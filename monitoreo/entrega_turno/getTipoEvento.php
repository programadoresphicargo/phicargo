<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT *  FROM tipos_eventos_monitoreo";

$resultado = mysqli_query($cn, $sql);
$eventos = array();

while ($row = mysqli_fetch_assoc($resultado)) {
    $eventos[] = $row;
}

echo json_encode($eventos);
