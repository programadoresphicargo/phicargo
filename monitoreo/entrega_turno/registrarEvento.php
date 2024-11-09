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
$id_entrega = $data['id_entrega'];
$titulo = $data['titulo'];
$descripcion = $data['descripcion'];
$sucursal = $data['sucursal'];
$tipo_evento = $data['tipo_evento'];

$sqlInsert = "INSERT INTO eventos_monitoreo VALUES(NULL,$id_entrega,'$titulo','$sucursal',$tipo_evento,'$descripcion',$id_usuario,'$fechaHora',null,null,null)";
$response = [];

if ($cn->query($sqlInsert)) {
    $response['status'] = 'success';
    $response['message'] = 'Evento registrado correctamente';
} else {
    $response['status'] = 'error';
    $response['message'] = 'Error al registrar el evento';
}

echo json_encode($response);
