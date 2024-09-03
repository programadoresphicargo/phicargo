<?php
require_once('../../mysql/conexion.php');

session_start();
$id_usuario = $_SESSION['userID'];

date_default_timezone_set('America/Mexico_City');
$fechaHoraMexico = date('Y-m-d H:i:s');

$cn = conectar();
$nombre_visitante = $_POST['nombre_visitante'];
$id_empresa = $_POST['id_empresa'];

$sqlSelect = "SELECT * FROM visitantes where nombre_visitante = '$nombre_visitante'";
$resultado = $cn->query($sqlSelect);
if ($resultado->num_rows <= 0) {
    $sql = "INSERT INTO visitantes VALUES(NULL, $id_empresa,'$nombre_visitante', $id_usuario,'$fechaHoraMexico','activo')";
    if ($cn->query($sql)) {
        $id_visitante = $cn->insert_id;
        $response = array(
            'estado' => 1,
            'id_visitante' => $id_visitante
        );
        echo json_encode($response);
    } else {
        echo json_encode(array('estado' => 0));
    }
} else {
    echo json_encode(array('estado' => 2));
}
