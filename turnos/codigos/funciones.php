<script>
    function ocultarCampo(campoId) {
        $(`#${campoId}`).closest('.col').hide();
    }

    function mostrarCampo(campoId) {
        $(`#${campoId}`).closest('.col').show();
    }

    var sucursal = '<?php echo $_GET['sucursal'] ?>';
    $("#sucursal").val(sucursal);

    const p = document.getElementById("titulo")
    p.innerText = sucursal;

    function cargar_contenido() {
        $("#tabla").load('../codigos/tabla.php', {
            sucursal: sucursal
        });
    }

    cargar_contenido();

    function cargar_op_cola() {
        $.ajax({
            url: '../cola/tabla.php',
            type: 'POST',
            data: {
                'sucursal': sucursal
            },
            success: function(response) {
                $('#OperadoresEncola').html(response);
            },
            error: function(xhr, status, error) {
                alert("Error al cargar el contenido: " + error);
            }
        });
    }

    $("#abrir_cola").click(function() {
        $('#cola').modal('show');
        cargar_op_cola();
    });

    function liberar(id_turno) {

        Swal.fire({
            title: "Confirmar liberación del turno",
            text: 'El operador ingresa al listado de turnos en la ultima posición.',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Confirmar liberación",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: {
                        'id_turno': id_turno
                    },
                    url: "../cola/liberacion_turno.php",
                    success: function(respuesta) {
                        if (respuesta == 1) {
                            Swal.fire("Operador liberado", "", "success");
                            cargar_op_cola();
                            cargar_contenido();
                        } else {
                            notyf.error(respuesta);
                        }
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Changes are not saved", "", "info");
            }
        });
    }

    flatpickr("#fecha_llegada", {
        enableTime: false,
        dateFormat: "Y-m-d"
    });

    $("#BtnEditar").click(function() {
        $('#FormEditar :input:not(.no-editable)').prop('disabled', false);
        $('#BtnGuardar').show();
        $('#BtnEditar').hide();
    });

    $("#BtnGuardar").click(function() {

        var formData = $("#FormEditar").find("input, select, textarea");
        var datos = {};
        formData.each(function() {
            var nombre = $(this).attr("name");
            var valor = $(this).val();
            datos[nombre] = valor;
            console.log(nombre + ' : ' + valor);
        });

        $.ajax({
            type: "POST",
            data: datos,
            url: "../codigos/editar.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    notyf.success('Información modificada correctamente.');
                    $('#unidad').val(0).change();
                    $('#operador').val(0).change();
                    cargar_contenido();
                    $('#FormEditar :input').prop('disabled', true);
                    $('#BtnGuardar').hide();
                    $('#BtnEditar').show();
                } else {
                    notyf.error('Existe inconsistencia en la información, favor de revisar.');
                    notyf.error(respuesta);
                }
            }
        });
    });

    $("#BtnIngresarOpcola").click(function() {

        $('.error').hide();

        let esValido = true;
        let camposVacios = [];

        $('#FormEditar .required').each(function() {
            if ($(this).val().trim() === '') {
                $(this).next('.error').show();
                $(this).addClass('border border-danger');
                camposVacios.push($(this).prev('label').text());
                esValido = false;
            } else {
                $(this).removeClass('border border-danger');
            }
        });

        if (esValido) {
            var datos = $("#FormEditar").serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigos/ingresar.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Operador ingresado correctamente a turnos.');
                        $("#modal_editar_turno").modal('toggle');
                        cargar_contenido();
                    } else {
                        notyf.error('Existe inconsistencia en la información, favor de revisar.');
                        notyf.error(respuesta);
                    }
                }
            });
        } else {
            let mensajeError = 'Los siguientes campos son obligatorios y están vacíos:<br><ul>';
            camposVacios.forEach(function(campo) {
                mensajeError += '<li>' + campo + '</li>';
            });
            mensajeError += '</ul>';
            notyf.error({
                message: mensajeError,
                duration: 5000,
                dismissible: true
            });
        }
    });

    $("#BtnEnviarOpcola").click(function() {
        $("#ConfirmarEnviocola").modal('toggle');
        $("#modal_editar_turno").modal('toggle');
    });

    $("#abrir_ingresar_turno").click(function() {
        const form = document.getElementById('FormEditar');
        form.reset();
        $("#modal_editar_turno").modal('toggle');
        $("#btns-ingresar").show();
        $("#btns-editar").hide();
        $('#FormEditar :input:not(.no-editable)').prop('disabled', false);

        ocultarCampo('usuario_registro');
        ocultarCampo('fecha_registro');
    });

    document.getElementById("sec3").style.display = "none";
    var fecha_hora_salida = '';

    function formatoFecha(fecha, formato) {
        const map = {
            dd: fecha.getDate(),
            mm: fecha.getMonth() + 1,
            yy: fecha.getFullYear().toString().slice(-2),
            yyyy: fecha.getFullYear()
        }

        return formato.replace(/dd|mm|yy|yyy/gi, matched => map[matched])
    }

    function sumarHoras(horas) {
        let fechaActual = new Date();
        fechaActual.setHours(fechaActual.getHours() + horas);
        return fechaActual;
    }

    const formatDate = (current_datetime) => {
        let formatted_date = current_datetime.getFullYear() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getDate() + " " + current_datetime.getHours() + ":" + current_datetime.getMinutes() + ":" + current_datetime.getSeconds();
        return formatted_date;
    }

    const hoy = new Date();
    var mañana = new Date();
    mañana.setDate(hoy.getDate() + 1);
    fecha_hora_salida = formatoFecha(mañana, 'yy-mm-dd');
    fecha_hora_salida = fecha_hora_salida.concat(" ");
    fecha_hora_salida = fecha_hora_salida.concat('09:00:00');
    console.log(fecha_hora_salida);

    $('#ColaDetalles').change(function(e) {
        console.log($("input[name='formRadio']:checked").val());
        var op = $("input[name='formRadio']:checked").val();

        if (op == '1') {
            document.getElementById("sec3").style.display = "none";

            const hoy = new Date();
            var mañana = new Date();
            mañana.setDate(hoy.getDate() + 1);
            fecha_hora_salida = formatoFecha(mañana, 'yy-mm-dd')
            fecha_hora_salida = fecha_hora_salida.concat(" ");
            fecha_hora_salida = fecha_hora_salida.concat('09:00:00');
            console.log(fecha_hora_salida);

        } else if (op == '3') {
            fecha_hora_salida = '';
            fecha_hora_salida = fecha_hora_salida.concat($("#fecha_salida").val());
            fecha_hora_salida = fecha_hora_salida.concat(" ");
            fecha_hora_salida = fecha_hora_salida.concat($("#hora_salida").val());
            console.log(fecha_hora_salida);
            document.getElementById("sec3").style.display = "block";
        }
    });

    $("#BtnConfirmarEnviarOpcola").click(function() {
        $('#FormEditar :input').prop('disabled', false);
        var datos = $("#FormEditar").serialize();
        console.log(datos);
        $.ajax({
            type: "POST",
            data: datos + "&fecha_hora_salida=" + fecha_hora_salida,
            url: "../cola/enviar_cola.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $.ajax({
                        type: "POST",
                        data: {
                            sucursal: $("#sucursal").val()
                        },
                        url: "../codigos/listado.php",
                        success: function(respuesta) {
                            $('#FormEditar :input').prop('disabled', true);
                            $("#OperadoresEncola").html(respuesta);
                        }
                    });

                    cargar_contenido();
                    $("#ConfirmarEnviocola").modal('toggle');
                    notyf.success('Operador enviado a la cola correctamente.');
                    $("input[name=formRadio][value='1']").prop("checked", true);

                    document.getElementById("sec3").style.display = "none";

                    const hoy = new Date();
                    var mañana = new Date();
                    mañana.setDate(hoy.getDate() + 1);
                    fecha_hora_salida = formatoFecha(mañana, 'yy-mm-dd')
                    fecha_hora_salida = fecha_hora_salida.concat(" ");
                    fecha_hora_salida = fecha_hora_salida.concat('09:00:00');
                    console.log(fecha_hora_salida);

                } else {
                    notyf.error('Error.');
                }
            }
        });
    });


    $('#placas').on("change", function() {
        var unidad = $('#unidad').val();
        $.ajax({
            type: "POST",
            data: {
                'sucursal': sucursal,
                'unidad': unidad
            },
            url: "../codigos/validar_unidad.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    document.getElementById('BtnIngresarOpcola').disabled = true;
                    notyf.error('La unidad ya esta en cola .');
                } else {
                    document.getElementById('BtnIngresarOpcola').disabled = false;
                }
            }

        });
    });

    $('#operador').on("change", function() {
        var id_operador = $('#operador').val();
        $.ajax({
            type: "POST",
            data: {
                'sucursal': sucursal,
                'id_operador': id_operador
            },
            url: "../codigos/validar_operador.php",
            success: function(data) {
                if (data == 1) {
                    document.getElementById('BtnIngresarOpcola').disabled = true;
                    notyf.error('El operador ya esta en cola.');
                } else {
                    document.getElementById('BtnIngresarOpcola').disabled = false;
                }
            }

        });
    });

    $("#Fijar_turno").click(function() {
        $('#FormEditar :input').prop('disabled', false);
        var datos = $("#FormEditar").serialize();
        console.log(datos);
        $.ajax({
            type: "POST",
            data: datos,
            url: "../codigos/fijar_turno.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $("#Fijar_turno").hide();
                    $("#Soltar_turno").show();
                    cargar_contenido();
                    $('#FormEditar :input').prop('disabled', true);
                    notyf.success('El turno se fijo correctamanete.');
                } else {
                    notyf.error('Error.');
                }
            }
        });
    });

    $("#Soltar_turno").click(function() {
        $('#FormEditar :input').prop('disabled', false);
        var datos = $("#FormEditar").serialize();
        console.log(datos);
        $.ajax({
            type: "POST",
            data: datos,
            url: "../codigos/soltar_turno.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $("#Fijar_turno").show();
                    $("#Soltar_turno").hide();
                    cargar_contenido();
                    $('#FormEditar :input').prop('disabled', true);
                    notyf.success('El turno se solto correctamanete.');
                } else {
                    notyf.error('Error.');
                }
            }
        });
    });

    $("#Viaje_asignado").click(function() {
        mostrarSweetAlert();
    });

    function archivar_turno(opcion) {
        $('#FormEditar :input').prop('disabled', false);
        var datos = $("#FormEditar").serialize();
        datos += '&opcion=' + opcion;
        console.log(datos);
        console.log(opcion);
        $.ajax({
            type: "POST",
            data: datos,
            url: "../plan_viaje/archivar.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $('#FormEditar :input').prop('disabled', true);
                    $("#modal_editar_turno").modal('toggle');
                    cargar_contenido();
                    cargar_planviaje();
                    notyf.success('Turno archivado.');
                } else {
                    notyf.error('Error');
                    notyf.error(respuesta);
                }
            }
        });
    }

    $("#mostrar_archivados").click(function() {
        document.getElementById('offcanvasScrolling').classList.toggle('show');
    });

    function cargar_planviaje() {
        $("#plan_de_viaje").load('../plan_viaje/plan_de_viaje.php', {
            rango: $("#rango").val(),
            sucursal: sucursal
        });
    };

    $("#cargar_plan_de_viaje").click(function() {
        cargar_planviaje();
    });

    $("#rango").on('change', function() {
        cargar_planviaje();
        console.log($("#rango").val());
    })

    flatpickr("#rango", {
        dateFormat: "Y-m-d",
        defaultDate: "today",
    });

    $("#abrir_modal_incidencia").click(function() {
        $('#modal_incidencia').modal('show');
    });

    $("#abrir_modal_incidencias").click(function() {
        $('#modal_control_incidencias').modal('show');
        $('#tabla_incidencias').load('../incidencias/tabla.php');
    });

    var miTabla = $('#tabla-distancia').DataTable();

    $("#abrir_modal_unidades_bajando").click(function() {
        $('#modal_unidades_bajando').modal('show');
        $.ajax({
            url: "../unidades_cercanas/getViajes.php",
            type: 'POST',
            data: {
                'sucursal': $("#sucursal").val()
            },
            success: function(response) {
                $("#contdistancias").html(response);
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });
    });

    $('#registrar_incidencia').click(function() {
        if ($("#comentarios_incidencias").val() != '') {
            $("#FormEditar input, #FormEditar select, #FormEditar textarea").prop("disabled", false);
            var datos1 = $("#FormEditar").serialize();
            var datos2 = $("#formIncidencia").serialize();
            var datosCombinados = datos1 + '&' + datos2 + '&sucursal=' + sucursal;

            $.ajax({
                url: '../incidencias/registro_incidencia.php',
                data: datosCombinados,
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        $("#modal_incidencia").modal('hide');
                        $("#modal_editar_turno").modal('hide');
                        notyf.success('Incidencia guardada correctamente');
                        cargar_contenido();
                        $("#FormEditar input, #FormEditar select, #FormEditar textarea").prop("disabled", true);
                        $("#comentarios_incidencias").val('');
                    } else {
                        notyf.error(data);
                    }
                },
                error: function(xhr, status, error) {
                    notyf.error('Error en la solicitud AJAXx:', status, error);
                }
            });
        } else {
            notyf.error('Ingresa un comentario');
        }
    });

    function mostrarSweetAlert() {
        var opciones = ['Viaje asignado', 'Turno repetido', 'Archivado sin asignación de viaje', 'Operador de enganche'];

        var selectHtml = '<select id="swal-select" class="form-control">';
        opciones.forEach(function(opcion) {
            selectHtml += '<option value="' + opcion + '">' + opcion + '</option>';
        });
        selectHtml += '</select>';

        Swal.fire({
            title: 'Archivar turno',
            text: 'Seleccione el motivo por el cual desea archivar este turno.',
            html: selectHtml,
            showCancelButton: true,
            confirmButtonText: 'Archivar',
            cancelButtonText: 'Cancelar',
            allowOutsideClick: false,
            preConfirm: function() {
                var opcionSeleccionada = document.getElementById('swal-select').value;

                if (opcionSeleccionada === '') {
                    Swal.showValidationMessage('Debes seleccionar una opción');
                }

                return opcionSeleccionada;
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                var opcionSeleccionada = result.value;
                archivar_turno(opcionSeleccionada);
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Operación cancelada', '', 'warning');
            }
        });
    }

    $.ajax({
        type: "POST",
        data: {
            'sucursal': sucursal
        },
        url: "../obtener_nombres/obtener_nombres.php",
        success: function(respuesta) {
            //notyf.success(respuesta);
        }
    });
</script>