<?php
require_once('../../mysql/conexion.php');

session_start();
$id_usuario = $_SESSION['userID'];

date_default_timezone_set('America/Mexico_City');
$fechaHoraMexico = date('Y-m-d H:i:s');

$cn = conectar();
$nombre = $_POST['nombre'];
$id_empresa = $_POST['id_empresa_2'];

$sqlSelect = "SELECT * FROM visitantes where nombre_visitante = '$nombre'";
$resultado = $cn->query($sqlSelect);
if ($resultado->num_rows <= 0) {
    $sql = "INSERT INTO visitantes VALUES(NULL,$id_empresa,'$nombre', $id_usuario,'$fechaHoraMexico','activo')";
    if ($cn->query($sql)) {
        echo 1;
    } else {
        echo 0;
    }
} else {
    echo 2;
}
