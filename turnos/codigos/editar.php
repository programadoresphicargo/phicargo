<?php

require_once "../../mysql/conexion.php";

$cn = conectar();
$id_turno = $_POST['id_turno'];
$id_operador = $_POST['id_operador'];
$placas = $_POST['placas'];
$fecha_llegada = $_POST['fecha_llegada'];
$hora_llegada = $_POST['hora_llegada'];
$comentarios = $_POST['comentarios'];
$maniobra1 = $_POST['maniobra1'];
$maniobra2 = $_POST['maniobra2'];

$sqlSelect = "UPDATE turnos SET id_operador = $id_operador, placas = '$placas', fecha_llegada = '$fecha_llegada', hora_llegada = '$hora_llegada', comentarios = '$comentarios', maniobra1 = '$maniobra1', maniobra2 = '$maniobra2' WHERE id_turno = $id_turno";

if ($cn->query($sqlSelect)) {
    echo 1;
} else {
    echo 0;
}
