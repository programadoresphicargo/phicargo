<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">
        <!-- Card -->
        <div class="card animate__animated animate__fadeIn animate__bounce animate__delay-1s">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="card-header-title text-primary">Solicitudes de transporte</h1>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                                <i class="bi bi-funnel-fill"></i> Agrupar por
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="0"> Sucursal
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="1"> Ejecutivo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="2"> Fecha
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="3"> Cliente
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="4"> Carta porte
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="5"> Referencia Contenedor
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="6"> Status
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="7"> Terminal retiro
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="8"> Operador retiro
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="9"> Eco retiro
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
                                                <option value="name">Carta porte</option>
                                                <option value="travel_id">Referencia de viaje</option>
                                                <option value="date_order">Fecha</option>
                                                <option value="store_id">Surcursal</option>
                                                <option value="x_ejecutivo_viaje_bel">Ejecutivo</option>
                                                <option value="employee_id">Operador</option>
                                                <option value="vehicle_id">Unidad</option>
                                                <option value="x_reference">Contenedores</option>
                                                <option value="partner_id">Cliente</option>
                                                <option value="x_status_bel">Status</option>
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
            <div class="card-body m-0 p-0">
                <div id="tabla"></div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
</main>

<?php
require_once('../../search/codigo1.php');
