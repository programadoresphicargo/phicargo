<?php
include_once("../../mysql/conexion.php");
$input = filter_input_array(INPUT_POST);
$cn = conectar();

$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {

    if (isset($input['km_recorridos'])) {
        $update_field = '';
        $update_field .= "km_recorridos=" . $input['km_recorridos'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    if (isset($input['calificacion'])) {
        $update_field = '';
        $update_field .= "calificacion=" . $input['calificacion'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    if (isset($input['excelencia'])) {
        $update_field = '';
        $update_field .= "excelencia=" . $input['excelencia'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    if (isset($input['productividad'])) {
        $update_field = '';
        $update_field .= "productividad=" . $input['productividad'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    if (isset($input['operacion'])) {
        $update_field = '';
        $update_field .= "operacion=" . $input['operacion'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    if (isset($input['seguridad_vial'])) {
        $update_field = '';
        $update_field .= "seguridad_vial=" . $input['seguridad_vial'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }

    if (isset($input['cuidado_unidad'])) {
        $update_field = '';
        $update_field .= "cuidado_unidad=" . $input['cuidado_unidad'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }


    if (isset($input['rendimiento'])) {
        $update_field = '';
        $update_field .= "rendimiento=" . $input['rendimiento'] . "";
        if ($update_field && $input['id_bono']) {
            $sql_query = "UPDATE bonos SET $update_field WHERE id_bono=" . $input['id_bono'] . "";
            echo $sql_query;
            if ($cn->query($sql_query)) {
                echo 1;
            } else {
                echo 0;
            }
        }
    }
}
