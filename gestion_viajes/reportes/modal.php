<div class="modal fade" id="modal_reporte_problema" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body bg-soft-secondary">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm mb-2 mb-sm-0">
                            <h2 class="page-header-title">Reporte: Operador tiene un problema</h2>
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>

                            <a class="btn btn-danger btn-sm" onclick="atender_reporte()" id="atenderpo">
                                <i class="bi-people-fille me-1"></i> Atender
                            </a>
                        </div>
                    </div>
                </div>
                <form id="formrpo">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <input type="hidden" class="form-control" id="id_rpo" name="id_rpo">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Fecha del reporte</label>
                                        <input type="text" class="form-control" id="fecha_rpo" name="fecha_rpo" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Referencia de viaje</label>
                                        <input type="text" class="form-control" id="referencia_rpo" name="referencia_rpo" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Operador</label>
                                        <input type="text" class="form-control" id="operador_rpo" name="operador_rpo" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Unidad</label>
                                        <input type="text" class="form-control" id="unidad_rpo" name="unidad_rpo" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <form>
                                        <div class="form-group mb-3">
                                            <label>Comentarios del operador</label>
                                            <textarea type="text" class="form-control" id="comentarios_operador_rpo" name="comentarios_rpo" rows="6" disabled></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Comentarios del monitorista</label>
                                            <textarea type="text" class="form-control" id="comentarios_monitorista_rpo" name="comentarios_monitorista_rpo" rows="6"></textarea>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Atendido por</label>
                                            <input type="text" class="form-control" id="usuario_resolvio_rpo" name="usuario_resolvio_rpo" disabled>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label>Fecha de atencion</label>
                                            <input type="text" class="form-control" id="fecha_resuelto_rpo" name="fecha_resuelto_rpo" disabled>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function atender_reporte() {

        var comentarios_monitorista = $("#comentarios_monitorista_rpo").val();
        var data = $("#formrpo").serialize();

        if (comentarios_monitorista != "") {
            $.ajax({
                url: '../../gestion_viajes/reportes/atender_reporte.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $("#modal_reporte_problema").modal('hide');
                        $('#tabla_reportes').load('tabla.php');
                        notyf.success('Reporte atendido.');
                        alertar_reportes();
                    } else {
                        notyf.error(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud AJAX:', error);
                }
            });
        } else {
            notyf.error('Debes añadir comentarios al reporte como evidencia.')
        }
    }
</script>