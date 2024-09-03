<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$fechaActual = '2024-01-01';

if ($_POST['opcion'] == 'solicitud') {
    $domain[0][] = ['date_order', '>=', $fechaActual];
    $domain[0][] = ['state', '!=', 'cancel'];
} else if ($_POST['opcion'] == 'cp') {
    $domain[0][] = ['date_order', '>=', $fechaActual];
    $domain[0][] = ['state', '!=', 'cancel'];
}

require_once('../../odoo/odoo-conexion.php');

$kwargs = ['fields' => ['id', 'name', 'x_ejecutivo_viaje_bel', 'x_reference', 'x_status_bel', 'x_llegada_patio', 'x_dias_en_patio', 'travel_id', 'store_id', 'date_order', 'partner_id', 'x_mov_bel', 'x_eco_retiro', 'x_operador_retiro', 'x_terminal_bel'], 'order' => 'date_order asc'];

$records = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    $domain,
    $kwargs
);

$json = json_encode($records);
$datos = json_decode($json, true);

?>

<div class="table-responsive">
    <table class="table table-align-middle table-hover table-sm" id="tabla-dato2">
        <thead class="thead-light">
            <tr class="">
                <th>ID</th>
                <th>Fecha</th>
                <th>Ejecutivo</th>
                <th>Cliente</th>
                <th>Referencia Contenedor </th>
                <th>Terminal retiro</th>
                <th>ECO retiro</th>
                <th>Operador retiro</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $item) { ?>
                <tr data-id="<?php echo $item['id'] ?>">
                    <td><?php echo $item['id'] ?></td>
                    <td><?php echo $item['date_order'] ?></td>
                    <td><?php echo $item['x_ejecutivo_viaje_bel'] != null ? $item['x_ejecutivo_viaje_bel'] : 'No definido' ?></td>
                    <td><?php echo $item['partner_id'][1] ?></td>
                    <td><?php echo $item['x_reference'] ?></td>
                    <td><?php echo $item['x_mov_bel'] ?></td>
                    <td><?php echo $item['x_eco_retiro'] ?></td>
                    <td><?php echo $item['x_operador_retiro'] ?></td>
                    <td><button class="btn btn-success btn-xs" onclick="seleccionar('<?php echo $item['id'] ?>')">Seleccionar</button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    var opcion = '<?php echo $_POST['opcion'] ?>';

    function seleccionar(id_cp) {
        if (opcion == 'cp') {
            $("#x_cp_enlazada").val(id_cp);
        } else if (opcion == 'solicitud') {
            $("#x_solicitud_enlazada").val(id_cp);
        }

        $('#buscador_cp_sol').modal('hide');

        $.ajax({
            url: "../buscador/cp_enlazar.php",
            type: "POST",
            data: {
                'id_cp': id_cp,
                'opcion': opcion
            },
            success: function(data) {
                notyf.success(id_cp);
            },
            error: function() {}
        });
    }

    $('#tabla-dato2').DataTable({
        dom: 'Bfrtlip',
        buttons: [{
                extend: 'pdfHtml5',
                text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-xs btn-success',
            },
            {
                extend: 'excelHtml5',
                text: 'Exel <i class="bi bi-filetype-exe"></i>',
                titleAttr: 'Exportar a Exel',
                className: 'btn btn-xs btn-success'
            },
            {
                extend: 'print',
                text: 'Impresion <i class="bi bi-printer"></i>',
                className: 'btn btn-xs btn-success',
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
</script>