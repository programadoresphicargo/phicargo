<script>
    $(document).ready(function() {
        $("#ListaOperadores").load('tabla.php');

        $("#guardar_operador").click(function() {
            datos = $("#info_operador").serialize();
            $.ajax({
                type: "POST",
                data: datos,
                url: "editar_operador.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('La información se actualizo correctamente.');
                        $('#editar_operador').modal('hide');
                        $("#ListaOperadores").load('tabla.php');
                    } else {
                        notyf.error('Error en la actualizacion de la información.');
                    }
                }
            });
        });

    });
</script>