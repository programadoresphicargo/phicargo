<!-- Modal -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="AsignarEquipoMI" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignación de Equipo - Maniobra de Ingreso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <form id="FormManiobraIngreso">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Terminal de Ingreso</label>
                <input type="text" class="form-control" id="x_terminal_bel" name="x_terminal_bel" aria-describedby="emailHelp">
            </div>
            <div class="tom-select-custom mb-3">
                <label for="exampleInputEmail1" class="form-label">Tipo de terminal</label>
                <select class="form-select form-select-sm" id="x_tipo_terminal_ingreso" name="x_tipo_terminal_ingreso">
                    <option selected value="puerto">Puerto</option>
                    <option value="externa">Externa</option>
                </select>
            </div>
            <div class="tom-select-custom mb-3">
                <label for="exampleInputEmail1" class="form-label">Operador de ingreso</label>
                <!-- Select -->
                <select class="form-select form-select-sm" id="x_mov_ingreso_bel_id" name="x_mov_ingreso_bel_id">
                    <?php foreach ($array2 as $operador) { ?>
                        <option value="<?php echo $operador->id ?>"><?php echo $operador->name ?></option>
                    <?php } ?>
                </select>
                <!-- End Select -->
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Inicio Programado</label>
                <input type="datetime-local" class="form-control" id="x_inicio_programado_ingreso" name="x_inicio_programado_ingreso" aria-describedby="emailHelp">
            </div>

            <div class="row">
                <div class="col-6">
                    <div class="tom-select-custom mb-3">
                        <label for="exampleInputPassword1" class="form-label">Unidad</label>
                        <!-- Select -->
                        <select class="form-select form-select-sm" id="x_eco_ingreso_id" name="x_eco_ingreso_id">
                            <?php foreach ($array as $vehiculo) {
                                if ($vehiculo->fleet_type == 'tractor') { ?>
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
                        <select class="form-select form-select-sm" id="x_remolque_1_ingreso" name="x_remolque_1_ingreso">
                            <?php foreach ($array as $vehiculo) {
                                if ($vehiculo->fleet_type == 'trailer') { ?>
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
                        <select class="form-select form-select-sm" id="x_remolque_2_ingreso" name="x_remolque_2_ingreso">
                            <?php foreach ($array as $vehiculo) {
                                if ($vehiculo->fleet_type == 'trailer') { ?>
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
                        <select class="form-select form-select-sm" id="x_dolly_ingreso" name="x_dolly_ingreso">
                            <?php foreach ($array as $vehiculo) {
                                if ($vehiculo->fleet_type == 'dolly') { ?>
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
                        <select class="form-select form-select-sm" id="x_motogenerador_1_ingreso" name="x_motogenerador_1_ingreso">
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
                        <select class="form-select form-select-sm" id="x_motogenerador_2_ingreso" name="x_motogenerador_2_ingreso">
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
                        <button type="button" class="btn btn-success btn-xs" id="abrir_buscador_cp" onclick="buscador2()">Enlazar otra CP</button>
                        <input type="text" class="form-control" id="x_cp_enlazada" name="x_cp_enlazada">
                        <button type="button" class="btn btn-danger btn-xs" onclick="borrar_cp()"><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="offcanvas-footer">
        <button type="button" class="btn btn-primary btn-sm" id="GuardarDatosManiobraIngreso" style="display: none;">Guardar</button>
        <button type="button" class="btn btn-success btn-sm" id="ConfirmarManiobraIngreso" style="display: none;">Confirmar</button>
    </div>
</div>
<!-- End Modal -->


<script>
    function borrar_cp() {
        $('#x_cp_enlazada').val('');
    }

    function buscador2() {
        $('#buscador_cp_sol').modal('show');
        $("#tabla_solicitudes_cp").load('../buscador/tabla.php', {
            'opcion': 'cp'
        });
    }
</script>