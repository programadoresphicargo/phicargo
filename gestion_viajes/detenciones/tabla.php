<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT 
rd.*, 
v.referencia AS referencia_viaje, 
v.estado AS estado_viaje, 
o.*, 
u.*, 
ubi.*, 
CASE
    WHEN rd.fin_detencion IS NULL THEN TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, NOW() - INTERVAL 6 HOUR)
    ELSE TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, rd.fin_detencion)
END AS tiempo_transcurrido_minutos
FROM 
registro_detenciones AS rd 
left JOIN viajes AS v ON v.id = rd.id_viaje
left JOIN operadores AS o ON o.id = v.employee_id 
left JOIN unidades AS u ON u.placas = v.placas 
left JOIN ubicaciones AS ubi ON ubi.id = rd.id_ubicacion
WHERE 
rd.estado_viaje IN ('ruta', 'retorno')
AND (
    CASE
        WHEN rd.fin_detencion IS NULL THEN TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, NOW() - INTERVAL 6 HOUR)
        ELSE TIMESTAMPDIFF(MINUTE, rd.inicio_detencion, rd.fin_detencion)
    END > 15
)
ORDER BY 
rd.inicio_detencion DESC";
$resultado = $cn->query($sqlSelect);
?>

<table class="table table-sm table-hover table-sm table-striped" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Viaje</th>
            <th scope="col">Estado del viaje</th>
            <th scope="col">Unidad</th>
            <th scope="col">Nombre operador</th>
            <th scope="col">Inicio detencion</th>
            <th scope="col">Fin detención</th>
            <th scope="col">Tiempo detenido</th>
            <th scope="col">Motivo detención</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Atentido</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <th><?php echo $row['referencia_viaje'] ?></th>
                <th><?php echo $row['estado_viaje'] ?></th>
                <th><span class="badge badge-secondary"><?php echo $row['unidad'] ?></span></th>
                <th><?php echo $row['nombre_operador'] ?></th>
                <th><?php echo $row['inicio_detencion'] ?></th>
                <th><?php echo $row['fin_detencion'] ?></th>
                <th><?php echo $row['tiempo_transcurrido_minutos'] ?></th>
                <th><?php echo $row['motivo'] ?></th>
                <th><?php echo $row['comentarios'] ?></th>
                <?php if ($row['atendida'] == 1) { ?>
                    <th><span class="badge bg-success">Atendida</span></th>
                <?php } else { ?>
                    <th><span class="badge bg-warning">En espera de ser atendida</span></th>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#miTabla').DataTable({
            ordering: false,
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