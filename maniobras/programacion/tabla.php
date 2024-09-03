<?php
require_once('get_registros.php');
?>
<table class="table table-striped table-bordered table-sm" id="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Carta porte</th>
            <th>Ejecutivo de viaje</th>
            <th>Contenedor</th>
            <th>Fecha de orden</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $item) : ?>
            <tr onclick="abrir('<?php echo $item['id']; ?>','<?php echo $item['partner_id'][0] ?>')">
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['x_ejecutivo_viaje_bel']; ?></td>
                <td><?php echo $item['x_reference']; ?></td>
                <td><?php echo $item['date_order']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    function cargar_maniobra(id, partner_id) {
        $.ajax({
            url: '../maniobra_detalle/maniobras.php',
            type: 'POST',
            data: {
                'id_cp': id,
                'partner_id': partner_id
            },
            success: function(response) {
                id_cp = id;
                partner_id = partner_id;
                $('#maniobrasregistradas').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                $('#resultado').html('<p>Ocurrió un error: ' + textStatus + '</p>');
            }
        });
    }

    function abrir(id, partner_id) {
        $("#detalle_maniobra").offcanvas('show');
        cargar_maniobra(id, partner_id);
    }
    $('#table').DataTable({});
</script>