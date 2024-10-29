<?php
require_once('../../mysql/conexion.php');
$data = json_decode(file_get_contents("php://input"), true);

$cn = conectar();
$Date = date('Y-m-d');

$id_usuario = $data['id_usuario'];
$sqlSelect = "SELECT * FROM usuarios where id_usuario = $id_usuario";
$resultSet = $cn->query($sqlSelect);

$usuarios = [];

while ($row = $resultSet->fetch_assoc()) {
    $usuarios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($usuarios);
