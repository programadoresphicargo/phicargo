<main id="content" role="main" class="main">
    <!-- Content -->
    <div class="content container-fluid bg-light">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">

                    <h1 class="page-header-title">Nuevo acceso</h1>

                    <div class="mt-2">
                        <button class="btn btn-success btn-sm me-2" id="btnValidar" style="display:none">Validar ingreso</button>
                        <button class="btn btn-danger btn-sm me-2" id="btnSalida" style="display:none">Validar salida</button>

                        <a class="btn btn-success btn-sm me-2" href="javascript:;" style="display:none" id="btnRegistrar">
                            <i class="bi-clipboard me-1"></i> Registrar
                        </a>
                        <a class="btn btn-danger btn-sm me-2" href="javascript:;" style="display:none" id="btnEditar">
                            <i class="bi-pen me-1"></i> Editar
                        </a>
                        <a class="btn btn-success btn-sm me-2" href="javascript:;" style="display:none" id="btnSave">
                            <i class="bi-save me-1"></i> Save
                        </a>
                        <a class="btn btn-primary btn-sm me-2" href="javascript:;" style="display:none">
                            <i class="bi-clipboard me-1"></i> Duplicar
                        </a>
                    </div>
                </div>
                <!-- End Col -->

                <div class="col-sm-auto">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle me-1" data-bs-toggle="tooltip" data-bs-placement="right" title="Previous product">
                            <i class="bi-arrow-left"></i>
                        </button>
                        <button type="button" class="btn btn-ghost-secondary btn-icon btn-sm rounded-circle" data-bs-toggle="tooltip" data-bs-placement="right" title="Next product">
                            <i class="bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-sm-12 col-lg-9">
                <!-- Card -->
                <div class="card mb-3 mb-lg-5">
                    <!-- Header -->
                    <div class="card-header">
                        <h4 class="card-header-title">Datos de acceso</h4>
                    </div>
                    <!-- End Header -->

                    <!-- Body -->
                    <div class="card-body">
                        <!-- Form -->
                        <form id="form_acceso">

                            <div class="mb-4">
                                <input type="hidden" class="form-control" name="id_acceso" id="id_acceso">
                            </div>

                            <div class="row">

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Empresa</label>
                                        <select id="id_empresa" name="id_empresa" class="form-control">
                                            <option value=""></option>
                                            <option value="nueva">Agregar nueva opción...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-8">
                                    <div class="mb-4">
                                        <label for="inputGroupFlushFullName" class="text-dark fw-semibold">Nombre del operador / conductor</label>
                                        <input type="text" class="form-control" name="nombre_operador" id="nombre_operador">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Tipo de movimiento</label>
                                        <select class="js-select form-select" id="tipo_mov" name="tipo_mov">
                                            <option value=""></option>
                                            <option value="ingreso">Ingreso</option>
                                            <option value="salida">Salida</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label for="inputGroupFlushFullName" class="text-dark fw-semibold">Fecha de entrada / salida</label>
                                        <input type="text" class="form-control" name="fecha_entrada" id="fecha_entrada">
                                    </div>
                                </div>


                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Documento de identificación:</label>
                                        <select id="tipo_identificacion" name="tipo_identificacion" class="form-control" data-no-validation>
                                            <option value=""></option>
                                            <option value="ine">Credencial para Votar (INE/IFE)</option>
                                            <option value="pasaporte">Pasaporte Mexicano</option>
                                            <option value="cartilla">Cartilla del Servicio Militar Nacional</option>
                                            <option value="cedula">Cédula Profesional</option>
                                            <option value="licencia">Licencia de Conducir</option>
                                            <option value="residencia">Tarjeta de Residencia Temporal o Permanente</option>
                                            <option value="laboral">Identificación Laboral</option>
                                            <option value="residencia">Carta de Residencia</option>
                                            <option value="afiliacion">Tarjeta de Afiliación a Servicios de Salud</option>
                                            <option value="escolar">Identificación Escolar</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Placas</label>
                                        <input type="text" class="form-control" name="placas" id="placas">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Contenedor 1</label>
                                        <input type="text" class="form-control" name="contenedor1" id="contenedor1" data-no-validation>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Contenedor 2</label>
                                        <input type="text" class="form-control" name="contenedor2" id="contenedor2" data-no-validation>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Motivo de ingreso</label>
                                        <input type="text" class="form-control" name="motivo" id="motivo">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Tipo de transporte</label>
                                        <select class="js-select form-select" id="tipo_transporte" name="tipo_transporte" data-no-validation>
                                            <option value=""></option>
                                            <option value="Refrigerado">Refrigerado</option>
                                            <option value="Caja seca">Caja seca</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Carga / Descarga</label>
                                        <select class="js-select form-select" id="carga_descarga" name="carga_descarga" data-no-validation>
                                            <option value=""></option>
                                            <option value="carga">Carga</option>
                                            <option value="descarga">Descarga</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Sellos</label>
                                        <input type="text" class="form-control" name="sellos" id="sellos" data-no-validation>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="text-dark fw-semibold">Designación de área</label>
                                        <br>
                                        <label for="edificioAdministrativo"><input type="checkbox" class="form-check-input" id="edificioAdministrativo" name="lugares" value="Edificio Administrativo"> Edificio Administrativo</label><br>
                                        <label for="comedor"><input type="checkbox" class="form-check-input" id="comedor" name="lugares" value="Comedor"> Comedor</label><br>
                                        <label for="compras"><input type="checkbox" class="form-check-input" id="compras" name="lugares" value="Compras"> Compras</label><br>
                                        <label for="naveMantenimiento"><input type="checkbox" class="form-check-input" id="naveMantenimiento" name="lugares" value="Nave Mantenimiento"> Nave Mantenimiento</label><br>
                                        <label for="servicontainer"><input type="checkbox" class="form-check-input" id="servicontainer" name="lugares" value="Servicontainer"> Servicontainer</label><br>
                                        <label for="scania"><input type="checkbox" class="form-check-input" id="scania" name="lugares" value="Scania"> Scania</label><br>
                                        <label for="elektra"><input type="checkbox" class="form-check-input" id="elektra" name="lugares" value="Elektra"> Elektra</label><br>
                                        <label for="patioManiobras"><input type="checkbox" class="form-check-input" id="patioManiobras" name="lugares" value="Patio Maniobras"> Patio Maniobras</label><br>
                                        <label for="patioContenedores"><input type="checkbox" class="form-check-input" id="patioContenedores" name="lugares" value="Patio de Contenedores"> Patio de Contenedores</label><br>
                                        <label for="dieselUrea"><input type="checkbox" class="form-check-input" id="dieselUrea" name="lugares" value="Diesel y Urea"> Diesel y Urea</label><br>
                                        <label for="rfe"><input type="checkbox" id="rfe" class="form-check-input" name="lugares" value="RFE (Comprobación y Revisión)"> RFE (Comprobación y Revisión)</label><br>
                                        <label for="estacionamientoExterno"><input type="checkbox" class="form-check-input" id="estacionamientoExterno" name="lugares" value="Estacionamiento Externo"> Estacionamiento Externo</label><br>
                                        <label for="perimetroInterior"><input type="checkbox" class="form-check-input" id="perimetroInterior" name="lugares" value="Perímetro Interior"> Perímetro Interior</label><br>
                                        <label for="perimetroExterior"><input type="checkbox" class="form-check-input" id="perimetroExterior" name="lugares" value="Perímetro Exterior"> Perímetro Exterior</label><br>

                                    </div>
                                </div>

                        </form>

                    </div>
                    <!-- Body -->
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>

        <div class="col-3">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div id="historial"></div>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Content -->
</main>
<!-- ========== END MAIN CONTENT ========== -->