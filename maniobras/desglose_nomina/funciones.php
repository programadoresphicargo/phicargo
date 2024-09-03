<script>
    $(document).ready(function() {
        $("#tabla_nominas").load('tabla.php', {
            'id_nomina': '<?php echo $_GET['id_nomina'] ?>'
        });
    });
</script>