<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="bg-dark">
        <div class="content container-fluid" style="height: 25rem;">
            <!-- Page Header -->
            <div class="page-header page-header-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h1 class="page-header-title">Informe de seguimiento</h1>
                    </div>
                    <!-- End Col -->

                    <div class="col-auto">
                        <select class="form-select" id="semana">
                            <?php for ($i = 1; $i <= 52; $i++) { ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-auto">
                        <input type="text" id="fechaInicio" class="form-control">
                    </div>
                    <div class="col-auto">
                        <input type="text" id="fechaFinal" class="form-control">
                    </div>
                    <!--
                    <div class="col-auto">
                        <input type="text" id="daterange" name="daterange" class="form-control">
                    </div>
                    -->

                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" id="abrir_cuentas">Cuentas</button>
                    </div>

                    <div class="col-auto">
                        <button class="btn btn-primary btn-sm" id="abrir_form_new_saldo">Ingresar saldos</button>
                    </div>

                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->
        </div>
    </div>
    <!-- End Content -->

    <!-- Content -->
    <div class="content container-fluid" style="margin-top: -17rem;">
        <!-- Card -->

        <div class="card mb-3 mb-lg-5">
            <div class="card-header">
                <h4 class="card-header-title mb-2 mb-sm-0">Saldos</h4>
            </div>
            <div class="card-body p-0 m-0">
                <div id="saldos_generales"></div>
            </div>
        </div>

        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Ingresos por sucursal</h4>
            </div>
            <!-- End Header -->
            <div class="card-body">
                <div id="ingresos">
                </div>
            </div>
        </div>
        <!-- End Card -->

        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Cantidad de viajes por ejecutivo</h4>
            </div>
            <!-- End Header -->
            <div class="card-body">
                <div id="ejecutivos_viajes">
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Vacios</h4>
            </div>
            <!-- End Header -->
            <div class="card-body">
                <div id="operaciones">
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Tipo de armado</h4>
            </div>
            <!-- End Header -->
            <div class="card-body">
                <div id="tipo_armado">
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Mantenimiento</h4>
            </div>
            <!-- End Header -->
            <div class="card-body">
                <div id="mantenimiento">
                </div>
            </div>
        </div>
        <!-- End Card -->

        <!-- Card -->
        <div class="card mb-3 mb-lg-5">
            <!-- Header -->
            <div class="card-header card-header-content-sm-between">
                <h4 class="card-header-title mb-2 mb-sm-0">Comentarios</h4>
            </div>
            <!-- End Header -->
            <div class="card-body">
                <div id="comentarios">
                </div>
            </div>
        </div>
        <!-- End Card -->

    </div>

</main>

<script>
    const boton = document.getElementById('abrir_form_new_saldo');

    boton.addEventListener('click', () => {
        $("#cuentas").load('../cuentas/cuentas.php');
        $("#ingresar_saldo_modal").modal('show');
    });

    const botonCuentas = document.getElementById('abrir_cuentas');

    botonCuentas.addEventListener('click', () => {
        $("#cuentas").load('../cuentas/cuentas.php');
        $("#listado_cuentas").modal('show');
    });

    const selectElement = document.getElementById("semana");

    selectElement.addEventListener("change", function() {
        const selectedOption = selectElement.value;
        $.ajax({
            type: "POST",
            data: {
                'semana': selectedOption
            },
            url: "getFecha.php",
            success: function(data) {
                var fechaInicio = data.fechaInicio;
                var fechaFin = data.fechaFin;

                $('#fechaInicio').val(fechaInicio);
                $('#fechaFinal').val(fechaFin);

                $('#saldos_generales').load('saldos_generales.php', {
                    'semana': selectedOption
                });

                $('#ejecutivos_viajes').load('ejecutivos_viajes.php', {
                    'semana': selectedOption,
                    'fecha_inicio': fechaInicio,
                    'fecha_final': fechaFin
                });

                $('#ingresos').load('ingresos.php', {
                    'semana': selectedOption,
                    'fecha_inicio': fechaInicio,
                    'fecha_final': fechaFin
                });

                $('#operaciones').load('maniobras.php', {
                    'semana': selectedOption,
                    'fecha_inicio': fechaInicio,
                    'fecha_final': fechaFin
                });

                $('#tipo_armado').load('tipo_armado.php', {
                    'semana': selectedOption,
                    'fecha_inicio': fechaInicio,
                    'fecha_final': fechaFin
                });

                $('#comentarios').load('../comentarios/comentarios.php', {
                    'semana': selectedOption,
                    'fecha_inicio': fechaInicio,
                    'fecha_final': fechaFin
                });

                $('#mantenimiento').load('mantenimiento.php', {
                    'semana': selectedOption,
                    'fecha_inicio': fechaInicio,
                    'fecha_final': fechaFin
                });


            },
            error: function() {
                notyf.success('Error al obtener el rango de fechas.');
            }
        });
    });

    $(function() {
        $('input[name="daterange"]').daterangepicker({
            startDate: moment().startOf('month'),
            endDate: moment().endOf('month'),
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            console.log(start.format('YYYY-MM-DD'));
            console.log(end.format('YYYY-MM-DD'));
            $('#ejecutivos_viajes').load('ejecutivos_viajes.php', {
                'fecha_inicio': start.format('YYYY-MM-DD'),
                'fecha_final': end.format('YYYY-MM-DD')
            })


            $('#mantenimiento').load('mantenimiento.php', {
                'fecha_inicio': start.format('YYYY-MM-DD'),
                'fecha_final': end.format('YYYY-MM-DD')
            });
        });
    });
</script>