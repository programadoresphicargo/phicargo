<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (!isset($_POST['inicio']) && (!isset($_POST['fin']))) {
    $fecha_actual = date("Y-m-d");
    $primer_dia_mes = date("Y-m-01", strtotime($fecha_actual));
    $ultimo_dia_mes = date("Y-m-t", strtotime($fecha_actual));
} else {
    $primer_dia_mes = $_POST['inicio'];
    $ultimo_dia_mes =  $_POST['fin'];
}

$domain = [
    [
        ['name', '=', false],
        ['date_order', '>=', '2023-12-01'],
        ['state', '!=', 'cancel'],
    ]
];

if (isset($_POST['searchResults'])) {
    $searchResultsJSON = $_POST['searchResults'];

    $searchResults = json_decode($searchResultsJSON, true);

    if ($searchResults !== null) {
        foreach ($searchResults as $result) {
            $searchText = $result['searchText'];
            $searchField = $result['searchField'];

            $new_condition = [$searchField, 'ilike', $searchText];
            array_push($domain[0], $new_condition);
        }
    } else {
        echo "Hubo un error al decodificar los datos JSON.";
    }
}
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'date_order', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'expected_date_delivery', 'partner_id', 'x_mov_bel', 'x_eco_retiro', 'x_operador_retiro', 'x_terminal_bel'], 'order' => 'date_order asc'];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    $kwargs
);

$json = json_encode($records);
$datos = json_decode($json, true);

?>

<div class="table-responsive">
    <table class="table table-align-middle table-hover table-sm" id="tabla-datos">
        <thead class="thead-light">
            <tr class="">
                <th>Sucursal</th>
                <th>Ejecutivo</th>
                <th>Fecha prevista</th>
                <th>Cliente</th>
                <th>Carta porte</th>
                <th>Referencia Contenedor </th>
                <th>Status</th>
                <th>Terminal retiro</th>
                <th>Operador retiro</th>
                <th>ECO retiro</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $item) { ?>
                <tr data-id="<?php echo $item['id'] ?>">
                    <td><?php echo $item['store_id'][1] ?></td>
                    <td><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                    <td><?php echo $item['date_order'] ?></td>
                    <td><?php echo $item['partner_id'][1] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['x_reference'] ?></td>

                    <?php
                    if ($item['x_status_bel'] == 'Ing') { ?>
                        <td class='text-center'><span class='badge bg-success rounded-pill'>Ingresado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'No Ing') { ?>
                        <td class='text-center'><span class='badge bg-danger rounded-pill'>No Ingresado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'pm') { ?>
                        <td class='text-center'><span class='badge bg-warning rounded-pill'>Patio México</span></td>
                    <?php } else if ($item['x_status_bel'] == 'sm') { ?>
                        <td class='text-center'><span class='badge bg-warning rounded-pill'>Sin Maniobra</span></td>
                    <?php } else if ($item['x_status_bel'] == 'EI') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>En proceso de ingreso</span></td>
                    <?php } else if ($item['x_status_bel'] == 'ru') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>Reutilizado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'can') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>Cancelado</span></td>
                    <?php } else if ($item['x_status_bel'] == 'P') { ?>
                        <td class='text-center'><span class='badge bg-morado rounded-pill'>En Patio</span></td>
                    <?php } else if ($item['x_status_bel'] == 'V') { ?>
                        <td class='text-center'><span class='badge bg-primary rounded-pill'>En Viaje</span></td>
                    <?php } else { ?>
                        <td class='text-center'><span class='badge bg-dark rounded-pill'>Sin Status</span></td>
                    <?php } ?>

                    <td><?php echo $item['x_mov_bel'] ?></td>
                    <td><?php echo $item['x_eco_retiro'] ?></td>
                    <td><?php echo $item['x_operador_retiro'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $('#tabla-datos').on('click', 'tr', function() {
        // Obtén el valor del atributo data-id del elemento <tr> clickeado
        var dataId = $(this).data('id');
        if ($.isNumeric(dataId)) {
            $("#detalles_maniobra").offcanvas("show");

            $('#cargadiv5').show();
            $('#contenidomaniobracanvas').hide();
            $('#contenidomaniobracanvas').load('../maniobra/index.php', {
                'id': dataId
            }, function() {
                $('#cargadiv5').hide();
                $('#contenidomaniobracanvas').show();
            });

        }
    });
</script>

<?php
require_once('../../search/codigo2.php');
