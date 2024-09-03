<?php
require_once('../../mysql/conexion.php');
require_once('../../conversion/conversion.php');
require_once('../../odoo/odoo-conexion.php');

$miArray = array();

$kwargs2 = ['fields' => ['id', 'name', 'x_ejecutivo_viaje_bel', 'date_start', 'travel_id', 'x_status_viaje', 'x_modo_bel', 'store_id', 'x_operador_bel_id', 'route_id', 'x_date_arrival_shed', 'x_reference', 'partner_id', 'vehicle_id', 'employee_id', 'x_codigo_postal', 'trailer1_id', 'trailer2_id', 'dolly_id', 'x_reference_2', 'date_order', 'date_start', 'x_date_arrival_shed', 'x_motogenerador_1', 'x_motogenerador_2', 'client_order_ref'],  'order' => 'travel_id asc'];

$ids2 = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(array(
        (array('travel_id', '!=', false)),
        (array('date_order', '>', "2023-11-13")),
        //(array('x_ejecutivo_viaje_bel', '!=', "Lucero Rodriguez Vallejo")),
        (array('x_status_viaje', '=', ['ruta', 'planta', 'retorno', false])),
    )),
    $kwargs2
);

$json2 = json_encode($ids2);
$cps = json_decode($json2, true);
file_put_contents('a.json', $json2);
$cn = conectar();


foreach ($cps as $cp) {
    $id_cp = $cp['travel_id'][0];
    $id = $cp['travel_id'][0];
    $referencia =  $cp['travel_id'][1];
    $vehicle_id = $cp['vehicle_id'][1];

    $palabras = explode(" ", $vehicle_id);
    $palabras[1] = str_replace(array('[', ']'), '', $palabras[1]);

    $employee_id = $cp['employee_id'][0];
    $modo = $cp['x_modo_bel'];
    $x_reference = str_replace("'", "", $cp['x_reference']);
    $partner_id =  $cp['partner_id'][0];
    $codigo_postal =  $cp['x_codigo_postal'];
    $store_id =  $cp['store_id'][1];
    $route_id =  $cp['route_id'][1];
    $date_order = $cp['date_order'];
    $x_inicio_programado = $cp['date_start'];
    $x_llegada_planta_programada = $cp['x_date_arrival_shed'];
    $referencia_cliente = $cp['client_order_ref'];

    if (isset($cp['vehicle_id'][0])) {
        $vehiculo =  $cp['vehicle_id'][0];
    } else {
        $vehiculo =  0;
    }

    if (isset($cp['trailer1_id'][0])) {
        $trailer1_id =  $cp['trailer1_id'][0];
    } else {
        $trailer1_id =  0;
    }

    if (isset($cp['trailer2_id'][0])) {
        $trailer2_id =  $cp['trailer2_id'][0];
    } else {
        $trailer2_id =  0;
    }

    if (isset($cp['dolly_id'][0])) {
        $dolly_id =  $cp['dolly_id'][0];
    } else {
        $dolly_id =  0;
    }

    if (isset($cp['x_motogenerador_1'][0])) {
        $motogenerador_1 =  $cp['x_motogenerador_1'][0];
    } else {
        $motogenerador_1 =  0;
    }

    if (isset($cp['x_motogenerador_2'][0])) {
        $motogenerador_2 =  $cp['x_motogenerador_2'][0];
    } else {
        $motogenerador_2 =  0;
    }

    $sql = "INSERT INTO viajes VALUES($id,'Disponible','$referencia','$palabras[1]',$employee_id,'$x_reference','$modo',$partner_id,NULL,NULL,NULL,NULL,NULL,'$store_id','$codigo_postal',$vehiculo,$trailer1_id,$trailer2_id,$dolly_id,'','$route_id','$date_order','$x_inicio_programado','$x_llegada_planta_programada',$motogenerador_1,$motogenerador_2,'$referencia_cliente')";
    try {
        $cn->query($sql);
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            //echo $id_cp . '-----------<br>';

            if (in_array($id_cp, $miArray)) {
                //echo $id_cp . 'ya esta dentro<br>';
                $sqlUpdate58 = "UPDATE viajes set x_reference_2 = '$x_reference'  where id = $id";
                try {
                    $cn->query($sqlUpdate58);
                    $miArray[] = $id_cp;
                } catch (Exception $e) {
                }
            } else {
                //echo $id_cp . 'no<br>';
                $sqlUpdate3 = "UPDATE viajes set x_reference = '$x_reference', x_reference_2 = '' where id = $id";
                //echo $x_reference . '<br>';
                try {
                    $cn->query($sqlUpdate3);
                    $miArray[] = $id_cp;
                } catch (Exception $e) {
                }
            }
            //print_r($miArray);

            $sqlUpdate = "UPDATE viajes set employee_id = $employee_id,x_modo_bel = '$modo', partner_id = $partner_id, placas = '$palabras[1]',  x_codigo_postal =  '$codigo_postal', store_id = '$store_id', vehiculo = $vehiculo, remolque1 = $trailer1_id, remolque2 = $trailer2_id, dolly = $dolly_id, route_id = '$route_id',date_order = '$date_order', x_inicio_programado = '$x_inicio_programado', x_llegada_planta_programada = '$x_llegada_planta_programada', motogenerador_1 = $motogenerador_1, motogenerador_2 = $motogenerador_2, referencia_cliente = '$referencia_cliente' where id = $id";
            try {
                if ($cn->query($sqlUpdate)) {
                    echo $sqlUpdate;
                    //echo $id . '<br>';
                } else {
                    echo 0;
                }
            } catch (Exception $e) {
            }
        } else {
            echo "Error: " . $id . $e->getMessage() . "<br>";
        }
    } catch (Exception $e) {
        echo "Error: " . $id . $e->getMessage() . "<br>";
    }
}
