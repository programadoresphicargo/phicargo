<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['name', 'limit' => 1]];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'account.invoice',
    'search_read',
    [[]],
    $kwargs
);

$json = json_encode($ids);
file_put_contents('lineas.json', $json);
print($json);
