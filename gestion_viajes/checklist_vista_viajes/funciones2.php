<script>
    $("#contenido_checklist_equipos").load('../checklist_vista_viajes/contenido_checklist.php', {
        'id_viaje': '<?php echo $id_viaje ?>'
    });
</script>