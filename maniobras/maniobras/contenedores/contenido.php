<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="card-header-title text-primary">Contenedores</h1>
                        </div>
                    </div>

                    <div class="col-auto">
                        <!-- Filter -->
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                    <input type="checkbox" value="0"> Carta porte
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="1"> Contenedor
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="2"> Ejecutivo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="3"> Viaje
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="4"> Llegada a patio
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="5"> Días en patio
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="6"> Status
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="7"> Fecha ingreso
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="8"> Sucursal
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
                                                <option value="0">Sucursal</option>
                                                <option value="1">Ejecutivo</option>
                                                <option value="2">Fecha</option>
                                                <option value="3">Cliente</option>
                                                <option value="4">Carta porte</option>
                                                <option value="5">Contenedor</option>
                                                <option value="6">Status</option>
                                                <option value="7">Terminal retiro</option>
                                                <option value="8">Operador retiro</option>
                                                <option value="9">ECO retiro</option>
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

            <div class="card-body p-0 m-0">
                <div id="tabla_contenedores"></div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->
</main>