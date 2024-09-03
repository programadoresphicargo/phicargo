<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'code', 'name']];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'waybill.materiales.peligrosos',
        'search_read',
        [],
        $kwargs
    );

echo json_encode($partners, true);
