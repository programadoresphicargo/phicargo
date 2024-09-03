<script>
    var salesData = <?php echo $data; ?>;
    var url = '../../disponibilidad/equipos/getContenedores.php';
    // Agrupar los datos
    var groupByFields = [];
    var columns = [
        ['Nombre', 'name2'],
        ['Placas', 'license_plate'],
        ['Tipo', 'fleet_type'],
        ['Status', 'x_status'],
        ['Viaje', 'x_viaje'],
        ['Maniora', 'x_maniobra'],
        ['OM', 'x_om']
    ];

    var columnas2 = [
        ['Nombre', 'name2'],
        ['Clase', 'fleet_type'],
        ['Status', 'x_status'],
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