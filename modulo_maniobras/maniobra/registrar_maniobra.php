<?php
require_once('../../postgresql/conexion.php');
require_once('../correos/control_correos.php');
session_start();

header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"), true);

$pdo = conectarPostgresql();
$id_usuario = $_SESSION['userID'];
$fechaHora = date('Y-m-d H:i:s');

$inicio_programado = $data['inicio_programado'];
$tipo_maniobra = $data['tipo_maniobra'];
$id_terminal = $data['id_terminal'];
$operador_id = $data['operador_id'];
$vehicle_id = $data['vehicle_id'];
$trailer1_id = !empty($data['trailer1_id']) ? $data['trailer1_id'] : null;
$trailer2_id = !empty($data['trailer2_id']) ? $data['trailer2_id'] : null;
$dolly_id = !empty($data['dolly_id']) ? $data['dolly_id'] : null;
$motogenerador_1 = !empty($data['motogenerador_1']) ? $data['motogenerador_1'] : null;
$motogenerador_2 = !empty($data['motogenerador_2']) ? $data['motogenerador_2'] : null;
$id_cp = $data['id_cp'];
$correos_ligados = $data['correos_ligados'];
$correos_desligados = $data['correos_desligados'];

try {
    $sql_check = "
        SELECT maniobras.id_maniobra
        FROM maniobras
        INNER JOIN maniobras_contenedores ON maniobras.id_maniobra = maniobras_contenedores.id_maniobra
        WHERE maniobras.tipo_maniobra = :tipo_maniobra
        AND maniobras_contenedores.id_cp = :id_cp
        AND maniobras.estado_maniobra = 'borrador'";

    $stmt_check = $pdo->prepare($sql_check);
    $stmt_check->execute([
        ':tipo_maniobra' => $tipo_maniobra,
        ':id_cp' => $id_cp
    ]);

    if ($stmt_check->rowCount() > 0) {
        echo json_encode(["error" => "Ya existe una maniobra de tipo " . $tipo_maniobra . ". Para abrir otra del mismo tipo, primero debes cancelar la anterior."]);
    } else {
        $pdo->beginTransaction();

        $sql_insert_maniobra = "
            INSERT INTO maniobras (
                tipo_maniobra, inicio_programado, operador_id, vehicle_id, trailer1_id, trailer2_id, dolly_id,
                motogenerador_1, motogenerador_2, usuario_registro, fecha_registro, estado_maniobra, id_terminal
            ) VALUES (
                :tipo_maniobra, :inicio_programado, :operador_id, :vehicle_id, :trailer1_id, :trailer2_id, :dolly_id,
                :motogenerador_1, :motogenerador_2, :id_usuario, :fecha_registro, 'borrador', :id_terminal
            )";

        $stmt_insert_maniobra = $pdo->prepare($sql_insert_maniobra);
        $stmt_insert_maniobra->execute([
            ':tipo_maniobra' => $tipo_maniobra,
            ':inicio_programado' => $inicio_programado,
            ':id_terminal' => $id_terminal,
            ':operador_id' => $operador_id,
            ':vehicle_id' => $vehicle_id,
            ':trailer1_id' => $trailer1_id,
            ':trailer2_id' => $trailer2_id,
            ':dolly_id' => $dolly_id,
            ':motogenerador_1' => $motogenerador_1,
            ':motogenerador_2' => $motogenerador_2,
            ':id_usuario' => $id_usuario,
            ':fecha_registro' => $fechaHora,
        ]);

        $id_maniobra = $pdo->lastInsertId();
        $sql_insert_contenedor = "
            INSERT INTO maniobras_contenedores (id_maniobra, id_cp)
            VALUES (:id_maniobra, :id_cp)";

        $stmt_insert_contenedor = $pdo->prepare($sql_insert_contenedor);
        $stmt_insert_contenedor->execute([
            ':id_maniobra' => $id_maniobra,
            ':id_cp' => $id_cp
        ]);

        $pdo->commit();
        echo json_encode(["success" => 1]);

        if ($tipo_maniobra == 'retiro') {
            require_once('guardar_datos_retiro.php');
        } else if ($tipo_maniobra == 'ingreso') {
            require_once('guardar_datos_ingreso.php');
        }

        insertarCorreos($pdo, $id_maniobra, $correos_ligados);
        eliminarCorreos($pdo, $id_maniobra, $correos_desligados);
    }
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(["error" => "Error: " . $e->getMessage()]);
}
