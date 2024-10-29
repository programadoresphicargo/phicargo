<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

require_once '../middlewares/auth_middleware.php';
require_once '../models/ReportModel.php';
require_once '../services/mounth_date_validator.php';

$cn = conectarPostgresql();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  if (empty($_GET['start_date']) || empty($_GET['end_date'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Falta el rango de fechas"]);
    exit;
  }
  $start_date = $_GET['start_date'];
  $end_date = $_GET['end_date'];

  if (mounthDateValidator($start_date, $end_date)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "El rango de fechas debe ser dentro del mismo mes"]);
    exit;
  }

  $reportModel = new ReportModel($cn);

  try {
    $records = $reportModel->getOrCreateRecordsByMonth($start_date, $end_date);
    http_response_code(200);
    echo json_encode($records);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()]);
  }
}
