<?php
require_once('../../mysql/conexion.php');
require_once('../../usuarios/codigo/comprobar_permiso.php');
session_start();
$cn = conectar();

if (isset($_SESSION['userID'])) {
    $idVal = $_SESSION['userID'];
    $sqlValidar = "SELECT * from usuarios where id_usuario = $idVal and estado = 'Activo'";
    $resultadoVal = $cn->query($sqlValidar);
    $rowPermisos = $resultadoVal->fetch_assoc();
    $tipo_usuario = $rowPermisos['tipo'];

    if ($resultadoVal->num_rows > 0) {
        if (!$_SESSION['logueado']) {
            header("Location: ../../login/inicio/index.php");
        }
    } else {
        header("Location: ../../login/inicio/index.php");
    }
} else {
    header("Location: ../../login/inicio/index.php");
}

?>
<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $titulo ?></title>
    <link rel="shortcut icon" href="../../img/philogo-morado.png">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/vendor.min.css?v=1.0">
    <link rel="stylesheet" href="../../assets/css/theme.min.css?v=2.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preload" href="../../assets/css/estilosfont.css" data-hs-appearance="default" as="style">
    <!--
    <link rel="stylesheet" href="../../assets/css/theme-dark.min.css" data-hs-appearance="dark" as="style">
    --->
    <link rel="stylesheet" href="../../assets/css/miccs.css?v=2.0" as="style">
    <link rel="stylesheet" href="../../assets/css/cssviaje.css?v=6.0" as="style">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="../../assets/css/rowGroup.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/2.3.1/css/searchPanes.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.2/css/select.bootstrap5.css">
    <link rel="stylesheet" href="../../assets/css/buttons.dataTables.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/searchbuilder/1.7.1/css/searchBuilder.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css">

    <link rel="stylesheet" href="../../assets/css/cssespecial.css">
    <script src="https://unpkg.com/dropzone@6.0.0-beta.1/dist/dropzone-min.js"></script>


    <?php if ($titulo == 'Disponibilidad de Unidades') { ?>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <?php } ?>

    <?php
    require_once('../../gestion_viajes/detenciones/modal_detencion.php');
    ?>

    <style>
        .accordion-button::after {
            display: none;
        }

        .accordion-header {
            padding-right: 0;
        }
    </style>

</head>

<body>

    <script src="../../assets/js/hs.theme-appearance.js"></script>

    <!-- Header -->
    <header class="docs-navbar navbar navbar-expand-lg navbar-end navbar-light bg-white" style="height:60px">
        <div class="container">
            <div class="js-mega-menu navbar-nav-wrap">
                <!-- Logo -->
                <a class="navbar-brand" href="../../menu/principal/index.php" aria-label="Front">
                    <img class="" src="../../img/philogo-morado.png" alt="Logo" style="max-width: 35px;">
                    <img class="" src="../../img/logoazul.png" alt="Logo" style="max-width: 140px;">
                </a>
                <!-- End Logo -->

                <!-- Toggle -->
                <button type="button" class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#navbarNavMenuWithMegaMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarNavMenuWithMegaMenu">
                    <span class="navbar-toggler-default">
                        <i class="bi-list"></i>
                    </span>
                    <span class="navbar-toggler-toggled">
                        <i class="bi-x"></i>
                    </span>
                </button>
                <!-- End Toggle -->

                <nav class="navbar-nav-wrap-col collapse navbar-collapse" id="navbarNavMenuWithMegaMenu">
                    <!-- Navbar -->
                    <ul class="navbar-nav">

                        <?php if (comprobar_permiso(8) == true) { ?>
                            <!-- Dashboards -->
                            <li class="hs-has-sub-menu nav-item">
                                <a id="dashboardsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle" href="#" role="button"><i class="bi bi-list-ol dropdown-item-icon"></i> Turnos</a>
                                <!-- Mega Menu -->
                                <div class="hs-sub-menu dropdown-menu" aria-labelledby="dashboardsMegaMenu" style="min-width: 14rem;">
                                    <a class="dropdown-item" href="../../turnos/vista/index.php?sucursal=veracruz">Veracruz</a>
                                    <a class="dropdown-item" href="../../turnos/vista/index.php?sucursal=manzanillo">Manzanillo</a>
                                    <a class="dropdown-item" href="../../turnos/vista/index.php?sucursal=mexico">México</a>
                                </div>
                                <!-- End Mega Menu -->
                            </li>
                            <!-- End Dashboards -->
                        <?php } ?>

                        <!-- Dashboards -->
                        <li class="hs-has-sub-menu nav-item">
                            <a id="dashboardsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle" href="#" role="button"><i class="bi bi-truck dropdown-item-icon"></i> Gestión de fletes</a>

                            <!-- Mega Menu -->
                            <div class="hs-sub-menu dropdown-menu " aria-labelledby="dashboardsMegaMenu" style="min-width: 14rem;">
                                <?php if (comprobar_permiso(101) == true) { ?>
                                    <a class="dropdown-item" href="../../gestion_viajes/fletes/index.php">Viajes</a>
                                <?php } ?>

                                <?php if (comprobar_permiso(102) == true) { ?>
                                    <a class="dropdown-item" href="../../gestion_viajes/finalizados/index.php">Finalizados</a>
                                <?php } ?>

                                <?php if (comprobar_permiso(103) == true) { ?>
                                    <a class="dropdown-item" href="../../gestion_viajes/banco/index.php">Banco de correos</a>
                                <?php } ?>

                                <?php if (comprobar_permiso(104) == true) { ?>
                                    <a class="dropdown-item" href="../../detenciones/vista/index.php">Detenciones</a>
                                <?php } ?>

                                <a class="dropdown-item" href="../../solicitudes/listado/index.php">Solicitudes</a>

                                <div class="hs-has-sub-menu nav-item">
                                    <a id="accountMegaMenu" class="hs-mega-menu-invoker dropdown-item dropdown-toggle " href="#" role="button">Checklist</a>

                                    <div class="hs-sub-menu dropdown-menu " aria-labelledby="accountMegaMenu" style="min-width: 14rem;">
                                        <a class="dropdown-item " href="../../viajes/checklist_vista_viajes/index.php">Viajes</a>
                                        <a class="dropdown-item " href="../../viajes/checklist_vista_viajes/index.php">Maniobras</a>
                                    </div>
                                </div>

                                <a class="dropdown-item" href="../../reportes/llegadas_tarde/index.html#/asignacion">Asignación de unidades</a>
                                <a class="dropdown-item" href="../../gestion_viajes/estadias/index.php">Estadías</a>
                                <a class="dropdown-item" href="../../gestion_viajes/incidencias/index.php">Incidencias</a>

                                <div class="hs-has-sub-menu nav-item">
                                    <a id="accountMegaMenu" class="hs-mega-menu-invoker dropdown-item dropdown-toggle " href="#" role="button">Ajustes</a>

                                    <div class="hs-sub-menu dropdown-menu " aria-labelledby="accountMegaMenu" style="min-width: 14rem;">
                                        <a class="dropdown-item " href="../../control_estatus/panel/index.php">Registro de estatus</a>
                                    </div>
                                </div>

                            </div>
                            <!-- End Mega Menu -->
                        </li>
                        <!-- End Dashboards -->

                        <!-- Apps -->
                        <li class="hs-has-sub-menu nav-item">
                            <a id="appsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button"><i class="bi bi-truck dropdown-item-icon"></i> Maniobras</a>

                            <div class="hs-sub-menu dropdown-menu " aria-labelledby="appsMegaMenu" style="min-width: 14rem;">
                                <a class="dropdown-item" href="../../modulo_maniobras/react/index.html">Nuevo modulo maniobras</a>
                            </div>
                        </li>
                        <!-- End Apps -->

                        <!-- Apps -->
                        <li class="hs-has-sub-menu nav-item">
                            <a id="appsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button"><i class="bi bi-display dropdown-item-icon"></i> Monitoreo</a>

                            <div class="hs-sub-menu dropdown-menu " aria-labelledby="appsMegaMenu" style="min-width: 14rem;">
                                <a class="dropdown-item" href="../../monitoreo/entrega/index.php">Entrega de turno</a>
                                <a class="dropdown-item" href="../reportes/index.php">Reportes</a>
                            </div>
                        </li>
                        <!-- End Apps -->


                        <!-- Apps -->
                        <li class="hs-has-sub-menu nav-item">
                            <a id="appsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button"><i class="bi bi-truck-flatbed dropdown-item-icon"></i> Disponibilidad</a>

                            <div class="hs-sub-menu dropdown-menu" aria-labelledby="appsMegaMenu" style="min-width: 14rem;">
                                <a class="dropdown-item" href="../../disponibilidad/equipos/index.php">Unidades</a>
                                <a class="dropdown-item" href="../../disponibilidad/operadores/index.php">Operadores</a>
                            </div>
                        </li>
                        <!-- End Apps -->

                        <!-- Apps -->
                        <li class="hs-has-sub-menu nav-item">
                            <a id="appsMegaMenu" class="hs-mega-menu-invoker nav-link dropdown-toggle " href="#" role="button"><i class="bi bi-person-circle dropdown-item-icon"></i> Operadores</a>

                            <div class="hs-sub-menu dropdown-menu" aria-labelledby="appsMegaMenu" style="min-width: 14rem;">
                                <a class="dropdown-item" href="../../operadores/contactos/index.php">Contactos</a>

                                <?php if (comprobar_permiso(7) == true) { ?>
                                    <a class="dropdown-item" href="../../operadores/cuentas/index.php">Cuentas</a>
                                <?php } ?>

                            </div>
                        </li>
                        <!-- End Apps -->

                        <?php
                        require_once('notificaciones_problemas.php');

                        require_once('notificaciones_alertas.php');

                        require_once('notificaciones_estatus_operador.php');
                        ?>

                        <li class="nav-item d-none d-md-inline-block">
                            <div class="dropdown">
                                <button type="button" class="btn btn-icon rounded-circle" id="notificaciones_detenciones" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                                    <i class="bi bi-sign-stop"></i>
                                </button>

                                <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="navbarNotificationsDropdown" style="width: 45rem;">
                                    <div class="card">
                                        <div class="card-header card-header-content-between">
                                            <h4 class="card-title mb-0">Notificaciones</h4>
                                        </div>
                                        <div class="card-body-height" style="height: 45rem;">
                                            <div id="alertas-detenciones">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a class="text-center link link-primary" href="../../gestion_viajes/detenciones/index.php">
                                                Ver más reportes de detención
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <!-- Account -->
                            <div class="dropdown">
                                <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                                    <div class="avatar avatar-sm avatar-circle">
                                        <img class="avatar-img" src="../../img/auxuser.png" alt="Image Description">
                                        <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                    </div>
                                </a>

                                <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
                                    <div class="dropdown-item-text">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm avatar-circle">
                                                <img class="avatar-img" src="../../img/auxuser.png" alt="Image Description">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-0"><?php echo $_SESSION['nombre'] ?></h5>
                                                <p class="card-text text-body"><?php echo $_SESSION['userName'] ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item" id="logoutButton" type="button">Cerrar sesión</a>
                                </div>
                            </div>
                            <!-- End Account -->
                        </li>
                    </ul>
                    <!-- End Navbar -->
                </nav>
            </div>
        </div>
    </header>
    <!-- End Header -->