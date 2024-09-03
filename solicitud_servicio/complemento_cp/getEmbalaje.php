<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'code']];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'waybill.tipo.embalaje',
        'search_read',
        [],
        $kwargs
    );

echo json_encode($partners, true);
