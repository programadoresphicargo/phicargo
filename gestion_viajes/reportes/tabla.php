<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT *, reportes.id as id_reporte FROM reportes inner join viajes on viajes.id = reportes.id_viaje inner join operadores on operadores.id = viajes.employee_id inner join unidades on unidades.placas = viajes.placas order by fecha_hora desc";
$resultado = $cn->query($sqlSelect);

?>
<table class="table table-sm table-hover table-sm table-striped" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Sucursal</th>
            <th scope="col">Fecha y hora</th>
            <th scope="col">Referencia</th>
            <th scope="col">Unidad</th>
            <th scope="col">Operador</th>
            <th scope="col">Comentarios de operador</th>
            <th scope="col">Comentarios de monitorista</th>
            <th scope="col">Atentido</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr onclick="abrir_notificacion(1,'<?php echo $row['id_reporte'] ?>')">
                <th><?php echo $row['store_id'] ?></th>
                <th><?php echo $row['fecha_hora'] ?></th>
                <th><?php echo $row['referencia'] ?></th>
                <th><span class="badge badge-secondary"><?php echo $row['unidad'] ?></span></th>
                <th><?php echo $row['nombre_operador'] ?></th>
                <th><?php echo $row['comentarios_operador'] ?></th>
                <th><?php echo $row['comentarios_monitorista'] ?></th>
                <?php if ($row['atendido'] != NULL) { ?>
                    <th><span class="badge bg-success">Atendido</span></th>
                <?php } else { ?>
                    <th></th>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function abrir_notificacion(noti, id) {
        if (noti == 1) {
            $("#modal_reporte_problema").modal('show');
            $("#info_reporte").load('../../includes2/info_reporte.php', {
                'id': id
            });
        }
    }
</script>

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