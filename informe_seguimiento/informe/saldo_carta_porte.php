<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');

$fecha_actual = $_POST['fecha'];
$fecha_anterior = date("Y-m-d", strtotime($fecha_actual . " -1 day"));

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
        (array('invoiced', '=', false)),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
file_put_contents('file3.json', $json2);
$data = json_decode($json2, true);

// Agrupar por store_id y date_order
$grouped_data = [];
foreach ($data as $item) {
    $store_id = $item['store_id'][1];
    $date_order = $item['date_order'];

    $grouped_data[$store_id][$date_order][] = $item['amount_total'];
}
?>

<div class="row">
    <div class="col">
        <?php
        // Imprimir la tabla
        echo '<table class="table table-striped table-sm table-hover" id="miTabla">
        <tr>
            <th>Sucursal</th>
            <th>' . $fecha_anterior . '</th>
            <th>' . $fecha_actual . '</th>
            <th>Variación</th>
        </tr>';

        foreach ($grouped_data as $store_id => $dates) {
            $amount_total_fecha_agrupada_1 = array_sum(reset($dates));
            $amount_total_fecha_agrupada_2 = array_sum(end($dates));

            $operacion = (($amount_total_fecha_agrupada_2 / $amount_total_fecha_agrupada_1) * 100) - 100;

            echo "<tr>
            <td>{$store_id}</td>
            <td>{$amount_total_fecha_agrupada_1}</td>
            <td>{$amount_total_fecha_agrupada_2}</td>
            <td>{$operacion}</td>
          </tr>";
        }

        echo '</table>';
        ?>
    </div>
    <div class="col">
        <canvas id="myChart8"></canvas>
    </div>
</div>

<script>
    var tabla = document.getElementById("miTabla");
    var valoresSucursal = [];
    var valoresColumna = [];
    var valoresColumna2 = [];

    for (var i = 1; i < tabla.rows.length; i++) {

        var valorSucursal = tabla.rows[i].cells[0].innerText;
        valoresSucursal.push(valorSucursal);

        var valorCelda = tabla.rows[i].cells[1].innerText;
        valoresColumna.push(valorCelda);

        var valorCelda2 = tabla.rows[i].cells[2].innerText;
        valoresColumna2.push(valorCelda2);
    }

    console.log(valoresColumna);

    var ctx8 = document.getElementById('myChart8').getContext('2d');

    // Define los datos del gráfico
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

    // Crea el gráfico de barras
    var myChart8 = new Chart(ctx8, {
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