<?php

require_once('../../postgresql/conexion.php'); // Asegúrate de que la conexión a PostgreSQL esté en este archivo
$cn = conectar(); // Supongo que tu función `conectar` devuelve un objeto PDO

date_default_timezone_set('America/Mexico_City');
$fechaHoraActual = date('Y-m-d H:i:s');

$id_maniobra = $_POST['id_maniobra'];
$id_usuario = $_POST['id_usuario'];
$dataArray = json_decode($_POST['checklist'], true);

try {
    // Iniciar la transacción
    $cn->beginTransaction();

    // Consulta para verificar si la maniobra ya existe
    $SQL = "SELECT * FROM checklists_maniobras inner join maniobras on maniobras.id_maniobra = checklists_maniobras.id_maniobra WHERE checklists_maniobras.id_maniobra = :id_maniobra";
    $stmt = $cn->prepare($SQL);
    $stmt->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() <= 0) {
        $sqlManiobra = "INSERT INTO checklists_maniobras (id_maniobra,id_usuario_abrio,fecha_abrio) 
                        VALUES (:id_maniobra,:id_usuario_abrio,:fecha_abrio)";
        $stmtManiobra = $cn->prepare($sqlManiobra);
        $tipo_maniobra = '';
        $stmtManiobra->bindParam(':id_maniobra', $id_maniobra, PDO::PARAM_INT);
        $stmtManiobra->bindParam(':id_usuario_abrio', $fecha_hora, PDO::PARAM_INT);
        $stmtManiobra->bindParam(':fecha_abrio', $fecha_hora, PDO::PARAM_STR);
        $stmtManiobra->execute();

        $ultimoIdInsertado = $cn->lastInsertId();

        foreach ($dataArray as $item) {
            $nombre_elemento = $item['nombre_elemento'];
            $estado = $item['estado'];
            $observacion = $item['observacion'];

            $sql = "INSERT INTO revisiones_elementos_maniobra 
                    (id_checklist, id_elemento, estado_salida, observacion_salida)
                    VALUES (:id_checklist, :id_elemento, :estado_salida, :observacion_salida)";
            $stmtRevision = $cn->prepare($sql);
            $stmtRevision->bindParam(':id_checklist', $ultimoIdInsertado, PDO::PARAM_INT);
            $stmtRevision->bindParam(':id_elemento', $nombre_elemento, PDO::PARAM_INT);
            $stmtRevision->bindParam(':estado_salida', $estado, PDO::PARAM_BOOL);
            $stmtRevision->bindParam(':observacion_salida', $observacion, PDO::PARAM_STR);
            $stmtRevision->execute();
        }
    } else {
        $rowM = $stmt->fetch(PDO::FETCH_ASSOC);
        $ultimoIdInsertado = $rowM['id_checklist'];

        if ($rowM['estado_maniobra'] == 'activa') {
            foreach ($dataArray as $item) {
                $nombre_elemento = $item['nombre_elemento'];
                $estado = $item['estado'];
                $observacion = $item['observacion'];

                $sql = "UPDATE revisiones_elementos_maniobra 
                        SET estado_entrada = :estado_entrada, observacion_entrada = :observacion_entrada 
                        WHERE id_checklist = :id_checklist AND id_elemento = :id_elemento";
                $stmtUpdate = $cn->prepare($sql);
                $stmtUpdate->bindParam(':estado_entrada', $estado, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':observacion_entrada', $observacion, PDO::PARAM_STR);
                $stmtUpdate->bindParam(':id_checklist', $ultimoIdInsertado, PDO::PARAM_INT);
                $stmtUpdate->bindParam(':id_elemento', $nombre_elemento, PDO::PARAM_INT);
                $stmtUpdate->execute();
            }
        }
    }

    $cn->commit();
    echo 1;
} catch (Exception $e) {
    $cn->rollBack();
    echo 'Error en la línea ' . $e->getLine() . ': ' . $e->getMessage();
}
