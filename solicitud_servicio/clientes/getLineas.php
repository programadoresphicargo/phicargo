<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name']];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'res.partner',
        'search_read',
        array(array(
            array('active', '=', 'true'),
        ),),
        $kwargs
    );

$data = json_encode($partners, true);
file_put_contents('clientes.json', $data);
echo $data;
