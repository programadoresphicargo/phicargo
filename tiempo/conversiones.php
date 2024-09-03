<?php

function utctocst($fechaHoraUtc)
{
    $zonaHorariaUtc = new DateTimeZone('UTC');
    $zonaHorariaCst = new DateTimeZone('America/Mexico_City');
    $fechaHoraUtcObj = new DateTime($fechaHoraUtc, $zonaHorariaUtc);
    $fechaHoraCstObj = $fechaHoraUtcObj->setTimezone($zonaHorariaCst);
    $formatoSalida = 'Y-m-d H:i:s';
    $fechaHoraCst = $fechaHoraCstObj->format($formatoSalida);
    return $fechaHoraCst;
}
