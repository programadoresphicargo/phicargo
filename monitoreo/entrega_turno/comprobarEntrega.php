<?php
session_start();
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_usuario = $_SESSION['userID'];

$sqlSelect = "SELECT id_entrega, fecha_inicio FROM entrega_turnos WHERE id_usuario = $id_usuario AND estado = 'abierto'";
$resultado = $cn->query($sqlSelect);

if ($resultado->num_rows == 0) {
    echo json_encode(["status" => 1]);
} else {
    $row = $resultado->fetch_assoc();
    echo json_encode([
        "status" => 0,
        "message" => "Ya existe una entrega tuya abierta, primero ciérrala y después abre una nueva.",
        "id_entrega" => $row['id_entrega'],
        "fecha_inicio" => $row['fecha_inicio']
    ]);
}
