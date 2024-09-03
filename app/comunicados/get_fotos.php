<?php

require_once('../../mysql/conexion.php');

$cn = conectar();
$id_comunicado = $_POST['id_comunicado'];
$sqlSelect = "SELECT nombre FROM comunicados_fotos where id_comunicado = $id_comunicado";
$resultado = $cn->query($sqlSelect);

$userData = array(); // Declarar la variable $userData fuera del bucle

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
}

$json = json_encode($userData); // Mover la línea de codificación JSON fuera del bucle

print($json);
