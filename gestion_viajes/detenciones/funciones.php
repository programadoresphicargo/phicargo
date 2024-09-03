<script>
    $('#btnatenderdetencion').click(function() {

        let esValido = true;
        let camposVacios = [];
        let formID = "#form_registro_detencion";

        $(`${formID} .required`).each(function() {
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
            var datos = $(formID).serialize();
            $.ajax({
                url: '../../gestion_viajes/detenciones/atender_detencion.php',
                type: 'POST',
                data: datos,
                success: function(response) {
                    if (response == '1') {
                        notyf.success('Detencion atendida correctamente');
                        notyf.open({
                            type: 'info',
                            message: 'Enviando a cliente.'
                        });
                        enviar_estatus_detencion();
                    } else {
                        notyf.error('Error: ');
                        notyf.error(response);
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
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

    function enviar_estatus_detencion() {

        var datos = $("#form_registro_detencion").serialize();
        var datos_obj = $.deparam(datos);

        datos_obj.id = $('#id_viaje_detencion').val();
        datos_obj.id_status = 12;
        datos_obj.status_nombre = 'Detención';
        datos_obj.comentarios = 'Motivo de detencion:  ' + $('#motivo_detencion option:selected').text() + ', tiempo detenido en minutos: ' + $("#tiempo_detenido").val() + ', Comentarios: ' + $('#comentarios_detencion').val();

        $.ajax({
            url: '../../gestion_viajes/algoritmos/envio_manual.php',
            type: 'POST',
            data: datos_obj,
            success: function(response) {
                if (response == '1') {
                    notyf.success('Estatus enviado.');
                    $("#control_detencion").modal('hide');
                    $('#form_registro_detencion')[0].reset();

                    alertar_reportes_detenciones();
                } else {
                    notyf.error('Error: ');
                    notyf.error(response);
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    }
</script>