<?php
require_once('../../mysql/conexion.php');
$cn = conectar();

$sql = "SELECT *, COUNT(*) AS cantidad
FROM incidencias
left join operadores on operadores.id = incidencias.id_operador
GROUP BY id_operador
ORDER BY cantidad DESC";
$resultado = $cn->query($sql);

?>
<div class="table-responsive">
    <table class="table table-sm" id="tablaIncidencias" style="width:100%;">
        <thead>
            <tr>
                <th scope="col">ID operador</th>
                <th scope="col">Nombre operador</th>
                <th scope="col">Número de incidencias</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
                <tr onclick="abrir_historial('<?php echo $row['id_operador'] ?>')" style="cursor:pointer">
                    <td scope="row"><?php echo $row['id_operador'] ?></td>
                    <td scope="row"><?php echo $row['nombre_operador'] ?></td>
                    <td scope="row"><?php echo $row['cantidad'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $('#tablaIncidencias tbody tr').each(function() {
        var cantidad = $(this).find('td:eq(2)').text();
        if (cantidad >= 3) {
            $(this).addClass('bg-danger');
            $(this).addClass('text-white');
        } else if (cantidad == 2) {
            $(this).addClass('bg-warning');
            $(this).addClass('text-dark');
        }
    });

    $('#tablaIncidencias').DataTable({
        ordering: false
    });

    function abrir_historial(id_operador) {
        $("#canvas_historial_incidencias").offcanvas('show');
        $("#historial_incidencias").load('../incidencias/historial.php', {
            'id_operador': id_operador
        })
    }
</script>