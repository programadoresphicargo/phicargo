<main id="content" role="main" class="main overflow-hidden">

    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-sm mb-2 mb-sm-0">
                    <h1 class="page-header-title">Asignación de unidades</h1>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 mb-5">
        </div>

        <h2 class="h4 mb-3">Reporte</h2>

        <div class="row">
            <div class="col-12">
                <div class="card card-sm card-hover-shadow h-100">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center flex-grow-1">
                            <div class="col-md">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h1 class="card-header-title text-white">Cartas porte</h1>
                                </div>
                            </div>

                            <div class="col-auto">
                                <div class="row align-items-sm-center">
                                    <div class="col-sm-auto">
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="display: none">
                                                <i class="bi-filter me-1"></i> Filtro fecha
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-sm-end dropdown-card card-dropdown-filter-centered" aria-labelledby="usersFilterDropdown" style="min-width: 22rem;">
                                                <div class="card">
                                                    <div class="card-header card-header-content-between">
                                                        <h5 class="card-header-title">Filtro</h5>

                                                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm ms-2">
                                                            <i class="bi-x-lg"></i>
                                                        </button>
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
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-auto">
                                        <div class="row align-items-center gx-0">
                                            <div class="col-auto">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                                        <i class="bi bi-funnel-fill"></i> Agrupar por
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="0"> Unidad
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="1"> Sucursal
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="2"> Operador
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="3"> Tipo
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="4"> Tipo de carga
                                                        </label>
                                                        <label class="dropdown-item">
                                                            <input type="checkbox" value="5"> Modalidad
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-auto">
                                        <div class="row align-items-center gx-0">
                                            <div class="col-auto">
                                                <div class="input-group input-group-merge input-group-flush">
                                                    <div class="input-group-prepend input-group-text" id="inputGroupFlushFullNameAddOn">
                                                        <i class="bi bi-search"></i>
                                                    </div>
                                                    <input type="text" class="form-control" id="searchText" placeholder="Escribe tu búsqueda">
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
                                                    <select id="searchField" class="form-select">
                                                        <option value="name2">Vehiculo</option>
                                                        <option value="x_sucursal">Sucursal</option>
                                                        <option value="x_operador_asignado">Operador asignado</option>
                                                        <option value="x_tipo_vehiculo">Tipo</option>
                                                        <option value="x_tipo_carga">Tipo de carga</option>
                                                        <option value="x_modalidad">Modalidad</option>
                                                    </select>
                                                    <button onclick="search()" class="btn btn-primary">Buscar</button>
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
                                                        <div id="results">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="tabla">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
include('../../search/codigo1.php');
