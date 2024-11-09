<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$sqlSelect = "SELECT * FROM permisos order by id_permiso asc";
$resultSet = $cn->query($sqlSelect);

if ($resultSet) {
    $usuarios = [];

    while ($row = $resultSet->fetch_assoc()) {
        $usuarios[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($usuarios);
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error en la consulta']);
}
