<script>
    $("#actualizarhistorial").click(function() {
        notyf.success('Actualizando historial');
        cargar_status_enviados('');
    });

    document.querySelector('.js-form-search').addEventListener('input', function(event) {
        var searchTerm = event.target.value.trim();
        console.log(searchTerm);
        cargar_status_enviados(searchTerm);
    });


    var select2 = new TomSelect("#correoscliente");

    function cargar_correos_ligados() {
        $.ajax({
            type: "POST",
            data: {
                'id_viaje': id_viaje_universal,
                'id_cliente': cliente_universal
            },
            url: "../correos/ligar_correos/getCorreo.php",
            success: function(respuesta) {
                console.log(respuesta);
                select2.clearOptions();
                select2.addOption(respuesta);
                select2.refreshOptions();
            },
            error: function(xhr, status, error) {
                reject(error);
            }
        });
    }

    cargar_correos_ligados();

    function comprobar_operador() {
        return new Promise(function(resolve, reject) {
            $.ajax({
                type: "POST",
                data: {
                    'id': id_viaje_universal
                },
                url: "../odoo/comprobar_operador.php",
                success: function(respuesta) {
                    if (respuesta === '1') {
                        resolve(true);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "El nombre del conductor de este viaje no concuerda con el operador programado en las cartas porte ligadas, favor de actualizar los campos Conductor en viaje y Operador Prog en carta porte e intente nuevamente.",
                        });
                        resolve(false);
                    }
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    $("#Iniciar_modal").click(function() {
        $.ajax({
            url: '../disponibilidad/comprobar_disponibilidad.php',
            type: 'POST',
            data: {
                id_viaje: id_viaje_universal
            },
            success: function(response) {
                if (response == '1') {
                    mostrarConfirmacion();
                } else {
                    Swal.fire({
                        title: 'No se puede iniciar este viaje.',
                        text: 'Existe otro servicio activo con la misma unidad asignada, finalice primero ese viaje para iniciar otro.',
                        icon: 'error'
                    });
                }
            },
            error: function(xhr, status, error) {
                $('#response').html('Error: ' + error);
            }
        });
    });

    function mostrarConfirmacion() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas inciar este viaje?',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, iniciar viaje',
            cancelButtonText: 'Cancelar',
            imageUrl: '../../img/status/start.png',
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Imagen de confirmación'
        }).then((result) => {
            if (result.isConfirmed) {
                notyf.open({
                    type: 'info',
                    message: 'Iniciando viaje...'
                });
                $.ajax({
                    type: "POST",
                    data: {
                        'id': id_viaje_universal
                    },
                    url: "../odoo/comprobar_operador.php",
                    success: function(respuesta) {
                        if (respuesta == '1') {
                            $.ajax({
                                type: "POST",
                                data: {
                                    'id': id_viaje_universal,
                                    'id_status': 1,
                                    'status_nombre': 'Inicio de ruta'
                                },
                                url: "../algoritmos/envio_manual.php",
                                success: function(respuesta) {
                                    if (respuesta == 1) {
                                        notyf.success('Viaje activado.');

                                        $.ajax({
                                            type: "POST",
                                            data: {
                                                'id': id_viaje_universal
                                            },
                                            url: "../disponibilidad/disponibilidad_viaje.php",
                                            success: function(respuesta) {
                                                notyf.success('Equipo en uso.')
                                            }
                                        });

                                        $.ajax({
                                            type: "POST",
                                            data: {
                                                'id': id_viaje_universal
                                            },
                                            url: "../disponibilidad/contenedores.php",
                                            success: function(respuesta) {
                                                notyf.success('Contenedores cambian a status a: En Viaje')
                                            }
                                        });

                                        $('#tabla').load('../fletes/tabla.php', {
                                            'consulta': consulta_universal
                                        });

                                        $.ajax({
                                            type: "POST",
                                            data: {
                                                'id_viaje': id_viaje_universal
                                            },
                                            url: "../notificaciones/iniciar_viaje.php",
                                            success: function(respuesta) {
                                                notyf.success('Notificación enviada a operador.');
                                            }
                                        });

                                        cargar_estado(id_viaje_universal);
                                        cargar_status_enviados('');

                                    } else {
                                        Swal.fire({
                                            icon: "error",
                                            title: "Oops...",
                                            text: "Ocurrio un error",
                                            footer: respuesta
                                        });
                                    }
                                }

                            });
                        } else {
                            notyf.error('No se puede iniciar el viaje porque el nombre del conductor no concuerda con el operador programado en las cartas porte ligadas, favor de actualizar la información en Odoo e intentar iniciar nuevamente.');
                        }
                    }
                });
            }
        });
    }

    $("#modal_ligar_abrir").click(function() {
        comprobar_operador().then(function(resultado) {
            if (resultado == true) {
                $("#modal_ligar_correos").offcanvas('show');
                $.ajax({
                    type: "POST",
                    data: {
                        'id_viaje': id_viaje_universal
                    },
                    url: "../correos/ligar_correos/correos_ligados.php",
                    success: function(respuesta) {
                        $("#listado_correos_ligados").html(respuesta);
                    }
                });
            }
        }).catch(function(error) {
            console.error("Error al llamar a la función:", error);
        });
    });


    var steps = {
        inicio: document.getElementById('inicioStep'),
        enRuta: document.getElementById('enRutaStep'),
        enPlanta: document.getElementById('enPlantaStep'),
        enResguardo: document.getElementById('enResguardoStep'),
        retorno: document.getElementById('retornoStep'),
        finViaje: document.getElementById('finViajeStep')
    };

    function actualizarProgreso(estadoViaje) {
        switch (estadoViaje) {
            case 'ruta':
                document.getElementById('step1').classList.add('current');
                break;
            case 'planta':
                document.getElementById('step2').classList.add('current');
                break;
            case 'resguardo':
                document.getElementById('step3').classList.add('current');
                break;
            case 'retorno':
                document.getElementById('step4').classList.add('current');
                break;
            case 'finalizado':
            case 'Finalizado':
                document.getElementById('step5').classList.add('current');
                break;
            default:
                console.log('Estado de viaje no reconocido:', estadoViaje);
        }
    }

    function comprobar_correos_ligados(id_viaje, estado) {
        if (estado == 'Disponible') {
            $.ajax({
                type: "POST",
                data: {
                    id_viaje: id_viaje
                },
                url: "../correos/ligar_correos/correos_ligados_comprobacion.php",
                success: function(respuesta) {
                    if (respuesta == '1') {
                        $('#btn_enviar_status').show();
                        $('#Iniciar_modal').show();
                    } else {
                        $('#btn_enviar_status').hide();
                        $('#Iniciar_modal').hide();
                        notyf.open({
                            type: 'info',
                            message: 'No hay correos electronicos ligados a este viaje.'
                        });
                    }
                }
            });
        }
    }

    function cargar_estado(id) {
        id_viaje_universal = id;
        $.ajax({
            type: "POST",
            data: {
                'id': id
            },
            url: "../viaje/ingresar/validar.php",
            success: function(respuesta) {
                comprobar_correos_ligados(id, respuesta);
                actualizarProgreso(respuesta);
                notyf.success(respuesta);

                switch (respuesta) {
                    case 'finalizado':
                    case 'Finalizado':
                        $('#btn_enviar_status').hide();
                        $('#Finalizar_modal').hide();
                        $('#Iniciar_modal').hide();
                        $('#modal_ligar_abrir').show();
                        $('#cancelar_viaje_modal').hide();
                        $('#modal_resguardo').hide();
                        $('#reactivar_viaje').show();
                        break;

                    case 'resguardo':
                        $('#modal_resguardo').show();
                        $('#btn_enviar_status').hide();
                        $('#Finalizar_modal').hide();
                        $('#Iniciar_modal').hide();
                        $('#modal_ligar_abrir').show();
                        $('#cancelar_viaje_modal').hide();
                        $('#reactivar_viaje').hide();
                        break;

                    case 'Disponible':
                        $('#modal_ligar_abrir').show();
                        $('#Finalizar_modal').hide();
                        $('#Iniciar_modal').show();
                        $('#cancelar_viaje_modal').show();
                        $('#modal_resguardo').hide();
                        $('#reactivar_viaje').hide();
                        break;

                    case 'ruta':
                    case 'planta':
                    case 'retorno':
                        $('#modal_ligar_abrir').show();
                        $('#Finalizar_modal').show();
                        $('#Iniciar_modal').hide();
                        $('#cancelar_viaje_modal').hide();
                        $('#reactivar_viaje').hide();
                        $('#modal_resguardo').hide();
                        $('#btn_enviar_status').show();
                        break;

                    case 'Cancelado':
                        $('#btn_enviar_status').hide();
                        $('#Finalizar_modal').hide();
                        $('#Iniciar_modal').hide();
                        $('#modal_ligar_abrir').hide();
                        $('#cancelar_viaje_modal').hide();
                        $('#modal_resguardo').hide();
                        $('#reactivar_viaje').show();
                        break;

                    default:
                }
            }
        });
    }

    function goToStep(step) {
        $('.card-body').removeClass('active');
        $('#basicVerStepFormContent > div').hide();
        $('#basicVerStepFormContent > div').eq(step - 1).addClass('active').show();
    }

    $('#contenido_envio_status').load('../panel_envio/modal/contenido.php', {
        'id': id_viaje_universal
    });

    $("#btn_enviar_status").click(function() {
        goToStep(1);
        $('#modal_envio_status').offcanvas('show');
        $('#miOffcanvas').offcanvas('hide');
        $('#enviar_status').show();
        $('#reenviar_status').hide();
    });

    $("#modal_resguardo").click(function() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Realmente deseas liberar el resguardo de esta unidad? Los status automáticos se reactivarán.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, liberar resguardo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: {
                        'id': id_viaje_universal,
                        'id_status': 17,
                        'status_nombre': 'Retomando ruta',
                    },
                    url: "../algoritmos/envio_manual.php",
                    success: function(respuesta) {
                        if (respuesta == '1') {
                            notyf.success('Viaje liberado de resguardo correctamente.');

                            cargar_estado(id_viaje_universal);

                            $('#tabla').load('../fletes/tabla.php', {
                                'consulta': consulta_universal
                            });

                        } else {
                            notyf.error('Error.');
                        }
                    }
                });
            }
        });
    });

    function cargar_tabla_ligados(id_viaje) {
        $.ajax({
            type: "POST",
            data: {
                'id_viaje': id_viaje,
            },
            url: "../correos/ligar_correos/correos_ligados.php",
            success: function(respuesta) {
                $("#listado_correos_ligados").html(respuesta);
            }
        });
    }

    $("#LigarCorreo").click(function() {
        datos = $("#FormLigarCorreo").serialize();
        console.log(datos);
        $.ajax({
            type: "POST",
            data: {
                'id_viaje': id_viaje_universal,
                'id_correo': $("#correoscliente").val()
            },
            url: "../correos/ligar_correos/ligar_correo.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $('#btn_enviar_status').show();
                    $('#Iniciar_modal').show();
                    notyf.success('Correo ligado a este viaje correctamente.');
                    cargar_tabla_ligados(id_viaje_universal);
                } else {
                    notyf.error('El correo ya esta ligado a este viaje.');
                }
            }
        }, );
    });

    function finalizar_alert() {
        Swal.fire({
            title: '¿Realmente quieres finalizar este viaje?',
            text: 'Esta acción no se puede deshacer',
            imageUrl: '../../img/status/final.gif',
            imageWidth: 200,
            imageHeight: 200,
            imageAlt: 'Imagen',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, finalizar viaje',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                finalizar_viaje();
            }
        });
    }

    $("#Finalizar_modal").click(function() {
        finalizar_alert();
    });

    function liberar_contenedores(id) {
        $.ajax({
            type: "POST",
            data: {
                'id': id
            },
            url: "../disponibilidad/liberar_contenedores.php",
            success: function(respuesta) {
                console.log('LIBERANDO3..');
            }
        });
    }

    $("#modal_iniciar").click(function() {
        mostrarConfirmacion();
    });

    function finalizar_viaje() {

        var partes = placas_universal.split(" ");
        var segundaVariable = partes[1].replace(/\[|\]/g, "");

        notyf.open({
            type: 'info',
            message: 'Finalizando viaje...'
        });
        $.ajax({
            type: "POST",
            data: {
                'id': id_viaje_universal,
                'placas': segundaVariable,
                'modo': modo_universal,
                'id_status': 103,
                'status_nombre': 'Viaje finalizado'
            },
            url: "../algoritmos/envio_manual.php",
            success: function(respuesta) {

                if (respuesta == '1') {
                    cargar_estado(id_viaje_universal);
                    notyf.success('Viaje finalizado.');

                    liberar_contenedores(id_viaje_universal);

                    $('#tabla').load('../fletes/tabla.php', {
                        'consulta': consulta_universal
                    });

                    cargar_colores2();
                    cargar_detenciones();

                    $.ajax({
                        type: "POST",
                        data: {
                            'id': id_viaje_universal,
                        },
                        url: "../disponibilidad/desmontar.php",
                        success: function(respuesta) {
                            notyf.success('Equipo liberado.')
                        }
                    });

                    getCorreos();

                } else {
                    notyf.error('Error.');
                }
            }
        });
    }

    $("#cancelar_viaje").click(function() {
        $.ajax({
            type: "POST",
            data: {
                'id': id_viaje_universal
            },
            url: "../odoo/cancelacion.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $('#Iniciar_modal').hide();
                    $('#badgeCancelado').show();
                    $("#modal_cancelar").modal('toggle');
                    $('#modal_ligar_abrir').hide();
                    $('#cancelar_viaje_modal').hide();
                    $('#badgeDisponible').hide();
                    $('#reactivar_viaje').show();
                    notyf.success('Viaje cancelado correctamente.');

                    $('#tabla').load('../fletes/tabla.php', {
                        'consulta': consulta_universal
                    });

                } else {
                    notyf.error('No se pudo cancelar el viaje.');
                }
            }
        }, );
    });

    $("#reactivar_viaje").click(function() {
        $.ajax({
            type: "POST",
            data: {
                'id': id_viaje_universal
            },
            url: "../odoo/reactivar.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $('#Iniciar_modal').hide();
                    $('#badgeCancelado').hide();
                    $('#modal_ligar_abrir').show();
                    $('#cancelar_viaje_modal').show();
                    $('#badgeDisponible').show();
                    $('#reactivar_viaje').hide();

                    notyf.success('Viaje reactivado correctamente.');

                    $('#tabla').load('../fletes/tabla.php', {
                        'consulta': consulta_universal
                    });

                } else {
                    notyf.error('No se pudo cancelar el viaje.');
                }
            }
        }, );
    });

    $("#cancelar_viaje_modal").click(function() {
        $('#miOffcanvas').offcanvas('hide');
        $('#modal_cancelar').modal('show');
    });
</script>