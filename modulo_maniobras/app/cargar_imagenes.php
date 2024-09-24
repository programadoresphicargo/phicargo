<?php

require_once('../../postgresql/conexion.php'); // Asegúrate de que la conexión es con PostgreSQL

$id_maniobra = $_POST['id_maniobra'];
$id_elemento = $_POST['id_elemento'];
$tipo = $_POST['tipo'];

$cn = conectarPostgresql();

$sqlSelect = "SELECT * FROM maniobras_evidencias WHERE id_maniobra = :id_maniobra AND tipo = :tipo AND id_elemento = :id_elemento";

$stmt = $cn->prepare($sqlSelect);

// Bind de los parámetros para evitar inyecciones SQL
$stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
$stmt->bindParam(':tipo', $tipo, PDO::PARAM_STR);
$stmt->bindParam(':id_elemento', $id_elemento, PDO::PARAM_INT);

// Ejecutar la consulta
if ($stmt->execute()) {
    $data = array();
    // Obtener los resultados como un arreglo asociativo
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data[] = $row;
    }
    // Convertir los resultados a JSON
    $jsonResult = json_encode($data);
    echo $jsonResult;
} else {
    echo "Error en la consulta: " . json_encode($stmt->errorInfo());
}

$cn = null; // Cerrar la conexión
