<!-- Modal -->
<div class="modal fade" id="listado_cuentas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Listado de cuentas bancarias</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-5">
                    <div class="col">
                        <button class="btn btn-success btn-sm" id="abrir_form_cuenta"><i class="bi bi-plus-lg"></i> Nueva cuenta</button>
                    </div>
                </div>

                <div id="cuentas"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
<script>
    const abrir_form_cuenta = document.getElementById('abrir_form_cuenta');

    abrir_form_cuenta.addEventListener('click', () => {
        $("#añadir_nueva_cuenta").offcanvas('show');
        $("#registrar_cuenta").css('display', 'block');
        $("#guardar_cambios_cuenta").css('display', 'none');

        var formulario2 = document.getElementById("form_nueva_cuenta");
        formulario2.reset();
    });
</script>