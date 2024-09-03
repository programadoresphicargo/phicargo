<?php

require_once('../../odoo/odoo-conexion.php');

$id         = $_POST['id'];
$name       = $_POST['name'];
$referencia = $_POST['referencia'];
$base64     = $_POST['base64'];

$values = [
    'name' => $name,
    'datas' => $base64,
    'res_name' => $referencia,
    'res_model' => 'tms.travel',
    'res_model_name' => 'viajes',
    'res_id' => $id,
    'type' => 'binary',
];
$partners = $models->execute_kw($db, $uid, $password, 'ir.attachment', 'create', [$values]);

echo 1;
