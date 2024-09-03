<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$idcorreo = $_POST['idcorreoup'];
$nombre = $_POST['nombreup'];
$cliente = $_POST['clienteup'];
$correo = $_POST['correoup'];
$tipo = $_POST['tipoup'];

$sqlUpdate = "UPDATE correos_electronicos set nombre_completo = '$nombre', id_cliente = $cliente, correo = '$correo', tipo = '$tipo' where id_correo = $idcorreo";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
