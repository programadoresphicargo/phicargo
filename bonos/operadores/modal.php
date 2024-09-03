<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Añadir comentarios</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div id="cronologia"></div>
    </div>
    <div class="offcanvas-footer">
        <form id="FormComentarios">
            <div class="mb-3">
                <input type="hidden" id="id_bono" name="id_bono">
                <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['userID'] ?>">
                <label class="form-label" for="exampleFormControlTextarea1">Añadir comentario:</label>
                <textarea id="comentario" name="comentario" class="form-control" placeholder="Textarea field" rows="2"></textarea>
            </div>
        </form>
        <div class="row">
            <div class="col">
                <button type="button" id="guardar_comentario" class="btn btn-primary btn-sm btn-block mt-3">Guardar</button>
            </div>
        </div>
    </div>
</div>