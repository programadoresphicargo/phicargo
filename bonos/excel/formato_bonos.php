<?php

require_once('../../vendor/autoload.php');
require_once('../../mysql/conexion.php');

date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria de México
$fechaActual = date('Y-m-d H:i:s');

$cn = conectar();
$operadores_existen = true;

use PhpOffice\PhpSpreadsheet\IOFactory;

$fecha = $_POST['fecha'];
$separado = explode("-", $fecha);

$mes = $separado[0];
$año = $separado[1];

$targetDir = "../" . $año . '/';

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
} else {
}

$fileName = $_FILES["archivo"]["name"];
$extension = pathinfo($fileName, PATHINFO_EXTENSION);
$uniqueName = 'Bonos_operadores_' . $mes . '-' . $año . '.' . $extension;
move_uploaded_file($_FILES["archivo"]["tmp_name"], $targetDir . $uniqueName);
$filePath = $targetDir . $uniqueName;

$documento = IOFactory::load($filePath);

$hoja = $documento->getSheet(0);
$numeroFilas = $hoja->getHighestDataRow();
$letra = $hoja->getHighestColumn();

$cantidad = 0;
$querys = 0;

for ($i = 3; $i <= $numeroFilas; $i++) {
    $cantidad++;
    $operador = $hoja->getCellByColumnAndRow('2', $i);
    $sqlSelect = "SELECT * FROM operadores where nombre_operador = '$operador'";
    echo $sqlSelect.'<br>';
    $resultado = $cn->query($sqlSelect);
    $row12 = $resultado->fetch_assoc();
        echo $row12['nombre_operador'].'<br>';

    if ($resultado->num_rows == 0) {
        echo $row12['nombre_operador'].'<br>';
        $operadores_existen = false;
    }else{
                echo 'existe'. $row12['nombre_operador'].'<br>';
    }

    for ($y = 3; $y <= 11; $y++) {
        $celda = $hoja->getCellByColumnAndRow($y, $i)->getCalculatedValue();
    }
}

if ($operadores_existen == true) {
    for ($i = 3; $i <= $numeroFilas; $i++) {

        $operador = $hoja->getCellByColumnAndRow('2', $i);
        $km_recorridos = $hoja->getCellByColumnAndRow('3', $i);
        $calificacion = $hoja->getCellByColumnAndRow('4', $i);
        $excelencia = $hoja->getCellByColumnAndRow('5', $i)->getCalculatedValue();
        $productividad = $hoja->getCellByColumnAndRow('6', $i)->getCalculatedValue();
        $operacion = $hoja->getCellByColumnAndRow('7', $i)->getCalculatedValue();
        $seguridad_vial = $hoja->getCellByColumnAndRow('8', $i)->getCalculatedValue();
        $cuidado_unidad = $hoja->getCellByColumnAndRow('9', $i)->getCalculatedValue();
        $rendimiento = $hoja->getCellByColumnAndRow('10', $i)->getCalculatedValue();
        $total = $hoja->getCellByColumnAndRow('11', $i)->getCalculatedValue();

        if (empty($productividad)) {
            $productividad = 0;
        }

        $sqlSelect = "SELECT * FROM operadores where nombre_operador = '$operador'";
        $resultado = $cn->query($sqlSelect);
        $row = $resultado->fetch_assoc();

        try {
            $id_operador = $row['id'];
            $sqlInsert = "INSERT INTO bonos VALUES(NULL,$id_operador,$mes,$año,$km_recorridos,$calificacion,$excelencia,$productividad,$operacion,$seguridad_vial,$cuidado_unidad,$rendimiento,$total,'$fechaActual')";
            if ($cn->query($sqlInsert)) {
                $querys++;
            } else {
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
} else {
    echo 'Error, Listado de operadores.';
}

if ($cantidad != $querys) {
    echo 'ERROR';
}
