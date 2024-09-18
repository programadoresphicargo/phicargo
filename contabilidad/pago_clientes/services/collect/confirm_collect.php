<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
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

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['collect_id']) || !isset($data['day_of_week']) || !isset($data['confirmed'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Faltan datos necesarios."]);
  $cn->close();
  exit;
}

$collect_id = intval($data['collect_id']);
$day_of_week = $data['day_of_week'];
$confirmed = filter_var($data['confirmed'], FILTER_VALIDATE_BOOLEAN);

$valid_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
if (!in_array($day_of_week, $valid_days)) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Día de la semana inválido."]);
  $cn->close();
  exit;
}

$sql = "INSERT INTO `accounting_collect_confirmations` (`collect_id`, `day_of_week`, `confirmed`)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE `confirmed` = VALUES(`confirmed`)";

$stmt = $cn->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al preparar la consulta."]);
  $cn->close();
  exit;
}

// Cambia 'i' por 's' para el parámetro $day_of_week que es un string
$stmt->bind_param('iss', $collect_id, $day_of_week, $confirmed);

if ($stmt->execute()) {
  http_response_code(200);
  echo json_encode(["success" => true, "message" => "Pago confirmado exitosamente."]);
} else {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al confirmar el pago."]);
}

$stmt->close();
$cn->close();
