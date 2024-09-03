<script>
    $("#abrir_lineas_complemento").click(function() {
        $("#modallineascomplemento").modal('show');
        $("#actualizar_mercancia").hide();
        $("#guardar_mercancia").show();
        document.getElementById("formlc").reset().change();
    });

    $("#guardar_mercancia").click(function() {
        if (validarForm('formlc') == true) {
            ingresar_mercancia();
        } else {
            notyf.error("Por favor, complete todos los campos.");
        }
    });

    $("#actualizar_mercancia").click(function() {
        if (validarForm('formlc') == true) {
            actualizar_linea_cp();
        } else {
            notyf.error("Por favor, complete todos los campos.");
        }
    });

    function ingresar_mercancia() {
        var id = 0;
        var description = $('#description').val();
        var dimensions_charge = $('#dimensions_charge').val();
        var quantity = $('#quantity').val();
        var weight_charge = $('#weight_charge').val();
        var hazardous_material = $('#hazardous_material').val();

        mercancias.push({
            id: id,
            description: description,
            dimensions_charge: dimensions_charge,
            quantity: quantity,
            sat_product_id: [$('#sat_product_id').val(), $('#sat_product_id option:selected').text()],
            sat_uom_id: [$('#sat_uom_id').val(), $('#sat_uom_id option:selected').text()],
            weight_charge: weight_charge,
            hazardous_material: [$('#hazardous_material').val(), $('#hazardous_material option:selected').text()],
            hazardous_key_product_id: $('#hazardous_key_product_id').val() !== '' ? [$('#hazardous_key_product_id').val(), $('#hazardous_key_product_id option:selected').text()] : false,
            tipo_embalaje_id: $('#tipo_embalaje_id').val() !== '' ? [$('#tipo_embalaje_id').val(), $('#tipo_embalaje_id option:selected').text()] : false
        });
        $("#modallineascomplemento").modal('hide');
        actualizar_tabla_mercancias();
    }

    function actualizar_linea_cp() {
        var formulario = document.getElementById('formlc');

        var elementoEspecifico = formulario.elements[0];
        var index = elementoEspecifico.value;

        var datosFormulario = {};
        for (var i = 0; i < formulario.elements.length; i++) {
            var elemento = formulario.elements[i];

            if (elemento.tagName === 'INPUT') {
                var nombre = elemento.name;
                var valor = elemento.value;
                var text = elemento.text;
                mercancias[index][nombre] = valor;
            } else if (elemento.tagName === 'SELECT') {
                var nombre = elemento.name;
                var valor = elemento.value;
                var textoSeleccionado = elemento.options[elemento.selectedIndex].text;
                mercancias[index][nombre] = [valor, textoSeleccionado];
            }
        }

        $("#modallineascomplemento").modal('hide');
        actualizar_tabla_mercancias();
    }

    function llamar_mercancias(id) {
        $.ajax({
            url: '../odoo_get/getMercancia.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'id': id
            },
            success: function(data) {
                mercancias = [];
                for (var i = 0; i < data.length; i++) {
                    var elemento = data[i];

                    var id = elemento.id;
                    var description = elemento.description;
                    var quantity = elemento.quantity;
                    var sat_product_id = elemento.sat_product_id;
                    var sat_uom_id = elemento.sat_uom_id;
                    var weight_charge = elemento.weight_charge;
                    var hazardous_material = elemento.hazardous_material;
                    var hazardous_key_product_id = elemento.hazardous_key_product_id;
                    var dimensions_charge = elemento.dimensions_charge;
                    var tipo_embalaje_id = elemento.tipo_embalaje_id;

                    mercancias.push({
                        id: id,
                        description: description,
                        quantity: quantity,
                        sat_product_id: sat_product_id,
                        sat_uom_id: sat_uom_id,
                        weight_charge: weight_charge,
                        hazardous_material: [hazardous_material, hazardous_material],
                        hazardous_key_product_id: hazardous_key_product_id,
                        dimensions_charge: dimensions_charge,
                        tipo_embalaje_id: tipo_embalaje_id,
                    });
                    actualizar_tabla_mercancias();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    }

    function actualizar_tabla_mercancias() {
        var tbody = $('#tabla_lineas_complemento tbody');
        tbody.empty();

        $.each(mercancias, function(index, item) {
            var row = $('<tr>');

            row.click(function() {
                if (!isEnabled == true) {
                    $("#actualizar_mercancia").show();
                    $("#guardar_mercancia").hide();
                } else {
                    $("#actualizar_mercancia").hide();
                    $("#guardar_mercancia").hide();
                }
                var objeto = mercancias[index];
                $("#modallineascomplemento").modal('show');
                $("#id_mercancia").val(index);
                for (var campo in objeto) {
                    if (objeto[campo] != false) {
                        if (campo == 'sat_product_id') {
                            console.log(objeto[campo][0] + ' - ' + objeto[campo][1]);
                            var select = document.getElementById("sat_product_id");
                            while (select.options.length > 0) {
                                select.remove(0);
                            }
                            var nuevaOpcion = document.createElement("option");
                            nuevaOpcion.text = objeto[campo][1];
                            nuevaOpcion.value = objeto[campo][0];
                            nuevaOpcion.selected = true;
                            select.add(nuevaOpcion);
                        } else {
                            $("#" + campo).val(objeto[campo]).change();
                        }
                    }
                }

                comprobar_material_peligroso();
            });

            $('<td>').text(item.id).appendTo(row);
            $('<td>').text(item.description).appendTo(row);
            $('<td>').text(item.dimensions_charge).appendTo(row);
            $('<td>').text(Array.isArray(item.sat_product_id) && item.sat_product_id.length > 1 ? item.sat_product_id[1] : item.sat_product_id).appendTo(row);
            $('<td>').text(item.quantity).appendTo(row);
            $('<td>').text(Array.isArray(item.sat_uom_id) && item.sat_uom_id.length > 1 ? item.sat_uom_id[1] : item.sat_uom_id).appendTo(row);
            $('<td>').text(item.weight_charge).appendTo(row);
            $('<td>').text(item.hazardous_material).appendTo(row);
            $('<td>').text(Array.isArray(item.hazardous_key_product_id) && item.hazardous_key_product_id.length > 1 ? item.hazardous_key_product_id[1] : '').appendTo(row);
            $('<td>').text(Array.isArray(item.tipo_embalaje_id) && item.tipo_embalaje_id.length > 1 ? item.tipo_embalaje_id[1] : '').appendTo(row);
            var deleteButton = $('<button>').addClass('btn btn-danger btn-xs').attr('type', 'button').append('<i class="bi bi-trash"></i>').prop('disabled', isEnabled).click(function() {
                eliminar_mercancia(index);
            });
            $('<td>').append(deleteButton).appendTo(row);
            tbody.append(row);
        });
    }


    function eliminar_mercancia(index) {
        event.stopPropagation();
        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas eliminar esta mercancía?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                mercancias.splice(index, 1);
                actualizar_tabla_mercancias();
            }
        });
    }
</script>