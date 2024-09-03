<?php
require_once('../algoritmos/obtener_turnos.php');

function insertar_turno($cn, $id_operador, $placas, $fecha, $hora, $comentarios, $sucursal, $usuario)
{
    $turno = obtener_turnos($sucursal) + 1;

    date_default_timezone_set("America/Mexico_City");
    $horaActual = date("Y-m-d H:i:s");

    $sqlSelect = "INSERT INTO turnos VALUES(NULL,'$sucursal',$turno,$id_operador,'$placas','$fecha','$hora','$comentarios','$usuario','$horaActual',false,null,null,false,null,null,null)";

    if ($cn->query($sqlSelect)) {
        echo 1;
    } else {
        echo 0;
    }
}
