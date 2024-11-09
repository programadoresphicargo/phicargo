<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

require_once '../services/record_fields_validator.php';
require_once '../models/ReportModel.php';

$cn = conectarPostgresql();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  return;
}

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
  exit;
}

if (!isset($_GET['branch_id'])) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "ID de sucursal del registro es requerido"]);
  exit;
}

$branch_id = intval($_GET['branch_id']);

$reportModel = new ReportModel($cn);

try {
  # Otenemos la fecha de hoy, para actualizar el registro del día actual
  $today = date('Y-m-d');

  $result = $reportModel->update_units($branch_id, $today);
  http_response_code(200);
  echo json_encode(["success" => true, "message" => "Datos actualizados correctamente"]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
