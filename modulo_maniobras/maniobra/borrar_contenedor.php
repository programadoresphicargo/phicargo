<?php
require_once('../../postgresql/conexion.php');
session_start();
$cn = conectar();

$id = $_GET['id'];

// Prepara la consulta con el parámetro
$sql = "DELETE FROM maniobras_contenedores WHERE id = :id";

try {
    // Prepara la consulta
    $stmt = $cn->prepare($sql);

    // Ejecuta la consulta con el valor proporcionado de manera segura
    $stmt->execute([':id' => $id]);

    // Verifica si se eliminó alguna fila
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => 1]);
    } else {
        // Si no se eliminó ninguna fila, lanza un error
        throw new Exception("No se encontró la fila para eliminar.");
    }
} catch (PDOException $e) {
    // Captura y muestra errores relacionados con la consulta
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Captura cualquier otro tipo de excepción
    echo json_encode(['error' => $e->getMessage()]);
}
