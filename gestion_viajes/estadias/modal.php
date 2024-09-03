<div class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="modal_estadias">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myExtraLargeModalLabel">Pago de estadías</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="page-header">
                    <div class="row align-items-start">
                        <div class="col-sm-auto">
                            <a class="btn btn-primary btn-sm" id="guardar_cobro">
                                <i class="bi bi-floppy"></i> Guardar
                            </a>
                        </div>
                        <div class="col-sm-auto">
                            <a class="btn btn-success btn-sm" id="confirmar_cobro">
                                <i class="bi bi-check2"></i> Confirmar
                            </a>
                        </div>
                        <div class="col-sm-auto">
                            <a class="btn btn-danger btn-sm" id="abrir_modal_cancelacion">
                                <i class="bi bi-x"></i> No procede a cobro
                            </a>
                        </div>
                    </div>
                </div>

                <form id="formcobroestadia">

                    <input type="hidden" class="form-control" id="id_estadia" name="id_estadia">
                    <input type="hidden" class="form-control" id="id_viaje" name="id_viaje">

                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1">Horas calculadas por el sistema</label>
                                <input type="text" class="form-control" id="horas_sistema" name="horas_sistema">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1">Horas a cobrar</label>
                                <input type="number" class="form-control" id="horas_cobro" name="horas_cobro">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1">Precio por hora</label>
                                <input type="number" class="form-control" id="precio_hora" name="precio_hora">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1">Total a cobrar</label>
                                <input type="number" class="form-control" id="total_cobrar" name="total_cobrar">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="exampleFormControlSelect1">Factura</label>
                                <select class="form-select" aria-label="Default select example" id="idfactura" name="idfactura">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlTextarea1">Comentarios</label>
                        <textarea class="form-control" rows="3" id="notas" name="notas"></textarea>
                    </div>

                </form>
                <h1 class="mt-5">Evidencias</h1>
                <form>
                    <div id="dropzoneadjuntos" class="js-dropzone dz-dropzone dz-dropzone-card">
                        <div class="dz-message">
                            <img class="avatar avatar-xl avatar-4x3 mb-3" src="../../img/cajita.svg" alt="C">

                            <h5>Arrastra y suelta aqui tus archivos</h5>

                            <p class="mb-2">o</p>

                            <span class="btn btn-white btn-sm">Abrir explorador de archivos</span>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>