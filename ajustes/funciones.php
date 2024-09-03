<script>

    $(document).ready(function() {

        $("#GuardarCredencialesOdooCorreo").click(function() {
            datos = $("#Odoo_correos").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "GuardarCredencialesOdooCorreo.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Datos guardados correctamente');
                    } else {
                        notyf.error('');
                    }
                }
            });
        });

        $("#GuardarCredencialesOdooAplicacion").click(function() {
            datos = $("#Odoo_aplicacion").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "GuardarCredencialesOdooAplicacion.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Datos guardados correctamente');
                    } else {
                        notyf.error('');
                    }
                }
            });
        });

        $("#GuardarCambiosCorreos").click(function() {
            datos = $("#CorreosAutomaticos").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "GuardarDatosCorreos.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Datos guardados correctamente');
                    } else {
                        notyf.error('');
                    }
                }
            });
        });

    });
</script>