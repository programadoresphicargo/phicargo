<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT PLACAS, UNIDAD, ESTADO, BASE, SALIDA, REGRESO FROM unidades";
$result = $cn->query($sqlSelect);

?>
<thead>
    <tr>
        <th>Placas</th>
        <th>Unidad</th>
        <th>Estado</th>
        <th>Base</th>
        <th>Salida</th>
        <th>Entrada</th>
    </tr>
</thead>
<tbody>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['PLACAS'] ?></td>
            <td><?php echo $row['UNIDAD'] ?></td>
            <td><?php echo $row['ESTADO'] ?></td>
            <td><?php echo $row['BASE'] ?></td>
            <td><?php echo $row['SALIDA'] ?></td>
            <td><?php echo $row['REGRESO'] ?></td>
        </tr>
    <?php } ?>
</tbody>