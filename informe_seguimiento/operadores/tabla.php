<?php

require_once('../../odoo/odoo-conexion.php');

$opcion = $_POST['opcion'];
$startDate = $_POST['fechaInicio'];
$endDate = $_POST['fechaFin'];

$kwargs = ['fields' => ['id', 'amount_total', 'employee_id', 'date_order', 'vehicle_id', 'store_id', 'travel_id'], 'order' => 'id asc'];
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
file_put_contents('ahs3.json', $data);
$dataArray = json_decode($data, true);
$totalsByEmployeeAndDate = [];

foreach ($dataArray as $item) {
    $employeeId = $item[$opcion][1];
    $date = date('Y-m-d', strtotime($item['date_order']));

    if (!isset($totalsByEmployeeAndDate[$employeeId][$date])) {
        $totalsByEmployeeAndDate[$employeeId][$date] = 0;
    }
    $totalsByEmployeeAndDate[$employeeId][$date] += $item['amount_total'];
}

$dateRange = [];
$currentDate = $startDate;
while ($currentDate <= $endDate) {
    $dateRange[] = $currentDate;
    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}

foreach ($totalsByEmployeeAndDate as &$employeeData) {
    $employeeData = array_merge(array_fill_keys($dateRange, 0), $employeeData);
}

$tableHTML = '<table id="myTable" class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table table-sm table-hover">';
$tableHTML .= '<thead class="thead-light">';
$tableHTML .= '<tr class="table-text-end">';
$tableHTML .= '<th>Operador</th>';

foreach ($dateRange as $date) {
    $tableHTML .= "<th>$date</th>";
}
$tableHTML .= '</tr>';
$tableHTML .= '</thead>';
$tableHTML .= '<tbody>';

$columnTotals = array_fill(0, count($dateRange), 0);

foreach ($totalsByEmployeeAndDate as $employeeId => $totalsByDate) {
    $tableHTML .= '<tr>';
    $tableHTML .= "<td><p><span class='text-dark fw-semibold'>$employeeId</span></th>";
    $colIndex = 0;
    foreach ($totalsByDate as $total) {
        $totalFormatted = number_format($total, 2, '.', ',');
        $tableHTML .= "<td class='table-text-end'>$totalFormatted</td>";
        $columnTotals[$colIndex] += $total;
        $colIndex++;
    }
    $tableHTML .= '</tr>';
}

$tableHTML .= '</tbody>';

$tableHTML .= '<tfoot>';
$tableHTML .= '<tr>';
$tableHTML .= '<td class="fw-bold">Total</td>';
foreach ($columnTotals as $total) {
    $totalFormatted = number_format($total, 2, '.', ',');
    $tableHTML .= "<td class='table-text-end'>$totalFormatted</td>";
}
$tableHTML .= '</tr>';
$tableHTML .= '</tfoot>';

$tableHTML .= '</table>';

echo $tableHTML;
?>

<script>
    var myChart;
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
        "lengthMenu": [
            [30, 40, 50, -1],
            [30, 40, 50, "All"]
        ]
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