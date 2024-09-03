<?php
require_once('../../mysql/conexion.php');


function get_operadores($activo)
{
    include('../../odoo/odoo-conexion.php');
    $cn = conectar();

    $kwargs = ['fields' => ['id', 'job_id', 'name', 'x_modalidad', 'x_peligroso_lic', 'active']];
    $ids = $models->execute_kw(
        $db,
        $uid,
        $password,
        'hr.employee',
        'search_read',
        array(
            array(
                array('job_id', '=', [25, 55, 26]),
                array('active', '=', $activo),
            )
        ),
        $kwargs
    );

    $json = json_encode($ids);
    $bytes = file_put_contents("operadores.json", $json);

    if (file_exists('operadores.json')) {
        $filename   = 'operadores.json';
        $data       = file_get_contents($filename);
        $operadores = json_decode($data);
    } else {
    }

    foreach ($operadores as $operador) {
        $sqlSelect = "SELECT NOMBRE_OPERADOR FROM operadores WHERE ID = '$operador->id'";
        $resultado = $cn->query($sqlSelect);
        $puesto = $operador->job_id[0];
        if ($resultado->num_rows == 1) {
            $sqlInsert = "UPDATE operadores SET NOMBRE_OPERADOR = '$operador->name', MODALIDAD = '$operador->x_modalidad', PELIGROSO = '$operador->x_peligroso_lic', ACTIVO = '$operador->active', TIPO = $puesto  WHERE ID = '$operador->id'";
            $cn->query($sqlInsert);
        } else {
            $sqlInsert = "INSERT INTO operadores VALUES($operador->id,'$operador->name','12345', $puesto, '0','0','$operador->x_modalidad','$operador->x_peligroso_lic', NULL)";
            $cn->query($sqlInsert);
        }
    }
}

get_operadores(true);
get_operadores(false);
