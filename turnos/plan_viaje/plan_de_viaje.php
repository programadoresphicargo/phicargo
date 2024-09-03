<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$rango = $_POST['rango'];
$sucursal = $_POST['sucursal'];

if (isset($_POST['update'])) {
    foreach ($_POST['positions'] as $position) {
        $index = $position[0];
        $newPosition = $position[1];
        $sqlUpdate = "UPDATE turnos SET turno = '$newPosition' WHERE id_turno='$index'";
        echo $sqlUpdate;
        $cn->query($sqlUpdate);
    }

    exit('success');
}

$Date = date('Y-m-d');
$sqlSelect = "SELECT id_turno, turno, id_operador, nombre_operador, unidades.placas, unidad, fecha_llegada, hora_llegada, comentarios, id_usuario_archivado, sucursal, fecha_archivado, nombre, motivo_archivado FROM turnos LEFT JOIN operadores ON turnos.id_operador = operadores.id LEFT JOIN unidades ON turnos.placas = unidades.placas LEFT JOIN usuarios on usuarios.id_usuario = turnos.id_usuario_archivado where sucursal = '$sucursal' and date(fecha_archivado) = '$rango' and fecha_archivado IS NOT NULL ORDER BY fecha_archivado desc";
$resultSet = $cn->query($sqlSelect); ?>
<div class="table-responsive">
    <table id="PlanDeViaje" class="table table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover" style="width: 100%;">
        <thead class="thead-light">
            <tr>
                <th>ID Turno</th>
                <th>Operador</th>
                <th>Placas / Unidad</th>
                <th>Llegada</th>
                <th>Comentarios</th>
                <th>Archivado por</th>
                <th>Fecha archivado</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="listado_plan_de_viaje">
            <?php $i = 1;
            while ($row = $resultSet->fetch_assoc()) { ?>
                <tr class="cursor-pointer" data-index="<?php echo $row['id_turno'] ?>" data-position="<?php echo $row['turno'] ?>">
                    <td>
                        <?php echo $row['id_turno'] ?>
                    </td>
                    <td class="fw-bold text-dark">
                        <?php echo $row['nombre_operador'] ?>
                    </td>
                    <td>
                        <?php echo '[' . $row['placas'] . '] ' . $row['unidad'] ?>
                    </td>
                    <td>
                        <?php echo $row['fecha_llegada'] . ' ' . $row['hora_llegada'] ?>
                    </td>
                    <td>
                        <?php echo $row['comentarios'] ?>
                    </td>
                    <td>
                        <h2 class="fw-normal mb-1"><span class="fs-5 text-body text-uppercase"><?php echo $row['nombre'] ?></span></h2>
                    </td>
                    <td>
                        <h2 class="fw-normal mb-1"><span class="fs-5 text-body text-uppercase"><?php echo $row['fecha_archivado'] ?></span></h2>
                    </td>
                    <td>
                        <?php echo $row['motivo_archivado'] ?>
                    </td>
                    <td class="fw-bold text-dark"><button type="button" class="btn btn-success btn-xs" onclick="reingresar_turno('<?php echo $row['id_turno']; ?>')">
                            Reingresar
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    $('#PlanDeViaje').DataTable({
        paging: false,
        searching: true,
        ordering: false,
    });

    var sucursal = '<?php echo $sucursal ?>';

    function reingresar_turno(id_turno) {
        Swal.fire({
            title: '¿Estás seguro que quieres reingresar este turno?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, reingresar a turnos',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $("#exampleModalCenter").offcanvas('hide');
                $.ajax({
                    type: "POST",
                    data: {
                        'id_turno': id_turno,
                        'sucursal': sucursal
                    },
                    url: "../plan_viaje/reingreso_turnos.php",
                    success: function(respuesta) {
                        if (respuesta == 1) {
                            $("#exampleModalCenter").modal('hide');
                            $("#tabla").load('../codigos/tabla.php', {
                                sucursal: sucursal
                            });
                            Swal.fire('¡Reingresado!', 'El turno ha sido reingresado correctamente.', 'success');
                        } else {
                            Swal.fire('Error', 'Error: ' + respuesta, 'error');
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire('Cancelado', 'El usuario canceló la ejecución.', 'info');
            }
        });
    }
</script>