<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$fechaInicio = $_POST['fechaInicio'];
$fechaFin = $_POST['fechaFin'];

$sqlSelect = "SELECT *, 
viajes.id as id_viaje,
estatus_llegada.fecha_envio AS fecha1, 
estatus_salida.fecha_envio AS fecha2,
TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio) AS diferencia,
CASE 
    WHEN viajes.partner_id IN (107800, 112577) THEN
        CASE 
            WHEN TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio) > '24:00:00' THEN (TIMEDIFF(TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio),('24:00:00')))
            ELSE 'NO'
        END
    WHEN viajes.partner_id = 108015 THEN
        CASE 
            WHEN TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio) > '12:00:00' THEN (TIMEDIFF(TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio),('12:00:00')))
            ELSE 'NO'
        END
    ELSE
        CASE 
            WHEN TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio) > '08:00:00' THEN (TIMEDIFF(TIMEDIFF(estatus_salida.fecha_envio, estatus_llegada.fecha_envio),('08:00:00')))
            ELSE 'NO'
        END
END AS cumple_condicion
FROM viajes
INNER JOIN operadores ON operadores.id = viajes.employee_id
INNER JOIN unidades ON unidades.placas = viajes.placas
INNER JOIN reportes_estatus_viajes AS estatus_llegada ON viajes.id = estatus_llegada.id_viaje AND estatus_llegada.id_estatus = 3
INNER JOIN reportes_estatus_viajes AS estatus_salida ON viajes.id = estatus_salida.id_viaje AND estatus_salida.id_estatus = 8
INNER JOIN clientes AS clientes ON viajes.partner_id = clientes.id
left JOIN cobro_estadias  ON viajes.id = cobro_estadias.id_viaje
WHERE DATE(fecha_inicio) BETWEEN '$fechaInicio' AND '$fechaFin' 
group by viajes.id
ORDER BY diferencia DESC";
$resultado = $cn->query($sqlSelect);

?>
<table class="table table-sm table-hover table-sm table-borderless table-thead-bordered table-align-middle" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Sucursal</th>
            <th scope="col">Referencia</th>
            <th scope="col">Unidad</th>
            <th scope="col">Operador</th>
            <th scope="col">Cliente</th>
            <th scope="col">Llegada a planta</th>
            <th scope="col">Salida de planta</th>
            <th scope="col">Tiempo en planta</th>
            <th scope="col">Horas estadías</th>
            <th scope="col">Estado cobro</th>
            <th scope="col">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr onclick="abrir('<?php echo $row['id_estadia'] ?>','<?php echo $row['id_viaje'] ?>','<?php echo $row['diferencia'] ?>')">
                <th class="h6"><?php echo $row['store_id'] ?></th>
                <th class="h6"><?php echo $row['referencia'] ?></th>
                <th class="h6"><?php echo $row['unidad'] ?></th>
                <th class="h6"><?php echo $row['nombre_operador'] ?></th>
                <th class="h6"><?php echo $row['nombre'] ?></th>
                <th class="h6"><?php echo $row['fecha1'] ?></th>
                <th class="h6"><?php echo $row['fecha2'] ?></th>
                <th class="h6"><?php echo $row['diferencia'] ?></th>
                <th class="h6"><?php echo $row['cumple_condicion'] ?></th>
                <th class="h6">
                    <?php if ($row['estado_estadia'] == 'confirmado') { ?>
                        <span class="badge bg-success">Confirmado</span>
                    <?php    } else if ($row['estado_estadia'] == 'borrador') { ?>
                        <span class="badge bg-warning">Borrador</span>
                    <?php  } else if ($row['estado_estadia'] == 'cancelado') { ?>
                        <span class="badge bg-danger">Cancelado</span>
                    <?php } ?>
                </th>
                <th class="h6"><?php echo $row['total_cobrar'] ?></th>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function abrir(id_estadia, id_viaje, horas_sistema) {
        $("#id_estadia").val(id_estadia);
        $("#id_viaje").val(id_viaje);
        $("#horas_sistema").val(horas_sistema);
        $("#modal_estadias").modal('show');
    }
</script>