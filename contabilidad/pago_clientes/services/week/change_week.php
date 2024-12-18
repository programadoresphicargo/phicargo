<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405); // Método no permitido
  echo json_encode([
    "success" => false,
    "message" => "Método no permitido. Solo se permite POST."
  ]);
  exit;
}

require_once '../../base_path.php';
require_once './utils/get_week_id.php';
require_once './utils/create_week.php';
require_once BASE_PATH . '/mysql/conexion.php';

$cn = conectar();

if ($cn->connect_error) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error de conexión a la base de datos"
  ]);
  exit;
}

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['start_date']) || !isset($data['end_date'])) {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "Faltan datos obligatorios (start_date o end_date)"
  ]);
  exit;
}

$start_date = $data['start_date'];
$end_date = $data['end_date'];

try {
  $week_id = get_week_id($cn, $start_date, $end_date);

  if ($week_id) {
    http_response_code(200);
    echo json_encode([
      "success" => true,
      "message" => "La semana ya existe",
      "week_id" => $week_id
    ]);
  } else {
    $week_id = create_week($cn, $start_date, $end_date);

    if ($week_id) {
      http_response_code(201);
      echo json_encode([
        "success" => true,
        "message" => "Semana creada exitosamente",
        "week_id" => $week_id
      ]);
    } else {
      http_response_code(500);
      echo json_encode([
        "success" => false,
        "message" => "No se pudo crear la semana"
      ]);
    }
  }

} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    "success" => false,
    "message" => "Error interno del servidor: " . $e->getMessage()
  ]);
} finally {
  $cn->close();
}
