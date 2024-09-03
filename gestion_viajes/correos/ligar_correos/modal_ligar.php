<div class="offcanvas offcanvas-end" tabindex="-1" id="modal_ligar_correos" aria-labelledby="offcanvasRightLabel" style="width: 45%;">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Correos ligados a viaje</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id='FormLigarCorreo'>
            <div class="input-group">
                <select class="js-select form-select" autocomplete="off" id="correoscliente" name="correoscliente"></select>
                <button type="button" class="btn btn-primary" id="LigarCorreo">Ligar</button>
            </div>
        </form>
        <div id="listado_correos_ligados">
        </div>
    </div>
</div>