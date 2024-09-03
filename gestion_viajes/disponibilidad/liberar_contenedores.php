<?php
require_once('../../odoo/odoo-conexion.php');

date_default_timezone_set("America/Mexico_City");
$fecha_hora = date("Y-m-d H:i:s");

echo $fecha_hora;
echo $id = $_POST['id'];

$ids = $models->execute_kw(
	$db,
	$uid,
	$password,
	'tms.waybill',
	'search_read',
	array(array(array('travel_id', '=', intval($id)))),
	array('fields' => array('id', 'name', 'x_llegada_patio', 'x_status_bel'))
);

$json = json_encode($ids);
file_put_contents('x.json', $json);
$array = json_decode($json);
foreach ($array as $mydata) {

	$partner_record_ids = [$mydata->id];
	$partner_value = [
		'x_llegada_patio' => $fecha_hora,
		'x_status_bel' => "P",
	];
	$values = [$partner_record_ids, $partner_value];

	$partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

	echo $mydata->id . "<br>";
	echo $mydata->name . "<br>";
	echo $mydata->x_llegada_patio . "<br>";
}
