<script>
    
    var fechaInicio;
    var fechaFin;

    $("#generarReporte").click(function() {
        generar_reporte();
    });

    function generar_reporte() {
        notyf.success('Generando informe, espere un minuto.');
        console.log("Fecha de inicio:", fechaInicio);
        console.log("Fecha de fin:", fechaFin);

        $("#registros").load('tabla.php', {
            'fecha_inicio': fechaInicio,
            'fecha_fin': fechaFin
        }, function() {
            notyf.success('Reporte generado.');
            cargar_colores();
        });
    }

    flatpickr("#dateRangePicker", {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            fechaInicio = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : null;
            fechaFin = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : null;
            console.log("Fecha de inicio:", fechaInicio);
            console.log("Fecha de fin:", fechaFin);
        }
    });

    var selectedOptions = [];

    $(".dropdown-menu").on("change", "input[type='checkbox']", function() {
        var optionValue = $(this).val();

        if ($(this).is(":checked")) {
            if (selectedOptions.indexOf(optionValue) === -1) {
                selectedOptions.push(optionValue);
            }
        } else {
            var index = selectedOptions.indexOf(optionValue);
            if (index !== -1) {
                selectedOptions.splice(index, 1);
            }
        }

        if (selectedOptions.length == 0) {
            cargar_colores();
        } else {

        }
        console.log(selectedOptions);
        cargar_colores();
    });

    function cargar_colores() {
        console.log('Recargo tabla');
        var table = $('#tabla-datos').DataTable();
        table.destroy();

        $('#tabla-datos').DataTable({
            enableSorting: false, 
            rowGroup: {
                dataSrc: selectedOptions,
            },
            language: {
                searchPanes: {
                    layout: 'columns-6',
                    clearMessage: 'Borrar busquedas',
                    collapse: {
                        0: 'Search Options',
                        _: 'Search Options (%d)'
                    }
                }
            },
            layout: {
                topStart: {
                    buttons: [{
                            extend: 'searchPanes',
                            className: 'btn btn-primary btn-sm',
                            text: 'Busqueda avanzada',
                            layout: 'columns-6'
                        }, {
                            extend: 'pdfHtml5',
                            text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                            titleAttr: 'Exportar a PDF',
                            className: 'btn btn-primary btn-sm',
                        },
                        {
                            extend: 'excelHtml5',
                            text: 'Exel <i class="bi bi-filetype-exe"></i>',
                            titleAttr: 'Exportar a Exel',
                            className: 'btn btn-primary btn-sm'
                        },
                        {
                            extend: 'print',
                            text: 'Impresion <i class="bi bi-printer"></i>',
                            className: 'btn btn-primary btn-sm',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ]
                }
            },
            lengthMenu: [
                [100, -1],
                [100, "All"]
            ]
        });

        table.ajax.reload();
    }
</script>