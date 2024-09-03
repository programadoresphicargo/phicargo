<?php
require_once('../../mysql/conexion.php');
$cn = conectar();


$sql = "SELECT 
v.id, 
v.referencia, 
v.estado,
o.nombre_operador,
u.unidad,
CONVERT_TZ(v.date_start, '+00:00', '-06:00') AS fecha_inicio, 
CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00') AS fecha_planta, 
CASE 
    WHEN v.estado IN ('ruta', 'planta', 'resguardo','retorno') THEN
        CASE 
            WHEN v.estado IN ('planta','retorno') AND c.status = 'Llegada a planta' AND c.fecha_envio IS NOT NULL THEN 
                CASE 
                    WHEN CONVERT_TZ(c.fecha_envio, '+00:00', '-06:00') > CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00') THEN
                        'Llegó tarde a planta'
                    WHEN CONVERT_TZ(c.fecha_envio, '+00:00', '-06:00') <= CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00') THEN
                        'Llegó a tiempo'
                END
            WHEN v.estado = 'ruta' THEN
                CASE 
                    WHEN CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00') >= NOW() THEN 'En tiempo'
                    WHEN CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00') < NOW() THEN 'Ya va tarde a planta'
                END
        END
END AS estado_llegada,
CASE 
    WHEN v.estado IN ('planta','retorno') AND c.status = 'Llegada a planta' AND c.fecha_envio IS NOT NULL THEN 
        CONVERT_TZ(c.fecha_envio, '+00:00', '-06:00')
    ELSE 
        NULL
END AS hora_llegada,
CASE 
    WHEN v.estado IN ('planta','retorno') AND c.status = 'Llegada a planta' AND c.fecha_envio IS NOT NULL THEN 
        TIMEDIFF(CONVERT_TZ(c.fecha_envio, '+00:00', '-06:00'), CONVERT_TZ(v.x_llegada_planta_programada, '+00:00', '-06:00'))
    ELSE 
        NULL
END AS diferencia_tiempo
FROM 
viajes v
LEFT JOIN 
correos c ON v.id = c.id_viaje AND c.status = 'Llegada a planta'
LEFT JOIN 
operadores o ON v.employee_id = o.id 
LEFT JOIN 
unidades u ON v.placas = u.placas
WHERE
v.estado IN ('ruta', 'planta', 'resguardo','retorno')
ORDER BY 
v.estado ASC";

$resultado = $cn->query($sql);
?>

<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm" id="tabla-datos5">
    <thead>
        <tr>
            <th scope="col">Referencia viaje</th>
            <th scope="col">Estado</th>
            <th scope="col">Nombre operador</th>
            <th scope="col">Unidad</th>
            <th scope="col">Inicio de ruta programado</th>
            <th scope="col">Inicio real</th>
            <th scope="col">Llegada a planta programada</th>
            <th scope="col">Llegada a planta reportada</th>
            <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td scope="col"><?php echo $row['referencia'] ?></td>
                <td scope="col"><?php echo $row['estado'] ?></td>
                <td scope="col"><?php echo $row['nombre_operador'] ?></td>
                <td scope="col"><?php echo $row['unidad'] ?></td>
                <td scope="col"><?php echo $row['fecha_planta'] ?></td>
                <td scope="col"><?php echo $row['hora_llegada'] ?></td>
                <td scope="col">
                    <?php if ($row['estado_llegada'] == 'Ya va tarde a planta') { ?>
                        <span class="badge bg-warning rounded-pill">Ya va tarde a planta</span>
                    <?php } else if ($row['estado_llegada'] == 'Llegó tarde a planta') { ?>
                        <span class="badge bg-danger rounded-pill">Llegó tarde a planta</span>
                    <?php } elseif ($row['estado_llegada'] == 'En tiempo') { ?>
                        <span class="badge bg-success rounded-pill">En tiempo</span>
                    <?php } elseif ($row['estado_llegada'] == 'Llegó a tiempo') { ?>
                        <span class="badge bg-primary rounded-pill">Llegó a tiempo</span>
                    <?php } else { ?>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tabla-datos5').DataTable({
            dom: 'Bfrtlip',
            buttons: [{
                    extend: 'pdfHtml5',
                    text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-primary btn-sm',
                },
                {
                    extend: 'excelHtml5',
                    text: 'Exel <i class="bi bi-filetype-exe"></i>',
                    titleAttr: 'Exportar a Exel',
                    className: 'btn btn-primary btn-sm'
                },
                {
                    extend: 'print',
                    text: 'Impresion <i class="bi bi-printer"></i>',
                    className: 'btn btn-primary btn-sm',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Filtros <i class="bi bi-printer"></i>',
                    className: 'btn btn-primary btn-sm',
                    columns: 'th:nth-child(n+2)'
                }
            ],
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": " Primero ",
                    "last": " Ultimo ",
                    "next": " Proximo ",
                    "previous": " Anterior  "
                }
            },
            "lengthMenu": [
                [30, 40, 50, -1],
                [30, 40, 50, "All"]
            ]
        });
    });
</script>