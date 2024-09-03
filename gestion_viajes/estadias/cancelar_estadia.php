<?php
require_once('../../mysql/conexion.php');
session_start();
$id_usuario = $_SESSION['userID'];
$cn = conectar();
$fecha_hora = date("Y-m-d H:i:s");
$id_viaje = $_POST['id-viaje-cancelacion'];
$razon_cancelacion = $_POST['razones-no-cobro-estadia'];
$comentarios = $_POST['comentarios-cancelacion'];

$sql = "INSERT INTO cobro_estadias VALUES(NULL,$id_viaje,'cancelado',NULL,0,0,0,0,0,'$razon_cancelacion',$id_usuario,'$fecha_hora')";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
