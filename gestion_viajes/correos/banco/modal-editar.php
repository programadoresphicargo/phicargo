<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "select id, nombre from clientes";
$result = $cn->query($sqlSelect);
?>

<!-- Modal -->
<div class="modal fade" id="modal_editar_correo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Correo Electrónico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormEditarCorreo">
                    <input class="form-control" type="hidden" id="idcorreoup" name="idcorreoup">
                    <div class="form-group row p-1">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Nombre</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nombreup" name="nombreup" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Correo</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="correoup" name="correoup" placeholder="">
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Cliente</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="clienteup" name="clienteup">
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row p-1">
                        <label for="inputPassword" class="col-sm-2 col-form-label">Tipo</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" id="tipoup" name="tipoup">
                                <option value="Destinatario">Destinatario</option>
                                <option value="CC">CC</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button id="editar_correo" type="button" class="btn btn-primary btn-sm">Guardar</button>
                <button id="mostrar_modal_eliminar" class="btn btn-danger btn-sm">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->