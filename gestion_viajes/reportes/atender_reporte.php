<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

$HoraActual = date('Y-m-d H:i:s');

$id_reporte = $_POST['id_rpo'];
$id_usuario = $_SESSION['userID'];
$comentarios_monitorista = $_POST['comentarios_monitorista_rpo'];

$sqlUpdate = "UPDATE reportes set comentarios_monitorista = '$comentarios_monitorista', 
usuario_resolvio = $id_usuario, 
fecha_resuelto = '$HoraActual', 
atendido = 1 where id = $id_reporte";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
