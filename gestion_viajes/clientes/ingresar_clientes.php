<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();

$kwargs = ['fields' => ['name',]];
$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'res.partner',
    'search_read',
    array(array(array('customer', '=', true))),
    $kwargs
);

$json = json_encode($ids);
$bytes = file_put_contents("clientes.json", $json);

if (file_exists('clientes.json')) {
    $filename   = 'clientes.json';
    $data       = file_get_contents($filename);
    $clientes = json_decode($data);
} else {
}

foreach ($clientes as $cliente) {
    $sqlSelect = "SELECT ID FROM clientes WHERE ID = $cliente->id";
    $sqlResult = $cn->query($sqlSelect);
    if ($sqlResult->num_rows == 1) {
    } else {
        $sqlInsert = "INSERT INTO clientes VALUES($cliente->id,'$cliente->name')";
        try {
            $cn->query($sqlInsert);
        } catch (Exception $e) {
        }
    }
}
