<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_empresa = $_POST['id_empresa'];
$sql = "SELECT * FROM visitantes where id_empresa = $id_empresa";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = array("value" => $row["id_visitante"], "text" => $row["nombre_visitante"]);
    }
}

header('Content-Type: application/json');
echo json_encode($options);
