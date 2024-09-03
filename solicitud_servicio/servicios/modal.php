<div class="modal fade" id="modal_servicios" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProductos" form-no-validation>

                    <input type="hidden" id="id_servicio" name="id_servicio" class="form-control" data-no-validation>

                    <div class="mb-2">
                        <div class="form-group row">
                            <label for="product_id" class="col-sm-4 col-form-label">Producto</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group-flush">
                                    <select id="product_id" name="product_id" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="form-group row">
                            <label for="weight_estimation" class="col-sm-4 col-form-label">Peso estimado (Toneladas)</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group-flush">
                                    <input id="weight_estimation" name="weight_estimation" class="form-control" autocomplete="off" type="number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="form-group row">
                            <label for="notes" class="col-sm-4 col-form-label">Referencia contenedor o numero de bultos (Carga Suelta)</label>
                            <div class="col-sm-8">
                                <div class="input-group input-group-flush">
                                    <input id="notes" name="notes" class="form-control" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-sm" id="actualizar_servicio">Guardar</button>
                <button class="btn btn-primary btn-sm" id="guardar_servicio">Guardar</button>
            </div>
        </div>
    </div>
</div>