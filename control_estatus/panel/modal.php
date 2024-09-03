<!-- Modal -->
<div class="modal fade" id="modal_registro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormStatus">
                    <input type="hidden" id="id_status" name="id_status" class="form-control" placeholder="Escribir el nombre del status">

                    <div class="mb-3">
                        <label class="form-label">Nombre del status:</label>
                        <input type="text" id="status" name="status" class="form-control" placeholder="Escribir el nombre del status">
                    </div>

                    <div class="tom-select-custom mb-3">
                        <label class="form-label">Tipo:</label>
                        <select class="js-select form-select" autocomplete="off" id="tipo" name="tipo">
                            <option value="viaje">Viaje</option>
                            <option value="maniobra">Maniobra</option>
                        </select>
                    </div>

                    <div class="tom-select-custom mb-3">
                        <label class="form-label">Tipo de terminal:</label>
                        <select class="js-select form-select" autocomplete="off" id="tipo_terminal" name="tipo_terminal">
                            <option value=""></option>
                            <option value="puerto">Entrada al puerto</option>
                            <option value="externa">Terminal externa</option>
                        </select>
                    </div>

                    <div class="d-flex align-items-center mb-3">
                        <label class="avatar avatar-xl avatar-circle" for="avatarUploader">
                            <img id="avatarImg" class="avatar-img" src="../../img/icons/img1.jpg" alt="Image Description">
                        </label>

                        <div class="d-flex gap-3 ms-4">
                            <div class="form-attachment-btn btn btn-sm btn-primary">Subir icono
                                <input type="file" class="js-file-attach form-attachment-btn-label" id="avatarUploader">
                            </div>
                            <button type="button" class="js-file-attach-reset-img btn btn-white btn-sm">Borrar</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="guardar_status" class="btn btn-success btn-sm" style="display:none">Guardar</button>
                <button type="button" id="registrar_status" class="btn btn-primary btn-sm">Registrar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script>
    document.getElementById('avatarUploader').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            document.getElementById('avatarImg').src = e.target.result;
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    });

    document.querySelector('.js-file-attach-reset-img').addEventListener('click', function() {
        document.getElementById('avatarImg').src = '../../img/icons/img1.jpg';
        document.getElementById('avatarUploader').value = '';
    });
</script>