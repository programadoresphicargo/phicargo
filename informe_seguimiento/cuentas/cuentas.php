<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT *, empresas.nombre as nombre_empresa, bancos.nombre as nombre_banco FROM cuentas inner join bancos on bancos.id_banco = cuentas.id_banco inner join empresas on empresas.id_empresa = cuentas.id_empresa";
$resultado = $cn->query($sql);
?>

<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-striped table-sm table-hover" id="TablaCuentas">
    <thead>
        <tr>
            <th scope="col">Empresa</th>
            <th scope="col">Banco</th>
            <th scope="col">Moneda</th>
            <th scope="col">Referencia</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['nombre_empresa'] ?></td>
                <td><?php echo $row['nombre_banco'] ?></td>
                <td><?php echo $row['moneda'] ?></td>
                <td><?php echo $row['referencia'] ?></td>
                <td onclick="editar_cuenta('<?php echo $row['id_cuenta'] ?>','<?php echo $row['id_banco'] ?>','<?php echo $row['id_empresa'] ?>','<?php echo $row['tipo'] ?>','<?php echo $row['moneda'] ?>','<?php echo $row['referencia'] ?>')"><button class="btn btn-success btn-xs"><i class="bi bi-pencil-square"></i></button></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function editar_cuenta(id_cuenta, id_banco, id_empresa, tipo, moneda, referencia) {
        $("#añadir_nueva_cuenta").offcanvas('show');
        $("#id_cuenta").val(id_cuenta).change();
        $("#id_banco").val(id_banco).change();
        $("#id_empresa").val(id_empresa).change();
        $("#tipo").val(tipo).change();
        $("#moneda").val(moneda).change();
        $("#referencia").val(referencia).change();
        $("#guardar_cambios_cuenta").css('display', 'block');
        $("#registrar_cuenta").css('display', 'none');
    }

    $('#TablaCuentas').DataTable({
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