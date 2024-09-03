<?php

$semana = $_POST['semana'];

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

// Ingresar el año y el número de semana
$anio = 2023;

// Obtener el rango de fechas de la semana seleccionada
$rangoFechas = obtenerRangoFechaSemana($anio, $semana);

$response = [
    'fechaInicio' => $rangoFechas['fechaInicio'],
    'fechaFin' => $rangoFechas['fechaFin']
];

header('Content-Type: application/json');
echo json_encode($response);
