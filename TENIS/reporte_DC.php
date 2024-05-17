<?php
require 'fpdf/fpdf.php';
require 'Configuracion.php';

// Obtén los datos de la base de datos
$db = new Database();
$con = $db->conectar();

$sql = "SELECT * FROM detalle_compra";
$resultado = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Crea una nueva instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16); // Establece la fuente, el estilo y el tamaño del texto
$pdf->Cell(0, 5, 'Reporte de Detalles de Compra', 0, 1, 'C'); // Crea una celda con el título, ajustando el ancho y la altura según sea necesario, y alinea el contenido al centro
$pdf->Ln(10); 

// Define el estilo de fuente y tamaño para el encabezado
$pdf->SetFont('Arial', '', 10);

// Agrega el encabezado de la tabla
$pdf->Cell(10, 10, 'ID', 1, 0, 'C'); // Alinea el contenido al centro
$pdf->Cell(30, 10, 'ID_Compra', 1, 0, 'C'); // Alinea el contenido al centro
$pdf->Cell(30, 10, 'ID_Producto', 1, 0, 'C'); // Alinea el contenido al centro
$pdf->Cell(60, 10, 'Nombre', 1, 0, 'C'); // Alinea el contenido al centro
$pdf->Cell(30, 10, 'Precio', 1, 0, 'C'); // Alinea el contenido al centro
$pdf->Cell(30, 10, 'Cantidad', 1, 0, 'C'); // Alinea el contenido al centro
$pdf->Ln();

// Define el estilo de fuente y tamaño para el contenido
$pdf->SetFont('Arial', '', 8);

// Agrega los datos de la tabla
foreach ($resultado as $fila) {
    $pdf->Cell(10, 10, $fila['id'], 1, 0,'C'); // Alinea el contenido al centro
    $pdf->Cell(30, 10, $fila['id_compra'], 1, 0,'C'); // Alinea el contenido al centro
    $pdf->Cell(30, 10, $fila['id_producto'], 1, 0,'C'); // Alinea el contenido al centro
    $pdf->Cell(60, 10, $fila['nombre'], 1, 0,'C'); // Utiliza MultiCell en lugar de Cell para permitir saltos de línea y alinea el contenido al centro
    $pdf->Cell(30, 10, $fila['precio'], 1, 0,'C'); // Alinea el contenido al centro
    $pdf->Cell(30, 10, $fila['cantidad'], 1, 0,'C'); // Alinea el contenido al centro
    $pdf->Ln();
}

// Genera el archivo PDF
$pdf->Output('reporte.pdf', 'I');
exit();
?>
