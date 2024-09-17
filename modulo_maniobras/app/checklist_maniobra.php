<?php
require_once('../../mysql/conexion.php');

$cn = conectar();

$id_maniobra = $_POST['id_maniobra'];

$SQL = "SELECT * FROM maniobra where id_maniobra = $id_maniobra and estado_maniobra = 'borrador'";
$result4 = $cn->query($SQL);
if ($result4->num_rows < 0) {
    $row2 = $result4->fetch_assoc();
    $id = $row2['id'];
    $sqlSelect = "SELECT * FROM revisiones_elementos_maniobra inner join elementos_checklist on elementos_checklist.id_elemento = revisiones_elementos_maniobra.elemento_id where revisiones_elementos_maniobra.maniobra_id = $id order by nombre_elemento asc";
    $resultSet = $cn->query($sqlSelect);
} else {
    $sqlSelect = "SELECT * FROM elementos_checklist where tipo_checklist = 'maniobra' order by nombre_elemento asc";
    $resultSet = $cn->query($sqlSelect);
}

while ($row = mysqli_fetch_array($resultSet)) $array[] = $row;
echo $json = json_encode($array);
