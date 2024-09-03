<main id="content" role="main" class="main">
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <div class="page-header page-header-light">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col">
                        <h1 class="page-header-title">Control de Estadías</h1>
                    </div>
                    <div class="col-auto">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                <i class="bi bi-funnel-fill"></i>  Agrupar por
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="CamposAgrupar">
                                <label class="dropdown-item">
                                    <input type="checkbox" value="0" onchange="handleCheckboxChange(this)"> Sucursal
                                </label>
                                <label class="dropdown-item">
                                    <input type="checkbox" value="1" onchange="handleCheckboxChange(this)"> Referencia
                                </label>
                                <label class="dropdown-item">
                                    <input type="checkbox" value="2" onchange="handleCheckboxChange(this)"> Unidad
                                </label>
                                <label class="dropdown-item">
                                    <input type="checkbox" value="3" onchange="handleCheckboxChange(this)"> Operador
                                </label>
                                <label class="dropdown-item">
                                    <input type="checkbox" value="4" onchange="handleCheckboxChange(this)"> Cliente
                                </label>
                                <label class="dropdown-item">
                                    <input type="checkbox" value="5" onchange="handleCheckboxChange(this)"> Genero estadías
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <input class="form-control bg-white" type="text" id="fechaRango" placeholder="Selecciona un rango de fechas">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content container-fluid" style="margin-top: -18rem;">
        <div class="card">
            <div class="card-body">
                <div id="tabla_reportes">
                </div>
            </div>
        </div>
    </div>
</main>