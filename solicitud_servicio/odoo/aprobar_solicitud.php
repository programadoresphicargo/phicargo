<?php
require_once('../../odoo/odoo-conexion.php');

$id_solicitud = $_POST['id_solicitud'];

$kwargs = ['fields' => [
    'id',
    'name',
    'sequence_id'
], 'order' => 'id desc'];

$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        array('id', '=', intval($id_solicitud)),
    ),),
    $kwargs
);

$json = json_encode($ids);
$ids = json_decode($json, true);

if ($ids !== null) {
    foreach ($ids as $elemento) {
        $id = $elemento['id'];
        $name = $elemento['name'];
        $sequence_id = $elemento['sequence_id'];
        $sequence_id_numero = $sequence_id[0];
    }
} else {
    echo "Error al decodificar el JSON.\n";
}

if ($name == false) {

    $kwargs = [
        'fields' => [
            'id',
            'name',
            'sequence_id'
        ],
        'order' => 'name desc', 'limit' => 1
    ];

    $ids = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.waybill',
        'search_read',
        array(array(
            array('sequence_id', '=', $sequence_id_numero),
            array('name', '!=', false),
            array('state', '!=', 'cancel'),
        ),),
        $kwargs
    );

    $json = json_encode($ids);
    $ids = json_decode($json, true);

    if ($ids !== null) {
        foreach ($ids as $elemento) {
            $name = $elemento['name'];
            $name = preg_replace_callback('/(\d+)/', function ($matches) {
                return $matches[1] + 1;
            }, $name);

            $nuevo_numero = preg_replace('/[A-Za-z-]+/', '', $name);

            switch ($sequence_id_numero) {
                case 35:
                    $name = 'CPV-0' . $nuevo_numero;
                    break;
                case 344:
                    $name = 'CPMZN-' . $nuevo_numero;
                    break;
                case 187:
                    $name = 'CPMX-' . $nuevo_numero;
                    break;
            }

            $partner_record_ids = [intval($id_solicitud)];
            $partner_value = [
                'name' => $name,
                'state' => 'approved'
            ];
            $values = [$partner_record_ids, $partner_value];

            $partners = $models->execute_kw($db, $uid, $password, 'tms.waybill', 'write', $values);
            if ($partners == 1) {
                $respuesta = array(
                    "mensaje" => "Solicitud aprobada.",
                    "estado" => "correcto",
                    "name" => $name,
                );
            } else {
                $respuesta = array(
                    "mensaje" => $partners,
                    "estado" => "error"
                );
            }
        }
    } else {
        echo "Error al decodificar el JSON.\n";
    }
} else {
    $respuesta = array(
        "mensaje" => "Solicitud ya confirmada.",
        "estado" => "error"
    );
}

$json_respuesta = json_encode($respuesta);
echo $json_respuesta;
