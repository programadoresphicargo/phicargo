<?php
// Incluir la clase TCPDF
require_once('../../TCPDF-main/tcpdf.php');

// Crear nueva instancia de TCPDF
$pdf = new TCPDF();
$pdf->SetTitle('PDF desde contenido PHP');
$pdf->AddPage();
$pdf->SetFont('helvetica', 'A', 8);
ob_start();

// Incluir el contenido PHP
$opcion_select = 'semana';
echo '<h1>Informe de seguimiento</h1>' . '<br>';
echo $_GET['fechaInicial'] . ' al ' . $_GET['fechaFinal'];
require_once('../informes/saldos_generales.php');
require_once('../informes/ingresos.php');
require_once('../informes/pagos.php');
require_once('../informes/viajes_ejecutivos.php');
require_once('../informes/maniobras.php');
require_once('../informes/tipo_armado.php');
require_once('../informes/mantenimiento.php');

// Capturar la salida generada por 'contenido.php'
$html = ob_get_clean();

// Eliminar JavaScript del HTML
$html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

// Agregar contenido HTML al PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Nombre del archivo de salida
$filename = 'pdf_desde_contenido_php.pdf';

// Salida del PDF como un archivo (puedes cambiar 'D' a 'I' para abrir en el navegador)
$pdf->Output($filename, 'D');
