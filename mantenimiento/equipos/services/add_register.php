<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php'; // Incluye tu archivo de configuración

// Manejar las solicitudes OPTIONS (preflight request)
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

require_once BASE_PATH . '/postgresql/conexion.php';

$cn = conectarPostgresql();

if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  $required_fields = ['workshop_id', 'fail_type', 'check_in', 'status', 'order_service', 'supervisor', 'tract_id', 'comments'];
  foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Campo faltante: $field"]);
      exit;
    }
  }

  // Validar que no exista un registro pendiente con el mismo tract_id
  $tract_id = $data['tract_id'];
  $checkPendingQuery = "SELECT COUNT(*) FROM public.maintenance_record WHERE tract_id = ? AND status = 'pending'";
  $checkStmt = $cn->prepare($checkPendingQuery);
  $checkStmt->execute([$tract_id]);
  $pendingCount = $checkStmt->fetchColumn();

  if ($pendingCount > 0) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Ya existe un registro pendiente con el tract_id $tract_id"]);
    exit;
  }

  $query = "INSERT INTO public.maintenance_record(
    workshop_id, fail_type, check_in, status, delivery_date, supervisor, tract_id, comments, order_service
  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

  $stmt = $cn->prepare($query);

  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta"]);
    exit;
  }

  $workshop_id = $data['workshop_id'];
  $fail_type = $data['fail_type'];
  $check_in = $data['check_in'];
  $status = $data['status'];
  $delivery_date = $data['delivery_date'] ?? null;
  $supervisor = $data['supervisor'];
  $tract_id = $data['tract_id'];
  $comments = $data['comments'];
  $order_service = $data['order_service'];

  $result = $stmt->execute([$workshop_id, $fail_type, $check_in, $status, $delivery_date, $supervisor, $tract_id, $comments, $order_service]);

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

