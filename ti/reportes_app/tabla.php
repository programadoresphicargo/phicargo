<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT * FROM reportes_app left join operadores on operadores.id = reportes_app.id_operador order by fecha_creacion desc";
$resultSet = $cn->query($sqlSelect);

?>

<table id="CuentasUsuario" class="table table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th>Fecha</th>
            <th>Operador</th>
            <th>Notas</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultSet->fetch_assoc()) { ?>
            <tr onclick="abrir_reporte(
                '<?php echo $row['id_reporte'] ?>',
                '<?php echo $row['id_operador'] ?>',
                '<?php echo $row['nombre_operador'] ?>',
                '<?php echo $row['fecha_creacion'] ?>',
                '<?php echo $row['notas_operador'] ?>',
                '<?php echo $row['comentarios_resuelto'] ?>'
                )">
                <td class="card-title"><?php echo $row['id_reporte'] ?></td>
                <td class="card-title">
                    <?php
                    $fechaFormateada = DateTime::createFromFormat('Y-m-d H:i:s', $row['fecha_creacion'])->format('d F Y h:i A');
                    echo $fechaFormateada
                    ?>
                </td>
                <td class="card-title"><?php echo $row['nombre_operador'] ?></td>
                <td class="card-title"><?php echo $row['notas_operador'] ?></td>

                <td class="card-title">
                    <?php if ($row['estado'] == 'resuelto') { ?>
                        <span class="badge bg-success rounded-pill">Resuelto</span>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#CuentasUsuario').DataTable({
            ordering: false,
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
                [20, 25, 30, 40, 50, -1],
                [20, 25, 30, 40, 50, "All"]
            ]
        });
    });

    function abrir_reporte(id_reporte, id_operador, nombre_operador, fecha_creacion, notasoperador, comentario) {
        comprobar_estado(id_reporte);
        $(".page-header-title").text("RF. " + id_reporte);
        $("#offcanvasRight").offcanvas('show');
        $("#id_reporte").val(id_reporte);
        $("#id_operador").val(id_operador);
        $("#nombre_operador").val(nombre_operador);
        $("#fecha_creacion").val(fecha_creacion);
        $("#notasoperador").val(notasoperador);
        $("#comentario").val(comentario);
        $("#imagenes").load('imagenes.php', {
            'res_id': id_reporte
        });
    }
</script>