<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); // Indicar que la respuesta es JSON

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204); 
  exit;
}

require_once('../../base_path.php');
session_start();

if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido."]);
  exit;
}

require_once BASE_PATH . '/mysql/conexion.php';
$cn = conectar();

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Falta el dato obligatorio (id)."]);
  exit;
}

$id = intval($data['id']);

$fields = [];
$params = [];
$types = "";

if (isset($data['monday_amount'])) {
  $fields[] = "monday_amount = ?";
  $params[] = floatval($data['monday_amount']);
  $types .= "d";
}
if (isset($data['tuesday_amount'])) {
  $fields[] = "tuesday_amount = ?";
  $params[] = floatval($data['tuesday_amount']);
  $types .= "d";
}
if (isset($data['wednesday_amount'])) {
  $fields[] = "wednesday_amount = ?";
  $params[] = floatval($data['wednesday_amount']);
  $types .= "d";
}
if (isset($data['thursday_amount'])) {
  $fields[] = "thursday_amount = ?";
  $params[] = floatval($data['thursday_amount']);
  $types .= "d";
}
if (isset($data['friday_amount'])) {
  $fields[] = "friday_amount = ?";
  $params[] = floatval($data['friday_amount']);
  $types .= "d";
}
if (isset($data['saturday_amount'])) {
  $fields[] = "saturday_amount = ?";
  $params[] = floatval($data['saturday_amount']);
  $types .= "d";
}
if (isset($data['observations'])) {
  $fields[] = "observations = ?";
  $params[] = $data['observations'];
  $types .= "s";
}

if (empty($fields)) {
  echo json_encode([
    "success" => false,
    "message" => "No se proporcionaron datos para actualizar."
  ]);
  exit;
}

$sql = "UPDATE accounting_weekly_collect SET " . implode(', ', $fields) . " WHERE id = ?";

$params[] = $id;
$types .= "i";

$stmt = $cn->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al preparar la consulta de actualización."]);
  exit;
}

$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
  if ($stmt->affected_rows > 0) {
    echo json_encode(["success" => true, "message" => "Registro actualizado exitosamente."]);
  } else {
    echo json_encode(["success" => false, "message" => "No se encontró el registro para actualizar o no hubo cambios."]);
  }
} else {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al ejecutar la actualización: " . $stmt->error]);
}

// Cerrar la conexión
$stmt->close();
$cn->close();
