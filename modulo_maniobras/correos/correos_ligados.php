<?php
require_once('../../postgresql/conexion.php');
$pdo = conectarPostgresql();
$id_maniobra = $_GET['id_maniobra'];
$sql = "SELECT * FROM maniobras_correos inner join correos_electronicos on correos_electronicos.id_correo = maniobras_correos.id_correo where id_maniobra = $id_maniobra";
try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
