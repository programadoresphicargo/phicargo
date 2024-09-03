<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');

$id_usuario = $_POST['id_usuario'];
$titulo = $_POST['titulo'];
$contenido = $_POST['contenido'];
$color = $_POST['color'];

$sqlInsert = "INSERT INTO entrega_turnos VALUES(NULL,'$titulo','$contenido','$fechaHora','$fechaHora','$color',$id_usuario,'abierto','$fechaHora',NULL)";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
