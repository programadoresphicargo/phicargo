<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$fecha = $_POST['fecha'];
$sql = "SELECT * FROM tankcontainer where fecha = '$fecha'";
$resultado = $cn->query($sql);
?>

<h1 class="p-2">Tank Container</h1>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Tanques lavados</th>
            <th scope="col">Tanques rechazados</th>
            <th scope="col">Tanques en patio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <th><?php echo $row['tanques_lavados'] ?></th>
                <th><?php echo $row['tanques_rechazados'] ?></th>
                <th><?php echo $row['tanques_patio'] ?></th>
            </tr>
        <?php } ?>
    </tbody>
</table>