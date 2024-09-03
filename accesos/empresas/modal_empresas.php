<div class="modal fade" id="canvas_empresas" tabindex="-1" aria-labelledby="modal_empresasLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_empresasLabel">Registro de empresas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="empresas_tabla"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#empresas_tabla").load('../empresas/empresas.php');
</script>