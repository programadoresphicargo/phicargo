<?php
require_once('../../mysql/conexion.php');
$mysqli = conectar();
$query_op = "SELECT id, nombre_operador FROM operadores ORDER BY nombre_operador ASC";
$query_eco = "SELECT placas, unidad FROM unidades ORDER BY UNIDAD ASC";

$resultado_op = $mysqli->query($query_op);
$resultado_eco = $mysqli->query($query_eco);

?>

<div class="modal fade" id="modal_editar_turno" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fw-bold">Información del turno</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row-1 mb-5" id="btns-ingresar" style="display:none">
                    <button id="BtnIngresarOpcola" type="button" class="btn btn-primary btn-sm"><i class="bi bi-floppy"></i> Ingresar turno</button>
                </div>
                <div class="row-1 mb-5" id="btns-editar" style="display:none">
                    <button id="BtnEditar" type="button" class="btn btn-primary btn-xs"><i class="bi bi-pen"></i> Editar</button>
                    <button id="BtnGuardar" type="button" class="btn btn-success btn-xs"><i class="bi bi-save"></i> Guardar</button>
                    <button id="Fijar_turno" type="button" class="btn btn-primary btn-xs"><i class="bi bi-pin"></i> Fijar turno</button>
                    <button id="Soltar_turno" type="button" class="btn btn-primary btn-xs"><i class="bi bi-pin-fill"></i>Soltar turno</button>
                    <button id="Viaje_asignado" type="button" class="btn btn-success btn-xs">Archivar turno</button>
                    <button id="asignar_viaje" type="button" class="btn btn-success btn-xs" style="display: none;"> Asignar viaje</button>
                    <button id="asignar_maniobra" type="button" class="btn btn-success btn-xs" style="display: none;"> Asignar maniobra</button>
                    <button id="abrir_modal_incidencia" type="button" class="btn btn-danger btn-xs"> Registrar incidencia</button>
                    <button id="BtnEnviarOpcola" type="button" class="btn btn-danger btn-xs">Enviar a la cola </button>
                </div>

                <form id="FormEditar">

                    <div class="row">
                        <div class="col-5">

                            <input type="hidden" name="id_turno" id="id_turno" class="form-control form-control-sm">
                            <input type="hidden" name="sucursal" id="sucursal" class="form-control form-control-sm">

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label class="col-sm-12 col-form-label form-label" data-add-required="true" data-edit-required="true">Unidad</label>
                                    <select class="form-control required" name="placas" id="placas">
                                        <option value=""> Seleccionar Unidad </option>
                                        <?php while ($row = $resultado_eco->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['placas']; ?>"><?php echo $row['unidad']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="col-sm-12 col-form-label form-label">Operador</label>
                                    <select class="form-control required" name="id_operador" id="id_operador">
                                        <option value=""> Seleccionar Operador </option>
                                        <?php while ($row = $resultado_op->fetch_assoc()) { ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nombre_operador']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-6">
                                    <label class="col-sm-12 col-form-label form-label">Fecha llegada</label>
                                    <input type="date" class="form-control required" name="fecha_llegada" id="fecha_llegada">
                                </div>

                                <div class="col-6">
                                    <label class="col-sm-12 col-form-label form-label">Hora llegada</label>
                                    <input type="time" class="form-control required" name="hora_llegada" id="hora_llegada" step="2">
                                </div>

                                <div class="col">
                                    <label class="col-sm-12 col-form-label form-label">Maniobra 1</label>
                                    <select class="form-select" id="maniobra1" name="maniobra1">
                                        <option value=""></option>
                                        <option value="importacion">Importación</option>
                                        <option value="exportacion">Exportación</option>
                                        <option value="vacio">Vacio</option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label class="col-sm-12 col-form-label form-label">Maniobra 2</label>
                                    <select class="form-select" id="maniobra2" name="maniobra2">
                                        <option value=""></option>
                                        <option value="importacion">Importación</option>
                                        <option value="exportacion">Exportación</option>
                                        <option value="vacio">Vacio</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="col">
                                <label class="col-sm-12 col-form-label form-label">Comentarios</label>
                                <textarea class="form-control" name="comentarios" id="comentarios" rows="6"></textarea>
                            </div>

                            <div class="col">
                                <label class="col-sm-12 col-form-label form-label">Creado por</label>
                                <input type="text" class="form-control no-editable" name="usuario_registro" id="usuario_registro">
                            </div>

                            <div class="col">
                                <label class="col-sm-12 col-form-label form-label">Fecha de registro</label>
                                <input type="text" class="form-control no-editable" name="fecha_registro" id="fecha_registro">
                            </div>
                        </div>

                        <div class="col-3">

                            <ul class="step">

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <span class="step-icon step-icon-soft-dark">M</span>

                                        <div class="step-content">
                                            <h5 class="mb-1">ICAVE</h5>
                                            <span class="badge bg-primary">Retiro</span>
                                            <p class="fs-5 mb-1">2024/08/01</span></p>
                                        </div>
                                    </div>
                                </li>

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <small class="step-divider">Yesterday</small>
                                    </div>
                                </li>

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <span class="step-icon step-icon-soft-info">D</span>

                                        <div class="step-content">
                                            <h5 class="mb-1">ICAVE</h5>
                                            <span class="badge bg-warning">Ingreso</span>
                                            <p class="fs-5 mb-1">2024/08/07</p>
                                        </div>
                                    </div>
                                </li>


                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <span class="step-icon step-icon-soft-info">D</span>

                                        <div class="step-content">
                                            <h5 class="mb-1">ICAVE</h5>
                                            <span class="badge bg-warning">Ingreso</span>
                                            <p class="fs-5 mb-1">2024/08/07</p>
                                        </div>
                                    </div>
                                </li>


                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <span class="step-icon step-icon-soft-info">D</span>

                                        <div class="step-content">
                                            <h5 class="mb-1">ICAVE</h5>
                                            <span class="badge bg-warning">Ingreso</span>
                                            <p class="fs-5 mb-1">2024/08/06</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <small class="step-divider">Last week</small>
                                    </div>
                                </li>

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <span class="step-icon step-icon-soft-info">D</span>

                                        <div class="step-content">
                                            <h5 class="mb-1">ICAVE</h5>
                                            <span class="badge bg-warning">Ingreso</span>
                                            <p class="fs-5 mb-1">2024/08/06</p>
                                        </div>
                                    </div>
                                </li>

                                <li class="step-item">
                                    <div class="step-content-wrapper">
                                        <span class="step-icon step-icon-soft-info">D</span>

                                        <div class="step-content">
                                            <h5 class="mb-1">ICAVE</h5>
                                            <span class="badge bg-warning">Ingreso</span>
                                            <p class="fs-5 mb-1">2024/08/06</p>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
            </div>
            </form>

            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Salir</button>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="ConfirmarEnviocola" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger" id="exampleModalLabel">Especificar salida</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="ColaDetalles">
                    <div class="form-check mb-3">
                        <input type="radio" id="opcion_1" class="form-check-input" name="formRadio" checked value="1">
                        <label class="h5" for="formRadio1">Salida a las 9:00 a.m.</label>
                        <div class="text-muted">El operador reingresa a la lista de turnos a las 9:00 a.m. del día siguiente.</div>
                    </div>
                    <!-- End Checkbox -->

                    <hr>

                    <!-- Checkbox -->
                    <div class="form-check mb-3">
                        <input type="radio" id="opcion_3" class="form-check-input" name="formRadio" value="3">
                        <label class="h5" for="formRadio4">Especificar salida de la cola.</label>
                        <div class="text-muted text-title">Determinar la fecha y hora de salida del turno.</div>
                    </div>


                    <div id="sec3">
                        <div class="d-flex mb-4">
                            <i class="bi-calendar-week nav-icon mt-2 me-2"></i>

                            <div class="flex-grow-1">
                                <input type="date" id="fecha_salida" name="fecha_salida" class="js-flatpickr form-control flatpickr-custom mb-2" placeholder="Select dates">
                            </div>
                        </div>

                        <div class="d-flex mb-4">
                            <i class="bi bi-alarm nav-icon mt-2 me-2"></i>

                            <div class="flex-grow-1">

                                <!-- Select -->
                                <div class="tom-select-custom">
                                    <select id="hora_salida" name="hora_salida" class="js-select form-select">
                                        <option value="00:00">00:00</option>
                                        <option value="01:00">01:00</option>
                                        <option value="02:00">02:00</option>
                                        <option value="03:00">03:00</option>
                                        <option value="04:00">04:00</option>
                                        <option value="05:00">05:00</option>
                                        <option value="06:00">06:00</option>
                                        <option value="07:00">07:00</option>
                                        <option value="08:00">08:00</option>
                                        <option value="09:00" selected>09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                        <option value="17:00">17:00</option>
                                        <option value="18:00">18:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="20:00">20:00</option>
                                        <option value="21:00">21:00</option>
                                        <option value="22:00">22:00</option>
                                        <option value="23:00">23:00</option>
                                    </select>
                                </div>
                                <!-- End Select -->
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button btn-sm" class="btn btn-white" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger btn-sm" id="BtnConfirmarEnviarOpcola">Enviar a la cola</button>
            </div>
        </div>
    </div>
</div>

<script>
    const miBoton = document.getElementById("asignar_viaje");
    miBoton.addEventListener("click", function() {
        console.log("Se hizo clic en el botón");
        $('#asignacion_viaje_canvas').offcanvas('show');
        console.log($('#FormEditar').serialize());
        operadorup.disabled = false;
        $.post('../asignacion_viaje/tabla.php', $('#FormEditar').serialize(), function(data) {
            $('#viajes_disponibles').html(data);
        });
    });
</script>