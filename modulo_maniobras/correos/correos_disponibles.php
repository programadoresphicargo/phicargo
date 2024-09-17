<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_cliente = $_GET['id_cliente'];

$id_cliente = intval($id_cliente);
$SqlSelect = "SELECT * FROM correos_electronicos WHERE id_cliente = $id_cliente ORDER BY correo ASC";
$resultado = $cn->query($SqlSelect);

$correos = [];

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $correos[] = $row;
    }
}

echo json_encode($correos);
