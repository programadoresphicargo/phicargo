<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT * FROM status where tipo = 'maniobra' order by id_status";
$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);
