<?php

require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT * FROM comunicados inner join usuarios on usuarios.id_usuario = comunicados.id_usuario order by fecha_hora desc";
$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);
