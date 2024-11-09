<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../../venv.php';
require_once BASE_PATH . '/mysql/conexion.php';
require_once '../models/AccessModel.php';
require_once '../validator/required_fields_validator.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  return;
}

$cn = conectar();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}



if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

// Verifica si el JSON se ha decodificado correctamente
if (json_last_error() !== JSON_ERROR_NONE) {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "JSON inválido: " . json_last_error_msg()]);
  exit;
}

$fields_valid = validateRequiredFields($data);
if (!$fields_valid['success']) {
  http_response_code(400);
  echo json_encode($fields_valid);
  exit;
}

$accessModel = new AccessModel($cn);

try {
  $accessModel->insert_access($data);
  http_response_code(201);
  echo json_encode(["success" => true, "message" => "Registro insertado correctamente"]);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()]);
}
