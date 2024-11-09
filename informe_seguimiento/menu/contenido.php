<?php
require_once('../../usuarios/codigo/comprobar_permiso.php');
?>

<body class="has-navbar-vertical-aside footer-offset">
    <main id="content" role="main" class="main overflow-hidden">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h1 class="page-header-title">Reportes</h1>
                    </div>
                </div>
            </div>

            <div class="tab-content" id="connectionsTabContent">
                <div class="tab-pane fade show active" id="grid" role="tabpanel" aria-labelledby="grid-tab">
                    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4">

                        <?php if (comprobar_permiso(190) == true) { ?>
                            <?php echo imprimirCard('Reporte Gerencial', '../informe/index.php', '../../img/seguimiento.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(191) == true) { ?>
                            <?php echo imprimirCard('Ingresos', '../operadores/index.php', '../../img/contabilidad.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(192) == true) { ?>
                            <?php echo imprimirCard('Número de viajes', '../viajes/index.php', '../../img/volante.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(193) == true) { ?>
                            <?php echo imprimirCard('Inicios de ruta y llegadas a planta', '../../reportes/llegadas_tarde/index.html', '../../img/clock.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(194) == true) { ?>
                            <?php echo imprimirCard('Detenciones', '../detenciones/index.php', '../../img/stop.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(195) == true) { ?>
                            <?php echo imprimirCard('Estadías', '../../viajes/estadias/index.php', '../../img/estadias.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(196) == true) { ?>
                            <?php echo imprimirCard('Cumplimiento estatus', '../../reportes/porcentajes_status/index.php', '../../img/icons/app.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(197) == true) { ?>
                            <?php echo imprimirCard('Balance de Cobro', '../../contabilidad/pago_clientes/index.php', '../../img/icons/icons-balance.png'); ?>
                        <?php } ?>

                        <?php if (comprobar_permiso(198) == true) { ?>
                            <?php echo imprimirCard('Mantenimiento de Tractos', '../../mantenimiento/equipos/index.php', '../../img/icons/maintenance_icon.png'); ?>
                            <?php } ?>

                        <?php echo imprimirCard('Reporte de Operaciones', '../../operaciones/reporte_diario/index.php', '../../img/icons/trailer_icon.png'); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>