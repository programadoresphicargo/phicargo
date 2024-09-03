<?php
require_once('../../mysql/conexion.php');
$mysqli = conectar();
$sucursal = $_POST['sucursal'];
$query = "SELECT * FROM cola left join turnos on turnos.id_turno = cola.id_turno left join operadores on operadores.id = turnos.id_operador left join unidades on unidades.placas = turnos.placas where cola_estado = 'espera' and sucursal = '$sucursal'";
$resultado = $mysqli->query($query);
?>
<table class="table table-borderless table-nowrap table-align-middle card-table table-sm" id="TableCola" style="width:100%">
    <thead>
        <tr>
            <th>OPERADOR</th>
            <th>PLACAS / ECO</th>
            <th>LLEGADA</th>
            <th>COMENTARIOS</th>
            <th>SALIDA DE COLA</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $resultado->fetch_assoc()) {
            $userData["cola_" . $sucursal][] = $row; ?>
            <tr class="cursor-pointer responsive">
                <td class="fw-bold text-dark">
                    <?php echo $row['nombre_operador'] ?>
                </td>
                <td>
                    <?php echo $row['unidad'] . ' [' . $row['placas'] . ']' ?>
                </td>
                <td>
                    <?php
                    $date_string = $row['fecha_llegada'] . ' ' . $row['hora_llegada'];
                    $date = new DateTime($date_string);
                    $formatted_date = $date->format('Y/m/d g:i a');
                    echo $formatted_date;
                    ?>
                </td>
                <td>
                    <?php echo $row['comentarios'] ?>
                </td>
                <td>
                    <?php echo $row['fecha_hora_salida']; ?>
                </td>

                <td>
                    <button type="button" class="btn btn-primary btn-xs" onclick="liberar('<?php echo $row['id_turno']; ?>')">
                        Liberar
                    </button>
                </td>

            </tr>
        <?php }
        if (isset($userData)) {
            $json = json_encode($userData);
            $bytes = file_put_contents("../../app/turnos/cola_$sucursal.json", $json);
        } else {
            $userData["cola_" . $sucursal] = [];
            $json = json_encode($userData);
            $bytes = file_put_contents("../../app/turnos/cola_$sucursal.json", $json);
        }  ?>

    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#TableCola').DataTable({
            order: [],
            dom: 'Bfrtlip',
            buttons: [{
                    extend: 'pdfHtml5',
                    text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-danger',
                },
                {
                    extend: 'excelHtml5',
                    text: 'Exel <i class="bi bi-filetype-exe"></i>',
                    titleAttr: 'Exportar a Exel',
                    className: 'btn btn-success'
                },
                {
                    extend: 'print',
                    text: 'Impresion <i class="bi bi-printer"></i>',
                    className: 'btn btn-primary',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
            ],
            /*
            columnDefs: [ {
                targets: -1,
                visible: false
            } ],*/
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
                [500, 40, 50, -1],
                [500, 40, 50, "All"]
            ]
        });
    });
</script>