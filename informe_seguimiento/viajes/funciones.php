<script>
    $('#myTable').DataTable();

    // Inicializar Flatpickr en modo rango
    var flatpickrConfig = {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            // Capturar las fechas seleccionadas y almacenarlas en dos variables
            var fechaInicio = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : null;
            var fechaFin = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : null;

            // Mostrar las fechas seleccionadas en la consola
            console.log("Fecha de inicio:", fechaInicio);
            console.log("Fecha de fin:", fechaFin);

            if (fechaFin != null) {
                $("#reporte").load('tabla.php', {
                    'opcion': $("#opcion").val(),
                    'fechaInicio': fechaInicio,
                    'fechaFin': fechaFin
                }, function(response, status, xhr) {
                    if (status == "error") {
                        console.error('Error al obtener los datos:', xhr.status, xhr.statusText);
                    }
                });
            }
        }
    };

    // Aplicar Flatpickr al elemento de entrada de texto
    flatpickr("#fechaRango", flatpickrConfig);
</script>