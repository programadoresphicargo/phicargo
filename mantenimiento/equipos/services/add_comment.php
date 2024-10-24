<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

require_once '../venv.php'; // Incluye tu archivo de configuración

// Manejar las solicitudes OPTIONS (preflight request)
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);

  $required_fields = ['maintenance_record_id', 'comment_text'];
  foreach ($required_fields as $field) {
    if (!isset($data[$field])) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => "Campo faltante: $field"]);
      exit;
    }
  }

  // Consulta con RETURNING para obtener el comentario recién creado
  $query = "INSERT INTO public.maintenance_comments(
              maintenance_record_id, comment_text)
              VALUES (?, ?)
              RETURNING id, maintenance_record_id, comment_text, created_at;"; // Ajusta los campos según tu esquema

  $stmt = $cn->prepare($query);

  if (!$stmt) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta"]);
    exit;
  }

  $maintenance_record_id = $data['maintenance_record_id'];
  $comment_text = $data['comment_text'];

  $stmt->execute([$maintenance_record_id, $comment_text]);

  $newComment = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($newComment) {
    http_response_code(201);
    echo json_encode( $newComment);
  } else {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error al obtener el comentario recién creado"]);
  }
} else {
  http_response_code(405);
  echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
