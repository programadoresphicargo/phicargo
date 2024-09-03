<div class="modal fade" id="modalalertasgps" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body bg-soft-secondary">
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm mb-2 mb-sm-0">
                            <h2 class="page-header-title">Alerta GPS</h2>
                            <div class="mb-3">
                                <h1> <span id="evento" name="evento" class="badge bg-warning rounded-pill"></span></h1>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>

                            <a class="btn btn-warning btn-sm" onclick="atender_alerta()" id="atender_alerta">
                                <i class="bi-people-fille me-1"></i> Atender
                            </a>
                        </div>
                    </div>
                </div>
                <form id="form_alerta">
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <input type="hidden" class="form-control" id="id_alerta" name="id_alerta">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Fecha</label>
                                        <input type="text" class="form-control" id="fecha_alerta" name="fecha_alerta" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Referencia de viaje</label>
                                        <input type="text" class="form-control" id="referencia_viaje_alerta" name="referencia_viaje_alerta" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Operador</label>
                                        <input type="text" class="form-control" id="operador_alerta" name="operador_alerta" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Unidad</label>
                                        <input type="text" class="form-control" id="unidad_alerta" name="unidad_alerta" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Comentarios del monitorista</label>
                                        <textarea type="text" class="form-control" id="comentarios_monitorista_alerta" name="comentarios_monitorista_alerta" rows="6"></textarea>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Atendido por</label>
                                        <input type="text" class="form-control" id="usuario_atendio_alerta" name="usuario_atendio_alerta" disabled>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Fecha de atencion</label>
                                        <input type="text" class="form-control" id="fecha_atendido_alerta" name="fecha_atendido_alerta" disabled>
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
    function atender_alerta() {

        var comentarios_monitorista = $("#comentarios_monitorista_alerta").val();
        var data = $("#form_alerta").serialize();

        if (comentarios_monitorista != "") {
            $.ajax({
                url: '../../gestion_viajes/alertas/gps/atender.php',
                type: 'POST',
                data: data,
                success: function(response) {
                    if (response == '1') {
                        $("#modalalertasgps").modal('hide');
                        notyf.success('Reporte atendido.');
                    } else {
                        notyf.error(response);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud AJAX:', error);
                }
            });
        } else {
            notyf.error('Debes añadir comentarios al reporte.');
            document.getElementById('comentarios_monitorista_alerta').classList.add('border-danger');
        }
    }
</script>