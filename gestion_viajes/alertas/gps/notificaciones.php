<?php
require_once('../../../mysql/conexion.php');
require_once('../../../tiempo/tiempo.php');

session_start();
$id_usuario = $_SESSION['userID'];

$cn = conectar();
$sqlSelect = "SELECT * FROM alertas 
inner join viajes on viajes.id = alertas.id_viaje
inner join operadores on operadores.id = viajes.employee_id
inner join unidades on unidades.placas = viajes.placas
left join usuarios on usuarios.id_usuario = alertas.usuario_atendio
where evento = 'Boton de panico'
order by fecha desc";
$resultado = $cn->query($sqlSelect);
?>

<ul class="list-group list-group-flush">
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <li class="list-group-item form-check-select <?php echo $row['id_viaje'] == NULL ? 'bg-soft-primary' : '' ?>" onclick="abrir_alerta('<?php echo $row['id_alerta'] ?>')">
            <div class="row">
                <div class="col-auto">
                    <div class="d-flex align-items-center">
                        <img class="avatar avatar-sm avatar-circle" src="../../img/icons/alarma.png">
                    </div>
                </div>

                <div class="col ms-n3">
                    <h5 class="badge bg-warning rounded-pill"><?php echo $row['evento'] ?></h5>
                    <p class="text-body">
                        ID: <?php echo $row['id_alerta'] ?> <br>
                        Referencia de viaje: <?php echo $row['referencia'] ?> <br>
                        Operador: <?php echo $row['nombre_operador'] ?> <br>
                        Unidad: <?php echo  $row['unidad'] . ' [' . $row['placas'] . ']' ?>
                    </p>
                    <?php
                    $fechaHoraBD = $row['fecha'];
                    $fechaHora = new DateTime($fechaHoraBD);
                    $formatoDeseado = $fechaHora->format('Y/m/d h:i a');
                    echo $formatoDeseado; ?>
                </div>

                <small class="col-auto text-muted text-cap"><?php echo imprimirTiempo($row['fecha']) ?></small>
                <small class="col-auto text-muted text-cap">
                    <span class="badge rounded-pill <?php echo ($row['atendido'] == '1') ? 'bg-success' : 'bg-warning'; ?>">
                        <i class="bi <?php echo ($row['atendido'] == '1') ? 'bi-check-lg' : 'bi-clock'; ?>"></i>
                        <?php echo ($row['atendido'] == '1') ? 'Atendido' : 'En espera de <br> ser atendido'; ?>
                    </span>
                </small>
            </div>
        </li>
    <?php } ?>
</ul>

<script>
    function abrir_alerta(id_alerta) {
        $('#modalalertasgps').modal('show');
        $.ajax({
            data: {
                'id_alerta': id_alerta
            },
            type: 'POST',
            url: "../../gestion_viajes/alertas/gps/get_alerta.php",
            success: function(respuesta) {

                var data = JSON.parse(respuesta);
                console.log(data);

                document.getElementById('evento').textContent = data.evento;

                $('#id_alerta').val(data.id_alerta);
                $('#evento').val(data.evento);
                $('#fecha_alerta').val(data.fecha).change();
                $('#referencia_viaje_alerta').val(data.referencia).change();
                $('#operador_alerta').val(data.nombre_operador).change();
                $('#unidad_alerta').val(data.unidad).change();
                $('#comentarios_monitorista_alerta').val(data.comentarios).change();
                $('#usuario_atendio_alerta').val(data.nombre).change();
                $('#fecha_atendido_alerta').val(data.fecha_atendido).change();

                console.log(data.atendido);
                if (data.atendido == '1') {
                    $('#atender_alerta').hide();
                    $('#comentarios_monitorista_alerta').prop('disabled', true);
                } else {
                    $('#atender_alerta').show();
                    $('#comentarios_monitorista_alerta').prop('disabled', false);
                }
            }
        });
    }
</script>