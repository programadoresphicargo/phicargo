<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$remolque1 = $_POST['remolque1_edit'];
$remolque2 = $_POST['remolque2_edit'];
$dolly = $_POST['dolly_edit'];
$contenedor1 = $_POST['contenedor1_edit'];
$contenedor2 = $_POST['contenedor2_edit'];

$sqlUpdate = "UPDATE viajes 
set 
remolque1 = $remolque1, 
remolque2 = $remolque2,
dolly = $dolly,
x_reference = '$contenedor1',
x_reference_2 = '$contenedor2'
where id = $id_viaje";
if ($cn->query($sqlUpdate)) {
    echo 1;
} else {
    echo 0;
}
