<?php

function minutos_transcurridos($fecha_i, $fecha_f)
{
    $minutos = (strtotime($fecha_i) - strtotime($fecha_f)) / 60;
    $minutos = abs($minutos);
    $minutos = floor($minutos);
    return $minutos;
}
