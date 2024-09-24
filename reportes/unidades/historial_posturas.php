<?php
require_once('../../mysql/conexion.php');
require_once('../../odoo/odoo-conexion.php');
$cn = conectar();

$id_vehiculo = $_GET['id_vehiculo'];
$sql = "SELECT * FROM posturas left join flota on flota.vehicle_id = posturas.id_vehiculo left join operadores on operadores.id = posturas.id_operador where vehicle_id = $id_vehiculo order by fecha_asignacion desc";
$resultado = $cn->query($sql);
?>

<table class="table table-sm table-striped" id="tabla-datos">
    <thead>
        <tr>
            <th scope="col">Unidad</th>
            <th scope="col">Operador</th>
            <th scope="col">Fecha</th>
            <th scope="col">Motivo</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td scope="col"><?php echo $row['name']  ?></td>
                <td scope="col"><?php echo $row['nombre_operador'] ?></td>
                <td scope="col"><?php echo $row['fecha_asignacion'] ?></td>
                <td scope="col"><?php echo $row['motivo'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>