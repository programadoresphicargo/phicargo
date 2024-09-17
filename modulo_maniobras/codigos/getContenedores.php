<?php

function contenedor($id_cp)
{
    include('../../odoo/odoo-conexion.php');
    $kwargs = ['fields' => ['id', 'x_reference', 'x_reference_2']];

    $ids = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(array('id', '=', $id_cp))),
        $kwargs
    );

    return $ids;
}
