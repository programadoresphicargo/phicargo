<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');
$fechaHora = date('Y-m-d H:i:s');

$id_bono = $_POST['id_bono'];
$id_usuario = $_POST['id_usuario'];
$comentario = $_POST['comentario'];

$sqlInsert = "INSERT INTO comentarios VALUES(NULL,$id_bono,$id_usuario,'$comentario','$fechaHora')";
if ($cn->query($sqlInsert)) {
    echo 1;
} else {
    echo 0;
}
