<!-- Modal -->
<div class="modal fade" id="estadia_cancelacion_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl shadow-lg p-3 mb-5 bg-white rounded" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="form_estadia_cancelacion">

                    <input id="id-viaje-cancelacion" name="id-viaje-cancelacion" class="form-control" type="hidden">

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlSelect1">Razón de cancelación</label>
                        <select id="razones-no-cobro-estadia" name="razones-no-cobro-estadia" class="form-control">
                            <option value="acuerdo-previo">Acuerdo previo entre las partes</option>
                            <option value="condiciones-climaticas-adversas">Condiciones climáticas adversas</option>
                            <option value="desastres-naturales">Desastres naturales</option>
                            <option value="fallas-tecnicas-muelle">Fallas técnicas en el muelle de carga o descarga</option>
                            <option value="huelgas-paros">Huelgas o paros laborales</option>
                            <option value="problemas-administrativos-destinatario">Problemas administrativos del destinatario</option>
                            <option value="errores-documentacion-destinatario">Errores de documentación por parte del destinatario</option>
                            <option value="espera-instrucciones-destinatario">Espera de instrucciones del destinatario</option>
                            <option value="incapacidad-recepcion-destinatario">Incapacidad del destinatario para recibir la carga</option>
                            <option value="imprevistos-administrativos-transportista">Imprevistos administrativos del transportista</option>
                            <option value="inspecciones-reglamentarias-no-culpables">Inspecciones reglamentarias no atribuibles a fallas del transportista</option>
                            <option value="problemas-legales-externos">Problemas legales externos al control del transportista</option>
                            <option value="procedimientos-aduana">Procedimientos aduaneros estándar</option>
                            <option value="congestiones-viales-no-culpables">Congestiones viales no atribuibles al transportista</option>
                            <option value="delays-cargadores-muelles">Retrasos por parte de cargadores en el muelle</option>
                            <option value="espera-ventana-horaria-programada">Espera dentro de la ventana horaria programada</option>
                            <option value="mutuo-acuerdo-tras-demora">Mutuo acuerdo después de una demora</option>
                            <option value="falta-espacio-descarga">Falta de espacio en el lugar de descarga no imputable al transportista</option>
                            <option value="periodos-cortos-tolerancia">Periodos cortos de tolerancia antes de aplicar el cobro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="exampleFormControlTextarea1">Comentarios</label>
                        <textarea id="comentarios-cancelacion" name="comentarios-cancelacion" class="form-control" placeholder="Comentarios" rows="4"></textarea>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="cancelar_estadia">Aceptar</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->