<script>
    function cargar_contenido() {
        $.ajax({
            type: "POST",
            data: {
                'mes': <?php echo $_GET['mes']; ?>,
                'año': <?php echo $_GET['año']; ?>,
                'usuario': <?php echo $idVal; ?>,
            },
            url: "tabla.php",
            success: function(respuesta) {
                $("#tabla_bonos").html(respuesta);
            }
        });
    }

    cargar_contenido();

    function iniciar_incidencia(id_bono) {
        $("#id_bono_incidencia").val(id_bono).change();
        $("#historial_incidencias").load('../incidencias/historial_incidencias.php', {
            'id_bono': id_bono
        });
    }

    $("#guardar_comentario").click(function() {
        notyf.success('Guardando comentario');
        datos = $("#FormComentarios").serialize();
        $.ajax({
            data: datos,
            method: "POST",
            url: "guardar_comentario.php",
            success: function(respuesta) {
                if (respuesta == '1') {
                    notyf.success('Comentario guardado.');
                    $.ajax({
                        type: "POST",
                        data: datos,
                        url: "cronologia.php",
                        success: function(respuesta) {
                            $("#cronologia").html(respuesta);
                        }
                    });
                } else {
                    notyf.error('Comentario no guardado. ' + respuesta);
                }
            }
        });


    });
</script>