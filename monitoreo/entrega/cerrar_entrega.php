<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d H:i:s');

$id = $_POST['id'];

$sqlInsert = "UPDATE entrega_turnos set estado = 'cerrado', cerrado = '$fecha' where id = $id";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
