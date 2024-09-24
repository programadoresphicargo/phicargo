<?php
require_once('../../postgresql/conexion.php');

$pdo = conectarPostgresql();
$id_maniobra = $_POST['id_maniobra'];
$id_maniobra = htmlspecialchars($id_maniobra, ENT_QUOTES, 'UTF-8');

try {
    $SQL = "SELECT * FROM checklists_maniobras WHERE id_maniobra = :id_maniobra";
    $stmt = $pdo->prepare($SQL);
    $stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() >= 1) {
        $row2 = $stmt->fetch(PDO::FETCH_ASSOC);
        $id_checklist = $row2['id_checklist'];

        $sqlSelect = "SELECT * FROM revisiones_elementos_maniobra 
                      INNER JOIN elementos_checklist 
                      ON elementos_checklist.id_elemento = revisiones_elementos_maniobra.id_elemento 
                      WHERE revisiones_elementos_maniobra.id_checklist= :id_checklist 
                      ORDER BY nombre_elemento ASC";
        $stmt = $pdo->prepare($sqlSelect);
        $stmt->bindParam(':id_checklist', $id_checklist, PDO::PARAM_INT);
        $stmt->execute();
    } else {
        $sqlSelect = "SELECT * FROM elementos_checklist WHERE tipo_checklist = 'maniobra' ORDER BY nombre_elemento ASC";
        $stmt = $pdo->prepare($sqlSelect);
        $stmt->execute();
    }

    $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($array);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
