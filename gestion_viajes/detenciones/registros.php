<?php
require_once('funcion.php');
date_default_timezone_set('America/Mexico_City');

$registros = obtenerRegistrosDetenciones();

$contador = 0;
foreach ($registros as $row) {
    $contador++;
    $clase_impar = ($contador % 2 != 0) ? 'bg-soft-secondary' : '';
?>
    <div class="container p-3 <?php echo $clase_impar; ?>" style="cursor: pointer;">
        <div class="row" onclick="abrir_detencion('<?php echo $row['id_detencion'] ?>')">
            <div class="col-auto">
                <div class="align-items-center">
                    <img class="avatar avatar-sm avatar-circle" src="../../img/stop.png" alt="Image Description">
                </div>
            </div>
            <div class="col">
                <h4 class="text-body"><?php echo $row['referencia_viaje'] ?>
                    <small class="col-auto text-muted text-cap">
                        <span class="badge rounded-pill <?php echo $row['estado_viaje'] === 'ruta' ? 'bg-primary' : ($row['estado_viaje'] === 'retorno' ? 'bg-warning' : 'bg-success'); ?>">
                            <?php echo $row['estado_viaje']; ?>
                        </span>
                    </small>
                </h4>
                <h6>OPERADOR: <span class="text-body"><?php echo $row['nombre_operador'] ?></span></h6>
                <h6>UNIDAD: <span class="text-body"><?php echo '[' . $row['placas'] . '] ' . $row['unidad'] ?></span></h6>

                <?php
                $fecha = new DateTime($row['inicio_detencion']);
                ?>
                <h6>DETENIDO DESDE: <span class="text-body"><?php echo $fecha->format('Y-m-d h:i a') ?><?php echo ' (' . $row['tiempo_transcurrido_minutos'] . ' minutos detenido)' ?></span></h6>

                <?php if ($row['fin_detencion'] != NULL) {
                    $fecha = new DateTime($row['fin_detencion']);
                ?>
                    <h6 class="badge rounded-pill bg-success">UNIDAD YA SE PUSO EN MOVIMIENTO: <?php echo $fecha->format('Y-m-d h:i a') ?></h6>
                <?php   } ?>

                <h6><a class="text-body m-0 p-0" target="_blank" href="https://www.google.com/maps?q=<?php echo $row['latitud'] . ',' . $row['longitud'] ?>">UBICACIÓN: <?php echo $row['latitud'] . ', ' . $row['longitud'] ?></a></h6>
            </div>
            <small class="col-auto text-muted text-cap">
                <?php if ($row['atendida'] == 1) { ?>
                    <span class="badge bg-success rounded-pill"><i class="bi bi-check-lg"></i>Atendido</span>
                <?php } else { ?>
                    <span class="badge bg-warning rounded-pill"><i class="bi bi-clock"></i> En espera de <br> ser atendido</span>
                <?php } ?>
            </small>
        </div>
    </div>

<?php
}
?>
<script>
    function abrir_detencion(id) {
        $.ajax({
            url: '../../gestion_viajes/detenciones/get_detencion.php',
            type: 'POST',
            data: {
                'id': id
            },
            success: function(response) {
                $("#control_detencion").modal('show');

                var data = JSON.parse(response);
                console.log(data);

                $('#id_detencion').val(data.id_detencion);
                $('#id_viaje_detencion').val(data.id_viaje);
                $('#viaje_detencion').val(data.referencia_viaje);
                $('#unidad_detencion').val(data.unidad + ' [' + data.placas + ']');
                $('#operador_detencion').val(data.nombre_operador);
                $('#inicio_detencion').val(data.inicio_detencion);
                $('#motivo_detencion').val(data.motivo);
                $('#tiempo_detenido').val(data.tiempo_transcurrido_minutos).change();
                $('#comentarios_detencion').val(data.comentarios).change();
                $('#tolerancia_concecida').val(data.tolerancia_concedida).change();
                $('#usuario_atendio').val(data.nombre);
                $('#fecha_atendido').val(data.fecha_atendido);

                $.ajax({
                    url: '../../gestion_viajes/detenciones/mapa.php',
                    type: 'POST',
                    data: {
                        'latitud': data.latitud,
                        'longitud': data.longitud
                    },
                    success: function(response) {
                        $("#mapa-detencion").html(response);
                    },
                    error: function(error) {
                        notyf.error(data);
                    }
                });

                var spanElement = document.getElementById('estadoregdetencion');

                if (data.atendida == '1') {
                    $('#btnatenderdetencion').hide();
                    $('#motivo_detencion').prop('disabled', true);
                    $('#comentarios_detencion').prop('disabled', true);
                    $('#tolerancia_concecida').prop('disabled', true);
                    spanElement.classList.remove('bg-warning');
                    spanElement.classList.add('bg-success', 'rounded-pill');
                    spanElement.textContent = 'Atendido';
                } else {
                    $('#btnatenderdetencion').show();
                    $('#motivo_detencion').prop('disabled', false);
                    $('#comentarios_detencion').prop('disabled', false);
                    $('#tolerancia_concecida').prop('disabled', false);
                    spanElement.classList.remove('bg-success');
                    spanElement.classList.add('bg-warning', 'rounded-pill');
                    spanElement.textContent = 'En espera de ser atendido';
                }
            },
            error: function(error) {
                notyf.error(data);
            }
        });
    }
</script>