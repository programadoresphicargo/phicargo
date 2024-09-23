<?php
require_once('../../postgresql/conexion.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$pdo = conectarPostgresql();

$terminal = $data['terminal'];

try {

    $pdo->beginTransaction();

    $sql_insert_maniobra = "
            INSERT INTO maniobras_terminales (
                terminal
            ) VALUES (
                :terminal
            )";

    $stmt_insert_maniobra = $pdo->prepare($sql_insert_maniobra);
    $stmt_insert_maniobra->execute([
        ':terminal' => $terminal,
    ]);

    $pdo->commit();
    echo json_encode(["success" => 1]);

} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
