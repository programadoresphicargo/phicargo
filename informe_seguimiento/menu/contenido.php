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
                        <?php echo imprimirCard('Reporte Gerencial', '../informe/index.php', '../../img/seguimiento.png'); ?>
                        <?php echo imprimirCard('Ingresos', '../operadores/index.php', '../../img/contabilidad.png'); ?>
                        <?php echo imprimirCard('Número de viajes', '../viajes/index.php', '../../img/volante.png'); ?>
                        <?php echo imprimirCard('Inicios de ruta y llegadas a planta', '../../reportes/llegadas_tarde/index.php', '../../img/clock.png'); ?>
                        <?php echo imprimirCard('Detenciones', '../detenciones/index.php', '../../img/stop.png'); ?>
                        <?php echo imprimirCard('Estadías', '../../viajes/estadias/index.php', '../../img/estadias.png'); ?>
                        <?php echo imprimirCard('Cumplimiento estatus', '../../reportes/porcentajes_status/index.php', '../../img/icons/app.png'); ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>

</html>