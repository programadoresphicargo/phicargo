<div class="modal fade" id="archivosModal" tabindex="-1" aria-labelledby="archivosModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg animate__animated animate__fadeInUpBig">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archivosModalLabel">Subir Archivos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button id="start-upload" type="button" class="btn btn-primary btn-sm mb-3"><i class="bi bi-send-check"></i> Enviar archivos</button>

                <form>
                    <div id="dropzoneadjuntos" class="js-dropzone dz-dropzone dz-dropzone-card">
                        <div class="dz-message">
                            <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/cajita.svg" alt="C">

                            <h5>Arrastra y suelta aqui tus archivos</h5>

                            <p class="mb-2">o</p>

                            <span class="btn btn-white btn-sm">Abrir explorador de archivos</span>
                        </div>
                    </div>
                </form>
                <div id="filesenviados" class="mt-5"></div>
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>