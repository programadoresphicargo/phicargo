<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modal_incidencia">
    <div class="modal-dialog" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Registro de incidencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="formIncidencia">
                    <div class="mb-3">
                        <input id="id_operador_incidencia" type="hidden" name="id_operador_incidencia" class="form-control"></input>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="registrar_incidencia">Registrar incidencia</button>
            </div>
        </div>
    </div>
</div>