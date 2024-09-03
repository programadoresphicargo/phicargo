<main id="content" role="main" class="main">
    <div class="content bg-soft-secondary">
        <div class="row justify-content-lg-center">
            <div class="col-lg-12">

                <div class="card m-5">
                    <div class="card-header">
                        <h1>Turnos: <h1 id="titulo" class="text-primary"></h1>
                            <button type="button" class="btn btn-primary btn-xs" id="abrir_ingresar_turno"><i class="bi bi-person-lines-fill"></i> Ingresar turno</button>
                            <button type="button" class="btn btn-danger btn-xs" id="abrir_cola"><i class="bi bi-folder"></i> Operadores enviados a cola</button>
                            <button id="cargar_plan_de_viaje" type="button" class="btn btn-success btn-xs" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><i class="bi bi-list-task"></i> Plan de Viaje</button>
                            <button type="button" class="btn btn-warning btn-xs" id="abrir_modal_unidades_bajando"><i class="bi bi-truck"></i> Unidades bajando</button>
                            <button type="button" class="btn btn-success btn-xs" id="abrir_modal_incidencias"><i class="bi bi-person-exclamation"></i> Conteo de incidencias</button>

                            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" id="usersExportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-download me-2"></i> Exportar
                            </button>

                            <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="usersExportDropdown">
                                <span class="dropdown-header">Opciones</span>
                                <a id="export-copy" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/copy.png" alt="Image Description">
                                    Copiar
                                </a>
                                <a id="export-print" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/print.png" alt="Image Description">
                                    Imprimir
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-header">Opciones de descarga</span>
                                <a id="export-excel" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/excel.png" alt="Image Description">Excel</a>
                                <a id="export-csv" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/csv.png" alt="Image Description">.CSV
                                </a>
                                <a id="export-pdf" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/pdf.png" alt="Image Description">PDF</a>
                            </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="tabla"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>