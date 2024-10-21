<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_empresa = $_GET['id_empresa'];
$sql = "SELECT * FROM visitantes where id_empresa = $id_empresa";
$result = $cn->query($sql);

$options = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $options[] = array("id_visitante" => $row["id_visitante"], "nombre_visitante" => $row["nombre_visitante"], "avatar" => "https://d2u8k2ocievbld.cloudfront.net/memojis/male/1.png");
    }
}

header('Content-Type: application/json');
echo json_encode($options);
