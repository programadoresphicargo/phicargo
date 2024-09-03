<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="envio_masivo_modal">
    <div class="modal-dialog modal-xl" role="document" style="max-width: 95%;">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h4" id="myExtraLargeModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm mb-2 mb-sm-0">
                            <h2 class="page-header-title">Envio de estatus masivo</h2>
                        </div>

                        <div class="col-sm-auto">
                            <a class="btn btn-primary btn-sm" href="javascript:;" id="enviarestatusmasivos">
                                <i class="bi-people-fille me-1"></i> Enviar estatus
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tablaenviosmasivos" class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-striped table-hover">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Referencia de viaje</th>
                                        <th>Estado actual</th>
                                        <th>Unidad</th>
                                        <th>Operador</th>
                                        <th>Estatus a enviar</th>
                                        <th>Comentarios</th>
                                        <th>Quitar viaje</th>
                                        <th>Estado de envio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>