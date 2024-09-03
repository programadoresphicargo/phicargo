<script>
    var estatus = [];
    var envio_masivos = [];

    function eliminarItem(id_viaje) {
        console.log('Array original:', envio_masivos);
        id_viaje = Number(id_viaje);
        envio_masivos = envio_masivos.filter(function(item) {
            return Number(item.id_viaje) !== id_viaje;
        });
        cargar_tabla_envios_masivos();
        console.log('Actualizado envio_masivos:', envio_masivos);
    }

    function actualizarEstatus(index, selectElement) {
        var idEstatus = selectElement.value;
        var tituloEstatus = selectElement.options[selectElement.selectedIndex].text;
        envio_masivos[index].id_estatus = [idEstatus, tituloEstatus];
        console.log('Actualizado envio_masivos:', envio_masivos);
    }

    function actualizarComentarios(index, text) {
        var comentarios = text.value;
        envio_masivos[index].comentarios = comentarios;
        console.log('Actualizado envio_masivos:', envio_masivos);
    }

    $.ajax({
        url: '../envio_masivo/getEstatus.php',
        type: 'POST',
        dataType: 'json',
        success: function(data) {
            $.each(data, function(index, item) {
                estatus.push({
                    id_estatus: item.id_status,
                    estatus: item.status,
                    url: item.imagen
                });
            });
            console.log(estatus);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            notyf.error(textStatus);
        }
    });

    function cargar_tabla_envios_masivos() {
        var tbody = $('#tablaenviosmasivos tbody');
        tbody.empty();
        $.each(envio_masivos, function(index, item) {

            var selectOptions = '';
            $.each(estatus, function(i, statusItem) {
                var selected = statusItem.id_estatus == item.id_status ? 'selected' : '';
                selectOptions += '<option value="' + statusItem.id_estatus + '" ' + selected + '>' + statusItem.estatus + '</option>';
            });

            var fila = '<tr id="fila-' + item.id_viaje + '">' +
                '<td><span class="d-block h5 text-inherit mb-0">' + item.referencia + '</span></td>' +
                '<td>' + item.estado + '</td>' +
                '<td><span class="badge bg-primary rounded-pill">' + item.unidad + '</span></td>' +
                '<td>' + item.operador + '</td>' +
                '<td>' +
                '<select class="form-select" onchange="actualizarEstatus(' + index + ', this)"><option></option>' +
                selectOptions +
                '</select>' +
                '</td>' +
                '<td><textarea class="form-control" onchange="actualizarComentarios(' + index + ', this)" rows="1"></textarea></td>' +
                '<td><button class="btn btn-delete btn-danger btn-xs" onclick="eliminarItem(' + item.id_viaje + ')"><i class="bi bi-x-circle"></i></button></td>' +
                '<td id="estado-' + item.id_viaje + '"></td>' +
                '</tr>';
            tbody.append(fila);
        });
    }

    $("#abrirmodalenviomasivo").click(function() {
        $("#envio_masivo_modal").modal('show');
        $.ajax({
            url: '../envio_masivo/getViajes.php',
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                envio_masivos = [];
                $.each(data, function(index, item) {
                    envio_masivos.push({
                        id_viaje: item.id_viaje,
                        referencia: item.referencia,
                        estado: item.estado_viaje,
                        operador: item.nombre_operador,
                        unidad: item.unidad + ' [' + item.placas + ']',
                    });
                });

                cargar_tabla_envios_masivos();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error(textStatus);
            }
        });
    })

    function verificarIdStatus(envio_masivos) {
        let todoCorrecto = true;

        envio_masivos.forEach(item => {
            if (!item.hasOwnProperty('id_estatus') || !Array.isArray(item.id_estatus)) {
                todoCorrecto = false;
                notyf.error(`Selecciona un estatus valido para el viaje: ${item.referencia}`);
            }
        });

        return todoCorrecto;
    }

    $("#enviarestatusmasivos").click(function() {
        console.log(envio_masivos);
        if (verificarIdStatus(envio_masivos)) {
            Swal.fire({
                title: 'Confirmar',
                text: '¿Estás seguro de que quieres enviar estos estatus?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Confirmar envio',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.each(envio_masivos, function(index, item) {
                        $("#estado-" + item.id_viaje).html('<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>');

                        $.ajax({
                            url: '../algoritmos/envio_manual.php',
                            data: {
                                'id': item.id_viaje,
                                'id_status': item.id_estatus[0],
                                'status_nombre': item.id_estatus[1],
                                'comentarios': item.comentarios
                            },
                            type: 'POST',
                            success: function(data) {
                                if (data == '1') {
                                    notyf.success('Estatus enviado con exito viaje: ' + item.referencia);
                                    $("#estado-" + item.id_viaje).html('<i class="bi bi-check2 text-success">Enviado</i>');
                                } else {
                                    notyf.error('Error:' + data);
                                    $("#estado-" + item.id_viaje).html('<i class="bi bi-exclamation-circle text-danger">Error al enviar</i>');

                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                notyf.error(textStatus);
                            }
                        });
                    });
                }
            });
        }
    })

    const currentDate = new Date();
    const fechaISO = currentDate.toISOString().split('T')[0];
    console.log("Fecha actual en formato ISO:", fechaISO);
    var fecha = fechaISO;

    function buscar_viajes_programados() {
        notyf.success('Cargando viajes');
        $.ajax({
            url: '../viajes_programados/viajes_programados.php',
            data: {
                'fecha': fecha
            },
            method: 'POST',
            success: function(data) {
                $("#viajes-programados").html(data);
            },
            error: function() {
                notyf.error(data);
            }
        });
    }

    $("#abrirviajesprogramados").click(function() {
        $("#modal-viajes-programados").modal('show');
        buscar_viajes_programados();
    });

    var offcanvasElement = document.getElementById('offcanvas_viaje');

    offcanvasElement.addEventListener('hidden.bs.offcanvas', function() {
        buscar_viajes_programados();
    });

    flatpickr("#datepicker", {
        enableTime: false,
        dateFormat: "Y-m-d",
        defaultDate: currentDate,
        locale: "es",
        onChange: function(selectedDates, dateStr, instance) {
            console.log("Fecha seleccionada:", dateStr);
            fecha = dateStr;
            buscar_viajes_programados();
        }
    });

    consulta_universal = 'activos';

    var selectedOptions = [];
    var busqueda;

    var id_viaje_universal = '';
    var operador_universal = '';
    var placas_universal = '';
    var modo_universal = '';
    var criterioBusqueda = [];

    function cargarTabla() {
        $('#tabla').load('tabla.php', {
            'consulta': consulta_universal
        }, function() {
            notyf.success('Tablero actualizado.');
            //cargar_detenciones();
            //consultar_monitoristas();
            conteo();
        });
    }

    cargarTabla();
    setInterval(cargarTabla, 300000);

    $("#repEstadoViajes").click(function() {
        $('#modal_reporte').modal('show');
        $('#contenido_reporte').load('../../reportes/llegadas_tarde/tabla2.php');
    });

    function conteo() {
        $.ajax({
            type: "GET",
            url: "conteos.php",
            dataType: "json",
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    if (data[i].estado == 'ruta') {
                        var elemento = document.getElementById("cr");
                        if (elemento) {
                            if (data[i].count != '0') {
                                elemento.textContent = data[i].count;
                            } else {
                                elemento.style.display = "none";
                            }
                        }
                    }

                    if (data[i].estado == 'planta') {
                        var elemento = document.getElementById("cp");
                        if (elemento) {
                            if (data[i].count != '0') {
                                elemento.textContent = data[i].count;
                            } else {
                                elemento.style.display = "none";
                            }
                        }
                    }

                    if (data[i].estado == 'retorno') {
                        var elemento = document.getElementById("cre");
                        if (elemento) {
                            if (data[i].count != '0') {
                                elemento.textContent = data[i].count;
                            } else {
                                elemento.style.display = "none";
                            }
                        }
                    }

                    if (data[i].estado == 'resguardo') {
                        var elemento = document.getElementById("res");
                        if (elemento) {
                            if (data[i].count != '0') {
                                elemento.textContent = data[i].count;
                            } else {
                                elemento.style.display = "none";
                            }
                        }
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX: " + status + " - " + error);
            }
        });
    }

    conteo();
    const links = document.querySelectorAll("#myNav a");

    links.forEach(link => {
        link.addEventListener("click", function() {
            $('#myNav li.nav-item a.nav-link').removeClass('active');
            $(this).addClass('active');
            var indexSeleccionado = this.getAttribute("pes");
            console.log("Índice seleccionado: " + indexSeleccionado);
            console.log(busqueda);

            switch (indexSeleccionado) {
                case '0':
                    console.log("todo");
                    busqueda = '';
                    consulta_universal = 'todo';
                    cargar_colores();
                    break;
                case '1':
                    console.log("ruta");
                    busqueda = 'en ruta';
                    consulta_universal = 'ruta';
                    cargar_colores();
                    break;
                case '2':
                    console.log("planta");
                    busqueda = 'en planta';
                    consulta_universal = 'planta';
                    cargar_colores();
                    break;
                case '3':
                    console.log("retorno");
                    busqueda = 'retorno';
                    consulta_universal = 'retorno';
                    cargar_colores();
                    break;
                case '4':
                    console.log("disponible");
                    busqueda = 'disponible'
                    consulta_universal = 'disponibles';
                    cargar_colores();
                    break;
                case '5':
                    console.log("resguardo");
                    busqueda = 'resguardo';
                    consulta_universal = 'resguardo';
                    cargar_colores();
                    break;
                default:
                    cargar_colores();
                    //consultar_monitoristas();
                    conteo();
                    break
            }
        });
    });

    $(".dropdown-menu").on("click", function(e) {
        e.stopPropagation();
    });

    $(".dropdown-menu").on("change", "input[type='checkbox']", function() {
        var optionValue = $(this).val();

        if ($(this).is(":checked")) {
            if (selectedOptions.indexOf(optionValue) === -1) {
                selectedOptions.push(optionValue);
            }
        } else {
            var index = selectedOptions.indexOf(optionValue);
            if (index !== -1) {
                selectedOptions.splice(index, 1);
            }
        }

        if (selectedOptions.length == 0) {
            //cargar_detenciones();
            //consultar_monitoristas();
        } else {

        }
        console.log(selectedOptions);
        cargar_colores();
        //cargar_detenciones();
        //consultar_monitoristas();
        alert();
    });

    function cargar_colores() {
        console.log('Recargo tabla');
        var table = $('#tabla-datos').DataTable();
        table.destroy();

        $('#tabla-datos').DataTable({
            order: [
                [2, 'desc']
            ],
            rowGroup: {
                dataSrc: selectedOptions,
            },
            search: {
                search: busqueda
            },
            language: {
                searchPanes: {
                    layout: 'columns-6',
                    clearMessage: 'Borrar busquedas',
                    collapse: {
                        0: 'Search Options',
                        _: 'Search Options (%d)'
                    }
                }
            },
            layout: {
                topStart: {
                    buttons: [{
                            extend: 'searchPanes',
                            className: 'btn btn-primary btn-sm',
                            text: 'Busqueda avanzada',
                            layout: 'columns-6'
                        }, {
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
                        }
                    ]
                }
            },
            lengthMenu: [
                [100, -1],
                [100, "All"]
            ]
        });

        table.ajax.reload();
    }

    function consultar_monitoristas() {
        var trElements = document.querySelectorAll('#tabla-datos tr');
        var viajesAtencion = [];

        var ajaxPromises = [];

        trElements.forEach(tr => {
            var promise = $.ajax({
                type: "POST",
                data: {
                    id_viaje: tr.id,
                },
                url: "../fletes/atencion_a_viaje.php",
                success: function(respuesta) {
                    if (respuesta == '1') {
                        viajesAtencion.push(tr.id);
                        tr.classList.add('bg-primary', 'text-white');
                    } else {
                        tr.classList.remove('bg-primary', 'text-white');
                    }
                }
            });
            ajaxPromises.push(promise);
        });

        Promise.all(ajaxPromises).then(() => {
            if (viajesAtencion.length > 0) {
                var notyf = new Notyf();
                notyf.open({
                    type: 'info',
                    message: 'Viajes que necesitan de tu atención: <br>' + viajesAtencion.join('<br>')
                });
            }
        });
    }

    function cargar_detenciones() {
        $('#tabla-datos tbody tr').each(function() {
            var fila = $(this);
            var referencia = $(this).find('td:eq(1)').text();
            var unidad = $(this).find('td:eq(10)').text();
            var estado = $(this).find('td:eq(2)').text();

            if (estado == 'En Ruta' || estado == 'En Planta' || estado == 'Retorno') {
                $.ajax({
                    type: "POST",
                    data: {
                        referencia: referencia,
                        unidad: unidad,
                    },
                    url: "../detenciones/alerta_detencion.php",
                    success: function(respuesta) {
                        if (respuesta == 1) {
                            fila.find('td:eq(10)').html('<span class="badge bg-naranja text-white animate__animated animate__flash animate__infinite animate__slower">' + unidad + '</span>');
                        } else if (respuesta == 0) {
                            fila.find('td:eq(10)').addClass('');
                        }
                    }
                });
            }
        });
    }

    var datosArray = [];

    function actualizarLista() {
        var dropdownList = document.getElementById('dropdown-list');
        dropdownList.innerHTML = '';

        datosArray.forEach(function(item, index) {
            var link = document.createElement('a');
            link.classList.add('btn', 'btn-soft-dark', 'btn-xs', 'rounded-pill');
            link.innerHTML = item.texto + '   <i class="bi bi-x-circle"></i>';
            link.addEventListener('click', function() {
                datosArray.splice(index, 1);
                actualizarLista();
                sendDataToServer(datosArray);
            });
            dropdownList.appendChild(link);
        });
    }

    function crearElementos(columns) {
        var camposBusqueda = document.getElementById('campos_busqueda');

        columns.forEach(function(column) {
            var link = document.createElement('a');
            link.classList.add('dropdown-item');
            link.innerHTML = '<span>Buscar en <strong>' + column[0] + '</strong></span>';

            link.addEventListener('click', function() {

                const inputFullName = document.getElementById('fullName');
                const texto = inputFullName.value;
                const datos = {
                    texto: texto,
                    opcion: column[1]
                };
                datosArray.push(datos);
                $("#fullName").val('').change();
                $('#tabla').load('tabla.php', {
                    'consulta': consulta_universal,
                    'searchResults': datosArray
                }, function() {
                    $('#loadingCard').hide();
                });
            });

            camposBusqueda.appendChild(link);
        });
    }

    var columns = [
        ['Viaje', 'travel_id'],
        ['Carta porte', 'name'],
        ['Contenedor', 'x_reference'],
        ['Unidad', 'vehicle_id'],
    ];

    crearElementos(columns);
</script>