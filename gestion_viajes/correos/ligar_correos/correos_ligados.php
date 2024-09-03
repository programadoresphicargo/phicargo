<?php
require_once('../../../mysql/conexion.php');
$cn = conectar();
$id_viaje = $_POST['id_viaje'];
$sqlSelect = "SELECT correos_viajes.id, correo, tipo, viajes.estado FROM correos_viajes INNER JOIN correos_electronicos ON correos_electronicos.id_correo = correos_viajes.id_correo INNER JOIN viajes on viajes.id = correos_viajes.id_viaje WHERE id_viaje = $id_viaje";
$result = $cn->query($sqlSelect);
?>
<table id="listado_correos_ligados" class="table-striped table-sm table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
    <thead>
        <tr>
            <th>Dirección</th>
            <th>Tipo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td>
                    <a class="d-flex align-items-center">
                        <div class="avatar avatar-soft-primary avatar-circle">
                            <span class="avatar-initials"><i class="bi bi-envelope-at"></i></span>
                        </div>
                        <div class="ms-3">
                            <span class="d-block h5 text-inherit mb-0"><?php echo  $row['correo'] ?></span>
                        </div>
                    </a>
                </td>
                <td><?php echo $row['tipo'] ?></td>
                <td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="desvincular_correo('<?php echo $row['id']; ?>','<?php echo $id_viaje; ?>','<?php echo $row['estado']; ?>')"><i class="bi bi-trash3"></i></button></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    function desvincular_correo(id, id_viaje, estado) {
        $.ajax({
            type: "POST",
            data: {
                'id': id
            },
            url: "../correos/ligar_correos/desvincular_correo.php",
            success: function(respuesta) {
                if (respuesta == '1') {
                    comprobar_correos_ligados(id_viaje, estado);
                    cargar_tabla_ligados(id_viaje);
                } else {
                    notyf.error(respuesta);
                }
            }
        }, );
    }
</script>