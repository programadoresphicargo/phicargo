<?php
require_once('../../postgresql/conexion.php');

$pdo = conectarPostgresql();
$id_cliente = $_GET['id_cliente'];

$sql = "SELECT DISTINCT ON (correo) 
id_correo, 
correo
FROM correos_electronicos
INNER JOIN tms_waybill ON tms_waybill.partner_id = correos_electronicos.id_cliente
WHERE correos_electronicos.id_cliente = :id_cp
ORDER BY correo ASC, id_correo";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_cp' => $id_cliente]);

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
