<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$operador_id = '1070';

$sql = "SELECT *
FROM maniobra
inner join operadores on operadores.id = maniobra.operador_id
where maniobra.operador_id = $operador_id";
$resultado = $cn->query($sql);
if ($resultado->num_rows > 0) {
    $data = array();
    while ($row = $resultado->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
} else {
    echo json_encode([]);
}
