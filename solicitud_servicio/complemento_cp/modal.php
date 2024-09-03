<!-- Modal -->
<div id="modallineascomplemento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Lineas Complemento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formlc" form-no-validation>
                    <div class="row mt-4">

                        <input type="hidden" id="id_mercancia" name="id_mercancia" class="form-control form-control-sm" data-no-validation>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="description">Descripción del producto</label>
                                <div class="col-sm-7">
                                    <div class="input-group  input-group-flush">
                                        <input type="text" id="description" name="description" class="form-control form-control-sm" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="dimensions_charge">Dimensiones</label>
                                <div class="col-sm-7">
                                    <div class="input-group  input-group-flush">
                                        <input type="text" id="dimensions_charge" name="dimensions_charge" class="form-control form-control-sm" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="quantity">Cantidad</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-flush">
                                        <input type="number" id="quantity" name="quantity" class="form-control form-control-sm" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="sat_product_id">Producto SAT</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-flush">
                                        <select id="sat_product_id" name="sat_product_id" class="form-control form-control-sm">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="sat_uom_id">UDM SAT</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-flush">
                                        <select id="sat_uom_id" name="sat_uom_id" class="form-select" iniciar="false">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="weight_charge">Peso en KG</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-flush">
                                        <input type="text" id="weight_charge" name="weight_charge" class="form-control form-control-sm" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="hazardous_material">Material Peligroso</label>
                                <div class="col-sm-7">
                                    <div class="input-group input-group-flush">
                                        <select id="hazardous_material" name="hazardous_material" class="form-control form-control-sm" iniciar="false">
                                            <option value=""></option>
                                            <option value="Sí">Si</option>
                                            <option value="No">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="hazardous_key_product_id">Clave material peligroso</label>
                                <div class="col-sm-7">
                                    <div class="input-group  input-group-flush">
                                        <select id="hazardous_key_product_id" name="hazardous_key_product_id" class="form-control form-control-sm" iniciar="false" style="display: none;">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row">
                                <label class="col-sm-5 col-form-label" for="tipo_embalaje_id">Tipo de embalaje</label>
                                <div class="col-sm-7">
                                    <div class="input-group  input-group-flush">
                                        <select id="tipo_embalaje_id" name="tipo_embalaje_id" class="form-control form-control-sm" data-no-validation>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn-sm" id="actualizar_mercancia" style="display: none;">Actualizar</button>
                <button type="button" class="btn btn-primary btn-sm" id="guardar_mercancia" style="display:  none;">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->