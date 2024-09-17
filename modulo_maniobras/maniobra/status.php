<?php
require_once('../../includes2/head2.php');
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');
?>
<button class="btn btn-primary btn-sm">Holi</button>

<select name="cars" id="cars">
    <option value="volvo">Volvo</option>
    <option value="saab">Saab</option>
    <option value="mercedes">Mercedes</option>
    <option value="audi">Audi</option>
</select>

<?php
$cn = conectar();
$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

$SqlS = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = '$tipo' order by fecha_inicio desc";
$resultadoS = $cn->query($SqlS);
$rowS = $resultadoS->fetch_assoc();
if ($resultadoS->num_rows != 0) {
    $id = $rowS['id'];
    $SqlSelect = "SELECT status.status, ubicaciones.latitud as lat_ubi, ubicaciones.longitud as long_ubi, referencia, ubicaciones.calle as calle_ubi, ubicaciones.referencia as referencia_ubi, fecha_hora, id_gps, status_maniobras.fecha_envio as fecha_ubi, ubicaciones_maniobras.latitud as lat_sm, ubicaciones_maniobras.longitud as long_sm, ubicaciones_maniobras.calle as calle_sm, ubicaciones_maniobras.fecha as fecha_sm, localidad, sublocalidad, nombre_operador, nombre, status_maniobras.comentarios FROM status_maniobras LEFT JOIN status on status.id_status = status_maniobras.id_status LEFT JOIN ubicaciones on ubicaciones.id = status_maniobras.id_gps LEFT JOIN ubicaciones_maniobras on ubicaciones_maniobras.id_ubicacion = status_maniobras.id_ubicacion_operador LEFT JOIN operadores on operadores.id = ubicaciones_maniobras.id_operador LEFT JOIN usuarios on usuarios.id_usuario = status_maniobras.id_usuario LEFT JOIN maniobras on maniobras.id = status_maniobras.id_maniobra  where id_maniobra = $id order by fecha_envio desc";
    $resultado = $cn->query($SqlSelect);
    while ($row = $resultado->fetch_assoc()) {
?>
        <ul class="step step-icon-xs mb-0">

            <?php if ($row['id_gps'] != NULL) { ?>
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon bi bi-geo-alt-fill bg-morado text-white"></span>

                        <div class="step-content">

                            <div class="step-title d-flex justify-content-between align-items-center">
                                <a class="text-dark" href="#">Actualización de status</a>
                                <span class="text-muted d-block"><?php echo imprimirTiempo($row['fecha_ubi']) ?></span>
                            </div>

                            <?php if ($row['nombre'] != '' || $row['nombre'] != 0) { ?>

                                <div class="d-flex">
                                    <span class="flex-shrink-0">
                                        <img class="avatar avatar-xs" src="../../img/monitorista.png" alt="Image Description">
                                    </span>
                                    <div class="flex-grow-1 text-truncate ms-2">
                                        <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">Enviado por</span>
                                        <span class="d-block small text-muted"><?php echo $row['nombre'] ?></span>
                                    </div>
                                </div>

                                <p class="fs-5 mb-3">Status <span class="badge bg-morado text-white rounded-pill"><span class="legend-indicator bg-white"></span><?php echo $row['status'] ?></span></p>
                            <?php }  ?>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-light">
                                    <div class="row">
                                        <div class="col-10">
                                            <span class="d-block fs-5 text-dark text-truncate">Fecha y Hora: <span class="text-muted"><?php echo $row['fecha_hora'] ?></span></span>
                                            <span class="d-block fs-5 text-dark text-truncate">Coordenadas: <span class="text-muted"><?php echo $row['lat_ubi'] . ', ' . $row['long_ubi'] ?></span></span>
                                            <span class="d-block fs-5 text-dark">Referencia: <span class="text-muted"><?php echo $row['referencia_ubi'] ?></span></span>
                                            <span class="d-block fs-5 text-dark">Calle: <span class="text-muted"><?php echo $row['calle_ubi'] ?></span></span>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <?php if ($row['comentarios'] != null) { ?>

                                <!-- List Group -->
                                <ul class="list-group list-group-flush navbar-card-list-group">

                                    <!-- Item -->
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                        <img class="avatar-img" src="../../img/monitorista.png" alt="Image Description">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Col -->

                                            <div class="col ms-n2">
                                                <h5 class="mb-1">Añadio un comentario:</h5>
                                                <p class="text-body fs-5"><?php echo $row['comentarios'] ?></p>
                                            </div>
                                            <!-- End Col -->

                                            <small class="col-auto text-muted text-cap"><?php imprimirTiempo($row['fecha_ubi']) ?></small>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </li>
                                    <!-- End Item -->
                                </ul>
                                <!-- End List Group -->
                            <?php } ?>

                        </div>
                    </div>
                </li>
            <?php } else { ?>
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon bi bi-geo-alt-fill step-icon-success"></span>

                        <div class="step-content">

                            <div class="step-title d-flex justify-content-between align-items-center">
                                <a class="text-dark" href="#">Actualización de status</a>
                                <span class="text-muted d-block"><?php imprimirTiempo($row['fecha_sm']) ?></span>
                            </div>

                            <div class="d-flex">
                                <span class="flex-shrink-0">
                                    <img class="avatar avatar-xs" src="../../img/operador.png" alt="Image Description">
                                </span>
                                <div class="flex-grow-1 text-truncate ms-2">
                                    <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">Enviado por</span>
                                    <span class="d-block small text-muted"><?php echo ucwords(strtolower($row['nombre_operador'])) ?></span>
                                </div>
                            </div>

                            <p class="fs-5 mb-3">Status <span class="badge bg-success text-white rounded-pill"><span class="legend-indicator bg-white"></span><?php echo $row['status'] ?></span></p>

                            <ul class="list-group list-group-flush">
                                <li class="list-group-item list-group-item-light">
                                    <div class="row">
                                        <div class="col-10">
                                            <span class="d-block fs-5 text-dark text-truncate">Fecha y Hora: <span class="text-muted"><?php echo $row['fecha_sm'] ?></span></span>
                                            <span class="d-block fs-5 text-dark text-truncate">Coordenadas: <span class="text-muted"><?php echo $row['lat_sm'] . ', ' . $row['long_sm'] ?></span></span>
                                            <span class="d-block fs-5 text-dark">Calle: <span class="text-muted"><?php echo $row['calle_sm'] ?></span></span>
                                            <span class="d-block fs-5 text-dark">Localidad: <span class="text-muted"><?php echo $row['localidad'] ?></span></span>
                                            <span class="d-block fs-5 text-dark">Sublocalidad: <span class="text-muted"><?php echo $row['sublocalidad'] ?></span></span>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <?php if ($row['comentarios'] != null) { ?>

                                <!-- List Group -->
                                <ul class="list-group list-group-flush navbar-card-list-group">

                                    <!-- Item -->
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar avatar-sm avatar-soft-dark avatar-circle">
                                                        <img class="avatar-img" src="../../img/operador.png" alt="Image Description">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Col -->

                                            <div class="col ms-n2">
                                                <h5 class="mb-1">El operador añadio un comentario:</h5>
                                                <p class="text-body fs-5"><?php echo $row['comentarios'] ?></p>
                                            </div>
                                            <!-- End Col -->

                                            <small class="col-auto text-muted text-cap"><?php imprimirTiempo($row['fecha_sm']) ?></small>
                                            <!-- End Col -->
                                        </div>
                                        <!-- End Row -->
                                    </li>
                                    <!-- End Item -->
                                </ul>
                                <!-- End List Group -->
                            <?php } ?>

                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
<?php
    }
}
?>