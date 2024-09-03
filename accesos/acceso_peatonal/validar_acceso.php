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
$sql = "UPDATE acceso_peatonal set estado_acceso = 'validado', usuario_valido = $id_usuario, fecha_validacion = '$fecha' where id_acceso = $id_acceso";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
