<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$Date = date('Y-m-d');

// Realiza la consulta SQL
$sqlSelect = "SELECT * FROM usuarios";
$resultSet = $cn->query($sqlSelect);

// Verifica si la consulta fue exitosa
if ($resultSet) {
    $usuarios = [];
    
    // Itera a través de todos los registros
    while ($row = $resultSet->fetch_assoc()) {
        $usuarios[] = $row;
    }
    
    header('Content-Type: application/json'); // Establece el tipo de contenido a JSON
    echo json_encode($usuarios); // Envía la respuesta JSON con todos los registros
} else {
    // Maneja el error en caso de que la consulta falle
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Error en la consulta']);
}
?>
