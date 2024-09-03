<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

$id_vehiculo = $_POST['id_vehiculo'];
$id_operador = $_POST['id_operador'];
$motivo = $_POST['motivo'];
$fechaHoraActual = date('Y-m-d H:i:s');
$id_usuario = $_SESSION['userID'];

$sql = "INSERT INTO posturas VALUES(NULL,$id_vehiculo,$id_operador,'$fechaHoraActual',$id_usuario,'$motivo')";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
