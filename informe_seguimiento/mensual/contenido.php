<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-dark">
        <div class="content container" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light page-header-reset navbar-expand-lg">
                <div class="navbar-nav">
                    <div class="row align-items-center flex-grow-1">
                        <div class="col">
                            <!-- Logo -->
                            <h1 class="text-white"><?php echo $_GET['nombre'] . ' - ' . $_GET['año'] ?></h1>
                            <!-- End Logo -->
                        </div>

                        <div class="col-auto">
                            <!-- Navbar -->
                            <ul class="list-inline">
                                <!-- Dropdown -->
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButtonHoverAnimation" data-bs-toggle="dropdown" aria-expanded="false">
                                        Empresa
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonHoverAnimation">
                                        <form>

                                            <div class="m-2">
                                                <?php
                                                $sql2 = "SELECT * FROM empresas";
                                                $resultado2 = $cn->query($sql2);
                                                ?>
                                                <form id="empresas_check">

                                                    <div class="form-check">
                                                        <input id="check_phicargo" class="form-check-input" onchange="consultarViajes()" type="checkbox" name="estados[]" value="1">
                                                        <label class=" form-check-label" for="flexCheckChecked">
                                                            Phi-Cargo
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input id="check_servi" class="form-check-input" onchange="consultarViajes()" type="checkbox" name="estados[]" value="2">
                                                        <label class=" form-check-label" for="flexCheckChecked">
                                                            Servi-Container
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input id="check_tank" class="form-check-input" onchange="consultarViajes()" type="checkbox" name="estados[]" value="3">
                                                        <label class=" form-check-label" for="flexCheckChecked">
                                                            Tank-Container
                                                        </label>
                                                    </div>

                                                </form>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- End Dropdown -->
                            </ul>
                            <!-- End Navbar -->
                        </div>

                        <div class="col-auto">
                            <!-- Navbar -->
                            <ul class="list-inline">
                                <a class="btn btn-danger btn-sm" href="index-imprimir.php?mes=<?php echo $_GET['mes'] ?>&año=<?php echo $_GET['año'] ?>">Descargar PDF</a>
                            </ul>
                            <!-- End Navbar -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
            </div>
            <!-- End Page Header -->
        </div>
    </div>
    <!-- End Content -->

    <!-- Content -->
    <div class="content container" style="margin-top: -19rem;">

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-header">
                <h4>Saldos generales</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_saldos" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="saldos_generales"></div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_ingresos" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="ingresos"></div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_pagos" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="pagos"></div>
            </div>
        </div>
        <!-- End Card -->


        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_viajes_ejecutivos" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="viajes_ejecutivos"></div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_tipo_armado" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="tipo_armado"></div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_maniobras" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="maniobras"></div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_mantenimiento" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="mantenimiento"></div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-primary" role="status" id="carga_comentarios" style="display:none">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div id="comentarios"></div>
            </div>
        </div>
        <!-- End Card -->

    </div>
    <!-- End Content -->
</main>
<!-- ========== END MAIN CONTENT ========== -->