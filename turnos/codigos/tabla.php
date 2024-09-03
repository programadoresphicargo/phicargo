<?php
require_once('../../mysql/conexion.php');
require_once('../../mysql/conexion_inventario.php');

$cn = conectar();
$cn2 = conectar_inventario();
$sucursal = $_POST['sucursal'];

if (isset($_POST['update'])) {
    foreach ($_POST['positions'] as $position) {
        $index = $position[0];
        $newPosition = $position[1];
        $sqlUpdate = "UPDATE turnos SET turno = '$newPosition' WHERE id_turno='$index' and sucursal = '$sucursal'";
        echo $sqlUpdate;
        $cn->query($sqlUpdate);
    }

    exit('success');
}

$Date = date('Y-m-d');
$sqlSelect = "SELECT id_turno, turno, id_operador, nombre_operador, unidades.placas, unidad, fecha_llegada, hora_llegada, comentarios, usuario_registro, fecha_registro, fijado, maniobra1, maniobra2, modalidad, peligroso FROM turnos LEFT JOIN operadores ON turnos.id_operador = operadores.id LEFT JOIN unidades ON turnos.placas = unidades.placas where cola = false and fecha_archivado IS NULL and sucursal = '$sucursal' ORDER BY turno ASC";
$resultSet = $cn->query($sqlSelect); ?>
<table id="miTabla" class="js-datatable table table-borderless table-nowrap table-align-middle card-table table-sm" data-hs-datatables-options='{
                    "dom": "Bfrtip",
                    "language": {
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
            "iDisplayLength": 50,
                    "buttons": [
                      {
                        "extend": "copy",
                        "className": "d-none"
                      },
                      {
                        "extend": "excel",
                        "className": "d-none"
                      },
                      {
                        "extend": "csv",
                        "className": "d-none"
                      },
                      {
                        "extend": "pdf",
                        "className": "d-none"
                      },
                      {
                        "extend": "print",
                        "className": "d-none"
                      }
                   ],
                   "order": []
                 }'>
    <thead class="thead-light">
        <tr>
            <th>Turno</th>
            <th>Operador</th>
            <th>Licencia</th>
            <th>Peligroso</th>
            <th>Contacto</th>
            <th>Unidad</th>
            <th>Llegada</th>
            <th>Maniobra #1</th>
            <th>Maniobra #2</th>
            <th>Comentarios</th>
        </tr>
    </thead>
    <tbody id="listado_turnos">
        <?php $i = 1;
        while ($row = $resultSet->fetch_assoc()) {
            $userData["turnos_" . $sucursal][] = $row; ?>

            <tr style="cursor: pointer;" class="cursor-pointer <?php echo ($row['fijado']) ? 'bg-soft-primary' : ''; ?>" onclick="get_turno('<?php echo $row['id_turno']; ?>')" data-index="<?php echo $row['id_turno'] ?>" data-position="<?php echo $row['turno'] ?>">

                <td class="fw-bold text-dark">
                    <div class="list-group-item">
                        <i class="sortablejs-custom-handle bi-grip-horizontal list-group-icon"></i> <span class="avatar avatar-soft-primary avatar-circle">
                            <span class="avatar-initials">#<?php echo $row['turno'] ?></span>
                        </span>
                    </div>
                </td>

                <td class="fw-bold text-dark"><?php echo $row['nombre_operador'] ?></td>
                <td><span class="badge <?php echo $row['modalidad'] == 'single' ? 'bg-warning' : 'bg-success' ?>"><?php echo $row['modalidad'] == 'single' ? 'Sencillo' : 'Full' ?></span></td>
                <td><?php echo $row['peligroso'] == 'SI' ? '<span class="badge bg-danger">Peligroso</span>' : '' ?></span></td>

                <td class="fw-bold text-dark">
                    <?php
                    $operador = $row['nombre_operador'];
                    $sqlNumber = "SELECT * from activo inner join empleado on empleado.ID_EMPLEADO = activo.ID_EMPLEADO inner join celular on celular.ID_CELULAR = activo.ID_CELULAR where CONCAT(APELLIDO_PATERNO, ' ', APELLIDO_MATERNO, ' ',NOMBRE_EMPLEADO) like '%$operador%' ";
                    $resultado = $cn2->query($sqlNumber);
                    if ($resultado->num_rows > 0) {
                        $row2 = $resultado->fetch_assoc();
                    ?>
                        <a class="link link-success"><i class="bi bi-telephone-fill"></i> <?php echo $row2['NUMERO_CELULAR'] ?></a>
                    <?php } ?>
                </td>

                <td><?php echo $row['unidad'] . ' [' . $row['placas'] . ']' ?></td>
                <td>
                    <?php
                    $date_string = $row['fecha_llegada'] . ' ' . $row['hora_llegada'];
                    $date = new DateTime($date_string);
                    $formatted_date = $date->format('Y/m/d g:i a');
                    echo $formatted_date;
                    ?>
                </td>
                <td><span class="badge bg-success rounded-pill"><?php echo $row['maniobra1'] ?></span></td>
                <td><span class="badge bg-primary rounded-pill"><?php echo $row['maniobra2'] ?></span></td>
                <td><?php echo $row['comentarios'] ?></td>
            </tr>
        <?php }

        if (isset($userData)) {
            $json = json_encode($userData);
            $bytes = file_put_contents("../../app/turnos/turnos_$sucursal.json", $json);
        } ?>

    </tbody>
</table>

<script>
    (function() {

        HSCore.components.HSDatatables.init('.js-datatable')
        const exportDatatable = HSCore.components.HSDatatables.getItem('miTabla')

        document.getElementById('export-copy').addEventListener('click', function() {
            exportDatatable.button('.buttons-copy').trigger()
        })

        document.getElementById('export-excel').addEventListener('click', function() {
            exportDatatable.button('.buttons-excel').trigger()
        })

        document.getElementById('export-csv').addEventListener('click', function() {
            exportDatatable.button('.buttons-csv').trigger()
        })

        document.getElementById('export-pdf').addEventListener('click', function() {
            exportDatatable.button('.buttons-pdf').trigger()
        })

        document.getElementById('export-print').addEventListener('click', function() {
            exportDatatable.button('.buttons-print').trigger()
        })
    })()
</script>


<script>
    function get_turno(id_turno) {

        mostrarCampo('usuario_registro');
        mostrarCampo('fecha_registro');

        $('.border-danger').removeClass('border-danger');

        $("#btns-ingresar").hide();
        $("#btns-editar").show();

        notyf.success('Obteniendo turno');

        $("#modal_editar_turno").modal('toggle');

        $.ajax({
            type: "POST",
            data: {
                'id_turno': id_turno,
            },
            url: "../codigos/get_turno.php",
            success: function(respuesta) {
                var data = JSON.parse(respuesta);

                $('#id_turno').val(data.id_turno).change();
                $('#turno').val(data.turno).change();
                $('#sucursal').val(data.sucursal).change();
                $('#placas').val(data.placas).change();
                $('#id_operador').val(data.id_operador).change();
                $('#fecha_llegada').val(data.fecha_llegada).change();
                $('#hora_llegada').val(data.hora_llegada).change();
                $('#comentarios').val(data.comentarios).change();
                $('#usuario_registro').val(data.nombre).change();
                $('#fecha_registro').val(data.fecha_registro).change();
                $('#maniobra1').val(data.maniobra1).change();
                $('#maniobra2').val(data.maniobra2).change();

            }
        });

        $('#FormEditar :input').prop('disabled', true);

        $.ajax({
            type: "POST",
            data: {
                'id_turno': id_turno,
            },
            url: "../codigos/fijado_comprobacion.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $('#Fijar_turno').hide();
                    $('#Soltar_turno').show();
                } else {
                    $('#Soltar_turno').hide();
                    $('#Fijar_turno').show();
                }
            }
        });

        $('#BtnGuardar').hide();
        $('#BtnEditar').show();
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        const listado = document.getElementById('listado_turnos');

        Sortable.create(listado, {
            group: {
                name: "lista-tareas",
                pull: true,
                put: true
            },
            animation: 150,
            handle: '.sortablejs-custom-handle',
            filter: '.bg-soft-primary',
            ghostClass: 'bg-soft-success',
            chosenClass: 'bg-soft-success',
            onUpdate: function(event, ui) {
                $('#miTabla tbody').children().each(function(index) {
                    if ($(this).attr('data-position') != (index + 1)) {
                        $(this).attr('data-position', (index + 1)).addClass('updated');
                    }
                });

                saveNewPositions();
            },
        });


        function saveNewPositions() {
            var positions = [];
            console.log(positions);
            $('.updated').each(function() {
                positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
                $(this).removeClass('updated');
            });

            $.ajax({
                url: '../codigos/tabla.php',
                method: 'POST',
                dataType: 'text',
                data: {
                    update: 1,
                    positions: positions,
                    sucursal: <?php echo "'$sucursal'" ?>
                },
                success: function(response) {
                    console.log(response);
                    $.ajax({
                        type: "POST",
                        data: {
                            sucursal: <?php echo "'$sucursal'" ?>
                        },
                        url: "../codigos/tabla.php",
                        success: function(respuesta) {
                            $("#tabla").html(respuesta);
                        }
                    });

                }
            });
        }
    });