<?php

require_once('../../ripcord-master/ripcord.php');

try {
    $Datos = file_get_contents('../../ajustes/configuraciones/GuardarCredencialesOdooCorreo.json');
} catch (Exception $e) {
    echo $e->getMessage();
}

$decoded_json = json_decode($Datos, true);
$json = json_encode($decoded_json);

$url = $decoded_json[0];
$username = $decoded_json[1];
$password = $decoded_json[2];
$db = $decoded_json[3];

$models = ripcord::client("$url/xmlrpc/2/common");

try {
    $uid = $models->authenticate($db, $username, $password, array());
    $models = ripcord::client("$url/xmlrpc/2/object");
} catch (Exception $e) {
    echo 'Se produjo una excepción: ',  $e->getMessage(), "\n";
}
