<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_maniobra = $_GET['id_maniobra'];
$id_cp = $_GET['id_cp'];
$sql_insert_contenedor = "INSERT INTO maniobra_contenedores VALUES(NULL, $id_maniobra, $id_cp)";
if ($cn->query($sql_insert_contenedor)) {
    echo 1;
} else {
    echo 0;
}
