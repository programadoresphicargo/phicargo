<div class="offcanvas offcanvas-end" tabindex="-1" id="entregaturnooffcanvas" aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLabel">Entrega de turno</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <input id="entregaviajeid" type="hidden">
        <div class="quill-custom">
            <div id="editor55" style="min-height: 8rem;">
            </div>
        </div>
        <div class="d-grid gap-2 mt-4">
            <button class="btn btn-primary btn-sm" type="button" id="guardar_entrega_viaje">Guardar</button>
        </div>
        <div id="listadoentregasviaje" class="mt-4">
        </div>
    </div>
</div>

<script>
    var quill = new Quill('#editor55', {
        theme: 'snow'
    });

    function quillEstaVacio() {
        var contenido = quill.getText().trim();
        return contenido.length === 0;
    }

    $("#guardar_entrega_viaje").click(function() {
        var contenido = quill.root.innerHTML;
        if (!quillEstaVacio()) {
            $.ajax({
                type: "POST",
                data: {
                    'id_viaje': $('#entregaviajeid').val(),
                    'id_usuario': '<?php echo $_SESSION['userID']; ?>',
                    'texto': contenido
                },
                url: "../codigos/guardar_entrega_viaje.php",
                success: function(respuesta) {
                    if (respuesta == 1) {
                        notyf.success('Entrega guardada correctamente');
                        $("#listadoentregasviaje").load('../status/modal/entregas.php', {
                            'id_viaje': $('#entregaviajeid').val()
                        });
                        quill.setContents([]);
                    } else if (respuesta == 2) {
                        notyf.error('No se guardo el comentario porque aún no existe una entrega de turno abierta.');
                    } else {
                        notyf.error('Error');
                    }
                }
            });
        } else {
            notyf.error('No se guardo porque no hay comentarios escritos.');
            console.log('vacio');
        }
    });
</script>