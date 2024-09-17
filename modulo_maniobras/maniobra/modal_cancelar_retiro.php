<div class="offcanvas offcanvas-start bg-danger" id="reactivar_maniobra_retiro" tabindex="-1" style="z-index: 1050;">
    <div class="offcanvas-header">
        <h5 class="modal-title text-white">Reactivar maniobra de retiro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-white">
        Maniobra anteriormente finalizada, ¿Desea reactivar?
    </div>
    <div class="offcanvas-footer">
        <button type="button" class="btn btn-white" data-bs-dismiss="offcanvas">Cancelar</button>
        <button type="button" class="btn btn-primary" id="cancelar_retiro">Reactivar</button>
    </div>
</div>

<script>
    $("#cancelar_retiro").click(function() {
        $.ajax({
            url: "../maniobra/cancelar_maniobra.php",
            type: "POST",
            data: {
                id_cp: '<?php echo $_POST['id'] ?> ',
                tipo_maniobra: "Retiro"
            },
            success: function(response) {
                if (response == 1) {
                    notyf.success('Maniobra de retiro reabierta');
                    $("#reactivar_maniobra_retiro").offcanvas('hide');
                } else {
                    notyf.error(response);
                }
            },
            error: function() {
                alert("Error en la solicitud Ajax");
            }
        });
    });
</script>