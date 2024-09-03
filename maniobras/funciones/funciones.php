<script>
    $(document).ready(function() {

        var id_cp = '<?php echo $_POST['id'] ?>';

        $("#abrir_checklist_1").click(function() {
            $('#checklist_maniobra').offcanvas('show');
            $('#contenido_checklist').load('../checklist/contenido.php', {
                'id_cp': '<?php echo $_POST['id'] ?>',
                'tipo': 'Retiro',
            });
        });

        $("#abrir_checklist_2").click(function() {
            $('#checklist_maniobra').offcanvas('show');
            $('#contenido_checklist').load('../checklist/contenido.php', {
                'id_cp': '<?php echo $_POST['id'] ?>',
                'tipo': 'Ingreso',
            });
        });

        const listado_ligado = document.getElementById('listado_ligado');

        $("#InfoManiobra1").load('../maniobra/maniobra_1.php', {
            'id': '<?php echo $_POST['id']; ?>',
        });

        $("#InfoManiobra2").load('../maniobra/maniobra_2.php', {
            'id': '<?php echo $_POST['id']; ?>',
        });

        var tipo;

        $(".retiro").click(function() {
            tipo = 'Retiro';
            console.log(tipo);
        });

        $(".ingreso").click(function() {
            tipo = 'Ingreso';
            console.log(tipo);
        });

        function comprobar_estado_odoo_retiro() {
            $.ajax({
                type: 'POST',
                data: {
                    id_cp: id_cp,
                    tipo: 'Retiro'
                },
                url: "../codigos/comprobar_estados_odoo.php",
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        if (data.length > 0) {
                            var primerObjeto = data[0];

                            if ('x_status_maniobra_retiro' in primerObjeto) {
                                var valor = primerObjeto['x_status_maniobra_retiro'];
                                console.log('Valor de x_status_maniobra_retiro:', valor);

                                switch (valor) {
                                    case false:
                                        $('#GuardarDatosManiobraRetiro').show();
                                        $('.M1iniciar').hide();
                                        $('.M1etiqueta').hide();
                                        break;
                                    case 'borrador':
                                        $('#GuardarDatosManiobraRetiro').show();
                                        $('#ConfirmarManiobraRetiro').show();
                                        $('.M1iniciar').hide();
                                        $('.M1etiqueta').hide();
                                        break;
                                    case 'confirmada':
                                        $('#GuardarDatosManiobraRetiro').show();
                                        $('#ConfirmarManiobraRetiro').hide();
                                        $('.M1iniciar').show();
                                        $('.M1etiqueta').hide();
                                        break;
                                    case 'activo':
                                        $('.M1finalizar').show();
                                        $('.M1status').show();
                                        $('.M1etiqueta').hide();
                                        break;
                                    case 'finalizado':
                                        $('#asignar_eqm1').css('display', 'none');
                                        $('.M1etiqueta').show();
                                        break;
                                    default:
                                        break;
                                }
                            } else {
                                console.error('La clave x_status_maniobra_retiro no está presente en el objeto.');
                            }
                        } else {
                            console.error('El array está vacío.');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Ha ocurrido un error al procesar la solicitud. Por favor, revisa la consola para más detalles.");
                }
            });
        }

        comprobar_estado_odoo_retiro();

        $("#ConfirmarManiobraRetiro").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    id_cp: id_cp,
                    tipo: 'Retiro'
                },
                url: "../maniobra/comprobar_equipo.php",
                success: function(respuesta) {
                    if (respuesta == '') {
                        $.ajax({
                            type: 'POST',
                            data: {
                                id_cp: id_cp,
                                tipo: 'Retiro'
                            },
                            url: "../codigos/confirmar_maniobra.php",
                            success: function(data) {
                                if (data == 1) {
                                    comprobar_estado_odoo_retiro();
                                    notyf.success('Maniobra confirmada.');
                                } else {
                                    notyf.error(data);
                                }
                            },
                        });
                    } else {
                        notyf.error('No se puede iniciar la maniobra ya que el equipo asignado no se encuentra disponible.');
                        notyf.error(respuesta);
                    }
                }
            })
        });

        $("#ConfirmarManiobraIngreso").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    id_cp: id_cp,
                    tipo: 'Ingreso'
                },
                url: "../maniobra/comprobar_equipo.php",
                success: function(respuesta) {
                    if (respuesta == '') {
                        $.ajax({
                            type: 'POST',
                            data: {
                                id_cp: id_cp,
                                tipo: 'Ingreso'
                            },
                            url: "../codigos/confirmar_maniobra.php",
                            success: function(data) {
                                if (data == 1) {
                                    comprobar_estado_odoo_ingreso();
                                    notyf.success('Maniobra confirmada.');
                                } else {
                                    notyf.error(data);
                                }
                            },
                        });
                    } else {
                        notyf.error('No se puede iniciar la maniobra ya que el equipo asignado no se encuentra disponible.');
                        notyf.error(respuesta);
                    }
                }
            })
        });

        function comprobar_estado_odoo_ingreso() {
            $.ajax({
                type: 'POST',
                data: {
                    id_cp: id_cp,
                    tipo: 'Ingreso'
                },
                url: "../codigos/comprobar_estados_odoo.php",
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(key, value) {
                        if (data.length > 0) {
                            var primerObjeto = data[0];

                            if ('x_status_maniobra_ingreso' in primerObjeto) {
                                var valor = primerObjeto['x_status_maniobra_ingreso'];
                                console.log('Valor de x_status_maniobra_ingreso:', valor);

                                switch (valor) {
                                    case false:
                                        $('#GuardarDatosManiobraIngreso').show();
                                        $('.M2iniciar').hide();
                                        $('.M2etiqueta').hide();
                                        break;
                                    case 'borrador':
                                        $('#GuardarDatosManiobraIngreso').show();
                                        $('#ConfirmarManiobraIngreso').show();
                                        $('.M2iniciar').hide();
                                        $('.M2etiqueta').hide();
                                        break;
                                    case 'confirmada':
                                        $('#GuardarDatosManiobraIngreso').show();
                                        $('#ConfirmarManiobraIngreso').hide();
                                        $('.M2iniciar').show();
                                        $('.M2etiqueta').hide();
                                        break;
                                    case 'activo':
                                        $('.M2finalizar').show();
                                        $('.M2status').show();
                                        $('.M2etiqueta').hide();
                                        break;
                                    case 'finalizado':
                                        $('#asignar_eqm1').css('display', 'none');
                                        $('.M2etiqueta').show();
                                        break;
                                    default:
                                        break;
                                }
                            } else {
                                console.error('La clave x_status_maniobra_ingreso no está presente en el objeto.');
                            }
                        } else {
                            console.error('El array está vacío.');
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Ha ocurrido un error al procesar la solicitud. Por favor, revisa la consola para más detalles.");
                }
            });
        }

        comprobar_estado_odoo_ingreso();

        function cambiar_estado_borrador(tipo) {
            $.ajax({
                type: 'POST',
                data: {
                    id_cp: id_cp,
                    tipo: tipo
                },
                url: "../codigos/cambiar_estado_borrador.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        comprobar_estado_odoo_retiro();
                    } else {
                        notyf.error(respuesta);
                    }
                },
            });
        }

        $("#linea_tiempo_status_retiro").load('../maniobra/status.php', {
            'id_cp': '<?php echo $_POST['id']; ?>',
            'tipo': 'Retiro'
        });

        $("#linea_tiempo_status_ingreso").load('../maniobra/status.php', {
            'id_cp': '<?php echo $_POST['id']; ?>',
            'tipo': 'Ingreso'
        });

        $("#GuardarDatosManiobraRetiro").click(function() {

            $.ajax({
                type: "POST",
                data: {
                    'id_cp': '<?php echo $_POST['id'] ?>'
                },
                url: "../codigos/comprobar_correo.php",
                success: function(respuesta) {

                    if (respuesta == 1) {

                        console.log('Guardando...');

                        var fechaActual = new Date();
                        var fechaComparar = new Date($('#x_inicio_programado_retiro').val());

                        if ($('#x_inicio_programado_retiro').val() != '') {
                            if (fechaComparar > fechaActual) {
                                if ($('#x_eco_retiro_id').val() != '') {
                                    if ($('#x_operador_retiro_id').val() != '') {
                                        datos = $("#FormManiobraRetiro").serialize();
                                        console.log(datos);
                                        var miSelect = document.getElementById("x_operador_retiro_id");
                                        var indiceSeleccionado = miSelect.selectedIndex;
                                        var opcionSeleccionada = miSelect.options[indiceSeleccionado];
                                        var valorOpcion = opcionSeleccionada.value;
                                        var tituloOpcion = opcionSeleccionada.text;
                                        console.log("Valor de la opción seleccionada:", valorOpcion);
                                        console.log("Título de la opción seleccionada:", tituloOpcion);

                                        var miSelectECO = document.getElementById("x_eco_retiro_id");
                                        var indice = miSelectECO.selectedIndex;
                                        var opcionSelecECO = miSelectECO.options[indice];
                                        var valorECO = opcionSelecECO.value;
                                        var tituloECO = opcionSelecECO.text;

                                        $.ajax({
                                            type: "POST",
                                            data: datos + "&id_cp=<?php echo $_POST['id'] ?>" + "&nombre_op=" + tituloOpcion + "&nombre_eco=" + tituloECO,
                                            url: "../maniobra/guardar_datos_retiro.php",
                                            success: function(respuesta) {
                                                if (respuesta == 1) {
                                                    notyf.success('Registro modificado correctamente1.');
                                                    cambiar_estado_borrador('Retiro');
                                                    $("#InfoManiobra1").load('../maniobra/maniobra_1.php', {
                                                        'id': '<?php echo $_POST['id']; ?>',
                                                    });
                                                    if ($("#tabla").length) {
                                                        $("#tabla").load('tabla.php');
                                                    } else {
                                                        console.log("El elemento con ID 'tabla' no existe.");
                                                    }
                                                } else {
                                                    notyf.error('No se pudo modificar el registro.');
                                                    notyf.error(respuesta);
                                                }
                                            },
                                            error: function() {
                                                notyf.error('ERROR, VERIFICAR');
                                            }
                                        });
                                    } else {
                                        notyf.error('El campo "Operador" es obligatorio.');
                                    }
                                } else {
                                    notyf.error('El campo "Unidad" es obligatorio.');
                                }
                            } else {
                                notyf.error("La fecha de inicio programado no puede ser menor a la fecha y hora actual.");
                            }
                        } else {
                            notyf.error('La fecha de inicio programado no puede estar nula.');
                        }
                    } else {
                        notyf.error('No existen correos electronicos enlazados a la maniobra.');
                    }
                }
            });
        });

        function guardar_datos_ingreso(datos, id_cp, arreglo, enlace) {
            $.ajax({
                type: "POST",
                data: datos + "&arreglo=" + arreglo + "&travel_id=" + travel_id + "&x_enlace=" + enlace,
                url: "../maniobra/guardar_datos_ingreso.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Registro modificado correctamente.');
                        $("#InfoManiobra2").load('../maniobra/maniobra_2.php', {
                            'id': id_cp,
                        });
                        $('#modal_confirmar_segundo_contenedor').modal('hide');
                    } else {
                        notyf.error('No se pudo modificar el registro.');
                        notyf.error(respuesta);
                    }
                },
                error: function() {
                    notyf.error('ERROR, VERIFICAR');
                }
            });
        }

        var miArreglo = [];
        var travel_id;
        var id_enlace;

        $("#GuardarDatosManiobraIngreso").click(function() {

            $.ajax({
                type: "POST",
                data: {
                    'id_cp': '<?php echo $_POST['id'] ?>'
                },
                url: "../codigos/comprobar_correo.php",
                success: function(respuesta) {

                    if (respuesta == 1) {

                        var contenedor_enlazado = false;
                        datos = $("#FormManiobraIngreso").serialize();
                        var id_cp = '<?php echo $_POST['id'] ?>';

                        var fechaActual = new Date();
                        var fechaComparar = new Date($('#x_inicio_programado_ingreso').val());

                        console.log('Guardando...');
                        if ($('#x_inicio_programado_ingreso').val() != '') {
                            if (fechaComparar > fechaActual) {
                                if ($('#x_eco_ingreso_id').val() != '') {
                                    if ($('#x_mov_ingreso_bel_id').val() != '') {
                                        $.ajax({
                                            type: "POST",
                                            data: "id_maniobra=" + id_cp,
                                            url: "../app/obtener2do.php",
                                            success: function(respuesta) {
                                                miArreglo.push(id_cp);
                                                try {
                                                    var jsonResponse = JSON.parse(respuesta);
                                                    if (jsonResponse.length > 0) {
                                                        var id = jsonResponse[0].id;
                                                        var travelId = jsonResponse[0].travel_id;
                                                        var xReference = jsonResponse[0].x_reference;

                                                        console.log('ID:', id);
                                                        console.log('Travel ID:', travelId);
                                                        console.log('X Reference:', xReference);
                                                        $('#modal_confirmar_segundo_contenedor').modal('show');
                                                        var parrafo = document.getElementById("2do_contenedor");
                                                        parrafo.textContent = xReference;
                                                        id_enlace = id;
                                                        travel_id = travelId[0];
                                                        cambiar_estado_borrador('Ingreso');
                                                    } else {
                                                        console.error('El arreglo JSON está vacío.');
                                                        guardar_datos_ingreso(datos, id_cp, miArreglo, false);
                                                        cambiar_estado_borrador('Ingreso');
                                                    }
                                                } catch (error) {
                                                    guardar_datos_ingreso(datos, id_cp, miArreglo, false);
                                                    cambiar_estado_borrador('Ingreso');
                                                    notyf.success('No se hallo un viaje ligado a esta solicitud/Carta porte.');
                                                }
                                            },
                                            error: function() {
                                                notyf.success('ERROR, VERIFICAR');
                                            }
                                        });

                                    } else {
                                        notyf.error('El campo "Operador" es obligatorio.');
                                    }
                                } else {
                                    notyf.error('El campo "Unidad" es obligatorio.');
                                }
                            } else {
                                notyf.error("La fecha de inicio programado no puede ser menor a la fecha y hora actual.");
                            }
                        } else {
                            notyf.error('La fecha de inicio programado no puede estar nula.');
                        }
                    } else {
                        notyf.error('No existen correos electronicos enlazados a la maniobra.');
                    }
                }
            });
        });

        $("#confirmar_enlace").click(function() {
            miArreglo.push(id_enlace);
            datos = $("#FormManiobraIngreso").serialize();
            var id_cp = '<?php echo $_POST['id'] ?>';
            guardar_datos_ingreso(datos, id_cp, miArreglo, true);
        });

        $("#no_enlace").click(function() {
            datos = $("#FormManiobraIngreso").serialize();
            var id_cp = '<?php echo $_POST['id'] ?>';
            guardar_datos_ingreso(datos, id_cp, miArreglo, false);
        });

        function enviar_status(id_cp, id_status, placas, tipo, id) {
            $.ajax({
                type: "POST",
                data: {
                    'id_cp': id_cp,
                    'id_status': id_status,
                    'placas': placas,
                    'tipo': tipo,
                    'id': id,
                },
                url: "guardar_status.php",
                success: function(respuesta) {
                    //$('#enviar_status_maniobra_modal').modal('hide')

                    $("#linea_tiempo_status_retiro").load('../maniobra/status.php', {
                        'id_cp': '<?php echo $_POST['id']; ?>',
                        'tipo': 'Retiro'
                    });

                    $("#linea_tiempo_status_ingreso").load('../maniobra/status.php', {
                        'id_cp': '<?php echo $_POST['id']; ?>',
                        'tipo': 'Ingreso'
                    });
                }
            });
        }

        $("#iniciar_maniobra").click(function() {
            console.log('INICIANDO MANIOBRA');
            $.ajax({
                type: "POST",
                data: {
                    'id_cp': <?php echo $_POST['id'] ?>,
                    'tipo': tipo,
                },
                url: "../maniobra/comprobar_equipo.php",
                success: function(respuesta) {
                    if (respuesta == '') {
                        $.ajax({
                            type: "POST",
                            data: {
                                'id_cp': <?php echo $_POST['id'] ?>,
                                'tipo': tipo,
                                'usuario_inicio': <?php echo $_SESSION['userID'] ?>,
                            },
                            url: "../codigos/iniciar_maniobra.php",
                            success: function(respuesta) {
                                if (respuesta == 1) {
                                    notyf.success('Maniobra iniciada');
                                    $('#modal_iniciar').modal('hide');

                                    $.ajax({
                                        type: "POST",
                                        data: {
                                            'id_cp': <?php echo $_POST['id'] ?>,
                                            'tipo': tipo,
                                        },
                                        url: "../codigos/cambiar_estados.php",
                                        success: function(respuesta) {
                                            notyf.success('Equipo estado: En Maniobra.');
                                        }
                                    });

                                    if (tipo == 'Retiro') {
                                        $('.M1iniciar').hide();
                                        $('.M1finalizar').show();
                                        $('.M1status').show();
                                    } else {
                                        $('.M2iniciar').hide();
                                        $('.M2finalizar').show();
                                        $('.M2status').show();
                                    }

                                    if (tipo == 'Retiro') {
                                        $.ajax({
                                            type: "POST",
                                            data: {
                                                'id_cp': <?php echo $_POST['id'] ?>,
                                                'tipo': tipo,
                                                'id_usuario': <?php echo $_SESSION['userID'] ?>,
                                                'status_ejecutivo': 95,
                                                'comentarios': 'Iniciando Maniobra de Retiro',
                                            },
                                            url: "../correos/envio_manual.php",
                                            success: function(respuesta) {
                                                if (respuesta == '11') {
                                                    notyf.success('Primer status enviado.');
                                                    $('.M1iniciar').hide();
                                                    $('.M1finalizar').show();
                                                    $('.M1status').show();
                                                }
                                            }
                                        });
                                    } else if (tipo == 'Ingreso') {
                                        $.ajax({
                                            type: "POST",
                                            data: {
                                                'id_cp': <?php echo $_POST['id'] ?>,
                                                'tipo': tipo,
                                                'id_usuario': <?php echo $_SESSION['userID'] ?>,
                                                'status_ejecutivo': 95,
                                                'comentarios': 'Iniciando Maniobra de Retiro',
                                            },
                                            url: "../correos/envio_manual.php",
                                            success: function(respuesta) {
                                                if (respuesta == '11') {
                                                    notyf.success('Primer status enviado.');
                                                    $('.M2iniciar').hide();
                                                    $('.M2finalizar').show();
                                                    $('.M2status').show();
                                                }
                                            }
                                        });
                                    }

                                } else if (respuesta == 2) {
                                    notyf.error('La maniobra ya fue iniciada.');
                                } else {
                                    notyf.error('La maniobra no se pudo iniciar.');
                                }
                            }
                        });
                    } else {
                        notyf.error('No se puede iniciar la maniobra ya que el equipo asignado no se encuentra disponible.');
                        notyf.error(respuesta);
                    }
                }
            });
        });

        $("#finalizar_maniobra_retiro").click(function() {
            notyf.success('Finalizando maniobra...');
            $.ajax({
                type: "POST",
                data: {
                    'id_cp': <?php echo $_POST['id'] ?>,
                    'tipo': tipo,
                    'usuario_finalizacion': <?php echo $_SESSION['userID'] ?>,
                },
                url: "../codigos/finalizar_maniobra.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        if (typeof recargar === 'function') {
                            recargar();
                        } else {
                            console.log("La función miFuncion no existe o no es una función.");
                        }
                        notyf.success('Maniobra finalizada.');
                        $('#modal_finalizar').modal('hide');
                        if (tipo == 'Retiro') {
                            $('.M1finalizar').hide();
                            $('.M1status').hide();
                            $('.M1etiqueta').show();
                        } else {
                            $('.M2finalizar').hide();
                            $('.M2status').hide();
                            $('.M2etiqueta').show();
                        }

                        $.ajax({
                            type: "POST",
                            data: {
                                'id_cp': <?php echo $_POST['id'] ?>,
                                'tipo': tipo,
                            },
                            url: "../codigos/liberar.php",
                            success: function(respuesta) {}
                        });
                    } else if (respuesta == 2) {
                        notyf.error('La maniobra ya fue iniciada.');
                    } else {
                        notyf.error('No se puede finalizar la maniobra.');
                    }
                }
            });
        });

        $("#guardar_correo").click(function() {
            datos = $('#FormCorreo').serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../correos/guardar_correo.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Correo registrado correctamente.');
                        $("#offcanvas_registro_correo").offcanvas('hide');
                        $('#correos_registrados').load('../correos/correos_disponibles.php', {
                            'id_cliente': '<?php echo $id_cliente ?>'
                        }, function() {

                            const listado = document.getElementById('listado_correos');

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
                    } else {
                        notyf.error('Error, no se guardo el registro.');
                    }
                }
            });
        });
    });

    $("#abrir_correos_ligados").click(function() {
        $('#modal_maniobras_correos').offcanvas('show');
    });

    $("#registrar_nuevo_correo").click(function() {
        $('#offcanvas_registro_correo').offcanvas('show');
    });

    $("#abrir_archivos_adjuntos").click(function() {
        $('#archivos_adjuntos_modal').offcanvas('show');
    });

    $("#abrir_modal_status1").click(function() {
        $('#enviar_status_maniobra_modal').offcanvas('show');
    });

    $("#abrir_modal_status2").click(function() {
        $('#enviar_status_maniobra_modal').offcanvas('show');
    });

    $("#abrir_modal_status1").click(function() {
        $('#enviar_status_maniobra_modal').offcanvas('show');
        $('#contenido_status').load('../status/contenido.php', {
            'id_cp': '<?php echo $_POST['id'] ?>',
            'tipo': 'Retiro'
        });
    });

    $("#abrir_modal_status2").click(function() {
        $('#enviar_status_maniobra_modal').offcanvas('show');
        $('#contenido_status').load('../status/contenido.php', {
            'id_cp': '<?php echo $_POST['id'] ?>',
            'tipo': 'Ingreso'
        });
    });

    $(".M1checklist").click(function() {
        $("#modal_checklist_maniobra").offcanvas('show');
        $('#checklist_maniobra_contenido').load('../checklist/cuerpo_checklist.php', {
            'id_cp': '<?php echo $_POST['id'] ?>',
            'tipo': 'Retiro',
        });
    });

    $(".M2checklist").click(function() {
        $("#modal_checklist_maniobra").offcanvas('show');
        $('#checklist_maniobra_contenido').load('../checklist/cuerpo_checklist.php', {
            'id_cp': '<?php echo $_POST['id'] ?>',
            'tipo': 'Ingreso',
        });
    });
</script>