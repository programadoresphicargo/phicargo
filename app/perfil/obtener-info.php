<?php

require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'hr.employee',
    'search_read',
    array(array(array('id', '=', $id))),
    array(
        'fields' => array('name', 'image', 'job_id', 'department_id', 'tms_driver_license_id', 'tms_driver_license_type', 'x_modalidad', 'x_peligroso_lic'),
    )
);

$json = json_encode($records);
file_put_contents('ai.json', $json);
print($json);
