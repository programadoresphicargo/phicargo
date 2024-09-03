<?php

require_once('../../../mysql/conexion.php');
date_default_timezone_set('America/Mexico_City');

$fecha_actual = date('Y-m-d H:i:s');

$id_viaje = $_POST['id_viaje'];
$id_cp = $_POST['id_cp'];
$id_usuario = $_POST['id_usuario'];
$tipo_checklist = $_POST['tipo_checklist'];
$dataArray = json_decode($_POST['checklist'], true);

$cn = conectar();
$cn->begin_transaction();

try {
    $sqlSelectCheckList = "SELECT * FROM checklist_contenedor WHERE id_cp = $id_cp and id_viaje = $id_viaje";
    $resultadoCheckList = $cn->query($sqlSelectCheckList);
    if ($resultadoCheckList->num_rows <= 0) {
        $sqlSelect = "INSERT INTO checklist_contenedor VALUES(NULL,$id_viaje,$id_cp, NULL,$id_usuario,'$fecha_actual')";
        if ($cn->query($sqlSelect)) {
            $id_auto_generado = $cn->insert_id;
            foreach ($dataArray as $item) {
                $nombre_elemento = $item['nombre_elemento'];
                $estado =  $item['estado'];
                $observacion = $item['observacion'];
                if ($tipo_checklist == 'salida') {
                    $sql = "INSERT INTO revisiones_elementos_contenedor VALUES(NULL,$id_auto_generado,$nombre_elemento,$estado,NULL,'$observacion',NULL)";
                } else {
                    $sql = "UPDATE revisiones_elementos_contenedor set estado_entrada = $estado, observacion_entrada = '$observacion' where checklist_id = $checklist";
                }
                if ($cn->query($sql)) {
                } else {
                }
            }
        } else {
        }
    } else {
        $rowChecList = $resultadoCheckList->fetch_assoc();
        $checklist = $rowChecList['checklist_id'];
        foreach ($dataArray as $item) {
            $nombre_elemento = $item['nombre_elemento'];
            $estado =  $item['estado'];
            $observacion = $item['observacion'];
            if ($tipo_checklist == 'salida') {
                $sqlSelect = "UPDATE revisiones_elementos_contenedor set estado_salida = $estado, observacion_salida = '$observacion' where checklist_id = $checklist and elemento_id = $nombre_elemento";
            } else {
                $sqlSelect = "UPDATE revisiones_elementos_contenedor set estado_entrada = $estado, observacion_entrada = '$observacion'  where checklist_id = $checklist and elemento_id = $nombre_elemento";
            }

            $cn->query($sqlSelect);
        }
    }

    if ($cn->commit()) {
        echo 1;
    } else {
        echo 0;
    }
} catch (Exception $e) {
    $cn->rollback();
    echo "Se ha producido una excepción en la línea " . $e->getLine() . ": " . $e->getMessage();
}
