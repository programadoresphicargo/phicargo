<?php

require_once('../../mysql/conexion_servi.php');
$cn = conectar_servi();
$fecha = $_POST['fecha'];
$sql = "SELECT * FROM datos_servi where fecha = '$fecha'";
$resultado = $cn->query($sql);
?>

<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover table-striped table-sm">
    <thead class="thead-light">
        <tr>
            <th scope="col">Servicontainer</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) {

            echo "<script>";
            echo "var datosServiArray = {";
            echo "  bodega_1: '{$row['bodega_1']}',";
            echo "  bodega_2: '{$row['bodega_2']}',";
            echo "  bodega_3: '{$row['bodega_3']}',";
            echo "  bodega_4: '{$row['bodega_4']}'";
            echo "};";
            echo "</script>";

        ?>
            <tr>
                <th>
                    <h4>
                        <?php
                        $marcaTiempo = strtotime($row['fecha']);
                        echo $fechaSinHora = date("Y-m-d", $marcaTiempo);
                        ?>
                    </h4>
                </th>
                <th>
                    <button class="btn btn-success btn-sm" onclick="obtener_datos_2('<?php echo $row['id_dato'] ?>','<?php echo $row['maniobras_ingresos_bodega'] ?>','<?php echo $row['maniobras_salidas_bodega'] ?>','<?php echo $row['bodega_1'] ?>','<?php echo $row['bodega_2'] ?>','<?php echo $row['bodega_3'] ?>','<?php echo $row['bodega_4'] ?>')">Editar</button>
                </th>
            </tr>
            <tr>
                <th>Maniobras de Ingreso a bodega</th>
                <th>
                    <?php echo $row['maniobras_ingresos_bodega'] ?>
                </th>
            </tr>
            <tr>
                <th>Maniobras de Salida de bodega</th>
                <th>
                    <?php echo $row['maniobras_salidas_bodega'] ?>
                </th>
            </tr>
            <tr>
                <th>% Ocupación Bodega 1</th>
                <th>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['bodega_1'] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $row['bodega_1'] ?>%</div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>% Ocupación Bodega 2</th>
                <th>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['bodega_2'] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $row['bodega_2'] ?>%</div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>% Ocupación Bodega 3</th>
                <th>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['bodega_3'] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $row['bodega_3'] ?>%</div>
                    </div>
                </th>
            </tr>
            <tr>
                <th>% Ocupación Bodega 4</th>
                <th>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: <?php echo $row['bodega_4'] ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo $row['bodega_4'] ?>%</div>
                    </div>
                </th>
            </tr>
        <?php } ?>
    </tbody>
</table>

<div class="row p-5">
    <div class="col">
        <canvas id="miGraficoDoughnut1" width="300" height="300"></canvas>
    </div>
    <div class="col">
        <canvas id="miGraficoDoughnut2" width="300" height="300"></canvas>
    </div>
    <div class="col">
        <canvas id="miGraficoDoughnut3" width="300" height="300"></canvas>
    </div>
    <div class="col">
        <canvas id="miGraficoDoughnut4" width="300" height="300"></canvas>
    </div>
</div>

<script>
    function obtener_datos_2(id_dato, ingresos, salidas, bodega1, bodega2, bodega3, bodega4) {
        $('#modal_datos_servi').modal('show');
        $('#id_dato').val(id_dato);
        $('#ingresos2').val(ingresos);
        $('#salidas').val(salidas);
        $('#bodega_1').val(bodega1);
        $('#bodega_2').val(bodega2);
        $('#bodega_3').val(bodega3);
        $('#bodega_4').val(bodega4);
    }

    // Obtén el contexto del lienzo
    if (typeof datosServiArray !== 'undefined' && datosServiArray !== null) {
        if (datosServiArray) {
            console.log(datosServiArray.bodega_1);
            console.log(datosServiArray.bodega_2);
            console.log(datosServiArray.bodega_3);
            console.log(datosServiArray.bodega_4);

            var ctx1 = document.getElementById('miGraficoDoughnut1').getContext('2d');
            var ctx2 = document.getElementById('miGraficoDoughnut2').getContext('2d');
            var ctx3 = document.getElementById('miGraficoDoughnut3').getContext('2d');
            var ctx4 = document.getElementById('miGraficoDoughnut4').getContext('2d');

            var datos1 = {
                labels: ['Usado', 'Libre'],
                datasets: [{
                    data: [datosServiArray.bodega_1, datosServiArray.bodega_1 - 100],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
                }]
            };

            var datos2 = {
                labels: ['Usado', 'Libre'],
                datasets: [{
                    data: [datosServiArray.bodega_2, datosServiArray.bodega_2 - 100],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
                }]
            };

            var datos3 = {
                labels: ['Usado', 'Libre'],
                datasets: [{
                    data: [datosServiArray.bodega_3, datosServiArray.bodega_3 - 100],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
                }]
            };

            var datos4 = {
                labels: ['Usado', 'Libre'],
                datasets: [{
                    data: [datosServiArray.bodega_4, 100 - datosServiArray.bodega_4],
                    backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)']
                }]
            };

            var opciones1 = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Bodega 1'
                    }
                },
            };

            var opciones2 = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Bodega 2'
                    }
                },
            };

            var opciones3 = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Bodega 3'
                    }
                },
            };

            var opciones4 = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Bodega 4'
                    }
                },
            };

            var miGraficoDoughnut1 = new Chart(ctx1, {
                type: 'doughnut',
                data: datos1,
                options: opciones1
            });

            var miGraficoDoughnut2 = new Chart(ctx2, {
                type: 'doughnut',
                data: datos2,
                options: opciones2
            });

            var miGraficoDoughnut3 = new Chart(ctx3, {
                type: 'doughnut',
                data: datos3,
                options: opciones3
            });

            var miGraficoDoughnut4 = new Chart(ctx4, {
                type: 'doughnut',
                data: datos4,
                options: opciones4
            });

        } else {
            console.log("No se encontraron registros.");
        }
    } else {
        console.log("La variable datosServiArray no está definida o es nula.");
    }
</script>