<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT *, usuarios.nombre as n1 FROM acceso_peatonal 
left join empresas_accesos on empresas_accesos.id_empresa = acceso_peatonal.id_empresa 
left join usuarios on usuarios.id_usuario = acceso_peatonal.usuario_creacion 
order by estado_acceso asc";
$resultado = $cn->query($sql);
?>

<div class="page-header">
    <div class="row align-items-center">
        <div class="col-sm mb-2 mb-sm-0">
            <h2 class="page-header-title">Acceso Peatonal</h2>
        </div>

        <div class="col-sm-auto">
            <a class="btn btn-success btn-sm" onclick="actualizar()">
                <i class="bi bi-arrow-clockwise"></i> Actualizar
            </a>

            <a class="btn btn-primary btn-sm" href="../acceso_peatonal/index_form.php">
                <i class="bi bi-plus-lg"></i> Nuevo acceso
            </a>
        </div>
    </div>
</div>

<table class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-striped" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Código de acceso</th>
            <th scope="col">Tipo de movimiento</th>
            <th scope="col">Fecha de entrada o salida</th>
            <th scope="col">Empresa</th>
            <th scope="col">Solicitado por</th>
            <th scope="col">Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_array()) { ?>
            <tr onclick="ir('<?php echo $row['id_acceso'] ?>')">
                <th><?php echo 'A-' . $row['id_acceso'] ?></th>
                <th>
                    <?php if ($row['tipo_mov'] == 'acceso') { ?>
                        <span class="badge bg-success rounded-pill">Acceso a las instalaciones</span>
                    <?php } elseif ($row['tipo_mov'] == 'salida') { ?>
                        <span class="badge bg-danger rounded-pill">Salida de las instalaciones</span>
                    <?php }  ?>
                </th>
                <th>
                    <?php
                    $fechaEntrada = $row['fecha_entrada'];
                    $dateTime = new DateTime($fechaEntrada);
                    $fechaFormateada = $dateTime->format('Y/m/d g:i a');
                    echo $fechaFormateada;
                    ?>
                </th>
                <th><?php echo $row['nombre_empresa'] ?></th>
                <th><?php echo $row['n1'] ?></th>
                <th>
                    <?php if ($row['estado_acceso'] == 'espera') { ?>
                        <span class="badge bg-warning rounded-pill">En espera de validación</span>
                    <?php } elseif ($row['estado_acceso'] == 'validado') { ?>
                        <span class="badge bg-success rounded-pill">Validado</span>
                    <?php } elseif ($row['estado_acceso'] == 'salida') { ?>
                        <span class="badge bg-soft-secondary rounded-pill text-dark">Salida validada</span>
                    <?php } ?>
                </th>
            </tr>
        <?php } ?>
    </tbody>
</table>
