<!-- Modal -->
<div class="modal fade" id="modal_datos_tank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresar datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="datosTank">

                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" class="form-control" id="id_tank" name="id_tank" value='' readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="text" class="form-control" id="fecha_tank" name="fecha_tank" value='<?php echo $fecha ?>' readonly>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Tanques lavados</label>
                                <input type="number" class="form-control" id="tanques_lavados" name="tanques_lavados">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Tanques rechazados</label>
                                <input type="number" class="form-control" id="tanques_rechazados" name="tanques_rechazados">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Tanques en patio</label>
                                <input type="number" class="form-control" id="tanques_patio" name="tanques_patio">
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="ingresar_datos_tank">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const boton_añadir_datos_tank = document.getElementById('ingresar_datos_tank');

    boton_añadir_datos_tank.addEventListener('click', () => {
        var datos = $('#datosTank').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../tank-container/ingresar_datos.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    notyf.success('Datos guardados correctamente');
                    $('#modal_datos_tank').modal('hide');
                    $('#tank').load('../informes/tank-container.php', {
                        'fecha': fecha,
                        'opcion': opcion
                    });
                } else if (respuesta == 2) {
                    notyf.error('Ya existe un registro para el dia seleccionado.');
                } else {
                    notyf.error(respuesta);
                }
            }
        });
    });
</script>