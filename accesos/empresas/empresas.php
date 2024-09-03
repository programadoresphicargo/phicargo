<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM empresas_accesos inner join usuarios on usuarios.id_usuario = empresas_accesos.id_usuario order by id_empresa desc";
$resultado = $cn->query($sql);
?>

<div class="form-group m-4">
    <div class="row">
        <div class="col-10">
            <label class="text-dark sw-semilbold">Nombre de la empresa</label>
            <input type="text" class="form-control" id="nombre_empresa" placeholder="Ingresar nombre de la empresa">
        </div>
        <div class="col">
            <button type="button" class="btn btn-primary" id="btnRegistrarEmpresa">Registrar</button>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-sm table-hover table-striped" id="miTablaEmpresas">
        <thead>
            <tr>
                <th>Registro</th>
                <th>Nombre de la empresa</th>
                <th>Fecha del registro</th>
                <th>Registrada por</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id_empresa'] ?></td>
                    <td><?php echo $row['nombre_empresa'] ?></td>
                    <td><?php echo $row['fecha_hora'] ?></td>
                    <td><?php echo $row['nombre'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $('#miTablaEmpresas').DataTable();

    $("#btnRegistrarEmpresa").click(function() {
        var nombre_empresa = $("#nombre_empresa").val();
        if (nombre_empresa != '') {
            $.ajax({
                url: "../empresas/registrar_empresa.php",
                data: {
                    'nombre_empresa': nombre_empresa,
                },
                type: "POST",
                dataType: 'json',
                success: function(response) {
                    if (response.success == 1) {
                        notyf.success("Salida registrada correctamente.");
                        $("#empresas_tabla").load('../empresas/empresas.php');
                        getEmpresas();
                        $("#canvas_empresas").modal('hide');
                    } else if (response.success == 2) {
                        notyf.error("Ya existe la empresa.");
                    } else {
                        notyf.error("Error en la solicitud: " + response.message);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    notyf.error("Error en la solicitud AJAX: " + textStatus, errorThrown);
                }
            });
        } else {
            notyf.error('Ingresa un nombre valido');
        }
    });
</script>