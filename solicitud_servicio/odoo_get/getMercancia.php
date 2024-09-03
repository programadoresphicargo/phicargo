<?php
require_once('../../odoo/odoo-conexion.php');

$id = $_POST['id'];

$kwargs = ['fields' => ['id', 'waybill_id', 'description', 'sat_product_id', 'quantity', 'sat_uom_id', 'weight_charge', 'hazardous_material', 'hazardous_key_product_id', 'dimensions_charge', 'tipo_embalaje_id',]];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill.complement.cp',
    'search_read',
    array(array(
        array('waybill_id', '=', intval($id)),
    ),),
    $kwargs
);

$json = json_encode($ids);
file_put_contents('lineas.json', $json);
print($json);
