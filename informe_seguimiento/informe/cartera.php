<?php

require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');
require_once('../informe/get_semana.php');

$fecha_actual = '2023-05-01';
$fecha_anterior = date("Y-m-d", strtotime($fecha_actual . " -1 day"));

$kwargs2 = ['fields' => ['account_name', 'create_date', 'ending_balance', 'account_type', 'account_level', 'account_nature', 'period_name']];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'account.monthly_balance',
    'search_read',
    array(array(
        (array('account_name', '=', 'CARTERA DE CLIENTES')),
        (array('account_level', '=', 5)),
    ),),
    $kwargs2
);

echo $json2 = json_encode($ids2);
$data = json_decode($json2, true);

$total = 0;
$i = 0;
while ($i < count($data)) {
    $total = $total + $data[$i]['ending_balance'];
    $i++;
}

echo $total;
