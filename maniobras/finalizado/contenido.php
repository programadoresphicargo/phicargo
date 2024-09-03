<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
        <div class="card mb-3 mb-lg-5">
            <div class="card-header p-3">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-header-title">Maniobras finalizadas</h4>
                        </div>
                    </div>

                    <div class="col-auto">
                        <!-- Filter -->
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-filter me-1"></i> Filtros
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
                                                    <input type="checkbox" value="0"> Status
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="1"> Tipo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="2"> Ultimo status
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="3"> Sucursal
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="4"> Ejecutivo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="5"> Fecha
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="6"> Cliente
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="7"> Carta porte
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="8"> Contenedor
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="9"> Status
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

                            <div class="col-md">
                                <form>
                                    <!-- Search -->
                                    <div class="input-group input-group-merge input-group-flush">
                                        <div class="input-group-prepend input-group-text">
                                            <i class="bi-search"></i>
                                        </div>
                                        <input id="buscador" type="search" class="form-control" placeholder="Buscador" aria-label="Buscador">
                                    </div>
                                    <!-- End Search -->
                                </form>
                            </div>
                            <!-- End Col -->
                        </div>
                        <!-- End Filter -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Header -->
            <div id="tabla_contenedores"></div>
        </div>
    </div>
    <!-- End Row -->
    </div>
    <!-- End Content -->
</main>