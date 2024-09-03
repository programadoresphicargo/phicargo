<?php
require_once('obtener_dias_mes.php');

if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
} else {
    $opcion = $opcion_select;
}

switch ($opcion) {
    case 'dia';
        $fecha_actual = $_POST['fecha'];
        $fecha_anterior = date("Y-m-d", strtotime($fecha_actual . " -1 day"));
        $columna1 = $fecha_anterior;
        $columna2 = $fecha_actual;
        break;
    case 'semana';
        if (isset($_POST['fechaInicial'])) {
            $fecha_inicial = $_POST['fechaInicial'];
        } else {
            $fecha_inicial = $_GET['fechaInicial'];
        }

        if (isset($_POST['fechaFinal'])) {
            $fecha_final = $_POST['fechaFinal'];
        } else {
            $fecha_final = $_GET['fechaFinal'];
        }

        if (!function_exists('obtenerRangoSemanaAnterior')) {
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
        }

        $rangoSemanaAnterior = obtenerRangoSemanaAnterior($fecha_inicial);
        $fecha_anterior = $rangoSemanaAnterior[0];
        $fecha_actual = $fecha_final;
        $columna1 = 'Semana anterior';
        $columna2 = 'Semana seleccionada';
        break;
    case 'mes';

        if (isset($_POST['mes'])) {
            $month = $_POST['mes'];
        } else {
            $month = $_GET['mes'];
        }

        if (isset($_POST['año'])) {
            $year = $_POST['año'];
        } else {
            $year = $_GET['año'];
        }

        $fechasMesActual = obtenerPrimerUltimoDia($year, $month);
        $fechasMesAnterior = obtenerPrimerUltimoDiaMesAnterior($year, $month);

        $primerDiaAc = $fechasMesActual['primerDia']->format('Y-m-d');
        $ultimoDiaAc = $fechasMesActual['ultimoDia']->format('Y-m-d');
        $primerDiaAnt = $fechasMesAnterior['primerDiaMesAnterior']->format('Y-m-d');
        $ultimoDiaAnt =  $fechasMesAnterior['ultimoDiaMesAnterior']->format('Y-m-d');

        $fecha_anterior = $primerDiaAnt;
        $fecha_actual = $ultimoDiaAc;

        $columna1 = 'Mes anterior';
        $columna2 = 'Mes seleccionado';
        break;
}
