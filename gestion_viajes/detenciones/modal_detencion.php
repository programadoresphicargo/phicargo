<div class="modal fade" id="control_detencion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <div class="modal-body bg-soft-secondary">

                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-sm mb-2 mb-sm-0">
                            <h2 class="page-header-title">Control de detención</h2>
                            <span class="badge rounded-pill" id="estadoregdetencion"></span>
                        </div>

                        <div class="col-sm-auto">
                            <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-primary btn-sm" id="btnatenderdetencion">Atender detención</button>
                        </div>
                    </div>
                </div>

                <form id="form_registro_detencion">

                    <div class="row">

                        <div class="col-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <input type="hidden" id="id_detencion" name="id_detencion" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <input type="hidden" id="id_viaje_detencion" name="id_viaje_detencion" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Viaje</label>
                                        <input type="text" id="viaje_detencion" name="viaje_detencion" class="form-control" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Operador</label>
                                        <input type="text" id="operador_detencion" class="form-control" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Unidad</label>
                                        <input type="text" id="unidad_detencion" class="form-control" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Inicio de la detencion</label>
                                        <input type="text" id="inicio_detencion" class="form-control" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tiempo de detenido en minutos</label>
                                        <input type="text" id="tiempo_detenido" name="tiempo_detenido" class="form-control" disabled>
                                    </div>

                                    <div class="mb-3">
                                        <div id="mapa-detencion" style="width: 570px; height:400px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Motivo de detención</label>
                                        <select id="motivo_detencion" name="motivo_detencion" class="form-select required">
                                            <option value=""></option>
                                            <option value="unidad_detenida_patio_veracruz">Unidad detenida en patio Veracruz</option>
                                            <option value="unidad_detenida_patio_mexico">Unidad detenida en patio México</option>
                                            <option value="unidad_detenida_patio_mzn">Unidad detenida en patio Manzanillo</option>
                                            <option value="unidad_ingreso_planta">Unidad detenida esperando ingreso a planta</option>
                                            <option value="averia_mecanica">Avería Mecánica</option>
                                            <option value="problemas_neumaticos">Problemas con Neumáticos</option>
                                            <option value="falta_combustible">Falta de Combustible</option>
                                            <option value="accidente">Accidente</option>
                                            <option value="condiciones_climaticas">Condiciones Climáticas</option>
                                            <option value="revisiones_rutina">Revisiones de Rutina</option>
                                            <option value="descanso_conductor">Descanso del Conductor</option>
                                            <option value="control_policial">Control Policial</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Comentarios detención</label>
                                        <textarea type="text" class="form-control required" id="comentarios_detencion" name="comentarios_detencion" rows="5"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tiempo autorizado para continuar detenido</label>
                                        <select id="tolerancia_concecida" name="tolerancia_concecida" class="form-select required">
                                            <option value=""></option>
                                            <option value="00:00:00">Sin tiempo de tolerancia</option>
                                            <option value="00:15:00">15 min</option>
                                            <option value="00:30:00">Media hora</option>
                                            <option value="01:00:00">1 hora</option>
                                            <option value="02:00:00">2 horas</option>
                                            <option value="03:00:00">3 horas</option>
                                            <option value="04:00:00">4 horas</option>
                                            <option value="05:00:00">5 horas</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Usuario atendio</label>
                                        <input type="text" class="form-control" id="usuario_atendio" name="usuario_atendio" disabled></input>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Fecha de atención</label>
                                        <input type="datetime-local" class="form-control" id="fecha_atendido" name="fecha_atendido" disabled></input>
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