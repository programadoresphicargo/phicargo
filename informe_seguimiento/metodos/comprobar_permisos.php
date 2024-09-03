<?php

require_once('../../mysql/conexion.php');
$cn = conectar();
session_start();

$id_usuario = $_SESSION['userID'];
$ids_permisos = array(121, 122, 123, 124, 125);
$existencia_permisos = array();

$sql = "SELECT id_permiso FROM permisos_usuarios WHERE id_permiso IN (" . implode(',', $ids_permisos) . ") AND id_usuario = $id_usuario";
$result = $cn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $existencia_permisos[$row['id_permiso']] = true;
    }
}

$resultados = array();

foreach ($ids_permisos as $id_permiso) {
    $resultado = array(
        'id_permiso' => $id_permiso,
        'existe' => isset($existencia_permisos[$id_permiso]),
    );
    $resultados[] = $resultado;
}

$json_resultados = json_encode($resultados);

echo $json_resultados;
