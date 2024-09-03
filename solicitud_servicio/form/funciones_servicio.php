<script>
    $("#abrir_servicios").click(function() {
        $("#modal_servicios").modal('show');
        $("#actualizar_servicio").hide();
        $("#guardar_servicio").show();
        document.getElementById("formProductos").reset().change();
    });

    $("#guardar_servicio").on("click", function() {
        if (validarForm('formProductos') == true) {
            var weight_estimation = $("#weight_estimation").val();
            var notes = $("#notes").val();

            servicios.push({
                id: 0,
                product_id: [$("#product_id").val(), $("#product_id option:selected").text()],
                weight_estimation: weight_estimation,
                notes: notes,
            });
            actualizar_tabla_servicios();
            $("#modal_servicios").modal('hide');
        } else {
            notyf.error('Llenar toda la información solicitada');
        }
    });

    $("#actualizar_servicio").click(function() {
        if (validarForm('formProductos') == true) {
            actualizar_servicio_array();
        } else {
            notyf.error("Por favor, complete todos los campos.");
        }
    });

    function actualizar_servicio_array() {

        var formulario = document.getElementById('formProductos');

        var elementoEspecifico = formulario.elements[0];
        var index = elementoEspecifico.value;
        console.log('holi' + index);

        var datosFormulario = {};
        for (var i = 0; i < formulario.elements.length; i++) {
            var elemento = formulario.elements[i];
            console.log(elemento);

            if (elemento.tagName === 'INPUT') {
                var nombre = elemento.name;
                var valor = elemento.value;
                var text = elemento.text;
                servicios[index][nombre] = valor;
            } else if (elemento.tagName === 'SELECT') {
                var nombre = elemento.name;
                var valor = elemento.value;
                var textoSeleccionado = elemento.options[elemento.selectedIndex].text;
                servicios[index][nombre] = [valor, textoSeleccionado];
            }
        }

        $("#modal_servicios").modal('hide');
        actualizar_tabla_servicios();
    }

    function llamar_servicios(id) {
        servicios = [];
        $.ajax({
            url: '../servicios/get_servicios.php',
            type: 'POST',
            dataType: 'json',
            data: {
                'id': id
            },
            success: function(data) {
                for (var i = 0; i < data.length; i++) {
                    var elemento = data[i];

                    var id = elemento.id;
                    var product_id = elemento.product_id;
                    var product_uom = elemento.product_uom;
                    var weight_estimation = elemento.weight_estimation;
                    var dimensiones_lpg = elemento.dimensiones_plg;
                    var notes = elemento.notes;

                    servicios.push({
                        id: id,
                        product_id: product_id,
                        product_uom: product_uom,
                        weight_estimation: weight_estimation,
                        dimensiones_lpg: dimensiones_lpg,
                        notes: notes,
                    });
                    actualizar_tabla_servicios();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al obtener los datos:', error);
            }
        });
    }


    function actualizar_tabla_servicios() {
        var tbody = $('#servicios_añadidos tbody');
        tbody.empty();

        $.each(servicios, function(index, item) {
            var row = $('<tr>');

            row.click(function() {

                if (!isEnabled) {
                    $("#actualizar_servicio").show();
                    $("#guardar_servicio").hide();
                } else {
                    $("#actualizar_servicio").hide();
                    $("#guardar_servicio").hide();
                }

                console.log(index);
                $("#id_servicio").val(index);
                var objeto = servicios[index];
                $("#modal_servicios").modal('show');
                for (var campo in objeto) {
                    if (objeto[campo] != false) {
                        $("#" + campo).val(objeto[campo]).change();
                    }
                }
            });

            $('<td>').text(item.id).appendTo(row);
            $('<td>').text(Array.isArray(item.product_id) && item.product_id.length > 1 ? item.product_id[1] : item.product_id).appendTo(row);
            $('<td>').text(item.weight_estimation).appendTo(row);
            $('<td>').text(item.notes).appendTo(row);
            var deleteButton = $('<button>').addClass('btn btn-danger btn-xs').attr('type', 'button').append('<i class="bi bi-trash"></i>').prop('disabled', isEnabled).click(function() {
                eliminar_servicio(index);
            });
            $('<td>').append(deleteButton).appendTo(row);
            tbody.append(row);
        });
    }

    function eliminar_servicio(index) {
        event.stopPropagation();
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción eliminará el elemento seleccionado.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                servicios.splice(index, 1);
                actualizar_tabla_servicios();
            }
        });
    }
</script>