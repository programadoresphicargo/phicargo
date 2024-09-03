<!-- Modal -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="modal_entrega" aria-labelledby="offcanvasRightLabel">

    <div class="offcanvas-header">
        <div class="col-sm mb-2 mb-sm-0">
            <h2 class="page-header-title">Entrega de turno</h2>
        </div>

        <div class="col-auto">
            <div id="listado_visto">
            </div>
        </div>

        <div class="col-sm-auto">
            <button id="abrir_entrega" type="button" class="btn btn-primary btn-sm"><i class="bi bi-check2"></i> Abrir mi entrega</button>
            <button id="guardar_entrega" type="button" class="btn btn-success btn-sm"><i class="bi bi-pen"></i> Guardar cambios</button>
            <button id="cerrar_entrega" type="button" class="btn btn-success btn-sm"><i class="bi bi-check2-all"></i> Cerrar</button>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
    </div>

    <div class="offcanvas-body">
        <div class="modal-body">
            <div class="row">

                <div class="col-6">
                    <div class="mb-3">
                        <label for="inputGroupBorderlessFullName" class="form-label">Fecha:</label>
                        <div class="input-group input-group-merge input-group-borderless input-group-flush">
                            <div class="input-group-prepend input-group-text">
                                <i class="bi bi-calendar3"></i>
                            </div>
                            <input type="datetime" id="fecha_creado" name="fecha_creado" class="form-control" disabled>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="inputGroupBorderlessFullName" class="form-label">Publicado por:</label>

                            <div class="input-group input-group-merge input-group-borderless input-group-flush">
                                <div class="input-group-prepend input-group-text">
                                    <i class="bi-person"></i>
                                </div>
                                <input type="text" id="usuario_autor" name="usuario_autor" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-5">
                <h2>Listado entragas para Monitorista</h2>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tarea</th>
                            <th>Tipo de Registro</th>
                            <th>Atendida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Revisar el sistema de cámaras</td>
                            <td>Nota</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario1"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Reportar falla en GPS de unidad 123</td>
                            <td>Urgente</td>
                            <td>Sí</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario2"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Desacato de operador en unidad 456</td>
                            <td>Desacato</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario3"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Desacato de operador en unidad 456</td>
                            <td>Desacato</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario3"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Desacato de operador en unidad 456</td>
                            <td>Desacato</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario3"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Desacato de operador en unidad 456</td>
                            <td>Desacato</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario3"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Revisar el sistema de cámaras</td>
                            <td>Nota</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario1"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Revisar el sistema de cámaras</td>
                            <td>Nota</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario1"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Revisar el sistema de cámaras</td>
                            <td>Nota</td>
                            <td>No</td>
                            <td>
                                <button class="btn btn-primary btn-xs" data-bs-toggle="offcanvas" data-bs-target="#offcanvasComentario1"><i class="bi bi-chat"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Offcanvas Comentario 1 -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComentario1" style="width: 40%;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Comentario sobre tarea: Revisar el sistema de cámaras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <textarea class="form-control" rows="5" placeholder="Escribe tu comentario aquí..."></textarea>
                    <button class="btn btn-success mt-3">Guardar Comentario</button>
                </div>
            </div>

            <!-- Offcanvas Comentario 2 -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComentario2" style="width: 40%;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Comentario sobre tarea: Reportar falla en GPS de unidad 123</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <textarea class="form-control" rows="5" placeholder="Escribe tu comentario aquí..."></textarea>
                    <button class="btn btn-success mt-3">Guardar Comentario</button>
                </div>
            </div>

            <!-- Offcanvas Comentario 3 -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasComentario3" style="width: 40%;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title">Comentario sobre tarea: Desacato de operador en unidad 456</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <textarea class="form-control" rows="5" placeholder="Escribe tu comentario aquí..."></textarea>
                    <button class="btn btn-success mt-3">Guardar Comentario</button>
                </div>
            </div>

            <form id="FormEntrega">
                <input type="hidden" id="id" name="id" class="form-control" placeholder="">
                <input type="hidden" id="id_usuario" name="id_usuario" class="form-control" value="<?php echo $_SESSION['userID'] ?>">

                <div class="row">
                    <div class="col-10">
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Título</label>
                            <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ingresar titulo" value="<?php echo $_SESSION['nombre'] ?> Entrega <?php echo date('Y-m-d H:i') ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-3">
                            <label class="form-label" for="exampleFormControlInput1">Color</label>
                            <input type="color" id="color" name="color" class="form-control form-control-color" value="#377dff">
                        </div>
                    </div>
                </div>

                <div class="quill-custom">
                    <div id="editor" style="min-height: 15rem">
                    </div>
                </div>

                <div class="mt-5" id="entviajes">
                    <div id="listado_entregas_viaje">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>