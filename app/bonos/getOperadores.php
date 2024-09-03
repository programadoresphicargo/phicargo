<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$mes = $_POST['mes'];
$año = $_POST['año'];

$sqlSelect = "SELECT id_bono, nombre_operador, id_operador, mes, año, km_recorridos, excelencia, productividad, operacion, seguridad_vial, cuidado_unidad, rendimiento, calificacion, sum(excelencia + productividad + operacion + seguridad_vial + cuidado_unidad + rendimiento) as total FROM bonos inner join operadores on operadores.id = bonos.id_operador where mes = $mes and año = $año group by id_bono";
$resultado = $cn->query($sqlSelect);

while ($row = $resultado->fetch_assoc()) {
    $userData[] = $row;
    $json = json_encode($userData);
}

print($json);