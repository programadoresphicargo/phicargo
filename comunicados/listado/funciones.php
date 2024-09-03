<script>
    $('#listado_comunicados').load('tabla.php');

    $("#crear").click(function() {
        window.location.href = '../comunicado/index.php';
    });
</script>