<?php
require_once('../../mysql/conexion.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$cn = conectar();
$id_usuario = $_SESSION['userID'];
$fechaHora = date('Y-m-d H:i:s');

$inicio_programado = $data['inicio_programado'];
$tipo_maniobra = $data['tipo_maniobra'];
$terminal = $data['terminal'];
$operador_id = $data['operador_id'];
$vehicle_id = $data['vehicle_id'];
$trailer1_id = !empty($data['trailer1_id']) ? $data['trailer1_id'] : 'NULL';
$trailer2_id = !empty($data['trailer2_id']) ? $data['trailer2_id'] : 'NULL';
$dolly_id = !empty($data['dolly_id']) ? $data['dolly_id'] : 'NULL';
$motogenerador_1 = !empty($data['motogenerador_1']) ? $data['motogenerador_1'] : 'NULL';
$motogenerador_2 = !empty($data['motogenerador_2']) ? $data['motogenerador_2'] : 'NULL';
$id_cp = $data['id_cp'];
$id_usuario = $_SESSION['userID'];
$peligroso = $data['peligroso'];

$sql_check = "
    SELECT maniobra.id_maniobra
    FROM maniobra
    INNER JOIN maniobra_contenedores ON maniobra.id_maniobra = maniobra_contenedores.id_maniobra
    WHERE maniobra.tipo_maniobra = '$tipo_maniobra' 
    AND maniobra_contenedores.id_cp = $id_cp
    AND maniobra.estado_maniobra = 'borrador'";

$result_check = $cn->query($sql_check);

if ($result_check->num_rows > 0) {
    echo "Ya existe una maniobra de tipo " . $tipo_maniobra . ". Para abrir otra del mismo tipo, primero debes cancelar la anterior.";
} else {
    $sql_insert_maniobra = "INSERT INTO maniobra VALUES(
        NULL, 
        '$tipo_maniobra', 
        '$inicio_programado', 
        '$terminal', 
        $operador_id, 
        $vehicle_id, 
        $trailer1_id, 
        $trailer2_id, 
        $dolly_id, 
        $motogenerador_1, 
        $motogenerador_2, 
        $id_usuario, 
        '$fechaHora', 
        'borrador', 
        NULL, 
        NULL, 
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        NULL,
        $peligroso
    )";
    $resultado = $cn->query($sql_insert_maniobra);

    if ($resultado) {
        $id_autoincremental = $cn->insert_id;
        $sql_insert_contenedor = "INSERT INTO maniobra_contenedores VALUES(NULL, $id_autoincremental, $id_cp)";
        if ($cn->query($sql_insert_contenedor)) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo "0, Error: " . $cn->error;
    }
}
