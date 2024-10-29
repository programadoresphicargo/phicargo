<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (isset($_GET['nombre_empresa'])) {
    $nombre_empresa = $cn->real_escape_string($_GET['nombre_empresa']);
    $sql_check = "SELECT * FROM empresas_accesos WHERE nombre_empresa like '%$nombre_empresa%'";
    $result_check = $cn->query($sql_check);

    if ($result_check->num_rows > 0) {
        $response = array(
            'success' => false,
            'message' => 'La empresa ya está registrada'
        );
    } else {
        $sql_insert = "INSERT INTO empresas_accesos (nombre_empresa) VALUES ('$nombre_empresa')";
        if ($cn->query($sql_insert) === TRUE) {
            $response = array(
                'success' => true,
                'message' => 'Empresa creada exitosamente',
                'id_empresa' => $cn->insert_id
            );
        } else {
            $response = array(
                'success' => false,
                'message' => 'Error al crear la empresa'
            );
        }
    }

    $result_check->free();
} else {
    $response = array(
        'success' => false,
        'message' => 'No se proporcionó el nombre de la empresa'
    );
}

$cn->close();
echo json_encode($response);
