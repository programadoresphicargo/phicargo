<?php
require_once('../../mysql/conexion.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$cn = conectar();
$id_usuario = $_SESSION['userID'];
$fechaHora = date('Y-m-d H:i:s');

$id_maniobra = $data['id_maniobra'];
$inicio_programado = $data['inicio_programado'];
$tipo_maniobra = $data['tipo_maniobra'];
$terminal = $data['terminal'];
$operador_id = $data['operador_id'];
$vehicle_id = $data['vehicle_id'];

// Verificar si las variables están vacías y establecerlas como NULL o su valor correspondiente
$trailer1_id = !empty($data['trailer1_id']) ? $data['trailer1_id'] : 'NULL';
$trailer2_id = !empty($data['trailer2_id']) ? $data['trailer2_id'] : 'NULL';
$dolly_id = !empty($data['dolly_id']) ? $data['dolly_id'] : 'NULL';
$motogenerador_1 = !empty($data['motogenerador_1']) ? $data['motogenerador_1'] : 'NULL';
$motogenerador_2 = !empty($data['motogenerador_2']) ? $data['motogenerador_2'] : 'NULL';

// Construir la consulta SQL con las variables correctamente configuradas
$sql_update_maniobra = "UPDATE maniobra 
SET tipo_maniobra = '$tipo_maniobra', 
    inicio_programado = '$inicio_programado', 
    terminal = '$terminal', 
    operador_id = $operador_id, 
    vehicle_id = $vehicle_id, 
    trailer1_id = $trailer1_id, 
    trailer2_id = $trailer2_id, 
    dolly_id = $dolly_id, 
    motogenerador_1 = $motogenerador_1, 
    motogenerador_2 = $motogenerador_2
WHERE id_maniobra = $id_maniobra";

if ($cn->query($sql_update_maniobra)) {
    echo 1;
} else {
    echo 0;
}
