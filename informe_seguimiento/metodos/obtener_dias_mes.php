<?php

function obtenerPrimerUltimoDia($year, $month)
{
    // Primer día del mes
    $primerDia = new DateTime("$year-$month-01");

    // Último día del mes
    $ultimoDia = new DateTime("$year-$month-" . $primerDia->format('t'));

    return array(
        'primerDia' => $primerDia,
        'ultimoDia' => $ultimoDia
    );
}

// Función para obtener el primer y último día del mes anterior
function obtenerPrimerUltimoDiaMesAnterior($year, $month)
{
    // Calcula el mes anterior
    $mesAnterior = ($month == 1) ? 12 : $month - 1;
    $yearAnterior = ($month == 1) ? $year - 1 : $year;

    // Obtiene el primer día del mes anterior
    $primerDiaMesAnterior = new DateTime("$yearAnterior-$mesAnterior-01");

    // Obtiene el último día del mes anterior
    $ultimoDiaMesAnterior = new DateTime("$yearAnterior-$mesAnterior-" . $primerDiaMesAnterior->format('t'));

    return array(
        'primerDiaMesAnterior' => $primerDiaMesAnterior,
        'ultimoDiaMesAnterior' => $ultimoDiaMesAnterior
    );
}
