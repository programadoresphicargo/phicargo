<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

require_once '../middlewares/auth_middleware.php';
require_once '../services/record_fields_validator.php';
require_once '../models/ReportModel.php';

$cn = conectarPostgresql();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

  if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID del registro es requerido"]);
    exit;
  }

  $id = intval($_GET['id']);

  $data = json_decode(file_get_contents("php://input"), true);

  $allowed_fields = ['simple_load', 'full_load', 'unloading_units', 'long_trip_units', 'observations'];
  $update_data = array_intersect_key($data, array_flip($allowed_fields));

  if (empty($update_data)) {
    http_response_code(400); // Bad Request
    echo json_encode(["success" => false, "message" => "No hay campos válidos para actualizar"]);
    exit;
  }

  $reportModel = new ReportModel($cn);

  try {
    $updated_record = $reportModel->updateRecord($id, $update_data);

    http_response_code(200);
    echo json_encode( $updated_record);
  } catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["success" => false, "message" => "Error al actualizar el registro: " . $e->getMessage()]);
  }
}
