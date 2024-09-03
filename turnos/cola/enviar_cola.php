<?php
require_once('funcion_enviar_cola.php');

$id_turno = $_POST['id_turno'];
$sucursal = $_POST['sucursal'];
$fecha_hora_salida = $_POST['fecha_hora_salida'];

enviar_cola($id_turno, $sucursal, $fecha_hora_salida);
