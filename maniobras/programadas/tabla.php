<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$domain = [
    [
        '|',
        ['x_status_maniobra_retiro', '=', "activo"],
        ['x_status_maniobra_ingreso', '=', "activo"],
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

$kwargs = ['fields' => ['id', 'name', 'date_order', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'partner_id', 'x_status_maniobra_retiro', 'x_status_maniobra_ingreso', 'x_eco_retiro_id', 'x_mov_bel', 'x_operador_retiro_id', 'x_terminal_bel', 'x_eco_ingreso_id', 'x_mov_ingreso_bel_id'], 'order' => 'date_order desc'];

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
                <th data-columna="Sucursal">Sucursal</th>
                <th data-columna="Estado">Carta Porte / Solicitud</th>
                <th data-columna="Tipo">Tipo</th>
                <th data-columna="Ultimo status">Ultimo status</th>
                <th data-columna="Ejecutivo">Ejecutivo</th>
                <th data-columna="Carta Porte">Cliente</th>
                <th data-columna="Remolque">Terminal</th>
                <th data-columna="Carta Porte">Unidad</th>
                <th data-columna="Carta Porte">Operador</th>
                <th data-columna="Remolque">Contenedor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $item) { ?>

                <tr data-id="<?php echo $item['id'] ?>">
                    <td data-columna="Sucursal"><?php echo $item['store_id'][1] ?></td>
                    <td><?php echo $item['name'] != false ? $item['name'] : $item['id'] ?></td>
                    <td data-columna="Tipo">
                        <?php if ($item['x_status_maniobra_retiro']) { ?>
                            <span class='badge bg-success rounded-pill'>Retiro</span>
                        <?php } else if ($item['x_status_maniobra_ingreso']) { ?>
                            <span class='badge bg-primary rounded-pill'>Ingreso</span>
                        <?php } ?>
                    </td>
                    <?php
                    $id_cp = $item['id'];
                    $sqlSelect = "SELECT * FROM status_maniobras inner join status on status.id_status = status_maniobras.id_status where id_cp = $id_cp order by fecha_envio desc limit 1";
                    $resultado = $cn->query($sqlSelect);
                    $row = $resultado->fetch_assoc();
                    if (!empty($row)) { ?>
                        <td class="openstatus"><span class='badge bg-success rounded-pill'><?php echo $row['status'] ?></span></td>
                    <?php } else { ?>
                        <td class="openstatus"></td>
                    <?php }
                    ?>
                    <td data-columna="Ejecutivo"><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                    <td data-columna="Cliente"><?php echo $item['partner_id'][1] ?></td>

                    <?php if ($item['x_status_maniobra_retiro']) { ?>

                        <td data-columna="Cliente"><?php echo $item['x_mov_bel'] ?></td>
                        <td data-columna="Cliente"><?php echo $item['x_eco_retiro_id'][1] ?></td>
                        <td data-columna="Cliente"><?php echo $item['x_operador_retiro_id'][1] ?></td>

                    <?php } else if ($item['x_status_maniobra_ingreso']) { ?>

                        <td data-columna="Cliente"><?php echo $item['x_terminal_bel'] ?></td>
                        <td data-columna="Cliente"><?php echo $item['x_eco_ingreso_id'][1] ?></td>
                        <td data-columna="Cliente"><?php echo $item['x_mov_ingreso_bel_id'][1] ?></td>

                    <?php } ?>

                    <td data-columna="Referencia contenedor"><?php echo $item['x_reference'] ?></td>
                </tr>

            <?php } ?>
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
?>