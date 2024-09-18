<?php
require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();

$kwargs = ['fields' => ['id', 'name2', 'license_plate', 'fleet_type'],  'order' => 'name2 asc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    [],
    $kwargs
);

$json = json_encode($ids);
$cps = json_decode($json, true);

$sql2 = "DELETE FROM flota";
$cn->query($sql2);

foreach ($cps as $cp) {
    $id = $cp['id'];
    $name =  $cp['name2'];
    $plates =  $cp['license_plate'];
    $fleet_type =  $cp['fleet_type'];
    $sql = "INSERT INTO flota VALUES($id,'$name','$plates','$fleet_type')";
    echo $sql;
    $cn->query($sql);
}