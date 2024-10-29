<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header(header: "Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

require_once '../middlewares/auth_middleware.php';
require_once '../services/record_fields_validator.php';
require_once '../models/ReportModel.php';
require_once '../models/UnitModel.php';

$cn = conectarPostgresql();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
}

if (empty($_GET['branch_id']) || empty($_GET['date'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Falta el id de la sucursal"]);
  exit;
}

$branchId = $_GET['branch_id'];
$date = $_GET['date'];

$unitModel = new UnitModel($cn);
$reportModel = new ReportModel($cn);

try {
  $unitIndicators = $unitModel->getUnitIndicators($branchId);
  http_response_code(200);
  echo json_encode($unitIndicators[0]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()]);
}

