<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width: 60%;">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Detalles del reporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-sm mb-2 mb-sm-0">
                    <h2 class="page-header-title"></h2>
                </div>

                <div class="col-sm-auto">
                    <a class="btn btn-primary btn-sm" href="javascript:;" id="solucionar_reporte" style="display: none;">
                        <i class="bi-people-fille me-1"></i> Solucionar
                    </a>
                </div>
            </div>
        </div>
        <!-- End Page Header -->

        <form id="formInfo">
            <input id="id_reporte" name="id_reporte" type="hidden">

            <div class="mb-3">
                <input class="form-control" id="id_operador" name="id_operador" type="hidden">
            </div>

            <div class="mb-3">
                <label>Nombre operador</label>
                <input class="form-control" id="nombre_operador" name="nombre_operador" disabled>
            </div>

            <div class="mb-3">
                <label>Fecha de creación</label>
                <input class="form-control" id="fecha_creacion" name="fecha_creacion" disabled>
            </div>

            <div class="mb-3">
                <label for="validationValidTextarea1">Notas operador</label>
                <textarea class="form-control" id="notasoperador" name="notasoperador" rows="4"></textarea>
            </div>

            <div class="mb-3">
                <label for="validationValidTextarea1">Comentario de la resolución del problema</label>
                <textarea class="form-control" id="comentario" name="comentario" rows="4"></textarea>
            </div>
        </form>

        <div class="mb-3">
            <div id="imagenes"></div>
        </div>
    </div>
</div>