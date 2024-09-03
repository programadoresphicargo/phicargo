<div class="offcanvas offcanvas-end" tabindex="-1" id="canvas_incidencias" aria-labelledby="offcanvasRightLabel" style="width: 40%;">
    <div class="offcanvas-body bg-soft-secondary">

        <div class="row align-items-center mb-3">
            <div class="col-sm mb-sm-0">
                <h2 class="page-header-title">Nueva incidencia</h2>
            </div>

            <div class="col-sm-auto">
                <button type="button" class="btn btn-primary btn-sm" onclick="abrir_modulo_incidencia()">
                    <i class="bi bi-plus-lg"></i> Nueva entrega
                </button>
            </div>
        </div>

        <div class="card" style="display: none;" id="modulo_incidencias">
            <div class="card-body">

                <button type="button" class="btn btn-success btn-xs" id="registrar_incidencia">
                    <i class="bi bi-plus-lg"></i> Registrar
                </button>

                <form id="formIncidencia">
                    <div class="mb-3">
                        <input id="id_operador_incidencia" type="hidden" name="id_operador_incidencia" class="form-control"></input>
                    </div>

                    <div class="mb-3">
                        <div>
                            <label class="form-label">Tipo de entrega</label>
                            <select id="tipo_incidencia" name="tipo_incidencia" class="js-select form-select">
                                <option value="efectos">Nota informativa</option>
                                <option value="trafico">Incidencia</option>
                                <option value="seguridad">Desacato operadores</option>
                                <option value="seguridad">Errores de documentacion</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div>
                            <label class="form-label">Tipo de incidencia</label>
                            <select id="tipo_incidencia" name="tipo_incidencia" class="js-select form-select">
                                <option value="efectos">Conducir bajo los efectos del alcohol o drogas</option>
                                <option value="trafico">Violaciones de Tráfico</option>
                                <option value="seguridad">Incumplimiento de Regulaciones de Seguridad</option>
                                <option value="mantenimiento">Mantenimiento Deficiente del Vehículo</option>
                                <option value="conducta">Conducta Agresiva o Imprudente</option>
                                <option value="carga">Incumplimiento de Normas de Carga y Peso</option>
                                <option value="documentacion">Documentación y Registros Incorrectos</option>
                                <option value="maniobra_no_realizada">Operador no quiso hacer una maniobra</option>
                                <option value="maniobra_abandonada">Operador dejó botada la maniobra</option>
                                <option value="no_tomo_equipo">No tomó equipo asignado</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlTextarea1">Comentarios</label>
                        <textarea id="comentarios_incidencias" name="comentarios_incidencias" class="form-control" rows="6"></textarea>
                    </div>

                </form>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h1>Historial de incidencias</h1>
            </div>
            <div class="card-body">
                <div id="historial_incidencias"></div>
            </div>
        </div>

    </div>
</div>