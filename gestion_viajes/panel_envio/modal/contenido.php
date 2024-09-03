<?php
session_start();
require_once('../../../mysql/conexion.php');
$cn = conectar();
$id_viaje = $_POST['id'];
$sqlSelect = "SELECT * FROM viajes where id = $id_viaje";
?>

<?php
$resultado = $cn->query($sqlSelect);
$rowViaje = $resultado = $resultado->fetch_assoc();

if ($rowViaje['estado'] == 'ruta' || $rowViaje['estado'] == 'planta' || $rowViaje['estado'] == 'retorno') {

    $placas = $rowViaje['placas'];
    $sqlUbicacion = "SELECT * FROM ubicaciones where placas = '$placas' limit 1";
    $resultado2 = $cn->query($sqlUbicacion);
    $rowVelocidad = $resultado2 = $resultado2->fetch_assoc();
    if (5 == 0) {
        $sql = "SELECT id_status, status, imagen from status where id_status = 12";
        $result = $cn->query($sql);
    } else {
        $sql = "SELECT id_status, status, imagen from status where tipo = 'viaje' and monitoreo = true";
        $result = $cn->query($sql);
    }
} else {
    $sql = "SELECT id_status, status, imagen from status where tipo = 'viaje' and status = 'Reportar a cliente' limit 1";
    $result = $cn->query($sql);
}

?>

<div class="modal-body">
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
                        <a class="step-content-wrapper" href="javascript:;">
                            <span class="step-icon step-icon-soft-dark">1</span>
                            <div class="step-content pb-5">
                                <span class="step-title">Seleccionar estatus</span>
                            </div>
                        </a>
                    </li>

                    <li class="step-item">
                        <a class="step-content-wrapper" href="javascript:;">
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
                    <div id="basicVerStepDetails" class="card card-body" style="min-height: 15rem;">
                        <h4>Seleccionar status</h4>

                        <div class="row">
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <div class="col-lg-3 col-sm-6 mt-3">
                                    <!-- Card -->
                                    <div class="card card-lg form-check form-check-select-stretched h-100 zi-1 card-hover-shadow text-center seleccionar" onclick="SeleccionarStatus('<?php echo $row['id_status'] ?>','<?php echo $row['status'] ?>')">
                                        <div class="card-footer text-center">
                                            <!-- Form Check -->
                                            <input type="radio" class="form-check-input" name="billingPricingRadio" id="billingPricingRadio<?php echo $row['id_status'] ?>" value="<?php echo $row['id_status'] ?>">
                                            <label class="form-check-label" for="billingPricingRadio<?php echo $row['id_status'] ?>"></label>
                                            <!-- End Form Check -->

                                            <h4 class="card-title text-dark"><?php echo $row['status'] ?></h4>
                                        </div>

                                        <div class="card-body justify-content-center">
                                            <img class="avatar avatar-lg avatar-4x3" src="../../img/status/<?php echo $row['imagen'] ?>" alt="<?php echo $row['imagen'] ?>">
                                        </div>

                                    </div>
                                    <!-- End Card -->
                                </div>
                            <?php } ?>
                            <!-- End Col -->
                        </div>
                        <!-- End Row -->

                        <!-- Footer -->
                        <div class="d-flex align-items-center mt-auto pt-3">
                            <div class="ms-auto">
                                <button type="button" class="btn btn-primary btnsiguiente" data-hs-step-form-next-options='{
                        "targetSelector": "#basicVerStepTerms"
                      }'>
                                    Siguiente <i class="bi-chevron-right small"></i>
                                </button>
                            </div>
                        </div>
                        <!-- End Footer -->
                    </div>

                    <div id="basicVerStepTerms" class="card card-body active" style="display: block; min-height: 15rem;">

                        <div class="mb-5">
                            <h4>Estatus seleccionado:</h4>
                            <h1 id="myHeading" class="text-primary">Llegada a planta</h1>
                        </div>

                        <h4>Añadir comentarios y/o evidencia</h4>


                        <form method="post" id="form_coments">

                            <label class="form-label">Añadir comentarios<span class="form-label-secondary">(Optional)</span></label>

                            <div class="quill-custom">
                                <div id="comentarios_editor" style="height: 140px;">
                                </div>
                            </div>

                            <label class="form-label mb-3 mt-3">Añadir evidencia <span class="form-label-secondary">(Optional)</span></label>

                            <!-- Dropzone -->
                            <div id="adjuntos" class="js-dropzone dz-dropzone dz-dropzone-card">
                                <div class="dz-message">
                                    <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/cajita.svg" alt="Image Description">

                                    <h5>Arrastra y suelta aqui tus archivos</h5>

                                    <p class="mb-2">o</p>

                                    <span class="btn btn-white btn-sm">Buscar archivos</span>
                                </div>
                            </div>
                            <!-- End Dropzone -->

                        </form>

                        <!-- Footer -->
                        <div class="d-flex align-items-center mt-auto pt-3">
                            <button type="button" class="btn btn-ghost-secondary me-2" data-hs-step-form-prev-options='{
                 "targetSelector": "#basicVerStepDetails"
               }'>
                                <i class="bi-chevron-left small"></i> Volver
                            </button>

                            <div class="ms-auto">
                                <button id="enviar_status" class="btn btn-primary" type='button' style="display: none;"><span><i class="bi bi-send-check"></i> Enviar estatus</span></button>
                                <button id="reenviar_status" class="btn btn-success" type='button' style="display: none;"><span><i class="bi bi-send-check"></i> Reenviar estatus</span></button>
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
</div>
<script>
    var myDropzone = new Dropzone("#adjuntos", {
        url: "../algoritmos/envio_manual.php",
        autoProcessQueue: false,
        addRemoveLinks: true,
    });

    var id_status;
    var status_nombre;
    var idreporte;

    function SeleccionarStatus(id, nombre) {
        id_status = id;
        status_nombre = nombre;
        console.log(id_status);
        console.log(status_nombre);
        $("#myHeading").text('(' + id + ') ' + nombre);

        const btnsiguiente = document.getElementsByClassName('btnsiguiente');
        btnsiguiente.disabled = false;
    }

    (function() {
        new HSStepForm('.js-step-form', {
            finish($el) {
                const $successMessageTempalte = $el.querySelector('.js-success-message').cloneNode(true)

                $successMessageTempalte.style.display = 'block'

                $el.style.display = 'none'
                $el.parentElement.appendChild($successMessageTempalte)
            }
        })
    })();

    var comentarios_editor = new Quill('#comentarios_editor', {
        placeholder: 'Comentarios',
        theme: 'snow',
        imageResize: {
            parchment: Quill.import('parchment'),
            modules: ['Resize', 'DisplaySize']
        }
    });

    $("#enviar_status").click(function() {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Estás seguro de enviar el estatus?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, enviar status',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarStatus();
            }
        });
    });

    function enviarStatus() {

        notyf.open({
            type: 'info',
            message: 'Enviando estatus, espere...'
        });
        var form_data = new FormData();

        form_data.append("id", '<?php echo $_POST['id'] ?>');
        form_data.append("placas", '<?php echo $rowViaje['placas'] ?>');
        form_data.append("id_status", id_status);
        form_data.append("status_nombre", status_nombre);
        form_data.append("modo", ' <?php echo $rowViaje['x_modo_bel'] ?>');
        form_data.append("comentarios", comentarios_editor.container.firstChild.innerHTML);
        form_data.append("fecha", $("#fecha_m").val());
        form_data.append("hora", $("#hora_m").val());

        var archivo = myDropzone.files[0];
        form_data.append("file[]", archivo);

        $.ajax({
            cache: false,
            contentType: false,
            data: form_data,
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            processData: false,
            method: "POST",
            url: "../algoritmos/envio_manual.php",
            success: function(respuesta) {
                if (respuesta == "1") {
                    notyf.success('Estatus enviado correctamente.');
                    comentarios_editor.setContents([{
                        insert: '\n'
                    }]);

                    $('#tabla').load('../fletes/tabla.php', {
                        'consulta': consulta_universal
                    });

                    myDropzone.removeAllFiles();
                    $('#modal_envio_status').offcanvas('hide');

                    cargar_status_enviados();
                    cargar_estado('<?php echo $_POST['id'] ?>');

                } else {
                    console.log('Error al enviar correo');
                    notyf.error('Correo no enviado, Error: ' + respuesta);
                }
            }
        });
    };


    $("#reenviar_status").click(function() {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Deseas realmente reenviar este estatus al cliente?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, reenviar estatus',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                reenviarStatus();
            }
        });
    });

    function reenviarStatus() {

        notyf.open({
            type: 'info',
            message: 'Enviando estatus, espere...'
        });
        var form_data = new FormData();

        form_data.append("id", '<?php echo $_POST['id'] ?>');
        form_data.append("placas", '<?php echo $rowViaje['placas'] ?>');
        form_data.append("id_reporte", idreporte);
        form_data.append("id_status", id_status);
        form_data.append("status_nombre", status_nombre);
        form_data.append("comentarios", comentarios_editor.container.firstChild.innerHTML);

        var archivo = myDropzone.files[0];
        form_data.append("file[]", archivo);

        $.ajax({
            cache: false,
            contentType: false,
            data: form_data,
            dataType: 'JSON',
            enctype: 'multipart/form-data',
            processData: false,
            method: "POST",
            url: "../algoritmos/reenvio.php",
            success: function(respuesta) {
                if (respuesta == "1") {
                    notyf.success('Estatus reenviado correctamente.');
                    comentarios_editor.setContents([{
                        insert: '\n'
                    }]);

                    myDropzone.removeAllFiles();
                    $('#modal_envio_status').offcanvas('hide');

                    cargar_status_enviados();
                    cargar_estado('<?php echo $_POST['id'] ?>');

                } else {
                    console.log('Error al enviar correo');
                    notyf.error('Correo no enviado, Error: ' + respuesta);
                }
            }
        });
    };
</script>