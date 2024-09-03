<?php
require_once('../../mysql/conexion.php');
session_start();
$id_usuario = $_SESSION['userID'];
$cn = conectar();
$fecha_hora = date("Y-m-d H:i:s");
$id_viaje = $_POST['id_viaje'];

$horas_sistema = $_POST['horas_sistema'];
$horas_cobro = $_POST['horas_cobro'];
$precio_hora = $_POST['precio_hora'];
$total_cobrar = $_POST['total_cobrar'];
$notas = $_POST['notas'];

$sql = "INSERT INTO cobro_estadias VALUES(NULL,$id_viaje,'borrador',NULL,$horas_cobro,$precio_hora,$total_cobrar,'$fecha_hora',0,NULL,NULL,NULL)";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
