<!-- Modal -->
<div class="modal fade" id="modal_ingresar_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingresar Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormIngresarUsuario">
                    <div class="row">

                        <div class="col-12 m-2">
                            <div class="form-group">
                                <label>Nombre de Usuario</label>
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi-person"></i>
                                    </div>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Ingresar un nombre de usuario">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <div class="form-group">
                                <label>Contraseña</label>
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi-person"></i>
                                    </div>
                                    <input type="text" class="form-control" id="passwoord" name="passwoord" placeholder="Ingresar una contraseña">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <div class="form-group">
                                <label>Nombre real</label>
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi-person"></i>
                                    </div>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre real del empleado">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <div class="form-group">
                                <label>Correo electronico</label>
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="correo" name="correo" placeholder="Ingresar correo electronico">
                                </div>
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tipo</label>
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi-person"></i>
                                    </div>
                                    <select class="form-control" id="tipo" name="tipo">
                                        <option value="Dirección">Dirección</option>
                                        <option value="Monitorista">Monitorista</option>
                                        <option value="Ejecutivo">Ejecutivo</option>
                                        <option value="Supervisor">Supervisor</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Desarrollador">Desarrollador</option>
                                        <option value="Vigilancia">Vigilancia</option>
                                        <option value="Invitado">Invitado</option>
                                        <option value="Contabilidad">Contabilidad</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 m-2">
                            <div class="form-group">
                                <label>PIN</label>
                                <div class="input-group input-group-merge input-group-flush">
                                    <div class="input-group-prepend input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <input type="text" class="form-control" id="pin" name="pin" placeholder="Ingresar pin">
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success btn-sm" id="RegistrarNuevoUsuario">Ingresar usuario</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->