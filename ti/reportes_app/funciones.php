<script>
    function comprobar_estado(id_reporte) {
        $.ajax({
            data: {
                'id_reporte': id_reporte
            },
            url: 'comprobar_estado.php',
            type: 'POST',
            success: function(data) {
                if (data == 1) {
                    $("#solucionar_reporte").hide();
                } else {
                    $("#solucionar_reporte").show();
                }
            },
            error: function(xhr, status, error) {
                notyf.success('Error en la consulta AJAX: ' + error);
            }
        });
    }

    $("#registros").load('tabla.php');

    $("#solucionar_reporte").click(function() {
        var datos = $('#formInfo').serialize();
        if ($("#comentario").val() != '') {
            $.ajax({
                data: datos,
                url: 'solucionar_reporte.php',
                type: 'POST',
                success: function(data) {
                    if (data == 1) {
                        notyf.success('Reporte atendido correctamente.');
                        $("#offcanvasRight").offcanvas('hide');
                        $("#registros").load('tabla.php');
                    } else {
                        notyf.error(data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la consulta AJAX: ' + error);
                }
            });
        } else {
            notyf.error('Añade un comentario, plox.');
        }
    });
</script>