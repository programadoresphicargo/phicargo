<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_cp = $_POST['id_cp'];
$SqlSelect = "SELECT * FROM correos_maniobras where id_cp = $id_cp";
$result = $cn->query($SqlSelect);
$row = $result->fetch_assoc();

if ($result->num_rows > 0) {
    echo 1;
} else {
    echo 0;
}
