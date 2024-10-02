<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido."]);
  exit;
}

require_once '../../base_path.php';
require_once './get_payment.php';

session_start();
if (MODE !== 'dev' && !isset($_SESSION['userID'])) {
  http_response_code(401);
  echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
  exit;
}

require_once BASE_PATH . '/mysql/conexion.php';

$cn = conectar();
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['id'])) {
  echo json_encode(["success" => false, "message" => "Falta el dato obligatorio (id)"]);
  exit;
}

$id = $cn->real_escape_string($data['id']);

function buildUpdateFields($cn, $data)
{
  $fields = [];
  $optionalFields = [
    'monday_amount',
    'tuesday_amount',
    'wednesday_amount',
    'thursday_amount',
    'friday_amount',
    'saturday_amount',
    'observations',
    'concept',
    'projection'
  ];

  foreach ($optionalFields as $field) {
    if (isset($data[$field])) {
      $fields[] = "$field = '" . $cn->real_escape_string($data[$field]) . "'";
    }
  }

  return $fields;
}

$updateFields = buildUpdateFields($cn, $data);

if (empty($updateFields)) {
  echo json_encode(["success" => false, "message" => "No se proporcionaron datos para actualizar"]);
  exit;
}

$updateSql = "UPDATE accounting_weekly_payment SET " . implode(', ', $updateFields) . " WHERE id = '$id'";

if ($cn->query(query: $updateSql) === TRUE) {
  if ($cn->affected_rows > 0) {
    try {
      $updatedRecord = get_payment_by_id($cn, $id);
      if ($updatedRecord) {
        http_response_code(200);
        echo json_encode($updatedRecord);
        exit;
      } else {
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Error al obtener el registro actualizado."]);
        exit;
      }
    } catch (Exception $e) {
      http_response_code(500);
      echo json_encode(["success" => false, "message" => "Error al actualizar el registro: " . $e->getMessage()]);
      exit;
    }
  } else {
    http_response_code(404);
    echo json_encode(["success" => false, "message" => "No se encontró el registro para actualizar"]);
  }
} else {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al actualizar el registro: " . $cn->error]);
}

$cn->close();
