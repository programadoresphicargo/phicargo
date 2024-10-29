<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

header("Content-Type: application/json");
$requestBody = file_get_contents("php://input");
$data = json_decode($requestBody, true);

date_default_timezone_set('America/Mexico_City');

$fechaHora = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['userID'];

$id_evento = $data['id_evento'];
$titulo = $data['titulo'];
$descripcion = $data['descripcion'];
$sucursal = $data['sucursal'];
$id_tipo_evento = $data['id_tipo_evento'];

$sqlInsert = "UPDATE eventos_monitoreo SET titulo = '$titulo', descripcion = '$descripcion', sucursal = '$sucursal', tipo_evento = $id_tipo_evento where id_evento = $id_evento";
$response = [];

if ($cn->query($sqlInsert)) {
    $response['status'] = 'success';
    $response['message'] = 'Evento registrado correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al registrar el evento';
}

echo json_encode($response);
