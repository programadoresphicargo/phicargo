<form id="form_solicitud">
    <div class="container">
        <div class="row">

            <input type="hidden" id="id_solicitud" name="id_solicitud" value="0" data-no-validation>
            <input type="hidden" id="name" name="name" data-no-validation>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="sequence_id">Sucursal</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="sequence_id" name="sequence_id" title="Sucursal" class="form-select">
                                <option value=""></option>
                                <option value="35" selected>Veracruz</option>
                                <option value="344">Manzanillo</option>
                                <option value="187">México</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="partner_id">Cliente</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="partner_id" name="partner_id" title="Cliente" class="form-select">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="date_order">Fecha</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="date_order" name="date_order" type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="expected_date_delivery">Fecha prevista</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="expected_date_delivery" name="expected_date_delivery" type="date" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label">Categoria</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="waybill_category" name="waybill_category" title="Categoria" class="form-select" iniciar="false">
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_tipo_bel">Modalidad</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="x_tipo_bel" name="x_tipo_bel" title="Modalidad" class="form-select">
                                <option value=""></option>
                                <option value="full">FULL</option>
                                <option value="single">SENCILLO</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_tipo2_bel">Tipo de carga</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="x_tipo2_bel" name="x_tipo2_bel" title="Modalidad" class="form-select">
                                <option value=""></option>
                                <option value="Cargado">Cargado</option>
                                <option value="Vacio">Vacio</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_modo_bel">Tipo de Servicio</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="x_modo_bel" name="x_modo_bel" class="form-select">
                                <option value=""></option>
                                <option value="imp">Importación</option>
                                <option value="exp">Exportación</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_medida_bel">Medida</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="x_medida_bel" name="x_medida_bel" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_clase_bel">Clase</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="x_clase_bel" name="x_clase_bel" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="departure_address_id">Dirección origen</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="departure_address_id" name="departure_address_id" class="form-select">
                                <option value="1">TRANSPORTES BELCHEZ SA DE CV</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="arrival_address_id">Dirección destino</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="arrival_address_id" name="arrival_address_id" class="form-select">
                                <option value="1">TRANSPORTES BELCHEZ SA DE CV</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_reference_owr">Referencia OW/RT</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="x_reference_owr" name="x_reference_owr" class="form-select">
                                <option value=""></option>
                                <option value="ow">OW</option>
                                <option value="rt">RT</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="client_order_ref">Referencia Facturación</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="client_order_ref" name="client_order_ref" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_ejecutivo">Ejecutivo cliente</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="x_ejecutivo" name="x_ejecutivo" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_reference">Referencia</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="x_reference" name="x_reference" class="form-control" data-no-validation>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_numero_cotizacion">Número de cotización</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="x_numero_cotizacion" name="x_numero_cotizacion" class="form-control" data-no-validation>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_tarifa">Tarifa</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <input id="x_tarifa" name="x_tarifa" class="form-control" type="number" data-no-validation>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="form-check mt-3">
                            <input type="checkbox" id="dangerous_cargo" name="dangerous_cargo" class="form-check-input">
                            <label class="form-check-label" for="dangerous_cargo">Carga Peligrosa</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="row">
                    <label class="col-sm-5   col-form-label" for="x_ejecutivo_viaje_bel">Ejecutivo de viaje</label>
                    <div class="col-sm-7">
                        <div class="input-group  input-group-flush">
                            <select id="x_ejecutivo_viaje_bel" name="x_ejecutivo_viaje_bel" class="form-select">
                                <option value="Ana Karen Lobato Rivera">Ana Karen Lobato Rivera</option>
                                <option value="Miriam Gonzalez">Miriam Gonzalez</option>
                                <option value="Espino Martinez Gustavo Adolfo">Espino Martinez Gustavo Adolfo</option>
                                <option value="Daniela Cruz">Daniela Cruz</option>
                                <option value="Karina Isabel Rojas Castro">Karina Isabel Rojas Castro</option>
                                <option value="Yuridia Palmeros Morales">Yuridia Palmeros Morales</option>
                                <option value="Lucero Rodriguez Vallejo">Lucero Rodriguez Vallejo</option>
                                <option value="Maria Cristina Acosta Medina ">MARIA CRISTINA ACOSTA MEDINA</option>
                                <option value="ZAPATA ESPINOZA CARLOS YAHIR">ZAPATA ESPINOZA CARLOS YAHIR</option>
                                <option value="GARCIA PEREZ NANCY LUCERO">GARCIA PEREZ NANCY LUCERO</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Líneas</button>
                <button class="nav-link" id="nav-if-tab" data-bs-toggle="tab" data-bs-target="#nav-if" type="button" role="tab" aria-controls="nav-if" aria-selected="true">Datos de entrega o <br> carga de mercancía</button>
                <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Complemento Carta Porte</button>
                <button class="nav-link" id="nav-aa-tab" data-bs-toggle="tab" data-bs-target="#nav-aa" type="button" role="tab" aria-controls="nav-aa" aria-selected="true">Agente aduanal</button>
                <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Custodia</button>
                <button class="nav-link" id="nav-se-tab" data-bs-toggle="tab" data-bs-target="#nav-se" type="button" role="tab" aria-controls="nav-se" aria-selected="false">Servicios adicionales</button>
                <button class="nav-link" id="nav-notas-tab" data-bs-toggle="tab" data-bs-target="#nav-notas" type="button" role="tab" aria-controls="nav-notas" aria-selected="false">Notas</button>
            </div>
        </nav>

        <div class="tab-content" id="nav-tabContent">

            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto mb-5 mt-5">
                        <h2>Servicios</h2>
                    </div>
                    <div class="col-auto mb-5 mt-5">
                        <button class="btn btn-primary btn-sm" id="abrir_servicios" type="button"><i class="bi bi-plus-circle-dotted"></i> Añadir registro</button>
                    </div>
                </div>

                <div class="col-12 mb-5">
                    <table class="table table-borderless table-thead-bordered table-striped table-sm" id="servicios_añadidos">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Peso estimado KG</th>
                                <th scope="col">Referencia contenedor</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-if" role="tabpanel" aria-labelledby="nav-if-tab">
                <div class="row mt-5">

                    <div class="row">

                        <div class="col-6">
                            <div class="row">
                                <label class="col-sm-4 col-form-label" for="date_start">Inicio de ruta requerido</label>
                                <div class="col-sm-8">
                                    <div class="input-group  input-group-flush">
                                        <input type="datetime-local" class="form-control" id="date_start" name="date_start">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="row">
                                <label class="col-sm-4 col-form-label" for="x_date_arrival_shed">Llegada a planta programada</label>
                                <div class="col-sm-8">
                                    <div class="input-group  input-group-flush">
                                        <input type="datetime-local" class="form-control" id="x_date_arrival_shed" name="x_date_arrival_shed">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_subcliente_bel">Empresa</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_subcliente_bel" name="x_subcliente_bel" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_contacto_subcliente">Ejecutivo contacto</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_contacto_subcliente" name="x_contacto_subcliente" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_telefono_subcliente">Telefono</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_telefono_subcliente" name="x_telefono_subcliente" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_correo_subcliente">Correo electrónico</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_correo_subcliente" name="x_correo_subcliente" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_ruta_bel">Ruta prog</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input id="x_ruta_bel" name="x_ruta_bel" class="form-select" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_ruta_destino">Ruta destino</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <select id="x_ruta_destino" name="x_ruta_destino" class="form-select" data-no-validation>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="upload_point">Punto de Carga</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="upload_point" name="upload_point" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="download_point">Punto de Descarga</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="download_point" name="download_point" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_codigo_postal">Codigo Postal del punto de carga o descarga</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="number" id="x_codigo_postal" name="x_codigo_postal" class="form-control" max="5">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_ruta_autorizada">Ruta autorizada</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_ruta_autorizada" name="x_ruta_autorizada" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_paradas_autorizadas">Paradas autorizadas</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_paradas_autorizadas" name="x_paradas_autorizadas" data-no-validation>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                <div class="alert alert-soft-primary mt-3" role="alert">
                    <div class="d-flex">
                        <div class="flex-shrink-0">
                            <i class="bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="flex-grow-1 ms-2">
                            <h4 class="card-header-title text-primary">Nota importante</h4>
                            La información proporcionada debe de aparecer en el catálogo del SAT versión 3.0 (de no ser así no se podrá enviar la unidad a ruta y se deben de tener en cuenta los costos extras que esto genere). Transportes Belchez S.A. de C.V. no se hará responsable en caso de que la información proporcionada de la carga no sea correcta.
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="row">
                        <label class="col-sm-5 col-form-label" for="international_shipping">Transporte internacional</label>
                        <div class="col-sm-7">
                            <div class="input-group input-group-flush">
                                <select id="international_shipping" name="international_shipping" class="form-select" onchange="mostrarOcultarInputs('international_shipping')">
                                    <option value=""></option>
                                    <option value="SI">SI</option>
                                    <option value="NO" selected>NO</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div id="international_shipping_inputs" style="display:none;" class="mb-4">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-sm-5   col-form-label" for="merchandice_country_origin_id">País de origen o destino</label>
                                    <div class="col-sm-7">
                                        <div class="input-group input-group-flush">
                                            <select id="merchandice_country_origin_id" name="merchandice_country_origin_id" class="form-select" data-no-validation>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-sm-5 col-form-label" for="tipo_transporte_entrada_salida_id">Via Entrada Salida</label>
                                    <div class="col-sm-7">
                                        <div class="input-group input-group-flush">
                                            <select id="tipo_transporte_entrada_salida_id" name="tipo_transporte_entrada_salida_id" class="form-select" data-no-validation>
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-sm-5 col-form-label" for="shipping_complement_type">Entrada/Salida Mercancia</label>
                                    <div class="col-sm-7">
                                        <div class="input-group input-group-flush">
                                            <select id="shipping_complement_type" name="shipping_complement_type" class="form-select" data-no-validation>
                                                <option value=""></option>
                                                <option value="Entrada">Entrada</option>
                                                <option value="Salida">Salida</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-sm-5 col-form-label" for="waybill_pedimento">Pedimento</label>
                                    <div class="col-sm-7">
                                        <div class="input-group input-group-flush">
                                            <input id="waybill_pedimento" name="waybill_pedimento" class="form-control" data-no-validation>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-12">

                        <div class="page-header">
                            <div class="row align-items-center">
                                <div class="col-sm mb-2 mb-sm-0">
                                    <h2 class="page-header-title">Mercancías</h2>
                                </div>

                                <div class="col-sm-auto">
                                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#abrir_modal_excel" type="button">
                                        <i class="bi bi-file-earmark-excel"></i> Subir excel
                                    </button>
                                    <button class="btn btn-primary btn-sm" id="abrir_lineas_complemento" type="button">
                                        <i class="bi bi-plus-lg"></i> Añadir mercancia
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-sm table-borderless table-thead-bordered table-align-middle" id="tabla_lineas_complemento">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Dimensiones</th>
                                        <th scope="col">Producto SAT</th>
                                        <th scope="col">Cantidad</th>
                                        <th scope="col">UDM SAT</th>
                                        <th scope="col">Peso en KG</th>
                                        <th scope="col">Material peligroso</th>
                                        <th scope="col">Clave material peligroso</th>
                                        <th scope="col">Embalaje</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-aa" role="tabpanel" aria-labelledby="nav-aa-tab">
                <div class="row mt-5">

                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="x_nombre_agencia">Nombre de la agencia</label>
                        <div class="col-sm-9">
                            <div class="input-group  input-group-flush">
                                <input type="text" class="form-control" id="x_nombre_agencia" name="x_nombre_agencia" data-no-validation>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="x_telefono_aa">Teléfono</label>
                        <div class="col-sm-9">
                            <div class="input-group  input-group-flush">
                                <input type="number" class="form-control" id="x_telefono_aa" name="x_telefono_aa" data-no-validation>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <label class="col-sm-3 col-form-label" for="x_email_aa">Correo electronico</label>
                        <div class="col-sm-9">
                            <div class="input-group  input-group-flush">
                                <input type="text" class="form-control" id="x_email_aa" name="x_email_aa" data-no-validation>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">

                <div class="row mt-4">
                    <label class="col-sm-3 col-form-label" for="x_custodia_bel">Custodia</label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-flush">
                            <select id="x_custodia_bel" name="x_custodia_bel" class="form-select">
                                <option value=""></option>
                                <option value="yes">SI</option>
                                <option value="no" selected>NO</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div id="x_custodia_bel_inputs">

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_nombre_custodios">Nombre de los custodios</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_nombre_custodios" name="x_nombre_custodios" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_telefono_custodios">Teléfono</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="number" class="form-control" id="x_telefono_custodios" name="x_telefono_custodios" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_empresa_custodia">Empresa que realiza la custodia</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_empresa_custodia" name="x_empresa_custodia" data-no-validation>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-sm-3 col-form-label" for="x_datos_unidad">Modelo, Color, Placas de la unidad</label>
                            <div class="col-sm-9">
                                <div class="input-group  input-group-flush">
                                    <input type="text" class="form-control" id="x_datos_unidad" name="x_datos_unidad" data-no-validation placeholder="Modelo, Color, Placas de unidad que se presenta">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-se" role="tabpanel" aria-labelledby="nav-se-tab">

                <div class="row mt-5">
                    <div class="mb-3 mb-sm-3">
                        <div class="alert alert-soft-primary mb-5 mb-sm-5" role="alert">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi-exclamation-triangle-fill"></i>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <h4 class="card-header-title text-primary">Nota importante</h4>
                                    Favor de considerar que estos servicios adicionales no están incluidos en su cotización y tendrán costo adicional
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_seguro" class="form-check-input" name="x_seguro">
                                <label class="form-check-label" for="x_seguro">Seguro de contenedor</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_desconsolidacion" class="form-check-input" name="x_desconsolidacion">
                                <label class="form-check-label" for="x_desconsolidacion">Desconsolidación</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_conexion_refrigerado" class="form-check-input" name="x_conexion_refrigerado">
                                <label class="form-check-label" for="x_conexion_refrigerado">Conexión de Refrigerado</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_pesaje" class="form-check-input" name="x_pesaje">
                                <label class="form-check-label" for="x_pesaje">Pesaje</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_almacenaje" class="form-check-input" name="x_almacenaje">
                                <label class="form-check-label" for="x_almacenaje">Almacenaje</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_maniobra_carga_descarga" class="form-check-input" name="x_maniobra_carga_descarga">
                                <label class="form-check-label" for="x_maniobra_carga_descarga">Maniobra de carga / descarga</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_barras_logisticas" class="form-check-input" name="x_barras_logisticas">
                                <label class="form-check-label" for="x_barras_logisticas">Barras logisticas</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_resguardo" class="form-check-input" name="x_resguardo">
                                <label class="form-check-label" for="x_resguardo">Resguardo de carga</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_sello" class="form-check-input" name="x_sello">
                                <label class="form-check-label" for="x_sello">Sello</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_fumigacion" class="form-check-input" name="x_fumigacion">
                                <label class="form-check-label" for="x_fumigacion">Fumigación</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_prueba_covid" class="form-check-input" name="x_prueba_covid">
                                <label class="form-check-label" for="x_prueba_covid">Prueba COVID</label>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-check mb-3">
                                <input type="checkbox" id="x_reparto" class="form-check-input" name="x_reparto">
                                <label class="form-check-label" for="x_reparto">Reparto</label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="nav-notas" role="tabpanel" aria-labelledby="nav-notas-tab">

                <div class="row mt-5">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label" for="x_epp">Equipo de proteccion especial </label>
                            <textarea id="x_epp" name="x_epp" class="form-control" placeholder="" rows="4" data-no-validation></textarea>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="row">
                        <div class="mb-3">
                            <label class="form-label" for="x_especificaciones_especiales">Notas (Especificar indicaciones especiales requeridas)</label>
                            <textarea id="x_especificaciones_especiales" name="x_especificaciones_especiales" class="form-control" placeholder="" rows="4" data-no-validation></textarea>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>