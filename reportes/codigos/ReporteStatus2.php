<?php
require_once("../../mysql/conexion.php");
$conn = conectar();

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$rango = $_POST['rango'];
$array = explode(" ", $rango);
$inicio = $array[0];
$final =  $array[2];

$sql = "SELECT viajes.id, referencia, employee_id, nombre_operador, fecha_inicio, x_reference, status, fecha_envio 
        FROM viajes 
        left JOIN operadores ON operadores.id = viajes.employee_id 
        left JOIN correos ON correos.id_viaje = viajes.id 
        WHERE correos.id_ubicacion IS NULL 
        AND DATE(fecha_envio) BETWEEN '$inicio' AND '$final' 
        ORDER BY nombre_operador, referencia, fecha_envio ASC";
$resultado = $conn->query($sql);
?>

<table class="table table-sm" id="tabla-datos">
    <thead>
        <tr>
            <th>Viaje</th>
            <th>Contenedor</th>
            <th>Operador</th>
            <th>Status</th>
            <th>Fecha de envio</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['referencia'] ?></td>
                <td width="100"><?php echo $row['x_reference'] ?></td>
                <td><?php echo $row['nombre_operador'] ?></td>
                <td><?php echo $row['status'] ?></td>
                <td><?php echo $row['fecha_envio'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php
require_once('../../search/codigo2.php');
