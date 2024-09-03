<?php

require_once('../../odoo/odoo-conexion.php');

$id_operador = $_POST['id_operador'];
$id_vehiculo = $_POST['id_vehiculo'];
$comentarios = $_POST['comentarios'];

$values = [
    'vehicle_id' => $id_vehiculo,
    'employee_id' => $id_operador,
    'x_notas_operador' => $comentarios,
    'notes' => ''
];

$partners =
    $models->execute_kw(
        $db,
        $uid,
        $password,
        'fleet.mro.driver_report',
        'create',
        [$values]
    );

if ($partners) {
    echo 1;

    $images = json_decode($_POST['images']);
    $id = $partners;
    $i = 0;

    foreach ($images as $image) {
        $values = [
            'name' => 'evidencia' . $i . '.png',
            'datas' => $image,
            'res_model' => 'fleet.mro.driver_report',
            'res_model_name' => 'Driver Report of Vehicle Failure',
            'res_id' => $id,
            'mimetype' => 'image/png'
        ];
        $partners = $models->execute_kw($db, $uid, $password, 'ir.attachment', 'create', [$values]);
        $i = $i + 1;
    }
} else {
    echo 0;
}
