<script>
    $('#nueva_entrega').click(function() {
        $('#guardar_entrega').hide();
        $('#abrir_entrega').show();
        $('#cerrar_entrega').hide();
        $('#entviajes').hide();

        $('#fecha_creado').val('').change();
        $('#usuario_autor').val('').change();

        $('#FormEntrega')[0].reset();
        quill.enable();
        quill.setText('');

        $('#FormEntrega :input').prop('disabled', false);

        $.ajax({
            url: 'comprobar_entregas.php',
            success: function(response) {
                if (response == 1) {
                    $('#modal_entrega').offcanvas('show');
                } else {
                    notyf.error('No se puede crear una nueva entrega porque aun no haz confirmado el cierre de una entrega la anterior.');
                }
            }
        });
    });

    $('#titulo').on('input', function() {
        var inputValue = $(this).val();
        if (inputValue === '') {
            $('#editar_entrega, #guardar_entrega').prop('disabled', true);
        } else {
            $('#editar_entrega, #guardar_entrega').prop('disabled', false);
        }
    });

    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    $('#search-input').on('input', function() {
        var searchTerm = $('#search-input').val();
        $('#calendar').fullCalendar('removeEventSources');
        $('#calendar').fullCalendar('addEventSource', 'eventos.php?busqueda=' + searchTerm);
    });

    $(document).ready(function() {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,list'
            },
            locales: 'es',
            views: {
                dayGrid: {
                    buttonText: 'Día'
                },
                timeGrid: {
                    buttonText: 'Semana'
                },
                list: {
                    buttonText: 'Lista'
                },
            },
            events: 'eventos.php',
            eventClick: function(calEvent, jsEvent, view) {
                var eventId = calEvent.id;
                var titulo = calEvent.title;
                var color = calEvent.color;
                var texto = calEvent.texto;
                var usuario = calEvent.usuario;
                var nombre_usuario = calEvent.nombre_usuario;
                var fecha = calEvent.start;
                var estado = calEvent.estado;

                console.log('Hiciste clic en el evento: ' + texto);

                $('#modal_entrega').offcanvas('show');
                $('#id').val(eventId).change();
                $('#titulo').val(titulo).change();
                $('#color').val(color).change();
                $('#fecha_creado').val(fecha).change();
                $('#usuario_autor').val(nombre_usuario).change();
                $('.bg-color').css('background-color', color);

                var delta = quill.clipboard.convert(texto);
                quill.setContents(delta);

                var id_usuario_edit = '<?php echo $_SESSION['userID'] ?>';
                console.log(id_usuario_edit);
                console.log(usuario);

                if (estado == 'abierto') {
                    $('#abrir_entrega').hide();
                    $('#guardar_entrega').show();
                    $('#cerrar_entrega').show();
                    quill.enable();

                    if (id_usuario_edit == usuario) {
                        console.log('el usuario es el mismo');
                        $('#FormEntrega :input').prop('disabled', false);
                        $('#editar_entrega').show();
                    } else {
                        console.log('el usuario NO es el mismo');
                        $('#FormEntrega :input').prop('disabled', true);
                        $('#editar_entrega').hide();
                        $('#guardar_entrega').hide();
                        quill.disable();
                    }

                } else if (estado == 'cerrado') {
                    $('#abrir_entrega').hide();
                    $('#guardar_entrega').hide();
                    $('#cerrar_entrega').hide();
                    $('#FormEntrega :input').prop('disabled', true);
                    quill.disable();
                }
                $('#entviajes').show();

                $.ajax({
                    type: 'POST',
                    url: 'visto.php',
                    data: {
                        'id_usuario': id_usuario_edit,
                        'id_entrega': eventId
                    },
                    success: function(response) {
                        if (response == 1) {
                            notyf.success('Visto.');
                        } else {
                            notyf.error('Entrega de turno, aún NO marcada como vista.');
                        }
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: 'listado_visto.php',
                    data: {
                        'id_entrega': eventId
                    },
                    success: function(response) {
                        $('#listado_visto').html(response);
                    }
                });

                $("#listado_entregas_viaje").load('../../viajes/status/modal/entregas.php', {
                    'id_entrega': eventId
                });

            }
        });
    });

    $('#abrir_entrega').click(function() {
        var datos = $("#FormEntrega").serialize();
        var contenidoHTML = quill.root.innerHTML;
        var titulo = $("#titulo").val();
        var contenido = quill.getText().trim();

        if (titulo != "") {
            if (contenido != "") {
                $.ajax({
                    type: 'POST',
                    url: 'guardar.php',
                    data: datos + '&contenido=' + contenidoHTML,
                    success: function(response) {
                        if (response == 1) {
                            notyf.success('Entrega de turno creada correctamente.');
                            $('#calendar').fullCalendar('removeEventSources');
                            $('#calendar').fullCalendar('addEventSource', 'eventos.php');
                            $('#modal_entrega').offcanvas('hide');
                            $('#FormEntrega')[0].reset();
                            quill.setText('');
                        } else {
                            notyf.error('Error en la creacion de la entrega.');
                        }
                    }
                });
            } else {
                notyf.error('No hay contenido en el área de texto.');
            }
        } else {
            notyf.error('Ingresa un titulo a tu entrega.');
        }
    });

    $('#guardar_entrega').click(function() {
        var datos = $("#FormEntrega").serialize();
        var contenidoHTML = quill.root.innerHTML;

        var titulo = $("#titulo").val();
        var contenido = quill.getText().trim();

        if (titulo != "") {
            if (contenido != "") {

                $.ajax({
                    type: 'POST',
                    url: 'editar.php',
                    data: datos + '&contenido=' + contenidoHTML,
                    success: function(response) {
                        if (response == 1) {
                            notyf.success('Entrega de turno modificada correctamente.');
                            $('#calendar').fullCalendar('removeEventSources');
                            $('#calendar').fullCalendar('addEventSource', 'eventos.php');
                            $('#modal_entrega').offcanvas('hide');
                            /*
                            $('#FormEntrega')[0].reset();
                            quill.setText('');*/
                        } else {
                            notyf.error('Error en la edición de la entrega.');
                        }
                    }
                });
            } else {
                notyf.error('No hay contenido en el área de texto.');
            }
        } else {
            notyf.error('Ingresa un titulo a tu entrega.');
        }
    });

    $('#cerrar_entrega').click(function() {
        var datos = $("#FormEntrega").serialize();

        console.log(datos);

        $.ajax({
            type: 'POST',
            url: 'cerrar_entrega.php',
            data: datos,
            success: function(response) {
                if (response == 1) {
                    notyf.success('Entrega de turno modificada correctamente.');
                    $('#calendar').fullCalendar('removeEventSources');
                    $('#calendar').fullCalendar('addEventSource', 'eventos.php');
                    $('#modal_entrega').offcanvas('hide');
                    /*
                    $('#FormEntrega')[0].reset();
                    quill.setText('');*/
                } else {
                    notyf.error('Error en la edición de la entrega.');
                }
            }
        });
    });
</script>