<?php

require_once "../../mysql/conexion.php";
require_once "../algoritmos/obtener_turnos.php";
$cn = conectar();

session_start();
$id_usuario = $_SESSION['userID'];
date_default_timezone_set("America/Mexico_City");
$horaActual = date("Y-m-d H:i:s");

$id_turno = $_POST['id_turno'];
$motivo_archivado = $_POST['opcion'];
$sucursal = $_POST['sucursal'];

$cn->autocommit(false);
try {
    $sqlUpdate = "UPDATE turnos 
    SET id_usuario_archivado = $id_usuario, 
            motivo_archivado = '$motivo_archivado',
            fecha_archivado = '$horaActual' where id_turno = $id_turno";
    $cn->query($sqlUpdate);

    reornedar_turnos($cn, $sucursal);

    $cn->commit();
    echo 1;
} catch (Exception $e) {
    $cn->rollback();
    echo 0;
    echo $e->getMessage();
}
