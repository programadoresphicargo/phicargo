<?php
require_once('../../mysql/conexion.php');
$mes = $_GET['mes'];
$año = $_GET['año'];

$monthNumber = $mes;
$monthName = date("F", mktime(0, 0, 0, $monthNumber, 10));

?>
<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Bonos Operadores <?php echo $monthName . ' ' . $año ?></h1>
                    </div>
                    <!-- End Col -->
                    <div class="col-auto">
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->
        </div>
    </div>
    <!-- End Content -->

    <!-- Content -->
    <div class="content container-fluid" style="margin-top: -18rem;">

        <!-- Card -->
        <div class="card">

            <div class="card-header">
                <div class="row justify-content-between align-items-center flex-grow-1">
                    <div class="col-md">
                        <h4 class="card-header-title">Bonos</h4>
                    </div>

                    <div class="col-auto">
                        <!-- Dropdown -->
                        <div class="dropdown me-2">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="usersExportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi-download me-2"></i> Exportar
                            </button>

                            <div class="dropdown-menu dropdown-menu-sm-end" aria-labelledby="usersExportDropdown">
                                <span class="dropdown-header">Opciones</span>
                                <a id="export-copy" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/copy.png" alt="Image Description">
                                    Copiar
                                </a>
                                <a id="export-print" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/print.png" alt="Image Description">
                                    Imprimir
                                </a>
                                <div class="dropdown-divider"></div>
                                <span class="dropdown-header">Opciones de descarga</span>
                                <a id="export-excel" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/excel.png" alt="Image Description">
                                    Excel
                                </a>
                                <a id="export-csv" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/csv.png" alt="Image Description">
                                    .CSV
                                </a>
                                <a id="export-pdf" class="dropdown-item" href="javascript:;">
                                    <img class="avatar avatar-xss avatar-4x3 me-2" src="../../img/icons/pdf.png" alt="Image Description">
                                    PDF
                                </a>
                            </div>
                        </div>
                        <!-- End Dropdown -->
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="tabla_bonos">
                </div>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Content -->
</main>
