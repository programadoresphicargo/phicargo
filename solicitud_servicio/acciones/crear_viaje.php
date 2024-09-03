<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = intval($_POST['id_solicitud']);

$values = [
    'tms_waybills' => [$id_solicitud],
    'route_id' => 10336,
    'vehicle_id' => 6640,
    'employee_id' => 620,
    'tms.route'
];

$result = $models->execute_kw($db, $uid, $password, 'tms.travel', 'create', [$values]);
if ($result) {
    print_r($result);
} else {
    die('Approval failed.');
}
