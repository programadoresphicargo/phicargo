<script>
    var fechaInicial = '<?php echo $_GET['fechaInicial'] ?>';
    var fechaFinal = '<?php echo $_GET['fechaFinal'] ?>';

    function consultarViajes() {
        var checkboxes = document.getElementsByName('estados[]');
        var selectedCheckboxes = [];

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                selectedCheckboxes.push(checkboxes[i].value);
            }
        }

        $('#saldos_generales').load('../informes/saldos_generales.php', {
            'empresas': $('#grupoCheck').serialize(),
            'fechaInicial': fechaInicial,
            'fechaFinal': fechaFinal,
            'opcion': 'semana',
            'empresas': selectedCheckboxes,
        });
        console.log('Valores seleccionados:', selectedCheckboxes);
    }

    $('#saldos_generales').load('../informes/saldos_generales.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#ingresos').load('../informes/ingresos.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#pagos').load('../informes/pagos.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#ejecutivos_viajes').load('../informes/viajes_ejecutivos.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#tipo_armado').load('../informes/tipo_armado.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#maniobras').load('../informes/maniobras.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#mantenimiento').load('../informes/mantenimiento.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });

    $('#comentarios').load('../comentarios/comentarios.php', {
        'fechaInicial': fechaInicial,
        'fechaFinal': fechaFinal,
        'opcion': 'semana'
    });
</script>