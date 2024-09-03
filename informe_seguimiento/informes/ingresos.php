<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');
require_once('../metodos/switch.php');

$kwargs2 = ['fields' => ['id', 'state', 'amount_total', 'date_order', 'store_id'], 'order' => 'date_order asc'];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('date_order', '>=', $fecha_anterior)),
        (array('date_order', '<=', $fecha_actual)),
        (array('state', '!=', 'cancel')),
        (array('travel_id', '!=', false)),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$data = json_decode($json2, true);

// Inicializar un array para almacenar los datos agrupados
$grouped_data = [];

if (isset($_POST['opcion'])) {
    $opcion = $_POST['opcion'];
} else {
    $opcion = $opcion_select;
}

switch ($opcion) {
    case 'dia':
        $start_date_1 = $fecha_anterior;
        $end_date_1 = $fecha_anterior;

        $start_date_2 = $fecha_actual;
        $end_date_2 = $fecha_actual;
        break;
    case 'semana':
        $start_date_1 = $rangoSemanaAnterior[0];
        $end_date_1 = $rangoSemanaAnterior[1];

        $start_date_2 = $fecha_inicial;
        $end_date_2 = $fecha_final;
        break;
    case 'mes':
        $start_date_1 = $primerDiaAnt;
        $end_date_1 = $ultimoDiaAnt;

        $start_date_2 = $primerDiaAc;
        $end_date_2 = $ultimoDiaAc;
        break;
}
// Recorrer los datos originales
foreach ($data as $item) {
    // Obtener store_id y date_order
    $store_id = $item['store_id'][1];
    $date_order = $item['date_order'];

    // Inicializar claves para cada store_id
    if (!isset($grouped_data[$store_id])) {
        $grouped_data[$store_id] = [
            'range_1' => 0,
            'range_2' => 0,
        ];
    }

    // Verificar si la fecha está dentro del primer rango especificado
    if (strtotime($date_order) >= strtotime($start_date_1) && strtotime($date_order) <= strtotime($end_date_1)) {
        $grouped_data[$store_id]['range_1'] += $item['amount_total'];
    }
    // Verificar si la fecha está dentro del segundo rango especificado
    elseif (strtotime($date_order) >= strtotime($start_date_2) && strtotime($date_order) <= strtotime($end_date_2)) {
        $grouped_data[$store_id]['range_2'] += $item['amount_total'];
    }
}

$total1 = 0;
$total2 = 0;
?>
<div class="row">
    <h1 class="m-3">Ingresos por sucursal</h1>
    <div class="col">
        <?php
        // Imprimir la tabla HTML
        echo '<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm" id="TablaIngresos">
        <tr>
            <th>Sucursal</th>
            <th class="table-text-end">' . $columna1 . '</th>
            <th class="table-text-end">' . $columna2 . '</th>
            <th class="table-text-end">Variación</th>
        </tr>';

        foreach ($grouped_data as $store_id => $amounts) {
            $total1 = $total1 + $amounts['range_1'];
            $total2 = $total2 + $amounts['range_2'];

            echo '<tr>
            <td><span class="badge bg-soft-success text-success">' . $store_id . '</span></td>
            <td class="table-text-end">' . number_format($amounts['range_1'],  2, '.', ',') . '</td>
            <td class="table-text-end">' . number_format($amounts['range_2'],  2, '.', ',') . '</td>
            <td class="table-text-end">';
            if ($amounts['range_1'] != 0) {
                $porcentaje = (($amounts['range_2'] - $amounts['range_1']) / $amounts['range_1']) * 100;
                echo number_format($porcentaje, 0) . '%';
            } else {
                echo "";
            }
            echo '</td>
        </tr>';
        }

        echo '<tr>
        <th>Total</th>
        <th class="table-text-end">' . number_format($total1,  2, '.', ',')  . '</th>
        <th class="table-text-end">' . number_format($total2,  2, '.', ',')  . '</th>
        <th></th>
        </tr>';

        echo '</table>';
        ?>
    </div>
    <div class="col">
        <canvas id="ingresos_canvas"></canvas>
    </div>
</div>

<script>
    var tabla = document.getElementById("TablaIngresos");
    var valoresSucursal = [];
    var valoresColumna = [];
    var valoresColumna2 = [];

    for (var i = 1; i < tabla.rows.length; i++) {

        var valorSucursal = tabla.rows[i].cells[0].innerText;
        valoresSucursal.push(valorSucursal);

        var valorCelda = tabla.rows[i].cells[1].innerText;
        valorCelda = valorCelda.replace(/,/g, '');
        valoresColumna.push(valorCelda);

        var valorCelda2 = tabla.rows[i].cells[2].innerText;
        valorCelda2 = valorCelda2.replace(/,/g, '');
        valoresColumna2.push(valorCelda2);
    }

    console.log(valoresSucursal);
    console.log(valoresColumna);
    console.log(valoresColumna2);

    var ctx8 = document.getElementById('ingresos_canvas').getContext('2d');

    var data8 = {
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
            backgroundColor: "#06cca7",
            hoverBackgroundColor: "#06cca7",
            borderColor: "#06cca7",
        }]
    };

    var ingresos_canvas = new Chart(ctx8, {
        type: 'bar',
        data: data8,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>