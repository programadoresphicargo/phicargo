<?php
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');

session_start();
$id_usuario = $_SESSION['userID'];

$cn = conectar();
$sqlSelect = "SELECT count(*) AS total FROM notificaciones 
LEFT JOIN control_notificaciones ON notificaciones.id = control_notificaciones.id_notificacion 
AND control_notificaciones.id_usuario = $id_usuario 
WHERE control_notificaciones.id IS NULL AND evento = 'estatus operador'";
$resultado = $cn->query($sqlSelect);
$fila = $resultado->fetch_assoc();
echo $conteo = $fila['total'];
