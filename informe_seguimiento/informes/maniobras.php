<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');
require_once('../metodos/switch.php');

$kwargs2 = ['fields' => ['id', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'store_id', 'state', 'date_order', 'x_modo_bel'],  'order' => 'date_order asc'];

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
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$data = json_decode($json2, true);

$grouped_data = [];

foreach ($data as $item) {
    $store_id = $item['store_id'][1];
    $ejecutivo = $item['x_modo_bel'];
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
    <h2 class="m-3">Maniobras</h2>
    <div class="col">
        <?php
        // Crear una tabla HTML
        echo '<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm" id="miTablaManiobras">';
        echo '<tr><th>Sucursal</th><th>Tipo</th><th class="table-text-end">' . $columna1 . '</th><th class="table-text-end">' . $columna2 . '</th></tr>';

        foreach ($grouped_data as $store_id => $ejecutivos) {
            foreach ($ejecutivos as $ejecutivo => $cantidad) {
                echo '<tr>';
                echo '<td>' . $store_id . '</td>';

                if ($ejecutivo == 'exp') {
                    echo '<td><span class="badge bg-danger rounded-pill">EXP</span></td>';
                } else if ($ejecutivo == 'imp') {
                    echo '<td><span class="badge bg-warning rounded-pill">IMP</span></td>';
                } else {
                    echo '<td>No definido</td>';
                }

                echo '<td class="table-text-end">' . $cantidad['Rango 1'] . '</td>';
                echo '<td class="table-text-end">' . $cantidad['Rango 2'] . '</td>';
                echo '</tr>';
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

        ?>
    </div>
    <div class="col-5">
        <canvas id="myChart6"></canvas>
    </div>
</div>

<script>
    var tabla = document.getElementById("miTablaManiobras");
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

    var ctx6 = document.getElementById('myChart6').getContext('2d');

    // Define los datos del gráfico
    var data6 = {
        labels: valoresSucursal,
        datasets: [{
            label: ['<?php echo $fecha_anterior ?>'],
            data: valoresColumna,
            backgroundColor: "#ec4d7c",
            hoverBackgroundColor: "#ec4d7c",
            borderColor: "#ec4d7c",
        }, {
            label: ['<?php echo $fecha_actual ?>'],
            data: valoresColumna2,
            backgroundColor: "#fcbd1f",
            hoverBackgroundColor: "#fcbd1f",
            borderColor: "#fcbd1f",
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