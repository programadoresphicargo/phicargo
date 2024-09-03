<?php
require_once('../../mysql/conexion.php');
session_start();

$cn = conectar();

$id_cuenta = $_POST['id_cuenta'];
$id_empresa = $_POST['id_empresa'];
$id_banco = $_POST['id_banco'];
$tipo = $_POST['tipo'];
$moneda = $_POST['moneda'];
$referencia = $_POST['referencia'];
$id_usuario = $_SESSION['userID'];

$fecha = date("Y-m-d H:i:s");

$sqlUpdate = "UPDATE cuentas set id_empresa = $id_empresa, id_banco = $id_banco, tipo = '$tipo', moneda = '$moneda', referencia = '$referencia' where id_cuenta = $id_cuenta";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
