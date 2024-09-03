<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
session_start();
$cn = conectar();
$id_usuario = $_SESSION['userID'];

$kwargs = ['order' => 'id desc', 'fields' => ['name', 'x_id_usuario_cliente', 'create_date', 'x_ruta_destino', 'x_modo_bel', 'x_tipo_bel', 'store_id', 'state']];
$partners = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(
        array(
            array('x_id_usuario_cliente', '=', intval($id_usuario))
        )
    ),
    $kwargs
);

?>

<table class="table table-sm table-striped table-borderless table-thead-bordered" id="tablasolicitudes">
    <thead class="thead-light">
        <tr>
            <th scope="col">Folio</th>
            <th scope="col">Sucursal</th>
            <th scope="col">Destino</th>
            <th scope="col">Tipo de armado</th>
            <th scope="col">Modo</th>
            <th scope="col">Fecha de registro</th>
            <th scope="col">Aprobada</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($partners as $partner) { ?>
            <tr onclick="abrir_solicitud('<?php echo $partner['id'] ?>')">
                <td><?php echo $partner['id'] ?></td>
                <td><?php echo isset($partner['store_id'][1]) ? $partner['store_id'][1] : '' ?></td>
                <td><?php echo isset($partner['x_ruta_destino'][1]) ? $partner['x_ruta_destino'][1] : '' ?></td>
                <td>
                    <?php if ($partner['x_tipo_bel'] == 'single') { ?>
                        Sencillo
                    <?php } else { ?>
                        Full
                    <?php    } ?> </td>
                <td>
                    <?php if ($partner['x_modo_bel'] == 'imp') { ?>
                        Importacion
                    <?php } else { ?>
                        Exportación
                    <?php    } ?>
                </td>

                <?php
                $create_date = $partner['create_date'];
                $fechaHora = new DateTime($create_date);
                $fechaHora->sub(new DateInterval('PT6H'));
                $fechaHoraFormateada = $fechaHora->format('Y-m-d H:i:s');
                ?>

                <td><?php echo $fechaHoraFormateada ?></td>
                <td><?php
                    if ($partner['state'] == 'approved') { ?>
                        <span class="badge bg-primary rounded-pill">Aprobado</span>
                    <?php } else if ($partner['state'] == 'cancel') { ?>
                        <span class="badge bg-secondary rounded-pill">Cancelado</span>
                    <?php } else if ($partner['state'] == 'confirmed') { ?>
                        <span class="badge bg-success rounded-pill">Confirmado</span>
                    <?php } ?>
                </td>
            </tr>
        <?php }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tablasolicitudes').DataTable({
            ordering: false
        });
    });

    function abrir_solicitud(id) {
        window.location.href = "../../solicitud_servicio/form/index.php?id=" + id;
    }
</script>