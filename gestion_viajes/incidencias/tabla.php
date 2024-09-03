<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT * FROM incidencias
inner join usuarios on usuarios.id_usuario = incidencias.id_usuario 
inner join operadores on operadores.id = incidencias.id_operador
order by fecha_registro desc";
$resultado = $cn->query($sqlSelect);

?>
<table class="table table-sm table-hover table-sm table-striped" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">ID Incidencia</th>
            <th scope="col">Operador</th>
            <th scope="col">Tipo incidencia</th>
            <th scope="col">Comentarios</th>
            <th scope="col">Fecha y hora</th>
            <th scope="col">Usurio registro</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <th><?php echo $row['id_incidencia'] ?></th>
                <th><?php echo $row['nombre_operador'] ?></th>
                <th><?php echo $row['tipo_incidencia'] ?></th>
                <th><?php echo $row['comentarios'] ?></th>
                <th><?php echo $row['fecha_registro'] ?></th>
                <th><?php echo $row['nombre'] ?></th>
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