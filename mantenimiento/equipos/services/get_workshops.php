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
  $query = "SELECT id, name
            FROM public.maintenance_workshops
            WHERE is_active = true;";

  $stmt = $cn->prepare($query);
  $stmt->execute();

  $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  http_response_code(200);
  echo json_encode($datos);

} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["success" => false, "message" => "Error al ejecutar la consulta" . $e->getMessage()]);
}

$cn = null;
