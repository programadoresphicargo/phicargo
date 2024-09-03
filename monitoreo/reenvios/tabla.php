<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

if (isset($_POST['fecha_inicio']) || isset($_POST['fecha_fin'])) {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $sql = "select * from reportes_estatus_viajes 
    left join empleados on empleados.id = reportes_estatus_viajes.id_usuario 
    left join status on status.id_status = reportes_estatus_viajes.id_estatus
    left join reenvios_estatus on reenvios_estatus.id_reporte = reportes_estatus_viajes.id_reporte
    left join usuarios on usuarios.id_usuario = reenvios_estatus.id_usuario
    where puesto IN ('OPERADOR','OPERADOR POSTURERO','MOVEDOR')
    order by reportes_estatus_viajes.fecha_envio desc limit 100";
} else {
    $sql = "select * from reportes_estatus_viajes 
    left join empleados on empleados.id = reportes_estatus_viajes.id_usuario 
    left join status on status.id_status = reportes_estatus_viajes.id_estatus
    left join reenvios_estatus on reenvios_estatus.id_reporte = reportes_estatus_viajes.id_reporte
    left join usuarios on usuarios.id_usuario = reenvios_estatus.id_usuario
    where puesto IN ('OPERADOR','OPERADOR POSTURERO','MOVEDOR')
    order by reportes_estatus_viajes.fecha_envio desc limit 100";
}
$resultado = $cn->query($sql);
?>

<table class="table" id="tabla-datos">
    <thead>
        <tr>
            <th scope="col">Nombre operador</th>
            <th scope="col">Estatus reportado</th>
            <th scope="col">Fecha envio</th>
            <th scope="col">Reenviado</th>
            <th scope="col">Empleado</th>
            <th scope="col">Fecha reenvio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td scope="col"><?php echo $row['name'] ?></td>
                <td scope="col"><?php echo $row['status'] ?></td>
                <td scope="col"><?php echo $row['fecha_envio'] ?></td>
                <td scope="col"><?php echo $row['id_reenvio'] != null ? 'SI' : 'NO' ?></td>
                <td scope="col"><?php echo $row['nombre'] ?></td>
                <td scope="col"><?php echo $row['fecha_envio'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>