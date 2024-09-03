<?php
require_once('../../mysql/conexion.php');
session_start();

$cn = conectar();

$id_empresa = $_POST['id_empresa'];
$id_banco = $_POST['id_banco'];
$tipo = $_POST['tipo'];
$moneda = $_POST['moneda'];
$referencia = $_POST['referencia'];
$id_usuario = $_SESSION['userID'];
$fecha = date("Y-m-d H:i:s");

$sqlSelect = "SELECT * FROM cuentas where referencia = '$referencia'";
$resultado = $cn->query($sqlSelect);

if ($resultado->num_rows <= 0) {
    $sqlInsert = "INSERT INTO cuentas VALUES(NULL,'$id_empresa',$id_banco,'$moneda','$referencia','$tipo','$fecha',$id_usuario)";
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 2;
}
