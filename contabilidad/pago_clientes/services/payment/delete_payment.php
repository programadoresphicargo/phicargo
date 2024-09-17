<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
session_start();

require_once('../../base_path.php');
require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  if (isset($_GET['payment_id'])) {
    $payment_id = $cn->real_escape_string($_GET['payment_id']);

    $checkSql = "SELECT id FROM accounting_weekly_payment WHERE id = '$payment_id'";
    $checkResult = $cn->query($checkSql);

    if ($checkResult->num_rows > 0) {
      $deleteSql = "DELETE FROM accounting_weekly_payment WHERE id = '$payment_id'";
      if ($cn->query($deleteSql) === TRUE) {
        http_response_code(200);
        echo json_encode([
          "success" => true,
          "message" => "Pago eliminado exitosamente"
        ]);
      } else {
        http_response_code(500);
        echo json_encode([
          "success" => false,
          "message" => "Error al eliminar el pago: " . $cn->error
        ]);
      }
    } else {
      http_response_code(404);
      echo json_encode([
        "success" => false,
        "message" => "No se encontró el pago con el ID especificado"
      ]);
    }
  } else {
    http_response_code(400);
    echo json_encode([
      "success" => false,
      "message" => "Falta el parámetro payment_id"
    ]);
  }
} else {
  http_response_code(405);
  echo json_encode([
    "success" => false,
    "message" => "Método no permitido"
  ]);
}

$cn->close();
