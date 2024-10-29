<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../../base_path.php';

session_start();

if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

require_once BASE_PATH . '/mysql/conexion.php';
require_once './utils/get_week_id.php';

$cn = conectar();

// Obtener el parámetro week_id desde la URL
if (!isset($_GET['start_date']) || !isset($_GET['end_date'])) {
  // Faltan parámetros, responder con código 400
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "Falta el parámetro week_id"
  ]);
  exit;
}

try {
  $week_id = get_week_id($cn, $_GET['start_date'], $_GET['end_date']);

  if (!$week_id) {
    http_response_code(404);
    echo json_encode([
      "success" => false,
      "message" => "No se encontró la semana"
    ]);
    exit;
  }

  echo json_encode([
    "success" => true,
    "week_id" => $week_id
  ]);

} catch(Exception $e) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error interno del servidor: " . $e->getMessage()
  ]);
} finally {
  $cn->close();
}
