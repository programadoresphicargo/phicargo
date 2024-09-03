<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$id_acceso = $_POST['id_acceso'];
$id_visitante = $_POST['id_visitante'];

$sql_verificar = "SELECT * FROM registro_visitantes WHERE id_acceso = $id_acceso AND id_visitante = $id_visitante";
$resultado_verificacion = $cn->query($sql_verificar);

if ($resultado_verificacion->num_rows > 0) {
    echo 2;
} else {
    $sql_insertar = "INSERT INTO registro_visitantes VALUES(NULL, $id_acceso, $id_visitante)";

    if ($cn->query($sql_insertar)) {
        echo 1;
    } else {
        echo 0;
    }
}
