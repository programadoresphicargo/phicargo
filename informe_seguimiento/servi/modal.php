<!-- Modal -->
<div class="modal fade" id="modal_datos_servi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresar datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="datosServi">

                    <div class="mb-3">
                        <label class="form-label">ID</label>
                        <input type="text" class="form-control" id="id_dato" name="id_dato" value='' readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fecha</label>
                        <input type="text" class="form-control" id="fecha_servi" name="fecha_servi" value='<?php echo $fecha ?>' readonly>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Consolidación</label>
                                <input type="text" class="form-control" id="ingresos2" name="ingresos2">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Desconsolidación</label>
                                <input type="number" class="form-control" id="salidas" name="salidas">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Bodega 1</label>
                                <input type="number" class="form-control" id="bodega_1" name="bodega_1">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Bodega 2</label>
                                <input type="number" class="form-control" id="bodega_2" name="bodega_2">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Bodega 3</label>
                                <input type="number" class="form-control" id="bodega_3" name="bodega_3">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label">Bodega 4</label>
                                <input type="number" class="form-control" id="bodega_4" name="bodega_4">
                            </div>
                        </div>

                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="ingresar_datos">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const boton_añadir_datos_servi = document.getElementById('ingresar_datos');

    boton_añadir_datos_servi.addEventListener('click', () => {
        var datos = $('#datosServi').serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "../servi/ingresar_datos.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    notyf.success('Datos guardados correctamente');
                    $('#modal_datos_servi').modal('hide');
                    $('#datos_servi').load('../informes/datos_servi.php', {
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