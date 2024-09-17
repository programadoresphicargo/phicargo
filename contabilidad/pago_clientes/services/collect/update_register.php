<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json"); // Indicar que la respuesta es JSON

// Si es una solicitud OPTIONS, no procesar más
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204); // No Content
  exit;
}

require_once('../../base_path.php');

require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

// Leer los datos de la solicitud POST (asumiendo que vienen en formato JSON)
$data = json_decode(file_get_contents("php://input"), true);

// Verificar que el campo obligatorio 'id' esté presente
if (isset($data['id'])) {

  // ID del registro a actualizar
  $id = $cn->real_escape_string($data['id']);

  // Montos opcionales para cada día (se asigna 0 si no se proporciona)
  $monday_amount = isset($data['monday_amount']) ? $cn->real_escape_string($data['monday_amount']) : null;
  $tuesday_amount = isset($data['tuesday_amount']) ? $cn->real_escape_string($data['tuesday_amount']) : null;
  $wednesday_amount = isset($data['wednesday_amount']) ? $cn->real_escape_string($data['wednesday_amount']) : null;
  $thursday_amount = isset($data['thursday_amount']) ? $cn->real_escape_string($data['thursday_amount']) : null;
  $friday_amount = isset($data['friday_amount']) ? $cn->real_escape_string($data['friday_amount']) : null;
  $saturday_amount = isset($data['saturday_amount']) ? $cn->real_escape_string($data['saturday_amount']) : null;
  $observations = isset($data['observations']) ? $cn->real_escape_string($data['observations']) : null;
  $projection = isset($data['projection']) ? $cn->real_escape_string($data['projection']) : null;

  // Construir la consulta SQL dinámica
  $updateFields = [];
  if ($monday_amount !== null)
    $updateFields[] = "monday_amount = '$monday_amount'";
  if ($tuesday_amount !== null)
    $updateFields[] = "tuesday_amount = '$tuesday_amount'";
  if ($wednesday_amount !== null)
    $updateFields[] = "wednesday_amount = '$wednesday_amount'";
  if ($thursday_amount !== null)
    $updateFields[] = "thursday_amount = '$thursday_amount'";
  if ($friday_amount !== null)
    $updateFields[] = "friday_amount = '$friday_amount'";
  if ($saturday_amount !== null)
    $updateFields[] = "saturday_amount = '$saturday_amount'";
  if ($observations !== null)
    $updateFields[] = "observations = '$observations'";
  if ($projection !== null)
    $updateFields[] = "projection = '$projection'";

  if (empty($updateFields)) {
    echo json_encode([
      "success" => false,
      "message" => "No se proporcionaron datos para actualizar"
    ]);
    exit;
  }

  $updateSql = "UPDATE accounting_weekly_collect 
                  SET " . implode(', ', $updateFields) . "
                  WHERE id = '$id'";

  // Ejecutar la consulta
  if ($cn->query($updateSql) === TRUE) {
    // Respuesta exitosa
    if ($cn->affected_rows > 0) {
      echo json_encode([
        "success" => true,
        "message" => "Registro actualizado exitosamente"
      ]);
    } else {
      // Si no se actualizó ninguna fila, podría ser que el registro no exista
      echo json_encode([
        "success" => false,
        "message" => "No se encontró el registro para actualizar"
      ]);
    }
  } else {
    // Respuesta de error en caso de fallo en la consulta
    echo json_encode([
      "success" => false,
      "message" => "Error al actualizar el registro: " . $cn->error
    ]);
  }
} else {
  // Respuesta de error si falta el campo obligatorio 'id'
  echo json_encode([
    "success" => false,
    "message" => "Falta el dato obligatorio (id)"
  ]);
}

// Cierra la conexión a la base de datos
$cn->close();
