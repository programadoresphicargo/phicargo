<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../../venv.php';
require_once BASE_PATH . '/mysql/conexion.php';
require_once '../models/AccessModel.php';

$cn = conectar();
if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  // Verifica si el JSON se ha decodificado correctamente
  if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "JSON inválido: " . json_last_error_msg()]);
    exit;
  }

  $required_fields = [
    'nombre_operador',
    'placas',
    'tipo_transporte',
    'contenedor1',
    'contenedor2',
    'tipo_identificacion',
    'carga_descarga',
    'id_empresa',
    'sellos',
    'areas',
    'motivo',
    'usuario_creacion',
    'fecha_creacion',
    'fecha_entrada',
    'estado_acceso',
    'tipo_mov'
  ];

  // $validationResult = validateRequiredFields($data, $required_fields);
  // if (!$validationResult['success']) {
  //   http_response_code(400);
  //   echo json_encode($validationResult);
  //   exit;
  // }

  $accessModel = new AccessModel($cn);

  try {
    $new_record = $accessModel->insert($data);
    http_response_code(201);
    echo json_encode(["success" => true, "message" => "Registro insertado correctamente", "data" => $new_record]);
  } catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al insertar el registro: " . $e->getMessage()]);
  }
}
