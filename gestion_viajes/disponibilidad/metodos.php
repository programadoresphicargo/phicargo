<?php

function actualizar_empleado($id_operador, $id_viaje, $status)
{
    include('../../odoo/odoo-conexion.php');
    $partner_record_ids = [$id_operador];
    $partner_value = [
        'x_status' => $status,
        'x_viaje' => $id_viaje
    ];
    $values = [$partner_record_ids, $partner_value];

    $models->execute_kw($db, $uid, $password, 'hr.employee', 'write', $values);
}

function actualizar_status($id_vehicle, $id_viaje, $status)
{
    include('../../odoo/odoo-conexion.php');
    $partner_record_ids = [$id_vehicle];
    $partner_value = [
        'x_status' => $status,
        'x_viaje' => $id_viaje
    ];
    $values = [$partner_record_ids, $partner_value];

    $models->execute_kw($db, $uid, $password, 'fleet.vehicle', 'write', $values);
}
