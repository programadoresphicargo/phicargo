<?php
date_default_timezone_set('America/Mexico_City');
require_once('../../mysql/conexion.php');
$cn = conectar();

session_start();

$id_usuario = $_SESSION['userID'];
$id_viaje = $_POST['id_viaje'];

$sql = "SELECT * FROM viajes where id = $id_viaje";
$row = ($resultado = $cn->query($sql))->fetch_assoc();
$id_operador = $row['employee_id'];

$fecha_hora_actual = date("Y-m-d H:i:s");
$tipo_incidencia = $_POST['tipo_incidencia'];
$comentarios_incidencias = $_POST['comentarios_incidencias'];

$sql = "INSERT INTO incidencias VALUES(NULL,$id_operador,'$fecha_hora_actual',$id_usuario,'$tipo_incidencia','$comentarios_incidencias', $id_viaje)";
if ($cn->query($sql)) {
    echo 1;
} else {
    echo 0;
}
