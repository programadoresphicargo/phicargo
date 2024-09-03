<?php

$year = date("Y");
$month = date("n");
$monthNames = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];
?>

<div class="container mt-4">
    <h2>Mensual</h2>
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

                        <table class="table table-sm table-hover table-striped table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                            <tr>
                                <th>Mes</th>
                            </tr>
                            <?php
                            for ($i = 1; $i <= 12; $i++) { ?>
                                <tr>
                                    <td onclick="getMes('<?php echo $i ?>','<?php echo $year ?>','<?php echo $monthNames[$i - 1] ?>')"><?php echo $monthNames[$i - 1] . ' - ' . $year ?></td>
                                </tr>
                            <?php  }
                            ?>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<script>
    function getMes(mes, año, nombre) {
        var nuevaURL = '../mensual/index.php' + '?mes=' + encodeURIComponent(mes) + '&año=' + encodeURIComponent(año) + '&nombre=' + encodeURIComponent(nombre);
        window.location.href = nuevaURL;
    }
</script>