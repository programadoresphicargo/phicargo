<?php
require_once("../../mysql/conexion.php");
require_once('../../odoo/odoo-conexion.php');

$id_op = $_POST['id'];

date_default_timezone_set("America/Mexico_City");
$Actual = date("Y-m-d H:i:s");

$cn = conectar();
$sqlSelect = "SELECT TURNO, FH_ENTRADA, FH_SALIDA FROM turnos_veracruz WHERE ID_OPERADOR = $id_op";
$resultSet = $cn->query($sqlSelect);
$row = $resultSet->fetch_assoc();

if ($resultSet->num_rows == 1) {
    $entrada = $row['FH_ENTRADA'];
    $salida  = $row['FH_SALIDA'];

    if ($Actual >= $entrada && $Actual < $salida) {
        $proceso = $models->execute_kw(
            $db,
            $uid,
            $password,
            'tms.waybill',
            'search',
            array(array(
                array('x_operador_bel_id', '=', $id_op),
                array(
                    'expected_date_delivery', '=',
                    date('Y/m/d'),
                ),
            ),),
        );
        $json = json_encode($proceso);
        $bytes = file_put_contents("viaje_asignado.json", $json);

        function JSON2Array($data)
        {
            return  (array) json_decode(stripslashes($data));
        }

        $array = JSON2Array($json);
        if (empty($array)) {
            echo 2;
        } else {
            echo 4;
        }
    } else {
        echo 1;
    }
} else {
    echo 3;
}
