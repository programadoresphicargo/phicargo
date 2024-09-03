<script>
    function cargar_status_enviados(busqueda) {
        $.ajax({
            type: "POST",
            data: {
                'id_viaje': id_viaje_universal,
                'busqueda': busqueda
            },
            url: "../viaje/estatus/reportes_status.php",
            success: function(respuesta) {
                $("#linea_tiempo_status").html(respuesta);
            }
        });
    }

    cargar_status_enviados('');

    function mapa() {
        $.ajax({
            type: "POST",
            data: {
                'placas': '<?php echo $placas ?>'
            },
            url: "../viaje/ultima_ubicacion.php",
            success: function(respuesta) {
                $("#ultima_ubicacion").html(respuesta);
            }
        });
    }

    mapa();

    cargar_estado(id_viaje_universal);

    $("#offpods").click(function() {
        $('#offcanvaspods').offcanvas('show');
    });

    $('#archivosdb').load('../documentacion/panel/archivos.php', {
        'id_viaje': id_viaje_universal
    });

    var myDropzone5 = new Dropzone("#dropzonepods", {
        url: '../pods/enviar.php',
        paramName: "file",
        maxFiles: 5,
        acceptedFiles: ".jpg,.jpeg,.png,.gif,.pdf",
        autoProcessQueue: false,
        addRemoveLinks: true
    });

    $("#start-upload").click(function() {
        var files = myDropzone5.getQueuedFiles();
        var tipoDoc = $("#tipo_doc").val();

        if (files.length > 0 || tipoDoc === "eir") {
            if (files.length === 0 && tipoDoc === "eir") {
                Swal.fire({
                    title: 'Confirmación',
                    text: "Está a punto de guardar un EIR vacío. ¿Desea continuar?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, enviar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        enviarFormulario();
                    }
                });
            } else {
                enviarFormulario();
            }
        } else {
            notyf.error('No hay archivos en el área de envío');
        }

        function enviarFormulario() {
            var formData = new FormData();

            formData.append("id", id_viaje_universal);
            formData.append("tipo_doc", tipoDoc);

            for (var i = 0; i < files.length; i++) {
                formData.append("files[]", files[i]);
            }

            notyf.open({
                type: 'info',
                message: 'Enviando por correo, espere un minuto y no salga de la página.'
            });

            $.ajax({
                url: "../documentacion/enviar.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == '1') {
                        notyf.success('Archivo guardado y enviado por correo electrónico.');
                        myDropzone5.removeAllFiles();
                        $('#archivosdb').load('../documentacion/panel/archivos.php', {
                            'id_viaje': id_viaje_universal
                        });
                    } else {
                        notyf.error(response);
                    }
                }
            });
        }
    });

    $("#abrir_alertas_detalle").click(function() {

        $('#alertasoffcanvas').offcanvas('show');

        $("#listado_alertas").load('../alertas/canvas/listado.php', {
            'id_viaje': id_viaje_universal
        });

        var percentComplete = 0;
        var progressBar = $('.progress-bar');
        $("#progreso_carga").show();

        var startTime = new Date().getTime();
        var progressInterval = setInterval(function() {
            var elapsedTime = new Date().getTime() - startTime;
            var maxWaitTime = 12000; // 30 segundos
            var percentComplete = Math.min(100, Math.floor((elapsedTime / maxWaitTime) * 100));
            console.log("Porcentaje de carga:", percentComplete);
            progressBar.css('width', percentComplete + '%').attr('aria-valuenow', percentComplete);
            progressBar.text(percentComplete + '% completado');
            if (percentComplete >= 100) {
                clearInterval(progressInterval);
            }
        }, 1000);

        $.ajax({
            url: '../alertas/canvas/detenciones_tiempos.php',
            type: 'POST',
            data: {
                'id_viaje': id_viaje_universal,
                'placas': placas_universal
            },
            success: function(response) {
                clearInterval(progressInterval);
                $("#detenciones_tiempos").html(response);
                notyf.success('Detenciones cargadas correctamente.');
                $("#progreso_carga").hide();
            },
            error: function(xhr, status, error) {
                notyf.error('Error al enviar el correo:', error);
                console.log(error);
            }
        });
    });

    $("#equipo_viaje").load('../detalle/equipo_viaje.php', {
        'id_viaje': id_viaje_universal,
    });

    $("#editar_equipo_canvas").click(function() {
        $("#contenido_equipo_form").load('../codigos/contenido_equipo.php', {
            'id_viaje': '<?php echo $id_viaje ?>'
        });
        $("#editor_equipo_offcanvas").offcanvas('show');
    })

    $("#checklist").click(function() {
        $("#canvas_checklist").offcanvas('show');
        $("#contenido_checklist").load('../checklist_vista_viajes/index_viaje.php', {
            'id_viaje': '<?php echo $id_viaje ?>'
        });
    })

    $.ajax({
        url: '../../aplicacion/estatus/porcentaje_cumplimiento.php',
        dataType: 'json',
        type: 'POST',
        data: {
            'id_viaje': id_viaje_universal,
            'id_operador': operador_universal
        },
        success: function(data) {
            $.each(data, function(index, item) {
                let porcentajeCumplimiento = item.porcentaje_cumplimiento;
                console.log('Ítem ' + index + ': ' + porcentajeCumplimiento);

                $('#progresscumplimiento').css('width', porcentajeCumplimiento + '%')
                    .attr('aria-valuenow', porcentajeCumplimiento)
                    .text(porcentajeCumplimiento + '%');

            });
        },
        error: function(xhr, status, error) {
            notyf.error('Error al enviar el correo:', error);
            console.log(error);
        }
    });

    $("#abrir_incidencias_canvas").click(function() {
        $('#canvas_incidencias').offcanvas('show');
    });

    function abrir_modulo_incidencia() {
        $("#modulo_incidencias").toggle();
    }

    function historial_incidencias() {
        $.ajax({
            type: "POST",
            data: {
                'id_viaje': id_viaje_universal,
            },
            url: "../incidencias/historial_viaje.php",
            success: function(respuesta) {
                $("#historial_incidencias").html(respuesta);
            }
        });
    }

    historial_incidencias();

    $('#registrar_incidencia').click(function() {
        if ($("#comentarios_incidencias").val() != '') {
            $("#FormEditar input, #FormEditar select, #FormEditar textarea").prop("disabled", false);
            var datos = $("#formIncidencia").serialize();
            var datosCombinados = datos + '&id_viaje=' + id_viaje_universal;

            $.ajax({
                url: '../incidencias/registro_incidencia.php',
                data: datosCombinados,
                type: 'POST',
                success: function(data) {
                    if (data == '1') {
                        $("#modal_incidencia").modal('hide');
                        notyf.success('Incidencia guardada correctamente');
                        $("#comentarios_incidencias").val('');
                        historial_incidencias();
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
</script>

<script>
    var map = L.map('map3').setView([21.783266490119388, -101.54152680535326], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    var polyline1;

    function addMarkersToMap(data) {

        polyline1 = L.polyline(data.coordenadas1, {
            color: 'green'
        }).addTo(map);

        var ultimaCoordenada1 = data.coordenadas1[data.coordenadas1.length - 1];
        map.setView(ultimaCoordenada1);
        var marker = L.marker(ultimaCoordenada1).addTo(map);
        console.log(ultimaCoordenada1);

    }

    $.ajax({
        url: "../fletes/getRecorrido.php",
        data: {
            id_viaje: id_viaje_universal,
        },
        type: "POST",
        dataType: "json",
        success: function(data) {
            addMarkersToMap(data);
        },
        error: function(error) {
            console.log("Error al obtener las coordenadas: " + JSON.stringify(error));
        }
    });

    $.ajax({
        url: "../odoo/comprobar_custodia.php",
        data: {
            'id_viaje': id_viaje_universal
        },
        type: "POST",
        dataType: 'json',
        success: function(data) {
            if (Array.isArray(data)) {
                data.forEach(function(item) {
                    console.log("ID:", item.id);
                    if (item.x_custodia_bel == 'yes') {
                        Swal.fire({
                            title: "Servicio con custodia",
                            text: "Recuerda llenar los datos de custodia para este servicio",
                            icon: "warning"
                        });
                    }
                });
            }
        },
        error: function(error) {
            console.log("Error al obtener las coordenadas: " + JSON.stringify(error));
        }
    });

    $("#abrir_custodia_canvas").click(function() {
        $('#canvas_custodia').offcanvas('show');
        $.ajax({
            url: "../odoo/comprobar_custodia.php",
            data: {
                'id_viaje': id_viaje_universal
            },
            type: "POST",
            dataType: 'json',
            success: function(data) {
                if (Array.isArray(data)) {
                    data.forEach(function(item) {
                        console.log("ID:", item.id);
                        $("#x_empresa_custodia").val(item.x_empresa_custodia);
                        $("#x_nombre_custodios").val(item.x_nombre_custodios);
                        $("#x_datos_unidad").val(item.x_datos_unidad);
                    });
                }
            },
            error: function(error) {
                console.log("Error al obtener las coordenadas: " + JSON.stringify(error));
            }
        });
    });

    $("#guardar_custodia").click(function() {
        var datos = $("#form_custodia").serialize();
        $.ajax({
            url: "../custodia/guardar_custodia.php",
            data: datos + '&id_viaje=' + id_viaje_universal,
            type: "POST",
            success: function(data) {
                if (data == '1') {
                    notyf.success('Información guardada correctamente');
                } else {
                    notyf.error(data);
                }
            },
            error: function(error) {
                console.log("Error al obtener las coordenadas: " + JSON.stringify(error));
            }
        });
    });
</script>