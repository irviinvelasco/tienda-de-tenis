<?php
require 'fpdf/fpdf.php';
require 'Configuracion.php';

// Clase personalizada que hereda de FPDF
class CustomFPDF extends FPDF {
    private $cellPadding; // Espaciado interno de las celdas
    
    // Método para establecer el espaciado interno de las celdas
    public function SetCellPadding($padding) {
        $this->cellPadding = $padding;
    }
    
    // Método para obtener el espaciado interno de las celdas
    public function GetCellPadding() {
        return $this->cellPadding;
    }
    
    // Método para dibujar una celda con espaciado interno
    public function CellWithPadding($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '') {
        $padding = $this->GetCellPadding();
        
        if ($padding > 0) {
            $this->Cell($w, $h + 2 * $padding, '', $border, $ln, '', $fill);
            $this->SetX($this->GetX() - $w);
            $this->Cell($w, $h, $txt, 0, $ln, $align, $fill, $link);
            $this->SetX($this->GetX() - $w);
            $this->Cell($w, $h + 2 * $padding, '', $border, $ln, '', $fill);
        } else {
            $this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
        }
    }
}


// Obtén los datos de la base de datos
$db = new Database();
$con = $db->conectar();

$sql = "SELECT * FROM mis_productos";
$resultado = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Crea una nueva instancia de CustomFPDF
$pdf = new CustomFPDF('L');
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 16); // Establece la fuente, el estilo y el tamaño del texto
$pdf->Cell(0, 5, 'Reporte de Mis Productos', 0, 1, 'C'); // Crea una celda con el título, ajustando el ancho y la altura según sea necesario, y alinea el contenido al centro
$pdf->Ln(10);

// Define el estilo de fuente y tamaño para el encabezado
$pdf->SetFont('Arial', '', 10);

// Configura el color de relleno de los cuadros en blanco
$pdf->SetFillColor(255, 255, 255); // Blanco

// Agrega el encabezado de la tabla
$pdf->CellWithPadding(6, 12, 'ID', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(37, 12, 'Nombre', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(120, 12, 'Descripcion', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(23, 12, 'Precio', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(23, 12, 'Descuento', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(23, 12, 'Cantidad', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(23, 12, 'ID_Categoria', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco
$pdf->CellWithPadding(23, 12, 'Activo', 1, 0, 'C', true); // Alinea el contenido al centro y establece el relleno en blanco

$pdf->Ln();

// Define el estilo de fuente y tamaño para el contenido
$pdf->SetFont('Arial', '', 7.5);

// Establece el espaciado interno de las celdas 
$pdf->SetCellPadding(2);

// Agrega los datos de la tabla
foreach ($resultado as $fila) {
    $pdf->CellWithPadding(6, 8, $fila['id'], 1, 0, 'C'); // Alinea el contenido al centro
    $pdf->CellWithPadding(37, 8, $fila['nombre'], 1, 0, 'B'); // Alinea el contenido al centro
    
    $maxCaracteres = 85; // Longitud máxima deseada para la descripción
    
    $descripcion = $fila['descripcion']; // Obtén el texto de la descripción
    
    if (strlen($descripcion) > $maxCaracteres) {
        $descripcion = substr($descripcion, 0, $maxCaracteres) . '...'; // Trunca el texto y agrega puntos suspensivos
    }
    
    $pdf->SetFont('Arial', '', 8);
    $pdf->CellWithPadding(120, 8, $descripcion, 1, 0, 'B'); // Alinea el contenido al centro
    $pdf->SetFont('Arial', '', 7.5);
    
    $pdf->CellWithPadding(23, 8,"$" .$fila['precio'], 1, 0, 'C'); // Alinea el contenido al centro
    $pdf->CellWithPadding(23, 8, $fila['descuento']."%", 1, 0, 'C'); // Alinea el contenido al centro
    $pdf->CellWithPadding(23, 8, $fila['cantidad'], 1, 0, 'C'); // Alinea el contenido al centro
    $pdf->CellWithPadding(23, 8, $fila['id_categoria'], 1, 0, 'C'); // Alinea el contenido al centro
    $pdf->CellWithPadding(23, 8, $fila['activo'], 1, 0, 'C'); // Alinea el contenido al centro
    $pdf->Ln();
}

// Genera el archivo PDF
$pdf->Output('reporte.pdf', 'I');
exit();
?>
