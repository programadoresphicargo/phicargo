<?php
require_once('../../mysql/conexion_servi.php');
$cn = conectar_servi();

session_start();
date_default_timezone_set('America/Mexico_City');

$fecha_actual = new DateTime();
$fecha_actual_formato = $fecha_actual->format('Y-m-d H:i:s');

$fecha = $_POST['fecha_servi'];
$ingresos = $_POST['ingresos2'];
$salidas = $_POST['salidas'];
$bodega_1 = $_POST['bodega_1'];
$bodega_2 = $_POST['bodega_2'];
$bodega_3 = $_POST['bodega_3'];
$bodega_4 = $_POST['bodega_4'];
$id_usuario = $_SESSION['userID'];

if (!isset($_POST['id_dato']) || $_POST['id_dato'] == '') {
    $SQL = "SELECT * FROM datos_servi where date(fecha_registro) = '$fecha'";
    $resultado = $cn->query($SQL);
    if ($resultado->num_rows <= 0) {
        $sql = "INSERT INTO datos_servi VALUES(NULL, $ingresos, $salidas, $bodega_1, $bodega_2, $bodega_3, $bodega_4,'$fecha', '$fecha_actual_formato',$id_usuario)";
        if ($cn->query($sql)) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 2;
    }
} else {
    $id_dato = $_POST['id_dato'];
    $SQL = "UPDATE datos_servi SET maniobras_ingresos_bodega = $ingresos, maniobras_salidas_bodega = $salidas, bodega_1 = $bodega_1, bodega_2 = $bodega_2, bodega_3 = $bodega_3, bodega_4 = $bodega_4 where id_dato = $id_dato";
    if ($cn->query($SQL)) {
        echo 1;
    } else {
        echo 0;
    }
}
