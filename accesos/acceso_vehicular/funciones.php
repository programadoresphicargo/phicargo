<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tu función a ejecutar
        miFuncion2();
    });

    function miFuncion2() {
        console.log("Ejecutado al inicio, antes de todo.");
        // Código de la función
        getEmpresas();
    }
</script>

<script>
    $('#id_empresa').on('change click', function() {
        var selectedOption = $(this).val();
        if (selectedOption === 'nueva') {
            $("#canvas_empresas").modal('show');
        }
        console.log('Select cambiado o clickeado');
    });

    var registrosArray = [];

    function getEmpresas(callback) {
        var select = $("#id_empresa");
        select.empty();
        select.append('<option value=""></option>');
        select.append('<option value="nueva">Añadir una opción</option>');

        $.ajax({
            url: '../empresas/getEmpresas.php',
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, value) {
                    select.append('<option value="' + value.id_empresa + '">' + value.nombre_empresa + '</option>');
                });
                if (callback) callback(); // Llama al callback si existe
            },
            error: function(xhr, status, error) {
                console.error('Error en la consulta AJAX: ' + error);
            }
        });
    }

    getEmpresas();

    var url = window.location.href;

    function ver_historial(id) {
        $("#historial").load('historial_cambios.php', {
            'id': id
        });
    }

    getEmpresas(function() {
        if (url.indexOf('id') !== -1) {
            console.log('La variable "miVariable" está presente en la URL.');
            var valorVariable = obtenerValorDeVariable('id');
            console.log('Valor de "miVariable": ' + valorVariable);
            obtener_info(valorVariable);
            $("#id_acceso").val(valorVariable).change();
            $('#form_acceso :input').prop('disabled', true);
            ver_historial(valorVariable);
            $('.page-header-title').text('Acceso AV-' + valorVariable);
            cargar_visitantes_2(valorVariable);
        } else {
            $("#btnRegistrar").show();
            $("#id_acceso").val(0);
            console.log('La variable "miVariable" no está presente en la URL.');
            $('.page-header-title').text('Nuevo acceso');
        }
    });


    function cargar_visitantes_2(id_acceso) {
        $.ajax({
            data: {
                id_acceso: id_acceso
            },
            url: 'consultar_visitantes.php',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $('#registrosTable tbody').empty();
                $.each(data, function(index, record) {
                    $('#registrosTable tbody').append('<tr><td>' + record.id_visitante + '</td><td>' + record.nombre_visitante + '</td><td><button class="btn btn-primary btn-xs" type="button" onclick="eliminar_visitante(' + record.id_visitante + ')"><i class="bi bi-x"></i></button></td></tr>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }

    function eliminar_visitante(id_visitante) {
        $.ajax({
            data: {
                id_visitante: id_visitante
            },
            url: 'eliminar_visitante.php',
            type: 'POST',
            success: function(data) {
                cargar_visitantes_2(valorVariable);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }

    function obtenerValorDeVariable(variable) {
        var queryString = url.split('?')[1];

        if (!queryString) {
            return null;
        }

        var pares = queryString.split('&');

        for (var i = 0; i < pares.length; i++) {
            var par = pares[i].split('=');
            if (par[0] === variable) {
                return decodeURIComponent(par[1]);
            }
        }

        return null;
    }

    $("#registros").load('tabla.php');

    $("#btnRegistrar").click(function() {
        if (verificarInputs() == true) {
            registrar_acceso();
        }
    });

    $("#btnEditar").click(function() {
        $("#btnEditar").hide();
        $("#btnSave").show();
        $('#form_acceso :input').prop('disabled', false);
    });

    $("#btnSave").click(function() {
        if (verificarInputs() == true) {
            guardar_acceso();
        }
    });

    $("#abrir_visitantes").click(function() {
        $("#modal_personas").modal('show');
    });

    $("#btnValidar").click(function() {
        var pin = prompt("Ingrese su PIN de validación:");
        if (pin !== null) {
            $.ajax({
                url: "../validacion_vigilancia/validacion.php",
                data: {
                    'pin': pin,
                },
                dataType: 'json',
                type: "POST",
                success: function(response) {
                    if (response.respuesta == 1) {

                        $('#form_acceso :input').prop('disabled', false);
                        var datos = $("#form_acceso").serialize();
                        $.ajax({
                            url: "validar_acceso.php",
                            data: {
                                'datos': datos,
                                'id_usuario': response.id_usuario
                            },
                            type: "POST",
                            success: function(response) {
                                if (response == 1) {
                                    notyf.success("Acceso validado correctamente.");
                                    $('#form_acceso :input').prop('disabled', true);
                                    ver_historial(valorVariable);
                                    obtener_info(valorVariable);
                                } else {
                                    notyf.error("Error en la solicitud" + response);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
                            }
                        });

                    } else {
                        notyf.error('PIN invalido');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
                }
            });
        }
    });

    $("#btnSalida").click(function() {

        var pin = prompt("Ingrese su PIN de validación:");
        if (pin !== null) {
            $.ajax({
                url: "../validacion_vigilancia/validacion.php",
                data: {
                    'pin': pin,
                },
                dataType: 'json',
                type: "POST",
                success: function(response) {
                    if (response.respuesta == 1) {

                        $('#form_acceso :input').prop('disabled', false);
                        var datos = $("#form_acceso").serialize();
                        $.ajax({
                            url: "validar_salida.php",
                            data: {
                                'datos': datos,
                                'id_usuario': response.id_usuario
                            },
                            type: "POST",
                            success: function(response) {
                                if (response == 1) {
                                    notyf.success("Salida registrada correctamente.");
                                    $('#form_acceso :input').prop('disabled', true);
                                    ver_historial(valorVariable);
                                    obtener_info(valorVariable);
                                } else {
                                    notyf.error("Error en la solicitud" + response);
                                }
                            },

                            error: function(jqXHR, textStatus, errorThrown) {
                                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
                            }
                        });
                    } else {
                        notyf.error('PIN invalido');
                    }
                }
            });
        }
    })

    function verificarInputs() {
        var formulario = document.getElementById('form_acceso');
        var elementos = formulario.elements;

        for (var i = 0; i < elementos.length; i++) {
            var elemento = elementos[i];

            if ((elemento.tagName.toLowerCase() === 'input' || elemento.tagName.toLowerCase() === 'select') && elemento.value.trim() === '' && !elemento.hasAttribute('data-no-validation')) {
                elemento.classList.add('border-bottom');
                elemento.classList.add('border-danger');
            } else {
                elemento.classList.remove('border-danger');
            }
        }

        if (!formulario.querySelector('.border-danger')) {
            return true;
        } else {
            notyf.error('Campos obligatorios.');
        }
    }

    function miFuncion() {
        alert('Todos los campos están llenos. Ejecutar la lógica deseada aquí.');
    }

    flatpickr("#fecha_entrada", {
        enableTime: true,
        locale: "es" // Configura el idioma (en este caso, español)
    });

    function registrar_acceso() {

        var checkboxes = document.getElementsByName('lugares');
        var opcionesSeleccionadas = [];

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                opcionesSeleccionadas.push(checkbox.value);
            }
        });

        var listaJSON = JSON.stringify(opcionesSeleccionadas);
        console.log(listaJSON);

        var datos = $("#form_acceso").serialize();
        $.ajax({
            url: "registrar_acceso.php",
            data: {
                'datos': datos,
                'lugares': listaJSON,
                'visitantes': registrosArray
            },
            type: "POST",
            dataType: "json",
            success: function(response) {
                if (response.status === 1) {
                    notyf.success("Registro guardado correctamente");
                    var currentUrl = window.location.href;
                    var newUrl = currentUrl + "?id=" + response.id_insertado;
                    window.history.replaceState({}, document.title, newUrl);
                    valorVariable = response.id_insertado;
                    ver_historial(response.id_insertado);
                    obtener_info(response.id_insertado);
                } else {
                    notyf.error("Error en la solicitud" + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }

    function guardar_acceso() {

        var checkboxes = document.getElementsByName('lugares');
        var opcionesSeleccionadas = [];

        checkboxes.forEach(function(checkbox) {
            if (checkbox.checked) {
                opcionesSeleccionadas.push(checkbox.value);
            }
        });

        var listaJSON = JSON.stringify(opcionesSeleccionadas);
        console.log(listaJSON);

        var datos = $("#form_acceso").serialize();
        $.ajax({
            url: "guardar_acceso.php",
            data: {
                'datos': datos,
                'lugares': listaJSON,
                'visitantes': registrosArray
            },
            type: "POST",
            dataType: "json",
            success: function(response) {
                if (response.status === 1) {
                    notyf.success("Registro modificado correctamente");
                    $('#form_acceso :input').prop('disabled', true);
                    $("#btnEditar").show();
                    $("#btnSave").hide();
                } else {
                    notyf.error("Error en la solicitud" + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }

    function obtener_info(id) {
        $.ajax({
            url: "getAcceso.php",
            data: {
                'id': id
            },
            type: "POST",
            dataType: "json",
            success: function(response) {
                $("#id_acceso").val(response[0].id_acceso).change();
                $("#tipo_identificacion").val(response[0].tipo_identificacion).change();
                $("#nombre_operador").val(response[0].nombre_operador).change();
                $("#id_empresa").val(response[0].id_empresa).change();
                $("#motivo").val(response[0].motivo).change();
                $("#fecha_entrada").val(response[0].fecha_entrada).change();
                $("#contenedor1").val(response[0].contenedor1).change();
                $("#contenedor2").val(response[0].contenedor2).change();
                $("#placas").val(response[0].placas).change();
                $("#sellos").val(response[0].sellos).change();
                $("#tipo_mov").val(response[0].tipo_mov).change();

                if (response[0].estado_acceso == 'espera') {
                    $("#btnValidar").show();
                    $("#btnSalida").hide();
                    $("#btnRegistrar").hide();
                    $("#btnEditar").show();
                } else if (response[0].estado_acceso == 'validado') {
                    $("#btnSalida").show();
                    $("#btnValidar").hide();
                    $("#btnRegistrar").hide();
                    $("#btnEditar").show();
                } else if (response[0].estado_acceso == 'salida') {
                    $("#btnValidar").hide();
                    $("#btnSalida").hide();
                    $("#btnRegistrar").hide();
                    $("#btnEditar").hide();
                }

                var opcionesArray = JSON.parse(response[0].areas);
                $.each(opcionesArray, function(index, opcion) {
                    $('input[type="checkbox"][value="' + opcion + '"]').prop('checked', true);
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }

    function cargar_visitantes() {
        $("#registroTable tbody").empty();
        $.ajax({
            url: 'datos.php',
            data: {
                'id': valorVariable
            },
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $.each(data, function(index, item) {
                    $('#registroTable tbody').append('<tr><td>' + item.id_acceso + '</td><td>' + item.nombre_visitante + '</td><td><button class="btn btn-primary btn-xs" type="button" onclick="borrar_registro(' + item.id + ')">x</button></td></tr>');
                });
            },
            error: function(error) {
                console.log('Error en la llamada AJAX: ' + error);
            }
        });
    }

    cargar_visitantes();


    function borrar_registro(id) {
        $.ajax({
            url: "eliminar.php",
            data: {
                'id': id,
            },
            type: "POST",
            success: function(response) {
                if (response == 1) {
                    notyf.success("Registro eliminado correctamente");
                    cargar_visitantes();
                } else {
                    notyf.error("Error en la solicitud" + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }
</script>