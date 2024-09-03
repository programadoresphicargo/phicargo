<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sqlSelect = "SELECT * FROM comunicados inner join usuarios on usuarios.id_usuario = comunicados.id_usuario order by fecha_hora desc";
$resultado = $cn->query($sqlSelect);
?>

<!-- Table -->
<div class="">
    <table class="table table-striped table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm">
        <thead class="thead-light">
            <tr>
                <th>Titulo</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Imagen</th>
            </tr>
        </thead>

        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr onclick="window.location.href = '../comunicado/index.php?id_comunicado=<?php echo $row['id_comunicado'] ?>'">
                    <td><?php echo $row['titulo'] ?></td>
                    <td><?php echo $row['nombre'] ?></td>
                    <td><?php echo $row['fecha_hora'] ?></td>
                    <td>
                        <span class="avatar avatar-xl avatar-4x3">
                            <?php $id_comunicado = $row['id_comunicado'];
                            $sqlSelectFotos = "SELECT * FROM comunicados_fotos where id_comunicado = $id_comunicado";
                            $resultadoFotos = $cn->query($sqlSelectFotos);
                            while ($row2 = $resultadoFotos->fetch_assoc()) { ?>
                                <img class="avatar-img" src="../fotos/<?php echo $row2['id_comunicado'] ?>/<?php echo $row2['nombre'] ?>" alt="Image Description">
                            <?php } ?>
                        </span>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- End Table -->