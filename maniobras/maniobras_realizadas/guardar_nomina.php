<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
$cn = conectar();
session_start();
$id_usuario = $_SESSION['userID'];
$fecha_actual = date('Y-m-d H:i:s');

if (isset($_POST['id_operador']) && isset($_POST['maniobras'])) {
    $cn->begin_transaction();

    $id_operador = $_POST['id_operador'];
    $maniobras = $_POST['maniobras'];
    $inicio = $_POST['inicio'];
    $fin = $_POST['fin'];

    try {
        $sqlnsert = "INSERT INTO nominas_movedores VALUES(NULL,$id_operador,'$inicio','$fin',$id_usuario,'$fecha_actual','borrador')";
        if ($cn->query($sqlnsert)) {
            $id_nomina = $cn->insert_id;
            foreach ($maniobras as $maniobra) {
                $id_maniobra = $maniobra['id'];
                $tipo_maniobra =  $maniobra['tipo_maniobra'];
                $total =  $maniobra['total'];
                $sqlnsertManiobra = "INSERT INTO maniobras_nomina VALUES(NULL,$id_nomina,$id_maniobra,$total)";
                $cn->query($sqlnsertManiobra);

                $partner_record_ids = [intval($id_maniobra)];
                if ($tipo_maniobra == 'Ingreso') {
                    $partner_value = [
                        'x_ingreso_pagado' => true,
                    ];
                } else if ($tipo_maniobra == 'Retiro') {
                    $partner_value = [
                        'x_retiro_pagado' => true,
                    ];
                }
                $values = [$partner_record_ids, $partner_value];
                $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
            }
            $cn->commit();
            echo 1;
        } else {
            throw new Exception("Error al insertar en la tabla nominas_movedores.");
        }
    } catch (Exception $e) {
        $cn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: No se recibieron los datos esperados.";
}
