<div class="card position-fixed bottom-0 end-0 m-4 spinner-container bg-dark" id="loadingCard">
    <div class="card-body">
        <div class="row">
            <div class="col-8 container-fluid d-flex justify-content-center align-items-center">
                <h4 class="card-text text-white">Cargando...</h4>
            </div>
            <div class="col-4">
                <div class="spinner-border text-white" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        </div>
    </div>
</div>

<main id="content" role="main" class="main">

    <div class="content container-fluid">
        <div class="card mb-3 mb-lg-5">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="card-header-title text-primary">Viajes finalizados</h1>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                    <input type="checkbox" value="0"> Referencia
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="1"> Carta Porte
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="2"> Fecha
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="3"> POD
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="4"> EIR
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="5"> CUENTA
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="6"> Fecha finalizado
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="7"> Finalizado por:
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="8"> Sucursal
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="9"> Ejecutivo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="10"> Operador
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="11"> Unidad
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="12"> Ruta
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="13"> Tipo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="14"> Contenedores
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="15"> Cliente
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
                                                <option value="100" selected>Seleccionar campo</option>
                                                <option value="travel_id">Referencia</option>
                                                <option value="name">Carta porte</option>
                                                <option value="date_order">Fecha</option>
                                                <option value="store_id">Surcursal</option>
                                                <option value="x_ejecutivo_viaje_bel">Ejecutivo</option>
                                                <option value="employee_id">Operador</option>
                                                <option value="vehicle_id">Unidad</option>
                                                <option value="route_id">Ruta</option>
                                                <option value="x_reference">Contenedores</option>
                                                <option value="partner_id">Cliente</option>
                                            </select>

                                            <button onclick="search()" class="btn btn-primary btn-sm">Buscar</button>
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

            <div id="tabla" class="card-body p-0 m-0">
            </div>

        </div>
    </div>
</main>
<?php

require_once('../../search/codigo1.php');
