<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');
require_once('../metodos/switch.php');

$kwargs2 = ['fields' => ['id', 'store_id', 'payment_date', 'amount'],  'order' => 'payment_date asc'];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'account.payment',
    'search_read',
    array(array(
        (array('payment_date', '>=', $fecha_anterior)),
        (array('payment_date', '<=', $fecha_actual)),
        (array("payment_type", "=", "inbound")),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$data = json_decode($json2, true);

// Inicializar un array para almacenar los datos agrupados
$grouped_data = [];

// Definir los dos rangos de fechas
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
    if (isset($item['store_id'][1])) {
        $store_id = $item['store_id'][1];
    } else {
        $store_id = 'Indefinido';
    }
    $date_order = $item['payment_date'];

    // Inicializar claves para cada store_id
    if (!isset($grouped_data[$store_id])) {
        $grouped_data[$store_id] = [
            'range_1' => 0,
            'range_2' => 0,
        ];
    }

    // Verificar si la fecha está dentro del primer rango especificado
    if (strtotime($date_order) >= strtotime($start_date_1) && strtotime($date_order) <= strtotime($end_date_1)) {
        $grouped_data[$store_id]['range_1'] += $item['amount'];
    }
    // Verificar si la fecha está dentro del segundo rango especificado
    elseif (strtotime($date_order) >= strtotime($start_date_2) && strtotime($date_order) <= strtotime($end_date_2)) {
        $grouped_data[$store_id]['range_2'] += $item['amount'];
    }
}

?>
<div class="row">
    <h1 class="m-3">Cobranza</h1>
    <div class="col">
        <?php
        // Imprimir la tabla HTML
        echo '<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm" id="TablaIngresos">
        <tr>
            <th>Sucursal</th>
            <th>' . $columna1 . '</th>
            <th>' . $columna2 . '</th>
        </tr>';

        foreach ($grouped_data as $store_id => $amounts) {
            echo '<tr>
            <td>' . $store_id . '</td>
            <td>' . $amounts['range_1'] . '</td>
            <td>' . $amounts['range_2'] . '</td>
        </tr>';
        }

        echo '</table>';
        ?>
    </div>
</div>