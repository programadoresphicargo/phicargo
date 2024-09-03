<?php
require_once('../../mysql/conexion.php');
require_once('../../usuarios/codigo/comprobar_permiso.php');

$cn = conectar();
$id = $_SESSION['userID'];
$sqlSelect = "SELECT * from permisos_usuarios where id_usuario = $id";
$resultado = $cn->query($sqlSelect);
$row = $resultado->fetch_assoc();
?>

<body class="has-navbar-vertical-aside navbar-vertical-aside-show-xl   footer-offset">

    <script src="../../assets/js/hs.theme-appearance.js"></script>

    <script src="../../assets/js/hs-navbar-vertical-aside-mini-cache.js"></script>

    <!-- ========== HEADER ========== -->

    <header id="header" class="navbar navbar-expand-lg navbar-fixed navbar-height navbar-container navbar-bordered bg-white">
        <div class="navbar-nav-wrap">
            <!-- Logo -->
            <a class="navbar-brand" href="./index.html" aria-label="Front">
                <img class="navbar-brand-logo" src="../../img/logoacolor.png" alt="Logo" data-hs-theme-appearance="default">
                <img class="navbar-brand-logo" src="../../img/logoacolor.png" alt="Logo" data-hs-theme-appearance="dark">
                <img class="navbar-brand-logo-mini" src="../../img/logoacolor.png" alt="Logo" data-hs-theme-appearance="default">
                <img class="navbar-brand-logo-mini" src="../../img/logoacolor.png" alt="Logo" data-hs-theme-appearance="dark">
            </a>
            <!-- End Logo -->

            <div class="navbar-nav-wrap-content-start">
                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                    <i class="bi bi-arrow-left navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                    <i class="bi bi-arrow-right navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
                </button>

                <!-- End Navbar Vertical Toggle -->
            </div>

            <div class="navbar-nav-wrap-content-end">
                <!-- Navbar -->
                <ul class="navbar-nav">

                    <li class="nav-item d-none d-sm-inline-block">
                        <!-- Notification -->
                        <div class="dropdown">
                            <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle" id="navbarNotificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                                <i class="bi-bell"></i>
                                <span class="btn-status btn-sm-status btn-status-danger"></span>
                            </button>

                            <div class="dropdown-menu dropdown-menu-end dropdown-card navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="navbarNotificationsDropdown" style="width: 35rem;">
                                <div class="card">
                                    <!-- Header -->
                                    <div class="card-header card-header-content-between">
                                        <h4 class="card-title mb-0">Notificaciones</h4>
                                    </div>
                                    <!-- End Header -->

                                    <!-- Nav -->
                                    <ul class="nav nav-tabs nav-justified" id="notificationTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#notificationNavOne" id="notificationNavOne-tab" data-bs-toggle="tab" data-bs-target="#notificationNavOne" role="tab" aria-controls="notificationNavOne" aria-selected="true">Reportes de viaje</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#notificationNavTwo" id="notificationNavTwo-tab" data-bs-toggle="tab" data-bs-target="#notificationNavTwo" role="tab" aria-controls="notificationNavTwo" aria-selected="false">Reporte de maniobras</a>
                                        </li>
                                    </ul>
                                    <!-- End Nav -->

                                    <!-- Body -->
                                    <div class="card-body-height">
                                        <!-- Tab Content -->
                                        <div class="tab-content" id="notificationTabContent">
                                            <div class="tab-pane fade show active" id="notificationNavOne" role="tabpanel" aria-labelledby="notificationNavOne-tab">
                                                <div class="div" id="notificaciones">
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="notificationNavTwo" role="tabpanel" aria-labelledby="notificationNavTwo-tab">
                                                <div class="div" id="notificaciones_maniobras">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Tab Content -->
                                    </div>
                                    <!-- End Body -->

                                    <!-- Card Footer -->
                                    <a class="card-footer text-center link link-primary" href="../../viajes/reportes/index.php">
                                        Ver todos los reportes
                                    </a>
                                    <!-- End Card Footer -->
                                </div>
                            </div>
                        </div>
                        <!-- End Notification -->
                    </li>


                    <li class="nav-item">
                        <!-- Account -->
                        <div class="dropdown">
                            <a class="navbar-dropdown-account-wrapper" href="javascript:;" id="accountNavbarDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" data-bs-dropdown-animation>
                                <div class="avatar avatar-sm avatar-circle">
                                    <img class="avatar-img" src="../../img/usuario.png" alt="Image Description">
                                    <span class="avatar-status avatar-sm-status avatar-status-success"></span>
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown-menu navbar-dropdown-menu-borderless navbar-dropdown-account" aria-labelledby="accountNavbarDropdown" style="width: 16rem;">
                                <div class="dropdown-item-text">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm avatar-circle">
                                            <img class="avatar-img" src="../../img/usuario.png" alt="Image Description">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-0"><?php echo $_SESSION['nombre']; ?></h5>
                                            <p class="card-text text-body"><?php echo $_SESSION['userTipo']; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logoutModal">Cerrar sesión</a>
                            </div>
                        </div>
                        <!-- End Account -->
                    </li>
                </ul>
                <!-- End Navbar -->
            </div>
        </div>
    </header>

    <!-- ========== END HEADER ========== -->

    <!-- ========== MAIN CONTENT ========== -->
    <!-- Navbar Vertical -->

    <aside class="js-navbar-vertical-aside navbar navbar-vertical-aside navbar-vertical navbar-vertical-fixed navbar-expand-xl navbar-bordered bg-light">
        <div class="navbar-vertical-container">
            <div class="navbar-vertical-footer-offset">
                <!-- Logo -->

                <a class="navbar-brand" href="../../menu/principal/index.php" aria-label="Front">
                    <img class="navbar-brand-logo mt-8" src="../../img/logoacolor.png" alt="Logo" data-hs-theme-appearance="default">
                    <img class="navbar-brand-logo mt-8" src="../../img/lp.png" alt="Logo" data-hs-theme-appearance="dark">
                    <img class="navbar-brand-logo-mini" src="../../img/logoacolor.png" alt="Logo" data-hs-theme-appearance="default">
                    <img class="navbar-brand-logo-mini" src="../../img/logo_1.png" alt="Logo" data-hs-theme-appearance="dark">
                </a>

                <!-- End Logo -->

                <!-- Navbar Vertical Toggle -->
                <button type="button" class="js-navbar-vertical-aside-toggle-invoker navbar-aside-toggler">
                    <i class="bi bi-list navbar-toggler-short-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Collapse"></i>
                    <i class="bi bi-list navbar-toggler-full-align" data-bs-template='<div class="tooltip d-none d-md-block" role="tooltip"><div class="arrow"></div><div class="tooltip-inner"></div></div>' data-bs-toggle="tooltip" data-bs-placement="right" title="Expand"></i>
                </button>

                <!-- End Navbar Vertical Toggle -->

                <!-- Content -->
                <div class="navbar-vertical-content">
                    <div id="navbarVerticalMenu" class="nav nav-pills nav-vertical card-navbar-nav">

                        <span class="dropdown-header mt-4">Modulos</span>
                        <small class="bi-three-dots nav-subtitle-replacer"></small>

                        <!-- Collapse -->
                        <div class="navbar-nav nav-compact">

                        </div>
                        <div id="navbarVerticalMenuPagesMenu">
                            <!-- Collapse -->
                            <?php if (comprobar_permiso(8) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesUsersMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUsersMenu" aria-expanded="false" aria-controls="navbarVerticalMenuPagesUsersMenu">
                                        <i class="bi bi-list-ol nav-icon"></i>
                                        <span class="nav-link-title">Turnos</span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesUsersMenu" class="nav-collapse collapse " data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <a class="nav-link " id="select_veracruz" href="../../turnos/turnos_veracruz/index.php">Veracruz</a>
                                        <a class="nav-link " id="select_mzn" href="../../turnos/turnos_manzanillo/index.php">Manzanillo</a>
                                        <a class="nav-link " id="select_mzn" href="../../turnos/turnos_manzanillo/index.php">México</a>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- End Collapse -->

                            <!-- Collapse -->
                            <?php if (comprobar_permiso(1) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle" href="#navbarVerticalMenuPagesUserProfileMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesUserProfileMenu" aria-expanded="true" aria-controls="navbarVerticalMenuPagesUserProfileMenu">
                                        <i class="bi bi-truck nav-icon"></i>
                                        <span class="nav-link-title">Gestión de fletes</span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesUserProfileMenu" class="nav-collapse collapse" data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <?php if (comprobar_permiso(101) == true) { ?>
                                            <a class="nav-link" href="../../viajes/fletes/index.php">Viajes</a>
                                        <?php } ?>

                                        <?php if (comprobar_permiso(102) == true) { ?>
                                            <a class="nav-link " href="../../viajes/finalizados/index.php">Finalizados</a>
                                        <?php } ?>

                                        <?php if (comprobar_permiso(103) == true) { ?>
                                            <a class="nav-link " href="../../correos/banco/index.php">Banco de correos</a>
                                        <?php } ?>

                                        <?php if (comprobar_permiso(104) == true) { ?>
                                            <a class="nav-link " href="../../detenciones/vista/index.php">Detenciones</a>
                                        <?php } ?>

                                    </div>
                                </div>
                            <?php } ?>

                            <!-- End Collapse -->

                            <!-- Collapse -->
                            <?php if (comprobar_permiso(38) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesAccountMenu5" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesAccountMenu5" aria-expanded="false" aria-controls="navbarVerticalMenuPagesAccountMenu5">
                                        <i class="bi bi-truck-flatbed nav-icon"></i>
                                        <span class="nav-link-title">Maniobras</span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesAccountMenu5" class="nav-collapse collapse " data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <a class="nav-link" href="../../maniobras/control/index.php">Control de maniobras</a>
                                        <a class="nav-link" href="../../maniobras/solicitudes_transporte/index.php">Solicitudes de transporte</a>
                                        <a class="nav-link" href="../../maniobras/cartas_porte/index.php">Cartas Porte</a>
                                        <a class="nav-link" href="../../maniobras/contenedores/index.php">Contenedores</a>
                                    </div>
                                </div>
                            <?php } ?>
                            <!-- End Collapse -->

                            <?php if (comprobar_permiso(40) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesAccountMenu6" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesAccountMenu6" aria-expanded="false" aria-controls="navbarVerticalMenuPagesAccountMenu6">
                                        <i class="bi bi-truck nav-icon"></i>
                                        <span class="nav-link-title">Monitoreo</span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesAccountMenu6" class="nav-collapse collapse " data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <a class="nav-link " href="../../monitoreo/entrega/index.php">Entrega de turno</a>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php if (comprobar_permiso(2) == true) { ?>

                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesAccountMenu6" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesAccountMenu6" aria-expanded="false" aria-controls="navbarVerticalMenuPagesAccountMenu6">
                                        <i class="bi bi-truck nav-icon"></i>
                                        <span class="nav-link-title">Disponibilidad</span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesAccountMenu6" class="nav-collapse collapse " data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <a class="nav-link " href="../../disponibilidad/equipos/index.php">Equipos</a>
                                        <a class="nav-link " href="../../disponibilidad/operadores/index.php">Operadores</a>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- Collapse -->
                            <?php if (comprobar_permiso(1) == true) { ?>

                                <div class="nav-item">
                                    <a class="nav-link " href="../../status/maniobras.php/index.php" data-placement="left">
                                        <i class="bi bi-exclamation-diamond-fill nav-icon"></i>
                                        <span class="nav-link-title">Status</span>
                                    </a>
                                </div>

                            <?php } ?>
                            <!-- End Collapse -->

                            <!-- Collapse -->
                            <?php if (comprobar_permiso(7) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link dropdown-toggle " href="#navbarVerticalMenuPagesAccountMenu" role="button" data-bs-toggle="collapse" data-bs-target="#navbarVerticalMenuPagesAccountMenu" aria-expanded="false" aria-controls="navbarVerticalMenuPagesAccountMenu">
                                        <i class="bi-person-badge nav-icon"></i>
                                        <span class="nav-link-title">Operadores</span>
                                    </a>

                                    <div id="navbarVerticalMenuPagesAccountMenu" class="nav-collapse collapse " data-bs-parent="#navbarVerticalMenuPagesMenu">
                                        <?php if (comprobar_permiso(7) == true) { ?>
                                            <a class="nav-link " href="../../operadores/cuentas/index.php">Cuentas operadores</a>
                                        <?php } ?>

                                        <a class="nav-link " href="../../operadores/contactos/index.php">Contactos</a>
                                        <a class="nav-link " href="../../operadores/unidades/index.php">Unidades</a>
                                        <a class="nav-link " href="../../operadores/ubicaciones/index.php">Ubicaciones</a>
                                    </div>
                                </div>
                            <?php } ?>

                            <!-- End Collapse -->
                            <?php if (comprobar_permiso(3) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link " href="../../bonos/vista/index.php" data-placement="left">
                                        <i class="bi bi-cash nav-icon"></i>
                                        <span class="nav-link-title">Bonos</span>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if (comprobar_permiso(4) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link " href="../../reportes/status/index.php" data-placement="left">
                                        <i class="bi bi-file-earmark-text-fill nav-icon"></i>
                                        <span class="nav-link-title">Reportes</span>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if (comprobar_permiso(5) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link " href="../../usuarios/usuarios/index.php" data-placement="left">
                                        <i class="bi bi-people-fill nav-icon"></i>
                                        <span class="nav-link-title">Usuarios</span>
                                    </a>
                                </div>
                            <?php } ?>

                            <?php if (comprobar_permiso(2) == true) { ?>
                                <div class="nav-item">
                                    <a class="nav-link " href="../../ajustes/configuraciones/index.php" data-placement="left">
                                        <i class="bi bi-key-fill nav-icon"></i>
                                        <span class="nav-link-title">Ajustes</span>
                                    </a>
                                </div>
                            <?php } ?>

                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="navbar-vertical-footer">
                    <ul class="navbar-vertical-footer-list">

                        <li class="navbar-vertical-footer-list-item">
                            <div id="builderOffcanvas" class="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBuilder" aria-controls="offcanvasBuilder">
                                <a class="btn btn-ghost-secondary btn-icon rounded-circle" href="javascript:;">
                                    <i class="bi bi-brush fs-6 me-2"></i>
                                </a>
                            </div>
                        </li>

                        <li class="navbar-vertical-footer-list-item">
                            <!-- Style Switcher -->
                            <div class="dropdown dropup">
                                <button type="button" class="btn btn-ghost-secondary btn-icon rounded-circle" id="selectThemeDropdown" data-bs-toggle="dropdown" aria-expanded="false" data-bs-dropdown-animation>

                                </button>

                                <div class="dropdown-menu navbar-dropdown-menu navbar-dropdown-menu-borderless" aria-labelledby="selectThemeDropdown">
                                    <a class="dropdown-item" href="#" data-icon="bi-moon-stars" data-value="auto">
                                        <i class="bi-moon-stars me-2"></i>
                                        <span class="text-truncate" title="Auto (system default)">Auto</span>
                                    </a>
                                    <a class="dropdown-item" href="#" data-icon="bi-brightness-high" data-value="default">
                                        <i class="bi-brightness-high me-2"></i>
                                        <span class="text-truncate" title="Default (light mode)">Claro</span>
                                    </a>
                                    <a class="dropdown-item active" href="#" data-icon="bi-moon" data-value="dark">
                                        <i class="bi-moon me-2"></i>
                                        <span class="text-truncate" title="Dark">Oscuro</span>
                                    </a>
                                </div>
                            </div>

                            <!-- End Style Switcher -->
                        </li>
                    </ul>
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </aside>