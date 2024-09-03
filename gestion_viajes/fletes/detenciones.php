<?php
require_once('../../mysql/conexion.php');

function getMinutos($placas, $fecha1, $fecha2)
{
    $tiempoTotal = 0;

    if (($fecha1 != '') || ($fecha1 != null)) {
        $cn = conectar();

        if ($fecha2 != '' || $fecha2 != null) {
            $sql1 = "SELECT inicio_detencion, fin_detencion, CASE WHEN fin_detencion > '$fecha2' THEN TIMESTAMPDIFF(MINUTE, inicio_detencion, '$fecha2') WHEN inicio_detencion < '$fecha1' AND fin_detencion > '$fecha1' THEN TIMESTAMPDIFF(MINUTE, '$fecha1', fin_detencion) ELSE TIMESTAMPDIFF(MINUTE, inicio_detencion, fin_detencion) END AS diferencia_en_minutos, latitud, longitud FROM detenciones inner join ubicaciones on ubicaciones.id = detenciones.id_ubicacion WHERE detenciones.placas = '$placas' AND ((inicio_detencion BETWEEN '$fecha1' AND '$fecha2') OR (fin_detencion BETWEEN '$fecha1' AND '$fecha2')) ORDER BY `detenciones`.`inicio_detencion` ASC";
        } else {
            $fecha2 = date("Y-m-d H:i:s");
            $sql1 = "SELECT inicio_detencion, fin_detencion, CASE WHEN fin_detencion > '$fecha2' THEN TIMESTAMPDIFF(MINUTE, inicio_detencion, '$fecha2') WHEN inicio_detencion < '$fecha1' AND fin_detencion > '$fecha1' THEN TIMESTAMPDIFF(MINUTE, '$fecha1', fin_detencion) ELSE TIMESTAMPDIFF(MINUTE, inicio_detencion, fin_detencion) END AS diferencia_en_minutos, latitud, longitud FROM detenciones inner join ubicaciones on ubicaciones.id = detenciones.id_ubicacion WHERE detenciones.placas = '$placas' AND ((inicio_detencion BETWEEN '$fecha1' AND '$fecha2') OR (fin_detencion BETWEEN '$fecha1' AND '$fecha2')) ORDER BY `detenciones`.`inicio_detencion` ASC";
        }
        $result1 = $cn->query($sql1);
        while ($row1 = $result1->fetch_assoc()) {
            $tiempoTotal = +$tiempoTotal + $row1['diferencia_en_minutos'];
        }
    }
    $minutos = $tiempoTotal;
    $tiempoConvertido = convertirMinutosAHorasMinutos($minutos);
    return $tiempoConvertido['horas'] . ':' . $tiempoConvertido['minutos'];
}

function getMinutosTotal($fecha1, $fecha2)
{
    $dateTime1 = new DateTime($fecha1);
    $dateTime2 = isset($fecha2) ? new DateTime($fecha2) : new DateTime();
    $interval = $dateTime1->diff($dateTime2);
    $segundosTotales = $interval->s + ($interval->i * 60) + ($interval->h * 3600) + ($interval->days * 86400);
    $horas = floor($segundosTotales / 3600);
    $segundosTotales %= 3600;
    $minutos = floor($segundosTotales / 60);

    $horas_formateadas = sprintf("%02d", $horas);
    $minutos_formateados = sprintf("%02d", $minutos);

    return $horas_formateadas . ':' . $minutos_formateados;
}

function convertirMinutosAHorasMinutos($minutos)
{
    $horas = floor($minutos / 60);
    $minutosRestantes = $minutos % 60;

    return [
        'horas' => $horas,
        'minutos' => $minutosRestantes
    ];
}
