<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

$semana = $_POST['semana'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_final = $_POST['fecha_final'];

$kwargs2 = ['fields' => ['id', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'store_id', 'state', 'date_order', 'x_tipo_bel', 'amount_total', 'x_modo_bel'],  'order' => 'date_order asc'];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('date_order', '>=', $fecha_inicio)),
        (array('date_order', '<=', $fecha_final)),
        (array('state', '!=', "cancel")),
        (array('travel_id', '!=', false)),
        (array('x_ejecutivo_viaje_bel', '!=', "Lucero Rodriguez Vallejo")),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$data = json_decode($json2, true);
file_put_contents('ahs5.json', $json2);

// Inicializar un array para almacenar los totales por store_id
$totals_by_store = array();

// Iterar a través de los datos y sumar los amount_total por store_id
foreach ($data as $item) {
    $store_id = $item['store_id'][0];
    $amount_total = $item['amount_total'];

    if (isset($totals_by_store[$store_id])) {
        $totals_by_store[$store_id] += $amount_total;
    } else {
        $totals_by_store[$store_id] = $amount_total;
    }
}

$veracruz = 0;
$manzanillo = 0;
$mexico = 0;

?>
<div class="row">
    <div class="col-7"><?php
                        echo '<table class="table table-striped table-sm">';
                        echo '<tr><th>Sucursal</th><th>Semana anterior</th><th>Semana actual</th></tr>';

                        foreach ($totals_by_store as $store_id => $total) {
                            echo '<tr>';
                            if ($store_id == 1) {
                                echo '<td>Veracruz</td>';
                            } else if ($store_id == 9) {
                                echo '<td>Manzanillo</td>';
                            } else {
                                echo '<td>México</td>';
                            }
                            echo '<td></td>';
                            echo '<td>' . $total . '</td>';
                            echo '</tr>';

                            if ($store_id == 1) {
                                $veracruz = $total;
                            } else if ($store_id == 9) {
                                $manzanillo = $total;
                            } else if ($store_id == 2) {
                                $mexico = $total;
                            }
                        }

                        echo '</table>';
                        ?>
    </div>
    <div class="col-5 d-flex justify-content-center align-items-center">
        <canvas id="myChart"></canvas>
    </div>
</div>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');

    var data = {
        labels: ['Veracruz', 'Manzanillo', 'México'],
        datasets: [{
            label: 'Ingresos',
            data: ['<?php echo $veracruz ?>', '<?php echo $manzanillo ?>', '<?php echo $mexico ?>'],
            backgroundColor: "#377dff",
            hoverBackgroundColor: "#377dff",
            borderColor: "#377dff",
        }]
    };

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });