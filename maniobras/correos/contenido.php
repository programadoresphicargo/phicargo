<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_cp = $_POST['id_cp'];
$SqlSelect2 = "SELECT * FROM correos_maniobras INNER JOIN correos_electronicos on correos_electronicos.id_correo = correos_maniobras.id_correo where id_cp = $id_cp order by correo asc";
$resultado2 = $cn->query($SqlSelect2);
?>

<form class="">
    <div class="row">
        <div class="col-lg-5">
            <div class="card card-body table-responsive" style="height: 40rem;">
                <div class="row mb-2">
                    <div class="col">
                        <h2>Correos disponibles</h2>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success btn-sm" type="button" id="registrar_nuevo_correo">Nuevo correo</button>
                    </div>
                </div>

                <input type="text" id="buscador" class="form-control" placeholder="Buscar">

                <div id="contenido"></div>

            </div>
        </div>

        <div class="col-lg-7">
            <div id="basicVerStepFormContent">
                <div id="basicVerStepDetails" class="card card-body" style="min-height: 15rem;">
                    <h2>Correos Electrónicos enlazados</h2>

                    <table class="table table-sm" id="correos_ligados">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Dirección</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listado_ligado">
                            <?php while ($row = $resultado2->fetch_assoc()) { ?>
                                <tr data-id="<?php echo $row['id_correo'] ?>">
                                    <td>
                                        <a class="d-flex align-items-center">
                                            <?php if ($row['tipo'] == 'Destinatario') { ?>
                                                <div class="avatar avatar-soft-primary avatar-circle">
                                                    <span class="avatar-initials"><?php echo $row['correo'][0] ?> </span>
                                                </div>
                                            <?php } else { ?>
                                                <div class="avatar avatar-soft-success avatar-circle">
                                                    <span class="avatar-initials"><?php echo $row['correo'][0] ?> </span>
                                                </div>
                                            <?php } ?>

                                            <div class="ms-3">
                                                <span class="d-block h5 text-inherit mb-1"><?php echo $row['correo'] ?></span>
                                                <?php if ($row['tipo'] == 'Destinatario') { ?>
                                                    <span class="d-block fs-5 text-body"><span class="badge bg-soft-primary text-primary"><?php echo $row['tipo'] ?></span></span>
                                                <?php } else { ?>
                                                    <span class="d-block fs-5 text-body"><span class="badge bg-soft-success text-success"><?php echo $row['tipo'] ?></span></span>
                                                <?php } ?>
                                            </div>
                                        </a>
                                    </td>
                                    <td><button class="btn btn-sm btn-primary" type="button" onclick="desvincular_correo(<?php echo $row['id_correo'] ?>)">Eliminar</button></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {

        $('#correos_registrados').DataTable({
            searching: false,
            paging: false,
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

    function comprobar_correo() {
        $.ajax({
            type: 'POST',
            data: {
                id_cp: '<?php echo $_POST['id'] ?>',
            },
            url: "../codigos/comprobar_correo.php",
            success: function(respuesta) {
                if (respuesta == '1') {
                    $('.M1iniciar').prop('disabled', false);
                    $('.M2iniciar').prop('disabled', false);
                } else {
                    notyf.success('Aun no hay correos ligados a esta maniobra');
                    $('.M1iniciar').attr('disabled', true);
                    $('.M2iniciar').attr('disabled', true);
                }
            },
        });
    }

    $('#contenido').load('../correos/correos_disponibles.php', {
        'id_cliente': '<?php echo $id_cliente ?>'
    }, function() {

        var tbodyId = $("#correos_registrados tbody").attr("id");
        const listado = document.getElementById(tbodyId);

        Sortable.create(listado, {
            group: {
                name: "lista-correos",
                pull: 'clone',
                put: false
            },
            animation: 150,
            onEnd: function(evt) {
                var item = evt.item;
                var id_correo = item.dataset.id;
                if (evt.to.id == 'listado_ligado') {
                    $.ajax({
                        type: "POST",
                        data: 'id_cp=' + <?php echo $_POST['id'] ?> + '&id_correo=' + id_correo,
                        url: "../correos/ligar_correo.php",
                        success: function(respuesta) {
                            if (respuesta == 1) {
                                notyf.success('Correo vinculado correctamente.');
                                comprobar_correo();
                            } else if (respuesta == 2) {
                                notyf.error('Correo ya vinculado.');
                                item.parentNode.removeChild(item);
                                comprobar_correo();
                            } else {
                                notyf.error('Correo desvinculado correctamente.');
                                item.parentNode.removeChild(item);
                                comprobar_correo();
                            }
                        }
                    });
                }
            }
        });
    });

    function eliminarRegistro(elemento, id_correo) {
        $.ajax({
            type: "POST",
            data: 'id_cp=' + <?php echo $_POST['id'] ?> + '&id_correo=' + id_correo,
            url: "../correos/desvincular_correo.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    notyf.success('Correo desvinculado correctamente.');
                    var fila = elemento.closest('tr');
                    fila.parentNode.removeChild(fila);
                    comprobar_correo();
                } else {
                    notyf.success('Error, no se desvinculo el correo.');
                }
            }
        });
    }

    Sortable.create(listado_ligado, {
        group: {
            name: "lista-correos",
            pull: 'clone',
        },
        animation: 150,
        onAdd: function(evt) {
            if (evt.to.id == 'listado_ligado') {
                var item = evt.item;
                var botonEliminar = document.createElement('button');
                botonEliminar.setAttribute('type', 'button');
                botonEliminar.classList.add('btn');
                botonEliminar.classList.add('btn-sm');
                botonEliminar.classList.add('btn-danger');
                botonEliminar.innerText = 'Eliminar';
                botonEliminar.addEventListener('click', function() {
                    var registroId = evt.item.getAttribute('data-id');
                    eliminarRegistro(this, registroId);
                });
                var tdAcciones = document.createElement('td');
                tdAcciones.appendChild(botonEliminar);
                item.appendChild(tdAcciones);
            }
        },
    });

    function desvincular_correo(id_correo) {
        $('#correos_ligados tr').click(function() {
            var dataId = $(this).data('id');
            console.log(dataId);
        });
        $.ajax({
            type: "POST",
            data: 'id_cp=' + <?php echo $_POST['id'] ?> + '&id_correo=' + id_correo,
            url: "../correos/desvincular_correo.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    notyf.success('Correo desvinculado correctamente.');
                    $('#correos_ligados tr[data-id=' + id_correo + ']').toggle();
                    comprobar_correo();
                } else {
                    notyf.success('Error, no se desvinculo el correo.');
                }
            }
        });
    }

    var buscador = document.getElementById('buscador');

    buscador.addEventListener('input', function() {
        var filtro = buscador.value.toLowerCase();
        var filas = document.querySelectorAll('#correos_registrados tbody tr');

        for (var i = 0; i < filas.length; i++) {
            var celdas = filas[i].querySelectorAll('td[data-search]');
            var mostrar = false;

            for (var j = 0; j < celdas.length; j++) {
                var valor = celdas[j].getAttribute('data-search').toLowerCase();
                if (valor.includes(filtro)) {
                    mostrar = true;
                    break;
                }
            }

            filas[i].style.display = mostrar ? '' : 'none';
        }
    });


    $("#registrar_nuevo_correo").click(function() {
        $('#modal_maniobras_correos').modal('hide');
        var offcanvas = $('#modal_registro_correo');
        offcanvas.addClass('show');
        $('body').addClass('offcanvas-open');
    });
</script>