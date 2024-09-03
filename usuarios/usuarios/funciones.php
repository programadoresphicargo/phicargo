<script>
    $(document).ready(function() {

        $("#tabla").load('tabla.php');
        console.log('prueba');

        $("#Asignar_Permisos").click(function() {
            $.ajax({
                type: "POST",
                data: {
                    'id_usuario': $("#idusuario").val(),
                    'id_permiso': $("#id_permiso").val(),
                },
                url: "../codigo/guardar_permisos.php",
                success: function(respuesta) {
                    if (respuesta == 1) {

                        $.ajax({
                            type: "POST",
                            data: {
                                'id_usuario': $('#idusuario').val()
                            },
                            url: "tabla_permisos.php",
                            success: function(respuesta) {
                                $("#usuarios_permisos_tabla").html(respuesta);
                                notyf.success('Permiso asignado correctamente');
                            }
                        });

                    } else if (respuesta == 2) {
                        notyf.error('Permiso ya asignado');
                    } else {
                        notyf.success('No se asigno el permiso.');
                    }
                }
            });
        })

        $("#abrir_modal_ingresar_usuario").click(function() {
            $("#modal_ingresar_usuario").modal('toggle');
        });

        $("#RegistrarNuevoUsuario").click(function() {
            var formulario = $("#FormIngresarUsuario");
            datos = $("#FormIngresarUsuario").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigo/ingresar.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Usuario ingresado correctamente.');
                        $("#tabla").load('tabla.php');
                        $("#modal_ingresar_usuario").modal('toggle');
                        formulario[0].reset();
                    } else {
                        notyf.error('Error, verifica la información.');
                    }
                }
            });

        })

        $("#editar_usuario").click(function() {
            datos = $("#EditarUsuarioForm").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigo/editar_usuario.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Usuario modificado correctamente.');
                        $("#tabla").load('tabla.php');
                        $("#modal_editar_usuario").modal('toggle');
                    } else {
                        notyf.error('Error, verifica la información.');
                    }
                }
            });

        })

    });
</script>