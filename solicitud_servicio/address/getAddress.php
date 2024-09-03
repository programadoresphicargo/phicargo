<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'street', 'name'], 'limit' => 100];
$busqueda = $_POST['busqueda'];
$id_select = $_POST['id_select'];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'res.partner',
        'search_read',
        array(
            array(
                array('customer', '=', true),
                '|',
                array('name', 'ilike', $busqueda),
                array('street', 'ilike', $busqueda),
            )
        ),
        $kwargs
    );

$json_data = json_encode($partners, true);
$data = json_decode($json_data, true);
?>

<table class="table table-sm table-hover table-striped">
    <thead>
        <tr>
            <th scope="col">Nombre</th>
            <th scope="col">Dirección</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $item) { ?>
            <tr onclick="seleccionar_address('<?php echo $item['id'] ?>','<?php echo $item['name'] ?>','<?php echo $id_select ?>')">
                <td><?php echo $item['name'] ?></td>
                <td><?php echo $item['street']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function seleccionar_address(id, name, id_select) {
        var select = document.getElementById(id_select);
        while (select.options.length > 0) {
            select.remove(0);
        }
        var nuevaOpcion = document.createElement("option");
        nuevaOpcion.text = name;
        nuevaOpcion.value = id;
        nuevaOpcion.selected = true;
        select.add(nuevaOpcion);
        $("#addressmodal").modal('hide');
    }
</script>