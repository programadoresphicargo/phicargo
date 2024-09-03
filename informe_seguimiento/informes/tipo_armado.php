<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');
require_once('../metodos/switch.php');

$kwargs2 = ['fields' => ['id', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'store_id', 'state', 'date_order', 'x_modo_bel', 'x_tipo_bel'],  'order' => 'date_order asc'];

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
    $ejecutivo = $item['x_tipo_bel'];
    $date_order = $item['date_order'];

    $ranges = [];

    include('../metodos/agrupacion.php');

    // Inicializar las variables en 0 si no existen
    if (!isset($grouped_data[$store_id])) {
        $grouped_data[$store_id] = [];
    }

    // Agregar el ejecutivo al array si no existe
    if (!isset($grouped_data[$store_id][$ejecutivo])) {
        $grouped_data[$store_id][$ejecutivo] = [
            "Rango 1" => 0,
            "Rango 2" => 0,
        ];
    }

    // Incrementar la cantidad en los rangos correspondientes
    foreach ($ranges as $range) {
        $grouped_data[$store_id][$ejecutivo][$range]++;
    }
}

?>
<div class="row">
    <h2 class="m-3">Viajes por tipo de armado</h2>
    <div class="col">
        <?php
        // Crear una tabla HTML
        echo '<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm" id="miTablaArmado">';
        echo '<tr><th>Sucursal</th><th>Tipo</th><th>' . $columna1 . '</th><th>' . $columna2 . '</th><th>Variación</th></tr>';

        foreach ($grouped_data as $store_id => $ejecutivos) {
            foreach ($ejecutivos as $ejecutivo => $cantidad) {
                echo '<tr>';

                echo '<td>' . $store_id . '</td>';

                if ($ejecutivo == 'single') {
                    echo '<td><span class="badge bg-primary rounded-pill">Sencillo</span></td>';
                } else {
                    echo '<td><span class="badge bg-dark rounded-pill">Full</span></td>';
                }

                $listado[] = $ejecutivo;
                echo '<td>' . $cantidad['Rango 1'] . '</td>';
                echo '<td>' . $cantidad['Rango 2'] . '</td>';
                if ($cantidad['Rango 1'] != 0) {
                    $op =  ((($cantidad['Rango 2'] / $cantidad['Rango 1']) * 100) - 100);
                    echo '<td>' . number_format($op, 2) . ' %' . '</td>';
                } else {
                    echo '<td>' . 0 . '</td>';
                };
                echo '</tr>';
            }
        }

        echo '</table>';
        ?>
    </div>
    <div class="col-5">
        <canvas id="myChart7"></canvas>
    </div>
</div>

<script>
    var tabla = document.getElementById("miTablaArmado");
    var valoresSucursal = [];
    var valoresColumna = [];
    var valoresColumna2 = [];

    for (var i = 1; i < tabla.rows.length; i++) {

        var valorSucursal = tabla.rows[i].cells[0].innerText;
        valoresSucursal.push(valorSucursal);

        var valorCelda = tabla.rows[i].cells[2].innerText;
        valoresColumna.push(valorCelda);

        var valorCelda2 = tabla.rows[i].cells[3].innerText;
        valoresColumna2.push(valorCelda2);
    }

    var ctx7 = document.getElementById('myChart7').getContext('2d');

    // Define los datos del gráfico
    var data7 = {
        labels: valoresSucursal,
        datasets: [{
            label: ['<?php echo $fecha_anterior ?>'],
            data: valoresColumna,
            backgroundColor: "#377dff",
            hoverBackgroundColor: "#377dff",
            borderColor: "#377dff",
        }, {
            label: ['<?php echo $fecha_actual ?>'],
            data: valoresColumna2,
            backgroundColor: "#e7eaf3",
            borderColor: "#e7eaf3",
        }]
    };

    // Crea el gráfico de barras
    var myChart7 = new Chart(ctx7, {
        type: 'bar',
        data: data7,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>