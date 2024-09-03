<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Viajes por sucursal</h1>
                    </div>
                    <div class="col-auto">
                        <!-- Select -->
                        <div class="tom-select-custom">
                            <select class="form-select" id="opcion" name="opcion" style="display: none;">
                                <option value="store_id">Sucursales</option>
                                <option value="employee_id">Operadores</option>
                                <option value="vehicle_id">Unidades</option>
                            </select>
                        </div>
                        <!-- End Select -->
                    </div>
                    <div class="col-3">
                        <input class="form-control bg-white" type="text" id="fechaRango" placeholder="Selecciona un rango de fechas">
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->
        </div>
    </div>
    <!-- End Content -->

    <div class="content container-fluid navbar-light" style="margin-top: -18rem;">
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="reporte"></div>
                </div>

                <canvas id="myChart"></canvas>

            </div>
        </div>
    </div>
</main>