<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DataTables con SearchPanes</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
    <!-- SearchPanes CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/2.3.1/css/searchPanes.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/2.0.2/css/select.dataTables.css">
</head>

<body>
    <table id="example" class="display table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>v</td>
                <td>System Aeeerchitect</td>
                <td>Edinbureegh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,800</td>
            </tr>
            <tr>
                <td>v1</td>
                <td>Systeem Architect</td>
                <td>Edinbeeurgh</td>
                <td>61</td>
                <td>2011/04/25</td>
                <td>$320,ee800</td>
            </tr>
            <tr>
                <td>v2</td>
                <td>Systeeem Architect</td>
                <td>Edeeeienburgh</td>
                <td>61</td>
                <td>20eee11/04/25</td>
                <td>$32eeee0,800</td>
            </tr>
            <!-- More rows go here -->
        </tbody>
    </table>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <!-- SearchPanes JS -->
    <script src="https://cdn.datatables.net/searchpanes/2.3.1/js/dataTables.searchPanes.js"></script>
    <script src="https://cdn.datatables.net/searchpanes/2.3.1/js/searchPanes.dataTables.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.2/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.2/js/select.dataTables.js"></script>


    <script>
        $(document).ready(function() {
            new DataTable('#example', {
                layout: {
                    top1: {
                        searchPanes: {
                            layout: 'columns-6'
                        }
                    }
                },
                columnDefs: [{
                    searchPanes: {
                        show: true
                    },
                    targets: [0, 1, 2, 3]
                }],
                rowGroup: {
                    dataSrc: [0],
                },
            });
        });
    </script>
</body>

</html>