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

$kwargs2 = ['fields' => ['id', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'store_id', 'state', 'date_order', 'x_modo_bel'],  'order' => 'date_order asc'];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('date_order', '>=', $primerDia)),
        (array('date_order', '<=', $ultimoDia)),
        (array('state', '!=', "cancel")),
        (array('travel_id', '!=', false)),
        (array('x_ejecutivo_viaje_bel', '!=', "Lucero Rodriguez Vallejo")),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
file_put_contents('ahs3.json', $json2);

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

$range1_start = $semana_anterior1;
$range1_end = $semana_anterior2;
$range2_start = $fecha_inicio;
$range2_end = $fecha_final;
$range3_start = $primerDia;
$range3_end = $ultimoDia;

// Crear un array para almacenar los datos agrupados
$grouped_data = [];

// Inicializar las variables de cantidad en 0
foreach ($filtered_json as $item) {
    $store_id = $item['store_id'][0];
    $ejecutivo = $item['x_modo_bel'];
    $date_order = $item['date_order'];

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
        echo '<tr><th>Sucursal</th><th>Ejecutivo</th><th>Semana anterior</th><th>Semana actual</th><th>Mes actual</th></tr>';

        foreach ($grouped_data as $store_id => $ejecutivos) {
            foreach ($ejecutivos as $ejecutivo => $cantidad) {
                echo '<tr>';
                if ($store_id == 1) {
                    echo '<td>Veracruz</td>';
                } else if ($store_id == 9) {
                    echo '<td>Manzanillo</td>';
                } else if ($store_id == 2) {
                    echo '<td>México</td>';
                }

                if ($ejecutivo == 'exp') {
                    echo '<td>EXP</td>';
                } else {
                    echo '<td>IMP</td>';
                }

                $listado[] = $ejecutivo;
                echo '<td>' . $cantidad['Rango 1'] . '</td>';
                $cantidades_exp[] = $cantidad['Rango 1'];
                echo '<td>' . $cantidad['Rango 2'] . '</td>';
                $cantidades_imp[] = $cantidad['Rango 2'];
                echo '<td>' . $cantidad['Rango 3'] . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';

        $listado_json1 = json_encode($cantidades_exp);
        $listado_json2 = json_encode($cantidades_imp);
        ?>
    </div>
    <div class="col-5">
        <canvas id="myChart6"></canvas>
    </div>
</div>

<script>
    var labels1 = <?php echo $listado_json1; ?>;
    var labels2 = <?php echo $listado_json2; ?>;

    var ctx6 = document.getElementById('myChart6').getContext('2d');

    // Define los datos del gráfico
    var data6 = {
        labels: ['Manzanillo', 'Veracruz', 'México'],
        datasets: [{
            label: ['Exp'],
            data: labels1,
            backgroundColor: "#377dff",
            hoverBackgroundColor: "#377dff",
            borderColor: "#377dff",
        }, {
            label: ['Imp'],
            data: labels2,
            backgroundColor: "#377dff",
            hoverBackgroundColor: "#377dff",
            borderColor: "#377dff",
        }]
    };

    // Crea el gráfico de barras
    var myChart6 = new Chart(ctx6, {
        type: 'bar',
        data: data6,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>