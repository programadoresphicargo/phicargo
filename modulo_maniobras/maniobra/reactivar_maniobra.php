<?php
require_once('../../mysql/conexion.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$cn = conectar();

$id_maniobra = $data['id_maniobra'];
$sql_update_maniobra = "UPDATE maniobra 
SET estado_maniobra = 'borrador' WHERE id_maniobra = $id_maniobra";

if ($cn->query($sql_update_maniobra)) {
    echo 1;
} else {
    echo 0;
}
