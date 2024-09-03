<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();

$a = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'search_read',
    array(array(array('name', '=', 'V-30322'))),
    array('fields' => array('id', 'name', 'fleet_type'), 'limit' => 1)
);

$id = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.travel',
    'fields_get',
    array(),
    array('attributes' => array('string', 'help', 'type'))
);


$json = json_encode($a);
$bytes = file_put_contents("a.json", $json);

if (file_exists('campos.json')) {
    $filename   = 'campos.json';
    $data       = file_get_contents($filename);
    $unidades = json_decode($data);
} else {
}
