<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT *, usuarios.nombre as n1 
FROM acceso_vehicular 
left join empresas_accesos on empresas_accesos.id_empresa = acceso_vehicular.id_empresa 
left join usuarios on usuarios.id_usuario = acceso_vehicular.usuario_creacion 
order by estado_acceso asc";
$resultado = $cn->query($sql);
?>

<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm mb-2 mb-sm-0">
            <h2 class="page-header-title">Acceso Vehicular</h2>
        </div>

        <div class="col-sm-auto">
            <a class="btn btn-primary btn-sm" href="../acceso_vehicular/index_form.php">
                <i class="bi bi-plus-lg"></i> Nuevo acceso
            </a>
        </div>
    </div>
</div>

<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-striped" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Código de acceso</th>
            <th scope="col">Tipo de movimiento</th>
            <th scope="col">Fecha entrada / salida</th>
            <th scope="col">Empresa</th>
            <th scope="col">Acceso solicitado por</th>
            <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_array()) { ?>
            <tr onclick="ir('<?php echo $row['id_acceso'] ?>')">
                <th><?php echo 'A-' . $row['id_acceso'] ?></th>
                <th>
                    <?php if ($row['tipo_mov'] == 'ingreso') { ?>
                        <span class="badge bg-success rounded-pill">Ingreso a las instalaciones</span>
                    <?php } else if ($row['tipo_mov'] == 'salida') { ?>
                        <span class="badge bg-danger rounded-pill">Salida de las instalaciones</span>
                    <?php }  ?>
                </th>
                <th>
                    <?php
                    $fechaEntrada = $row['fecha_entrada'];
                    $dateTime = new DateTime($fechaEntrada);
                    $fechaFormateada = $dateTime->format('Y/m/d g:i a');
                    echo $fechaFormateada; ?>
                </th>
                <th><?php echo $row['nombre_empresa'] ?></th>
                <th><?php echo $row['n1'] ?></th>
                <th>
                    <?php if ($row['estado_acceso'] == 'espera') { ?>
                        <span class="badge bg-warning rounded-pill">En espera de validación</span>
                    <?php } elseif ($row['estado_acceso'] == 'validado') { ?>
                        <span class="badge bg-success rounded-pill">Validado</span>
                    <?php } elseif ($row['estado_acceso'] == 'salida') { ?>
                        <span class="badge bg-soft-secondary rounded-pill text-dark">Salida validada</span>
                    <?php } ?>
                </th>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function ir(id) {
        window.location.href = "../acceso_vehicular/index_form.php?id=" + id;
    }

    $('#miTabla').DataTable({
        ordering: false,
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
            [30, 40, 50, -1],
            [30, 40, 50, "All"]
        ]
    });
</script>