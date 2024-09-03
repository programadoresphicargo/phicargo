<script>
    var salesData = <?php echo $data; ?>;
    var url = '../../disponibilidad/operadores/get_operadores.php';
    // Agrupar los datos
    var groupByFields = [];
    var columns = [
        ['Empleado', 'name'],
        ['Tipo', 'job_id'],
        ['Status', 'x_status'],
        ['Viaje', 'x_viaje'],
        ['Maniora', 'x_maniobra'],
    ];

    var columnas2 = [
        ['Empleado', 'name'],
        ['Tipo', 'job_id'],
        ['Status', 'x_status'],
        ['Viaje', 'x_viaje'],
        ['Maniora', 'x_maniobra'],
    ];

    cargar_agrupar(columnas2);
    crearElementos(columns);

    if (groupByFields.length === 0) {
        const salesList = renderGroup(salesData, 0);
        salesListContainer.appendChild(salesList);
    } else {
        const salesList = renderGroup(salesData, 0);
        salesListContainer.appendChild(salesList);
    }

    $(document).ready(function() {

        $("#guardar_estado").on("click", function() {
            var datos = $("#FormInfoEquipo").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                url: "guardar_cambios.php",
                data: datos,
                success: function(data) {
                    if (data == '1') {
                        notyf.success('Registro modificado correctamente');
                        $("#disponibilidad_equipo").load('tabla.php');
                    } else {
                        notyf.error('Registro modificado correctamente');
                    }
                }
            });
        });
    });
</script>

<script>
    function abrir_info(id_unidad, estado) {
        $('#id_unidad').val(id_unidad);
        $('#estado').val(estado);
        $('#info_unidad').offcanvas('show');
    }
</script>