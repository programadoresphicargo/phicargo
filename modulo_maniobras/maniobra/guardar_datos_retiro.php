<?php
require_once('../../odoo/odoo-conexion.php');
require_once('../../notificaciones/notificaciones.php');
require_once('../../mysql/conexion.php');
session_start();
$id_usuario = $_SESSION['userID'];
$cn = conectar();
$fechaHora = date("Y-m-d H:i:s");

try {
    $id_cp = $_POST['id_cp'];
    $x_mov_bel = $_POST['x_mov_bel'];
    $x_tipo_terminal_retiro = $_POST['x_tipo_terminal_retiro'];

    if ($_POST['x_inicio_programado_retiro'] == '') {
        $x_inicio_programado_retiro = false;
    } else {
        $x_inicio_programado_retiro = $_POST['x_inicio_programado_retiro'];
    }

    if ($_POST['x_solicitud_enlazada'] == '') {
        $x_solicitud_enlazada = false;
    } else {
        $x_solicitud_enlazada = intval($_POST['x_solicitud_enlazada']);
    }

    $x_operador_retiro_id = $_POST['x_operador_retiro_id'];
    $nombre_op = $_POST['nombre_op'];
    $x_eco_retiro = $_POST['nombre_eco'];
    $x_eco_retiro_id = $_POST['x_eco_retiro_id'];
    $x_remolque_1_retiro = $_POST['x_remolque_1_retiro'];
    $x_remolque_2_retiro = $_POST['x_remolque_2_retiro'];
    $x_dolly_retiro = $_POST['x_dolly_retiro'];
    $x_motogenerador_1_retiro = $_POST['x_motogenerador_1_retiro'];
    $x_motogenerador_2_retiro = $_POST['x_motogenerador_2_retiro'];

    $partner_record_ids = [intval($id_cp)];
    $partner_value = [
        'x_operador_retiro_id' => $x_operador_retiro_id,
        'x_operador_retiro' => $nombre_op,
        'x_mov_bel' => $x_mov_bel,
        'x_tipo_terminal_retiro' => $x_tipo_terminal_retiro,
        'x_inicio_programado_retiro' => $x_inicio_programado_retiro,
        'x_eco_retiro' => $x_eco_retiro,
        'x_eco_retiro_id' => $x_eco_retiro_id,
        'x_remolque_1_retiro' => $x_remolque_1_retiro,
        'x_remolque_2_retiro' => $x_remolque_2_retiro,
        'x_dolly_retiro' => $x_dolly_retiro,
        'x_motogenerador_1_retiro' => $x_motogenerador_1_retiro,
        'x_motogenerador_2_retiro' => $x_motogenerador_2_retiro,
        'x_programo_retiro_usuario' => $_SESSION['nombre'],
        'x_programo_retiro_fecha' => $fechaHora,
        'x_solicitud_enlazada' => $x_solicitud_enlazada
    ];
    $values = [$partner_record_ids, $partner_value];

    $cambios = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);

    if ($cambios) {
        echo 1;
        $sql_check = "SELECT registros_maniobras.id_maniobra FROM cp_maniobras inner join registros_maniobras on registros_maniobras.id_maniobra = cp_maniobras.id_maniobra WHERE tipo = 'Retiro' AND id_cp = $id_cp and estado = 'borrador'";
        $result = $cn->query($sql_check);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $id_existente = $row['id_maniobra'];
            $sql_update = "UPDATE registros_maniobras SET id_operador = $x_operador_retiro_id WHERE id_maniobra = $id_existente";
            if ($cn->query($sql_update) === TRUE) {
                //echo "Registro actualizado correctamente.";
                if ($_POST['x_solicitud_enlazada'] == '') {
                    $x_solicitud_enlazada = intval($_POST['x_solicitud_enlazada']);
                    $sql_insert_cp = "DELETE FROM cp_maniobras where id_maniobra = $id_existente";
                    $cn->query($sql_insert_cp);
                    $sql_insert_cp = "INSERT INTO cp_maniobras VALUES(NULL, $id_existente, $id_cp)";
                    $cn->query($sql_insert_cp);
                }
            } else {
                //echo "Error al actualizar el registro: " . $cn->error;
            }
        } else {
            $sql_insert = "INSERT INTO registros_maniobras VALUES(NULL, $x_operador_retiro_id, 'Retiro', $id_usuario, '$fechaHora','borrador')";
            if ($cn->query($sql_insert) === TRUE) {
                $id_insertado = $cn->insert_id;
                $sql_insert_cp = "INSERT INTO cp_maniobras VALUES(NULL, $id_insertado, $id_cp)";
                if ($cn->query($sql_insert_cp) === TRUE) {
                    if ($_POST['x_solicitud_enlazada'] == '') {
                    } else {
                        $x_solicitud_enlazada = intval($_POST['x_solicitud_enlazada']);
                        $sql_insert_cp = "INSERT INTO cp_maniobras VALUES(NULL, $id_insertado, $x_solicitud_enlazada)";
                        $cn->query($sql_insert_cp);
                    }
                    //echo "Nuevo registro creado correctamente.";
                } else {
                    //echo "Error al insertar en cp_maniobras: " . $cn->error;
                }
            } else {
                //echo "Error al insertar en registros_maniobras: " . $cn->error;
            }
        }
    } else {
        echo 0;
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}
