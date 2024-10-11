<?php
header('Content-Type: text/html; charset=utf-8');
require_once('../../odoo/odoo-conexion.php');
require_once('../../mysql/conexion.php');
$cn = conectar();

$fecha_actual = date('Y-m-d H:i:s');

$mes = $_POST['mes'];
$año = $_POST['año'];

if (!empty($uid)) {

    $primer_dia_mes = date('Y-m-01', strtotime("$año-$mes-01")) . ' 00:00:00';
    $ultimo_dia_mes = date('Y-m-t', strtotime("$año-$mes-01")) . ' 23:59:59';

    echo $primer_dia_mes_resta = date('Y-m-d H:i:s', strtotime($primer_dia_mes . ' +6 hours'));
    echo $ultimo_dia_mes_resta = date('Y-m-d H:i:s', strtotime($ultimo_dia_mes . ' +6 hours'));

    $kwargs = ['order' => 'employee_id desc, date desc', 'fields' => ['id', 'distance_route', 'employee_id', 'x_puesto', 'date', 'name']];

    $partners = $models->execute_kw(
        $db,
        $uid,
        $password,
        'tms.travel',
        'search_read',
        array(array(
            array('date', '>=', $primer_dia_mes_resta),
            array('date', '<=', $ultimo_dia_mes_resta),
            array('state', '!=', 'cancel'),
            array('x_puesto', '=', [25, 55]),
            array('x_permisionario', '!=', true),
        )),
        $kwargs
    );

    $json = json_encode($partners);
    //print_r($json);
} else {
    echo "Failed to sign in";
}


$data = json_decode($json, true);
$resultados = array();
foreach ($data as $item) {
    $employee_id = $item['employee_id'][0];
    $distance_route = $item['distance_route'];
    $date = $item['date'];
    $name = $item['name'];
    echo $employee_id . ' --->' . $name . ' --' . $date . '<br>';

    if (isset($resultados[$employee_id])) {
        $resultados[$employee_id] += $distance_route;
    } else {
        $resultados[$employee_id] = $distance_route;
    }
}

function cmp($a, $b)
{
    if ($a == $b) {
        return 0;
    }
    return ($a > $b) ? -1 : 1;
}

uasort($resultados, 'cmp');

foreach ($resultados as $employee_id => $total_distance) {
    echo "ID: $employee_id ,Distancia total: $total_distance\n" . "<br>";
    if ($total_distance >= 13500) {
        $productividad = 1250;
    } else {
        $productividad = 0;
    }
    try {
        $sqlSelect = "INSERT INTO bonos VALUES(NULL,$employee_id,$mes,$año,$total_distance,0,0,$productividad,0,0,0,0,0,'$fecha_actual')";
        $cn->query($sqlSelect);
    } catch (Exception $e) {
        if ($e->getCode() == 1062) {
            echo "Error: Clave primaria duplicada. No se puede insertar el registro." . "<br>";
            $sqlSelect2 = "SELECT * FROM bonos where id_operador = $employee_id and mes = $mes and año = $año";
            $resultado = $cn->query($sqlSelect2);
            $row = $resultado->fetch_assoc();
            $km = $row['km_recorridos'];
            if ($km == $total_distance) {
                echo 'km iguales' . '<br>';
            } else {
                $sqlUpdate = "UPDATE bonos set km_recorridos = $total_distance, productividad = $productividad where id_operador = $employee_id and mes = $mes and año = $año";
                echo $sqlUpdate;
                if ($cn->query($sqlUpdate)) {
                    echo 'Se actualizo' . '<br>';
                }
            }
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
