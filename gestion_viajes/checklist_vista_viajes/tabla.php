<?php
require_once('../../mysql/conexion.php');
$cn = conectar();
$sql = "SELECT * FROM checklist_flota inner join viajes on viajes.id = checklist_flota.viaje_id inner join unidades on unidades.placas = viajes.placas inner join operadores on operadores.id = viajes.employee_id group by viaje_id order by date_order desc";
$resultado = $cn->query($sql);

?>
<table class="table table-sm table-hover table-striped" id="miTabla">
    <thead class="thead-light">
        <tr>
            <th scope="col">Sucursal</th>
            <th scope="col">Fecha</th>
            <th scope="col">Referencia</th>
            <th scope="col">Unidad</th>
            <th scope="col">Operador</th>
            <th scope="col">Ruta</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $resultado->fetch_assoc()) { ?>
            <tr onclick="redirigir('<?php echo $row['viaje_id'] ?>')" style="cursor: pointer;">
                <th><?php echo $row['store_id']; ?></th>
                <th><?php echo $row['date_order']; ?></th>
                <th><?php echo $row['referencia']; ?></th>
                <th><?php echo $row['unidad']; ?></th>
                <th><?php echo $row['nombre_operador']; ?></th>
                <th><?php echo $row['route_id']; ?></th>
            </tr>
        <?php } ?>
    </tbody>
</table>

<script>
    $('#miTabla').DataTable({
        "order": [],
        "orderCellsTop": true,
        "buttons": [],
        "searching": true,
        "aaSorting": [],
        "ordering": true,
        dom: 'Bfrtlip',
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
            [30, 40, 50, 100, 150, 200, -1],
            [30, 40, 50, 100, 150, 200, "All"]
        ]
    });

    function redirigir(id_viaje) {
        window.location.href = "index_viaje.php?id_viaje=" + id_viaje;
    }
</script>