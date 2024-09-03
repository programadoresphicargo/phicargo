<?php
require_once('../../mysql/conexion_inventario.php');
$cn = conectar_inventario();
$sqlSelect = "SELECT * FROM activo inner join empleado on empleado.id_empleado = activo.id_empleado inner join celular on celular.id_celular = activo.id_celular where id_departamento = 9";
$resultado = $cn->query($sqlSelect);
?>

<table class="table table-striped table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Empleado</th>
            <th scope="col">Puesto</th>
            <th scope="col">Número celular</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($row = $resultado->fetch_assoc()) { ?>

            <tr>
                <th><?php echo $row['APELLIDO_PATERNO'] . ' ' . $row['APELLIDO_MATERNO'] . ' ' . $row['NOMBRE_EMPLEADO'] ?></th>
                <th><?php echo $row['PUESTO'] ?></th>
                <th><?php echo $row['NUMERO_CELULAR'] ?></th>
            </tr>

        <?php } ?>

    </tbody>
</table>

<script>
    $('#miTabla').DataTable({
        "pageLength": 50
    });
</script>