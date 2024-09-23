<?php
require_once('../../postgresql/conexion.php');
$cn = conectarPostgresql();

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

$sql = "SELECT maniobras_contenedores.id as id, x_reference, dangerous_cargo, x_reference_2 FROM maniobras_contenedores 
inner join tms_waybill on tms_waybill.id = maniobras_contenedores.id_cp
where id_maniobra = :id_maniobra";

try {
    $stmt = $cn->prepare($sql);
    $stmt->execute([':id_maniobra' => $id_maniobra]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    header('Content-Type: application/json');
    echo json_encode($data);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}
