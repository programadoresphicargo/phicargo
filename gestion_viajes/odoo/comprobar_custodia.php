<?php
require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

$id_viaje = $_POST['id_viaje'];
$kwargs = ['fields' => [
    'id',
    'x_custodia_bel',
    'x_empresa_custodia',
    'x_nombre_custodios',
    'x_datos_unidad',
    'x_custodia_validada'
],  'order' => 'x_status_viaje asc'];

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

$json = json_encode($ids);
$bytes = file_put_contents("cartas_porte2.json", $json);
echo $json;
