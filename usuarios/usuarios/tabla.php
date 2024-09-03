<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$Date = date('Y-m-d');
$sqlSelect = "SELECT * FROM usuarios";
$resultSet = $cn->query($sqlSelect); ?>
<table class="js-datatable-checkboxes table table-lg table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-hover table-striped table-sm" id="miTabla2">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Nombre</th>
            <th>Contraseña</th>
            <th>Correo electronico</th>
            <th>Tipo de usuario</th>
            <th>Estado</th>
            <th>PIN</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $resultSet->fetch_assoc()) { ?>
            <tr class="cursor-pointer" onclick="getDatos(
        '<?php echo $row['id_usuario']; ?>',
        '<?php echo $row['usuario']; ?>',
        '<?php echo $row['nombre']; ?>',
        '<?php echo $row['passwoord']; ?>',
        '<?php echo $row['tipo']; ?>',
        '<?php echo $row['estado']; ?>',
        '<?php echo $row['correo']; ?>',
        '<?php echo $row['pin']; ?>')">
                <td>
                    <div class="ms-3">
                        <span class="badge bg-primary"><?php echo $row['usuario'] ?></span>
                    </div>
                </td>
                <td>
                    <div class="ms-3">
                        <span class="d-block h5 text-inherit mb-0"><?php echo $row['nombre'] ?></span>
                    </div>
                </td>
                <td><?php echo $row['passwoord'] ?></td>
                <td><?php echo $row['correo'] ?></td>
                <td><?php echo $row['tipo'] ?></td>
                <td>
                    <?php if ($row['estado'] == 'Activo') { ?>
                        <span class="badge bg-success">Activo</span>
                    <?php  } else { ?>
                        <span class="badge bg-danger">Inactivo</span>
                    <?php  } ?>
                </td>
                <td><?php echo $row['pin'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


<script>
    function getDatos(id, username, name, passwoord, tipo, estado, correo, pin) {
        $("#modal_editar_usuario").modal('toggle');
        $('#idusuario').val(id).change();
        $('#usernameup').val(username).change();
        $('#nameup').val(name).change();
        $('#passwoordup').val(passwoord).change();
        $('#tipoup').val(tipo).change();
        $('#estadoup').val(estado).change();
        $('#correoup').val(correo).change();
        $('#pinup').val(pin).change();

        $.ajax({
            type: "POST",
            data: {
                'id_usuario': $('#idusuario').val()
            },
            url: "tabla_permisos.php",
            success: function(respuesta) {
                $("#usuarios_permisos_tabla").html(respuesta);
            }
        });

        $.ajax({
            type: "POST",
            data: {
                'id_usuario': $('#idusuario').val()
            },
            url: "select_permisos.php",
            success: function(respuesta) {
                $("#select_permisos").html(respuesta);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#miTabla2').DataTable({
            buttons: [{
                    extend: 'pdfHtml5',
                    text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-link',
                },
                {
                    extend: 'excelHtml5',
                    text: 'Exel <i class="bi bi-filetype-exe"></i>',
                    titleAttr: 'Exportar a Exel',
                    className: 'btn btn-link'
                },
                {
                    extend: 'print',
                    text: 'Impresion <i class="bi bi-printer"></i>',
                    className: 'btn btn-link',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Filtros <i class="bi bi-printer"></i>',
                    className: 'btn btn-link',
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