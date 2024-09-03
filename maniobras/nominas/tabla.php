<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT *, nominas_movedores.id as id_nomina FROM nominas_movedores inner join operadores on operadores.id = nominas_movedores.id_movedor inner join usuarios on usuarios.id_usuario = nominas_movedores.usuario_creador";
$resultado = $cn->query($sql);
?>

<div class="table-responsive">
    <table class="js-datatable table table-thead-bordered table-align-middle table-hover table-sm" id="tablamaniobras">
        <thead class="thead-light">
            <tr class="text-center">
                <th>ID Nomina</th>
                <th>Movedor</th>
                <th>Periodo inicio</th>
                <th>Periodo fin</th>
                <th>Usuario creador</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr onclick="abrir_nomina('<?php echo $row['id_nomina']; ?>')">
                    <td>
                        <?php echo 'N. ' . $row['id_nomina']; ?>
                    </td>
                    <td>
                        <?php echo $row['nombre_operador']; ?>
                    </td>
                    <td>
                        <?php echo $row['periodo_inicio']; ?>
                    </td>
                    <td>
                        <?php echo $row['periodo_fin']; ?>
                    </td>
                    <td>
                        <?php echo $row['nombre']; ?>
                    </td>
                    <td>
                        <?php echo $row['estado_nomina']; ?>
                    </td>
                </tr>
            <?php } ?>

        </tbody>
    </table>
</div>

<script>
    function abrir_nomina(id_nomina) {
        window.location.href = "../desglose_nomina/index.php?id_nomina=" + id_nomina;
    }
</script>