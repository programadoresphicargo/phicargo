<div class="offcanvas offcanvas-end" tabindex="-1" id="canvas_comentarios" aria-labelledby="offcanvasRightLabel" style="width: 40%;">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Añadir comentarios</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="quill-custom">
            <div id="editor-container" style="height: 300px;"></div>
        </div>
        <div class="mt-5">
            <button id="get-text-button" class="btn btn-success btn-sm">Guardar</button>
        </div>
    </div>
</div>

<script>
    var quill = new Quill('#editor-container', {
        theme: 'snow'
    });

    var getTextButton = document.getElementById('get-text-button');
    getTextButton.addEventListener('click', function() {
        var editorContent = quill.root.innerHTML;
        console.log(editorContent);

        $.ajax({
            type: 'POST',
            url: '../comentarios/guardar_comentario.php',
            data: {
                'fecha_informe': fecha,
                'comentario': editorContent,
                'opcion': 'dia'
            },
            success: function(data) {
                if (data == 1) {
                    notyf.success('Comentario guardado correctamente');
                    $("#canvas_comentarios").offcanvas('hide');
                    quill.deleteText(0, quill.getLength());
                } else {
                    notyf.error('Comentario guardado correctamente');
                }

                $('#comentarios').load('../comentarios/comentarios.php', {
                    'fecha': fecha,
                    'opcion': 'dia'
                });
            },
            error: function(error) {
                console.error('Error en la solicitud:', error);
                alert('Error en la solicitud. Consulta la consola para obtener más detalles.');
            }
        });

    });
</script>