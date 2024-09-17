<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once('../../base_path.php');
require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

// Verificar que el método de solicitud sea DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  // Obtener el parámetro collect_id desde la URL
  if (isset($_GET['collect_id'])) {
    $collect_id = $cn->real_escape_string($_GET['collect_id']);

    // Verificar si el registro existe antes de eliminar
    $checkSql = "SELECT id FROM accounting_weekly_collect WHERE id = '$collect_id'";
    $checkResult = $cn->query($checkSql);

    if ($checkResult->num_rows > 0) {
      // Realizar la eliminación
      $deleteSql = "DELETE FROM accounting_weekly_collect WHERE id = '$collect_id'";
      if ($cn->query($deleteSql) === TRUE) {
        // Respuesta exitosa con código 200
        http_response_code(200);
        echo json_encode([
          "success" => true,
          "message" => "Registro eliminado exitosamente"
        ]);
      } else {
        // Error al eliminar
        http_response_code(500);
        echo json_encode([
          "success" => false,
          "message" => "Error al eliminar el registro: " . $cn->error
        ]);
      }
    } else {
      // No se encontró el registro
      http_response_code(404);
      echo json_encode([
        "success" => false,
        "message" => "No se encontró el registro con el ID especificado"
      ]);
    }
  } else {
    // Faltan parámetros, responder con código 400
    http_response_code(400);
    echo json_encode([
      "success" => false,
      "message" => "Falta el parámetro collect_id"
    ]);
  }
} else {
  // Método no permitido, responder con código 405
  http_response_code(405);
  echo json_encode([
    "success" => false,
    "message" => "Método no permitido"
  ]);
}

// Cierra la conexión a la base de datos
$cn->close();
