<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');
require_once('../metodos/switch.php');

$kwargs2 = ['fields' => ['id', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'store_id', 'state', 'date_order'],  'order' => 'date_order asc'];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('date_order', '>=', $fecha_anterior)),
        (array('date_order', '<=', $fecha_actual)),
        (array('state', '!=', "cancel")),
        (array('travel_id', '!=', false)),
        (array('x_ejecutivo_viaje_bel', '!=', "Lucero Rodriguez Vallejo")),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$data = json_decode($json2, true);

$seen_travel_ids = [];
$filtered_json = [];

foreach ($data as $item) {
    $travel_id = $item['travel_id'][1];

    if (!in_array($travel_id, $seen_travel_ids)) {
        $seen_travel_ids[] = $travel_id;
        $filtered_json[] = $item;
    }
}

$grouped_data = [];

foreach ($filtered_json as $item) {
    $store_id = $item['store_id'][1];
    $ejecutivo = $item['x_ejecutivo_viaje_bel'];
    $date_order = $item['date_order'];

    $ranges = [];

    include('../metodos/agrupacion.php');

    if (!isset($grouped_data[$store_id])) {
        $grouped_data[$store_id] = [];
    }

    if (!isset($grouped_data[$store_id][$ejecutivo])) {
        $grouped_data[$store_id][$ejecutivo] = [
            "Rango 1" => 0,
            "Rango 2" => 0,
        ];
    }

    foreach ($ranges as $range) {
        $grouped_data[$store_id][$ejecutivo][$range]++;
    }
}

$total1 = 0;
$total2 = 0;

?>
<div class="row">
    <h2 class="m-3">Viajes por ejecutivo</h2>
    <div class="col-7">
        <?php
        echo '<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm">';
        echo '<tr><th>Sucursal</th><th>Ejecutivo</th><th class="table-text-end">' . $columna1 . '</th><th class="table-text-end">' . $columna2 . '</th><th>Variación</th></tr>';

        foreach ($grouped_data as $store_id => $ejecutivos) {
            foreach ($ejecutivos as $ejecutivo => $cantidad) {
                echo '<tr>';
                echo '<td>' . $store_id . '</td>';
                echo '<td>' . $ejecutivo . '</td>';
                $listado[] = $ejecutivo;
                echo '<td class="table-text-end">' . $cantidad['Rango 1'] . '</td>';
                $cantidades[] = $cantidad['Rango 1'];
                $total1 = $total1 + $cantidad['Rango 1'];

                echo '<td class="table-text-end">' . $cantidad['Rango 2'] . '</td>';
                if ($cantidad['Rango 1'] != 0) {
                    $op =  ((($cantidad['Rango 2'] / $cantidad['Rango 1']) * 100) - 100);
                    echo '<td>' . number_format($op, 2) . ' %' . '</td>';
                } else {
                    echo '<td>' . 0 . '</td>';
                };
                echo '</tr>';

                $cantidades2[] = $cantidad['Rango 2'];
                $total2 = $total2 + $cantidad['Rango 2'];
            }
        }

        echo '<tr>';
        echo '<td></td>';
        echo '<td class="table-text-end"><h4>Totales</h4></td>';
        echo '<td class="table-text-end"><h4>' . $total1 . '</h4></td>';
        echo '<td class="table-text-end"><h4>' . $total2 . '</h4></td>';
        echo '<td></td>';
        echo '</tr>';

        echo '</table>';

        $listado_json = json_encode($listado);
        $cantidades_json = json_encode($cantidades);
        $cantidades_json2 = json_encode($cantidades2);
        ?>
    </div>
    <div class="col-5">
        <canvas id="myChart3"></canvas>
    </div>
</div>

<script>
    var labels = <?php echo $listado_json; ?>;
    var labels2 = <?php echo $cantidades_json; ?>;
    var labels3 = <?php echo $cantidades_json2; ?>;

    var ctx3 = document.getElementById('myChart3').getContext('2d');

    var data3 = {
        labels: labels,
        datasets: [{
                label: ['<?php echo $fecha_anterior ?>'],
                data: labels2,
                backgroundColor: "#377dff",
                hoverBackgroundColor: "#377dff",
                borderColor: "#377dff",
            },
            {
                label: ['<?php echo $fecha_actual ?>'],
                data: labels3,
                backgroundColor: "#e7eaf3",
                borderColor: "#e7eaf3",
            }
        ]
    };

    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: data3,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>