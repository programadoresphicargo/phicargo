<script>
    $("#tabla").load('tabla.php');

    $(document).ready(function() {
        $("#daterange").flatpickr({
            mode: 'range',
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 1) {
                    var startDate = selectedDates[0].toISOString().split('T')[0];
                    var endDate = selectedDates[1].toISOString().split('T')[0];
                    $("#selectedDates").text("Start Date: " + startDate + ", End Date: " + endDate);
                    $.ajax({
                        url: "tabla.php",
                        type: "POST",
                        data: {
                            inicio: startDate,
                            fin: endDate
                        },
                        success: function(response) {
                            $("#tabla").html(response);
                        },
                        error: function(xhr, status, error) {
                            notyf.error("Error al cargar datos: " + error);
                        }
                    });
                }
            }
        });
    });
</script>