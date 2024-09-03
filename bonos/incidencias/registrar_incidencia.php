<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();
$id_usuario = $_SESSION['userID'];
$id_bono = $_POST['id_bono_incidencia'];
$motivo = $_POST['comentarios_incidencias'];
$fecha_creacion = date("Y-m-d H:i:s");

$sql = "INSERT INTO registro_incidencias VALUES(NULL,$id_bono,$id_usuario,'$fecha_creacion','$motivo')";
if ($cn->query($sql)) {
    $sqlUpdate = "UPDATE bonos set
    excelencia = 0,
    productividad = 0,
    operacion = 0,
    seguridad_vial = 0,
    cuidado_unidad = 0,
    rendimiento = 0
    where id_bono = $id_bono";
    echo 1;
    $cn->query($sqlUpdate);
} else {
    echo 0;
}
