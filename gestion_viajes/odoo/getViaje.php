<?php
require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

$id_viaje = $_POST['id_viaje'];
$kwargs = ['fields' => [
    'id', 'x_custodia_bel', 'name', 'date_order',
    'date_start', 'x_date_arrival_shed', 'x_ejecutivo_viaje_bel',
    'x_reference', 'x_reference', 'x_modo_bel', 'upload_point',
    'x_codigo_postal', 'travel_id', 'store_id', 'x_operador_bel_id',
    'route_id', 'partner_id', 'x_status_viaje', 'employee_id', 'vehicle_id',
    'download_point',
    'trailer1_id', 'trailer2_id', 'dolly_id', 'x_motogenerador_1', 'x_motogenerador_2'
],  'order' => 'x_status_viaje asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'search_read',
    array(array(
        (array('id', '=', intval($id_viaje))),
    )),
    $kwargs
);

$json = json_encode($ids);
$bytes = file_put_contents("cartas_porte.json", $json);
echo $json;
