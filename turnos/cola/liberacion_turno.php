<?php
require_once('../../mysql/conexion.php');
require_once('../algoritmos/algoritmos.php');
require_once('../algoritmos/obtener_turnos.php');

$cn = conectar();
$id_turno = $_POST['id_turno'];

$sqlturno = "SELECT * FROM turnos where id_turno = $id_turno";
$resultadoturno = $cn->query($sqlturno);
$row = $resultadoturno->fetch_assoc();
$sucursal = $row['sucursal'];

$cn->autocommit(false);
try {
    $turno = obtener_turnos($sucursal) + 1;
    $sql = "UPDATE turnos set cola = false, turno = $turno where id_turno = $id_turno";
    $cn->query($sql);
    $sql = "UPDATE cola set cola_estado = 'liberado' where id_turno = $id_turno";
    $cn->query($sql);
    $cn->commit();
    echo 1;
} catch (Exception $e) {
    $cn->rollback();
    echo $e->getMessage();
    echo 0;
}
