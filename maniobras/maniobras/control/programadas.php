<?php
require_once('../../odoo/odoo-conexion.php');

if (isset($_POST['fecha'])) {
    $fecha_inicial = $_POST['fecha'] . ' 00:00:00';
    $fecha_final = $_POST['fecha'] . ' 23:59:59';
} else {
    $fechaHoraActual = date('Y-m-d');
    $fecha_inicial = $fechaHoraActual . ' 00:00:00';
    $fecha_final = $fechaHoraActual . ' 23:59:59';
}

$kwargs = ['fields' => ['name', 'x_reference', 'x_operador_retiro_id', 'x_mov_bel', 'x_eco_retiro_id', 'x_inicio_programado_retiro', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_status_maniobra_retiro', 'x_tipo_terminal_retiro', 'x_ejecutivo_viaje_bel', 'x_status_maniobra_ingreso', 'x_mov_ingreso_bel_id', 'x_eco_ingreso_id', 'x_terminal_bel', 'x_eco_bel_id', 'x_status_maniobra_retiro', 'x_status_maniobra_ingreso', 'x_inicio_programado_ingreso', 'travel_id', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso', 'x_reference_2', 'x_programo_retiro_usuario', 'x_programo_retiro_fecha'], 'order' => 'x_inicio_programado_retiro desc'];
$kwargs2 = ['fields' => ['name', 'x_reference', 'x_operador_retiro_id', 'x_mov_bel', 'x_eco_retiro_id', 'x_inicio_programado_retiro', 'x_remolque_1_retiro', 'x_remolque_2_retiro', 'x_dolly_retiro', 'x_status_maniobra_retiro', 'x_tipo_terminal_retiro', 'x_ejecutivo_viaje_bel', 'x_status_maniobra_ingreso', 'x_mov_ingreso_bel_id', 'x_eco_ingreso_id', 'x_terminal_bel', 'x_eco_bel_id', 'x_status_maniobra_ingreso', 'x_inicio_programado_ingreso', 'travel_id', 'x_remolque_1_ingreso', 'x_remolque_2_ingreso', 'x_dolly_ingreso', 'x_reference_2', 'x_programo_ingreso_usuario', 'x_programo_ingreso_fecha'], 'order' => 'x_inicio_programado_ingreso desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_programo_retiro_fecha', '>=', $fecha_inicial),
        array('x_programo_retiro_fecha', '<=', $fecha_final),
    ),),
    $kwargs
);

$retiros = $ids;

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('x_programo_ingreso_fecha', '>=',  $fecha_inicial),
        array('x_programo_ingreso_fecha', '<=',  $fecha_final),
    ),),
    $kwargs2
);

$ingresos = $ids;

function removeDuplicateTravelIds($data)
{
    $uniqueTravelIds = array();
    $uniqueData = array();

    foreach ($data as $item) {
        if (isset($item['travel_id'])) {
            $travelId = $item['travel_id'];

            if ($travelId !== false || !in_array($travelId, $uniqueTravelIds)) {
                $uniqueData[] = $item;
                if ($travelId !== false) {
                    $uniqueTravelIds[] = $travelId;
                }
            }
        } else {
            $uniqueData[] = $item;
        }
    }

    return $uniqueData;
}

$finalRetiros = $retiros;
$finalIngresos = removeDuplicateTravelIds($ingresos);

$json = json_encode($finalRetiros);
file_put_contents('AHS.JSON', $json);
$datos = json_decode($json, true);

$json2 = json_encode($finalIngresos);
file_put_contents('AHS2.JSON', $json2);
$datos2 = json_decode($json2, true);

?>
<div class="table-responsive">
    <table class="table table-striped table-hover table-responsive table-xs" id="miTabla5">
        <thead>
            <tr class="">
                <th>Carta Porte / Solicitud</th>
                <th>Tipo de maniobra</th>
                <th>Inicio programado</th>
                <th>Ejecutivo</th>
                <th>Terminal</th>
                <th>Unidad</th>
                <th>Operador</th>
                <th>Contenedor 1</th>
                <th>Contenedor 2</th>
                <th>Remolque 1</th>
                <th>Remolque 2</th>
                <th>Dolly</th>
                <th>Programada por</th>
                <th>Fecha programación</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $item) { ?>

                <tr data-id="<?php echo $item['id'] ?>">
                    <td><?php echo $item['name'] != false ? $item['id'] . ' /' . $item['name'] : $item['id'] ?></td>
                    <td><span class="badge bg-warning"><?php echo 'Retiro de terminal' ?></span></td>
                    <td data-columna=""><?php echo $item['x_inicio_programado_retiro'] ?></td>
                    <td data-columna=""><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                    <td data-columna=""><?php echo $item['x_mov_bel'] ?></td>
                    <td data-columna=""><?php echo $item['x_eco_retiro_id'] != null ? '<span class="badge bg-primary rounded-pill">' . $item['x_eco_retiro_id'][1] . '</span>' : 'No definido'  ?></td>
                    <td data-columna=""><?php echo $item['x_operador_retiro_id'] != false ? $item['x_operador_retiro_id'][1] : 'No definido' ?></td>
                    <td data-columna=""><?php echo $item['x_reference'] ?></td>
                    <td data-columna=""><?php echo $item['x_reference_2'] ?></td>
                    <td data-columna=""><?php echo $item['x_remolque_1_retiro'] != null ? $item['x_remolque_1_retiro'][1] : ''  ?></td>
                    <td data-columna=""><?php echo $item['x_remolque_2_retiro'] != null ? $item['x_remolque_2_retiro'][1] : '' ?></td>
                    <td data-columna=""><?php echo $item['x_dolly_retiro'] != null ? $item['x_dolly_retiro'][1] : '' ?></td>
                    <td data-columna=""><span class="badge bg-dark"><?php echo $item['x_programo_retiro_usuario'] ?></span></td>
                    <td data-columna=""><?php echo $item['x_programo_retiro_fecha'] ?></td>
                    <td data-columna="">
                        <?php if ($item['x_status_maniobra_retiro'] == 'borrador') { ?>
                            <span class="badge bg-warning rounded-pill"> <?php echo $item['x_status_maniobra_retiro'];  ?></span>
                        <?php } else { ?>
                            <?php echo $item['x_status_maniobra_retiro'];  ?>
                        <?php } ?>
                    </td>
                </tr>

            <?php } ?>

            <?php foreach ($datos2 as $item) { ?>

                <tr data-id="<?php echo $item['id'] ?>">
                    <td><?php echo $item['name'] != false ? $item['id'] . ' /' . $item['name'] : $item['id'] ?></td>
                    <td><span class="badge bg-success"><?php echo 'Ingreso en terminal' ?></span></td>
                    <td data-columna=""><?php echo $item['x_inicio_programado_ingreso'] ?></td>
                    <td data-columna=""><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                    <td data-columna=""><?php echo $item['x_terminal_bel'] ?></td>
                    <td data-columna=""><?php echo $item['x_eco_ingreso_id']  != null ? '<span class="badge bg-primary rounded-pill">' . $item['x_eco_ingreso_id'][1] . '</span>' : 'No definido' ?></td>
                    <td data-columna=""><?php echo $item['x_mov_ingreso_bel_id']  != false ? $item['x_mov_ingreso_bel_id'][1] : 'No definido'  ?></td>
                    <td data-columna=""><?php echo $item['x_reference'] ?></td>
                    <?php

                    $kwargs5 = ['fields' => ['travel_id', 'id', 'x_reference'], 'order' => 'x_inicio_programado_retiro desc'];

                    $ids5 = $models->execute_kw(
                        $db,
                        $uid,
                        $password,
                        'tms.waybill',
                        'search_read',
                        array(array(
                            array('travel_id', '=',  $item['travel_id'][0]),
                            array('x_reference', '!=',  $item['x_reference']),
                            array('x_enlace_cp', '=',  true),
                        ),),
                        $kwargs5
                    );

                    $json5 = json_encode($ids5);
                    $data5 = json_decode($json5, true);
                    ?>
                    <td><?php
                        foreach ($data5 as $item5) { ?>
                            <?php echo $item5['x_reference'] != null ? $item5['x_reference'] : ''  ?>
                        <?php } ?>

                    <td data-columna=""><?php echo $item['x_remolque_1_ingreso'] != null ? $item['x_remolque_1_ingreso'][1] : ''  ?></td>
                    <td data-columna=""><?php echo $item['x_remolque_2_ingreso'] != null ? $item['x_remolque_2_ingreso'][1] : '' ?></td>
                    <td data-columna=""><?php echo $item['x_dolly_ingreso'] != null ? $item['x_dolly_ingreso'][1] : '' ?></td>
                    <td data-columna=""><span class="badge bg-dark"><?php echo $item['x_programo_ingreso_usuario'] ?></span></td>
                    <td data-columna=""><?php echo $item['x_programo_ingreso_fecha'] ?></td>
                    <td data-columna="">
                        <?php if ($item['x_status_maniobra_ingreso'] == 'borrador') { ?>
                            <span class="badge bg-secondary rounded-pill"> <?php echo $item['x_status_maniobra_ingreso'];  ?></span>
                        <?php } else { ?>
                            <?php echo $item['x_status_maniobra_ingreso'];  ?>
                        <?php } ?>
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>
</div>

<script>
    $('#miTabla5').on('click', 'tr', function() {
        var dataId = $(this).data('id');
        if ($.isNumeric(dataId)) {
            $("#detalles_maniobra").offcanvas("show");

            $('#cargadiv5').show();
            $("#contenidomaniobracanvas").load('../maniobra/index.php', {
                'id': dataId
            }, function() {
                $('#cargadiv5').hide();
            });

        }
    });
</script>

<script>
    $('#miTabla5').DataTable({
        "order": [
            [2, "desc"]
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": " Primero ",
                "last": " Ultimo ",
                "next": " Proximo ",
                "previous": " Anterior  "
            }
        },
        "lengthMenu": [
            [20, 25, 30, 40, 50, -1],
            [20, 25, 30, 40, 50, "All"]
        ]
    });
</script>