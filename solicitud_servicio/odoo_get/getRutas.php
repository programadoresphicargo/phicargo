<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['order' => 'name asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.route',
    'search_read',
    [[]],
    $kwargs
);

$json = json_encode($ids);
file_put_contents('getRutas.json', $json);
print($json);
