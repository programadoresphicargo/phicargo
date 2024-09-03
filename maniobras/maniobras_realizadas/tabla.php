<?php
require_once('getManiobras.php');

$ids = json_decode($json, true);
$ids2 = json_decode($json2, true);
?>

<div class="table-responsive">
    <table class="js-datatable table table-thead-bordered table-align-middle table-hover table-sm" id="tablamaniobras">
        <thead class="thead-light">
            <tr class="text-center">
                <th>ID Maniobra</th>
                <th>Operador</th>
                <th>Vehiculo</th>
                <th>Tipo movimiento</th>
                <th>Contenedor 1</th>
                <th>Contenedor 2</th>
                <th>Contenedor Anexo</th>
                <th>Inicio programado</th>
                <th>Peligroso</th>
                <th>Pago</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ids as $item) : ?>
                <tr>
                    <td class="id"><?php echo $item['id']; ?></td>
                    <td><?php echo $item['x_mov_ingreso_bel_id'][1]; ?></td>
                    <td><?php echo isset($item['x_eco_ingreso_id'][1]) ? $item['x_eco_ingreso_id'][1] : ''; ?></td>
                    <td class="tipo_maniobra"><?php echo 'Ingreso' ?></td>
                    <td style="max-width: 10px;"><?php echo $item['x_reference']; ?></td>
                    <td style="max-width: 10px;">
                        <?php
                        if ($item['x_enlace_cp'] == true) {
                            $kwargs = ['fields' => ['x_reference']];

                            $ids = $models->execute_kw(
                                $db,
                                $uid,
                                $password,
                                'tms.waybill',
                                'search_read',
                                array(array(
                                    (array('travel_id', '=', $item['travel_id'][0])),
                                    (array('id', '!=', $item['id'])),
                                ),),
                                $kwargs
                            );

                            $json = json_encode($ids);
                            $array = json_decode($json, true);
                            foreach ($array as $objeto) {
                                echo $objeto['x_reference'];
                                $pago = 'FULL';
                            }
                        } else {
                            $pago = 'SENCILLO';
                        } ?>
                    </td>
                    <td style="max-width: 10px;">
                        <?php
                        if ($item['x_cp_enlazada'] != false) {
                            $kwargs = ['fields' => ['x_reference']];

                            $ids = $models->execute_kw(
                                $db,
                                $uid,
                                $password,
                                'tms.waybill',
                                'search_read',
                                array(array(
                                    (array('id', '=', $item['x_cp_enlazada'][0])),
                                ),),
                                $kwargs
                            );

                            $json = json_encode($ids);
                            $array = json_decode($json, true);
                            foreach ($array as $objeto) {
                                echo $objeto['x_reference'];
                                $pago = 'FULL';
                            }
                        } else {
                            $pago = 'SENCILLO';
                        } ?>
                    </td>
                    <td><?php echo $item['x_inicio_programado_ingreso']; ?></td>
                    <td class="peligroso"><?php echo $item['dangerous_cargo'] == true ? 'SI' : 'NO' ?></td>
                    <td><?php echo $pago; ?></td>
                    <td class="status"><?php echo $item['x_ingreso_pagado'] == 1 ?  'Pagado' : '' ?></td>
                </tr>
            <?php endforeach; ?>

            <?php foreach ($ids2 as $item) : ?>
                <tr>
                    <td class="id"><?php echo $item['id']; ?></td>
                    <td><?php echo $item['x_operador_retiro_id'][1]; ?></td>
                    <td><?php echo isset($item['x_eco_retiro_id'][1]) ? $item['x_eco_retiro_id'][1] : ''; ?></td>
                    <td class="tipo_maniobra"><?php echo 'Retiro' ?></td>
                    <td style="max-width: 12px;"><?php echo $item['x_reference']; ?></td>
                    <td style="max-width: 10px;">
                        <?php
                        if ($item['x_solicitud_enlazada'] != false) {
                            $kwargs = ['fields' => ['x_reference']];

                            $ids = $models->execute_kw(
                                $db,
                                $uid,
                                $password,
                                'tms.waybill',
                                'search_read',
                                array(array(
                                    (array('id', '=', $item['x_solicitud_enlazada'][0])),
                                ),),
                                $kwargs
                            );

                            $json = json_encode($ids);
                            $array = json_decode($json, true);
                            foreach ($array as $objeto) {
                                echo $objeto['x_reference'];
                                $pago = 'FULL';
                            }
                        } else {
                        } ?>
                    </td>
                    <td>
                    </td>
                    <td><?php echo $item['x_inicio_programado_retiro']; ?></td>
                    <td class="peligroso"><?php echo $item['dangerous_cargo'] == true ? 'SI' : 'NO'  ?></td>
                    <td><?php echo $pago ?></td>
                    <td class="status"><?php echo $item['x_retiro_pagado'] == 1 ?  'Pagado' : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#tablamaniobras').DataTable({
        order: [
            [7, "asc"]
        ],
        paging: false,
        dom: 'Bfrtlip',
        buttons: [{
                extend: 'pdfHtml5',
                text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-sm btn-danger',
            },
            {
                extend: 'excelHtml5',
                text: 'Exel <i class="bi bi-filetype-exe"></i>',
                titleAttr: 'Exportar a Exel',
                className: 'btn btn-sm btn-success'
            },
            {
                extend: 'print',
                text: 'Impresion <i class="bi bi-printer"></i>',
                className: 'btn btn-sm btn-primary',
                exportOptions: {
                    columns: ':visible'
                }
            },
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
            [30, 40, 50, -1],
            [30, 40, 50, "All"]
        ]
    });
</script>