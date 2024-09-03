<?php

require_once "../../../mysql/conexion.php";
require_once "../../../google_maps/enlance/crear_enlace.php";
require_once "../../../tiempo/tiempo.php";

$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$search = $_POST['busqueda'];

$sqlSelect  =  "WITH Cambios AS (
        SELECT *,
               CASE
                   WHEN LAG(id_estatus) OVER (ORDER BY id_reporte) = id_estatus THEN 0
                   ELSE 1
               END Cambio
        FROM reportes_estatus_viajes
        WHERE id_viaje = $id_viaje
    ),
    Grupos AS (
        SELECT *,
               SUM(Cambio) OVER (ORDER BY id_reporte) Grupo
        FROM Cambios
    ),
    ReporteGrupos AS (
        SELECT
            id_estatus,
            COUNT(*) AS registros,
            GROUP_CONCAT(id_reporte ORDER BY fecha_envio DESC SEPARATOR ',') AS id_reportes_agrupados,
            MAX(fecha_envio) AS ultima_fecha_envio,
            MIN(id_reporte) AS min_id_reporte,
            MAX(id_reporte) AS max_id_reporte,
            id_usuario
        FROM Grupos
        GROUP BY id_estatus, day(fecha_envio), Grupo
        ORDER BY MIN(id_reporte)
    ),
    FechasReporteGrupos AS (
        SELECT 
            rg.*,
            (SELECT fecha_envio FROM reportes_estatus_viajes WHERE id_reporte = rg.min_id_reporte) AS primera_fecha_envio,
            (SELECT fecha_envio FROM reportes_estatus_viajes WHERE id_reporte = rg.max_id_reporte) AS ultima_fecha_envio_real
        FROM ReporteGrupos rg
    )
    SELECT
        frg.id_estatus,
        frg.registros,
        frg.id_reportes_agrupados,
        DATE(fecha_envio) AS dia_envio,
        frg.primera_fecha_envio,
        frg.ultima_fecha_envio,
        frg.id_usuario,
        status.id_status,
        status.status,
        status.imagen,
        empleados.name,
        empleados.puesto,
        usuarios.nombre
    FROM FechasReporteGrupos frg
    INNER JOIN reportes_estatus_viajes ON frg.min_id_reporte = reportes_estatus_viajes.id_reporte
    INNER JOIN status ON status.id_status = reportes_estatus_viajes.id_estatus
    LEFT JOIN empleados ON empleados.id = reportes_estatus_viajes.id_usuario
    LEFT JOIN usuarios ON usuarios.id_usuario = reportes_estatus_viajes.id_usuario
    WHERE
        frg.id_estatus LIKE '%$search%'
        OR frg.registros LIKE '%$search%'
        OR frg.id_reportes_agrupados LIKE '%$search%'
        OR frg.primera_fecha_envio LIKE '%$search%'
        OR frg.ultima_fecha_envio LIKE '%$search%'
        OR frg.id_usuario LIKE '%$search%'
        OR status.id_status LIKE '%$search%'
        OR status.status LIKE '%$search%'
        OR status.imagen LIKE '%$search%'
        OR empleados.name LIKE '%$search%'
        OR empleados.puesto LIKE '%$search%'
        OR usuarios.nombre LIKE '%$search%'
    ORDER BY frg.ultima_fecha_envio_real DESC";

$resultSet  = $cn->query($sqlSelect);

?>
<div class="accordion">
    <ul class="step">
        <?php
        $index = 0;
        $previousDiaEnvio = null;

        while ($row = $resultSet->fetch_assoc()) {

            $collapseId = "collapse"  . $index;
            $index++;
            if ($row['dia_envio'] !== $previousDiaEnvio) {
                echo '<span class="badge bg-secondary rounded-pill mb-5 mr-5 ml-5">' . $row['dia_envio'] . '</span>';
                $previousDiaEnvio = $row['dia_envio'];
            }
        ?>

            <div class="step-content-wrapper">

                <?php if ($row['puesto'] == 'OPERADOR' || $row['puesto'] == 'OPERADOR POSTURERO' || $row['puesto'] == 'MOVEDOR') { ?>
                    <span class="step-icon step-icon-sm bg-soft-secondary"><img src="../../img/status/<?php echo $row['imagen'] ?>" width="40"></span>
                <?php } else if ($row['id_usuario'] == 172 || $row['id_usuario'] == 8) { ?>
                    <span class="step-icon step-icon-sm bi bi-geo-alt-fill text-white bg-primary"></span>
                <?php } else { ?>
                    <span class="step-icon step-icon-sm bi bi-geo-alt-fill text-white bg-morado"></span>
                <?php } ?>

                <div class="step-content">

                    <div class="accordion-item mb-4">
                        <div class="accordion-header">
                            <button class="accordion-button btn-link d-flex align-items-center justify-content-between" role="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $collapseId; ?>" aria-expanded="true" aria-controls="<?php echo $collapseId; ?>">

                                <?php
                                $badgeClass = '';

                                if (in_array($row['puesto'], ['OPERADOR', 'OPERADOR POSTURERO', 'MOVEDOR']) && $row['id_status'] != 94) {
                                    $badgeClass = 'bg-success';
                                } elseif (in_array($row['id_usuario'], [172, 8])) {
                                    $badgeClass = 'bg-primary';
                                } elseif ($row['id_status'] == 94) {
                                    $badgeClass = 'bg-danger';
                                } else {
                                    $badgeClass = 'bg-morado';
                                }
                                ?>

                                <span class="badge <?php echo $badgeClass; ?> text-white rounded-pill">
                                    <span class="legend-indicator bg-white"></span>
                                    <?php echo $row['status']; ?>
                                    <?php echo $row['registros'] > 1 ?  '<span class="badge bg-danger rounded-pill">' . $row['registros'] . '</span>' : ''  ?>
                                </span>

                                <span class="text-muted">

                                    <?php
                                    $id_reportes_array = explode(',', $row['id_reportes_agrupados']);
                                    foreach ($id_reportes_array as $id_reporte) {
                                        $sqlReenvios = "SELECT * FROM reenvios_estatus inner join usuarios on usuarios.id_usuario = reenvios_estatus.id_usuario where id_reporte = $id_reporte";
                                        $resultReenvios = $cn->query($sqlReenvios);
                                    ?>

                                        <?php if ($resultReenvios->num_rows > 0) { ?>
                                            <span class="badge bg-success rounded-pill"><i class="bi bi-check-lg"></i> Enviado RV-<?php echo $id_reporte ?></span>
                                        <?php } ?>
                                    <?php }
                                    ?>

                                    <?php if ($row['nombre'] == NULL) {
                                        echo  $row['name'] ?>
                                    <?php } else {
                                        echo $row['nombre'] ?>
                                    <?php } ?>
                                    <?php
                                    $primera_fecha_envio = $row['primera_fecha_envio'];
                                    $primera_hora_minutos = date('h:i A', strtotime($primera_fecha_envio));

                                    $ultima_fecha_envio = $row['ultima_fecha_envio'];
                                    $ultima_hora_minutos = date('h:i A', strtotime($ultima_fecha_envio));

                                    ?>
                                    <span class="badge bg-secondary rounded-pill">
                                        <?php
                                        echo $primera_hora_minutos != $ultima_hora_minutos ? $primera_hora_minutos . ' - ' : '';
                                        echo $ultima_hora_minutos;
                                        ?>
                                    </span>
                                </span>

                            </button>
                        </div>
                        <div id="<?php echo $collapseId; ?>" class="accordion-collapse collapse hide" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">

                                <ul class="step">

                                    <?php
                                    $id_reportes_array = explode(',', $row['id_reportes_agrupados']);
                                    foreach ($id_reportes_array as $id_reporte) {
                                        $sqlSelectReporte  =  "SELECT * FROM reportes_estatus_viajes inner join status on status.id_status = reportes_estatus_viajes.id_estatus  inner join ubicaciones_estatus on ubicaciones_estatus.id_ubicacion = reportes_estatus_viajes.id_ubicacion inner join viajes on viajes.id = reportes_estatus_viajes.id_viaje left join empleados on empleados.id = reportes_estatus_viajes.id_usuario where id_reporte = $id_reporte order by fecha_envio desc";
                                        $resultadoReporte = $cn->query($sqlSelectReporte);
                                        $rowReporte = $resultadoReporte->fetch_assoc();
                                    ?>

                                        <li class="step-item">
                                            <div class="step-content-wrapper">

                                                <span class="step-avatar">
                                                    <?php if (($rowReporte['puesto'] == 'OPERADOR' || $rowReporte['puesto'] == 'OPERADOR POSTURERO' || $rowReporte['puesto'] == 'MOVEDOR') && $rowReporte['id_status'] != 94) { ?>
                                                        <img class="step-avatar-img" src="../../img/operador.png" alt="Image Description">
                                                    <?php } else if ($rowReporte['id_usuario'] == 172 || $rowReporte['id_usuario'] == 8) { ?>
                                                        <img class="step-avatar-img" src="../../img/automatico.png" alt="Image Description">
                                                    <?php } else if ($rowReporte['id_status'] == 94) { ?>
                                                        <img class="step-avatar-img" src="../../img/problema.png" alt="Image Description">
                                                    <?php } else { ?>
                                                        <img class="step-avatar-img" src="../../img/monitorista.png" alt="Image Description">
                                                    <?php } ?>
                                                </span>

                                                <div class="step-content">
                                                    <h5 class="mb-1">Enviado por</h5>

                                                    <?php if ($rowReporte['name'] != NULL) { ?>
                                                        <p class="fs-5 mb-1"><?php echo '(' . $rowReporte['id_usuario'] . ') ' . $rowReporte['name'] . ' - ' . $rowReporte['puesto'] ?></p>
                                                    <?php } else { ?>
                                                        <p class="fs-5 mb-1"><?php echo '(' . $rowReporte['id_usuario'] . ') ' . $row['nombre'] ?></p>
                                                    <?php } ?>

                                                    <ul class="list-group list-group-sm list-group-flush">
                                                        <li class="list-group-item list-group-item-light">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span class="d-block fs-5 text-dark text-truncate">Referencia reporte: <span class="text-muted"><?php echo 'RV-' . $rowReporte['id_reporte'] ?></span></span>
                                                                    <span class="d-block fs-5 text-dark text-truncate">Coordenadas: <span class="text-muted"><?php echo $rowReporte['latitud'] . ', ' . $rowReporte['longitud'] ?></span></span>
                                                                    <span class="d-block fs-5 text-dark">Localidad: <span class="text-muted"><?php echo $rowReporte['localidad'] ?></span></span>
                                                                    <span class="d-block fs-5 text-dark">Sublocalidad: <span class="text-muted"><?php echo $rowReporte['sublocalidad'] ?></span></span>
                                                                    <span class="d-block fs-5 text-dark">Calle: <span class="text-muted"><?php echo $rowReporte['calle'] ?></span></span>
                                                                    <?php if ($rowReporte['codigo_postal'] != 0) : ?>
                                                                        <span class="d-block fs-5 text-dark">Codigo postal: <span class="text-muted"><?php echo $rowReporte['codigo_postal'] ?></span></span>
                                                                    <?php endif; ?>
                                                                    <span class="d-block fs-5 text-dark text-truncate">Fecha y Hora: <span class="text-muted"><?php echo $rowReporte['fecha_hora'] ?></span></span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <?php
                                                    $sqlmagenes = "SELECT * FROM archivos_adjuntos WHERE id_reporte = $id_reporte";
                                                    $resultado = $cn->query($sqlmagenes);
                                                    ?>

                                                    <?php if ($resultado->num_rows > 0) { ?>
                                                        <ul class="list-group list-group-flush mt-2 list-group-sm">
                                                            <li class="list-group-item list-group-item-light">
                                                                <div class="row">
                                                                    <?php
                                                                    while ($rowAdjunto = $resultado->fetch_assoc()) {
                                                                        $id_reporte = $rowAdjunto['id_reporte'];
                                                                        $nombre = $rowAdjunto['nombre'];
                                                                        $extension = $rowAdjunto['extension'];
                                                                        $ruta = "../adjuntos_estatus/$id_viaje/$nombre";
                                                                        if ($extension == 'jpg' || $extension == 'png' || $extension == 'image/jpeg') { ?>
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

                                                    <?php if ($rowReporte['comentarios_estatus'] != null || $rowReporte['comentarios_estatus'] != '') { ?>
                                                        <ul class="list-group list-group-flush navbar-card-list-group">
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                                                <?php if ($rowReporte['puesto'] == 'OPERADOR' || $rowReporte['puesto'] == 'OPERADOR POSTURERO') { ?>
                                                                                    <img class="avatar-img" src="../../img/operador.png" alt="Image Description">
                                                                                <?php } else if ($rowReporte['id_usuario'] == 172) { ?>
                                                                                    <img class="avatar-img" src="../../img/automatico.png" alt="Image Description">
                                                                                <?php } else { ?>
                                                                                    <img class="avatar-img" src="../../img/monitorista.png" alt="Image Description">
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col ms-n2">
                                                                        <h5 class="mb-1">Se añadio un comentario:</h5>
                                                                        <p class="text-body fs-5"><?php echo $rowReporte['comentarios_estatus'] ?></p>
                                                                    </div>
                                                                    <small class="col-auto text-muted text-cap"><?php imprimirTiempo($rowReporte['fecha_envio']) ?></small>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    <?php } ?>

                                                    <?php if (($rowReporte['puesto'] == 'OPERADOR' || $rowReporte['puesto'] == 'OPERADOR POSTURERO'  || $rowReporte['puesto'] == 'MOVEDOR') && $rowReporte['id_status'] != 94) { ?>
                                                        <a class="btn btn-success btn-sm mt-2 mb-3 fw-bold btn-sm" onclick="reenviarestatus('<?php echo $rowReporte['id_reporte'] ?>')">Reenviar <i class="bi bi-reply-fill"></i></a>
                                                    <?php } ?>

                                                    <a class="btn btn-light mt-2 mb-3 fw-bold btn-sm" href="<?php echo crear_enlance($rowReporte['latitud'], $rowReporte['longitud']) ?>" role="button" target="_blank"><img src="../../img/maps.png" height="25"> Ver en Google Maps</a>
                                                    <a class="btn btn-light mt-2 mb-3 fw-bold btn-sm" href="<?php echo crear_enlance_distancia($rowReporte['latitud'], $rowReporte['longitud'], $rowReporte['x_modo_bel'], $rowReporte['x_codigo_postal'], $rowReporte['store_id']) ?>" role="button" target="_blank"><img src="../../img/distancia.png" height="25"> <?php echo $rowReporte['x_modo_bel'] == 'imp' ? 'Distancia al punto de descarga' : 'Distancia al punto de carga' ?> </a>

                                                    <?php
                                                    $sqlReenvios = "SELECT * FROM reenvios_estatus inner join usuarios on usuarios.id_usuario = reenvios_estatus.id_usuario where id_reporte = $id_reporte";
                                                    $resultReenvios = $cn->query($sqlReenvios);
                                                    ?>

                                                    <?php if ($resultReenvios->num_rows > 0) {
                                                        while ($rowCorreo = $resultReenvios->fetch_assoc()) { ?>
                                                            <ul class="list-group list-group-flush mt-2 list-group-sm">
                                                                <li class="list-group-item list-group-item-light">
                                                                    <div class="row">
                                                                        <a>
                                                                            <div class="d-flex">
                                                                                <div class="flex-shrink-0">
                                                                                    <i class="bi bi-reply-fill"></i>
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-2">
                                                                                    <span class="font-weight-bold text-dark">Reenvío por: <?php echo $rowCorreo['nombre']; ?></span>
                                                                                    <span class="d-block small text-muted">Fecha y hora:
                                                                                        <?php
                                                                                        $fechaEnvio = $rowCorreo['fecha_envio'];
                                                                                        $dateTime = new DateTime($fechaEnvio);
                                                                                        $fechaFormateada = $dateTime->format('d/m/Y g:i a');
                                                                                        echo $fechaFormateada;
                                                                                        ?>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                    <?php }
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </li>

                                    <?php } ?>

                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php }
        ?>
    </ul>
</div>

<script>
    function addFileToDropzone(filePath, fileName) {
        fetch(filePath)
            .then(response => response.blob())
            .then(blob => {
                const file = new File([blob], fileName, {
                    type: blob.type
                });
                myDropzone.addFile(file);
            })
            .catch(error => console.error('Error al cargar el archivo:', error));
    }

    function cargarDocumentos(id_reporte) {
        myDropzone.removeAllFiles(true);
        $.ajax({
            url: '../viaje/estatus/get_files.php',
            type: 'POST',
            data: {
                id_reporte: id_reporte
            },
            dataType: 'json',
            success: function(response) {

                if (Array.isArray(response) && response.length > 0) {
                    console.log('Datos recibidos correctamente:');

                    response.forEach(item => {
                        console.log('Nombre:', item.name);
                        console.log('URL:', item.url);
                        addFileToDropzone(item.url, item.name);

                        notyf.open({
                            type: 'info',
                            message: 'Imagen ligada al correo.',
                        });

                    });
                } else {
                    notyf.open({
                        type: 'info',
                        message: 'La respuesta no contiene evidencias.'
                    });
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error('Error en la solicitud:', textStatus, errorThrown);
            }
        });
    }

    function reenviarestatus(id_reporte) {
        $("#modal_envio_status").offcanvas('show');
        goToStep(2);

        $('#enviar_status').hide();
        $('#reenviar_status').show();

        $.ajax({
            url: '../viaje/estatus/estatus_operador.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'id_reporte': id_reporte
            },
            success: function(response) {
                if (response.length > 0) {
                    var data = response[0];
                    SeleccionarStatus(data.id_status, data.status);
                    idreporte = id_reporte;
                    comentarios_editor.clipboard.dangerouslyPasteHTML(data.comentarios_estatus);
                    cargarDocumentos(id_reporte);
                } else {
                    notyf.error('No se encontraron datos.');
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {}
        });
    }
</script>
<script src="../../js/fslightbox.js"></script>