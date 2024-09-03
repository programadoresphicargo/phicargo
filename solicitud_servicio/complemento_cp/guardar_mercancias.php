<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = $_POST['id_solicitud'];

$domain = [
    ['waybill_id', '=', intval($id_solicitud)]
];

$kwargs = ['order' => 'id asc', 'fields' => ['id']];
$mercancias = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill.complement.cp',
    'search_read',
    [$domain],
    $kwargs
);

if (!isset($_POST['mercancias'])) {
    $_POST['mercancias'] = array();
}

$miArray = $_POST['mercancias'];
$idArray = array_column($miArray, 'id');

foreach ($mercancias as $mercancia) {
    $encontrado = false;
    if (in_array($mercancia['id'], $idArray)) {
        $encontrado = true;
    }

    if (!$encontrado) {
        $eliminado = $models->execute_kw($db, $uid, $password, 'tms.waybill.complement.cp', 'unlink', [[$mercancia['id']]]);
        print_r($eliminado);
    }
}


if (isset($_POST['mercancias'])) {
    $miArray = $_POST['mercancias'];

    foreach ($miArray as $valor) {
        $id = $valor['id'];
        $description = $valor['description'];
        $quantity = $valor['quantity'];
        $dimensions_charge = $valor['dimensions_charge'];
        $sat_product_id = $valor['sat_product_id'][0];
        $sat_uom_id = $valor['sat_uom_id'][0];
        $weight_charge = $valor['weight_charge'];
        $hazardous_material = $valor['hazardous_material'][0];
        $hazardous_key_product_id =  is_array($valor['hazardous_key_product_id']) ? $valor['hazardous_key_product_id'][0] : false;
        $tipo_embalaje_id = is_array($valor['tipo_embalaje_id']) ? $valor['tipo_embalaje_id'][0] : false;

        $values = [
            'waybill_id' => $id_solicitud,
            'description' => $description,
            'dimensions_charge' => $dimensions_charge,
            'quantity' => $quantity,
            'sat_product_id' => $sat_product_id,
            'sat_uom_id' => $sat_uom_id,
            'weight_charge' => $weight_charge,
            'hazardous_material' => $hazardous_material,
            'hazardous_key_product_id' => $hazardous_key_product_id,
            'tipo_embalaje_id' => $tipo_embalaje_id,
        ];

        if ($id == 0) {
            $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill.complement.cp', 'create', [$values]);
            print_r($partners);
        } else {
            $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill.complement.cp', 'write', [$id, $values]);
            print_r($partners);
        }
    }
}
