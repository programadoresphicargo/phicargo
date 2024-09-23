<?php
require_once('../../../mysql/conexion.php');
require_once('../../../postgresql/conexion.php');

$cn = conectar();
$pdo = conectarPostgresql();

$idcorreo = $_POST['idcorreoup'];
$nombre = $_POST['nombreup'];
$cliente = $_POST['clienteup'];
$correo = $_POST['correoup'];
$tipo = $_POST['tipoup'];

try {
    $cn->begin_transaction();
    $sqlUpdateMySQL = "UPDATE correos_electronicos SET nombre_completo = '$nombre', id_cliente = $cliente, correo = '$correo', tipo = '$tipo' WHERE id_correo = $idcorreo";

    if ($cn->query($sqlUpdateMySQL)) {
        $pdo->beginTransaction();

        $sqlUpdatePostgres = "UPDATE correos_electronicos SET nombre_completo = ?, id_cliente = ?, correo = ?, tipo = ? WHERE id_correo = ?";
        $stmPostgres = $pdo->prepare($sqlUpdatePostgres);

        if ($stmPostgres->execute([$nombre, $cliente, $correo, $tipo, $idcorreo])) {
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
