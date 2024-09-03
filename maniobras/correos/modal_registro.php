<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvas_registro_correo" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Nuevo Correo Electronico</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <form id="FormCorreo">

            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="text" id="correo" name="correo" class="form-control form-control-title" placeholder="correo@prueba.com">
            </div>

            <div class="mb-3 tom-select-custom">
                <label class="form-label" for="exampleFormControlSelect1">Tipo</label>
                <select id="tipo" name="tipo" class="js-select form-select">
                    <option value="Destinatario">Destinatario</option>
                    <option value="CC">CC</option>
                </select>
            </div>

            <div class="mb-3">
                <input type="hidden" id="id_cliente" name="id_cliente" class="form-control" value="<?php echo $id_cliente ?>">
            </div>

            <div class="mb-3 d-grid gap-2">
                <button type="button" class="btn btn-success btn-sm" id="guardar_correo">Guardar</button>
            </div>

            <div class="mb-3 d-grid gap-2">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="offcanvas" aria-label="Close">Cancelar</button>
            </div>

        </form>
    </div>
</div>