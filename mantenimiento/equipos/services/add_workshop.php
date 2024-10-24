<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php';

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

session_start();

if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

require_once BASE_PATH . '/postgresql/conexion.php';

$cn = conectarPostgresql();

if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  $required_fields = ['name'];
  foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Campo faltante: $field"]);
      exit;
    }
  }

  $query = "INSERT INTO public.maintenance_workshops(name) VALUES (?);";

  $stmt = $cn->prepare($query);

  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta"]);
    exit;
  }

  $name = $data['name'];

  $result = $stmt->execute([$name]);

  if ($result) {
    http_response_code(201);
    echo json_encode(["success" => true, "message" => "Comentario agregado con éxito"]);
  } else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al insertar el Comentario"]);
  }
} else {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
}

