<?php

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name2']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    [],
    $kwargs
);

$json = json_encode($ids);
print($json);
