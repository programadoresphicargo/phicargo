<body class="bg-light">

    <script src="../assets/js/hs.theme-appearance.js"></script>

    <!-- ========== MAIN CONTENT ========== -->
    <main id="content" role="main" class="main">
        <!-- Content -->
        <div class="bg-dark">
            <div class="content container" style="height: 25rem;">
                <!-- Page Header -->
                <div class="page-header page-header-light page-header-reset">
                    <div class="row align-items-center">
                        <div class="col">
                            <h1 class="page-header-title">Reporte Gerencial</h1>
                        </div>

                        <div class="col-auto">
                            <input type="text" id="datepicker" class="form-control form-control-sm bg-white">
                        </div>

                        <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButtonHoverAnimation" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                    <input id="check_transportes_belchez" class="form-check-input" onchange="consultarViajes()" type="checkbox" name="estados[]" value="1">
                                                    <label class=" form-check-label" for="flexCheckChecked">
                                                        Transportes Belchez
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input id="check_phicargo" class="form-check-input" onchange="consultarViajes()" type="checkbox" name="estados[]" value="5">
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

                                                <div class="form-check">
                                                    <input id="check_ometra" class="form-check-input" onchange="consultarViajes()" type="checkbox" name="estados[]" value="4">
                                                    <label class=" form-check-label" for="flexCheckChecked">
                                                        Ometra
                                                    </label>
                                                </div>

                                            </form>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- End Dropdown -->
                        </div>

                        <div class="col-auto">
                            <!-- Dropdown -->
                            <div class="btn-group">
                                <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="dropdownMenuButtonSm" data-bs-toggle="dropdown" aria-expanded="false">
                                    Agrupar por
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonSm">

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="grupo" value="dia">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Día
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="grupo" value="semana">
                                        <label class="form-check-label" for="flexRadioDefault2">
                                            Semana
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="grupo" value="mes">
                                        <label class="form-check-label" for="flexRadioDefault1">
                                            Mes
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- End Dropdown -->
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Page Header -->
            </div>
        </div>
        <!-- End Content -->

        <!-- Content -->
        <div class="content container-fluid" style="margin-top: -20rem;">

            <!-- Sidebar Detached Content -->
            <div class=" mt-3 mt-lg-0">
                <!-- Card -->
                <div class="card" style="display: none;" id="vista_agrupada">
                    <div class="card-heard">
                    </div>
                    <div class="card-body">
                        <div id="listado_reporte">
                        </div>
                    </div>
                </div>


                <div class="card mb-3" style="display: none;" id="page_saldos">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-sm" id="abrir_cuentas">Registro de cuentas</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div id="saldos_generales"></div>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_cartera">
                    <div class="card-body p-0">
                        <div id="ingresos"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: block;" id="page_datos_servi">
                    <div class="card-header">
                        <div class="row align-items-center">

                            <div class="col-auto">
                                <img src="../../img/Servi-3.png" class="img-fluid" alt="Responsive image" width="100px">
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-success btn-sm" id="abrir_modal_datos">Ingresar datos</button>
                            </div>

                        </div>
                    </div>
                    <div class="card-body  p-2">
                        <div id="datos_servi"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_cartera">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="page-header-title">Cartera de clientes</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="cartera"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_tank">

                    <div class="card-header">
                        <div class="row align-items-center">

                            <div class="col-auto">
                                <img src="../../img/tank.jpg" class="img-fluid" alt="Responsive image" width="100px">
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-success btn-sm" id="abrir_modal_tank">Ingresar datos</button>
                            </div>

                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div id="tank"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_pagos">
                    <div class="card-body p-0">
                        <div id="pagos"></div>
                    </div>
                </div>
                <!-- End Card -->


                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_viajes_ejecutivo">
                    <div class="card-body p-2">
                        <div id="ejecutivos_viajes"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_maniobras">
                    <div class="card-body  p-2">
                        <div id="maniobras"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_tipo_armado">
                    <div class="card-body  p-2">
                        <div id="tipo_armado"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_mantenimiento">
                    <div class="card-body  p-2">
                        <div id="mantenimiento"></div>
                    </div>
                </div>
                <!-- End Card -->

                <!-- Card -->
                <div class="card mb-3" style="display: none;" id="page_comentarios">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="page-header-title">Comentarios</h4>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-success btn-sm" id="abrir_canvas_comentarios">Añadir comentario</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body ">
                        <div id="comentarios"></div>
                    </div>
                </div>
                <!-- End Card -->


            </div>
            <!-- End Sidebar Detached Content -->
        </div>
        <!-- End Content -->
    </main>
    <!-- ========== END MAIN CONTENT ========== -->