<script>
    var servicios = [];
    var mercancias = [];
    var id_solicitud;
    var isEnabled = true;

    async function cargarTodoEnSecuencia() {
        await cargar_select_odoo('../odoo_get/getRutas.json', '#x_ruta_destino');
        await cargar_select_odoo('../clientes/clientes.json', '#partner_id');
        await cargar_select_odoo('../tms.waybill.category/tms_watbill_category.php', '#waybill_category');
        await cargar_select_odoo_code('../transporte_internacional/paises.json', '#merchandice_country_origin_id');
        await cargar_select_odoo_code('../transporte_internacional/getClavetransporte.php', '#tipo_transporte_entrada_salida_id');
        await cargar_select_odoo_code('../complemento_cp/getSatUDM.php', '#sat_uom_id');
        await cargar_select_odoo_code('../complemento_cp/getMaterialesPeligrosos.php', '#hazardous_key_product_id');
        await cargar_select_odoo_code('../complemento_cp/getEmbalaje.php', '#tipo_embalaje_id');
        await cargar_select_odoo_code('../servicios/get_contenedores.php', '#product_id');
        cargar_contenido();
    }

    cargarTodoEnSecuencia();

    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
    }

    function cargar_contenido() {
        if (getParameterByName('id')) {
            var id = getParameterByName('id');
            id_solicitud = id;
            $("#id_solicitud").val(id);
            $("h1.page-header-title").text('Folio: ' + id);

            $.ajax({
                url: '../odoo_get/getCampos.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    'id': id
                },
                success: function(data) {
                    const fieldNames = Object.keys(data[0]);
                    fieldNames.forEach(fieldName => {
                        const fieldValue = data[0][fieldName];

                        if (fieldName == 'state') {
                            comprobar_estado(fieldValue);
                        }

                        if (fieldValue !== true && fieldValue !== false) {
                            if (Array.isArray(fieldValue) && fieldValue.length > 0) {
                                console.log(fieldName + '-' + fieldValue);

                                if (fieldName == 'departure_address_id') {
                                    crear_select('departure_address_id', fieldValue);
                                } else if (fieldName == 'arrival_address_id') {
                                    crear_select('arrival_address_id', fieldValue);
                                } else {
                                    $("#" + fieldName).val(fieldValue[0]).change();
                                    $("#" + fieldName).select2({
                                        width: '100%'
                                    });
                                }
                            } else {
                                $("#" + fieldName).val(fieldValue).change();
                            }
                        } else {
                            var input = document.getElementById(fieldName);
                            if (input.type === 'checkbox') {
                                $("#" + fieldName).prop("checked", fieldValue);
                            } else if (input.type === 'text') {} else {
                                console.log('El elemento NO es de tipo checkbox.');
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                }
            });

            llamar_mercancias(id_solicitud);
            llamar_servicios(id_solicitud);

            //deshabilitar_form();

        } else {
            console.log("La variable 'id' no está presente en la URL.");
            $("#actualizar_solicitud").show();
        }
    }

    function crear_select(id_select, fieldValue) {
        var select = document.getElementById(id_select);
        while (select.options.length > 0) {
            select.remove(0);
        }
        var nuevaOpcion = document.createElement("option");
        nuevaOpcion.text = fieldValue[1];
        nuevaOpcion.value = fieldValue[0];
        nuevaOpcion.selected = true;
        select.add(nuevaOpcion);
    }

    $("#editar_solicitud").click(function() {
        $("#aprobar_solicitud").hide();
        $("#editar_solicitud").hide();
        $("#actualizar_solicitud").show();
        habilitar_form();
    });

    $("#actualizar_solicitud").click(function() {
        var datos = $("#form_solicitud").serialize();
        console.log(mercancias);
        console.log(servicios);
        if (validarCamposLlenos()) {

            $.ajax({
                type: "POST",
                data: datos,
                url: "../odoo/insert_update_registro.php",
                success: function(respuesta) {
                    var objetoJSON = JSON.parse(respuesta);
                    if ((objetoJSON.status == "correcto")) {

                        if (objetoJSON.accion == "create") {
                            id_solicitud = objetoJSON.respuesta;
                            $("#id_solicitud").val(objetoJSON.respuesta);
                            $("h1.page-header-title").text('Folio: ' + objetoJSON.respuesta);
                            notyf.success('Solicitud creada correctamente.');
                        } else if (objetoJSON.accion == "write") {
                            notyf.success('Solicitud modificada correctamente.');
                        }

                        $.ajax({
                            type: "POST",
                            data: {
                                'id_solicitud': id_solicitud,
                                'mercancias': mercancias
                            },
                            url: "../complemento_cp/guardar_mercancias.php",
                            success: function(respuesta) {
                                if (!isNaN(respuesta)) {
                                    //notyf.success('Complemento carta porte registrado.');
                                    llamar_mercancias(id_solicitud);
                                } else {
                                    notyf.error('Error en CCP: ' + respuesta);
                                }
                            }
                        });

                        $.ajax({
                            type: "POST",
                            data: {
                                'id_solicitud': id_solicitud,
                                'servicios': servicios
                            },
                            url: "../servicios/crear_servicio.php",
                            success: function(respuesta) {
                                if (!isNaN(respuesta)) {
                                    //notyf.success('Servicio registrado.');
                                    llamar_servicios(id_solicitud);
                                } else {
                                    notyf.error('Error en Servicios: ' + respuesta);
                                }
                            }
                        });

                        //deshabilitar_form();
                        //$("#editar_solicitud").show();
                        $("#actualizar_solicitud").show();

                    } else {
                        notyf.error(respuesta);
                    }
                }
            });

        } else {
            notyf.error("Por favor, complete todos los campos antes de guardar la solicitud.");
        }
    });

    function cargar_select_odoo(url, id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(datos) {
                    $.each(datos, function(index, item) {
                        $(id).append($('<option>', {
                            value: item.id,
                            text: item.name
                        }));
                    });

                    $(id).select2({
                        width: '100%'
                    });

                    resolve();
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                    reject(error);
                }
            });
        });
    }

    function cargar_select_odoo_code(url, id) {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(datos) {
                $.each(datos, function(index, item) {
                    $(id).append($('<option>', {
                        value: item.id,
                        text: item.code + '  ' + item.name
                    }));
                });

                $(id).select2({
                    width: '100%'
                });
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    }

    function habilitar_form() {
        var formulario = document.getElementById("form_solicitud");
        var elementos = formulario.elements;

        for (var i = 0; i < elementos.length; i++) {
            elementos[i].disabled = false;
        }

        isEnabled = false;

        $('td .delete-button').each(function() {
            $(this).prop('disabled', isEnabled);
        });
    }

    function deshabilitar_form() {
        var formulario = document.getElementById("form_solicitud");
        var elementos = formulario.elements;

        for (var i = 0; i < elementos.length; i++) {
            if (elementos[i].getAttribute("role") !== "tab") {
                elementos[i].disabled = true;
            }
        }

        isEnabled = true;

    }

    function validarCamposLlenos() {
        var camposLlenos = true;
        $("form").each(function() {
            var formId = $(this).attr("id");
            var validar = $(this).attr("validar");
            $('#' + formId + ' input, #' + formId + ' select').each(function() {});

            var formNoValidation = $(this).attr("form-no-validation");
            if (formId == 'form_solicitud') {
                if (formNoValidation == undefined && formNoValidation == null) {
                    $("#" + formId + " input, #" + formId + " select, #" + formId + " textarea").each(function() {
                        console.log(formId);
                        if ($(this).val() === '' && !$(this).is('[data-no-validation]')) {
                            camposLlenos = false;
                            console.log($(this).attr('id') + ' ' + $(this).attr('name'));
                            $(this).addClass('border-bottom error-border-danger');
                            $(this).closest('.row').find('label[for="' + $(this).attr('id') + '"]').addClass('error_danger fw-semibold');
                        } else {
                            $(this).removeClass('border-bottom error-border-danger');
                            $(this).closest('.row').find('label[for="' + $(this).attr('id') + '"]').removeClass('error_danger fw-semibold');
                        }
                    });
                }
            }
        });
        return camposLlenos;
    }

    function validarForm(formId) {
        var camposLlenos = true;
        $("#" + formId + " input, #" + formId + " select").each(function() {
            if (!$(this).is('[data-no-validation]') && $(this).val() === '') {
                camposLlenos = false;
                $(this).addClass('border-bottom error-border-danger');
                $(this).closest('.row').find('label[for="' + $(this).attr('id') + '"]').addClass('error_danger fw-semibold');
            } else {
                $(this).removeClass('border-bottom error-border-danger');
                $(this).closest('.row').find('label[for="' + $(this).attr('id') + '"]').removeClass('error_danger fw-semibold');
            }
        });
        return camposLlenos;
    }

    function comprobar_material_peligroso() {
        var opcionSeleccionada = $('#hazardous_material').val();
        if (opcionSeleccionada === "Sí") {
            $('#hazardous_key_product_id').prop('disabled', false).show();
            var elemento = document.getElementById('hazardous_key_product_id');
            elemento.removeAttribute('data-no-validation', '');
        } else if (opcionSeleccionada === "No") {
            $('#hazardous_key_product_id').prop('disabled', true).hide();
            $('#hazardous_key_product_id').val('');
            var elemento = document.getElementById('hazardous_key_product_id');
            elemento.setAttribute('data-no-validation', '');
        }
    }

    $('#hazardous_material').change(function() {
        comprobar_material_peligroso();
    });

    $("#subir_excel").click(function() {
        var formData = new FormData();
        var file = $('#archivo')[0].files[0];

        formData.append('archivo', file);

        $.ajax({
            url: '../lineas_excel/read.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                notyf.success('Analizando archivo...');
                try {
                    var jsonData = JSON.parse(response);
                    var keys = Object.keys(jsonData);

                    keys.forEach(function(key) {
                        mercancias.push({
                            id: 0,
                            description: jsonData[key]['descripcion_mercancia'],
                            quantity: jsonData[key]['cantidad'],
                            sat_product_id: jsonData[key]['clave_producto_sat'],
                            sat_uom_id: jsonData[key]['clave_udm_sat'],
                            weight_charge: jsonData[key]['peso_kg'],
                            hazardous_material: jsonData[key]['material_peligroso'],
                            hazardous_key_product_id: jsonData[key]['clave_material_peligroso'],
                            dimensions_charge: jsonData[key]['dimensiones'],
                            tipo_embalaje_id: jsonData[key]['tipo_embalaje'],
                        });
                        actualizar_tabla_mercancias();
                        $("#abrir_modal_excel").modal('hide');
                    });
                } catch (e) {
                    Swal.fire({
                        icon: "error",
                        title: "No se pudo procesar el archivo debido a que algunas validaciones no se cumplieron.",
                        html: response,
                    });
                }
            },
            error: function(xhr, status, error) {
                notyf.error('Error al enviar archivo:', error);
            }
        });
    });

    $("#aprobar_solicitud").click(function() {
        $.ajax({
            url: '../odoo/aprobar_solicitud.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                if (response.estado == 'error') {
                    notyf.error(response.mensaje);
                } else if (response.estado == 'correcto') {
                    notyf.success(response.mensaje);
                    comprobar_estado(response.name);
                }
            },
            error: function(xhr, status, error) {
                notyf.error('Error', error);
            }
        });
    });

    function comprobar_estado(state) {
        var elemento = document.getElementById("name_cp");
        if (state == 'cancel') {
            elemento.innerHTML = 'Cancelado';
            elemento.classList.add("bg-secondary");
            $("#editar_solicitud").hide();
        } else if (state == 'approved') {
            elemento.innerHTML = 'Aprobado';
            elemento.classList.add("bg-primary");
            $("#editar_solicitud").show();
            $("#abrir_archivos").show();
        } else if (state == 'confirmed') {
            elemento.innerHTML = 'Confirmado';
            elemento.classList.add("bg-primary");
            $("#editar_solicitud").hide();
            $("#abrir_archivos").show();
        } else if (state == 'draft') {
            elemento.innerHTML = 'Borrador';
            elemento.classList.add("bg-info");
            $("#actualizar_solicitud").show();
            $("#abrir_archivos").show();
        }
    }

    var select_sat_product_id = document.getElementById("sat_product_id");
    select_sat_product_id.addEventListener("click", function(event) {
        event.preventDefault();
        $("#modal_catalogo_sat").modal('show');
        $('#spinner').show();
        $('#catalogo_sat').load('../catalogo_sat/getSatproducto.php', {
            'busqueda': ''
        }, function() {
            $('#spinner').hide();
        });
    });

    var buscadorInput = document.getElementById("buscador_sat");
    buscadorInput.addEventListener("input", function() {
        $('#spinner').show();
        var valor = buscadorInput.value;

        $('#catalogo_sat').load('../catalogo_sat/getSatproducto.php', {
            'busqueda': valor
        }, function() {
            $('#spinner').hide();
        });
    });

    var buscadorInputAddress = document.getElementById("buscador_address");
    buscadorInputAddress.addEventListener("input", function() {
        $('#spinneraddress').show();
        var valor = buscadorInputAddress.value;

        $('#addresstabla').load('../address/getAddress.php', {
            'busqueda': valor,
            'id_select': clickedID
        }, function() {
            $('#spinneraddress').hide();
        });
    });

    function mostrarOcultarInputs(id) {
        var selectValue = document.getElementById(id).value;
        var inputsDiv = document.getElementById(id + "_inputs");

        if (selectValue === "SI" || selectValue === "yes") {
            inputsDiv.style.display = "block";
            var inputs = inputsDiv.querySelectorAll("input, select");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].removeAttribute("data-no-validation");
                console.log(inputs[i]);
            }
        } else {
            inputsDiv.style.display = "none";
            var inputs = inputsDiv.querySelectorAll("input, select");
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].setAttribute("data-no-validation", "");
            }
        }
    }

    var clickedID;

    function handleSelectChange(event) {

        var clickedSelect = event.target;
        var clickedSelectId = clickedSelect.id;
        console.log("Se hizo clic en el selector con ID: " + clickedSelectId);
        clickedID = clickedSelectId

        console.log("Se hizo clic en un select");
        $("#addressmodal").modal('show');

        $('#spinneraddress').show();
        $("#addresstabla").load('../address/getAddress.php', {
            'busqueda': '',
            'id_select': clickedSelectId
        }, function() {
            $('#spinneraddress').hide();
        });
    }

    var select1 = document.getElementById("departure_address_id");
    var select2 = document.getElementById("arrival_address_id");

    select1.addEventListener("click", handleSelectChange);
    select2.addEventListener("click", handleSelectChange);


    $('#x_modo_bel').change(function() {
        var selectedOption = $(this).val();
        console.log('Opción seleccionada:', selectedOption);
        if (selectedOption == 'imp') {
            $("#departure_address_id").val(1).change();
        } else if (selectedOption == 'exp') {
            $("#arrival_address_id").val(1).change();
        }
    });

    $('#x_codigo_postal').on('input', function() {
        var codigoPostal = $(this).val();
        var regex = /^[0-9]{5}$/;

        if (regex.test(codigoPostal)) {
            notyf.success('Código postal válido');
        } else {
            noty.error('Código postal inválido');
        }
    });
</script>
<style>
    .select2-container .select2-selection {
        border: none;
        border-bottom: 1px solid #ccc;
        border-radius: 0;
        outline: none;
        border-bottom: .0625rem solid rgba(231, 234, 243, .7);
        padding: .6125rem 2.25rem .6125rem -6rem;
        padding-left: 0px;
    }

    .select2-container--default.select2-container--disabled .select2-selection--single {
        background-color: #FFFF;
        cursor: default;
        border: none;
        border-left: 0px;
    }
</style>
<script>
    $("#abrir_archivos").click(function() {
        cargar_archivos();
        $("#archivosModal").modal('show');
    });

    var myDropzone5 = new Dropzone("#dropzoneadjuntos", {
        url: '../archivos_adjuntos/enviar.php',
        paramName: "file",
        maxFiles: 5,
        acceptedFiles: ".jpg,.jpeg,.png,.gif,.pdf,.xls,.xlsx,.csv",
        autoProcessQueue: false,
        addRemoveLinks: true
    });

    $("#start-upload").click(function() {
        var files = myDropzone5.getQueuedFiles();

        if (files.length > 0) {
            var formData = new FormData();
            formData.append("id_solicitud", id_solicitud);

            for (var i = 0; i < files.length; i++) {
                formData.append("files[]", files[i]);

                (function(file) {
                    $.ajax({
                        url: "../archivos_adjuntos/enviar.php",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if (!isNaN(response)) {
                                notyf.success('Archivo enviado correctamente.');
                                myDropzone5.removeFile(file);
                                cargar_archivos();
                            } else {
                                notyf.error('Archivo no enviado.');
                                cargar_archivos();
                            }
                        }
                    });
                })(files[i]);
            }
        } else {
            notyf.error('No hay archivos en el área de envío');
        }
    });

    function cargar_archivos() {
        $.ajax({
            url: "../archivos_adjuntos/enviados.php",
            type: "POST",
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                $("#filesenviados").html(response);
            }
        });
    }

    function aprobar() {
        $.ajax({
            url: "../acciones/aprobar.php",
            type: "POST",
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                notyf.error(response);
            }
        });
    }

    function confirmar() {
        $.ajax({
            url: "../acciones/confirmar.php",
            type: "POST",
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                notyf.error(response);
            }
        });
    }

    function crear_viaje() {
        $.ajax({
            url: "../acciones/crear_viaje.php",
            type: "POST",
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                notyf.error(response);
            }
        });
    }

    function duplicar() {
        $.ajax({
            url: "../acciones/duplicar.php",
            type: "POST",
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                if (!isNaN(Number(response))) {
                    notyf.success('Solicitud duplicada, folio: ' + response);
                } else {
                    notyf.error('Approval failed.');
                }
            }
        });
    }

    function imprimir() {
        $.ajax({
            url: "../acciones/imprimir.php",
            type: "POST",
            data: {
                'id_solicitud': id_solicitud
            },
            success: function(response) {
                notyf.error(response);
            }
        });
    }
</script>