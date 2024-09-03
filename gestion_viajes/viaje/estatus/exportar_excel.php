<?php
require '../../../vendor/autoload.php';
require '../../../mysql/conexion.php';
$cn = conectar();

$id_viaje = $_GET['id_viaje'];

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$sql = "SELECT * FROM reportes_estatus_viajes inner join ubicaciones_estatus on ubicaciones_estatus.id_ubicacion = reportes_estatus_viajes.id_ubicacion where id_viaje = $id_viaje";
$result = $cn->query($sql);

if ($result->num_rows > 0) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $customHeaders = [
        'nombre_columna1' => 'Encabezado 1',
        'nombre_columna2' => 'Encabezado 2',
        'nombre_columna3' => 'Encabezado 3',
    ];

    $columns = array();
    $columnLetter = 'A';

    $fieldinfo = $result->fetch_fields();
    foreach ($fieldinfo as $val) {
        $columnName = $val->name;

        $header = isset($customHeaders[$columnName]) ? $customHeaders[$columnName] : $columnName;
        $sheet->setCellValue($columnLetter . '1', $header);
        $columns[] = $columnLetter;
        $columnLetter++;
    }

    $rowNumber = 2;
    while ($row = $result->fetch_assoc()) {
        $columnNumber = 0;
        foreach ($row as $data) {
            $sheet->setCellValue($columns[$columnNumber] . $rowNumber, $data);
            $columnNumber++;
        }
        $rowNumber++;
    }

    $writer = new Xlsx($spreadsheet);
    $filename = 'historial_' . $id_viaje . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
} else {
    echo "0 resultados";
}
$conn->close();
