<?php

require_once('mysql/conexion.php');
$cn = conectar();

try {
    $cn->begin_transaction(); // Iniciar transacción

    $sql_select = "SELECT * FROM turnos_mexico";
    $resultado_select = $cn->query($sql_select);

    while ($row = $resultado_select->fetch_assoc()) {
        $turno = $row['turno'];
        $id_operador = $row['id_operador'];
        $placas = $row['placas'];
        $fecha = $row['fecha_llegada'];
        $hora = $row['hora_llegada'];
        $comentarios = $row['comentarios'];
        $usuario_registro = $row['usuario_registro'];
        $fecha_registro = $row['fecha_registro'];
        $fijado = $row['fijado'];

        // Comprobar si el registro ya existe en la tabla 'turnos'
        $sql_check = "SELECT COUNT(*) as count FROM turnos WHERE turno = '$turno' AND id_operador = $id_operador AND placas = '$placas' AND fecha_llegada = '$fecha' AND hora_llegada = '$hora'";
        $resultado_check = $cn->query($sql_check);
        $row_check = $resultado_check->fetch_assoc();
        $registro_existente = $row_check['count'];

        if ($registro_existente == 0) { // Si el registro no existe, insertarlo
            $sql_insert = "INSERT INTO turnos VALUES(NULL,'mexico',$turno,$id_operador,'$placas','$fecha','$hora','$comentarios',$usuario_registro,'$fecha_registro',$fijado,null,null,false,false,null)";

            echo $sql_insert;
            if ($cn->query($sql_insert)) {
                $last_insert_id = $cn->insert_id;
                echo "ID insertado: $last_insert_id<br>";
            } else {
                throw new Exception("Error al insertar datos en la base de datos.");
            }
        } else {
            echo "El registro ya existe en la base de datos. No se insertará duplicado.<br>";
        }
    }

    $cn->commit(); // Confirmar transacción

    echo "Transacción completada exitosamente.";
} catch (Exception $e) {
    $cn->rollback(); // Deshacer transacción en caso de error
    echo "Error: " . $e->getMessage();
}
