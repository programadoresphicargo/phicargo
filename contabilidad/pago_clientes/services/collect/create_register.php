<?php
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); 

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once '../../base_path.php';
require_once BASE_PATH . '/mysql/conexion.php';

session_start();
if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

$cn = conectar();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido."]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['client_id']) || !isset($data['week_id'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Faltan datos obligatorios (client_id, week_id)."]);
  exit;
}

$client_id = intval($data['client_id']);
$week_id = intval($data['week_id']);

$monday_amount = isset($data['monday_amount']) ? floatval($data['monday_amount']) : 0;
$tuesday_amount = isset($data['tuesday_amount']) ? floatval($data['tuesday_amount']) : 0;
$wednesday_amount = isset($data['wednesday_amount']) ? floatval($data['wednesday_amount']) : 0;
$thursday_amount = isset($data['thursday_amount']) ? floatval($data['thursday_amount']) : 0;
$friday_amount = isset($data['friday_amount']) ? floatval($data['friday_amount']) : 0;
$saturday_amount = isset($data['saturday_amount']) ? floatval($data['saturday_amount']) : 0;

$check_sql = "SELECT COUNT(*) as count FROM accounting_weekly_collect WHERE client_id = ? AND week_id = ?";
$check_stmt = $cn->prepare($check_sql);
if (!$check_stmt) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al preparar la consulta de verificación."]);
  $cn->close();
  exit;
}

$check_stmt->bind_param('ii', $client_id, $week_id);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Ya existe un registro con el mismo client_id y week_id."]);
  $cn->close();
  exit;
}

$sql = "INSERT INTO accounting_weekly_collect 
        (client_id, week_id, monday_amount, tuesday_amount, wednesday_amount, thursday_amount, friday_amount, saturday_amount) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $cn->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al preparar la consulta de inserción."]);
  $cn->close();
  exit;
}

$stmt->bind_param('iidddddd', $client_id, $week_id, $monday_amount, $tuesday_amount, $wednesday_amount, $thursday_amount, $friday_amount, $saturday_amount);

// Ejecutar la consulta
if ($stmt->execute()) {
  // Obtener el ID del registro insertado
  $inserted_id = $stmt->insert_id;

  // Obtener el nombre del cliente
  $client_name_sql = "SELECT nombre FROM clientes WHERE id = ?";
  $client_stmt = $cn->prepare($client_name_sql);
  $client_stmt->bind_param('i', $client_id);
  $client_stmt->execute();
  $client_stmt->bind_result($client_name);
  $client_stmt->fetch();
  $client_stmt->close();
  

  // Crear un arreglo con los datos del nuevo registro
  $new_record = [
    'id' => $inserted_id,
    'client_id' => $client_id,
    'client_name' => $client_name,
    'week_id' => $week_id,
    'monday_amount' => [
      'amount' => $monday_amount,
      'confirmed' => false,
      'real_amount' => 0,
    ],
    'tuesday_amount' => [
      'amount' => $tuesday_amount,
      'confirmed' => false,
      'real_amount' => 0,
    ],
    'wednesday_amount' => [
      'amount' => $wednesday_amount,
      'confirmed' => false,
      'real_amount' => 0,
    ],
    'thursday_amount' => [
      'amount' => $thursday_amount,
      'confirmed' => false,
      'real_amount' => 0,
    ],
    'friday_amount' => [
      'amount' => $friday_amount,
      'confirmed' => false,
      'real_amount' => 0,
    ],
    'saturday_amount' => [
      'amount' => $saturday_amount,
      'confirmed' => false,
      'real_amount' => 0,
    ],
    'observations' => '',
    'total_confirmed_amount' => 0,
  ];

  http_response_code(200);
  echo json_encode($new_record);
} else {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al insertar el registro."]);
}

$stmt->close();
$cn->close();
