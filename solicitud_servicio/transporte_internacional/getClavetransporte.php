<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'code']];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'waybill.clave.transporte',
        'search_read',
        [],
        $kwargs
    );

echo $json = json_encode($partners, true);
file_put_contents('ahs.json', $json);
