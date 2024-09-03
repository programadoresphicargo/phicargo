<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

echo $semana = $_POST['semana'];
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

$result = [];
$months = [];

foreach ($data as $item) {
    $storeID = $item['store_id'][0];
    $ejecutivo = $item['x_ejecutivo_viaje_bel'];
    $date = date('Y-m', strtotime($item['date_order']));
    $travelID = $item['travel_id'];

    // Registramos los meses presentes
    $months[$date] = true;

    if (!isset($result[$storeID])) {
        $result[$storeID] = [];
    }

    if (!isset($result[$storeID][$ejecutivo])) {
        $result[$storeID][$ejecutivo] = [];
    }

    if (!isset($result[$storeID][$ejecutivo][$date])) {
        $result[$storeID][$ejecutivo][$date] = ['count' => 0, 'travel_ids' => []];
    }

    // Verificamos si travel_id no es false y si no se ha contado antes
    if ($travelID && !in_array($travelID[0], $result[$storeID][$ejecutivo][$date]['travel_ids'])) {
        $result[$storeID][$ejecutivo][$date]['count']++;
        $result[$storeID][$ejecutivo][$date]['travel_ids'][] = $travelID[0];
    }
}
// Obtenemos una lista de meses presentes
$uniqueMonths = array_keys($months);

$data = json_decode($json2, true);

$groupedData = [];

foreach ($data as $item) {
    $store_id = $item['store_id'][1];
    $x_tipo_bel = $item['x_tipo_bel'];
    $travel_id = $item['travel_id'][0];

    if (!isset($groupedData[$store_id][$x_tipo_bel])) {
        $groupedData[$store_id][$x_tipo_bel] = [];
    }

    if (!in_array($travel_id, $groupedData[$store_id][$x_tipo_bel])) {
        $groupedData[$store_id][$x_tipo_bel][] = $travel_id;
    }
}

$veracruz_sencillo = 0;
$veracruz_full = 0;

$manzanillo_sencillo = 0;
$manzanillo_full = 0;

$mexico_sencillo = 0;
$mexico_full = 0;
?>

<div class="row">
    <div class="col-7">
        <table class="table">
            <tr class="bg-dark">
                <th class="text-white">Sucursal</th>
                <th class="text-white">Tipo</th>
                <th class="text-white">Total</th>
            </tr>
            <?php
            $totalByStore = array();

            foreach ($groupedData as $store_id => $types) :
                $storeTotal = 0;
            ?>
                <?php foreach ($types as $x_tipo_bel => $travelIds) : ?>
                    <?php $count = count($travelIds); ?>
                    <tr>
                        <td><?php echo $store_id; ?></td>
                        <td><?php echo $x_tipo_bel; ?></td>
                        <td><?php echo $count; ?></td>
                    </tr>
                    <?php
                    if ($store_id == '[VER] Veracruz (Matriz)' && $x_tipo_bel == 'single') {
                        $veracruz_sencillo = $count;
                    } else if ($store_id == '[VER] Veracruz (Matriz)' && $x_tipo_bel == 'full') {
                        $veracruz_full = $count;
                    } else 

                    if ($store_id == '[MZN] Manzanillo (Sucursal)' && $x_tipo_bel == 'single') {
                        $manzanillo_sencillo = $count;
                    } else if ($store_id == '[MZN] Manzanillo (Sucursal)' && $x_tipo_bel == 'full') {
                        $manzanillo_full = $count;
                    }

                    if ($store_id == '[MEX] México (Sucursal)' && $x_tipo_bel == 'single') {
                        $mexico_sencillo = $count;
                    } else if ($store_id == '[MEX] México (Sucursal)' && $x_tipo_bel == 'full') {
                        $mexico_full = $count;
                    }
                    ?>
                    <?php $storeTotal += $count; ?>
                <?php endforeach; ?>
                <?php
                $totalByStore[$store_id] = $storeTotal;
                ?>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="col-5 d-flex justify-content-center align-items-center">
        <canvas id="myChart2"></canvas>
    </div>
</div>

<table class="table">
    <tr class="bg-dark">
        <th class="text-white">Total por Sucursal</th>
        <th class="text-white">Count</th>
    </tr>
    <?php
    foreach ($totalByStore as $store_id => $total) :
    ?>
        <tr>
            <td><?php echo $store_id; ?></td>
            <td><?php echo $total; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<script>
    var ctx2 = document.getElementById('myChart2').getContext('2d');

    // Define los datos del gráfico
    var data2 = {
        labels: ['Veracruz', 'Manzanillo', 'México'],
        datasets: [{
            label: 'SENCILLO',
            data: ['<?php echo $veracruz_sencillo ?>', '<?php echo $manzanillo_sencillo ?>', '<?php echo $mexico_sencillo ?>'],
            backgroundColor: "#377dff",
            hoverBackgroundColor: "#377dff",
            borderColor: "#377dff",
        }, {
            label: 'FULL',
            data: ['<?php echo $veracruz_full ?>', '<?php echo $manzanillo_full ?>', '<?php echo $mexico_full ?>'],
            backgroundColor: '#e7eaf3',
            borderColor: "#e7eaf3",
        }],
    };

    // Crea el gráfico de barras
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: data2,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
$data = json_decode($json2, true);

$groupedData = [];

foreach ($data as $item) {
    $store_id = $item['store_id'][1];
    $x_tipo_bel = $item['x_modo_bel'];
    $travel_id = $item['travel_id'][0];

    if (!isset($groupedData[$store_id][$x_tipo_bel])) {
        $groupedData[$store_id][$x_tipo_bel] = [];
    }

    if (!in_array($travel_id, $groupedData[$store_id][$x_tipo_bel])) {
        $groupedData[$store_id][$x_tipo_bel][] = $travel_id;
    }
}

$listado = array();
$cantidades = array();

$veracruz_imp = 0;
$veracruz_exp = 0;

$manzanillo_imp = 0;
$manzanillo_exp = 0;

?>

<div class="row">
    <div class="col-7">
        <table class="table">
            <tr class="bg-dark">
                <th class="text-white">Sucursal</th>
                <th class="text-white">Tipo</th>
                <th class="text-white">Total</th>
            </tr>
            <?php
            $totalByStore = array();

            foreach ($groupedData as $store_id => $types) :
                $storeTotal = 0;
            ?>
                <?php foreach ($types as $x_tipo_bel => $travelIds) : ?>
                    <?php $count = count($travelIds); ?>
                    <tr>
                        <td><?php echo $store_id; ?></td>
                        <?php $listado[] = $store_id; ?>
                        <td><?php echo $x_tipo_bel; ?></td>
                        <td><?php echo $count; ?></td>
                        <?php $cantidades[] = $count; ?>
                    </tr>
                    <?php
                    if ($store_id == '[VER] Veracruz (Matriz)' && $x_tipo_bel == 'single') {
                        $veracruz_imp = $count;
                    } else if ($store_id == '[VER] Veracruz (Matriz)' && $x_tipo_bel == 'full') {
                        $veracruz_exp = $count;
                    } else 

                    if ($store_id == '[MZN] Manzanillo (Sucursal)' && $x_tipo_bel == 'single') {
                        $manzanillo_imp = $count;
                    } else if ($store_id == '[MZN] Manzanillo (Sucursal)' && $x_tipo_bel == 'full') {
                        $manzanillo_exp = $count;
                    }

                    if ($store_id == '[MEX] México (Sucursal)' && $x_tipo_bel == 'single') {
                        $mexico_imp = $count;
                    } else if ($store_id == '[MEX] México (Sucursal)' && $x_tipo_bel == 'full') {
                        $mexico_exp = $count;
                    }
                    ?>
                    <?php $storeTotal += $count; ?>
                <?php endforeach; ?>
                <?php
                $totalByStore[$store_id] = $storeTotal;

                $listado_json = json_encode($listado);
                $cantidades_json = json_encode($cantidades);
                ?>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="col-5 d-flex justify-content-center align-items-center">
        <canvas id="myChart4"></canvas>
    </div>
</div>

<script>
    var labels = <?php echo $listado_json; ?>;
    var labels2 = <?php echo $cantidades_json; ?>;

    var ctx4 = document.getElementById('myChart4').getContext('2d');

    // Define los datos del gráfico
    var data4 = {
        labels: labels,
        datasets: [{
            label: 'IMP',
            data: labels2,
            backgroundColor: "#377dff",
            hoverBackgroundColor: "#377dff",
            borderColor: "#377dff",
        }, {
            label: 'EXP',
            data: labels2,
            backgroundColor: '#e7eaf3',
            borderColor: "#e7eaf3",
        }],
    };

    // Crea el gráfico de barras
    var myChart4 = new Chart(ctx4, {
        type: 'bar',
        data: data4,
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>