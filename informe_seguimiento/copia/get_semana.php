<?php

function obtenerRangoFechaSemana($anio, $numeroSemana)
{
    // Establecer el primer día de la semana (lunes)
    $primerDiaSemana = new DateTime();
    $primerDiaSemana->setISODate($anio, $numeroSemana, 1);

    // Calcular el último día de la semana (domingo)
    $ultimoDiaSemana = clone $primerDiaSemana;
    $ultimoDiaSemana->add(new DateInterval('P6D'));

    return array(
        'fechaInicio' => $primerDiaSemana->format('Y-m-d'),
        'fechaFin' => $ultimoDiaSemana->format('Y-m-d')
    );
}
