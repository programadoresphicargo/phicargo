<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT");
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

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = json_decode(file_get_contents("php://input"), true);


  if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Falta el parámetro: id"]);
    exit;
  }

  $id = $_GET['id']; // ID del registro a actualizar
  $fields = [];
  $values = [];

  // Definir los campos que pueden ser actualizados
  $updatable_fields = [
    'workshop_id', 
    'fail_type', 
    'check_in', 
    'check_out', 
    'status', 
    'delivery_date', 
    'supervisor', 
    'comments',
    'order',
  ];

  foreach ($updatable_fields as $field) {
    if (isset($data[$field])) {
      $fields[] = "$field = ?";
      $values[] = $data[$field];
    }
  }

  if (empty($fields)) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "No se proporcionaron campos para actualizar"]);
    exit;
  }

  // Construir la consulta de actualización
  $query = "UPDATE public.maintenance_record SET " . implode(", ", $fields) . " WHERE id = ?";
  $values[] = $id; // Agregar el ID al final de los valores

  $stmt = $cn->prepare($query);

  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta"]);
    exit;
  }

  // Ejecutar la consulta
  $result = $stmt->execute($values);

  if ($result) {
    http_response_code(200);
    echo json_encode(["success" => true, "message" => "Registro actualizado con éxito"]);
  } else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al actualizar el registro"]);
  }
} else {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
