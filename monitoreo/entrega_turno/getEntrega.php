<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_entrega = $_GET['id_entrega'];
$sql = "SELECT *
FROM entrega_turnos 
where id_entrega = $id_entrega";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($options);
