<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$codigo_postal = $_POST['codigo_postal'];
$latitud = $_POST['latitud'];
$longitud = $_POST['longitud'];

$sqlSelect = "INSERT INTO codigos_postales VALUES(NULL,$codigo_postal,$latitud,$longitud)";
$cn->query($sqlSelect);
