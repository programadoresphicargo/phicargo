<?php
require_once('../../odoo/odoo-conexion.php');
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!empty($uid)) {

    $partner_record_ids = [(int)($data['id'])];
    $partner_value = [
        'x_status' => $data['estado'],
    ];
    $values = [$partner_record_ids, $partner_value];
    $partners = $models->execute_kw($db, $uid, $password, 'fleet.vehicle', 'write', $values);
    $response = [
        'success' => true,
        'message' => 'Estado actualizado correctamente'
    ];
} else {
    $response = [
        'success' => false,
        'message' => 'Faltan datos'
    ];
}

header('Content-Type: application/json');
echo json_encode($response);
