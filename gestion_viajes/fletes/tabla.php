<?php
require_once('getCP.php');
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');
require_once('../../tiempo/conversiones.php');
require_once('detenciones.php');
require_once('distancia.php');

function calcularDiferenciaTiempo($fecha_salida, $fecha_llegada, $limite)
{
    $fecha_salida = $fecha_salida ?? date('Y-m-d H:i:s');
    $diferencia_segundos = strtotime($fecha_llegada) - strtotime($fecha_salida);
    $limite_segundos = strtotime($limite);

    if ($diferencia_segundos > $limite_segundos) {
        $diferencia_horas = gmdate("H:i", $diferencia_segundos - $limite_segundos);
        return  '<span class="badge bg-danger rounded-pill">' . $diferencia_horas . '</span>';
    } else {
        return '<span class="badge bg-success rounded-pill">No</span>';
    }
}

$cn = conectar();
$cps = json_decode($json2, true);

?>
<table class="table table-align-middle table-hover table-sm" id="tabla-datos">
    <thead class="thead-light">
        <tr class="ignorar">
            <th class="text-center" scope="col">Sucursal</th>
            <th class="text-center" scope="col">Referencia</th>
            <th class="text-center" scope="col">Estado</th>
            <th class="text-center" scope="col">Último status enviado por correo</th>
            <th class="text-center" scope="col">Distancia</th>
            <th class="text-center" scope="col">Tipo de armado</th>
            <th class="text-center" scope="col">Medida contenedores</th>
            <th class="text-center" scope="col">Contenedores</th>
            <th class="text-center" scope="col">Ejecutivo</th>
            <th class="text-center" scope="col">Operador</th>
            <th class="text-center" scope="col">Unidad</th>
            <th class="text-center" scope="col">Tiempo Patio a Planta</th>
            <th class="text-center" scope="col">Detenido patio a planta</th>
            <th class="text-center" scope="col">Estadías h:min</th>
            <th class="text-center" scope="col">Tiempo Planta a Patio</th>
            <th class="text-center" scope="col">Detenido planta a patio</th>
            <th class="text-center" scope="col">Ruta</th>
            <th class="text-center" scope="col">Tipo</th>
            <th class="text-center" scope="col">Inicio programado</th>
            <th class="text-center" scope="col">Llegada a planta programada</th>
            <th class="text-center" scope="col">Cliente</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $uniqueValues = array();

        foreach ($cps as $cp) {
            $travelId = $cp['travel_id'][1];

            if (!in_array($travelId, $uniqueValues)) {
                $uniqueValues[] = $travelId; ?>

                <tr onclick="onRowClick(this)" travelid="<?php echo $cp['travel_id'][1] ?>" id="<?php echo $cp['travel_id'][0]  ?>" id_cliente="<?php echo $cp['partner_id'][0]  ?>" codigo_postal="<?php echo $cp['x_codigo_postal'] ?>" status="<?php echo $cp['x_status_viaje'] ?>">

                    <td class="openstatus"><?php echo $cp['store_id'][1] ?></td>

                    <td class="openentrega"><span class="d-block h5 mb-0"><?php echo $cp['travel_id'] != false ? $cp['travel_id'][1] : '' ?></span></td>

                    <?php if ($cp['x_status_viaje'] == 'ruta') { ?>
                        <td class="openentrega"><span class="badge bg-primary rounded-pill">En Ruta</span></td>
                    <?php } else if ($cp['x_status_viaje'] == 'planta') { ?>
                        <td class="openentrega"><span class="badge bg-success rounded-pill">En Planta</span></td>
                    <?php } else if ($cp['x_status_viaje'] == 'retorno') { ?>
                        <td class="openentrega"><span class="badge bg-warning rounded-pill">Retorno</span></td>
                    <?php } else if ($cp['x_status_viaje'] == 'resguardo') { ?>
                        <td class="openentrega"><span class="badge bg-morado rounded-pill">Resguardo</span></td>
                    <?php } else if ($cp['x_status_viaje'] == false) { ?>
                        <td class="openentrega"><span class="badge bg-secondary rounded-pill">Disponible</span></td>
                    <?php } else if ($cp['x_status_viaje'] == 'finalizado') { ?>
                        <td class="openentrega"><span class="badge bg-primary rounded-pill">Finalizado</span></td>
                    <?php } else { ?>
                        <td class="openentrega"><?php echo $cp['x_status_viaje'] ?></td>
                    <?php }

                    if ($cp['x_status_viaje'] == 'ruta' || $cp['x_status_viaje'] == 'planta' || $cp['x_status_viaje'] == 'retorno') {
                        $id = $cp['travel_id'][0];
                        $sql = "SELECT * from reportes_estatus_viajes inner join status on status.id_status = reportes_estatus_viajes.id_estatus left join empleados on empleados.id = reportes_estatus_viajes.id_usuario left join usuarios on usuarios.id_usuario = reportes_estatus_viajes.id_usuario where id_viaje = $id order by fecha_envio desc limit 1";
                        $r = $cn->query($sql);
                        $ro = $r->fetch_assoc(); ?>
                        <td class="openstatus">
                            <?php if ($ro['id_usuario'] == 8) { ?>
                                <span style="white-space: normal; width:130px" class="badge bg-primary fw-bold animate__animated animate__pulse rounded-pill"><?php echo $ro['status'] ?></span><br>
                                <?php if (isset($ro['fecha_envio'])) { ?>
                                    <p class="text-muted"><?php imprimirTiempo(($ro['fecha_envio'])) ?></p>
                                <?php  } ?>
                            <?php
                            } else if ($ro['name'] == NULL) { ?>
                                <span style="white-space: normal; width:130px" class="badge bg-morado fw-bold animate__animated animate__pulse rounded-pill"><?php echo $ro['status'] ?></span><br>
                                <?php if (isset($ro['fecha_envio'])) { ?>
                                    <p class="text-muted"><?php imprimirTiempo(($ro['fecha_envio'])) ?></p>
                                <?php  } ?>
                            <?php
                            } else { ?>
                                <span style="white-space: normal; width:130px" class="badge bg-success fw-bold animate__animated animate__pulse rounded-pill"><?php echo $ro['status'] ?></span><br>
                                <?php if (isset($ro['fecha_envio'])) { ?>
                                    <p class="text-muted"><?php imprimirTiempo(($ro['fecha_envio'])) ?></p>
                                <?php  } ?>
                            <?php
                            } ?>
                        </td>
                    <?php } else { ?>
                        <td class="openstatus">
                        </td>
                    <?php } ?>

                    <?php
                    if (isset($cp['vehicle_id'][1])) {
                        $cadena = explode(" ", $cp['vehicle_id'][1]);
                        $plates = str_replace(["[", "]"], "", $cadena[1]);
                    }
                    ?>

                    <td class='distancia text-center'>
                        <?php if ($cp['x_status_viaje'] == 'ruta' || $cp['x_status_viaje'] == 'planta' || $cp['x_status_viaje'] == 'retorno') { ?>
                            <?php echo calcular_distancia($plates, $cp['x_codigo_postal'], $cp['x_status_viaje'], $cp['store_id'][1]); ?>
                        <?php } ?>
                    </td>

                    <td class="openstatus"><?php echo $cp['x_tipo_bel'] == 'single' ? '<span class="badge bg-warning rounded-pill">SENCILLO</span>' : '<span class="badge bg-danger rounded-pill">FULL</span>' ?></td>
                    <td class="openstatus"><?php echo $cp['x_medida_bel'] != false ? $cp['x_medida_bel'] : '' ?></td>
                    <td class="openstatus"><?php echo $cp['x_reference'] != false ? $cp['x_reference'] : '' ?></td>
                    <td class="openstatus"><?php echo $cp['x_ejecutivo_viaje_bel'] != false ? $cp['x_ejecutivo_viaje_bel'] : '' ?></td>
                    <td class="openstatus"><?php echo $cp['x_operador_bel_id'] != false ? $cp['x_operador_bel_id'][1] : '' ?></td>
                    <td class="open_detencion"><?php echo $cp['vehicle_id'] != false ? $cp['vehicle_id'][1] : '' ?></td>

                    <?php
                    if ($cp['x_status_viaje'] == 'ruta' || $cp['x_status_viaje'] == 'planta' || $cp['x_status_viaje'] == 'retorno') {
                        $sql = "SELECT * FROM reportes_estatus_viajes WHERE id_viaje = $id order by fecha_envio asc";
                        $result = $cn->query($sql);

                        $inicioViajeFecha = null;
                        $llegadaPlantaFecha = null;
                        $salidaPlantaFecha = null;
                        $finViajeFecha = null;

                        while ($row = $result->fetch_assoc()) {
                            $id_estatus = $row['id_estatus'];
                            $fechaHora = $row['fecha_envio'];

                            if ($id_estatus == 1 && (!$inicioViajeFecha || $fechaHora < $inicioViajeFecha)) {
                                $inicioViajeFecha = $fechaHora;
                            } else if ((($id_estatus == 3 || $id_estatus == 4)) && (!$llegadaPlantaFecha || $fechaHora < $llegadaPlantaFecha)) {
                                $llegadaPlantaFecha = $fechaHora;
                            } else if ($id_estatus == 8 && (!$salidaPlantaFecha || $fechaHora < $salidaPlantaFecha)) {
                                $salidaPlantaFecha = $fechaHora;
                            } else if ($id_estatus == 103 && (!$finViajeFecha || $fechaHora < $finViajeFecha)) {
                                $finViajeFecha = $fechaHora;
                            }
                        }
                    ?>

                        <?php if ($inicioViajeFecha != null ||  $llegadaPlantaFecha != null) { ?>
                            <td class="openalertas"><span class="badge bg-primary text-white"><i class="bi bi-clock"></i> <?php echo getMinutosTotal($inicioViajeFecha, $llegadaPlantaFecha) ?></span></td>
                        <?php } else { ?>
                            <td class="openalertas"></td>
                        <?php } ?>

                        <?php if ($inicioViajeFecha  != null ||  $llegadaPlantaFecha  != null) { ?>
                            <td class="openalertas"><span class="badge bg-soft-secondary text-dark"><i class="bi bi-clock"></i> <?php echo getMinutos($plates, $inicioViajeFecha, $llegadaPlantaFecha) ?></span></td>
                        <?php } else { ?>
                            <td class="openalertas"></td>
                        <?php } ?>

                        <?php if ($cp['x_status_viaje'] == 'planta' || $cp['x_status_viaje'] == 'retorno') { ?>
                            <td class="openalertas">
                                <?php
                                $partner_id = $cp['partner_id'][0];
                                $fecha_envio_salida = $salidaPlantaFecha;
                                $fecha_envio_llegada = $llegadaPlantaFecha;

                                $resultado = '';
                                switch ($partner_id) {
                                    case 107800:
                                    case 112577:
                                        $limite = '24:00:00';
                                        $resultado = calcularDiferenciaTiempo($fecha_envio_salida, $fecha_envio_llegada, $limite);
                                        break;
                                    case 108015:
                                        $limite = '12:00:00';
                                        $resultado = calcularDiferenciaTiempo($fecha_envio_salida, $fecha_envio_llegada, $limite);
                                        break;
                                    default:
                                        $limite = '08:00:00';
                                        $resultado = calcularDiferenciaTiempo($fecha_envio_salida, $fecha_envio_llegada, $limite);
                                        break;
                                }
                                echo $resultado;
                                ?>
                            </td> <?php } else { ?>
                            <td class="openalertas"></td>
                        <?php } ?>

                        <?php if ($salidaPlantaFecha != null || $finViajeFecha != null) { ?>
                            <td class="openstatus"><span class="badge bg-success text-white"><i class="bi bi-clock"></i> <?php echo getMinutosTotal($salidaPlantaFecha, $finViajeFecha) ?></span></td>
                        <?php } else { ?>
                            <td class="openstatus"></td>
                        <?php } ?>

                        <?php if ($salidaPlantaFecha  != null ||  $finViajeFecha != null) { ?>
                            <td class="openstatus"><span class="badge bg-soft-secondary text-dark"><i class="bi bi-clock"></i> <?php echo getMinutos($plates, $salidaPlantaFecha, $finViajeFecha) ?></span></td>
                        <?php } else { ?>
                            <td class="openstatus"></td>
                        <?php } ?>

                    <?php } else { ?>
                        <td class="openstatus"></td>
                        <td class="openstatus"></td>
                        <td class="openstatus"></td>
                        <td class="openstatus"></td>
                        <td class="openstatus"></td>
                    <?php  } ?>


                    <td class="openstatus"><?php echo $cp['route_id'] != false ? $cp['route_id'][1] : '' ?></td>

                    <?php if ($cp['x_modo_bel'] == 'imp') { ?>
                        <td class="openstatus"><span class="badge bg-warning">Imp</span></td>
                    <?php } else if ($cp['x_modo_bel'] == 'exp') { ?>
                        <td class="openstatus"><span class="badge bg-danger">Exp</span></td>
                    <?php } else { ?>
                        <td class="openstatus"></td>
                    <?php } ?>

                    <td class="openstatus"><?php echo $cp['date_start'] != false ? utctocst($cp['date_start']) : '' ?></td>
                    <td class="openstatus"><?php echo $cp['x_date_arrival_shed'] != false ? utctocst($cp['x_date_arrival_shed']) : '' ?></td>
                    <td class="openstatus"><?php echo $cp['partner_id'] != false ? $cp['partner_id'][1] : '' ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>

<script>
    var filaId;
    var status;
    var sucursal;
    var marker1, marker2;

    function onRowClick(row) {

        filaId = $(row).attr('id');
        status = $(row).attr('status');

        if ($(event.target).closest('td').hasClass('openstatus')) {

            $('#offcanvas_viaje').offcanvas('show');
            $('#cargadiv5').show();

            $('#contenido').hide();
            $("#contenido").load('../viaje/index.php?id=' + filaId, {
                'consulta': '<?php echo $_POST['consulta'] ?>'
            }, function() {
                $('#cargadiv5').hide();
                $('#contenido').show();
            });

            var filacliente = $(row).attr('id_cliente');
            var codigo_postal = $(row).attr('codigo_postal');

            placas_universal = $(row).find('td:eq(8)').text();
            sucursal = $(row).find('td:eq(5)').text();
            modo_universal = $(row).find('td:eq(15)').text();
            console.log(placas_universal);

        } else if ($(event.target).closest('td').hasClass('openentrega')) {
            console.log('caso 2');
            $('#entregaturnooffcanvas').offcanvas('show');
            $('#entregaviajeid').val(filaId);

            $("#listadoentregasviaje").load('../status/modal/entregas.php', {
                'id_viaje': filaId
            });

        } else if ($(event.target).closest('td').hasClass('openalertas')) {
            $('#alertasoffcanvas').offcanvas('show');
            placas_universal = $(row).find('td:eq(8)').text();

            $("#listado_alertas").load('../alertas/canvas/listado.php', {
                'id_viaje': filaId
            });

            $("#detenciones_tiempos").load('../alertas/canvas/detenciones_tiempos.php', {
                'id_viaje': filaId,
                'placas': placas_universal
            });

        } else if ($(event.target).closest('td').hasClass('distancia')) {

        } else if ($(event.target).closest('td').hasClass('open_detencion')) {
            alert();
        } else if ($(event.target).hasClass('ignorar')) {

        } else {
            console.log('caso 3');
            window.location.href = "../../gestion_viajes/viaje/index2.php?id=" + filaId;
        }
    }

    var flatpickrInstance = flatpickr("#rangoInput", {
        mode: "range",
        FormData: "y-m-d",
        onClose: function(selectedDates, dateStr, instance) {
            if (selectedDates[0] === selectedDates[0]) {
                console.log("PRIMERA OPCION");
            } else if (selectedDates[0] !== selectedDates[0]) {
                console.log("SEGUNDA OPCION");
            } else {
                console.log("La selección no es válida.");
            }
        }
    });

    var fechaInicio = null;
    var fechaFin = null;

    $("#borrar_fecha").on("click", function(e) {
        flatpickrInstance.setDate(null);

        var table2 = document.getElementById('tabla-datos');
        while (table2.rows.length > 1) {
            table2.deleteRow(1);
        }
        table2.innerHTML = contenidoOriginal;

        agruparTabla("tabla-datos", selectedOptions, null, null);
        fechaInicio = null;
        fechaFin = null;
    });

    function guardar_cp() {
        $('#tabla-datos tbody tr').each(function() {
            var codigoPostal = $(this).attr('codigo_postal');

            $.ajax({
                type: "POST",
                url: "../codigo_postal/comprobar.php",
                data: {
                    codigo_postal: codigoPostal,
                },
                success: function(respuesta) {
                    if (respuesta != 1) {

                        const geocoder = new google.maps.Geocoder();
                        const address = codigoPostal + ', Mexico';

                        geocoder.geocode({
                            address: address
                        }, (results, status) => {
                            if (status === google.maps.GeocoderStatus.OK) {
                                const location = results[0].geometry.location;
                                $.ajax({
                                    type: "POST",
                                    url: "../codigo_postal/guardar.php",
                                    data: {
                                        codigo_postal: codigoPostal,
                                        latitud: location.lat(),
                                        longitud: location.lng()
                                    },
                                    dataType: "json",
                                    success: function(data) {},
                                });
                            } else {
                                alert('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    } else {
                        console.log('ya existe');
                    }
                }
            });
        })
    }

    function obtenerCheckboxesSeleccionados() {
        var checkboxesSeleccionados = [];
        $(".dropdown-menu input[type='checkbox']").each(function() {
            if ($(this).is(":checked")) {
                checkboxesSeleccionados.push($(this).val());
            }
        });
        return checkboxesSeleccionados;
    }

    selectedOptions = obtenerCheckboxesSeleccionados();

    if (selectedOptions.length == 0) {
        cargar_colores();
        console.log('caso 2');
    } else {
        cargar_colores();
        console.log('caso 3');
    }
</script>