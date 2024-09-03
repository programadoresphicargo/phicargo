<!-- Modal -->
<div class="modal fade" id="abrir_modal_excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualización Lineas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm mb-5">
                        <!-- List Checked -->
                        <p>Instrucciones del uso y llenado del formato Complemento Carta Porte</p>
                        <ul class="list-checked list-checked-sm list-checked-primary">
                            <li class="list-checked-item">No se puede modificar la estructura del formato.</li>
                            <li class="list-checked-item">Los campos de color verde son obligatorios de capturar.</li>
                            <li class="list-checked-item">La columna F (material_peligroso) se debe especificar con un "Sí" o un "No" (No puede quedar vacia) respetando mayusculas y acentos.</li>
                        </ul>
                        <!-- End List Checked -->
                        <a href="../lineas_excel/formato.xlsx" class="link link-primary mt-5 mb-5">Descargar formato de llenado</a>

                    </div>
                </div>

                <form id="files_excel" form-no-validation>
                    <label for="basicFormFile" class="js-file-attach form-label">Importación por Excel</label>
                    <input class="form-control" type="file" id="archivo" name="archivo" placeholder="holi">
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary btn-sm" id="subir_excel">Subir</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->