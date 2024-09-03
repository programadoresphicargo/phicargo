<div id="editar_operador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalTopCoverTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-top-cover bg-fondo text-center">
                <figure class="position-absolute end-0 bottom-0 start-0">
                    <svg preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 1920 100.1">
                        <path fill="#fff" d="M0,0c0,0,934.4,93.4,1920,0v100.1H0L0,0z" />
                    </svg>
                </figure>

                <div class="modal-close">
                    <button type="button" class="btn-close btn-close-light" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <!-- End Header -->

            <div class="modal-top-cover-icon">
                <span class="icon icon-lg icon-light icon-circle icon-centered shadow-sm">
                    <img src="../../img/auxuser.png" alt="Girl in a jacket" class="fs-2" width="100" height="100">
                </span>
            </div>

            <div class="modal-body">
                <form id="info_operador">
                    <input type="hidden" id="id_operador" name="id_operador" class="form-control">
                    <div class="mb-3">
                        <input type="text" id="nombre_operador" name="nombre_operador" class="h6 form-control text-center" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlInput3">Password</label>
                        <input type="text" id="contraseña" name="contraseña" class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-danger btn-sm" id="guardar_operador">Guardar</button>
            </div>
        </div>
    </div>
</div>