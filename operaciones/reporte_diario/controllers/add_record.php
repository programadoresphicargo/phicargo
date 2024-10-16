<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $required_fields = [
    'date', 
    'simple_load', 
    'full_load', 
    'meta', 
    'difference', 
    'accumulated_difference', 
    'available_units', 
    'unloading_units', 
    'long_trip_units', 
    'units_in_maintenance', 
    'units_no_operator', 
    'total_units', 
    'observations'
  ];

  $validationResult = validateRequiredFields($data, $required_fields);
  if (!$validationResult['success']) {
    http_response_code(400);
    echo json_encode($validationResult);
    exit;
  }

  $reportModel = new ReportModel($cn);

  try {
    $new_record = $reportModel->insertRecord($data);
    http_response_code(201);
    echo json_encode($new_record);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()]);
  }
}
