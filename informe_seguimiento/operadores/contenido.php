<main id="content" role="main" class="main">
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Reporte de ingresos</h1>
                    </div>
                    <div class="col-auto">
                        <div class="tom-select-custom">
                            <select class="form-select" id="opcion" name="opcion">
                                <option value="store_id">Sucursales</option>
                                <option value="employee_id" selected>Operadores</option>
                                <option value="vehicle_id">Unidades</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <input class="form-control bg-white" type="text" id="fechaRango" placeholder="Selecciona un rango de fechas">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content container-fluid navbar-light" style="margin-top: -18rem;">
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="reporte"></div>
                </div>
            </div>
        </div>
    </div>
</main>