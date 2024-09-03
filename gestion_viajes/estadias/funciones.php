<script>
    var fechaInicio;
    var fechaFin;

    function cargar() {

        var parametros = {
            'opcion': $("#opcion").val(),
            'fechaInicio': fechaInicio,
            'fechaFin': fechaFin
        };

        if (fechaFin != null) {
            $.ajax({
                url: 'tabla.php',
                type: 'POST',
                data: parametros,
                success: function(response) {
                    $('#tabla_reportes').html(response);
                    var elemento = document.getElementById("miTabla");
                    if (elemento) {
                        console.log("El elemento existe.");
                        cargar_tabla();
                    } else {
                        console.log("El elemento no existe.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', xhr.status, xhr.statusText);
                }
            });
        }
    }

    var flatpickrConfig = {
        mode: "range",
        dateFormat: "Y-m-d",
        defaultDate: [fechaInicio, fechaFin],
        onChange: function(selectedDates, dateStr, instance) {
            fechaInicio = selectedDates[0] ? selectedDates[0].toISOString().split('T')[0] : null;
            fechaFin = selectedDates[1] ? selectedDates[1].toISOString().split('T')[0] : null;

            console.log("Fecha de inicio:", fechaInicio);
            console.log("Fecha de fin:", fechaFin);

            cargar();
        }
    };

    flatpickr("#fechaRango", flatpickrConfig);
</script>


<script>
    var selectedCheckboxes = [];

    function handleCheckboxChange(checkbox) {
        if (checkbox.checked) {
            selectedCheckboxes.push(checkbox.value);
        } else {
            var index = selectedCheckboxes.indexOf(checkbox.value);
            if (index !== -1) {
                selectedCheckboxes.splice(index, 1);
            }
        }
        console.log("Checkboxes seleccionados:", selectedCheckboxes);
        cargar();
    }
</script>

<script>
    function cargar_tabla() {
        $('#miTabla').DataTable().destroy();
        var table = $('#miTabla').DataTable({
            rowGroup: {
                dataSrc: selectedCheckboxes,
            },
            language: {
                searchPanes: {
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
                            className: 'btn btn-primary',
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
        });

        table.ajax.reload();

    }

    $("#guardar_cobro").click(function() {
        var datos = $("#formcobroestadia").serialize();
        $.ajax({
            url: 'guardar_cobro.php',
            type: 'POST',
            data: datos,
            success: function(response) {
                if (response == '1') {
                    notyf.success('Registro guardado correctamente');
                    cargar_tabla();
                } else {
                    notyf.error(response)
                }
            },
            error: function(xhr, status, error) {
                notyf.error('Error al obtener los datos:', xhr.status, xhr.statusText);
            }
        });
    });

    $("#confirmar_cobro").click(function() {
        var datos = $("#formcobroestadia").serialize();
        $.ajax({
            url: 'confirmar_cobro.php',
            type: 'POST',
            data: datos,
            success: function(response) {
                if (response == '1') {
                    notyf.success('Cobro confirmado');
                    cargar();
                } else {
                    notyf.error(response)
                }
            },
            error: function(xhr, status, error) {
                notyf.error('Error al obtener los datos:', xhr.status, xhr.statusText);
            }
        });
    });

    const input1 = document.getElementById('horas_cobro');
    const input2 = document.getElementById('precio_hora');
    const input3 = document.getElementById('total_cobrar');

    function verificarCambios() {
        const valorInput1 = input1.value;
        const valorInput2 = input2.value;

        if (valorInput1 !== '' && valorInput2 !== '') {
            var total = valorInput1 * valorInput2;
            $("#total_cobrar").val(total);
        }
    }

    input1.addEventListener('input', verificarCambios);
    input2.addEventListener('input', verificarCambios);


    $("#abrir_modal_cancelacion").click(function() {
        $("#estadia_cancelacion_modal").modal('show');
        $("#id-viaje-cancelacion").val($("#id_viaje").val());
    });

    $("#cancelar_estadia").click(function() {
        var datos = $("#form_estadia_cancelacion").serialize();
        $.ajax({
            url: 'cancelar_estadia.php',
            type: 'POST',
            data: datos,
            success: function(response) {
                if (response == '1') {
                    $("#estadia_cancelacion_modal").modal('show');
                    notyf.success('Estadia cancelada.');
                    cargar();
                } else {
                    notyf.error(response)
                }
            },
            error: function(xhr, status, error) {
                notyf.error('Error al obtener los datos:', xhr.status, xhr.statusText);
            }
        });
    });

    var select = document.getElementById('idfactura');
    var jsonFile = 'lineas.json'; // Reemplaza con la ruta correcta

    fetch(jsonFile)
        .then(response => response.json())
        .then(data => {
            data.forEach(function(item) {
                var option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.id; // Ajusta según la estructura de tu JSON
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error loading JSON:', error));
</script>