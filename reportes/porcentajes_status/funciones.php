<script>
    var fechaInicio;
    var fechaFin;

    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            fechaInicio = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : null;
            fechaFin = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : null;

            console.log("Fecha de inicio:", fechaInicio);
            console.log("Fecha de fin:", fechaFin);

            $("#registros").load('tabla.php', {
                'fecha_inicio': fechaInicio,
                'fecha_fin': fechaFin
            });

        }
    });
</script>