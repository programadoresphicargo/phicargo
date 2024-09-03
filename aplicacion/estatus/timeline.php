<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$id_operador = $_POST['id_operador'];

$sql = "SELECT * FROM reportes_estatus_viajes inner join ubicaciones_estatus on ubicaciones_estatus.id_ubicacion = reportes_estatus_viajes.id_ubicacion inner join status on status.id_status = reportes_estatus_viajes.id_estatus where id_viaje = $id_viaje and id_usuario = $id_operador order by fecha_envio desc";
$result = $cn->query($sql);

$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
