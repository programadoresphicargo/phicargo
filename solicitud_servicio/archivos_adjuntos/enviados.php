<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = $_POST['id_solicitud'];

$kwargs = ['fields' => [
    'id',
    'name',
    'create_date',
    'file_size',
    'datas'
], 'order' => 'create_date desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'ir.attachment',
    'search_read',
    array(array(
        array('res_id', '=', intval($id_solicitud)),
    ),),
    $kwargs
);

$json = json_encode($ids);
$ids = json_decode($json);

?>
<h4 class="mt-5 mb-3">Archivos adjuntados</h4>
<?php

foreach ($ids as $item) { ?>
    <ul class="list-group">
        <li class="list-group-item">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img class="avatar avatar-xs avatar-4x3" src="../../img/icons/docu.png" alt="Image Description">
                </div>

                <div class="col">
                    <h5 class="mb-0">
                        <a class="text-dark" download="<?php echo $item->name ?>" href="data:application/octet-stream;base64,<?php echo $item->datas ?>"><?php echo $item->name ?></a>
                    </h5>
                    <ul class="list-inline list-separator small text-body">
                        <li class="list-inline-item">
                            <?php
                            $fecha_hora = $item->create_date;
                            $fecha_hora_objeto = new DateTime($fecha_hora);
                            $fecha_hora_objeto->modify('-6 hours');
                            $nueva_fecha_hora = $fecha_hora_objeto->format('Y-m-d H:i:s');
                            echo $nueva_fecha_hora;
                            ?>
                        </li>
                        <li class="list-inline-item"><?php echo number_format(($item->file_size / 1024), 2) . ' kb' ?></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
<?php } ?>