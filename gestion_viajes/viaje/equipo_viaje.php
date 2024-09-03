<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id = $_POST['id_viaje'];
$sql = "SELECT x_reference, x_reference_2, flota1.vehicle_id AS remolque1_id, flota1.name AS remolque1_info, flota2.vehicle_id AS remolque2_id, flota2.name AS remolque2_info, flota3.vehicle_id AS dolly_id, flota3.name AS dolly_info FROM viajes LEFT JOIN flota AS flota1 ON viajes.remolque1 = flota1.vehicle_id LEFT JOIN flota AS flota2 ON viajes.remolque2 = flota2.vehicle_id LEFT JOIN flota AS flota3 ON viajes.dolly = flota3.vehicle_id where id = $id";
$resultado = $cn->query($sql);
$row = $resultado->fetch_assoc();

$remolque1_id = $row['remolque1_id'];
$remolque1 = $row['remolque1_info'];

$remolque2_id = $row['remolque2_id'];
$remolque2 = $row['remolque2_info'];

$dolly_id = $row['dolly_id'];
$dolly = $row['dolly_info'];

$contenedor1 = $row['x_reference'];
$contenedor2 = $row['x_reference_2'];
?>

<div class="card-body p-0 m-0">
    <div class="list-group list-group-flush list-group-no-gutters">

        <?php if ($row['remolque1_info'] != '') { ?>
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col">
                        <span class="card-title">Remolque 1:</span>
                    </div>
                    <div class="col-auto">
                        <a class="badge bg-soft-primary text-primary p-2" href="#"><?php echo $remolque1 ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($row['remolque2_info'] != '') { ?>
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col">
                        <span class="card-title">Remolque 2:</span>
                    </div>
                    <div class="col-auto">
                        <a class="badge bg-soft-primary text-primary p-2" href="#"><?php echo $remolque2 ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($row['dolly_info'] != '') { ?>
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col">
                        <span class="card-title">Dolly:</span>
                    </div>
                    <div class="col-auto">
                        <a class="badge bg-soft-primary text-primary p-2" href="#"><?php echo $dolly ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($row['x_reference'] != '') { ?>
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col">
                        <span class="card-title">Contenedor 1:</span>
                    </div>
                    <div class="col-auto">
                        <a class="badge bg-soft-primary text-primary p-2" href="#"><?php echo $contenedor1 ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if ($row['x_reference_2'] != '') { ?>
            <div class="list-group-item">
                <div class="row align-items-center">
                    <div class="col">
                        <span class="card-title">Contenedor 2:</span>
                    </div>
                    <div class="col-auto">
                        <a class="badge bg-soft-primary text-primary p-2" href="#"><?php echo $contenedor2 ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>