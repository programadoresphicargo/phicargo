<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

date_default_timezone_set('America/Mexico_City');
$fechaHoraActual = date('Y-m-d H:i:s');

$maniobra_id = $_POST['maniobra_id'];
$tipo_maniobra = $_POST['tipo_maniobra'];
$usuario_id = $_POST['usuario_id'];
$dataArray = json_decode($_POST['checklist'], true);

try {
    $cn->begin_transaction();
    $SQL = "SELECT * FROM maniobras where id_cp = $maniobra_id and tipo = '$tipo_maniobra' and status != 'cancelado'";
    $result = $cn->query($SQL);

    if ($result->num_rows <= 0) {
        $sqlManiobra = "INSERT INTO maniobras VALUES(NULL,$maniobra_id, 'Disponible', '$tipo_maniobra', NULL, NULL, NULL, NULL, NULL)";
        $resultado = $cn->query($sqlManiobra);
        $ultimoIdInsertado = $cn->insert_id;

        foreach ($dataArray as $item) {
            $nombre_elemento = $item['nombre_elemento'];
            $estado =  $item['estado'];
            $observacion = $item['observacion'];
            $sql = "INSERT INTO revisiones_elementos_maniobra VALUES(NULL, $ultimoIdInsertado, $nombre_elemento, $estado, '$observacion','$fechaHoraActual',NULL,NULL,NULL)";
            $cn->query($sql);
        }
    } else {
        $rowM = $result->fetch_assoc();
        $ultimoIdInsertado = $rowM['id'];

        if ($rowM['status'] == 'Disponible') {
            foreach ($dataArray as $item) {
                $nombre_elemento = $item['nombre_elemento'];
                $estado =  $item['estado'];
                $observacion = $item['observacion'];
                $sql = "UPDATE revisiones_elementos_maniobra SET estado_salida = $estado, observacion_salida = '$observacion' where maniobra_id = $ultimoIdInsertado and elemento_id = $nombre_elemento";
                $cn->query($sql);
            }
        } else if ($rowM['status'] == 'Activo') {
            foreach ($dataArray as $item) {
                $nombre_elemento = $item['nombre_elemento'];
                $estado =  $item['estado'];
                $observacion = $item['observacion'];
                $sql = "UPDATE revisiones_elementos_maniobra SET estado_entrada = $estado, observacion_entrada = '$observacion' where maniobra_id = $ultimoIdInsertado and elemento_id = $nombre_elemento";
                $cn->query($sql);
            }
        }
    }

    $cn->commit();
    echo 1;
} catch (Exception $e) {
    $cn->rollback();
    echo 'Error en la línea ' . $e->getLine() . ': ' . $e->getMessage();
}
