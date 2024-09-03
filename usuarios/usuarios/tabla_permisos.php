<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$id_usuario = $_POST['id_usuario'];
$sqlSelet = "SELECT id_usuario, permisos.id_permiso, descripcion FROM permisos_usuarios INNER JOIN permisos on permisos.id_permiso = permisos_usuarios.id_permiso where id_usuario = $id_usuario order by id_permiso";
$resultado = $cn->query($sqlSelet);
?>
<div class="table-responsive datatable-custom" style="height: 25rem;">
    <table class="js-datatable table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
        <thead class="thead-light">
            <tr>
                <th>Código de permiso</th>
                <th>Descripción del permiso</th>
                <th>Quitar permiso</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td class="text-center">
                        <span class="avatar avatar-soft-success avatar-circle">
                            <span class="avatar-initials"><?php echo $row['id_permiso'] ?></span>
                        </span>
                    </td>
                    <td width="90%">
                        <div class="ms-3">
                            <span class="d-block h5 text-inherit mb-0"><?php echo $row['descripcion'] ?></span>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm" onclick="quitar_permiso(<?php echo $row['id_usuario'] ?>,<?php echo $row['id_permiso'] ?>)">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    function quitar_permiso(id_usuario, id_permiso) {
        console.log(id_usuario);
        console.log(id_permiso);

        $.ajax({
            type: "POST",
            data: {
                'id_usuario': id_usuario,
                'id_permiso': id_permiso
            },
            url: "../codigo/quitar_permisos.php",
            success: function(respuesta) {
                if (respuesta == 1) {
                    $.ajax({
                        type: "POST",
                        data: {
                            'id_usuario': id_usuario
                        },
                        url: "tabla_permisos.php",
                        success: function(respuesta) {
                            $("#usuarios_permisos_tabla").html(respuesta);
                            notyf.success('Permiso eliminado correctamente');
                        }
                    });
                } else {
                    notyf.error('Error, verifica la información.');
                }
            }
        });


    }
</script>