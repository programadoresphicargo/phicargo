<?php

require_once('../../mysql/conexion.php');
$cn = conectar();

$opcion = $_POST['opcion'];
$fecha_inicio = $_POST['fechaInicio'];
$fecha_fin = $_POST['fechaFin'];

$sqlSel = "SELECT * FROM viajes 
inner join unidades on viajes.placas = unidades.placas 
inner join empleados on empleados.id = viajes.employee_id
where date(fecha_inicio) 
between '$fecha_inicio' and '$fecha_fin' 
group by $opcion order by unidades.unidad asc";
$resultSel = $cn->query($sqlSel);
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">Unidad</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultSel->fetch_assoc()) { ?>
            <tr onclick="abrir_detenciones('<?php echo $row['placas'] ?>', '<?php echo $fecha_inicio ?>', '<?php echo $fecha_fin ?>')">
                <?php if ($opcion == 'employee_id') { ?>
                    <td><?php echo htmlspecialchars('(' . $row['employee_id'] . ') ' . $row['name']); ?></td>
                <?php } else { ?>
                    <td><?php echo htmlspecialchars('(' . $row['unidad'] . ') ' . $row['placas']); ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function abrir_detenciones(placas, fecha_inicio, fecha_fin) {
        $("#modal_detenciones").modal('show');
        $.ajax({
            url: 'detenciones.php',
            method: 'POST',
            data: {
                'placas': placas,
                'fecha_inicio': fecha_inicio,
                'fecha_fin': fecha_fin,
            },
            success: function(response) {
                $('#registrosdetencionesunidad').html(response);
            },
            error: function() {}
        });
    }
</script>