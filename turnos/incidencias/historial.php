<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_operador = $_POST['id_operador'];

$sql = "SELECT *
FROM incidencias
left join operadores on operadores.id = incidencias.id_operador
left join usuarios on usuarios.id_usuario = incidencias.id_usuario
where id_operador = $id_operador
ORDER BY fecha_registro DESC";
$resultado = $cn->query($sql);
?>

<ul class="step step-icon-sm step-avatar-sm">
    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <li class="step-item">
            <div class="step-content-wrapper">
                <span class="step-icon step-icon-soft-danger">I</span>
                <div class="step-content">
                    <h5 class="mb-1"><?php echo $row['nombre'] ?></h5>
                    <p class="fs-5 mb-1"><?php echo $row['tipo_incidencia'] ?></p>
                    <p class="fs-5 mb-1"><?php echo $row['comentarios'] ?></p>
                    <span class="small text-muted text-uppercase"><?php echo $row['fecha_registro'] ?></span>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>