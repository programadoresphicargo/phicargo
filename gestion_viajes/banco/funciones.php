<script>

    $(document).ready(function() {
        $("#correos_registrados").load('correos.php');
    });

    console.log('prueba3d');

    $('#idcliente').select2({
        dropdownParent: $('#modal_ingresar_correo'),
        dropdownAutoWidth: true,
        width: '83%',
    });

    $('#clienteup').select2({
        dropdownParent: $('#modal_editar_correo'),
        dropdownAutoWidth: true,
        width: '83%',
    });

    $("#ingresar_correo").click(function() {
        datos = $("#FormIngresarCorreo").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "consultas/ingresar_correo.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $("#correos_registrados").load('correos.php');
                    $("#modal_ingresar_correo").modal('hide');
                    $("#nombre").val('');
                    $("#correo").val('');
                    $('#tipo').val('Destinatario').change();
                    notyf.success('Correo ingresado correctamente.');
                } else {
                    notyf.error('');
                }
            }
        });
    });


    $("#editar_correo").click(function() {
        datos = $("#FormEditarCorreo").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "consultas/editar_correo.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $("#correos_registrados").load('correos.php');
                    $("#modal_editar_correo").offcanvas('hide');
                    notyf.success('Información de correo modificada correctamente.');
                } else {
                    notyf.error('');
                }
            }
        });
    });

    $("#mostrar_modal_eliminar").click(function() {
        $("#modal_eliminar_correo").modal('show');
        $("#modal_editar_correo").offcanvas('hide');
    });

    $("#eliminar_correo").click(function() {
        datos = $("#FormEditarCorreo").serialize();
        $.ajax({
            type: "POST",
            data: datos,
            url: "consultas/eliminar_correo.php",
            success: function(respuesta) {
                if (respuesta = 1) {
                    notyf.success('Correo eliminado correctamente.');
                    $("#correos_registrados").load('correos.php');
                    $("#modal_eliminar_correo").modal('hide');
                } else {
                    notyf.error('Error, no se pudo eliminar.');
                }
            }
        });
    });

    $('#correo').keyup(function() {
        var a = $("#correo").val();
        var b = $("#idcliente").val();
        $.ajax({
            type: "POST",
            data: {
                correo: a,
                id_cliente: b
            },
            url: "consultas/duplicidad.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    jQuery('#ingresar_correo').prop("disabled", false);
                } else if (respuesta == 0) {
                    notyf.error('El correo ya esta registrado.');
                    jQuery('#ingresar_correo').prop("disabled", true);
                }
            }
        });
    });

    $('#FormIngresarCorreo').change(function() {
        var a = $("#correo").val();
        var b = $("#idcliente").val();
        $.ajax({
            type: "POST",
            data: {
                correo: a,
                id_cliente: b
            },
            url: "consultas/duplicidad.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    jQuery('#ingresar_correo').prop("disabled", false);
                } else if (respuesta == 0) {
                    notyf.error('El correo ya esta registrado.');
                    jQuery('#ingresar_correo').prop("disabled", true);
                }
            }
        });
    });
</script>