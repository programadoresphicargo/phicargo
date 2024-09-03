<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$operadorup = $_POST['operadorup'];
$fecha_actual = date("Y-m-d");
if (isset($_POST['fecha'])) {
    $fecha_actual = $_POST['fecha'];
} else {
    $fecha_actual = date('Y-m-d');
}

if ($_POST['sucursalup'] == 'veracruz') {
    $sucursal = 1;
} elseif ($_POST['sucursalup'] == 'manzanillo') {
    $sucursal = 9;
}

require_once('../../odoo/odoo-conexion.php');

$domain2 = [
    [
        ['id', '=', $operadorup],
    ]
];

$kwargs2 = ['fields' => ['id', 'name', 'x_modalidad', 'x_peligroso_lic', 'tms_driver_license_type']];

$records2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'hr.employee',
    'search_read',
    $domain2,
    $kwargs2
);

$json2 = json_encode($records2);
$datos2 = json_decode($json2, true);
file_put_contents('ahs3.json', $json2);

foreach ($datos2 as $item2) {
    $id_operador = $item2['id'];
    $nombre = $item2['name'];
    $modalidad = $item2['x_modalidad'];
    $peligroso = $item2['x_peligroso_lic'];
    $tipo_licencia = $item2['tms_driver_license_type'];
}

if ($modalidad == 'full') {
    $domain = [
        [
            ['name', '=', false],
            ['date_order', '=', $fecha_actual],
            ['x_tipo_bel', '=', ['full', 'single']],
            ['x_operador_bel_id', '=', false],
            ['store_id', '=', $sucursal],
            ['state', '!=', 'cancel'],
        ]
    ];
} else {
    $domain = [
        [
            ['name', '=', false],
            ['date_order', '=', $fecha_actual],
            ['x_tipo_bel', '=', 'single'],
            ['x_operador_bel_id', '=', false],
            ['store_id', '=', $sucursal],
            ['state', '!=', 'cancel'],
        ]
    ];
}

$kwargs = ['fields' => ['id', 'name', 'date_order', 'x_eco_bel_id', 'x_ejecutivo_viaje_bel',  'partner_id', 'x_tipo_bel', 'x_tipo2_bel', 'x_modo_bel', 'dangerous_cargo', 'date_start', 'x_ruta_bel', 'x_operador_bel_id', 'x_custodia_bel', 'x_date_arrival_shed', 'store_id'], 'order' => 'date_order asc'];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    $kwargs
);

$json = json_encode($records);
$datos = json_decode($json, true);
file_put_contents('ahs.json', $json);

?>

<div class="row justify-content-md-between mb-3">
    <div class="col-md">
        <h4>Nombre del operador:</h4>
        <h4><?php echo '(' . $id_operador . ') ' . $nombre ?></h4>
        <!-- Flatpickr -->
        <input id="fecha" type="text" class="js-flatpickr form-control form-control-sm flatpickr-custom" placeholder="Seleccionar fecha" value="<?php echo $fecha_actual ?>">
        <!-- End Flatpickr -->

    </div>
    <!-- End Col -->

    <div class="col-md text-md-end">
        <dl class="row">
            <dt class="col-sm-8">Tipo licencia:</dt>
            <dd class="col-sm-4"><?php echo $tipo_licencia ?></dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-8">Peligroso:</dt>
            <dd class="col-sm-4"><?php echo $peligroso ?></dd>
        </dl>
        <dl class="row">
            <dt class="col-sm-8">Modalidad:</dt>
            <dd class="col-sm-4">
                <?php if ($modalidad == 'full') { ?>
                    <td><span class="badge bg-danger rounded-pill"><?php echo 'FULLERO' ?></span></td>
                <?php } else if ($modalidad == 'single') { ?>
                    <td><span class="badge bg-success rounded-pill"><?php echo 'SENCILLERO' ?></span></td>
                <?php   } else { ?>
                    <td><?php echo 'No definido' ?></td>
                <?php } ?>
            </dd>
        </dl>
    </div>
    <!-- End Col -->
</div>
<!-- End Row -->

<?php if ($modalidad != false || $peligroso != false) { ?>
    <div class="table-responsive">
        <table class="table table-hover table-xs" id="tabla-datos">
            <thead class="thead-light">
                <tr class="">
                    <th>Solicitud de transporte</th>
                    <th>Ejecutivo</th>
                    <th>Cliente</th>
                    <th>ECO</th>
                    <th>Inicio Ruta Prog.</th>
                    <th>Llegada a Planta Prog.</th>
                    <th>Ruta</th>
                    <th>Tipo Armado</th>
                    <th>Tipo Carga</th>
                    <th>Modo</th>
                    <th>Peligroso</th>
                    <th>Custodia</th>
                    <th>Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($datos as $item) { ?>
                    <tr data-id="<?php echo $item['id'] ?>">
                        <td><?php echo $item['id'] ?></td>
                        <td><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                        <td><?php echo $item['partner_id'][1] ?></td>
                        <td><?php echo $item['x_eco_bel_id']  != false ? $item['x_eco_bel_id'][1] : ''  ?></td>

                        <?php
                        if ($item['date_start'] != false) {;
                            $IST = new DateTime($item['date_start'], new DateTimeZone('UTC'));
                            $IST->setTimezone(new DateTimeZone('America/Mexico_city'));
                        ?>
                            <td><?php echo $IST->format('Y-m-d H:i:s'); ?></td>
                        <?php } else {  ?>
                            <td></td>
                        <?php } ?>

                        <?php
                        if ($item['x_date_arrival_shed'] != false) {;
                            $arrival = new DateTime($item['x_date_arrival_shed'], new DateTimeZone('UTC'));
                            $arrival->setTimezone(new DateTimeZone('America/Mexico_city'));
                        ?>
                            <td><?php echo $arrival->format('Y-m-d H:i:s'); ?></td>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>

                        <td><?php echo $item['x_ruta_bel'] ?></td>

                        <?php if ($item['x_tipo_bel'] == 'full') { ?>
                            <td><span class="badge bg-danger rounded-pill"><?php echo 'FULL' ?></span></td>
                        <?php } else if ($item['x_tipo_bel'] == 'single') { ?>
                            <td><span class="badge bg-success rounded-pill"><?php echo 'SENCILLO' ?></span></td>
                        <?php   } else { ?>
                            <td><?php echo 'No definido' ?></td>
                        <?php } ?>

                        <?php if ($item['x_tipo2_bel'] == 'Cargado') { ?>
                            <td><?php echo 'CARGADO' ?></td>
                        <?php } else if ($item['x_tipo2_bel'] == 'Vacio') { ?>
                            <td><?php echo 'VACIO' ?></td>
                        <?php   } else { ?>
                            <td><?php echo 'No definido' ?></td>
                        <?php } ?>

                        <?php if ($item['x_modo_bel'] == 'exp') { ?>
                            <td><?php echo 'EXP' ?></td>
                        <?php } else if ($item['x_modo_bel'] == 'imp') { ?>
                            <td><?php echo 'IMP' ?></td>
                        <?php   } else { ?>
                            <td><?php echo 'No definido' ?></td>
                        <?php } ?>

                        <?php if ($item['dangerous_cargo'] == true) { ?>
                            <td><?php echo 'PELIGROSO' ?></td>
                        <?php } else if ($item['dangerous_cargo'] == false) { ?>
                            <td><?php echo 'No definido' ?></td>
                        <?php   } else { ?>
                            <td><?php echo 'No definido' ?></td>
                        <?php } ?>

                        <?php if ($item['x_custodia_bel'] == 'yes') { ?>
                            <td><?php echo 'SI' ?></td>
                        <?php } else if ($item['x_custodia_bel'] == 'no') { ?>
                            <td><?php echo 'NO' ?></td>
                        <?php } else { ?>
                            <td><?php echo 'No definido' ?></td>
                        <?php } ?>

                        <td><button class="btn btn-primary btn-xs" onclick="asignar_viaje('<?php echo $item['id'] ?>','<?php echo $id_operador ?>')">Seleccionar</button></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-items-center" style="height: 60vh;">
                <div>
                    <h1>Información de licencia incompleta.</h1>
                    <p>Rellena los datos de licencia en Odoo para proceder con la asignación.</p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="modal fade" id="confirmar_asignacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar asignación de viaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Realmente quieres confirmar el viaje asignado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button onclick="confirmar_viaje()" type="button" class="btn btn-primary btn-sm">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#tabla-datos').DataTable({
        dom: 'Bfrtlip',
        buttons: [{
                extend: 'pdfHtml5',
                text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-primary btn-xs',
            },
            {
                extend: 'excelHtml5',
                text: 'Exel <i class="bi bi-filetype-exe"></i>',
                titleAttr: 'Exportar a Exel',
                className: 'btn btn-primary btn-xs'
            },
            {
                extend: 'print',
                text: 'Impresion <i class="bi bi-printer"></i>',
                className: 'btn btn-primary btn-xs',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        /*
        columnDefs: [ {
            targets: -1,
            visible: false
        } ],*/
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

    if ('<?php echo $peligroso ?>' == '' || '<?php echo $modalidad ?>' == '') {
        notyf.error('Información de licencia incompleta.');
    }

    $("#fecha").flatpickr({
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            $.ajax({
                type: 'POST',
                url: '../asignacion_viaje/tabla.php',
                data: {
                    'operadorup': <?php echo $operadorup ?>,
                    'fecha': dateStr,
                    'sucursalup': '<?php echo $_POST['sucursalup'] ?>',
                },
                success: function(data) {
                    $('#viajes_disponibles').html(data);
                },
                error: function() {
                    notyf.error('Error en la solicitud AJAX');
                }
            });
        }
    });

    var id_viaje_select;
    var id_operador_select;

    function asignar_viaje(id_viaje, id_operador) {
        $("#confirmar_asignacion").modal('show');
        id_viaje_select = id_viaje;
        id_operador_select = id_operador;
    }

    function confirmar_viaje() {
        $.ajax({
            url: '../asignacion_viaje/asignar_odoo.php',
            data: {
                'id_operador': id_operador_select,
                'id_viaje': id_viaje_select
            },
            type: 'POST',
            success: function(data) {
                if (data == 1) {
                    notyf.success('Viaje asignado correctamente');
                    $("#confirmar_asignacion").modal('hide');
                    $("#asignacion_viaje_canvas").offcanvas('hide');
                    $("#modal_editar_turno").modal('hide');

                    unidadup.disabled = false;
                    operadorup.disabled = false;
                    fechaup.disabled = false;
                    horaup.disabled = false;
                    comentariosup.disabled = false;

                    datos5 = $("#FormEditar").serialize();
                    console.log(datos5);
                    $.ajax({
                        type: "POST",
                        data: datos5,
                        url: "../codigos/archivar.php",
                        success: function(respuesta) {
                            if (respuesta == 1) {
                                $.ajax({
                                    type: "POST",
                                    data: {
                                        sucursal: $("#sucursal").val()
                                    },
                                    url: "../codigos/tabla.php",
                                    success: function(respuesta) {
                                        $("#tabla").html(respuesta);
                                    }
                                });
                                notyf.success('Turno archivado.');
                            } else {
                                notyf.error('Error 5.');
                            }
                        }
                    });

                } else {
                    notyf.success('Existe un error en la validacion de la información: ' + data);
                }
            },
            error: function() {
                notyf.error('Error en la solicitud AJAX');
            }
        });
    }
</script>