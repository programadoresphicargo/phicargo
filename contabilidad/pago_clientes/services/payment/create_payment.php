<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../../base_path.php';

// Manejar solicitud preflight (OPTIONS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

session_start();
if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

require_once BASE_PATH . '/mysql/conexion.php';

$cn = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  $required_fields = ['provider_id', 'week_id', 'provider', 'concept'];
  foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Campo faltante: $field"]);
      exit;
    }
  }

  $provider_id = $cn->real_escape_string($data['provider_id']);
  $provider = $cn->real_escape_string($data['provider']);
  $week_id = $cn->real_escape_string($data['week_id']);
  $concept = $cn->real_escape_string($data['concept']);

  $monday_amount = isset($data['monday_amount']) ? $cn->real_escape_string($data['monday_amount']) : 0;
  $tuesday_amount = isset($data['tuesday_amount']) ? $cn->real_escape_string($data['tuesday_amount']) : 0;
  $wednesday_amount = isset($data['wednesday_amount']) ? $cn->real_escape_string($data['wednesday_amount']) : 0;
  $thursday_amount = isset($data['thursday_amount']) ? $cn->real_escape_string($data['thursday_amount']) : 0;
  $friday_amount = isset($data['friday_amount']) ? $cn->real_escape_string($data['friday_amount']) : 0;
  $saturday_amount = isset($data['saturday_amount']) ? $cn->real_escape_string($data['saturday_amount']) : 0;

  $check_sql = "SELECT COUNT(*) AS total FROM accounting_weekly_payment WHERE provider_id = ? AND week_id = ?";
  $check_stmt = $cn->prepare($check_sql);
  if (!$check_stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta de validación"]);
    exit;
  }

  $check_stmt->bind_param('ss', $provider_id, $week_id);
  $check_stmt->execute();
  $check_result = $check_stmt->get_result();
  $row = $check_result->fetch_assoc();

  if ($row['total'] > 0) {
    http_response_code(409);
    echo json_encode(["success" => false, "message" => "Ya existe un registro para este proveedor y semana"]);
    exit;
  }

  // Insertar el nuevo registro
  $sql = "INSERT INTO accounting_weekly_payment
            (provider_id, 
            provider, 
            week_id, 
            monday_amount, 
            tuesday_amount, 
            wednesday_amount, 
            thursday_amount, 
            friday_amount, 
            saturday_amount,
            concept)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $cn->prepare($sql);
  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta"]);
    exit;
  }

  $result = $stmt->execute([
    $provider_id,
    $provider,
    $week_id,
    $monday_amount,
    $tuesday_amount,
    $wednesday_amount,
    $thursday_amount,
    $friday_amount,
    $saturday_amount,
    $concept
  ]);
  if ($result) {
    http_response_code(201);
    echo json_encode(["success" => true, "message" => "Registro creado con éxito"]);
  } else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al insertar el registro"]);
  }

} else {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
}

$cn->close();