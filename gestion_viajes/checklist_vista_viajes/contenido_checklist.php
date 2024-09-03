<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$sql = "SELECT * FROM checklist_flota where id_viaje = $id_viaje";
$resultado = $cn->query($sql);
?>

<div class="container">
    <div class="row">
        <div class="accordion accordion-flush">

            <?php
            while ($row = $resultado->fetch_assoc()) {
                $id = $row['id'];
                $sql2 = "SELECT * FROM revisiones_elementos_flota inner join elementos_checklist on elementos_checklist.id_elemento = revisiones_elementos_flota.elemento_id inner join checklist_flota on checklist_flota.id = revisiones_elementos_flota.checklist_id inner join flota on flota.vehicle_id = checklist_flota.id_flota where checklist_id = $id";
                $resultado2 = $cn->query($sql2);
                $row2 = $resultado2->fetch_assoc();
                if (isset($row2['id_flota'])) {
            ?>

                    <div class="col-12">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $row2['name'] ?>" aria-expanded="false" aria-controls="<?php echo $row2['name'] ?>">
                                    <?php echo $row2['name'] ?>
                                </button>
                            </h2>

                            <div id="<?php echo $row2['name'] ?>" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                    <table class="table table-sm table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Elemento</th>
                                                <th class="text-center">Estado salida</th>
                                                <th class="text-center">Observación salida</th>
                                                <th class="text-center">Evidencia</th>
                                                <th class="text-center">Estado entrada</th>
                                                <th class="text-center">Observación entrada</th>
                                                <th class="text-center">Evidencia</th>
                                                <th class="text-center">Fecha registro salida</th>
                                                <th class="text-center">Fecha registro entrada</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php while ($row2 = $resultado2->fetch_assoc()) { ?>

                                                <tr>
                                                    <td class="text-center"><?php echo $row2['nombre_elemento'] ?></td>

                                                    <td class="text-center">
                                                        <?php if ($row2['estado_salida'] == true) { ?>
                                                            <i class="bi bi-check2"></i>
                                                        <?php  } else if ($row2['estado_salida'] == false) { ?>
                                                            <i class="bi bi-x"></i>
                                                        <?php } ?>
                                                    </td>

                                                    <td class="text-center"><?php echo $row2['observacion_entrada'] ?></td>

                                                    <td class="text-center"><button class="btn btn-soft-primary btn-xs"><i class="bi bi-image-fill"></i></button></td>

                                                    <td class="text-center">
                                                        <?php if ($row2['estado_entrada'] == true) { ?>
                                                            <i class="bi bi-check2"></i>
                                                        <?php  } else if ($row2['estado_entrada'] == false) { ?>
                                                            <i class="bi bi-x"></i>
                                                        <?php } ?>
                                                    </td>

                                                    <td class="text-center"><?php echo $row2['observacion_entrada'] ?></td>

                                                    <td class="text-center"><button class="btn btn-soft-primary btn-xs"><i class="bi bi-image-fill"></i></button></td>

                                                    <td class="text-center"><?php echo $row2['fecha_salida'] ?></td>
                                                    <td class="text-center"><?php echo $row2['fecha_entrada'] ?></td>

                                                </tr>

                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                <?php }
            } ?>
                    </div>
        </div>
    </div>

    <?php
    $sqlContenedor = "SELECT * FROM checklist_contenedor where id_viaje = $id_viaje";
    $resultadoContenedor = $cn->query($sqlContenedor);
    ?>

    <div class="row">
        <div class="accordion accordion-flush">

            <?php
            while ($rowContenedor = $resultadoContenedor->fetch_assoc()) {
                $checklist_id = $rowContenedor['checklist_id'];
                $sqlRevisiones = "SELECT * FROM revisiones_elementos_contenedor inner join elementos_checklist on elementos_checklist.id_elemento = revisiones_elementos_contenedor.elemento_id inner join checklist_contenedor on checklist_contenedor.checklist_id = revisiones_elementos_contenedor.checklist_id where checklist_contenedor.checklist_id = $checklist_id";
                $resultadoRevisiones = $cn->query($sqlRevisiones);
                $rowRevisiones = $resultadoRevisiones->fetch_assoc();
            ?>

                <div class="col-12">

                    <div class="accordion-item">
                        <div class="accordion-header" id="headingOne">
                            <a class="accordion-button" role="button" data-bs-toggle="collapse" data-bs-target="#checklist<?php echo $rowRevisiones['checklist_id'] ?>" aria-expanded="true" aria-controls="collapseOne">
                                <?php echo $rowRevisiones['contenedor_id'] ?>
                            </a>
                        </div>

                        <div id="checklist<?php echo $rowRevisiones['checklist_id'] ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table table-sm table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Elemento</th>
                                            <th class="text-center">Estado salida</th>
                                            <th class="text-center">Observación salida</th>
                                            <th class="text-center">Evidencia</th>
                                            <th class="text-center">Estado entrada</th>
                                            <th class="text-center">Observación entrada</th>
                                            <th class="text-center">Evidencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php while ($rowRevisiones = $resultadoRevisiones->fetch_assoc()) { ?>

                                            <tr>
                                                <td class="text-center"><?php echo $rowRevisiones['nombre_elemento'] ?></td>

                                                <td class="text-center">
                                                    <?php if ($rowRevisiones['estado_salida'] == true) { ?>
                                                        <i class="bi bi-check2"></i>
                                                    <?php  } else if ($rowRevisiones['estado_salida'] == false) { ?>
                                                        <i class="bi bi-x"></i>
                                                    <?php } ?>
                                                </td>

                                                <td class="text-center"><?php echo $rowRevisiones['observacion_entrada'] ?></td>

                                                <td class="text-center"><button class="btn btn-soft-primary btn-xs"><i class="bi bi-image-fill"></i></button></td>

                                                <td class="text-center">
                                                    <?php if ($rowRevisiones['estado_entrada'] == true) { ?>
                                                        <i class="bi bi-check2"></i>
                                                    <?php  } else if ($rowRevisiones['estado_entrada'] == false) { ?>
                                                        <i class="bi bi-x"></i>
                                                    <?php } ?>
                                                </td>

                                                <td class="text-center"><?php echo $rowRevisiones['observacion_entrada'] ?></td>

                                                <td class="text-center"><button class="btn btn-soft-primary btn-xs"><i class="bi bi-image-fill"></i></button></td>

                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                <?php
            } ?>
                </div>
        </div>
    </div>

</div>