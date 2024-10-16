<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

require_once '../middlewares/auth_middleware.php';
require_once '../models/UnitModel.php';

$cn = conectarPostgresql();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $branchId = $_GET['branch_id'];

  $unitModel = new UnitModel($cn);

  try {
    $unitIndicators = $unitModel->getUnitIndicators($branchId);
    http_response_code(200);
    echo json_encode($unitIndicators[0]);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()]);
  }
}