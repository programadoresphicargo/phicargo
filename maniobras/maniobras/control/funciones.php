<script>
    var selectedOptions = [];
    var inicio;
    var fin;

    $(document).ready(function() {
        $("#tabla").load('tabla.php');
    });

    function recargar() {
        $("#tabla").load('tabla.php');
    }
</script>