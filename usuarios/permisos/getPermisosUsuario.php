<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_usuario = 533;

$cn = conectar();

$sqlSelect = "SELECT id_usuario, permisos.id_permiso, descripcion FROM permisos_usuarios INNER JOIN permisos on permisos.id_permiso = permisos_usuarios.id_permiso where id_usuario = $id_usuario order by id_permiso";
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
