<?php
require_once('../../../mysql/conexion.php');
require_once('../../../tiempo/tiempo.php');

$cn = conectar();

$id_viaje = $_POST['id_viaje'];
$sql = "SELECT *, usuarios.nombre as nombre_usuario, documentacion.nombre as nombre_archivo FROM documentacion inner join usuarios on usuarios.id_usuario = documentacion.id_usuario WHERE documentacion.tipo_doc IN ('pod', 'eir', 'cuentaop') and id_viaje = $id_viaje order by fecha_hora desc";
$resultado = $cn->query($sql);
?>

<div class="table-responsive">
    <table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-hover">
        <thead>
            <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Tipo de documento</th>
                <th scope="col">Envío</th>
                <th scope="col">Fecha</th>
                <th scope="col">Descargar</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['nombre_archivo'] ?></td>
                    <td><?php echo $row['tipo_doc'] ?></td>
                    <td><?php echo $row['nombre_usuario'] ?></td>
                    <td><?php echo $row['fecha_hora'] ?></td>
                    <?php $nombre = $row['nombre_archivo']; ?>
                    <td><a class="btn btn-success btn-xs" href='../adjuntos_estatus/<?php echo $id_viaje . '/' . $nombre ?>' target="_blank">Descargar</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<ul class="list-group mt-3">

    <?php while ($row = $resultado->fetch_assoc()) { ?>
        <li class="list-group-item">
            <div class="row align-items-center">
                <div class="col-auto">
                    <img class="avatar avatar-xs avatar-4x3" src="../../img/img.svg" alt="A">
                </div>

                <div class="col">
                    <h5 class="mb-0">
                        <a target="_blank" class="text-dark" href="../pods/viajes/<?php echo $id_viaje . '/' . $row['nombre'] ?>"><?php echo $row['nombre'] ?></a>
                    </h5>
                    <ul class="list-inline list-separator small text-body">
                        <li class="list-inline-item"><?php echo $row['fecha_hora'] ?></li>
                        <li class="list-inline-item"><?php echo imprimirTiempo($row['fecha_hora']) ?></li>
                    </ul>
                </div>

                <div class="col-auto">
                    <div class="dropdown">
                        <button type="button" class="btn btn-white btn-sm" id="filesListDropdown8" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="d-none d-sm-inline-block me-1">+</span>
                            <i class="bi-chevron-down"></i>
                        </button>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="filesListDropdown8" style="min-width: 13rem;">
                            <span class="dropdown-header">Opciones</span>

                            <a class="dropdown-item" href="../pods/viajes/<?php echo $id_viaje . '/' . $row['nombre'] ?>">
                                <i class="bi-download dropdown-item-icon"></i> Descargar
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>