<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();
$fecha = date("Y-m-d H:i:s");
$id_usuario = $_SESSION['userID'];
$comentario = $_POST['comentario'];
$fecha_informe = $_POST['fecha_informe'];

$sql = "INSERT INTO informe_comentarios VALUES(NULL,'$comentario',$id_usuario,'$fecha','$fecha_informe')";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
