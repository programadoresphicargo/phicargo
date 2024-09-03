<script>
    $.ajax({
        url: '../reservas/consultar_datos.php',
        success: function(datos) {
            if (datos == 1) {
                Swal.fire({
                    title: 'Ingresar número celular',
                    input: 'number',
                    inputPlaceholder: 'Número celular a 10 digitos',
                    showCancelButton: true,
                    confirmButtonText: 'Guardar',
                    showLoaderOnConfirm: true,
                    preConfirm: (numero_celular) => {
                        if (numero_celular.length !== 10) {
                            Swal.showValidationMessage(
                                'El número celular debe tener 10 dígitos.'
                            );
                            return false; // Evita que se cierre el modal si la validación falla
                        }

                        return $.ajax({
                            url: '../reservas/guardar_datos.php',
                            type: 'POST',
                            data: {
                                'numero_celular': numero_celular
                            }
                        }).then((data) => {
                            if (data == 1) {
                                notyf.success('Informacion actualizada correctamente.');
                            } else {
                                notyf.error(data);
                            }
                        }).catch((error) => {
                            console.error('Error al obtener los datos:', error);
                            Swal.showValidationMessage(
                                `Error al obtener los datos: ${error}`
                            );
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {});
            } else {}
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener los datos:', error);
            reject(error);
        }
    });

    var productos = [];

    function esNumerico(valor) {
        return /^\d+$/.test(valor);
    }

    $("#guardar_solicitud").click(function() {
        if (validarCamposLlenos()) {
            if (productos.length != 0) {
                var datos = $("#form_solicitud").serialize();
                $.ajax({
                    type: "POST",
                    data: datos,
                    url: "../odoo/guardar.php",
                    success: function(respuesta) {
                        if (esNumerico(respuesta)) {
                            $.ajax({
                                type: "POST",
                                data: {
                                    'id_solicitud': respuesta
                                },
                                url: "../correo/envio.php",
                                success: function(respuesta) {
                                    notyf.success(respuesta);
                                }
                            });
                            $.ajax({
                                type: "POST",
                                data: {
                                    'id_solicitud': respuesta,
                                    'productos': productos
                                },
                                url: "../odoo/crear_producto.php",
                                success: function(respuesta) {
                                    notyf.success(respuesta);
                                }
                            });
                            //window.location.href = "confirmacion.php?id_solicitud=" + respuesta;
                            notyf.success('Solicitud nueva creada, folio:' + respuesta);
                        } else {
                            notyf.error(respuesta);
                        }
                    }
                });
            } else {
                notyf.error('Añade al menos un producto.');
            }
        } else {
            notyf.error("Por favor, complete todos los campos antes de guardar la solicitud.");
        }
    });

    function validarCamposLlenos() {
        var camposLlenos = true;
        $("#form_solicitud input, #form_solicitud select").each(function() {
            if ($(this).val() === '') {
                camposLlenos = false;
                $(this).addClass('border-bottom');
                $(this).addClass('border-danger');
                $(this).addClass('border-2');
            } else {
                $(this).removeClass('border-bottom');
                $(this).removeClass('border-danger');
            }
        });
        return camposLlenos;
    }

    $("#registros").load('tabla.php');
</script>