<?php

date_default_timezone_set("America/Mexico_City");
$fechaActual = date("Y-m-d H:i:s");

$json = file_get_contents('viajes.json');
$cps = json_decode($json, true);

date_default_timezone_set("America/Mexico_City");
$fechaActual = date("Y-m-d H:i:s");

foreach ($cps as $cp) {

    $fecha1 = $fechaActual;
    $fecha2 = $cp['date_start'];
    $diff = strtotime($fecha2) - strtotime($fecha1);
    $dias = $diff / (60 * 60 * 24);
    $horas = ($dias - intval($dias)) * 24;
    $min = ($horas - intval($horas)) * 60;
    $seg = ($min - intval($min)) * 60;

    if (intval($dias) <= 0 && intval($horas) <= 0 && intval($min <= 0) && $cp['x_status_viaje'] == '') {
        echo $cp['vehicle_id'][1] . " , ";
    } else if (intval($dias) == 0 && intval($horas) == 0 && intval($min) < 60 && $cp['x_status_viaje'] == '') {
    }
}
