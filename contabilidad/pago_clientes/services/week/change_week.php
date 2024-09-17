<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

require_once('../../base_path.php');

require_once(BASE_PATH . '/mysql/conexion.php');

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

if (isset($data['start_date']) && isset($data['end_date']) && validateDate($data['start_date']) && validateDate($data['end_date'])) {

  $start_date = $cn->real_escape_string($data['start_date']);
  $end_date = $cn->real_escape_string($data['end_date']);

  $checkSql = $cn->prepare("SELECT id FROM accounting_weeks WHERE start_date = ? AND end_date = ?");
  if ($checkSql) {
    $checkSql->bind_param("ss", $start_date, $end_date);
    $checkSql->execute();
    $result = $checkSql->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      http_response_code(200);
      echo json_encode([
        "success" => true,
        "message" => "La semana ya existe",
        "week_id" => (int) $row['id']
      ]);
    } else {
      $insertSql = $cn->prepare("INSERT INTO accounting_weeks (start_date, end_date) VALUES (?, ?)");
      if ($insertSql) {
        $insertSql->bind_param("ss", $start_date, $end_date);

        if ($insertSql->execute()) {
          http_response_code(201);
          echo json_encode([
            "success" => true,
            "message" => "Registro de semana insertado exitosamente",
            "week_id" => (int) $cn->insert_id
          ]);
        } else {
          http_response_code(500);
          echo json_encode([
            "success" => false,
            "message" => "Error al insertar el registro: " . $cn->error
          ]);
        }
        $insertSql->close();
      } else {
        http_response_code(500);
        echo json_encode([
          "success" => false,
          "message" => "Error al preparar la consulta de inserción: " . $cn->error
        ]);
      }
    }
    $checkSql->close();
  } else {
    http_response_code(500);
    echo json_encode([
      "success" => false,
      "message" => "Error al preparar la consulta de verificación: " . $cn->error
    ]);
  }
} else {
  http_response_code(400);
  echo json_encode([
    "success" => false,
    "message" => "Faltan datos obligatorios o los datos son inválidos (start_date o end_date)"
  ]);
}

$cn->close();

/**
 * Función para validar el formato de la fecha
 */
function validateDate($date, $format = 'Y-m-d')
{
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) === $date;
}
