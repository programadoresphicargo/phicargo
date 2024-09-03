<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name',]];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill.category',
        'search_read',
        [],
        $kwargs
    );

echo json_encode($partners, true);
