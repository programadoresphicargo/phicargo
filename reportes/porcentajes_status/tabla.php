<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];

$sql = "SELECT
v.referencia,
v.fecha_inicio,
rv.id_viaje,
rv.id_usuario,
e.name,
COUNT(DISTINCT rv.id_estatus) AS estatus_enviados,
(COUNT(DISTINCT rv.id_estatus) / 6.0) * 100 AS porcentaje_estatus,
GROUP_CONCAT(DISTINCT s.status ORDER BY s.status SEPARATOR ', ') AS estatus_encontrados
FROM
reportes_estatus_viajes rv
INNER JOIN
status s ON s.id_status = rv.id_estatus
INNER JOIN
viajes v ON v.id = rv.id_viaje
INNER JOIN
empleados e ON e.id = rv.id_usuario
WHERE
rv.id_estatus IN (3, 4, 5, 6,7, 8) 
and
v.fecha_inicio BETWEEN '$fecha_inicio' and '$fecha_fin'
GROUP BY
rv.id_viaje,
rv.id_usuario
ORDER BY rv.id_estatus, v.fecha_inicio DESC";

$resultado = $cn->query($sql);
?>

<table class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table" id="tabla-datos">
    <thead class="thead-light">
        <tr>
            <th>Viaje</th>
            <th>Operador</th>
            <th>Fecha inicio de viaje</th>
            <th>Estatus enviados</th>
            <th>Número de estatus enviados</th>
            <th style="width: 5px;">Porcentaje de cumplimiento</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['referencia'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['fecha_inicio'] ?></td>
                <td><?php echo $row['estatus_enviados'] ?></td>
                <td><?php echo $row['porcentaje_estatus'] ?></td>
                <td style="width: 5px;"><?php echo $row['estatus_encontrados'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla-datos').DataTable({
            paging: false,
            searching: true,
        });
    });
</script>
<?php
require_once('../../search/codigo2.php');
