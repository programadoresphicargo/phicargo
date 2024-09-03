<?php
require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'vehicle_id']];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.mro.order',
    'search_read',
    array(array(
        (array('state', '=', 'open')),
    ),),
    $kwargs
);

$json = json_encode($ids);
$data = json_decode($json, true);
if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "Error al decodificar el JSON: " . json_last_error_msg();
} else {
    foreach ($data as $item) {
        $partner_record_ids = [$item['vehicle_id'][0]];
        $partner_value = [
            'x_om' => $item['id'],
            'x_status' => 'mantenimiento',
        ];
        $values = [$partner_record_ids, $partner_value];
        $partners = $models->execute_kw($db, $uid, $password, 'fleet.vehicle', 'write', $values);
    }
}
