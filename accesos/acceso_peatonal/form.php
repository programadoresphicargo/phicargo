<main id="content" role="main" class="main">
    <div class="content container-fluid bg-light">
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
                            <i class="bi-save me-1"></i> Guardar
                        </a>
                        <a class="btn btn-primary btn-sm me-2" href="javascript:;" style="display:none">
                            <i class="bi-clipboard me-1"></i> Duplicar
                        </a>
                    </div>
                </div>

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
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-lg-9">
                <div class="card mb-3 mb-lg-5">
                    <div class="card-header">
                        <h4 class="card-header-title">Datos de acceso</h4>
                    </div>

                    <div class="card-body">
                        <form id="form_acceso">

                            <div class="mb-4">
                                <input type="hidden" class="form-control" name="id_acceso" id="id_acceso" data-no-validation>
                            </div>

                            <buttton id="añadirnuevaempresa2" class="btn btn-primary mb-2">Añadir nueva empresa</buttton>
                            <buttton id="registarnuevovisitante2" class="btn btn-primary mb-2">Registrar nuevo visitante</buttton>

                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <label class="form-label h3">Empresa</label>
                                    <select id="empresa" name="empresa" class="form-control">
                                        <option value=""></option>
                                        <option value="nueva">Añadir empresa</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="mb-4">
                                    <label class="form-label h3">Añadir visitantes</label>
                                    <select id="mySelect3" name="mySelect3" class="form-control tom-select form-select" data-no-validation>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <table id="registrosTable" class="table table-sm">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label h3">Tipo de movimiento</label>
                                        <select type="text" class="form-control" name="tipo_mov" id="tipo_mov">
                                            <option value="acceso" selected>Acceso a las instalaciones</option>
                                            <option value="salida">Salida de las instalaciones</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label h3">Fecha entrada</label>
                                        <input type="text" class="form-control" name="fecha_entrada" id="fecha_entrada">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label h3">Documento de identificación:</label>
                                        <select id="tipo_identificacion" name="tipo_identificacion" class="form-control">
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

                                <div class="col-sm-6">
                                    <div class="mb-4">
                                        <label class="form-label h3">Motivo de ingreso</label>
                                        <input type="text" class="form-control" name="motivo" id="motivo">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb-4">
                                        <label class="form-label h3">Designación de área</label>
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
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-3">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-header-title">Historial de cambios</h4>
                </div>
                <div class="card-body">
                    <div id="historial"></div>
                </div>
            </div>
        </div>
    </div>
</main>