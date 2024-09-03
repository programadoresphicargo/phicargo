<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'code', 'name']];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'sat.udm',
        'search_read',
        [],
        $kwargs
    );

echo json_encode($partners, true);
