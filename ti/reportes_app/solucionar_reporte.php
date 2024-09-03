<?php
require_once('../../mysql/conexion.php');
require_once('../../notificaciones/notificaciones.php');

$cn = conectar();

session_start();
$id_usuario = $_SESSION['userID'];
$id_operador = $_POST['id_operador'];
$id_reporte = $_POST['id_reporte'];
$comentario_resuelto = $_POST['comentario'];
$fechaYHora = date("Y-m-d H:i:s");

$sql = "UPDATE reportes_app set estado = 'resuelto', usuario_resolvio = $id_usuario, fecha_resuelto = '$fechaYHora', comentarios_resuelto = '$comentario_resuelto' where id_reporte = $id_reporte";
if ($cn->query($sql)) {
    enviar_notificacion('Tu problema ha sido atendido', $comentario_resuelto, $id_operador);
    echo 1;
} else {
    echo 0;
}
