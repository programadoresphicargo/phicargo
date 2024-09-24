<?php
require_once('../../../mysql/conexion.php');
require_once('../../../postgresql/conexion.php');

$cn = conectar();
$pdo = conectarPostgresql();

$cliente = $_POST['idcliente'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$tipo = $_POST['tipo'];

try {
    $cn->begin_transaction();
    $sqlInsertMySQL = "INSERT INTO correos_electronicos VALUES(NULL, $cliente, '$nombre', '$correo', '$tipo', 'activo')";
    if ($cn->query($sqlInsertMySQL)) {
        $lastId = $cn->insert_id;
        $pdo->beginTransaction();
        $sqlInsertPostgres = "INSERT INTO correos_electronicos (id_correo, id_cliente, nombre_completo, correo, tipo, estado) VALUES (?, ?, ?, ?, ?, 'activo')";
        $stmPostgres = $pdo->prepare($sqlInsertPostgres);
        if ($stmPostgres->execute([$lastId, $cliente, $nombre, $correo, $tipo])) {
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
