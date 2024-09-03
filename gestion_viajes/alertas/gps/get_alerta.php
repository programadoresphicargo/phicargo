<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();

$id_alerta = $_POST['id_alerta'];
$sql = "SELECT * FROM alertas
inner join viajes on viajes.id = alertas.id_viaje
inner join operadores on operadores.id = viajes.employee_id
inner join unidades on unidades.placas = viajes.placas
left join usuarios on usuarios.id_usuario = alertas.usuario_atendio
where id_alerta = $id_alerta";
$resultado = $cn->query($sql);
$row = $resultado->fetch_assoc();
echo json_encode($row);
