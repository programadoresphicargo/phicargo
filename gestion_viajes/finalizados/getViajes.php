<?php
require_once('../../odoo/odoo-conexion.php');

$domain = [
    [
        ['date_order', '>=', '2024-01-01'],
        ['date_order', '<=', '2024-01-31'],
        ['x_status_viaje', '=', ['finalizado']],
        ['travel_id', '!=', false],
    ]
];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    array(
        'fields' => array('id', 'name', 'x_ejecutivo_viaje_bel', 'date_order', 'store_id', 'employee_id', 'vehicle_id', 'route_id', 'x_reference', 'partner_id', 'travel_id', 'x_modo_bel'),
        'order' => 'date_order desc',
    )
);

echo $json = json_encode($records);
$cps = json_decode($json, true);

?>
