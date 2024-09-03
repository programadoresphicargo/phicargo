<?php

require_once('../../odoo/odoo-conexion.php');

$opcion = $_POST['opcion'];
$startDate = $_POST['fechaInicio'];
$endDate = $_POST['fechaFin'];

$kwargs = ['fields' => ['id', 'date_order', 'vehicle_id', 'store_id', 'travel_id', 'x_tipo_bel'], 'order' => 'id asc'];
$ids = $models->execute_kw(
    $db,
    $uid,
    $password,
    'tms.waybill',
    'search_read',
    array(
        array(
            array('date_order', '>=', $startDate),
            array('date_order', '<=', $endDate),
            array('employee_id', '!=', false),
            array('state', '!=', 'cancel')
            
        )
    ),
    $kwargs
);

$data = json_encode($ids);
$shipments = json_decode($data, true);

$uniqueShipments = [];
foreach ($shipments as $shipment) {
    $travelId = $shipment['travel_id'][1];
    if (!isset($uniqueShipments[$travelId])) {
        $uniqueShipments[$travelId] = $shipment;
    }
}

$counts = [];

$startDate = new DateTime($startDate);
$endDate = new DateTime($endDate);
$dateRange = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);

foreach ($uniqueShipments as $shipment) {
    $storeId = $shipment['store_id'][1];
    $type = $shipment['x_tipo_bel'];
    $date = $shipment['date_order'];

    if (!isset($counts[$storeId][$type][$date])) {
        $counts[$storeId][$type][$date] = 1;
    } else {
        $counts[$storeId][$type][$date]++;
    }
}
?>
<div class="table-responsive">
    <table class="table table-sm table-hover table-striped table-borderless" id="myTable">
        <thead class="thead-light">
            <tr>
                <th>Sucursales</th>
                <th>Tipo</th>
                <?php foreach ($dateRange as $date) : ?>
                    <th><?= $date->format('Y-m-d') ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($counts as $storeId => $storeData) : ?>
                <?php foreach (["single", "full"] as $type) : ?>
                    <tr>
                        <td><?= $storeId ?></td>
                        <td><?= $type ?></td>
                        <?php foreach ($dateRange as $date) : ?>
                            <?php
                            $dateStr = $date->format('Y-m-d');
                            $count = isset($storeData[$type][$dateStr]) ? $storeData[$type][$dateStr] : 0;
                            ?>
                            <td><?= $count ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#myTable').DataTable({
        dom: 'Bfrtlip',
        buttons: [{
                extend: 'pdfHtml5',
                text: 'PDF <i class="bi bi-filetype-pdf"></i>',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-sm btn-danger',
            },
            {
                extend: 'excelHtml5',
                text: 'Exel <i class="bi bi-filetype-exe"></i>',
                titleAttr: 'Exportar a Exel',
                className: 'btn btn-sm btn-success'
            },
            {
                extend: 'print',
                text: 'Impresion <i class="bi bi-printer"></i>',
                className: 'btn btn-sm btn-primary',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        language: {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "paginate": {
                "first": " Primero ",
                "last": " Ultimo ",
                "next": " Proximo ",
                "previous": " Anterior  "
            }
        },
    });

    var rows = document.querySelectorAll("#myTable tbody tr");
    rows.forEach(function(row) {
        row.addEventListener('click', function() {
            $("#offcanvas_grafico").offcanvas('show');

            if (myChart) {
                myChart.destroy();
            }

            var employeeId = row.cells[0].innerText;
            var totals = Array.from(row.cells).slice(1).map(cell => parseFloat(cell.innerText));

            var labels = <?php echo json_encode($dateRange); ?>;
            console.log(labels);
            var data = {
                labels: labels,
                datasets: [{
                    label: 'Total',
                    backgroundColor: "#377dff",
                    hoverBackgroundColor: "#377dff",
                    borderColor: "#377dff",
                    maxBarThickness: "10",
                    data: totals
                }]
            };

            var options = {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            var ctx = document.getElementById('myChart').getContext('2d');

            myChart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: options
            });
        });
    });
</script>
<script>
    var data = <?php echo json_encode($counts); ?>;

    var chartData = {
        labels: [],
        datasets: [{
                label: 'Single',
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: []
            },
            {
                label: 'Full',
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                data: []
            }
        ]
    };

    <?php
    foreach ($dateRange as $date) {
        $dateStr = $date->format('Y-m-d');
        echo "chartData.labels.push('$dateStr');";
        foreach ($counts as $storeId => $storeData) {
            $singleCount = isset($storeData['single'][$dateStr]) ? $storeData['single'][$dateStr] : 0;
            $fullCount = isset($storeData['full'][$dateStr]) ? $storeData['full'][$dateStr] : 0;
            echo "chartData.datasets[0].data.push($singleCount);";
            echo "chartData.datasets[1].data.push($fullCount);";
        }
    }
    ?>

    var ctx = document.getElementById('myChart').getContext('2d');
    if (window.myChart instanceof Chart) {
        window.myChart.destroy();
    }

    var myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>