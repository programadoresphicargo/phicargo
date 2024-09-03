<script>
    var selectedOptions = [];
    var inicio;
    var fin;

    $(document).ready(function() {
        $("#tabla").load('../control/programadas.php');
    });

    flatpickr("#fechaInput", {
        dateFormat: "Y-m-d",
        enableTime: false,
        onChange: function(selectedDates, dateStr, instance) {
            var formattedDate = selectedDates.length > 0 ? selectedDates[0].toISOString().split('T')[0] : '';
            $("#tabla").load('../control/programadas.php', {
                'fecha': formattedDate
            });
        }
    });
</script>