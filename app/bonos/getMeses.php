<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT mes, año FROM bonos where mes >= 1 and año = 2024 group by mes, año";
$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);