<div class="offcanvas offcanvas-end" tabindex="-1" id="modal_incidencia" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Registro de incidencia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="historial_incidencias"></div>
    </div>
    <div class="offcanvas-footer">
        <form id="FormIncidencias">
            <div class="mb-3">
                <input type="hidden" id="id_bono_incidencia" name="id_bono_incidencia">
                <label class="form-label" for="exampleFormControlTextarea1">Motivos de incidencia</label>
                <textarea id="comentarios_incidencias" name="comentarios_incidencias" class="form-control" rows="8"></textarea>
            </div>
        </form>
        <div class="row">
            <div class="col">
                <button type="button" id="registrar_incidencia" class="btn btn-danger btn-sm btn-block mt-3">Registrar incidencia</button>
            </div>
        </div>
    </div>
</div>

<script>
    $("#registrar_incidencia").click(function() {
        if ($("#comentarios_incidencias").val() != '') {
            if (confirm("¿Estás seguro de que deseas registrar esta incidencia? Esta acción cancelara todos los bonos obtenidos.")) {
                ejecutarMiFuncion();
            } else {}
        } else {
            notyf.error('Ingresa el motivo de la incidencia.');
        }
    });


    function ejecutarMiFuncion() {
        var datos = $("#FormIncidencias").serialize();
        var id_bono = $("#id_bono_incidencia").val();
        $.ajax({
            data: datos,
            type: "POST",
            url: "../incidencias/registrar_incidencia.php",
            success: function(respuesta) {
                if (respuesta == '1') {
                    notyf.success('Comentario guardado.');
                    $("#historial_incidencias").load('../incidencias/historial_incidencias.php', {
                        'id_bono': id_bono
                    });
                    $("#comentarios_incidencias").val('');
                    cargar_contenido();
                } else {
                    notyf.error('Error:' + respuesta);
                }
            }
        });
    }
</script>