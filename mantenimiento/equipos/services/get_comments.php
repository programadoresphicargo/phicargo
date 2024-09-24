<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

$cn = conectar_pg();

if (!$cn) {
  echo json_encode(["error" => "No se pudo conectar a la base de datos"]);
  exit;
}

try {
  // Verifica si se pasó el parámetro 'register_id'
  if (!isset($_GET['register_id'])) {
    http_response_code(400);
    echo json_encode(["error" => "Falta el parámetro register_id"]);
    exit;
  }

  // Obtiene el valor del parámetro
  $register_id = $_GET['register_id'];

  // Construye la consulta
  $query = "SELECT
              id, 
              maintenance_record_id,
              comment_text,
              created_at
            FROM public.maintenance_comments
            WHERE maintenance_record_id = :register_id";

  $stmt = $cn->prepare($query);

  // Bind de parámetros
  $stmt->bindParam(':register_id', $register_id, PDO::PARAM_INT);

  // Ejecuta la consulta
  $stmt->execute();
  $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Respuesta exitosa
  http_response_code(200);
  echo json_encode($datos);

} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(["error" => "Error al ejecutar la consulta: " . $e->getMessage()]);
}

$cn = null;
