<?php
require_once('../../odoo/odoo-conexion.php');

echo $_POST['id'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(array('travel_id', '=', intval($_POST['id'])))),
    array(
        'fields' => array('id', 'x_reference', 'x_status_bel')
    )
);

$json = json_encode($ids);
$array = json_decode($json);

foreach ($array as $cp) {

    echo $cp->id . '<br>';
    echo $cp->x_reference . '<br>';

    $partner_record_ids = [$cp->id];
    $partner_value = [
        'x_status_bel' => 'V',
    ];
    $values = [$partner_record_ids, $partner_value];

    $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
}
