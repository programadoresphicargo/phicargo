<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'code']];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill.transportable',
        'search_read',
        [],
        $kwargs
    );

$data = json_encode($partners, true);
echo $data;
