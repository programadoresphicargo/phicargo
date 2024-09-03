<?php
session_start();
require_once('../../mysql/conexion.php');
$cn = conectar();

$id_cp = $_POST['id_cp'];
$tipo = $_POST['tipo'];

$sql = "SELECT * FROM maniobras where id_cp = $id_cp and tipo = '$tipo'";
$result = $cn->query($sql);
$rowS = $result->fetch_assoc();

if (isset($rowS['status'])) {
    if ($rowS['status'] == 'Activo') {
        $sqlSelect = "SELECT * FROM status where tipo = 'maniobra'";
    }
} else {
    $sqlSelect = "SELECT * FROM status where id_status = 82";
}
$resultado = $cn->query($sqlSelect);
?>

<!-- Step Form -->
<form class="js-step-form" data-hs-step-form-options='{
        "progressSelector": "#basicVerStepFormProgress",
        "stepsSelector": "#basicVerStepFormContent",
        "endSelector": "#basicVerStepFinishBtn"
      }'>
    <div class="row">
        <div class="col-lg-3">
            <!-- Step -->
            <ul id="basicVerStepFormProgress" class="js-step-progress step step-icon-sm mb-7">
                <li class="step-item">
                    <a class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-dark">1</span>
                        <div class="step-content pb-5">
                            <span class="step-title">Enviar Status</span>
                        </div>
                    </a>
                </li>

                <li class="step-item">
                    <a class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-dark">2</span>
                        <div class="step-content pb-5">
                            <span class="step-title">Añadir comentarios y/o evidencia</span>
                        </div>
                    </a>
                </li>

            </ul>
            <!-- End Step -->
        </div>

        <div class="col-lg-9">
            <!-- Content Step Form -->
            <div id="basicVerStepFormContent">
                <div id="basicVerStepDetails" class="card card-body active" style="min-height: 15rem;">
                    <h4>Status</h4>

                    <div class="row">

                        <?php while ($row = $resultado->fetch_assoc()) { ?>
                            <div class="col-3 mb-3">
                                <!-- Card -->
                                <div class="card card-lg form-check form-check-select-stretched h-100 zi-1">
                                    <div class="card-header text-center">
                                        <!-- Form Check -->
                                        <input type="radio" class="form-check-input" name="statusaenviar" id="<?php echo $row['id_status'] ?>" value="<?php echo $row['id_status'] ?>">
                                        <label class="form-check-label" for="<?php echo $row['id_status'] ?>"></label>
                                        <!-- End Form Check -->
                                        <h4 class="card-title text-dark"><?php echo $row['status'] ?></h4>
                                    </div>

                                    <div class="card-body d-flex justify-content-center">
                                        <img src="../../app/maniobras/iconos/<?php echo $row['imagen'] ?>" height="90">
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                            <!-- End Col -->
                        <?php } ?>

                    </div>
                    <!-- End Row -->

                    <!-- Footer -->
                    <div class="d-flex align-items-center mt-auto">
                        <div class="ms-auto">
                            <button id="siguiente" type="button" class="btn btn-primary" data-hs-step-form-next-options='{
                        "targetSelector": "#basicVerStepTerms"
                      }'>
                                Siguiente <i class="bi-chevron-right small"></i>
                            </button>
                        </div>
                    </div>
                    <!-- End Footer -->
                </div>

                <div id="basicVerStepTerms" class="card card-body" style="display: none; min-height: 15rem;">
                    <h4>Comentarios y/o evidencia</h4>

                    <label class="form-label">Description <span class="form-label-secondary">(Optional)</span></label>

                    <form>
                        <!-- Quill -->
                        <div class="quill-custom p-3">
                            <div id="comentarios" style="min-height: 15rem;">
                            </div>
                        </div>
                        <!-- End Quill -->
                    </form>

                    <label class="form-label">Description <span class="form-label-secondary">(Optional)</span></label>

                    <form>
                        <!-- Dropzone -->
                        <div id="my-dropzone" class="js-dropzone row dz-dropzone dz-dropzone-card p-3 mb-5">
                            <div class="dz-message">

                                <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/cajita.svg" alt="Image Description">

                                <h5>Arrastar y soltar archivos, documentos o evidencias</h5>

                                <p class="mb-2">o</p>

                                <span class="btn btn-white btn-sm">Buscar archivos</span>
                                <div id="preview-container">

                                </div>
                            </div>
                        </div>
                        <!-- End Dropzone -->
                    </form>

                    <!-- Footer -->
                    <div class="d-flex align-items-center mt-auto">
                        <button type="button" class="btn btn-ghost-secondary me-2" data-hs-step-form-prev-options='{
                 "targetSelector": "#basicVerStepDetails"
               }'>
                            <i class="bi-chevron-left small"></i> Volver
                        </button>

                        <div class="ms-auto">
                            <button id="enviar_status_maniobra" type="button" class="btn btn-primary">
                                Enviar <i class="bi-chevron-right small"></i>
                            </button>
                        </div>
                    </div>
                    <!-- End Footer -->
                </div>

            </div>
            <!-- End Content Step Form -->
        </div>
    </div>
    <!-- End Row -->
</form>
<!-- End Step Form -->
<script>
    var rad = document.getElementsByName("statusaenviar");
    var miBoton = document.getElementById("siguiente");

    for (var i = 0; i < rad.length; i++) {
        rad[i].addEventListener("change", function() {
            validarSeleccion();
        });
    }

    function validarSeleccion() {
        var seleccionado = false;
        for (var i = 0; i < rad.length; i++) {
            if (rad[i].checked) {
                seleccionado = true;
                break;
            }
        }

        if (seleccionado) {
            miBoton.disabled = false;
        } else {
            miBoton.disabled = true;
        }
    }

    validarSeleccion();

    var quill = new Quill('#comentarios', {
        theme: 'snow'
    });

    var myDropzone = new Dropzone("#my-dropzone", {
        paramName: "file",
        url: "../correos/envio_manual.php",
        autoProcessQueue: false,
        addRemoveLinks: true,
        parallelUploads: 10,
        uploadMultiple: true,
        init: function() {
            this.on("addedfile", function(file) {
                var previewElement = file.previewElement;
                $(previewElement).find(".dz-success-mark, .dz-error-mark").remove();
            });
        }
    });

    progress_bar = $('.progress-bar');
    progress_msg = $('#msg');
    progress_porcentaje = $('#porcentaje');

    progress_msg.html('Preparando...');
    progress_porcentaje.html('0%');

    $("#enviar_status_maniobra").click(function() {
        notyf.success('Enviando correo.');
        $("#barra_carga").show();
        $("#barra_carga").addClass("animate__animated");
        $("#barra_carga").addClass("animate__fadeInUp");
        progress_bar.removeClass('bg-success').addClass('bg-primary');
        progress_bar.css('width', '0%');
        progress_porcentaje.html('0%');

        var contenidoQuill = quill.getText();

        myDropzone.processQueue();

        var formData = new FormData();

        formData.append("id_cp", <?php echo $_POST['id_cp'] ?>);
        formData.append("tipo", '<?php echo $tipo ?>');
        formData.append("id_usuario", <?php echo $_SESSION['userID'] ?>);
        formData.append("comentarios", quill.root.innerHTML.trim());
        formData.append('contenidoQuill', contenidoQuill);

        myDropzone.files.forEach(function(file) {
            formData.append('file[]', file);
        });

        var radios = document.getElementsByName("statusaenviar");
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                console.log(radios[i].value);
                break;
            }
        }

        formData.append('status_ejecutivo', radios[i].value);

        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function(e) {
                    if (e.lengthComputable) {
                        let percentComplete = Math.floor((e.loaded / e.total) * 100);
                        progress_msg.html('Enviando...');
                        progress_bar.css('width', percentComplete + '%');
                        progress_porcentaje.html(percentComplete + '%');
                        console.log(percentComplete);
                    }

                }, false);

                return xhr;
            },
            url: '../correos/envio_manual.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#enviar_status_maniobra_modal').offcanvas('hide');
                notyf.success('El correo se ha enviado correctamente');
                myDropzone.removeAllFiles();
                quill.setText('');
                $("#barra_carga").toggle();
                progress_bar.removeClass('bg-primary').addClass('bg-success');
                progress_msg.html('¡Correo enviado!');

                $("#linea_tiempo_status_retiro").load('../maniobra/status.php', {
                    'id_cp': '<?php echo $_POST['id_cp']; ?>',
                    'tipo': 'Retiro'
                });

                $("#linea_tiempo_status_ingreso").load('../maniobra/status.php', {
                    'id_cp': '<?php echo $_POST['id_cp']; ?>',
                    'tipo': 'Ingreso'
                });

            },
            error: function(xhr, status, error) {
                notyf.error('Error al enviar el correo:', error);
                console.log(error);
                // Realizar acciones adicionales en caso de error
            }
        }).done(res => {
            console.log(res.status);
            if (res.status == 200) {
                progress_bar.removeClass('bg-primary').addClass('bg-success');
                progress_bar.html('¡Correo enviado!');
            }
        });
    });

    (function() {
        // INITIALIZATION OF STEP FORM
        // =======================================================
        new HSStepForm('.js-step-form', {
            finish($el) {
                const $successMessageTempalte = $el.querySelector('.js-success-message').cloneNode(true)

                $successMessageTempalte.style.display = 'block'

                $el.style.display = 'none'
                $el.parentElement.appendChild($successMessageTempalte)
            }
        })
    })();
</script>