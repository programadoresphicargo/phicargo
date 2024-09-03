<?php

require_once('../../odoo/odoo-conexion.php');

$modalidad     = $_POST['modalidad'];
$peligroso     = $_POST['peligroso'];

switch ($modalidad) {
    case $modalidad == 'full' && $peligroso == 'SI';
        $records = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('expected_date_delivery', '=', date('Y/m/d')),
                array('store_id', '=', 1),
                array('x_operador_bel', '=', false),
            ),),
            array(
                'fields' => array('name', 'store_id', 'x_ejecutivo_viaje_bel', 'partner_id', 'waybill_category', 'x_ruta_bel', 'x_tipo_bel', 'x_tipo2_bel', 'x_modo_bel', 'x_medida_bel', 'x_clase_bel', 'x_operador_bel_id', 'x_operador_bel', 'date_start_real', 'x_custodia_bel', 'x_tipo_carga'),
            )
        );
        $json = json_encode($records);
        print($json);
        break;
    case $modalidad == 'full' && $peligroso == 'NO';
        $records = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('expected_date_delivery', '=', date('Y/m/d')),
                array('store_id', '=', 1),
                array('x_operador_bel', '=', false),
                array('x_tipo_clase', '=', 'GENERAL'),
            )),
            array(
                'fields' => array('name', 'store_id', 'x_ejecutivo_viaje_bel', 'partner_id', 'waybill_category', 'x_ruta_bel', 'x_tipo_bel', 'x_tipo2_bel', 'x_modo_bel', 'x_medida_bel', 'x_clase_bel', 'x_operador_bel_id', 'x_operador_bel', 'date_start_real', 'x_custodia_bel', 'x_tipo_carga'),
            )
        );
        $json = json_encode($records);
        print($json);
        break;
    case $modalidad == 'single' && $peligroso == 'SI';
        $records = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('expected_date_delivery', '=', date('Y/m/d')),
                array('store_id', '=', 1),
                array('x_operador_bel', '=', false),
                array('x_tipo_bel', '=', 'single'),
            )),
            array(
                'fields' => array('name', 'store_id', 'x_ejecutivo_viaje_bel', 'partner_id', 'waybill_category', 'x_ruta_bel', 'x_tipo_bel', 'x_tipo2_bel', 'x_modo_bel', 'x_medida_bel', 'x_clase_bel', 'x_operador_bel_id', 'x_operador_bel', 'date_start_real', 'x_custodia_bel', 'x_tipo_carga'),
            )
        );
        $json = json_encode($records);
        print($json);
        break;
    case $modalidad == 'single' && $peligroso == 'NO';
        $records = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search_read',
            array(array(
                array('expected_date_delivery', '=', date('Y/m/d')),
                array('store_id', '=', 1),
                array('x_operador_bel', '=', false),
                array('x_tipo_bel', '=', 'single'),
                array('x_tipo_carga', '=', 'GENERAL'),
            )),
            array(
                'fields' => array('name', 'store_id', 'x_ejecutivo_viaje_bel', 'partner_id', 'waybill_category', 'x_ruta_bel', 'x_tipo_bel', 'x_tipo2_bel', 'x_modo_bel', 'x_medida_bel', 'x_clase_bel', 'x_operador_bel_id', 'x_operador_bel', 'date_start_real', 'x_custodia_bel'),
            )
        );
        $json = json_encode($records);
        print($json);
        file_put_contents('a.json', $json);
        break;
}
