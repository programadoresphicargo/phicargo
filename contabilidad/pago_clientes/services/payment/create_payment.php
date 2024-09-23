<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

require_once('../../base_path.php');

session_start();
if (MODE !== 'dev') {
  if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
  }
}

require_once(BASE_PATH . '/mysql/conexion.php');

$cn = conectar();

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['provider_id']) && 
    isset($data['week_id']) && 
    isset($data['provider']) && 
    isset($data['concept'])){

  $provider_id = $cn->real_escape_string($data['provider_id']);
  $provider = $cn->real_escape_string($data['provider']);
  $week_id = $cn->real_escape_string($data['week_id']);
  $concept = $cn->real_escape_string($data['concept']);

  $monday_amount = isset($data['monday_amount']) ? $cn->real_escape_string($data['monday_amount']) : 0;
  $tuesday_amount = isset($data['tuesday_amount']) ? $cn->real_escape_string($data['tuesday_amount']) : 0;
  $wednesday_amount = isset($data['wednesday_amount']) ? $cn->real_escape_string($data['wednesday_amount']) : 0;
  $thursday_amount = isset($data['thursday_amount']) ? $cn->real_escape_string($data['thursday_amount']) : 0;
  $friday_amount = isset($data['friday_amount']) ? $cn->real_escape_string($data['friday_amount']) : 0;
  $saturday_amount = isset($data['saturday_amount']) ? $cn->real_escape_string($data['saturday_amount']) : 0;

  $sql = "INSERT INTO accounting_weekly_payment
            (provider_id, 
            provider, 
            week_id, 
            monday_amount, 
            tuesday_amount, 
            wednesday_amount, 
            thursday_amount, 
            friday_amount, 
            saturday_amount,
            concept)
            VALUES (
            '$provider_id', 
            '$provider', 
            '$week_id', 
            '$monday_amount', 
            '$tuesday_amount', 
            '$wednesday_amount', 
            '$thursday_amount', 
            '$friday_amount', 
            '$saturday_amount',
            '$concept')";

  if ($cn->query($sql) === TRUE) {
    echo json_encode([
      "success" => true,
      "message" => "Registro insertado exitosamente"
    ]);
  } else {
    echo json_encode([
      "success" => false,
      "message" => "Error al insertar el registro: " . $cn->error
    ]);
  }
} else {
  echo json_encode([
    "success" => false,
    "message" => "Faltan datos obligatorios (provider_id, week_id o provider)"
  ]);
}

$cn->close();
