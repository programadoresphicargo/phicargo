<script>
    var seleccionados = [];
    var inicio;
    var fin;

    function confirmar_nomina() {
        console.log(seleccionados);
        let datos = {
            id_operador: '<?php echo $_GET['id'] ?>',
            maniobras: seleccionados,
            inicio: inicio,
            fin: fin
        };
        $.ajax({
            url: "guardar_nomina.php",
            type: "POST",
            data: datos,
            success: function(response) {
                notyf.success('Guardado correcto');
            },
            error: function(xhr, status, error) {
                $("#data-container").html("Error al cargar datos: " + error);
            }
        });
    }

    function actualizarTotalAPagar() {
        $("#contador_pagar").show();
        seleccionados = [];
        var totalPagar = 0;
        $("#tablamaniobras tbody tr").each(function() {

            var id = parseFloat($(this).find(".id").text());
            var tipo_maniobra = $(this).find(".tipo_maniobra").text().trim();
            var total = parseFloat($(this).find(".total").text());
            totalPagar += total;

            var objeto = {
                id: id,
                tipo_maniobra: tipo_maniobra,
                total: total
            };
            seleccionados.push(objeto);

        });

        console.log(seleccionados);
        console.log(totalPagar);
        var elementoTotalAPagar = document.getElementById("totalAPagar");
        elementoTotalAPagar.textContent = "Total a pagar: $ " + totalPagar + '.00';
    }

    $("#confirmar_nomina").click(function() {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Confirmar registro de nomina",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, confirmar",
            cancelButtonText: "No, cancelar",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                confirmar_nomina();
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {

            }
        });
    });

    $(document).ready(function() {
        $("#daterange").flatpickr({
            mode: 'range',
            dateFormat: "Y-m-d", // Formato de fecha deseado
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 1) {
                    var startDate = selectedDates[0].toISOString().split('T')[0];
                    var endDate = selectedDates[1].toISOString().split('T')[0];
                    inicio = startDate;
                    fin = endDate;
                    $("#selectedDates").text("Start Date: " + startDate + ", End Date: " + endDate);
                    $.ajax({
                        url: "tabla.php", // URL del servidor
                        type: "POST", // Método HTTP (GET, POST, PUT, DELETE, etc.)
                        data: {
                            id_operador: '<?php echo $_GET['id'] ?>',
                            inicio: startDate,
                            fin: endDate
                        }, // Tipo de datos esperados en la respuesta
                        success: function(response) {
                            $("#tabla_contenedores").html(response);
                            actualizarTotalAPagar();
                        },
                        error: function(xhr, status, error) {
                            // Manejar errores de la solicitud AJAX
                            $("#data-container").html("Error al cargar datos: " + error);
                        }
                    });
                }
            }
        });
    });
</script>