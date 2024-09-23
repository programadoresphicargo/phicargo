<?php
require_once('../../postgresql/conexion.php');
require_once('../correos/control_correos.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$pdo = conectarPostgresql();
$id_usuario = $_SESSION['userID'];
$fechaHora = date('Y-m-d H:i:s');

$id_maniobra = $data['id_maniobra'];
$inicio_programado = $data['inicio_programado'];
$tipo_maniobra = $data['tipo_maniobra'];
$terminal = $data['terminal'];
$operador_id = $data['operador_id'];
$vehicle_id = $data['vehicle_id'];
$id_cp = $data['id_cp'];
$correos_ligados = $data['correos_ligados'];
$correos_desligados = $data['correos_desligados'];

$trailer1_id = isset($data['trailer1_id']) && $data['trailer1_id'] !== '' ? $data['trailer1_id'] : null;
$trailer2_id = isset($data['trailer2_id']) && $data['trailer2_id'] !== '' ? $data['trailer2_id'] : null;
$dolly_id = isset($data['dolly_id']) && $data['dolly_id'] !== '' ? $data['dolly_id'] : null;
$motogenerador_1 = isset($data['motogenerador_1']) && $data['motogenerador_1'] !== '' ? $data['motogenerador_1'] : null;
$motogenerador_2 = isset($data['motogenerador_2']) && $data['motogenerador_2'] !== '' ? $data['motogenerador_2'] : null;

try {
    $sql_update_maniobra = "
    UPDATE maniobras 
    SET tipo_maniobra = :tipo_maniobra, 
        inicio_programado = :inicio_programado, 
        terminal = :terminal, 
        operador_id = :operador_id, 
        vehicle_id = :vehicle_id, 
        trailer1_id = :trailer1_id, 
        trailer2_id = :trailer2_id, 
        dolly_id = :dolly_id, 
        motogenerador_1 = :motogenerador_1, 
        motogenerador_2 = :motogenerador_2
    WHERE id_maniobra = :id_maniobra";

    // Preparar la consulta SQL
    $stmt = $pdo->prepare($sql_update_maniobra);
    // Ejecutar la consulta con los parámetros
    $stmt->execute([
        ':tipo_maniobra' => $tipo_maniobra,
        ':inicio_programado' => $inicio_programado,
        ':terminal' => $terminal,
        ':operador_id' => $operador_id,
        ':vehicle_id' => $vehicle_id,
        ':trailer1_id' => $trailer1_id,
        ':trailer2_id' => $trailer2_id,
        ':dolly_id' => $dolly_id,
        ':motogenerador_1' => $motogenerador_1,
        ':motogenerador_2' => $motogenerador_2,
        ':id_maniobra' => $id_maniobra
    ]);

    if ($tipo_maniobra == 'retiro') {
        require_once('guardar_datos_retiro.php');
    } else if ($tipo_maniobra == 'ingreso') {
        require_once('guardar_datos_ingreso.php');
    }

    print_r($correos_ligados);
    print_r($correos_desligados);
    insertarCorreos($pdo, $id_maniobra, $correos_ligados);
    eliminarCorreos($pdo, $id_maniobra, $correos_desligados);


    echo json_encode(["success" => 1]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
