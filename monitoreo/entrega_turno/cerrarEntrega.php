<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d H:i:s');

header("Content-Type: application/json");
$requestBody = file_get_contents("php://input");
$data = json_decode($requestBody, true);

$id_entrega = $data['id_entrega'];

$sqlInsert = "UPDATE entrega_turnos set estado = 'cerrado', cerrado = '$fecha' where id_entrega = $id_entrega";
if ($cn->query($sqlInsert)) {
    echo json_encode([
        "status" => 1,
        "message" => "Entrega cerrada correctamente.",
    ]);
} else {
    echo json_encode([
        "status" => 0,
        "message" => "Error",
    ]);
}
