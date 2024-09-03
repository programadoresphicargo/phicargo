<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
session_start();

$HoraActual = date('Y-m-d H:i:s');

$id_alerta = $_POST['id_alerta'];
$id_usuario = $_SESSION['userID'];
$comentarios_monitorista = $_POST['comentarios_monitorista_alerta'];

$sqlUpdate = "UPDATE alertas set comentarios = '$comentarios_monitorista', 
usuario_atendio = $id_usuario, 
fecha_atendido = '$HoraActual', 
atendido = 1 where id_alerta = $id_alerta";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
