<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

$cn = conectarPostgresql();

if (!$cn) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "No se pudo conectar a la base de datos"]);
  exit;
}


try {
  $query = "SELECT 
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) AS pending_count,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) AS completed_count,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled_count
          FROM public.maintenance_record";

  $stmt = $cn->prepare($query);
  $stmt->execute();
  $counts = $stmt->fetch(PDO::FETCH_ASSOC);

  $response = [
    "pending" => (int) $counts['pending_count'],
    "completed" => (int) $counts['completed_count'],
    "cancelled" => (int) $counts['cancelled_count']
  ];

  http_response_code(200);
  echo json_encode($response);

} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Error al ejecutar la consulta: " . $e->getMessage()]);
}

$cn = null;
