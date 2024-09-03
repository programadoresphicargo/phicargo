<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_nomina = $_POST['id_nomina'];
$sql = "SELECT * FROM maniobras_nomina where id_nomina = $id_nomina";
$resultado = $cn->query($sql);
$total = 0;
?>

<table class="table table-sm table-striped table-hover" id="tablamaniobras">
    <thead class="thead-light">
        <tr class="text-center">
            <th>ID Maniobra</th>
            <th>Pagado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr onclick="Abrir_nomina('<?php echo $row['id_nomina']; ?>')">
                <td>
                    <?php echo $row['id_maniobra']; ?>
                </td>
                <td>
                    <?php
                    echo number_format($row['precio_pagado'], 2, '.', ',');
                    $total += $row['precio_pagado'];
                    ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td> <?php echo number_format($total, 2, '.', ','); ?></td>
        </tr>
    </tfoot>
</table>

<script>
    $('#tablamaniobras').DataTable();
</script>