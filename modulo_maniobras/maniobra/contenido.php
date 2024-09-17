<?php

function calcularTiempoTranscurrido($fecha1, $fecha2)
{
    $fechaActual = time();
    $fecha1Timestamp = strtotime($fecha1);

    // Si se proporciona una segunda fecha, calcular la diferencia entre las fechas.
    if ($fecha2 !== null) {
        $fecha2Timestamp = strtotime($fecha2);
        $diferenciaSegundos = $fecha2Timestamp - $fecha1Timestamp;
    } else {
        // Si no se proporciona una segunda fecha, calcular la diferencia entre la fecha dada y la fecha actual.
        $diferenciaSegundos = $fechaActual - $fecha1Timestamp;
    }

    $dias = floor($diferenciaSegundos / (60 * 60 * 24));
    $horas = floor(($diferenciaSegundos % (60 * 60 * 24)) / (60 * 60));
    $minutos = floor(($diferenciaSegundos % (60 * 60)) / 60);
    $segundos = $diferenciaSegundos % 60;

    return array(
        "dias" => $dias,
        "horas" => $horas,
        "minutos" => $minutos,
        "segundos" => $segundos
    );
}
?>

<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid p-0">
        <div class="row justify-content-lg-center">
            <div class="col-lg-12">

                <!-- Page Header -->
                <div class="container">
                    <!-- Media -->
                    <div class="d-sm-flex align-items-lg-center">

                        <div class="flex-grow-1">
                            <div class="row">
                                <div class="col-md mb-3 mb-md-0">


                                    <?php
                                    $id_cliente;
                                    foreach ($products as $datos) { ?>
                                        <h1 class="mt-3 h1 mb-1"><?php echo $datos['name'] == null ? $_POST['id'] : $datos['name']  ?></h1>
                                        <h3 class="mt-3 h1 mb-1"><?php echo $_POST['id']  ?></h1>

                                            <!-- Rating -->
                                            <?php if ($datos['x_reference'] != null) { ?>
                                                <div class="d-flex gap-1">
                                                    <span class="fw-semibold text-dark ms-1">Contenedor:</span>
                                                    <span class="ms-1"><?php echo $datos['x_reference'] ?></span>
                                                </div>
                                            <?php } ?>
                                            <div class="d-flex gap-1">
                                                <span class="fw-semibold text-dark ms-1">Cliente:</span>
                                                <span class="ms-1"><?php echo $datos['partner_id'][1] ?></span>
                                                <?php $id_cliente = $datos['partner_id'][0] ?>
                                            </div>


                                            <div class="d-flex gap-1">
                                                <span class="fw-semibold text-dark ms-1">Status:</span>

                                                <?php
                                                if ($datos['x_status_bel'] == 'Ing') {
                                                    echo "<td class='text-center'><span class='badge bg-success rounded-pill'>Ingresado</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'No Ing') {
                                                    echo "<td class='text-center'><span class='badge bg-danger rounded-pill'>No Ingresado</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'pm') {
                                                    echo "<td class='text-center'><span class='badge bg-warning rounded-pill'>Patio México</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'sm') {
                                                    echo "<td class='text-center'><span class='badge bg-warning rounded-pill'>Sin Maniobra</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'EI') {
                                                    echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>En proceso de ingreso</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'ru') {
                                                    echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>Reutilizado</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'can') {
                                                    echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>Cancelado</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'P') {
                                                    echo "<td class='text-center'><span class='badge bg-morado rounded-pill'>En Patio</span></td>";
                                                } elseif ($datos['x_status_bel'] == 'V') {
                                                    echo "<td class='text-center'><span class='badge bg-primary rounded-pill'>En Viaje</span></td>";
                                                } else {
                                                    echo "<td class='text-center'><span class='badge bg-dark rounded-pill'>Sin Status</span></td>";
                                                }
                                                ?>

                                            </div>
                                            <div class="d-flex gap-1">
                                                <span class="fw-semibold text-dark ms-1">Ejecutivo:</span>
                                                <span class="ms-1"><?php echo $datos['x_ejecutivo_viaje_bel'] ?></span>
                                            </div>

                                            <div class="d-flex gap-1">
                                                <span class="fw-semibold text-dark ms-1">Llegada a patio:</span>
                                                <span class="ms-1"><?php echo $datos['x_llegada_patio'] ?></span>
                                            </div>

                                            <div class="d-flex gap-1">
                                                <span class="fw-semibold text-dark ms-1">Fecha de ingreso:</span>
                                                <span class="ms-1"><?php echo $datos['x_fechaing_bel'] ?></span>
                                            </div>
                                            <!-- End Rating -->
                                        <?php } ?>

                                </div>
                                <!-- End Col -->

                                <div class="col-md-auto align-self-md-end">
                                    <div class="d-grid d-sm-flex gap-2">
                                        <button type="button" class="btn btn-success btn-sm" disabled><i class="bi bi-whatsapp"></i> Números celular</button>
                                        <button type="button" class="btn btn-primary btn-sm" id="abrir_correos_ligados"><i class="bi bi-envelope"></i> Correos Electrónicos</button>
                                    </div>
                                </div>
                                <!-- End Col -->
                            </div>
                            <!-- End Row -->
                        </div>
                    </div>
                    <!-- End Media -->

                    <!-- Nav -->
                    <div class="js-nav-scroller hs-nav-scroller-horizontal mb-5">
                        <span class="hs-nav-scroller-arrow-prev" style="display: none;">
                            <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                                <i class="bi-chevron-left"></i>
                            </a>
                        </span>

                        <span class="hs-nav-scroller-arrow-next" style="display: none;">
                            <a class="hs-nav-scroller-arrow-link" href="javascript:;">
                                <i class="bi-chevron-right"></i>
                            </a>
                        </span>

                        <ul class="nav nav-tabs align-items-center">
                            <li class="nav-item">
                                <a class="nav-link active" href="./user-profile.html">Inicio</a>
                            </li>

                            <li class="nav-item ms-auto">
                                <div class="d-flex gap-2">
                                    <button class="btn btn-info btn-sm" type="button" id="abrir_archivos_adjuntos"><i class="bi bi-file-earmark-text"></i> Archivos adjuntos</button>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- End Nav -->
                </div>
                <!-- End Page Header -->

                <div class="row">
                    <div id="datos_maniobra_retiro" class="col-lg-4 animate__animated animate__fadeIn">

                        <!-- Sticky Block Start Point -->
                        <div id="accountSidebarNav"></div>

                        <div id="InfoManiobra1"></div>
                    </div>

                    <div class="col-lg-8">
                        <div class="d-grid gap-3 gap-lg-5">
                            <!-- Card -->
                            <div class="card">
                                <!-- Header -->
                                <div class="card-header card-header-content-between">
                                    <h4 class="card-header-title">Línea del tiempo <span class="badge bg-primary M1etiqueta">Finalizada</span></h4>

                                    <div class="col-auto">
                                        <button type="button" class="M1iniciar btn btn-success btn-sm retiro" id="abrir_checklist_1" style="display:none"><i class="bi bi-send-plus"></i> Iniciar </button>
                                        <button type="button" class="M1checklist btn btn-danger btn-sm ingreso"><i class="bi bi-list-check"></i> CheckList </button>
                                        <button type="button" class="M1finalizar btn btn-danger btn-sm retiro" data-bs-toggle="modal" data-bs-target="#modal_finalizar" style="display:none"><i class="bi bi-send-plus"></i> Finalizar </button>
                                        <button type="button" class="M1status btn btn-primary btn-sm retiro" id="abrir_modal_status1"><i class="bi bi-send-plus"></i> Enviar status</button>
                                    </div>
                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body card-body-height" style="height: 30rem;">
                                    <!-- Step -->
                                    <div id="linea_tiempo_status_retiro"></div>
                                    <!-- End Step -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <div class="card-footer">
                                </div>
                                <!-- End Footer -->
                            </div>
                            <!-- End Card -->
                        </div>

                        <!-- Sticky Block End Point -->
                        <div id="stickyBlockEndPoint"></div>
                    </div>

                    <div class="mb-5"></div>

                    <div id="datos_maniobra_ingreso" class="col-lg-4 animate__animated animate__fadeIn">

                        <!-- Sticky Block Start Point -->
                        <div id="accountSidebarNav"></div>

                        <div id="InfoManiobra2"></div>
                    </div>

                    <div class="col-lg-8">
                        <div class="d-grid gap-3 gap-lg-5">
                            <!-- Card -->
                            <div class="card">
                                <!-- Header -->
                                <div class="card-header card-header-content-between">
                                    <h4 class="card-header-title">Línea del tiempo <span class="badge bg-primary M2etiqueta">Finalizada</span></h4>

                                    <div class="col-auto">
                                        <button type="button" class="M2iniciar btn btn-success btn-sm ingreso" style="display:none" id="abrir_checklist_2"><i class="bi bi-send-plus"></i> Iniciar </button>
                                        <button type="button" class="M2checklist btn btn-danger btn-sm ingreso"><i class="bi bi-list-check"></i> CheckList </button>
                                        <button type="button" class="M2finalizar btn btn-danger btn-sm ingreso" data-bs-toggle="modal" data-bs-target="#modal_finalizar" style="display:none"><i class="bi bi-send-plus"></i> Finalizar </button>
                                        <button type="button" class="M2status btn btn-primary btn-sm ingreso" id="abrir_modal_status2"><i class="bi bi-send-plus"></i> Enviar status</button>
                                    </div>

                                </div>
                                <!-- End Header -->

                                <!-- Body -->
                                <div class="card-body card-body-height" style="height: 30rem;">
                                    <!-- Step -->
                                    <div id="linea_tiempo_status_ingreso"></div>
                                    <!-- End Step -->
                                </div>
                                <!-- End Body -->

                                <!-- Footer -->
                                <div class="card-footer">
                                </div>
                                <!-- End Footer -->
                            </div>
                            <!-- End Card -->
                        </div>

                        <!-- Sticky Block End Point -->
                        <div id="stickyBlockEndPoint"></div>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->
</main>

<script>
    function InfoManiobraRetiro(terminal, horario, id_operador, eco, r1, r2, dolly, tipoterminal, moto1, moto2) {
        $('#AsignarEquipoMR').offcanvas('show');
        $("#x_mov_bel").val(terminal);
        $("#x_inicio_programado_retiro").val(horario);

        try {
            new TomSelect('#x_operador_retiro_id').setValue(id_operador);
            new TomSelect('#x_eco_retiro_id').setValue(eco);
            new TomSelect('#x_remolque_1_retiro').setValue(r1);
            new TomSelect('#x_remolque_2_retiro').setValue(r2);
            new TomSelect('#x_dolly_retiro').setValue(dolly);
            new TomSelect('#x_tipo_terminal_retiro').setValue(tipoterminal);
            new TomSelect('#x_motogenerador_1_retiro').setValue(moto1);
            new TomSelect('#x_motogenerador_2_retiro').setValue(moto2);
        } catch (error) {
            console.error("Ocurrió un error durante la inicialización de Tom Select:", error);
        }

        $.ajax({
            url: "../maniobra/comprobar_estado.php",
            type: "POST",
            data: {
                'id': '<?php echo $_POST['id'] ?>',
                'tipo': 'Retiro'
            },
            success: function(data) {
                if (data == 1) {
                    if (confirm("Maniobra finalizada, para realizar modificaciones esta debe reactivarse ¿Deseas reactivar la maniobra?")) {
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
                                } else {
                                    notyf.error(response);
                                }
                            },
                            error: function() {
                                alert("Error en la solicitud Ajax");
                            }
                        });
                    } else {
                        notyf.success("Operación cancelada.");
                        $('#AsignarEquipoMR').offcanvas('hide');
                    }
                } else if (data == 3) {
                    alert('Para modificar los datos de la maniobra, primero debes finalizarla.');
                    $('#AsignarEquipoMR').offcanvas('hide');
                }
            },
            error: function(error) {
                notyf.error("Error en la solicitud AJAX:", error);
            }
        });
    }
</script>

<script>
    function InfoManiobraIngreso(terminal, horario, id_operador, eco, r1, r2, dolly, tipoterminal, moto1, moto2, cp_enlazada) {
        $('#AsignarEquipoMI').offcanvas('show');
        $("#x_terminal_bel").val(terminal);
        $("#x_inicio_programado_ingreso").val(horario);

        try {
            new TomSelect('#x_mov_ingreso_bel_id').setValue(id_operador);
            new TomSelect('#x_eco_ingreso_id').setValue(eco);
            new TomSelect('#x_remolque_1_ingreso').setValue(r1);
            new TomSelect('#x_remolque_2_ingreso').setValue(r2);
            new TomSelect('#x_dolly_ingreso').setValue(dolly);
            new TomSelect('#x_tipo_terminal_ingreso').setValue(tipoterminal);
            new TomSelect('#x_motogenerador_1_ingreso').setValue(moto1);
            new TomSelect('#x_motogenerador_2_ingreso').setValue(moto2);
        } catch (error) {
            console.error("Ocurrió un error durante la inicialización de Tom Select.");
        }

        $('#x_cp_enlazada').val(cp_enlazada).change();

        $.ajax({
            url: "../maniobra/comprobar_estado.php",
            type: "POST",
            data: {
                'id': '<?php echo $_POST['id'] ?>',
                'tipo': 'Ingreso'
            },
            success: function(data) {
                if (data == 1) {
                    if (confirm("Maniobra finalizada, para realizar modificaciones esta debe reactivarse ¿Deseas reactivar la maniobra?")) {
                        $.ajax({
                            url: "../maniobra/cancelar_maniobra.php",
                            type: "POST",
                            data: {
                                id_cp: '<?php echo $_POST['id'] ?> ',
                                tipo_maniobra: "Ingreso"
                            },
                            success: function(response) {
                                if (response == 1) {
                                    notyf.success('Maniobra de ingreso reabierta');
                                    comprobar_estado_odoo_ingreso();
                                } else {
                                    notyf.error(response);
                                }
                            },
                            error: function() {
                                alert("Error en la solicitud Ajax");
                            }
                        });
                    } else {
                        notyf.success("Operación cancelada.");
                        $('#AsignarEquipoMI').offcanvas('hide');
                    }
                } else if (data == 3) {
                    alert('Para modificar los datos de la maniobra, primero debes finalizarla.');
                    $('#AsignarEquipoMI').offcanvas('hide');
                }
            },
            error: function(error) {
                notyf.error("Error en la solicitud AJAX:", error);
            }
        });
    }
</script>