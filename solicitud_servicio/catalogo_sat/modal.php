<div class="modal fade" id="modal_catalogo_sat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Catalogo Sat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group mb-3">
                        <label>Clave o descripción</label>
                        <input type="text" class="form-control" id="buscador_sat" placeholder="Ingresar clave del producto SAT o la descripción">
                    </div>
                </form>

                <div class="text-center" id="spinner" role="status">
                    <div class="spinner-border text-primary" role="status">
                    </div>
                </div>

                <div id="catalogo_sat">
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>