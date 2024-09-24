<?php
require_once('../../../mysql/conexion.php');
require_once('../../../postgresql/conexion.php');

$cn = conectar();
$pdo = conectarPostgresql();

$idcorreo = $_POST['idcorreoup'];

try {
    $cn->begin_transaction();
    $sqlUpdateMySQL = "UPDATE correos_electronicos SET estado = 'inactivo' WHERE id_correo = $idcorreo";
    if ($cn->query($sqlUpdateMySQL)) {
        $pdo->beginTransaction();

        $sqlUpdatePostgres = "UPDATE correos_electronicos SET estado = 'inactivo' WHERE id_correo = ?";
        $stmPostgres = $pdo->prepare($sqlUpdatePostgres);

        if ($stmPostgres->execute([$idcorreo])) {
            $cn->commit();
            $pdo->commit();
            echo 1;
        } else {
            $pdo->rollBack();
            $cn->rollback();
            echo 0;
        }
    } else {
        $cn->rollback();
        echo 0;
    }
} catch (Exception $e) {
    $cn->rollback();
    $pdo->rollBack();
    echo "Error: " . $e->getMessage();
}
