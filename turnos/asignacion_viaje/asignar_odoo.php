<?php
require_once('../../odoo/odoo-conexion.php');

try {
    $id_operador = $_POST['id_operador'];
    $id_viaje = $_POST['id_viaje'];

    $partner_record_ids = [intval($id_viaje)];
    $partner_value = [
        'x_operador_bel_id' => $id_operador,
    ];
    $values = [$partner_record_ids, $partner_value];

    $cambios = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

    if ($cambios == 1) {
        echo 1;
    } else {
        echo 0;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
