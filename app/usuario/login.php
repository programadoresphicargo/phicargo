<?php
$id         = $_POST['id'];
$passwoord  = $_POST['passwoord'];
$identifier = $_POST['identifier'];

require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT IDENTIFIER FROM operadores WHERE ID = '$id'";
$resultSet = $cn->query($sqlSelect);
$row = $resultSet->fetch_assoc();
$identifier_save = $row['IDENTIFIER'];

if ($identifier_save == 0) {
    $sqlSelect = "SELECT * FROM operadores WHERE ID = '$id' and PASSWOORD = '$passwoord'";
    $resultSet = $cn->query($sqlSelect);

    if ($resultSet->num_rows === 1) {
        $datos = mysqli_fetch_assoc($resultSet);

        $sqlUpdate = "UPDATE operadores SET IDENTIFIER = '$identifier' WHERE ID = '$id'";
        $cn->query($sqlUpdate);
        echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else {
        echo json_encode(0);
    }
} else {
    $sqlSelect = "SELECT * FROM operadores WHERE ID = '$id' and PASSWOORD = '$passwoord'";
    $resultSet = $cn->query($sqlSelect);

    $sqlSelectIDPass = "SELECT * FROM operadores WHERE ID = '$id' and PASSWOORD = '$passwoord'";
    $resultSetIDPass = $cn->query($sqlSelectIDPass);

    if ($resultSet->num_rows === 1) {
        $datos = mysqli_fetch_assoc($resultSet);
        echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    } else if ($resultSetIDPass->num_rows === 1) {
        $datos = mysqli_fetch_assoc($resultSetIDPass);
        echo json_encode(2);
    } else {
        echo json_encode(0);
    }
}
