<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
$cn = conectar();

$domain = [
    []
];

if (isset($_POST['searchResults'])) {
    $searchResultsJSON = $_POST['searchResults'];

    $searchResults = json_decode($searchResultsJSON, true);

    if ($searchResults !== null) {
        foreach ($searchResults as $result) {
            $searchText = $result['searchText'];
            $searchField = $result['searchField'];

            $newCriterion = [$searchField, 'like', $searchText];
            if (empty($domain[0])) {
            } else {
                array_unshift($domain[0], '|');
            }
            $domain[0][] = $newCriterion;
        }
    } else {
        echo "Hubo un error al decodificar los datos JSON.";
    }
}

$domain[0][] = ['vehicle_type_id', '=', 2162];
$domain[0][] = ['supplier_vehicle', '!=', true];

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'state_id', 'name2', 'x_tipo_vehiculo', 'x_sucursal', 'x_tipo_vehiculo', 'x_tipo_carga', 'x_modalidad', 'x_operador_asignado']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    $domain,
    $kwargs
);

$json = json_encode($ids);
$vehicles = json_decode($json, true);
?>

<table class="table table-sm" id="tabla-datos">
    <thead>
        <tr>
            <th scope="col">Unidad</th>
            <th scope="col">Sucursal</th>
            <th scope="col">Operador asignado</th>
            <th scope="col">Tipo</th>
            <th scope="col">Tipo de carga</th>
            <th scope="col">Modalidad</th>
            <th scope="col">Última postura</th>
            <th scope="col">Fecha última postura</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($vehicles as $vehicle) { ?>
            <tr onclick="abrir_postura('<?php echo $vehicle['id'] ?>','<?php echo $vehicle['name2'] ?>','<?php echo $vehicle['x_sucursal'] != false ? $vehicle['x_sucursal'][0] : 0 ?>','<?php echo $vehicle['x_operador_asignado'] != false ? $vehicle['x_operador_asignado'][0] : 0 ?>','<?php echo $vehicle['x_tipo_vehiculo'] ?>','<?php echo $vehicle['x_modalidad'] ?>','<?php echo $vehicle['x_tipo_carga'] ?>')" style="cursor:pointer">
                <td scope="col"><?php echo $vehicle['name2'] ?></td>
                <td scope="col"><?php echo $vehicle['x_sucursal'] != false ? $vehicle['x_sucursal'][1] : ''  ?></td>
                <td scope="col"><?php echo $vehicle['x_operador_asignado'] != false ? $vehicle['x_operador_asignado'][1] : ''  ?></td>
                <td scope="col"><?php echo $vehicle['x_tipo_vehiculo'] ?></td>
                <td scope="col"><?php echo $vehicle['x_tipo_carga'] ?></td>
                <td scope="col">
                    <?php if ($vehicle['x_modalidad'] == 'sencillo') { ?>
                        <span class="badge bg-primary rounded-pill">Sencillo</span>
                    <?php } else if ($vehicle['x_modalidad'] == 'full') { ?>
                        <span class="badge bg-danger rounded-pill">Full</span>
                    <?php   } ?>
                </td>
                <?php
                $id_vehiculo = $vehicle['id'];
                $sqlPostura = "SELECT * FROM posturas left join operadores on operadores.id = posturas.id_operador where id_vehiculo = $id_vehiculo order by fecha_asignacion desc limit 1";
                $resultadoPostura = $cn->query($sqlPostura);
                if ($resultadoPostura->num_rows > 0) {
                    while ($rowP = $resultadoPostura->fetch_assoc()) { ?>
                        <td scope="col"><?php echo $rowP['nombre_operador'] ?></td>
                        <td scope="col"><?php echo $rowP['fecha_asignacion'] ?></td>
                    <?php
                    }
                } else { ?>
                    <td colspan="2"></td>
                <?php   } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function abrir_postura(id_vehiculo, nombre_vehiculo, sucursal, operador_asignado, tipo_vehiculo, modalidad, tipo_carga) {
        $("#id_vehiculo").val(id_vehiculo);
        $("#nombre_vehiculo").val(nombre_vehiculo);
        $("#modal_postura").modal('show');

        $("#x_sucursal").val(sucursal);
        select1.setValue([operador_asignado]);
        $("#x_tipo_vehiculo").val(tipo_vehiculo);
        $("#x_modalidad").val(modalidad);
        $("#x_tipo_carga").val(tipo_carga);

        $("#historial_posturas").load('historial_posturas.php', {
            'id_vehiculo': id_vehiculo
        })
    }
</script>

<?php
require_once('../../search/codigo2.php');
?>