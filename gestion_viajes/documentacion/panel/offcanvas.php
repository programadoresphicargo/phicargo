<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvaspods" aria-labelledby="offcanvasBottomLabel" style="width: 80%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Documentación adjunta a viaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <div class="row">
            <div class="col-4">
                <button id="start-upload" type="button" class="btn btn-success btn-sm mb-3"><i class="bi bi-floppy"></i> Guardar y enviar por correo</button>
                <form>

                    <div class="tom-select-custom mb-3">
                        <label>Tipo de documento</label>
                        <select class="js-select form-select" autocomplete="off" id="tipo_doc">
                            <option value="pod">POD</option>
                            <option value="eir">EIR</option>
                            <option value="cuentaop">Cuenta operador</option>
                        </select>
                    </div>

                    <div id="dropzonepods" class="js-dropzone dz-dropzone dz-dropzone-card">
                        <div class="dz-message">
                            <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/cajita.svg" alt="C">

                            <h5>Arrastra y suelta aqui tus archivos</h5>

                            <p class="mb-2">o</p>

                            <span class="btn btn-white btn-sm">Buscar archivos</span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-8">
                <div id="archivosdb"></div>
            </div>
        </div>
    </div>
</div>