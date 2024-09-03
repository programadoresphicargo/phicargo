<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$sql = "SELECT * FROM incidencias INNER JOIN usuarios ON usuarios.id_usuario = incidencias.id_usuario WHERE id_viaje = $id_viaje ORDER BY fecha_registro DESC";
$resultado = $cn->query($sql);
?>
<ul class="list-group">
    <?php
    if ($resultado->num_rows > 0) {
        while ($row = $resultado->fetch_assoc()) { ?>
            <li class="list-group-item">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img class="avatar avatar-xs avatar-4x3" src="../../img/alert.png" alt="Image Description">
                    </div>

                    <div class="col">
                        <h5 class="mb-0">
                            <a class="text-dark"><?php echo $row['tipo_incidencia'] ?></a>
                        </h5>
                        <ul class="list-inline list-separator small text-body">
                            <li class="list-inline-item"><?php echo $row['comentarios'] ?></li>
                        </ul>
                        <ul class="list-inline list-separator small text-body">
                            <li class="list-inline-item"><?php echo $row['nombre'] ?></li>
                            <li class="list-inline-item"><?php echo $row['fecha_registro'] ?></li>
                        </ul>
                    </div>
                </div>
            </li>
        <?php }
    } else { ?>
        <li class="list-group-item">
            <div class="alert alert-warning" role="alert">
                No se encontraron incidencias para este viaje.
            </div>
        </li>
    <?php } ?>
</ul>