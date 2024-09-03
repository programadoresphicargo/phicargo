<?php

function obtenerRangoSemanaAnterior($fechaLunes)
{
    $fecha = new DateTime($fechaLunes);
    $fecha->modify('-7 days');
    $primerDiaSemanaAnterior = clone $fecha;
    $ultimoDiaSemanaAnterior = clone $fecha;
    $ultimoDiaSemanaAnterior->modify('+6 days');
    $primerDiaSemanaAnteriorStr = $primerDiaSemanaAnterior->format('Y-m-d');
    $ultimoDiaSemanaAnteriorStr = $ultimoDiaSemanaAnterior->format('Y-m-d');
    return [$primerDiaSemanaAnteriorStr, $ultimoDiaSemanaAnteriorStr];
}
