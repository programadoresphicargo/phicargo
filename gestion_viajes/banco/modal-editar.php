<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "select id, nombre from clientes";
$result = $cn->query($sqlSelect);
?>

<!-- Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="modal_editar_correo" aria-labelledby="offcanvasRightLabel" style="width:40%">
    <div class="offcanvas-header">
        <h5 class="modal-title">Editar Correo Electrónico</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <form id="FormEditarCorreo">
            <input class="form-control" type="hidden" id="idcorreoup" name="idcorreoup">

            <!-- Input Group -->
            <div class="mb-3">
                <label for="inputGroupFlushFullName" class="form-label">Nombre</label>

                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <input type="text" class="form-control" id="nombreup" name="nombreup">
                </div>
            </div>
            <!-- End Input Group -->

            <!-- Input Group -->
            <div class="mb-3">
                <label for="inputGroupFlushFullName" class="form-label">Correo electronico</label>

                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <input type="text" class="form-control" id="correoup" name="correoup">
                </div>
            </div>
            <!-- End Input Group -->

            <!-- Input Group -->
            <div class="mb-3">
                <label for="inputGroupFlushGenderSelect" class="form-label">Cliente</label>

                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                    <select id="clienteup" name="clienteup" class="form-select">
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- End Input Group -->

            <!-- Input Group -->
            <div class="mb-3">
                <label for="inputGroupFlushGenderSelect" class="form-label">Tipo</label>

                <div class="input-group input-group-merge input-group-flush">
                    <div class="input-group-prepend input-group-text">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <select id="tipoup" name="tipoup" class="form-select">
                        <option value="Destinatario">Destinatario</option>
                        <option value="CC">CC</option>
                    </select>
                </div>
            </div>
            <!-- End Input Group -->
        </form>
    </div>
    <div class="offcanvas-footer">
        <button id="editar_correo" type="button" class="btn btn-success btn-sm"><i class="bi bi-pen"></i>Actualizar</button>
        <button id="mostrar_modal_eliminar" class="btn btn-danger btn-sm"><i class="bi bi-x-circle"></i> Baja</button>
    </div>
</div>