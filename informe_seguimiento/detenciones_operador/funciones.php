<script>
    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, '0');
        var day = String(date.getDate()).padStart(2, '0');
        return year + '-' + month + '-' + day;
    }

    var fechaActual = new Date();
    var primerDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
    var ultimoDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);
    var primerDiaMesFormateado = formatDate(primerDiaMes);
    var ultimoDiaMesFormateado = formatDate(ultimoDiaMes);

    var fechaInicio = primerDiaMesFormateado;
    var fechaFin = ultimoDiaMesFormateado;

    function cargar() {
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

    var flatpickrConfig = {
        mode: "range",
        dateFormat: "Y-m-d",
        defaultDate: [fechaInicio, fechaFin],
        onChange: function(selectedDates, dateStr, instance) {
            fechaInicio = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : null;
            fechaFin = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : null;

            console.log("Fecha de inicio:", fechaInicio);
            console.log("Fecha de fin:", fechaFin);

            cargar();
        }
    };

    flatpickr("#fechaRango", flatpickrConfig);

    var select = document.getElementById('opcion');
    select.addEventListener('change', function() {
        cargar();
    });

    cargar();
</script>