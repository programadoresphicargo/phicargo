<script>
    var criterioBusqueda = [];
    $(document).ready(function() {

        $("#GenerarReporte").click(function() {
            datos = $("#FormReporteStatus").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigos/ReporteStatus2.php",
                success: function(respuesta) {
                    $("#ReporteStatusListado").html(respuesta);
                }
            });
        });

        $("#GenerarReporte").click(function() {
            datos = $("#FormReporteStatus").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigos/ReporteStatus.php",
                success: function(respuesta) {
                    $("#ReporteStatus").html(respuesta);
                    $('#InicioReporteStatus').modal('hide');
                }
            });
        });

        $("#GenerarReporteCola").click(function() {
            datos = $("#FormReporteCola").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigos/ReporteCola.php",
                success: function(respuesta) {
                    $("#ReporteStatus").html(respuesta);
                }
            });
        });

        $("#GenerarPDF").click(function() {

            datos = $("#FormReporteStatus").serialize();
            console.log(datos);
            $.ajax({
                type: "POST",
                data: datos,
                url: "../codigos/ReporteStatus.php",
                success: function(respuesta) {
                    $("#ReporteStatus").html(respuesta);
                    const contenido = document.getElementById('ReporteStatus');

                    const opt = {
                        margin: 10,
                        filename: 'documento.pdf',
                        image: {
                            type: 'jpeg',
                            quality: 0.98
                        },
                        html2canvas: {
                            scale: 3
                        },
                        jsPDF: {
                            unit: 'mm',
                            format: 'a4',
                            orientation: 'portrait'
                        }
                    };

                    // Convertir el contenido HTML a PDF
                    html2pdf().from(contenido).set(opt).save();
                }
            });
        });
    });
</script>