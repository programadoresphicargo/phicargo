<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT * FROM status";
$resultado = $cn->query($sqlSelect);
?>
<!-- Card -->
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Estatus</h4>
    </div>

    <form>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-thead-bordered table-nowrap table-align-middle table-first-col-px-0 table-sm table-hover table-striped" id="status_viaje">
                <thead class="thead-light">
                    <tr>
                        <th>ID Status</th>
                        <th>Icono</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Terminal</th>
                        <th class="text-center">
                            <div class="mb-1">
                                <img class="avatar avatar-xs" src="../../img/phone.svg" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xs" src="./assets/svg/illustrations-light/oc-email-at.svg" alt="Image Description" data-hs-theme-appearance="dark">
                            </div>
                            Foto
                        </th>
                        <th class="text-center">
                            <div class="mb-1">
                                <img class="avatar avatar-xs" src="../../img/phone.svg" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xs" src="./assets/svg/illustrations-light/oc-globe.svg" alt="Image Description" data-hs-theme-appearance="dark">
                            </div>
                            Email
                        </th>
                        <th class="text-center">
                            <div class="mb-1">
                                <img class="avatar avatar-xs" src="../../img/phone.svg" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xs" src="./assets/svg/illustrations-light/oc-phone.svg" alt="Image Description" data-hs-theme-appearance="dark">
                            </div>
                            Comentarios
                        </th>
                        <th class="text-center">
                            <div class="mb-1">
                                <img class="avatar avatar-xs" src="../../img/phone.svg" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xs" src="./assets/svg/illustrations-light/oc-phone.svg" alt="Image Description" data-hs-theme-appearance="dark">
                            </div>
                            Monitoreo
                        </th>
                        <th class="text-center">
                            <div class="mb-1">
                                <img class="avatar avatar-xs" src="../../img/phone.svg" alt="Image Description" data-hs-theme-appearance="default">
                                <img class="avatar avatar-xs" src="./assets/svg/illustrations-light/oc-phone.svg" alt="Image Description" data-hs-theme-appearance="dark">
                            </div>
                            Operador
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = $resultado->fetch_assoc()) { ?>
                        <tr>
                            <td class="text-center"><?php echo $row['id_status'] ?></td>
                            <td class="text-center"><img src="../../img/estatus/<?php echo $row['imagen'] ?>" width="30px"></td>
                            <td onclick="getDatos('<?php echo $row['id_status'] ?>','<?php echo $row['status'] ?>','<?php echo $row['tipo'] ?>','<?php echo $row['tipo_terminal'] ?>', '<?php echo $row['imagen'] ?>')"><span class="d-block h5 text-inherit mb-0"><?php echo $row['status'] ?></span></td>

                            <?php if ($row['tipo'] == 'viaje') { ?>
                                <td><span class="badge bg-primary">Viaje</span></td>
                            <?php } else if ($row['tipo'] == 'maniobra') { ?>
                                <td><span class="badge bg-success">Maniobra</span></td>
                            <?php } else { ?>
                                <td><span class="badge bg-success"></span></td>
                            <?php } ?>

                            <?php if ($row['tipo_terminal'] == 'puerto') { ?>
                                <td><span class="badge bg-warning">Puerto</span></td>
                            <?php } else if ($row['tipo_terminal'] == 'externa') { ?>
                                <td><span class="badge bg-danger">Externa</span></td>
                            <?php } else { ?>
                                <td><span class="badge bg-success"></span></td>
                            <?php } ?>

                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox" data-id="<?php echo $row["id_status"] ?>" data-columna="foto" type="checkbox" <?php echo $row["foto"] ? "checked" : ""; ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox" data-id="<?php echo $row["id_status"] ?>" data-columna="email" type="checkbox" <?php echo $row["email"] ? "checked" : ""; ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox" data-id="<?php echo $row["id_status"] ?>" data-columna="comentarios" type="checkbox" <?php echo $row["comentarios"] ? "checked" : ""; ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox" data-id="<?php echo $row["id_status"] ?>" data-columna="monitoreo" type="checkbox" <?php echo $row["monitoreo"] ? "checked" : ""; ?>>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input checkbox" data-id="<?php echo $row["id_status"] ?>" data-columna="operador" data-columna="1" type="checkbox" <?php echo $row["operador"] ? "checked" : ""; ?>>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- End Table -->
    </form>

</div>
<!-- End Card -->
<script>
    function getDatos(id_status, status, tipo, tipo_terminal, img) {
        $('#id_status').val(id_status);
        $('#status').val(status);
        $('#tipo').val(tipo);
        $('#tipo_terminal').val(tipo_terminal);
        $('#modal_registro').modal('show');
        $('#guardar_status').show();
        $('#registrar_status').hide();
        document.getElementById('avatarImg').src = img;
    }

    $(document).ready(function() {

        $('.checkbox').change(function() {
            var checkbox = $(this);
            var id = $(this).data('id');
            var columna = $(this).data('columna');
            var valor = $(this).prop('checked') ? true : false;

            console.log('ID: ' + id + ', Columna: ' + columna + ', Valor: ' + valor);

            $.ajax({
                url: "editar_status.php",
                method: "POST",
                data: {
                    id_estatus: id,
                    columna: columna,
                    valor: valor
                },
                success: function(response) {
                    if (response == 1) {} else {
                        notyf.error('Error.');
                        checkbox.prop('checked', !valor);
                    }
                },
                error: function() {
                    checkbox.prop('checked', !valor);
                    alert("Error al guardar los datos en MySQL");
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#status_viaje').DataTable({
            dom: 'Bfrtlip',
            aaSorting: [],
            buttons: [{
                    extend: 'pdfHtml5',
                    text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                    titleAttr: 'Exportar a PDF',
                    className: 'btn btn-primary',
                },
                {
                    extend: 'excelHtml5',
                    text: 'Exel <i class="bi bi-filetype-exe"></i>',
                    titleAttr: 'Exportar a Exel',
                    className: 'btn btn-primary'
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
                [50, -1],
                [50, "All"]
            ]
        });
    });
</script>