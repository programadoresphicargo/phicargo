<div class="modal fade" id="subir_archivo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Subir archivo de bonos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <input class="form-control mb-3" id="fecha" name="fecha">

                <div id="archivo_excel" class="js-dropzone row dz-dropzone dz-dropzone-card">
                    <div class="dz-message">
                        <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/cajita.svg" alt="Image Description">

                        <h5>Arrastrar archivo aquí</h5>

                        <p class="mb-2">o</p>

                        <span class="btn btn-white btn-sm">Buscar archivo</span>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary btn-sm" id='subirbonos'>Subir archivo</button>
            </div>
        </div>
    </div>
</div>

<script>
    var myDropzone = new Dropzone("#archivo_excel", {
        url: "../excel/formato_bonos.php",
        autoProcessQueue: false,
        maxFiles: 1,
        acceptedFiles: ".xls, .xlsx",
        addRemoveLinks: true,
    });

    flatpickr("#fecha", {
        plugins: [
            new monthSelectPlugin({
                dateFormat: "n-Y",
                shorthand: true
            })
        ],
        altInput: true,
        altFormat: "Y-m",
    });

    var myInput = document.getElementById('fecha');
    var myButton = document.getElementById('subirbonos');
    myButton.disabled = true;

    function checkButtonStatus() {
        if (myDropzone.files.length > 0 && myInput.value.trim() !== '') {
            myButton.disabled = false;
        } else {
            myButton.disabled = true;
        }
    }

    myDropzone.on('addedfile', checkButtonStatus);
    myInput.addEventListener('input', checkButtonStatus);
</script>

<script>
    $("#subirbonos").click(function(e) {
        e.preventDefault();
        var archivo = myDropzone.files[0];
        var fecha = $("#fecha").val();
        var formData = new FormData();
        formData.append("archivo", archivo);
        formData.append("fecha", fecha);
        $.ajax({
            url: "../excel/formato_bonos.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response == 1) {
                    $("#meses").load('meses.php');
                    notyf.success('Archivo de bonos cargado correctamente');
                } else {
                    notyf.success(response);
                }
                $("#subir_archivo").modal('hide');
                $("#meses").load('meses.php');
                myDropzone.removeAllFiles();
                myInput.val('');
            },
            error: function(xhr, status, error) {
                notyf.error(error);
            }
        });
    });
</script>