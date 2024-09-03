<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM operadores where activo = 1";
$resultado = $cn->query($sql);
?>
<!-- Modal -->
<div class="modal fade" id="modal_postura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Postura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formpostura">

                    <div class="row">
                        <div class="col-3 mb-3">
                            <label class="form-label" for="exampleFormControlInput4">Vehiculo</label>
                            <input type="textl" class="form-control" id="nombre_vehiculo" name="nombre_vehiculo" disabled>
                        </div>
                    </div>

                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Datos del vehiculo</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Posturas</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="mb-3">
                                <input type="hidden" class="form-control" id="id_vehiculo" name="id_vehiculo">
                            </div>

                            <div class="row">
                                <div class="col-3 mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Sucursal</label>
                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" id="x_sucursal" name="x_sucursal">
                                            <option value="1">Veracruz</option>
                                            <option value="9">Manzanillo</option>
                                            <option value="2">México</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label class="form-label" for="exampleFormControlInput4">Operador asignado</label>
                                    <select class="form-select tom-select" id="x_operador_asignado" name="x_operador_asignado">
                                        <?php while ($row = $resultado->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_operador'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-4 mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Tipo de vehiculo</label>
                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" id="x_tipo_vehiculo" name="x_tipo_vehiculo">
                                            <option value="local">Local</option>
                                            <option value="carretera">Carretera</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4 mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Modalidad</label>
                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" id="x_modalidad" name="x_modalidad">
                                            <option value="sencillo">sencillo</option>
                                            <option value="full">full</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4 mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Tipo de carga</label>
                                    <div class="tom-select-custom">
                                        <select class="js-select form-select" id="x_tipo_carga" name="x_tipo_carga">
                                            <option value="imo">IMO</option>
                                            <option value="general">General</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-4 mb-3">
                                    <button type="button" class="btn btn-success btn-sm" onclick="actualizar()">Actualizar información</button>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <div class="row mt-3">
                                <div class="col-5">
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlInput4">Operador postura</label>
                                        <select class="form-select tom-select" id="id_operador" name="id_operador">
                                            <?php
                                            $resultado = $cn->query($sql);
                                            while ($row = $resultado->fetch_assoc()) { ?>
                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_operador'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label" for="exampleFormControlInput4">Motivo de postura</label>
                                        <input type="textl" class="form-control" id="motivo" name="motivo">
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div id="historial_posturas"></div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <button type="button" class="btn btn-danger" onclick="guardar_postura()">Registrar postura</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    var select1 = new TomSelect('#x_operador_asignado');
    var select2 = new TomSelect('#id_operador');

    function actualizar() {
        var datos = $("#formpostura").serialize();
        $.ajax({
            data: datos,
            url: 'guardar_vehiculo.php',
            type: 'POST',
            success: function(data) {
                if (data == 1) {
                    notyf.success('Datos actualizados.');
                    $('#modal_postura').modal('hide');
                    $("#tabla").load('tabla.php');
                } else {
                    notyf.error('Error en la actualización: ');
                    notyf.error(data);
                }
            },
            error: function(error) {
                console.error('Error al cargar los datos:', error);
            }
        });
    }

    function guardar_postura() {
        var datos = $("#formpostura").serialize();
        $.ajax({
            data: datos,
            url: 'guardar_postura.php',
            type: 'POST',
            success: function(data) {
                notyf.success(data);
                $("#historial_posturas").load('historial_posturas.php', {
                    'id_vehiculo': $("#id_vehiculo").val()
                })
            },
            error: function(error) {
                console.error('Error al cargar los datos:', error);
            }
        });
    }
</script>