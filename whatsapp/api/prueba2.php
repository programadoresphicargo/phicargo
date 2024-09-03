<?php
require_once('../../odoo/odoo-conexion.php');

$values = [
    'route_id' => 10336,
    'vehicle_id' => 6640,
    'employee_id' => 620,
    'store_id' => 9
];
$partners = $models->execute_kw($db, $uid, $password, 'tms.travel', 'create', [$values]);

echo "<pre>" . print_r($partners, true) . "</pre>";
