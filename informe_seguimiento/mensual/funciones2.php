<script>
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
            'mes': mes,
            'año': año,
            'opcion': 'mes',
            'empresas': selectedCheckboxes,
        });
        console.log('Valores seleccionados:', selectedCheckboxes);
    }
</script>