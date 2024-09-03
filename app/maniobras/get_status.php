<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

if ($_POST['tipoterminal'] == 'puerto') {
    $sqlSelect = "SELECT * FROM status where (tipo = 'maniobra' || id_status = 94) and id_status !=80 and id_status != 81 order by id_status";
} else if ($_POST['tipoterminal'] == 'externa') {
    $sqlSelect = "SELECT * FROM status where tipo = 'maniobra' and (tipo_terminal = 'externa' || id_status = 94) order by id_status";
}

$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);
