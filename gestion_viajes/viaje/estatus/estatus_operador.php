<?php

require_once('../../../mysql/conexion.php');

$cn = conectar();
$id_reporte = $_POST['id_reporte'];
$sql = "SELECT * FROM reportes_estatus_viajes inner join status on status.id_status = reportes_estatus_viajes.id_estatus where id_reporte = $id_reporte";
$resultado = $cn->query($sql);
$datos = array();
while ($row = $resultado->fetch_assoc()) {
    $datos[] = $row;
}

$json = json_encode($datos);

echo $json;
