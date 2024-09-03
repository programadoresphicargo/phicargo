<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'code', 'name'], 'limit' => 500];
$busqueda = $_POST['busqueda'];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'sat.producto',
        'search_read',
        array(
            array(
                '|',
                array('code', 'ilike', $busqueda),
                array('name', 'ilike', $busqueda),
            ),
        ),
        $kwargs
    );
?>
<div class="table-responsive">
    <table class="table table-sm table-hover table-striped" id="tabla_catalogo">
        <thead>
            <tr style="">
                <th>Código</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($partners as $partner) : ?>
                <tr onclick="seleccionar_clave('<?php echo $partner['id'] ?>','<?php echo $partner['code'] ?>','<?php echo $partner['name'] ?>')">
                    <td><?php echo $partner['code']; ?></td>
                    <td><?php echo $partner['name']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    function seleccionar_clave(id, code, descripcion) {
        var select = document.getElementById("sat_product_id");
        while (select.options.length > 0) {
            select.remove(0);
        }
        var nuevaOpcion = document.createElement("option");
        nuevaOpcion.text = "[" + code + "] " + descripcion;
        nuevaOpcion.value = id;
        nuevaOpcion.selected = true;
        select.add(nuevaOpcion);
        $("#modal_catalogo_sat").modal('hide');
    }
</script>