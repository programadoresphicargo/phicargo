<?php
require_once('../../mysql/conexion.php');
?>

<div class="modal fade" id="modal_cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelación de Viaje</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Realmente quieres cancelar este viaje?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Close</button>
                <button id="cancelar_viaje" type="button" class="btn btn-danger">Cancelar viaje</button>
            </div>
        </div>
    </div>
</div>