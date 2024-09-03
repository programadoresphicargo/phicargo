<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = $_POST['id_solicitud'];

$domain = [
    ['waybill_id', '=', intval($id_solicitud)]
];

$kwargs = ['order' => 'id desc'];
$servicios = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill.shipped_product',
    'search_read',
    [$domain],
    $kwargs
);

if (!isset($_POST['servicios'])) {
    $_POST['servicios'] = array();
}

$miArray = $_POST['servicios'];
$idArray = array_column($miArray, 'id');

foreach ($servicios as $servicio) {
    $encontrado = false;
    if (in_array($servicio['id'], $idArray)) {
        $encontrado = true;
    }

    if (!$encontrado) {
        $eliminado = $models->execute_kw($db, $uid, $password, 'tms.waybill.shipped_product', 'unlink', [[intval($servicio['id'])]]);
        print_r($eliminado);
    }
}


if (isset($_POST['servicios'])) {
    $servicios = $_POST['servicios'];
    foreach ($servicios as $servicio) {

        $values = [
            'name' => $servicio['product_id'][1],
            'product_uom' => 7,
            'product_id' => $servicio['product_id'][0],
            'weight_estimation' => $servicio['weight_estimation'],
            'notes' => $servicio['notes'],
            'waybill_id' => $id_solicitud,
        ];

        if ($servicio['id'] == 0) {
            $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill.shipped_product', 'create', [$values]);
        } else {
            $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill.shipped_product', 'write', [intval($servicio['id']), $values]);
        }

        print_r($partners);
    }
}
