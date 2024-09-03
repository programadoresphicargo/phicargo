<script>
    var mes = '<?php echo $_GET['mes'] ?>';
    var año = '<?php echo $_GET['año'] ?>';

    $('#carga_saldos').show();
    $('#saldos_generales').load('../informes/saldos_generales.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_saldos').hide();
    });

    $('#carga_ingresos').show();
    $('#ingresos').load('../informes/ingresos.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_ingresos').hide();
    });

    $('#carga_pagos').show();
    $('#pagos').load('../informes/pagos.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_pagos').hide();
    });

    $('#carga_viajes_ejecutivos').show();
    $('#viajes_ejecutivos').load('../informes/viajes_ejecutivos.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_viajes_ejecutivos').hide();
    });

    $('#carga_tipo_armado').show();
    $('#tipo_armado').load('../informes/tipo_armado.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_tipo_armado').hide();
    });

    $('#carga_maniobras').show();
    $('#maniobras').load('../informes/maniobras.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_maniobras').hide();
    });

    $('#carga_mantenimiento').show();
    $('#mantenimiento').load('../informes/mantenimiento.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_mantenimiento').hide();
    });

    $('#carga_comentarios').show();
    $('#comentarios').load('../comentarios/comentarios.php', {
        'mes': mes,
        'año': año,
        'opcion': 'mes'
    }, function() {
        $('#carga_comentarios').hide();
    });
</script>