<?php
require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];

$kwargs = ['order' => 'id asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill.shipped_product',
    'search_read',
    array(array(
        array('waybill_id', '=', intval($id)),
    ),),
    $kwargs
);

$json = json_encode($ids);
print($json);
