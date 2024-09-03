<?php
require_once('../../mysql/conexion.php');
session_start();

$cn = conectar();

$id_cuenta = $_POST['id_cuenta_ingresar'];
$fecha = $_POST['fecha_saldo'];
$nuevo_saldo = $_POST['nuevo_saldo'];
$disponible = $_POST['disponible'];
$id_usuario = $_SESSION['userID'];

$sqlSelect = "SELECT * FROM saldos where fecha = '$fecha' and id_cuenta = $id_cuenta";
$resultado = $cn->query($sqlSelect);

if ($resultado->num_rows <= 0) {
    $sqlInsert = "INSERT INTO saldos VALUES(NULL, $id_cuenta, '$fecha', $nuevo_saldo, $id_usuario,$disponible,0)";
    if ($cn->query($sqlInsert)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    $row = $resultado->fetch_assoc();
    $id_saldo = $row['id_saldo'];
    $sqlUpdate = "UPDATE saldos SET saldo = $nuevo_saldo, disponible = $disponible where id_saldo = $id_saldo";
    if ($cn->query($sqlUpdate)) {
        echo 1;
    } else {
        echo 0;
    }
}
