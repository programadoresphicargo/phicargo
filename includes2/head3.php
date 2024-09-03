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

    <header class="docs-navbar navbar navbar-expand-lg navbar-end navbar-light bg-white" style="height:60px">
        <div class="container">
            <div class="js-mega-menu navbar-nav-wrap">
                <a class="navbar-brand" href="../../menu/principal/index.php" aria-label="Front">
                    <img class="" src="../../img/philogo-morado.png" alt="Logo" style="max-width: 35px;">
                    <img class="" src="../../img/logoazul.png" alt="Logo" style="max-width: 140px;">
                </a>

                <button type="button" class="navbar-toggler ms-auto" data-bs-toggle="collapse" data-bs-target="#navbarNavMenuWithMegaMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarNavMenuWithMegaMenu">
                    <span class="navbar-toggler-default">
                        <i class="bi-list"></i>
                    </span>
                    <span class="navbar-toggler-toggled">
                        <i class="bi-x"></i>
                    </span>
                </button>

                <nav class="navbar-nav-wrap-col collapse navbar-collapse" id="navbarNavMenuWithMegaMenu">
                    <ul class="navbar-nav">

                        <li class="nav-item">
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
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>