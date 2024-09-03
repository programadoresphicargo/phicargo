<?php
require_once('getContenedores.php');

function calcularTiempoTranscurrido($fecha1, $fecha2)
{
    $fechaActual = time();
    $fecha1Timestamp = strtotime($fecha1);

    // Si se proporciona una segunda fecha, calcular la diferencia entre las fechas.
    if ($fecha2 !== null) {
        $fecha2Timestamp = strtotime($fecha2);
        $diferenciaSegundos = $fecha2Timestamp - $fecha1Timestamp;
    } else {
        // Si no se proporciona una segunda fecha, calcular la diferencia entre la fecha dada y la fecha actual.
        $diferenciaSegundos = $fechaActual - $fecha1Timestamp;
    }

    $dias = floor($diferenciaSegundos / (60 * 60 * 24));
    $horas = floor(($diferenciaSegundos % (60 * 60 * 24)) / (60 * 60));
    $minutos = floor(($diferenciaSegundos % (60 * 60)) / 60);
    $segundos = $diferenciaSegundos % 60;

    return array(
        "dias" => $dias,
        "horas" => $horas,
        "minutos" => $minutos,
        "segundos" => $segundos
    );
}

$ids = json_decode($json, true);
?>

<div class="table-responsive">
    <table class="js-datatable table table-thead-bordered table-align-middle table-hover" id="tabla-datos">
        <thead class="thead-light">
            <tr class="text-center">
                <th>Carta Porte</th>
                <th>Referencia Contenedor</th>
                <th>Ejecutivo</th>
                <th>Viaje</th>
                <th>Llegada a patio</th>
                <th>Días en patio</th>
                <th>Status</th>
                <th>Fecha ingreso</th>
                <th>Sucursal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ids as $item) : ?>
                <tr data-id="<?php echo $item['id']; ?>">
                    <td>
                        <div class="ms-3"><span class="d-block h5 text-inherit mb-0"><?php echo $item['name']; ?></span></div>
                    </td>
                    <td width="20px"><?php echo $item['x_reference']; ?></td>
                    <td><?php echo $item['x_ejecutivo_viaje_bel']; ?></td>
                    <td><?php echo $item['travel_id'][1]; ?></td>
                    <td><?php echo $item['x_llegada_patio']; ?></td>

                    <?php
                    if ($item['x_llegada_patio'] !== false) {
                        $tiempoTranscurrido = calcularTiempoTranscurrido(($item['x_llegada_patio']), ($item['x_fechaing_bel']));
                        if ($tiempoTranscurrido['dias'] >= 1) {
                            if ($tiempoTranscurrido['dias'] >= 7) {
                                echo '<td class="text-center"><span class="badge bg-danger rounded-pill">' . $tiempoTranscurrido['dias'] . ' días</span></td>';
                            } else {
                                echo '<td class="text-center">' . $tiempoTranscurrido['dias'] . ' días</td>';
                            }
                        } elseif ($tiempoTranscurrido['horas'] >= 24) {
                            echo '<td class="text-center">' . $tiempoTranscurrido['horas'] . ' horas</td>';
                        } elseif ($tiempoTranscurrido['minutos'] <= 60) {
                            echo '<td class="text-center">' . $tiempoTranscurrido['minutos'] . ' minutos</td>';
                        }
                    } else {
                        echo '<td class="text-center"></td>';
                    }
                    ?>

                    <?php
                    if ($item['x_status_bel'] == 'Ing') {
                        echo "<td class='text-center'><span class='badge bg-success rounded-pill'>Ingresado</span></td>";
                    } elseif ($item['x_status_bel'] == 'No Ing') {
                        echo "<td class='text-center'><span class='badge bg-danger rounded-pill'>No Ingresado</span></td>";
                    } elseif ($item['x_status_bel'] == 'pm') {
                        echo "<td class='text-center'><span class='badge bg-warning rounded-pill'>Patio México</span></td>";
                    } elseif ($item['x_status_bel'] == 'sm') {
                        echo "<td class='text-center'><span class='badge bg-warning rounded-pill'>Sin Maniobra</span></td>";
                    } elseif ($item['x_status_bel'] == 'EI') {
                        echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>En proceso de ingreso</span></td>";
                    } elseif ($item['x_status_bel'] == 'ru') {
                        echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>Reutilizado</span></td>";
                    } elseif ($item['x_status_bel'] == 'can') {
                        echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>Cancelado</span></td>";
                    } elseif ($item['x_status_bel'] == 'P') {
                        echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>En Patio</span></td>";
                    } elseif ($item['x_status_bel'] == 'V') {
                        echo "<td class='text-center'><span class='badge bg-primary rounded-pill'>En Viaje</span></td>";
                    } else {
                        echo "<td class='text-center'><span class='badge bg-dark rounded-pill'>Sin Status</span></td>";
                    }
                    ?>

                    <td><?php echo $item['x_fechaing_bel']; ?></td>
                    <td class="text-center"><?php echo $item['store_id'][1]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#tabla-datos').on('click', 'tr', function() {
        var dataId = $(this).data('id');
        if ($.isNumeric(dataId)) {
            $("#detalles_maniobra").offcanvas("show");
            $('#cargadiv5').show();
            $("#contenidomaniobracanvas").load('../maniobra/index.php', {
                'id': dataId
            }, function() {
                $('#cargadiv5').hide();
            });
        }
    });
</script>
<?php
require_once('../../search/codigo2.php');
