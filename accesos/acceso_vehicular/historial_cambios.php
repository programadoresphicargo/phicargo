<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id = $_POST['id'];
$SQL = "SELECT 
    u_creacion.nombre AS nombre_creacion,
    u_valido.nombre AS nombre_valido,
    u_salida.nombre AS nombre_salida,
    fecha_creacion,
    fecha_validacion,
    fecha_salida
FROM 
acceso_vehicular a
left JOIN 
usuarios u_creacion ON a.usuario_creacion = u_creacion.id_usuario
left JOIN 
usuarios u_valido ON a.usuario_valido = u_valido.id_usuario
left JOIN 
usuarios u_salida ON a.usuario_salida = u_salida.id_usuario
WHERE 
a.id_acceso = $id;";
$resultado = $cn->query($SQL);
?>
<!-- Step -->
<ul class="step step-icon-xs mb-0">

    <!-- Step Item -->
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <li class="step-item">
            <div class="step-content-wrapper">
                <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                <div class="step-content">
                    <h5 class="step-title">
                        <a class="text-dark" href="#">Creado por:</a>
                    </h5>

                    <p class="fs-5 mb-1"><?php echo $row['nombre_creacion'] ?></p>

                    <span class="text-muted small text-uppercase"><?php echo $row['fecha_creacion'] ?></span>
                </div>
            </div>
        </li>

        <li class="step-item">
            <div class="step-content-wrapper">
                <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                <div class="step-content">
                    <h5 class="step-title">
                        <a class="text-dark" href="#">Validado por:</a>
                    </h5>

                    <p class="fs-5 mb-1"><?php echo $row['nombre_valido'] ?></p>

                    <span class="text-muted small text-uppercase"><?php echo $row['fecha_validacion'] ?></span>
                </div>
            </div>
        </li>

        <li class="step-item">
            <div class="step-content-wrapper">
                <span class="step-icon step-icon-pseudo step-icon-soft-dark"></span>

                <div class="step-content">
                    <h5 class="step-title">
                        <a class="text-dark" href="#">Salida por:</a>
                    </h5>

                    <p class="fs-5 mb-1"><?php echo $row['nombre_salida'] ?></p>

                    <span class="text-muted small text-uppercase"><?php echo $row['fecha_salida'] ?></span>
                </div>
            </div>
        </li>
    <?php } ?>
    <!-- End Step Item -->
</ul>