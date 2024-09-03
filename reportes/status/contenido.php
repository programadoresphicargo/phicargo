<main id="content" role="main" class="main overflow-hidden">
    <!-- Added overflow: hidden; to avoid Bootstrap horizontal scrolling issue when .btn-group > .dropdown is used in .row class -->
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Reportes</h1>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto" aria-label="Button group">
                    <!-- Button Group -->
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadFilesModal">
                            <i class="bi-cloud-arrow-up-fill me-1"></i> Upload
                        </button>

                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" id="uploadGroupDropdown" data-bs-toggle="dropdown" aria-expanded="false"></button>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="uploadGroupDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="bi-folder-plus dropdown-item-icon"></i> New folder
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="bi-folder-symlink dropdown-item-icon"></i> New shared folder
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#uploadFilesModal">
                                    <i class="bi-file-earmark-arrow-up dropdown-item-icon"></i> Upload files
                                </a>
                                <a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#uploadFilesModal">
                                    <i class="bi-upload dropdown-item-icon"></i> Upload folder
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- End Button Group -->
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <h2 class="h4 mb-3">Reportes Disponibles<i class="bi-question-circle text-muted" data-bs-toggle="tooltip" data-bs-placement="right" title="Pinned access to files you've been working on."></i></h2>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">

            <div class="col mb-3 mb-lg-5">
                <div class="card card-sm card-hover-shadow h-100 text-center" data-bs-toggle="modal" data-bs-target="#InicioReporteStatus">
                    <div class="card-body">
                        <img class="avatar avatar-4x3" src="../../img/status/documento.svg" alt="Image Description">
                    </div>
                    <div class="card-footer border-0">
                        <h5>Reporte Status Operador</h5>
                    </div>
                    <a class="stretched-link" href="#"></a>
                </div>
            </div>

            <div class="col mb-3 mb-lg-5">
                <div class="card card-sm card-hover-shadow h-100 text-center" onclick="window.location.href = '../porcentajes_status/index.php'">
                    <div class="card-body">
                        <img class="avatar avatar-4x3" src="../../img/status/documento.svg" alt="Image Description">
                    </div>
                    <div class="card-footer border-0">
                        <h5>Porcentaje de cumplimiento de estatus</h5>
                    </div>
                    <a class="stretched-link" href="#"></a>
                </div>
            </div>

            <div class="col mb-3 mb-lg-5">
                <div class="card card-sm card-hover-shadow h-100 text-center" onclick="window.location.href = '../llegadas_tarde/index.php'">
                    <div class="card-body">
                        <img class="avatar avatar-4x3" src="../../img/status/documento.svg" alt="Image Description">
                    </div>
                    <div class="card-footer border-0">
                        <h5>Llegadas tarde</h5>
                    </div>
                    <a class="stretched-link" href="#"></a>
                </div>
            </div>

            <div class="col mb-3 mb-lg-5">
                <!-- Card -->
                <div class="card card-sm card-hover-shadow h-100 text-center" data-bs-toggle="modal" data-bs-target="#InicioReporteCola" style="display: none;">
                    <!-- Form Check -->
                    <div class="form-check form-check-switch card-pinned-top-start zi-2">
                        <input class="form-check-input" type="checkbox" value="" id="starredCheckbox3" checked>
                        <label class="form-check-label btn-icon btn-xs rounded-circle" for="starredCheckbox3">
                            <span class="form-check-default" data-bs-toggle="tooltip" data-bs-placement="top" title="Pin">
                                <i class="bi-star"></i>
                            </span>
                            <span class="form-check-active" data-bs-toggle="tooltip" data-bs-placement="top" title="Pinned">
                                <i class="bi-star-fill"></i>
                            </span>
                        </label>
                    </div>
                    <!-- End Form Check -->


                    <div class="card-body">
                        <img class="avatar avatar-4x3" src="../../img/status/documento.svg" alt="Image Description">
                    </div>

                    <div class="card-footer border-0">
                        <h5>Operadores enviado a cola</h5>
                    </div>

                    <a class="stretched-link" href="#"></a>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->

        </div>
        <!-- End Pinned Access -->

        <h2 class="h4 mb-3">Reporte</h2>

        <!-- Folders -->
        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card card-sm card-hover-shadow h-100">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-md">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h1 class="card-header-title text-white">Cartas porte</h1>
                                </div>
                            </div>

                            <div class="col-auto">
                                <!-- Filter -->
                                <div class="row align-items-sm-center">

                                    <div class="col-sm-auto">
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="display: none">
                                                <i class="bi-filter me-1"></i> Filtro fecha
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered" aria-labelledby="usersFilterDropdown" style="min-width: 22rem;">
                                                <!-- Card -->
                                                <div class="card">
                                                    <div class="card-header card-header-content-between">
                                                        <h5 class="card-header-title">Filtro</h5>

                                                        <!-- Toggle Button -->
                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2">
                                                            <i class="bi-x-lg"></i>
                                                        </button>
                                                        <!-- End Toggle Button -->
                                                    </div>

                                                    <div class="card-body">
                                                        <form>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="input-group mb-3">
                                                                        <input type="text" id="rangoInput" class="form-control daterangepicker-custom-input" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2">
                                                                        <div class="input-group-append">
                                                                            <button class="btn btn-danger" id="borrar_fecha" type="button"><i class="bi bi-x-lg"></i></button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- End Card -->
                                            </div>
                                        </div>
                                        <!-- End Dropdown -->
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-sm-auto">
                                        <div class="row align-items-center gx-0">

                                            <div class="col-auto">
                                                <!-- Dropdown -->
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                                        <i class="bi bi-funnel-fill"></i> Agrupar por
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="0"> Viaje
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="1"> Contenedor
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="2"> Operador
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="3"> Status
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="4"> Fecha de envio
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- End Dropdown -->
                                            </div>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </div>
                                    <!-- End Col -->

                                    <div class="col-sm-auto">
                                        <div class="row align-items-center gx-0">
                                            <div class="col-auto">
                                                <div class="input-group input-group-merge input-group-flush">
                                                    <div class="input-group-prepend input-group-text" id="inputGroupFlushFullNameAddOn">
                                                        <i class="bi bi-search"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="input" placeholder="Buscador">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-auto">
                                        <div class="row align-items-center gx-0">
                                            <div class="col-auto">
                                                <div class="input-group input-group-merge input-group-flush">
                                                    <div class="input-group-prepend input-group-text">
                                                        <i class="bi bi-arrow-right"></i>
                                                    </div>
                                                    <select id="select" class="form-select">
                                                        <option value="100" selected>Seleccionar campo</option>
                                                        <option value="0">Viajes</option>
                                                        <option value="1">Contenedor</option>
                                                        <option value="2">Operador</option>
                                                        <option value="3">Status</option>
                                                        <option value="4">Fecha envio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-auto">
                                        <div class="row align-items-center gx-0">
                                            <div class="col-auto">
                                                <div class="dropdown">
                                                    <a class="btn btn-primary dropdown-toggle btn-sm" href="#" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        Busquedas
                                                    </a>
                                                    <div class="dropdown-menu" id="lista" aria-labelledby="dropdownMenuLink">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Filter -->
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="ReporteStatusListado">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card card-sm card-hover-shadow h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="ReporteStatus">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Folders -->
    </div>
    <!-- End Content -->
</main>