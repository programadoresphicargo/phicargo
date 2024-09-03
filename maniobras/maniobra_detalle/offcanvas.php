<div class="offcanvas offcanvas-start" tabindex="-1" id="detalle_maniobra" aria-labelledby="offcanvasExampleLabel" style="width: 100%;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Maniobra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" id="maniobrasregistradas">
    </div>
</div>

<script>
    function nueva_maniobra(id_cp) {
        $("#exampleModal").modal('show');
        $("#id_cp").val(id_cp).change();
        estado_maniobra('nueva');
    }

    function abrir_modal_correos(partner_id) {
        $("#modal_maniobras_correos").offcanvas('show');
        $.ajax({
            url: '../correos/contenido.php',
            type: 'POST',
            data: {
                'partner_id': partner_id
            },
            success: function(response) {
                $('#contenido_correos_maniobra').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                notyf.error(textStatus);
            }
        });
    }
</script>