<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$codigo_postal = $_POST['codigo_postal'];

$sqlSelect = "SELECT * FROM codigos_postales where codigo = $codigo_postal";
$resultado = $cn->query($sqlSelect);
if ($resultado->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
