<?php

require_once('../../mysql/conexion_inventario.php');

$cn = conectar_inventario();
$sqlSelect = "SELECT ID_DEPARTAMENTO, NOMBRE_DEP, ALIAS, ICONO from departamento where ID_DEPARTAMENTO != 1 AND ID_DEPARTAMENTO !=8 AND ID_DEPARTAMENTO != 12 AND ID_DEPARTAMENTO !=13 order by ID_DEPARTAMENTO ASC";
$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);

