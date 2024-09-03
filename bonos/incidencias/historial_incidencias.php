<?php
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');

$cn = conectar();

$id_bono = $_POST['id_bono'];

$sql = "SELECT * FROM registro_incidencias left join usuarios on usuarios.id_usuario = registro_incidencias.id_usuario where id_bono = $id_bono order by fecha_creacion desc";
$resultado = $cn->query($sql);
?>
<!-- Step -->
<ul class="step">

    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <!-- Step Item -->
        <li class="step-item">
            <div class="step-content-wrapper">
                <div class="step-avatar">
                    <img class="step-avatar" src="../../img/usuario.png" alt="Image Description">
                </div>

                <div class="step-content">

                    <div class="step-title d-flex justify-content-between align-items-center">
                        <a class="text-dark" href="#"><?php echo $row['nombre'] ?></a>
                        <span class="text-muted d-block"><?php imprimirTiempo($row['fecha_creacion']) ?></span>
                    </div>

                    <p class="fs-5 mb-1">Añadió un comentario</p>

                    <ul class="list-group list-group-sm">
                        <!-- List Item -->
                        <li class="list-group-item list-group-item-light">
                            <div class="row gx-1">
                                <div class="col-sm-4">
                                    <!-- Media -->
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img class="avatar avatar-xs" src="../../img/coment.png" alt="Image Description">
                                        </div>
                                        <div class="flex-grow-1 ms-2">
                                            <span class="d-block small text-muted"><?php echo $row['motivo'] ?></span>
                                        </div>
                                    </div>
                                    <!-- End Media -->
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->
                        </li>
                        <!-- End List Item -->
                    </ul>
                </div>
            </div>
        </li>
        <!-- End Step Item -->
    <?php } ?>

</ul>
<!-- End Step -->