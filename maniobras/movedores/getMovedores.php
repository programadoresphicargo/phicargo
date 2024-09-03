<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'hr.employee',
    'search_read',
    array(array(
        (array('job_id', '=', 26)),
        (array('active', '=', true)),
    ),),
    $kwargs
);

$json = json_encode($ids);
