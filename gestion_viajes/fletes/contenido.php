<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid m-0 p-0">
        <!-- Card -->
        <div class="card rounded-0">
            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-lg-2 col-sm-12">
                        <h1 class="text-primary">Gestion de fletes</h1>
                    </div>
                    <div class="col-md">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Nav -->
                            <ul class="nav nav-segment" id="myNav">
                                <?php if (comprobar_permiso(105) == true) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#" pes="0">Todo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" pes="1">En ruta<span id="cr" class="badge bg-primary rounded-pill ms-1">0</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" pes="2">En planta<span id="cp" class="badge bg-success rounded-pill ms-1">0</span></a>
                                    </li>
                                <?php } ?>
                                <?php if (comprobar_permiso(106) == true) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" pes="3">Retorno<span id="cre" class="badge bg-warning rounded-pill ms-1">0</span></a>
                                    </li>
                                <?php } ?>
                                <?php if (comprobar_permiso(105) == true) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" pes="4">Disponible</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" pes="5">Resguardo<span id="res" class="badge bg-morado rounded-pill ms-1">0</span></a>
                                    </li>
                                <?php } ?>
                            </ul>
                            <!-- End Nav -->

                            <button class="btn btn-success btn-sm" type="button" id="abrirmodalenviomasivo"><i class="bi bi-send"></i> Envío estatus masivo</button>
                            <button class="btn btn-secondary btn-sm" type="button" id="abrirviajesprogramados"><i class="bi bi-clock"></i> Programación</button>
                        </div>
                    </div>

                    <div class="col-auto">
                        <!-- Filter -->
                        <div class="row align-items-sm-center">

                            <div class="col-sm-auto">
                                <div class="row align-items-center gx-0">

                                    <div class="col-auto">
                                        <!-- Dropdown -->
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>
                                                <i class="bi bi-funnel-fill"></i> Agrupar por
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="0"> Sucursal
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="1"> Referencia
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="2"> Estado
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="5"> Tipo de armado
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="6"> Medida
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="8"> Ejecutivo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="9"> Operador
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="10"> Unidad
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="15"> Ruta
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="17"> Tipo
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="18"> Inicio prog.
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="19"> Llegada a planta prog
                                                </label>
                                                <label class="dropdown-item">
                                                    <input type="checkbox" value="21"> Cliente
                                                </label>
                                            </div>
                                        </div>
                                        <!-- End Dropdown -->
                                    </div>
                                    <!-- End Col -->
                                </div>
                                <!-- End Row -->
                            </div>
                            <!-- End Col -->
                        </div>
                    </div>
                </div>
            </div>

            <div id="tabla" class="card-body p-0 m-0 text-center position-static">
                <img src="../../img/viaje.gif" style="width: 25%">
            </div>
        </div>
    </div>
</main>