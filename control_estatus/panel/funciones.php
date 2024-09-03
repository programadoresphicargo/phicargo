<script>
    $(document).ready(function() {
        $("#tabla_status").load('estatus.php');

        $('#new_status').click(function() {
            $('#modal_registro').modal('show');
            $('#guardar_status').hide();
            $('#registrar_status').show();
            var form = $('#FormStatus');
            form[0].reset();
        });

        $('#registrar_status').on('click', function() {
            if ($("#estatus").val() != '') {
                var formData = new FormData();
                formData.append('status', $('#status').val());
                formData.append('tipo', $('#tipo').val());
                formData.append('tipo_terminal', $('#tipo_terminal').val());
                formData.append('avatar', $('#avatarUploader')[0].files[0]);
                formData.append('funcion', 'registrar');

                $.ajax({
                    url: 'control_estatus.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Form submitted successfully');
                        if (response == '1') {
                            notyf.success('Estatus registrado.');
                            $('#modal_registro').modal('hide');
                            $("#tabla_status").load('estatus.php');
                        } else {
                            notyf.error(response);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error submitting form: ', textStatus, errorThrown);
                        notyf.error('Error.');
                    }
                });
            } else {
                notyf.error('Falta el nombre del estatus');
            }
        });

        $('#guardar_status').click(function() {
            var formData = new FormData();
            formData.append('id_status', $('#id_status').val());
            formData.append('status', $('#status').val());
            formData.append('tipo', $('#tipo').val());
            formData.append('tipo_terminal', $('#tipo_terminal').val());
            formData.append('avatar', $('#avatarUploader')[0].files[0]);
            formData.append('funcion', 'editar');

            $.ajax({
                url: "control_estatus.php",
                method: "POST",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == '1') {
                        notyf.success('Status registrado correctamente');
                        $('#modal_registro').modal('hide');
                        $("#tabla_status").load('estatus.php');
                        var form = $('#FormStatus');
                        form[0].reset();
                    } else {
                        notyf.error('Error.');
                    }
                },
            });
        });
    });
</script>