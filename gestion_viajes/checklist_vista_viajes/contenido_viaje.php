<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sqlInfo = "SELECT * FROM viajes inner join operadores on operadores.id = viajes.employee_id where viajes.id = $id_viaje";
$resultadoInfo = $cn->query($sqlInfo);
$row3 = $resultadoInfo->fetch_assoc();

?>

<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title"><?php echo $row3['referencia'] ?></h1>
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
    <div class="row">
        <div class="col-sm-12 col-lg-3">
            <div class="content container-fluid" style="margin-top: -18rem;">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header card-header-content-between">
                        <h4 class="card-header-title"><?php echo $row3['referencia'] ?></h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <ul class="list-unstyled list-py-2 text-dark mb-0">
                            <li class="pb-0"><span class="card-subtitle">DATOS DEL VIAJE</span></li>
                            <li><i class="bi-person dropdown-item-icon"></i>Sucursal:</li>
                            <li class="fs-6 text-body"><?php echo $row3['store_id'] ?></li>

                            <li><i class="bi-person dropdown-item-icon"></i>Fecha:</li>
                            <li class="fs-6 text-body"><?php echo $row3['date_order'] ?></li>

                            <li><i class="bi-person dropdown-item-icon"></i>Operador:</li>
                            <li class="fs-6 text-body"><?php echo $row3['nombre_operador'] ?></li>

                            <li><i class="bi-person dropdown-item-icon"></i>Modo2:</li>
                            <li class="fs-6 text-body"><?php echo $row3['x_modo_bel'] ?></li>

                        </ul>
                    </div>
                    <!-- End Body -->
                </div>
                <!-- End Card -->
            </div>
            <!-- End Content -->
        </div>
        <div class="col">
            <div class="content container-fluid" style="margin-top: -18rem;">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <div class="card-body">
                        <!-- Title -->
                        <div id="contenido_checklist_equipos">
                        </div>
                        <!-- End Title -->
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Content -->
        </div>
    </div>
</main>
<!-- ========== END MAIN CONTENT ========== -->