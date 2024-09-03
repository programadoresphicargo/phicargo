<?php
require_once('../../mysql/conexion.php');

function getEjecutivo($id)
{
    include('../../odoo/odoo-conexion.php');

    $kwargs = ['fields' => ['id', 'x_ejecutivo_viaje_bel']];

    $partners =
        $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(array('id', '=', intval($id)))),
            $kwargs
        );

    $x_ejecutivo_viaje_bel = $partners[0]['x_ejecutivo_viaje_bel'];
    return $x_ejecutivo_viaje_bel;
}