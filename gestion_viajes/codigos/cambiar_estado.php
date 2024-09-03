<?php


function actualizar_odoo($id_viaje, $estado)
{
    require_once('../../mysql/conexion.php');
    include('../../odoo/odoo-conexion.php');

    $cn = conectar();
    $sql = "UPDATE viajes set estado = '$estado' where id = $id_viaje";
    if ($cn->query($sql)) {
        $partner_record_ids = [intval($id_viaje)];
        $partner_value = [
            'x_status_viaje' => $estado,
        ];
        $values = [$partner_record_ids, $partner_value];
        $partners = $models->execute_kw($db, $uid, $password, 'tms.travel', 'write', $values);
    }
}

function cambiar_estado($id_viaje, $id_status)
{
    switch ($id_status) {
        case 3:
        case 4:
            actualizar_odoo($id_viaje, 'planta');
            break;
        case 8:
            actualizar_odoo($id_viaje, 'retorno');
            break;
        case 16:
            actualizar_odoo($id_viaje, 'resguardo');
            break;
        case 1:
            actualizar_odoo($id_viaje, 'ruta');
            break;
        case 103:
            actualizar_odoo($id_viaje, 'finalizado');
            break;
    }
}
