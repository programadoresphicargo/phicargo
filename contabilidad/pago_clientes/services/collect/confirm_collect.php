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
require_once './get_collect_register.php';

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

if (!isset($data['collect_id']) || !isset($data['day_of_week']) || !isset($data['confirmed']) || !isset($data['amount'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Faltan datos necesarios."]);
  $cn->close();
  exit;
}

$collect_id = intval($data['collect_id']);
$day_of_week = $data['day_of_week'];
$confirmed = filter_var($data['confirmed'], FILTER_VALIDATE_BOOLEAN);
$amount = floatval($data['amount']);

$valid_days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
if (!in_array($day_of_week, $valid_days)) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Día de la semana inválido."]);
  $cn->close();
  exit;
}

$sql = "INSERT INTO `accounting_collect_confirmations` (`collect_id`, `day_of_week`, `confirmed`, `amount`)
        VALUES (?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE `confirmed` = VALUES(`confirmed`)";

$stmt = $cn->prepare($sql);
if (!$stmt) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al preparar la consulta."]);
  $cn->close();
  exit;
}

$stmt->bind_param('issd', $collect_id, $day_of_week, $confirmed, $amount);

if ($stmt->execute()) {

  try {
    $updatedRecord = get_collect_register_by_id($cn, $collect_id);
    if ($updatedRecord) {
      http_response_code(200);
      echo json_encode($updatedRecord);
      exit;
    } else {
      http_response_code(500);
      echo json_encode(["success" => false, "message" => "Error al obtener el registro actualizado."]);
      exit;
    }
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al actualizar el registro: " . $e->getMessage()]);
    exit;
  }

} else {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al confirmar el pago."]);
}

$stmt->close();
$cn->close();
