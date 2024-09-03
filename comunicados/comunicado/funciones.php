<script>
    $('#informacion_comunicado').load('informacion.php', {
        'id_comunicado': <?php if (isset($_GET['id_comunicado'])) {
                                echo $_GET['id_comunicado'];
                            } else {
                                echo 0;
                            } ?>
    });

    $('#imagenes').load('imagenes.php', {
        'id_comunicado': <?php if (isset($_GET['id_comunicado'])) {
                                echo $_GET['id_comunicado'];
                            } else {
                                echo 0;
                            } ?>
    });

    var myDropzone = new Dropzone("#attachFiles", {
        url: "crear.php",
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 3,
        maxFiles: 5,
        acceptedFiles: "image/*",
        addRemoveLinks: true
    });

    $("#guardar").click(function() {
        var id_comunicado = $("#id_comunicado").val();
        var titulo = $("#titulo").val();
        var descripcion = quill.getText();

        var formData = new FormData();
        formData.append('id_comunicado', id_comunicado);
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);

        var images = myDropzone.getQueuedFiles();
        for (var i = 0; i < images.length; i++) {
            formData.append('imagenes[]', images[i]);
        }

        $.ajax({
            url: "editar.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(respuesta) {
                notyf.success('La información se actualizo correctamente.');
                $('#imagenes').load('imagenes.php', {
                    'id_comunicado': <?php if (isset($_GET['id_comunicado'])) {
                                            echo $_GET['id_comunicado'];
                                        } else {
                                            echo 0;
                                        } ?>
                });
                myDropzone.removeAllFiles();
            },
        });
    });

    $("#publicar").click(function() {
        var titulo = $("input[name='titulo']").val();
        var descripcion = quill.root.innerHTML;

        var formData = new FormData();
        formData.append('titulo', titulo);
        formData.append('descripcion', descripcion);
        formData.append('id_usuario', <?php echo $_SESSION['userID'] ?>);

        var images = myDropzone.getQueuedFiles();
        for (var i = 0; i < images.length; i++) {
            formData.append('imagenes[]', images[i]);
        }

        $.ajax({
            url: "crear.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $.ajax({
                    url: "enviar_notificaciones.php",
                    success: function(response) {
                        notyf.success('Notificaciones enviadas.');
                    },
                });
                notyf.success('Comunicado creado correctamente');
                window.location.href = '../listado/index.php';
                console.log(response);
                myDropzone.removeAllFiles();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error('Error en la creación del comunicado.');
                console.log(textStatus, errorThrown);
            }
        });
    });
</script>