<?php
require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
$cn = conectar();

$kwargs2 = ['fields' => ['id', 'x_custodia_bel', 'name', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'x_status_viaje', 'x_modo_bel', 'store_id', 'x_operador_bel_id', 'vehicle_id', 'route_id', 'x_date_arrival_shed', 'x_reference', 'partner_id', 'x_codigo_postal', 'x_tipo_bel', 'x_medida_bel', 'date_order', 'employee_id'],  'order' => 'date_start asc'];

$domain = [];

if (isset($_POST['searchResults'])) {
    $searchResultsArray = $_POST['searchResults'];
    if (isset($searchResultsArray) && !empty($searchResultsArray)) {
        $searchResultsJSON = json_encode($searchResultsArray);
        if ($searchResultsJSON !== false) {
            $decodedSearchResults = json_decode($searchResultsJSON, true);
            if ($decodedSearchResults !== null) {
                foreach ($decodedSearchResults as $result) {
                    $campoEspecifico1 = $result['texto'];
                    $campoEspecifico2 = $result['opcion'];
                    $new_condition = [$campoEspecifico2, 'ilike', $campoEspecifico1];
                    if (empty($domain[0])) {
                    } else {
                        array_unshift($domain[0], '|');
                    }
                    $domain[0][] = $new_condition;
                }
            } else {
                echo "Error al decodificar la cadena JSON.";
            }
        } else {
            echo "Error al codificar la cadena JSON.";
        }
    } else {
        echo "No se encontraron datos en \$_POST['searchResults'].";
    }
}

$fecha = $_POST['fecha'];

$fecha_inicio = date('Y-m-d H:i:s', strtotime("$fecha 00:00:00 +6 hours"));
$fecha_fin = date('Y-m-d H:i:s', strtotime("$fecha 23:59:59 +6 hours"));

$domain[0][] = ['travel_id', '!=', false];
$domain[0][] = ['name', '!=', false];
$domain[0][] = ['date_start', '>=', $fecha_inicio];
$domain[0][] = ['date_start', '<=', $fecha_fin];
$domain[0][] = ['x_status_viaje', '!=', ['ruta', 'planta', 'retorno', 'finalizado']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    $kwargs2
);

$json = json_encode($ids);
$datos = json_decode($json, true);
?>

<div class="table-responsive">
    <table class="table table-align-middle table-hover table-sm table-hover" id="vp">
        <thead class="thead-light">
            <tr class="">
                <th>Estado</th>
                <th>Sucursal</th>
                <th>Ejecutivo</th>
                <th>Inicio ruta programado</th>
                <th>Cliente</th>
                <th>Servicio con custodia</th>
                <th>Referencia</th>
                <th>Fecha</th>
                <th>Viaje</th>
                <th>Operador</th>
                <th>Unidad</th>
                <th>Correo ligado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $item) { ?>

                <tr onclick="abrirviaje('<?php echo $item['travel_id'][0] ?>')">
                    <td>
                        <span class="<?php
                                        switch ($item['x_status_viaje']) {
                                            case 'finalizado':
                                                echo 'badge bg-dark rounded-pill';
                                                break;
                                            case 'cancelado':
                                                echo 'badge bg-danger rounded-pill';
                                                break;
                                            case 'ruta':
                                                echo 'badge bg-primary rounded-pill';
                                                break;
                                            case 'planta':
                                                echo 'badge bg-success rounded-pill';
                                                break;
                                            case 'retorno':
                                                echo 'badge bg-warning rounded-pill';
                                                break;
                                            default:
                                                echo '';
                                        }
                                        ?>"><?php echo $item['x_status_viaje'] == '' ? 'Disponible' : $item['x_status_viaje'] ?>
                    </td></span>
                    <td><?php echo $item['store_id'][1] ?></td>
                    <td><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>

                    <?php
                    $fechaOriginal = $item['date_start'];
                    $fecha = new DateTime($fechaOriginal);
                    $fecha->modify('-6 hours');
                    $nuevaFecha = $fecha->format('Y-m-d H:i:s');
                    ?>

                    <td style="width: 10%;"><?php echo $nuevaFecha ?></td>
                    <td><?php echo $item['partner_id'][1] ?></td>
                    <td class="<?= $item['x_custodia_bel'] === 'yes' ? 'bg-primary text-white' : '' ?>"><?= $item['x_custodia_bel'] === 'yes' ? 'SI' : 'NO' ?></td>
                    <td style="width: 10%;"><?php echo $item['x_reference'] ?></td>
                    <td style="width: 10%;"><?php echo $item['date_order'] ?></td>
                    <td><?php echo $item['travel_id'][1] ?></td>
                    <td><?php echo $item['employee_id'][1] ?></td>
                    <td><?php echo $item['vehicle_id'][1] ?></td>
                    <td>
                        <?php
                        $id_viaje = $item['travel_id'][0];
                        $sql = "SELECT * FROM correos_viajes where id_viaje = $id_viaje";
                        $resultado = $cn->query($sql);
                        if ($resultado->num_rows > 0) { ?>
                            <span class="badge bg-primary rounded-pill">Correos ligados</span>
                        <?php   }
                        ?>
                    </td>

                </tr>

            <?php } ?>
        </tbody>
    </table>
</div>
<script>
    function abrirviaje(id_viaje) {
        console.log('caso 1');
        $('#offcanvas_viaje').offcanvas('show');
        $('#cargadiv5').show();
        $("#contenido").load('../viaje/index.php?id=' + id_viaje, function() {
            $('#cargadiv5').hide();
        });
    }

    $('#vp').DataTable({
        paging: false,
        order: [
            [3, 'asc']
        ],
        rowGroup: {
            dataSrc: 1
        }
    });

    function cargar_colores2() {
        $('#vp tbody tr').each(function() {
            var fila = $(this);

            var estado = fila.find('td:eq(0)').text().trim();
            var inicio_programado = fila.find('td:eq(3)').text().trim();
            var fechaActual = new Date();
            var fechaDada = new Date(inicio_programado);

            if (estado === 'Disponible') {
                if (fechaActual.getTime() > fechaDada.getTime()) {
                    console.log(1);
                    fila.find('td:eq(3)').addClass('table-danger'); // Aplica clase solo a la celda de la fecha
                } else {
                    var diferenciaHoras = (fechaDada.getTime() - fechaActual.getTime()) / (1000 * 60 * 60);
                    if (diferenciaHoras < 1) {
                        console.log(2);
                        fila.find('td:eq(3)').addClass('table-warning'); // Aplica clase solo a la celda de la fecha
                    }
                }
            }
        });
    }

    cargar_colores2();
</script>