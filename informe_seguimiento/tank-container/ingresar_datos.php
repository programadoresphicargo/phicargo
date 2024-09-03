<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

session_start();
date_default_timezone_set('America/Mexico_City');

$fecha_actual = new DateTime();
$fecha_actual_formato = $fecha_actual->format('Y-m-d H:i:s');

$fecha = $_POST['fecha_tank'];
$tanques_lavados = $_POST['tanques_lavados'];
$tanques_rechazados = $_POST['tanques_rechazados'];
$tanques_patio = $_POST['tanques_patio'];
$id_usuario = $_SESSION['userID'];

if (!isset($_POST['id_tank']) || $_POST['id_tank'] == '') {
    $SQL = "SELECT * FROM tankcontainer where date(fecha) = '$fecha'";
    $resultado = $cn->query($SQL);
    if ($resultado->num_rows <= 0) {
        $sql = "INSERT INTO tankcontainer VALUES(NULL, $tanques_lavados, $tanques_rechazados, $tanques_patio,$id_usuario, '$fecha')";
        if ($cn->query($sql)) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
} else {
    $id_tank = $_POST['id_tank'];
    $SQL = "UPDATE tankcontainer SET tanques_lavados = $tanques_lavados, tanques_rechazados = $tanques_rechazados, tanques_patio = $tanques_patio where id = $id_tank";
    if ($cn->query($SQL)) {
        echo 1;
    } else {
        echo 0;
    }
}
