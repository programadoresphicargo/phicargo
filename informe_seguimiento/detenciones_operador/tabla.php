<?php

require_once('../../mysql/conexion.php');
require_once('../../viajes/alertas/canvas/procesar_fechas.php');
require_once('metodos.php');
$cn = conectar();

$opcion = $_POST['opcion'];
$fecha_inicio = $_POST['fechaInicio'];
$fecha_fin = $_POST['fechaFin'];

$supertotal1 = 0;
$supertotal2 = 0;
$supertotal3 = 0;

$sqlSel = "SELECT * FROM viajes inner join operadores on viajes.employee_id = operadores.id where date(fecha_inicio) between '$fecha_inicio' and '$fecha_fin' group by employee_id order by operadores.id asc";
$resultSel = $cn->query($sqlSel);
?>

<div class="accordion" id="accordionExample">
    <?php while ($rowSel = $resultSel->fetch_assoc()) { ?>
        <div class="accordion-item">
            <div class="accordion-header" id="headingOne">
                <a class="accordion-button" role="button" data-bs-toggle="collapse" data-bs-target="#<?php echo $rowSel['employee_id']; ?>" aria-expanded="true" aria-controls="<?php echo $rowSel['employee_id']; ?>">
                    <?php echo $rowSel['employee_id'] . ' - ' . $rowSel['nombre_operador']; ?>
                </a>
            </div>
            <div id="<?php echo $rowSel['employee_id']; ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body">

                    <?php
                    $placas = $rowSel['placas'];
                    $sqlSelect = "SELECT * FROM viajes where placas = '$placas' and date(fecha_inicio) between '$fecha_inicio' and '$fecha_fin' order by fecha_inicio asc";
                    $resultado = $cn->query($sqlSelect);
                    ?>

                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Referencia de viaje</th>
                                <th scope="col">Placas</th>
                                <th scope="col">Salida de patio</th>
                                <th scope="col">Llegada con cliente</th>
                                <th scope="col">Salida del cliente</th>
                                <th scope="col">Finalización</th>
                                <th scope="col">Detenido Patio -> Planta</th>
                                <th scope="col">Detenido Planta -> Salida Planta</th>
                                <th scope="col">Detenido Salida Planta -> Patio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($row = $resultado->fetch_assoc()) {
                                $id = $row['id'];
                                $sql = "SELECT * FROM correos WHERE id_viaje = $id order by fecha_envio asc";
                                $result = $cn->query($sql);

                                $inicioViajeFecha = null;
                                $llegadaPlantaFecha = null;
                                $salidaPlantaFecha = null;
                                $finViajeFecha = null;

                                procesarFechas($inicioViajeFecha, $llegadaPlantaFecha, $salidaPlantaFecha, $finViajeFecha, $result); ?>
                                <tr>
                                    <th><?php echo $row['referencia'] ?></th>
                                    <th><?php echo $row['placas'] ?></th>
                                    <th><?php echo $inicioViajeFecha ?></th>
                                    <th><?php echo $llegadaPlantaFecha ?></th>
                                    <th><?php echo $salidaPlantaFecha ?></th>
                                    <th><?php echo $finViajeFecha ?></th>
                                    <th><?php echo $total1 = Imprimir_Tiempo($row['placas'], $inicioViajeFecha, $llegadaPlantaFecha) ?></th>
                                    <th><?php echo $total2 = Imprimir_Tiempo($row['placas'], $llegadaPlantaFecha, $salidaPlantaFecha) ?></th>
                                    <th><?php echo $total3 =  Imprimir_Tiempo($row['placas'], $salidaPlantaFecha, $finViajeFecha) ?></th>
                                    <?php
                                    $supertotal1 = $supertotal1 + $total1;
                                    $supertotal2 = $supertotal2 + $total2;
                                    $supertotal3 = $supertotal3 + $total3;
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Totales</td>
                                <td><?php echo $supertotal1; ?></td>
                                <td><?php echo $supertotal2; ?></td>
                                <td><?php echo $supertotal3; ?></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    <?php } ?>
</div>