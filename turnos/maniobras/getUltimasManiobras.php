<?php
require_once('../../postgresql/conexion.php');

$cn = conectarPostgresql();
$operador_id = $_POST['operador_id'];
if ($cn) {
    try {
        $sql = "SELECT * FROM maniobras inner join fleet_vehicle on fleet_vehicle.id = maniobras.vehicle_id where operador_id = $operador_id order by inicio_programado desc";
        $stmt = $cn->prepare($sql);
        $stmt->execute();
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>

<h1 class="mb-5">Últimas maniobras del operador</h1>

<ul class="step step-icon-xs mb-0">

    <?php foreach ($resultados as $fila) { ?>

        <li class="step-item">
            <div class="step-content-wrapper">
                <span class="step-icon step-icon-pseudo step-icon-soft-primary"></span>

                <div class="step-content">
                    <h5 class="step-title">
                        Maniobra M-<?php echo $fila['id_maniobra'] ?>
                    </h5>

                    <p class="fs-5 mb-1">Inicio programado:
                        <?php
                        $inicioProgramado = $fila['inicio_programado'];
                        $date = new DateTime($inicioProgramado);
                        echo $fechaFormateada = $date->format('Y/m/d h:i a');
                        ?>
                    </p>

                    <ul class="list-group">
                        <li class="list-group-item list-group-item-light">
                            <div class="row gx-1">
                                <div class="col-12">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 text-truncate ms-2">
                                            <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">Tipo de maniobra: <?php echo $fila['tipo_maniobra'] ?></span>
                                            <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">Terminal: <?php echo $fila['terminal'] ?></span>
                                            <span class="d-block fs-6 text-dark text-truncate" title="weekly-reports.xls">Vehiculo: <?php echo $fila['name2'] ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </li>

    <?php } ?>

</ul>