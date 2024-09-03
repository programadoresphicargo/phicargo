<?php
require_once('../../mysql/conexion.php');

$cn = conectar();
$sqlSelect = "SELECT ID, NOMBRE_OPERADOR, PASSWOORD, IDENTIFIER, MODALIDAD, PELIGROSO, ACTIVO FROM operadores";
$resultSet = $cn->query($sqlSelect);

?>

<table id="CuentasUsuario" class="table table-striped table-hover table-responsive">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Contraseña</th>
            <th>Identificador</th>
            <th>Modalidad</th>
            <th>Peligroso</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultSet->fetch_assoc()) { ?>
            <tr onclick="getDatos('<?php echo $row['ID']; ?>',
        '<?php echo $row['NOMBRE_OPERADOR']; ?>',
        '<?php echo $row['PASSWOORD']; ?>')">
                <td class="card-title">
                    <div class="badge bg-primary"><?php echo $row['ID'] ?></div>
                </td>
                <td class="card-title"><?php echo $row['NOMBRE_OPERADOR'] ?></td>
                <td class="card-title"><?php echo $row['PASSWOORD'] ?></td>
                <td class="card-title"><?php echo $row['IDENTIFIER'] ?></td>
                <?php if ($row['MODALIDAD'] == 'single') { ?>
                    <td class="card-title">
                        <div class="badge bg-warning"><?php echo 'SENCILLO' ?></div>
                    </td>
                <?php } else if ($row['MODALIDAD'] == 'full') { ?>
                    <td class="card-title">
                        <div class="badge bg-success"><?php echo 'FULL' ?></div>
                    </td>
                <?php } else { ?>
                    <td class="card-title"><?php echo '' ?></td>
                <?php } ?>
                <td class="card-title"><?php echo $row['PELIGROSO'] ?></td>

                <?php if ($row['ACTIVO'] == 1) { ?>
                    <td class="card-title">
                        <div class="badge bg-success"><?php echo 'Activo' ?></div>
                    </td>
                <?php } else if ($row['ACTIVO'] == 0) { ?>
                    <td class="card-title">
                        <div class="badge bg-danger"><?php echo 'Inactivo' ?></div>
                    </td>
                <?php } ?>

            </tr>
        <?php } ?>
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#CuentasUsuario').DataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": " Primero ",
                    "last": " Ultimo ",
                    "next": " Proximo ",
                    "previous": " Anterior  "
                }
            },
            "lengthMenu": [
                [20, 25, 30, 40, 50, -1],
                [20, 25, 30, 40, 50, "All"]
            ]
        });
    });
</script>
<script>
    function getDatos(id_operador, nombre_operador, contraseña) {
        console.log('ahs');
        $('#editar_operador').modal('show'); // abrir
        $('#id_operador').val(id_operador);
        $('#nombre_operador').val(nombre_operador);
        $('#contraseña').val(contraseña);
    }
</script>