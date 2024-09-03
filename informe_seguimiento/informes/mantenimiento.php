<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');
require_once('../metodos/switch.php');

$kwargs2 = ['fields' => ['id', 'mro_type_id', 'vehicle_id', 'store_id', 'date']];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.mro.order',
    'search_read',
    array(array(
        (array('mro_type_id', '!=', false)),
        (array('store_id', '!=', false)),
        (array('date', '>=', $fecha_anterior)),
        (array('date', '<=', $fecha_actual)),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$data = json_decode($json2, true);

// Crear un array para almacenar los datos agrupados
$grouped_data = [];

// Inicializar las variables de cantidad en 0
foreach ($data as $item) {
    $store_id = $item['store_id'][0];
    $ejecutivo = $item['mro_type_id'][1];
    $date_order = $item['date'];
    $vehicle = $item['vehicle_id'][1];

    // Inicializar un array para llevar un registro de los rangos en los que cae
    $ranges = [];

    // Determinar a qué rango de fecha pertenece el registro y registrarlos en el array
    if ($date_order >= $fecha_anterior . ' 00:00:00' && $date_order <= $fecha_anterior . ' 23:59:00') {
        $ranges[] = "Rango 1";
    }
    if ($date_order >= $fecha_actual . ' 00:00:00' && $date_order <= $fecha_actual . ' 23:59:00') {
        $ranges[] = "Rango 2";
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
        ];
    }

    // Incrementar la cantidad en los rangos correspondientes
    foreach ($ranges as $range) {
        $grouped_data[$store_id][$ejecutivo][$range]++;
    }
}

?>
<div class="row">
    <h2 class="m-3">Mantenimiento</h2>
    <div class="col">
        <?php
        // Crear una tabla HTML
        echo '<div class="table-responsive">';
        echo '<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm">';
        echo '<tr><th>Tipo de servicio</th><th>' . $columna1 . '</th><th style="width: 200px;">Unidades</th><th>' . $columna2 . '</th><th>Unidades</th><th>Variación</th></tr>';

        foreach ($grouped_data as $store_id => $ejecutivos) {
            foreach ($ejecutivos as $ejecutivo => $cantidades) {
                echo '<tr>';
                echo '<td>' . $ejecutivo . '</td>';
                echo '<td>' . $cantidades['Rango 1'] . '</td>';
                $cantidades_exp[] = $cantidades['Rango 1'];
                echo '<td>';
                foreach ($data as $item) {
                    if (
                        $item['store_id'][0] == $store_id &&
                        $item['mro_type_id'][1] == $ejecutivo &&
                        $item['date'] >= $fecha_anterior . ' 00:00:00' &&
                        $item['date'] <= $fecha_anterior . ' 23:59:00'
                    ) {
                        echo $item['vehicle_id'][1] . ', ';
                    }
                }
                echo '</td>';
                echo '<td>' . $cantidades['Rango 2'] . '</td>';
                echo '<td width="100">';
                foreach ($data as $item) {
                    if (
                        $item['store_id'][0] == $store_id &&
                        $item['mro_type_id'][1] == $ejecutivo &&
                        $item['date'] >= $fecha_actual . ' 00:00:00' &&
                        $item['date'] <= $fecha_actual . ' 23:59:00'
                    ) {
                        echo $item['vehicle_id'][1] . ', ';
                    }
                }
                echo '</td>';
                $cantidades_imp[] = $cantidades['Rango 1'];
                if ($cantidades['Rango 1'] != 0) {
                    $op =  ((($cantidades['Rango 2'] / $cantidades['Rango 1']) * 100) - 100);
                    echo '<td>' . number_format($op, 2) . ' %' . '</td>';
                } else {
                    echo '<td>' . 0 . '</td>';
                };
                echo '</tr>';
            }
        }

        echo '</table>';
        echo '</div>';
        $listado_json1 = json_encode($cantidades_exp);
        $listado_json2 = json_encode($cantidades_imp);
        ?>
    </div>
</div>