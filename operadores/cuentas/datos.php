<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();

$ids = $models->execute_kw($db, $uid, $password, 'hr.employee', 'fields_get', array(), array('attributes' => array('string', 'help', 'type')));

$json = json_encode($ids);
$bytes = file_put_contents("operadores-datos.json", $json);

if (file_exists('operadores.json')) {
    $filename   = 'operadores.json';
    $data       = file_get_contents($filename);
    $operadores = json_decode($data);
} else {
}
