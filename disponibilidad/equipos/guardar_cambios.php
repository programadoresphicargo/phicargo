<?php
require_once('../../odoo/odoo-conexion.php');

if (!empty($uid)) {

    $partner_record_ids = [(int)($_POST['id_unidad'])];
    $partner_value = [
        'x_status' => $_POST['estado'],
    ];
    $values = [$partner_record_ids, $partner_value];

    $partners = $models->execute_kw($db, $uid, $password, 'fleet.vehicle', 'write', $values);

    echo $partners;
} else {
    echo "Failed to sign in";
}
