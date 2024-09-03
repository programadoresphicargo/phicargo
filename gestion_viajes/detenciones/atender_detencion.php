<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

$id_usuario = $_SESSION['userID'];
$fecha_atendido = date('Y-m-d H:i:s');

$id_detencion = $_POST['id_detencion'];
$motivo_detencion = $_POST['motivo_detencion'];
$comentarios_detencion = $_POST['comentarios_detencion'];
$tolerancia_concecida = $_POST['tolerancia_concecida'];

$sql = "UPDATE registro_detenciones set atendida = 1, 
motivo = '$motivo_detencion', 
comentarios = '$comentarios_detencion', 
tolerancia_concedida = '$tolerancia_concecida',
usuario_atendio = '$id_usuario', 
fecha_atendido = '$fecha_atendido' 
where id_detencion = $id_detencion";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
