<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT ID, NOMBRE FROM clientes";
$result = $cn->query($sqlSelect);
?>

<div class="modal fade" id="modal_ingresar_correo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresar Correo Electrónico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormIngresarCorreo">
                    <input class="form-control" type="hidden" id="id" name="id">

                    <div class="col-lg-12 mb-3" id="">
                        <div class="form-group formulario__grupo-input input-group p-1">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Cliente</span>
                                </div>
                                <select class="form-select" id="idcliente" name="idcliente">
                                    <?php while ($row = $result->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['ID']; ?>"><?php echo $row['NOMBRE']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-3" id="">
                        <div class="form-group formulario__grupo-input input-group p-1">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Nombre completo</span>
                                </div>
                                <input type="text" class="form-control formulario__input" id="nombre" name="nombre">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-3" id="grupo-correo">
                        <div class="form-group formulario__grupo-input input-group p-1">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Correo Electronico</span>
                                </div>
                                <input type="text" class="form-control formulario__input" id="correo" name="correo">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 mb-3" id="grupo-correo">
                        <div class="form-group formulario__grupo-input input-group p-1">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Tipo</span>
                                </div>
                                <select class="form-select" aria-label="Default select example" id="tipo" name="tipo">
                                    <option value="Destinatario">Destinatario</option>
                                    <option value="CC">CC</option>
                                </select>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button id="ingresar_correo" type="button" class="btn btn-danger btn-sm">Ingresar</button>
            </div>
        </div>
    </div>
</div>