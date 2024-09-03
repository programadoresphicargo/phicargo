<?php
require_once('../../mysql/conexion.php');
require_once('../algoritmos/algoritmos.php');
require_once('../algoritmos/obtener_turnos.php');

$cn = conectar();
$sucursal = $_POST['sucursal'];

$cn->autocommit(false);
try {
    $turno = obtener_turnos($sucursal) + 1;
    $id_turno = $_POST['id_turno'];
    $cn->query("UPDATE turnos set id_usuario_archivado = NULL, fecha_archivado = NULL, turno = $turno where id_turno = $id_turno");
    $cn->commit();
    echo 1;
} catch (Exception $e) {
    $cn->rollback();
    echo 0;
}
