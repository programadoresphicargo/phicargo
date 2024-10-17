<?php
require_once('../../../postgresql/conexion.php');
$cn = conectarPostgresql();
$date = date('Y-m-d H:i:s');

if (isset($_POST['id_maniobra'])) {
    $id_maniobra = $_POST['id_maniobra'];
} else {
    $id_maniobra = $_GET['id_maniobra'];
}

try {
    $sql = "SELECT * FROM reportes_estatus_maniobras 
    left join status on status.id_status = reportes_estatus_maniobras.id_estatus
    left join ubicaciones_maniobras on ubicaciones_maniobras.id_ubicacion = reportes_estatus_maniobras.id_ubicacion
    where reportes_estatus_maniobras.id_maniobra = $id_maniobra order by reportes_estatus_maniobras.fecha_hora desc";
    $stmt = $cn->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
}

?>

<ul class="step">
    <?php foreach ($rows as $row) { ?>
        <li class="step-item">
            <div class="step-content-wrapper">
                <div class="step-avatar">
                    <span class="step-icon step-icon-soft-dark">E</span>
                </div>
                <div class="step-content">
                    <h5 class="mb-1"><span class="badge bg-success rounded-pill"></span><span class="badge bg-primary rounded-pill"><?php echo $row['status'] ?></span><?php echo $row['comentarios_estatus'] ?></h5>
                    <ul class="list-group list-group-sm">
                        <li class="list-group-item list-group-item-light">
                            <div class="row gx-1">
                                <div class="col-12">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-truncate ms-2">
                                            <span class="d-block fs-6 text-dark text-truncate">Coordenadas: <?php echo $row['latitud'] . ',' . $row['longitud'] ?></span>
                                            <span class="d-block fs-6 text-dark text-truncate">Referencia: <?php echo $row['localidad'] ?></span>
                                            <span class="d-block fs-6 text-dark text-truncate">Calle: <?php echo $row['calle'] ?></span>
                                            <span class="d-block fs-6 text-dark text-truncate">Fecha: <?php echo $row['fecha_hora'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <?php
                    $sqlmagenes = "SELECT * FROM archivos_adjuntos_maniobras WHERE id_reporte = :id_reporte";
                    $stmt = $cn->prepare($sqlmagenes);
                    $stmt->execute([':id_reporte' => $row['id_reporte']]);
                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <?php if (count($resultado) > 0) { ?>
                        <ul class="list-group list-group-flush mt-2 list-group-sm">
                            <li class="list-group-item list-group-item-light">
                                <div class="row">
                                    <?php
                                    // Iterar sobre los resultados
                                    foreach ($resultado as $rowAdjunto) {
                                        $id_reporte = $rowAdjunto['id_reporte'];
                                        $id_maniobra = $row['id_maniobra'];
                                        $nombre = $rowAdjunto['nombre'];
                                        $extension = $rowAdjunto['extension'];
                                        $ruta = "../../maniobras_evidencias/M_$id_maniobra/$nombre";

                                        // Verificar si la extensión es de imagen
                                        if ($extension == 'jpg' || $extension == 'png' || $extension == 'image/jpeg'  || $extension == 'jpeg') { ?>
                                            <div class="col-auto mb-2">
                                                <a href="<?php echo $ruta ?>" data-fslightbox="gallery">
                                                    <img class="img-thumbnail" src='<?php echo $ruta ?>' alt="Image Description" height="150px" width="150px">
                                                </a>
                                            </div>
                                        <?php } else { ?>
                                            <div class="col-auto mb-2">
                                                <a href="<?php echo $ruta ?>" target="_blank">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0">
                                                            <img class="avatar avatar-xs" src="../../img/report.png" alt="Image Description">
                                                        </div>
                                                        <div class="flex-grow-1 text-truncate ms-2">
                                                            <span class="d-block fs-6 text-dark text-truncate" title="<?php echo $nombre ?>"><?php echo $nombre ?></span>
                                                            <span class="d-block small text-muted"><?php echo $extension ?></span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                    <?php } ?>

                </div>
            </div>
        </li>
    <?php } ?>
</ul>