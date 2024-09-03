<!-- Modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="modal_ingresar_visitante" style="height: 100%;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Nuevo visitante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="info_visitante">

                    <div class="col-sm-12">
                        <div class="mb-4">
                            <label class="form-label sw-bold">Empresa</label>
                            <select id="id_empresa_2" name="id_empresa_2" class="form-control">
                                <option value=""></option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 sw-bold">
                        <label class="form-label" for="exampleFormControlInput1">Nombre del visitante</label>
                        <input type="text" class="form-control" id="nombre" name="nombre">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="registrar_visitante()">Registrar</button>
            </div>

        </div>
    </div>
</div>
<!-- End Modal -->
<script>
    function registrar_visitante() {
        var datos = $("#info_visitante").serialize();
        $.ajax({
            url: "../visitantes/ingresar_visitante.php",
            data: datos,
            type: "POST",
            success: function(response) {
                if (response == 1) {
                    notyf.success("Visitante registrado correctamente.");
                    $("#modal_ingresar_visitante").modal('hide');
                    $("#registros").load('../visitantes/index.php');
                } else if (response == 2) {
                    notyf.error("Visitante ya registrado.");
                } else {
                    notyf.error("Error en la solicitud" + response);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
            }
        });
    }
</script>