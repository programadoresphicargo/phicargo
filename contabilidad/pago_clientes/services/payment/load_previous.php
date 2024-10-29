<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode([
    "success" => false,
    "message" => "Método no permitido. Solo se permite POST."
  ]);
  exit;
}

require_once '../../base_path.php';
require_once BASE_PATH . '/mysql/conexion.php';

$cn = conectar();

if ($cn->connect_error) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error de conexión a la base de datos"
  ]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['previous_week_id']) || !isset($data['new_week_id'])) {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "Faltan datos obligatorios (previous_week_id o new_week_id)"
  ]);
  exit;
}

$previous_week_id = $data['previous_week_id'];
$new_week_id = $data['new_week_id'];

try {
  $sql = "SELECT insert_pending_payments($previous_week_id, $new_week_id) AS affected_rows";
  http_response_code(200);
  echo json_encode([
    "success" => true,
    "message" => "Pagos pendientes cargados correctamente",
    "affected_rows" => $cn->query($sql)->fetch_object()->affected_rows
  ]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error interno del servidor: " . $e->getMessage()
  ]);
} finally {
  $cn->close();
}
