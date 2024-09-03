<?php
require_once("../../mysql/conexion.php");
$cn = conectar();

//$operadores = $_POST['operadorescola'];
$rango = $_POST['rangocola'];
$array = explode(" ", $rango);
$inicio = $array[0];
$final =  $array[2];
$sqlSelect = "SELECT id_operador, nombre_operador, COUNT(*) AS cola FROM cola_respaldo INNER JOIN operadores on operadores.id = cola_respaldo.id_operador where date(fecha_envio) BETWEEN '$inicio' AND '$final' GROUP BY id_operador order by fecha_envio asc ";
$sqlSelect;
$result = $cn->query($sqlSelect);
?>

<table class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID Operador</th>
            <th scope="col">Nombre operador</th>
            <th scope="col"># De Veces en cola</th>
            <th scope="col">Historial</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <th><?php echo $row['id_operador'] ?></th>
                <th><?php echo $row['nombre_operador'] ?></th>
                <th><?php echo $row['cola'] ?></th>
                <th>
                    <?php
                    $id_operador = $row['id_operador'];
                    $sqlSelect2 = "SELECT fecha_envio from cola_respaldo where id_operador = $id_operador and date(fecha_envio) BETWEEN '$inicio' AND '$final' order by fecha_envio asc";
                    $resultado = $cn->query($sqlSelect2);
                    ?>
                    <table>
                        <?php while ($row2 = $resultado->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row2['fecha_envio'] ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </th>
            </tr>
        <?php } ?>

    </tbody>
</table>