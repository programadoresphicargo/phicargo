<script>
    $("#registros").load('tabla.php');
</script>

<script>
    $.ajax({
        url: '../data/update_flota.php',
        method: 'POST',
        dataType: 'json',
        success: function(response) {},
        error: function(jqXHR, textStatus, errorThrown) {}
    });

    function loadData(filterValue, selectId) {
        $.ajax({
            url: '../data/get_flota.php',
            method: 'POST',
            data: {
                fleet_type: filterValue
            },
            dataType: 'json',
            success: function(response) {
                $.each(response, function(index, item) {
                    $('#' + selectId).append('<option value="' + item.vehicle_id + '">' + item.name + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar los datos: ', textStatus, errorThrown);
            }
        });
    }

    function loadOperadores() {
        $.ajax({
            url: '../data/get_operadores.php',
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                $.each(response, function(index, item) {
                    $('#operador_id').append('<option value="' + item.id + '">' + item.nombre_operador + '</option>');
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al cargar los datos: ', textStatus, errorThrown);
            }
        });
    }

    loadData('tractor', 'vehicle_id');
    loadData('trailer', 'trailer1_id');
    loadData('trailer', 'trailer2_id');
    loadData('dolly', 'dolly_id');
    loadOperadores();
</script>