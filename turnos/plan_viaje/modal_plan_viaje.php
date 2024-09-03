<div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Plan de Viaje</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center mb-3">
                    <div class="col-lg">
                        <div class="row align-items-center g-0">
                            <div class="col-auto">Fecha:</div>
                            <div class="col flatpickr-custom-position-fix-sm-down">
                                <div id="projectDeadlineFlatpickr" class="js-flatpickr flatpickr-custom flatpickr-custom-borderless input-group input-group-sm">
                                    <input type="text" id="rango" name="rango" class="flatpickr-custom-form-control form-control" placeholder="Seleccionar fecha" data-input value="">
                                    <div class="input-group-append input-group-text ps-0" data-bs-toggle>
                                        <i class="bi-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                        <!-- Select -->
                        <div class="dropdown me-2">
                            <button type="button" class="btn btn-success btn-sm dropdown-toggle" id="usersExportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-download me-2"></i> Exportar
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="usersExportDropdown">
                                <li><a id="export-copy-pv" class="dropdown-item" href="javascript:;">Copiar</a></li>
                                <li><a id="export-print-pv" class="dropdown-item" href="javascript:;">Imprimir</a></li>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-header">Opciones de descarga</span>
                                <li><a id="export-excel-pv" class="dropdown-item" href="javascript:;">Excel</a></li>
                                <li><a id="export-csv-pv" class="dropdown-item" href="javascript:;">.CSV</a></li>
                                <li><a id="export-pdf-pv" class="dropdown-item" href="javascript:;">PDF</a></li>
                            </ul>
                        </div>
                        <!-- End Select -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
                <div id="plan_de_viaje"></div>
            </div>
            <!-- End Modal Body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cerrar</button>
            </div>
            <!-- End Modal Footer -->
        </div>
        <!-- End Modal Content -->
    </div>
    <!-- End Modal Dialog -->
</div>
<!-- End Modal -->