<main id="content" role="main" class="main">
    <div class="content container-fluid">
        <div class="card mb-3 mb-lg-5">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="card-header-title text-primary">Maniobras activas</h1>
                        </div>
                    </div>

                    <div class="col-auto">
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <div class="row align-items-center gx-0">

                                    <div class="col-sm-auto p-5">
                                        <div class="row align-items-center gx-0">
                                            <div class="col-auto">
                                                <button class="btn btn-success btn-sm" id="abrir_programadas">Maniobras programadas</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-auto">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                                <i class="bi bi-funnel-fill"></i> Agrupar por
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="0"> ID
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="1"> Tipo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="2"> Ejecutivo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="3"> Cliente
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="4"> Terminal
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="5"> Unidad
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="6"> Inicio programado
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="7"> Operador
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="8"> Contenedor
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
                                                <option value="store_id">Sucursal</option>
                                                <option value="x_ejecutivo_viaje_bel">Ejecutivo</option>
                                                <option value="partner_id">Cliente</option>
                                                <option value="x_reference">Contenedores</option>
                                                <option value="x_status_bel">Status</option>
                                                <option value="x_eco_retiro_id">ECO retiro</option>
                                                <option value="x_eco_ingreso_id">ECO ingreso</option>

                                                <option value="x_mov_bel">Terminal retiro</option>
                                                <option value="x_terminal_bel">Terminal ingreso</option>

                                                <option value="x_operador_retiro_id">Operador retiro</option>
                                                <option value="x_mov_ingreso_bel_id">Operador ingreso</option>
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
            <!-- End Header -->
            <div id="tabla">

            </div>
        </div>
    </div>
    <!-- End Row -->
    </div>
    <!-- End Content -->
</main>
<?php
require_once('../../search/codigo1.php');
?>
<script>
    $('#abrir_programadas').click(function() {
        $('#modal_maniobras_programadas').modal('show');
        $('#maniobras_programadas').load('programadas.php');
    });
</script>