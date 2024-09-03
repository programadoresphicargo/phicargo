<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (!isset($_POST['inicio']) && (!isset($_POST['fin']))) {
    $fecha_actual = date("Y-m-d");
    $nuevaFecha = strtotime("-1 month", strtotime($fecha_actual));
    $hace_1_mes = date("Y-m-d", $nuevaFecha);

    $primer_dia_mes = $hace_1_mes;
    $ultimo_dia_mes = $fecha_actual;
} else {
    $primer_dia_mes = $_POST['inicio'];
    $ultimo_dia_mes =  $_POST['fin'];
}

$domain = [
    [
        ['date_order', '>=', $primer_dia_mes],
        ['date_order', '<=', $ultimo_dia_mes],
        ['x_status_viaje', '=', ['finalizado']],
        ['travel_id', '!=', false],
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

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    array(
        'fields' => array('id', 'name', 'x_ejecutivo_viaje_bel', 'date_order', 'store_id', 'employee_id', 'vehicle_id', 'route_id', 'x_reference', 'partner_id', 'travel_id', 'x_modo_bel'),
        'order' => 'date_order desc',
    )
);

$json = json_encode($records);
$cps = json_decode($json, true);

?>

<div class="table-responsive">
    <table class="table table-align-middle table-hover table-sm" id="tabla-datos">
        <thead class="thead-light">
            <tr class="ignorar">
                <th class="text-center" scope="col">Referencia</th>
                <th class="text-center" scope="col">Carta porte</th>
                <th class="text-center" scope="col">Fecha</th>
                <th class="text-center" scope="col">POD</th>
                <th class="text-center" scope="col">EIR</th>
                <th class="text-center" scope="col">Cuenta</th>
                <th class="text-center" scope="col">Fecha Finalizado</th>
                <th class="text-center" scope="col">Finalizado por</th>
                <th class="text-center" scope="col">Sucursal</th>
                <th class="text-center" scope="col">Ejecutivo</th>
                <th class="text-center" scope="col">Operador</th>
                <th class="text-center" scope="col">Unidad</th>
                <th class="text-center" scope="col">Ruta</th>
                <th class="text-center" scope="col">Tipo</th>
                <th class="text-center" scope="col">Contenedores</th>
                <th class="text-center" scope="col">Cliente</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($cps as $cp) { ?>
                <tr onclick="onRowClick(this)" id="<?php echo $cp['travel_id'][0]  ?>" id_cliente="<?php echo $cp['partner_id'][0]  ?>">
                    <td class="open"><?php echo $cp['travel_id'][1] ?></td>
                    <td><?php echo $cp['name'] ?></td>
                    <td><?php echo $cp['date_order'] ?></td>

                    <?php
                    $id = $cp['travel_id'][0];

                    $sqlpod = "SELECT 
                            id_viaje,
                            MAX(CASE WHEN tipo_doc = 'pod' THEN 'enviado' ELSE '' END) AS pod,
                            MAX(CASE WHEN tipo_doc = 'eir' THEN 'enviado' ELSE '' END) AS eir,
                            MAX(CASE WHEN tipo_doc = 'cuenta' THEN 'enviado' ELSE '' END) AS cuenta
                        FROM 
                            documentacion
                        WHERE 
                            id_viaje = $id
                        GROUP BY 
                            id_viaje";
                    $resultadopod = $cn->query($sqlpod);
                    $rowdoc = $resultadopod->fetch_assoc();
                    ?>
                    <td>
                        <?php
                        $pod = !empty($rowdoc['pod']) ? '<span class="badge bg-success">' . htmlspecialchars($rowdoc['pod']) . '</span>' : '';
                        echo $pod;
                        ?>
                    </td>
                    <td>
                        <?php
                        $eir = !empty($rowdoc['eir']) ? '<span class="badge bg-success">' . htmlspecialchars($rowdoc['eir']) . '</span>' : '';
                        echo $eir;
                        ?>
                    </td>
                    <td>
                        <?php
                        $cuenta = !empty($rowdoc['cuenta']) ? '<span class="badge bg-success">' . htmlspecialchars($rowdoc['cuenta']) . '</span>' : '';
                        echo $cuenta;
                        ?>
                    </td>

                    <td>
                        <?php
                        $id = $cp['travel_id'][0];

                        $sqlv = "SELECT nombre, DATE(fecha_finalizado) AS fecha_sin_hora FROM viajes inner join usuarios on viajes.usuario_finalizado = usuarios.id_usuario where viajes.id = $id";
                        $resultadov = $cn->query($sqlv);
                        $rowv = $resultadov->fetch_assoc();
                        if ($resultadov->num_rows != 0) {
                        ?>
                            <?php echo $rowv['fecha_sin_hora'] ?>
                        <?php } ?>
                    </td>

                    <td>
                        <?php
                        if ($resultadov->num_rows != 0) {
                        ?>
                            <?php echo $rowv['nombre'] ?>
                        <?php } ?>
                    </td>

                    <td><?php echo $cp['store_id'][1] ?></td>
                    <td><?php echo $cp['x_ejecutivo_viaje_bel'] ?></td>
                    <td><?php echo $cp['employee_id'][1] ?></td>
                    <td><?php echo $cp['vehicle_id'][1] ?></td>
                    <td><?php echo $cp['route_id'][1] ?></td>
                    <td><?php echo $cp['x_modo_bel'] ?></td>
                    <td><?php echo $cp['x_reference'] ?></td>
                    <td><?php echo $cp['partner_id'][1] ?></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</div>

<script>
    function onRowClick(row) {

        filaId = $(row).attr('id');
        status = $(row).attr('status');

        if ($(event.target).closest('td').hasClass('open')) {
            $("#offcanvas_viaje").offcanvas('show');
            $('#cargadiv5').show();
            $("#contenido").load('../detalle/index.php?id=' + filaId, function() {
                $('#cargadiv5').hide();
            });

        } else {
            console.log('caso 3');
            window.location.href = "../../gestion_viajes/viaje/index2.php?id=" + filaId;
        }
    }
</script>
<?php
require_once('../../search/codigo2.php');
