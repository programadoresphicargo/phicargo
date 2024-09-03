<script>
    $(document).ready(function() {

        $("#meses").load('meses.php');

        $("#confirmar_abrir_mes").click(function() {
            datos = $("#BonosMes").serialize();
            $.ajax({
                data: datos,
                method: "POST",
                url: "get_viajes.php",
                success: function(respuesta) {
                    $('#abrir_mes').modal('hide');
                    //location.reload();
                }
            });
        });
    });
</script>