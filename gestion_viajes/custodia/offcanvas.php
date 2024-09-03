<div class="offcanvas offcanvas-end" tabindex="-1" id="canvas_custodia" aria-labelledby="offcanvasRightLabel" style="width:30%;">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Datos custodia</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">

        <form id="form_custodia">
            <div class="mb-3">
                <label class="form-label" for="exampleFormControlInput1">Empresa custodia</label>
                <input type="text" id="x_empresa_custodia" name="x_empresa_custodia" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label" for="exampleFormControlTextarea1">Nombre custodios</label>
                <textarea id="x_nombre_custodios" name="x_nombre_custodios" class="form-control" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="exampleFormControlTextarea1">Datos del vehiculo (Modelo, placas, color)</label>
                <textarea id="x_datos_unidad" name="x_datos_unidad" class="form-control" rows="4"></textarea>
            </div>
        </form>

        <button id="guardar_custodia" class="btn btn-primary">Guardar información</button>

    </div>
</div>