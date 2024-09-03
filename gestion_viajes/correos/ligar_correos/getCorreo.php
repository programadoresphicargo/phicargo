<?php
require_once '../../../mysql/conexion.php';

$id_cliente = $_POST['id_cliente'];
$mysqli = conectar();

$queryM = "SELECT id_correo, correo FROM correos_electronicos WHERE id_cliente = $id_cliente and estado = 'activo' ORDER BY correo ASC";
$resultadoM = $mysqli->query($queryM);

$correos = array();

while ($rowM = $resultadoM->fetch_assoc()) {
  $correos[] = array(
    'value' => $rowM['id_correo'],
    'text' => $rowM['correo']
  );
}

header('Content-Type: application/json');
echo json_encode($correos);
