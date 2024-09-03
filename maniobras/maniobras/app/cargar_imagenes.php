<?php

require_once('../../mysql/conexion.php');

$id_maniobra = $_POST['id_maniobra'];
$id_elemento = $_POST['id_elemento'];
$tipo = $_POST['tipo'];

$cn = conectar();
$sqlSelect = "SELECT * FROM maniobras_evidencias where id_maniobra = $id_maniobra and tipo = '$tipo' and id_elemento = $id_elemento";
$resultSet = $cn->query($sqlSelect);

if ($resultSet) {
    $data = array();
    while ($row = $resultSet->fetch_assoc()) {
        $data[] = $row;
    }
    $jsonResult = json_encode($data);
    echo $jsonResult;
} else {
    echo "Error en la consulta: " . $cn->error;
}
$cn->close();
