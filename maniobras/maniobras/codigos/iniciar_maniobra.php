<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');

date_default_timezone_set("America/Mexico_City");
$fecha_hora = date("Y-m-d H:i:s");

$cn = conectar();

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];
$usuario_inicio = $_POST['usuario_inicio'];

$sqlSelect = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = '$tipo' and status != 'cancelado'";

$result = $cn->query($sqlSelect);
if ($result->num_rows <= 0) {
    $sqlInsert = "INSERT INTO maniobras VALUES(NULL,$id_cp,'Activo','$tipo','$fecha_hora','$fecha_hora',NULL,$usuario_inicio,NULL)";
    try {
        if ($cn->query($sqlInsert)) {
            $partner_record_ids = [intval($id_cp)];
            if ($tipo == 'Retiro') {
                $partner_value = [
                    'x_status_maniobra_retiro' => 'activo',
                ];
            } else {
                $partner_value = [
                    'x_status_maniobra_ingreso' => 'activo',
                ];
            }
            $values = [$partner_record_ids, $partner_value];

            $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
            if ($partners) {
                echo 1;
            }
        } else {
            echo 0;
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else {
    $row = $result->fetch_assoc();
    if ($row['status'] == 'Disponible') {
        $id = $row['id'];
        $SqlUpdate = "UPDATE maniobras set status = 'Activo', usuario_inicio = $usuario_inicio, fecha_inicio = '$fecha_hora', ultimo_envio = '$fecha_hora'  where id = $id";
        try {
            if ($cn->query($SqlUpdate)) {
                $partner_record_ids = [intval($id_cp)];
                if ($tipo == 'Retiro') {
                    $partner_value = [
                        'x_status_maniobra_retiro' => 'activo',
                    ];
                } else {
                    $partner_value = [
                        'x_status_maniobra_ingreso' => 'activo',
                    ];
                }
                $values = [$partner_record_ids, $partner_value];

                $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
                if ($partners) {
                    echo 1;
                }
            } else {
                echo 0;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else {
        echo 2;
    }
}
