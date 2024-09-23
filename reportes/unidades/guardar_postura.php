<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

header('Content-Type: application/json');
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if ($data === null) {
    echo json_encode(['error' => 'Datos no válidos']);
    exit;
}

$id_vehiculo = $data['id_vehiculo'];
$id_operador = $data['id_operador'];
$motivo = $data['motivo'];
$fechaHoraActual = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['userID'];

$sql = "INSERT INTO posturas VALUES(NULL,$id_vehiculo,$id_operador,'$fechaHoraActual',$id_usuario,'$motivo')";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
