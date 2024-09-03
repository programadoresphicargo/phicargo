<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');

$semana = $_POST['semana'] - 1;
$rangoFechas = obtenerRangoFechaSemana(2023, $semana);

$response = [
    'fechaInicio' => $rangoFechas['fechaInicio'],
    'fechaFin' => $rangoFechas['fechaFin']
];

$semana_anterior1 = $rangoFechas['fechaInicio'];
$semana_anterior2 = $rangoFechas['fechaFin'];

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_final = $_POST['fecha_final'];

$fecha = $fecha_inicio;
$primerDia = date("Y-m-01", strtotime($fecha));
$ultimoDia = date("Y-m-t", strtotime($fecha));

"Fecha original: $fecha<br>";
"Primer día del mes: $primerDia<br>";
"Último día del mes: $ultimoDia<br>";

$kwargs2 = ['fields' => ['id', 'mro_type_id', 'vehicle_id', 'store_id', 'date', 'groupby' => 'id']];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.mro.order',
    'search_read',
    array(array(
        (array('mro_type_id', '!=', false)),
        (array('store_id', '!=', false)),
        (array('date', '>=', $primerDia)),
        (array('date', '<=', $ultimoDia)),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
file_put_contents('ahs3.json', $json2);
$data = json_decode($json2, true);

$range1_start = $semana_anterior1;
$range1_end = $semana_anterior2;
$range2_start = $fecha_inicio;
$range2_end = $fecha_final;
$range3_start = $primerDia;
$range3_end = $ultimoDia;

// Crear un array para almacenar los datos agrupados
$grouped_data = [];

// Inicializar las variables de cantidad en 0
foreach ($data as $item) {
    $store_id = $item['store_id'][0];
    $ejecutivo = $item['mro_type_id'][1];
    $date_order = $item['date'];

    // Inicializar un array para llevar un registro de los rangos en los que cae
    $ranges = [];

    // Determinar a qué rango de fecha pertenece el registro y registrarlos en el array
    if ($date_order >= $range1_start && $date_order <= $range1_end) {
        $ranges[] = "Rango 1";
    }
    if ($date_order >= $range2_start && $date_order <= $range2_end) {
        $ranges[] = "Rango 2";
    }
    if ($date_order >= $range3_start && $date_order <= $range3_end) {
        $ranges[] = "Rango 3";
    }

    // Inicializar las variables en 0 si no existen
    if (!isset($grouped_data[$store_id])) {
        $grouped_data[$store_id] = [];
    }

    // Agregar el ejecutivo al array si no existe
    if (!isset($grouped_data[$store_id][$ejecutivo])) {
        $grouped_data[$store_id][$ejecutivo] = [
            "Rango 1" => 0,
            "Rango 2" => 0,
            "Rango 3" => 0,
        ];
    }

    // Incrementar la cantidad en los rangos correspondientes
    foreach ($ranges as $range) {
        $grouped_data[$store_id][$ejecutivo][$range]++;
    }
}

?>
<div class="row">
    <div class="col">
        <?php
        // Crear una tabla HTML
        echo '<table class="table table-striped table-sm">';
        echo '<tr><th>Tipo de servicio</th><th>Semana anterior</th><th>Semana actual</th><th>Variación</th><th>Mes</th></tr>';

        foreach ($grouped_data as $store_id => $ejecutivos) {
            foreach ($ejecutivos as $ejecutivo => $cantidad) {
                echo '<tr>';

                echo '<td>' . $ejecutivo . '</td>';

                $listado[] = $ejecutivo;
                echo '<td>' . $cantidad['Rango 1'] . '</td>';
                $cantidades_exp[] = $cantidad['Rango 1'];
                echo '<td>' . $cantidad['Rango 2'] . '</td>';
                $cantidades_imp[] = $cantidad['Rango 2'];
                if ($cantidad['Rango 1'] != 0) {
                    $op =  ((($cantidad['Rango 2'] / $cantidad['Rango 1']) * 100) - 100);
                    echo '<td>' . number_format($op, 2) . ' %' . '</td>';
                } else {
                    echo '<td>' . 0 . '</td>';
                };
                echo '<td>' . $cantidad['Rango 3'] . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';

        $listado_json1 = json_encode($cantidades_exp);
        $listado_json2 = json_encode($cantidades_imp);
        ?>
    </div>
</div>