<?php
require_once('../../mysql/conexion.php');

session_start();

if (isset($_POST['id_usuario'])) {
    $id_usuario = $_POST['id_usuario'];
} else {
    $id_usuario = $_SESSION['userID'];
}

$datos = $_POST['datos'];
parse_str($datos, $datosF);
$fecha = date("Y-m-d H:i:s");

$id_acceso = $datosF['id_acceso'];

$cn = conectar();
$sql = "UPDATE acceso_vehicular set estado_acceso = 'salida', usuario_salida = $id_usuario, fecha_salida = '$fecha' where id_acceso = $id_acceso";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
