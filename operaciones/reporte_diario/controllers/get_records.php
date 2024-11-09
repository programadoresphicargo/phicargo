<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
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

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  return;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
  exit;
}

if (empty($_GET['start_date']) || empty($_GET['end_date']) || empty($_GET['branch_id'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Falta el rango de fechas o el ID de la sucursal"]);
  exit;
}

$branch_id = intval($_GET['branch_id']);
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

if (mounthDateValidator($start_date, $end_date)) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "El rango de fechas debe ser dentro del mismo mes"]);
  exit;
}

$reportModel = new ReportModel($cn);

try {
  $records = $reportModel->get_or_create_records_by_month(
    $branch_id,
    $start_date,
    $end_date
  );
  http_response_code(200);
  echo json_encode($records);
} catch (Exception $e) {
  $errorMessage = $e->getMessage();

  if (preg_match("/ERROR:\s*(.+?)\n/", $errorMessage, $matches)) {
    $customMessage = trim($matches[1]);
  } else {
    $customMessage = "Error inesperado.";
  }

  http_response_code(500);
  echo json_encode(["success" => false, "message" => $customMessage]);
}
