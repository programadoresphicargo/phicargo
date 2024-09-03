<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

session_start();
$id_reporte = $_POST['id_reporte'];

$sql = "SELECT * FROM reportes_app where id_reporte = $id_reporte and estado = 'resuelto'";
$resultado = $cn->query($sql);
if ($resultado) {
    if ($resultado->num_rows > 0) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 0;
}
