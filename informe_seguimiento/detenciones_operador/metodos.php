<?php

function Imprimir_Tiempo($variable2, $fecha1, $fecha2)
{
    $tiempoTotal = 0;

    if (($fecha1 != '') || ($fecha1 != null)) {
        $cn = conectar();

        if ($fecha2 != '' || $fecha2 != null) {
            $sql1 = "SELECT inicio_detencion, fin_detencion, CASE WHEN fin_detencion > '$fecha2' THEN TIMESTAMPDIFF(MINUTE, inicio_detencion, '$fecha2') WHEN inicio_detencion < '$fecha1' AND fin_detencion > '$fecha1' THEN TIMESTAMPDIFF(MINUTE, '$fecha1', fin_detencion) ELSE TIMESTAMPDIFF(MINUTE, inicio_detencion, fin_detencion) END AS diferencia_en_minutos, latitud, longitud FROM detenciones inner join ubicaciones on ubicaciones.id = detenciones.id_ubicacion WHERE detenciones.placas = '$variable2' AND ((inicio_detencion BETWEEN '$fecha1' AND '$fecha2') OR (fin_detencion BETWEEN '$fecha1' AND '$fecha2')) ORDER BY `detenciones`.`inicio_detencion` ASC";
        } else {
            $fecha2 = date("Y-m-d H:i:s");
            $sql1 = "SELECT inicio_detencion, fin_detencion, CASE WHEN fin_detencion > '$fecha2' THEN TIMESTAMPDIFF(MINUTE, inicio_detencion, '$fecha2') WHEN inicio_detencion < '$fecha1' AND fin_detencion > '$fecha1' THEN TIMESTAMPDIFF(MINUTE, '$fecha1', fin_detencion) ELSE TIMESTAMPDIFF(MINUTE, inicio_detencion, fin_detencion) END AS diferencia_en_minutos, latitud, longitud FROM detenciones inner join ubicaciones on ubicaciones.id = detenciones.id_ubicacion WHERE detenciones.placas = '$variable2' AND ((inicio_detencion BETWEEN '$fecha1' AND '$fecha2') OR (fin_detencion BETWEEN '$fecha1' AND '$fecha2')) ORDER BY `detenciones`.`inicio_detencion` ASC";
        }
        $result1 = $cn->query($sql1);
        while ($row1 = $result1->fetch_assoc()) {
            $tiempoTotal = +$tiempoTotal + $row1['diferencia_en_minutos'];
        }
    }
    return $tiempoTotal;
}
