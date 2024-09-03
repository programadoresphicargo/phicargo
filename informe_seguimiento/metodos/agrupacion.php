<?php

if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
} else {
    $opcion = $opcion_select;
}

switch ($opcion) {

    case 'dia';
        if ($date_order == $fecha_anterior) {
            $ranges[] = "Rango 1";
        }
        if ($date_order == $fecha_actual) {
            $ranges[] = "Rango 2";
        }
        $columna1 = $fecha_anterior;
        $columna2 = $fecha_actual;
        break;

    case 'semana';
        if ($date_order >= $rangoSemanaAnterior[0] && $date_order <= $rangoSemanaAnterior[1]) {
            $ranges[] = "Rango 1";
        }
        if ($date_order >= $fecha_inicial && $date_order <= $fecha_final) {
            $ranges[] = "Rango 2";
        }
        $columna1 = 'Semana anterior';
        $columna2 = 'Semana actual';
        break;

    case 'mes';
        if ($date_order >= $primerDiaAnt && $date_order <= $ultimoDiaAnt) {
            $ranges[] = "Rango 1";
        }
        if ($date_order >= $primerDiaAc && $date_order <= $ultimoDiaAc) {
            $ranges[] = "Rango 2";
        }
        break;

    default:
        break;
}
