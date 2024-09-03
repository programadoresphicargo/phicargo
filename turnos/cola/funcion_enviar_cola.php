<?php
include_once('../algoritmos/obtener_turnos.php');

function enviar_cola($id_turno, $sucursal, $fecha_hora_salida)
{
    include_once("../../mysql/conexion.php");
    $cn = conectar();
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $usuario_envio = $_SESSION['userID'];
    $horaActual = date("Y-m-d H:i:s");

    $cn->autocommit(false);
    try {
        $sqlInsert = "INSERT INTO cola VALUES(NULL, $id_turno, $usuario_envio, '$horaActual' ,'$fecha_hora_salida','espera')";
        $cn->query($sqlInsert);
        $sqlDelete = "UPDATE turnos set cola = true WHERE id_turno = $id_turno";
        $cn->query($sqlDelete);
        reornedar_turnos($cn, $sucursal);
        $cn->commit();
        echo 1;
    } catch (Exception $e) {
        $cn->rollback();
        echo 0;
        echo "Error: " . $e->getMessage();
        echo "Error en la línea " . $e->getLine() . ": " . $e->getMessage();
    }
}
