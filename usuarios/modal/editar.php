<div class="modal fade" id="modal_editar_usuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar información usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6">
                        <form id="EditarUsuarioForm">
                            <div class="row">
                                <div class="col-6">
                                    <input type="hidden" class="form-control" id="idusuario" name="idusuario">

                                    <div class="form-group mb-3">
                                        <label>Nombre de Usuario</label>

                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text" id="inputGroupFlushFullNameAddOn">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" id="usernameup" name="usernameup" placeholder="Ingresar un nombre de usuario">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text" id="inputGroupFlushFullNameAddOn">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" id="passwoordup" name="passwoordup" placeholder="Ingresar una contraseña">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-6">

                                    <div class="form-group mb-3">
                                        <label>Nombre real</label>
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text" id="inputGroupFlushFullNameAddOn">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" id="nameup" name="nameup" placeholder="Nombre real del empleado">
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label>Tipo</label>
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text">
                                                <i class="bi-person"></i>
                                            </div>
                                            <select class="form-control" id="tipoup" name="tipoup">
                                                <option value="Dirección">Dirección</option>
                                                <option value="Monitorista">Monitorista</option>
                                                <option value="Ejecutivo">Ejecutivo</option>
                                                <option value="Supervisor">Supervisor</option>
                                                <option value="Administrador">Administrador</option>
                                                <option value="Desarrollador">Desarrollador</option>
                                                <option value="Invitado">Invitado</option>
                                                <option value="Vigilancia">Vigilancia</option>
                                                <option value="Contabilidad">Contabilidad</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="form-group mb-3">
                                        <label>Estado</label>
                                        <!-- Select -->
                                        <div class="tom-select-custom">
                                            <div class="input-group input-group-merge input-group-flush">
                                                <div class="input-group-prepend input-group-text">
                                                    <i class="bi-person"></i>
                                                </div>
                                                <select class="js-select form-select" autocomplete="off" id="estadoup" name="estadoup">
                                                    <option value="Activo">Activo</option>
                                                    <option value="Inactivo">Inactivo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="form-group mb-3">
                                        <label>Correo electronico</label>
                                        <!-- Select -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" id="correoup" name="correoup" placeholder="Correo electronico">
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>

                                <div class="col-6 mt-3">
                                    <div class="form-group mb-3">
                                        <label>PIN</label>
                                        <!-- Select -->
                                        <div class="input-group input-group-merge input-group-flush">
                                            <div class="input-group-prepend input-group-text">
                                                <i class="bi-person"></i>
                                            </div>
                                            <input type="text" class="form-control" id="pinup" name="pinup" placeholder="PIN">
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="col-6">
                        <div class="mb-3 mt-3">
                            <h5 class="card-title mb-0">Permisos</h5>
                        </div>

                        <?php
                        require_once('../../mysql/conexion.php');
                        $cn = conectar();
                        $sqlSelect = "SELECT permisos.id_permiso, descripcion FROM permisos";
                        $resultado = $cn->query($sqlSelect);
                        ?>
                        <!-- Prepend -->
                        <div class="input-group mb-3">
                            <!-- Select -->
                            <div class="tom-select-custom">
                                <select class="js-select form-select form-select-sm" autocomplete="off" id="id_permiso" name="id_permiso">
                                    <?php while ($row = $resultado->fetch_assoc()) { ?>
                                        <option value="<?php echo $row['id_permiso'] ?>" selected><?php echo $row['descripcion'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <!-- End Select -->
                            <button type="button" id="Asignar_Permisos" class="btn btn-primary btn-sm">Asignar permiso</button>
                        </div>
                        <!-- End Prepend -->

                        <div id="usuarios_permisos_tabla">
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="editar_usuario" class="btn btn-success btn-sm">Guardar</button>
            </div>
        </div>
    </div>
</div>