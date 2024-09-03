<?php
function generarTablaSemanas($year)
{
    $html = '<table class="table table-sm table-hover table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">';
    $html .= '<tr><th>Semana</th><th>Inicio</th><th>Fin</th></tr>';

    $fecha = new DateTime();
    $fecha->setISODate($year, 1, 1);

    while ($fecha->format('Y') == $year) {
        $inicioSemana = $fecha->format('Y-m-d');
        $fecha->modify('+6 days');
        $finSemana = $fecha->format('Y-m-d');


        $html .= '<tr onclick="mostrarRango(\'' . $inicioSemana . '\', \'' . $finSemana . '\', \'' . $fecha->format('W') . '\');">';
        $html .= '<td>' . $fecha->format('W') . '</td>';
        $html .= '<td>' . $inicioSemana . '</td>';
        $html .= '<td>' . $finSemana . '</td>';
        $html .= '</tr>';

        $fecha->modify('+1 days');
    }

    $html .= '</table>';

    return $html;
}
?>


<div class="container mt-4">
    <h2>Semanas</h2>
    <?php
    $currentYear = date('Y');
    for ($year = 2021; $year <= $currentYear; $year++) {
    ?>
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <div class="accordion-header" id="headingOne">
                    <a class="accordion-button" role="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $year ?>" aria-expanded="true" aria-controls="collapse<?php echo $year ?>">
                        <?php echo $year ?>
                    </a>
                </div>
                <div id="collapse<?php echo $year ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php
                        $tablaSemanas = generarTablaSemanas($year);
                        echo $tablaSemanas;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    function mostrarRango(inicio, fin, semana) {
        var nuevaURL = '../semanal/index.php' + '?fechaInicial=' + encodeURIComponent(inicio) + '&fechaFinal=' + encodeURIComponent(fin) + '&semana=' + encodeURIComponent(semana);
        window.location.href = nuevaURL;
    }
</script>