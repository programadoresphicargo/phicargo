<?php
require_once '../venv.php';
require_once BASE_PATH . '/postgresql/conexion.php';

session_start();

if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}