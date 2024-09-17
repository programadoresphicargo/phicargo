<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type"); 
header("Content-Type: application/json"); 


require_once('../../base_path.php');

require_once(BASE_PATH . '/mysql/conexion.php');

header('Content-Type: application/json');

$cn = conectar();

$sql = "SELECT * FROM clientes";
$resultado = $cn->query($sql);

$clientes = array();

if ($resultado->num_rows > 0) {
  while ($row = $resultado->fetch_assoc()) {
    $clientes[] = $row;
  }
}

echo json_encode($clientes);

$cn->close();
