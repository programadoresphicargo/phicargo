<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');

$id = $_POST['id'];
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$color = $_POST['color'];

$sqlInsert = "UPDATE entrega_turnos set titulo = '$titulo', texto = '$contenido', color = '$color' where id = $id";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
