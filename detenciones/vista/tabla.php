<?php
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');

$cn = conectar();
$sqlSelect = "SELECT * from alertas inner join ubicaciones on ubicaciones.id = alertas.id_ubicacion inner join viajes on viajes.id = alertas.id_viaje where evento like '%detenido%'";
$resultado = $cn->query($sqlSelect);
?>
<table class="table" id="tabla-datos">
    <thead>
        <tr>
            <th scope="col">Referencia de viaje</th>
            <th scope="col">Operador</th>
            <th scope="col">Unidad</th>
            <th scope="col">Placas</th>
            <th scope="col">Evento</th>
            <th scope="col"></th>
            <th scope="col">Fecha</th>
            <th scope="col">Latitud</th>
            <th scope="col">Longitud</th>
            <th scope="col">Referencia</th>
            <th scope="col">Calle</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <th><?php echo $row['placas'] ?></th>
                <th><?php echo $row['evento'] ?></th>
                <th><?php echo $row['nombre'] ?></th>
                <th><?php echo $row['descripcion'] ?></th>
                <td><?php echo $row['evento'] ?></td>
                <td>
                    <?php
                    $pattern = '/\((\d+)\)/';
                    preg_match('/\d+/', $row['evento'], $matches);
                    echo $numero = $matches[0];
                    ?>
                </td>
                <td><?php echo $row['fecha'] ?></td>
                <td><?php echo $row['latitud'] ?></td>
                <td><?php echo $row['longitud'] ?></td>
                <td><?php echo $row['referencia'] ?></td>
                <td><?php echo $row['calle'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require_once('../../busqueda/agrupar.php');
