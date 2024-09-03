<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

$cn = conectar();

$kwargs = ['fields' => ['name2', 'license_plate', 'fleet_type']];
$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'fleet.vehicle',
    'search_read',
    array(array(array('fleet_type', '=', 'tractor'))),
    $kwargs
);

$json = json_encode($ids);
$bytes = file_put_contents("unidades.json", $json);

if (file_exists('unidades.json')) {
    $filename   = 'unidades.json';
    $data       = file_get_contents($filename);
    $unidades = json_decode($data);
} else {
}

foreach ($unidades as $unidad) {
    $sqlSelect = "SELECT PLACAS FROM unidades WHERE PLACAS = '$unidad->license_plate'";
    $sqlResult = $cn->query($sqlSelect);
    if ($sqlResult->num_rows == 1) {
    } else {
        $sqlInsert = "INSERT INTO unidades VALUES('$unidad->license_plate','$unidad->name2','DENTRO','Veracruz','','',NULL)";
        $cn->query($sqlInsert);
    }
}
