<?php
require_once('../../mysql/conexion.php');

$kwargs = ['fields' => ['id', 'name2', 'fleet_type', 'x_status', 'x_motogenerador']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    [],
    $kwargs
);

$json = json_encode($ids);
$array = json_decode($json);

$kwargs = ['fields' => ['id', 'name']];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'hr.employee',
    'search_read',
    array(array(array('job_id', '=', [55, 25, 26]))),
    $kwargs
);

$json2 = json_encode($ids2);
$array2 = json_decode($json2);

?>
<!-- Offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="AsignarEquipoMR" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignación de Equipo - Maniobra de Retiro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="FormManiobraRetiro">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Terminal de Retiro</label>
                <div class="input-group input-group-merge input-group-hover-light">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi-person"></i>
                    </div>
                    <input type="text" class="form-control" id="x_mov_bel" name="x_mov_bel" aria-describedby="emailHelp">
                </div>
            </div>
            <div class="tom-select-custom mb-3">
                <label for="exampleInputEmail1" class="form-label">Tipo de terminal</label>
                <select class="form-select form-select-sm" id="x_tipo_terminal_retiro" name="x_tipo_terminal_retiro">
                    <option selected value="puerto">Puerto</option>
                    <option value="externa">Externa</option>
                </select>
            </div>
            <div class="tom-select-custom mb-3">
                <label for="exampleInputEmail1" class="form-label">Operador de Retiro</label>
                <select class="form-select form-select-sm" id="x_operador_retiro_id" name="x_operador_retiro_id">
                    <?php foreach ($array2 as $operador) { ?>
                        <option value="<?php echo $operador->id ?>"><?php echo $operador->name ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Inicio Programado</label>
                <input type="datetime-local" class="form-control" id="x_inicio_programado_retiro" name="x_inicio_programado_retiro" aria-describedby="emailHelp">
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">ECO Retiro</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_eco_retiro_id" name="x_eco_retiro_id">
                            <?php foreach ($array as $vehiculo) {
                                if (($vehiculo->fleet_type == 'tractor')) { ?>
                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->name2 ?></option>
                            <?php }
                            } ?>
                        </select>
                        <!-- End Select -->
                    </div>
                </div>
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">Remolque 1</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_remolque_1_retiro" name="x_remolque_1_retiro">
                            <?php foreach ($array as $vehiculo) {
                                if (($vehiculo->fleet_type == 'trailer')) { ?>
                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->name2 ?></option>
                            <?php }
                            } ?>
                        </select>
                        <!-- End Select -->
                    </div>
                </div>
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">Remolque 2</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_remolque_2_retiro" name="x_remolque_2_retiro">
                            <?php foreach ($array as $vehiculo) {
                                if (($vehiculo->fleet_type == 'trailer')) { ?>
                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->name2 ?></option>
                            <?php }
                            } ?>
                        </select>
                        <!-- End Select -->
                    </div>
                </div>
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">Dolly</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_dolly_retiro" name="x_dolly_retiro">
                            <?php foreach ($array as $vehiculo) {
                                if (($vehiculo->fleet_type == 'dolly')) { ?>
                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->name2 ?></option>
                            <?php }
                            } ?>
                        </select>
                        <!-- End Select -->
                    </div>
                </div>
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">Motogenerador 1</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_motogenerador_1_retiro" name="x_motogenerador_1_retiro">
                            <?php foreach ($array as $vehiculo) {
                                if (($vehiculo->x_motogenerador == true)) { ?>
                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->name2 ?></option>
                            <?php }
                            } ?>
                        </select>
                        <!-- End Select -->
                    </div>
                </div>
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">Motogenerador 2</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_motogenerador_2_retiro" name="x_motogenerador_2_retiro">
                            <?php foreach ($array as $vehiculo) {
                                if (($vehiculo->x_motogenerador == true)) { ?>
                                    <option value="<?php echo $vehiculo->id ?>"><?php echo $vehiculo->name2 ?></option>
                            <?php }
                            } ?>
                        </select>
                        <!-- End Select -->
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group mb-3">
                        <button type="button" class="btn btn-success btn-xs" onclick="buscador_sol()">Enlazar otra solicitud</button>
                        <input type="text" class="form-control" id="x_solicitud_enlazada" name="x_solicitud_enlazada">
                        <button type="button" class="btn btn-danger btn-xs" onclick="borrar_sol()"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="offcanvas-footer">
        <button type="button" class="btn btn-primary btn-sm" id="GuardarDatosManiobraRetiro" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-success btn-sm" id="ConfirmarManiobraRetiro" style="display: none;">Confirmar</button>
    </div>
</div>
<!-- End Offcanvas -->

<script>
    function borrar_sol() {
        $('#x_solicitud_enlazada').val('');
    }

    function buscador_sol() {
        $('#buscador_cp_sol').modal('show');
        $("#tabla_solicitudes_cp").load('../buscador/tabla.php', {
            'opcion': 'solicitud'
        });
    }
</script>