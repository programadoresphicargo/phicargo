<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

$cn = conectarPostgresql();

if (!$cn) {
  echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
  exit;
}

try {
  $query = "SELECT id, code, name
            FROM public.res_store";

  $stmt = $cn->prepare($query);
  $stmt->execute();

  $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  echo json_encode($datos);

} catch (PDOException $e) {
  echo json_encode(["error" => "Error al ejecutar la consulta: " . $e->getMessage()]);
}

$cn = null;
