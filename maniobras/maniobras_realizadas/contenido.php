<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid">

        <div class="position-fixed start-50 bottom-0 translate-middle-x w-100 zi-99 mb-3" style="max-width: 40rem;display:none" id="contador_pagar">
            <!-- Card -->
            <div class="card card-sm bg-dark border-dark mx-2">
                <div class="card-body">
                    <div class="row justify-content-center justify-content-sm-between">
                        <div class="col">
                            <h2 id="totalAPagar" class="text-white">Total a pagar: $0.00</h2>
                        </div>
                        <!-- End Col -->

                        <div class="col-auto">
                            <div class="d-flex gap-3">
                                <button type="button" class="btn btn-primary" id="confirmar_nomina">Procesar nomina</button>
                            </div>
                        </div>
                        <!-- End Col -->
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Card -->
        </div>

        <!-- Card -->
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="card-header-title text-primary">Maniobras realizadas</h1>
                        </div>
                    </div>

                    <div class="col-auto">
                        <!-- Filter -->
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <!-- Dropdown -->
                                <div class="dropdown">
                                    <button type="button" class="btn btn-primary btn-sm w-100" id="usersFilterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bi-filter me-1"></i> Establecer periodo
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
                                                                <input type="text" id="daterange" class="form-control daterangepicker-custom-input" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon2">
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