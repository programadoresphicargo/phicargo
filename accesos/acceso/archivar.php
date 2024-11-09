<?php
require_once('../../mysql/conexion.php');

session_start();
if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
} else {
    $id_usuario = $_SESSION['userID'];
}

$fecha = date("Y-m-d H:i:s");
$id_acceso = $_GET['id_acceso'];

$cn = conectar();
$sql = "UPDATE accesos set estado_acceso = 'archivado', usuario_archivo = $id_usuario, fecha_archivado = '$fecha' where id_acceso = $id_acceso";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
