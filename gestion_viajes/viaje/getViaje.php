<?php
require_once('../../odoo/odoo-conexion.php');

$id_viaje = $_GET['id_viaje'];
$kwargs = ['fields' => ['id', 'x_custodia_bel', 'name', 'date_order', 'date_start', 'x_date_arrival_shed', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_reference', 'x_modo_bel', 'upload_point', 'x_codigo_postal', 'travel_id', 'store_id', 'x_operador_bel_id', 'route_id', 'partner_id', 'x_status_viaje', 'employee_id', 'vehicle_id', 'download_point'],  'order' => 'x_status_viaje asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('travel_id', '=', intval($id_viaje))),
    )),
    $kwargs
);

echo $json = json_encode($ids);
