<div class="offcanvas offcanvas-end" tabindex="-1" id="info_unidad" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Unidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Select -->
        <form id="FormInfoEquipo">
            <input id="id_unidad" name="id_unidad" type="text">
            <div class="input-group input-group-merge input-group-flush">
                <div class="input-group-prepend input-group-text">
                    <i class="bi-person"></i>
                </div>
                <select class="js-select form-select" id="estado" name="estado">
                    <option value="disponible">Disponible</option>
                    <option value="viaje">En viaje</option>
                    <option value="mantenimiento">Mantenimiento</option>
                    <option value="maniobra">Maniobra</option>
                </select>
            </div>
        </form>
        <div class="d-grid gap-2 m-3">
            <button class="btn btn-primary" type="button" id="guardar_estado">Guardar</button>
        </div>
    </div>
    <!-- End Select -->
</div>
</div>