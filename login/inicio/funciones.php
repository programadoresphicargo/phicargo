<script>
    $("#IniciarSesion").click(function() {
        datos = $("#InicioSesion").serialize();
        console.log(datos);
        $.ajax({
            type: "POST",
            data: datos,
            url: "validar.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    window.location = "../../menu/principal/index.php";
                    notyf.success('Bienvenido :)');
                } else if (respuesta == 2) {
                    window.location = "../../alertas/actualizaciones/index.php";
                    notyf.success('Alerta');
                } else if (respuesta == 3) {
                    window.location = "../../menu/principal/index.php";
                    notyf.success('Desarrollador');
                } else {
                    notyf.error('Usuario o contraseña incorrectos.');
                }
            }
        });
    });
</script>