<?php
require_once('../../mysql/conexion.php');
require_once('../../tiempo/tiempo.php');
require_once('../../google_maps/enlance/crear_enlace.php');

$cn = conectar();
$placas = $_POST['placas'];
$sqlSelect = "SELECT * FROM ubicaciones WHERE placas = '$placas' ORDER BY FECHA_HORA DESC LIMIT 1";
$result = $cn->query($sqlSelect);
$row = $result->fetch_assoc();
?>

<div class="media mb-3">
    <div class="media-body align-self-center">
        <h4 class="mt-0 mb-0 font-16">Última ubicación
        </h4>
        <p class="text-muted mb-0 font-12"><?php imprimirTiempo($row['FECHA_HORA']); ?></p>
    </div>
</div>

<ul class="list-unstyled mb-2">
    <li class=""><b>Unidad</b> <?php echo $row['PLACAS'] ?></li>
    <li class=""><b>Coordenadas: </b> <?php echo $row['LATITUD'] . ', ' . $row['LONGITUD'] ?> <a class="card-link text-primary" href="<?php echo crear_enlance($row['LATITUD'], $row['LONGITUD']) ?>" target="_blank"> Ver en Google Maps</a></li>
    <li class="mt-2"><b> Referencia: </b> <?php echo $row['REFERENCIA'] ?></li>
    <li class="mt-2"><b> Referencia de la calle donde se encuentra el vehículo: </b> <?php echo $row['CALLE'] ?></li>
    <li class="mt-2"><b> Velocidad de la unidad: </b> <?php echo $row['VELOCIDAD'] . ' Km/h' ?></li>
    <li class="mt-2"><b> Fecha y hora: </b> <?php echo $row['FECHA_HORA'] ?></li>
    <input type="hidden" id="lat" name="lat" value="<?php echo $row['LATITUD'] ?>">
    <input type="hidden" id="long" name="long" value="<?php echo $row['LONGITUD'] ?>">
    <input type="hidden" id="ref" name="ref" value="<?php echo $row['REFERENCIA'] ?>">
    <input type="hidden" id="link" name="link" value="<?php echo crear_enlance($row['LATITUD'], $row['LONGITUD']) ?>">
</ul>