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
rv.id_estatus IN (3, 4, 5, 6,7,8) 
and
v.fecha_inicio BETWEEN '$fecha_inicio' and '$fecha_fin'
GROUP BY
rv.id_viaje,
rv.id_usuario
ORDER BY v.fecha_inicio DESC";

$resultado = $cn->query($sql);
?>

<table class="table" id="tabla-datos">
    <thead>
        <tr>
            <th scope="col">Referencia viaje</th>
            <th scope="col">Nombre operador</th>
            <th scope="col">Fecha inicio</th>
            <th scope="col">Estatus enviados</th>
            <th scope="col">Numero de estatus enviados</th>
            <th scope="col">Porcentajed de cumplimiento</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td scope="col"><?php echo $row['referencia'] ?></td>
                <td scope="col"><?php echo $row['name'] ?></td>
                <td scope="col"><?php echo $row['fecha_inicio'] ?></td>
                <td scope="col"><?php echo $row['estatus_enviados'] ?></td>
                <td scope="col"><?php echo $row['porcentaje_estatus'] ?></td>
                <td scope="col"><?php echo $row['estatus_encontrados'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla-datos').DataTable({
            // Configuration options
            paging: true,
            searching: true,
            info: true,
            responsive: true,
            // Add any additional configuration you need here
        });
    });
</script>
<?php
require_once('../../search/codigo2.php');
