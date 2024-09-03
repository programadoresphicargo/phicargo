<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_reporte = $_POST['id_reporte'];
$sql = "SELECT *, reportes.id as id_reporte FROM reportes 
left join viajes on viajes.id = reportes.id_viaje 
left join operadores on operadores.id = viajes.employee_id 
left join unidades on unidades.placas = viajes.placas 
left join usuarios on usuarios.id_usuario = reportes.usuario_resolvio 
where reportes.id = $id_reporte";
$resultado = $cn->query($sql);
$row = $resultado->fetch_assoc();
echo json_encode($row);
