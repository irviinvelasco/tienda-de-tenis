<?php

	# Incluyendo librerias necesarias #
    require "fpdf/fpdf.php";
    require 'Configuracion.php';
    require 'source/config.php';
    $correo = $_SESSION['correo']; // Obtener el correo electrónico de la sesión
    $db = new Database();
    $con = $db->conectar();
     
    //$sql = "SELECT descuento FROM mis_productos WHERE Correo = :correo";

    $sql = "SELECT compras.id_transaccion, compras.fecha, detalle_compra.id_compra, 
    detalle_compra.nombre, detalle_compra.precio, detalle_compra.cantidad, compras.total, mis_productos.descuento, mis_productos.precio
    FROM compras, detalle_compra, mis_productos
    WHERE detalle_compra.id_compra = compras.id AND detalle_compra.id_producto=mis_productos.id ORDER BY compras.fecha DESC";


    $stmt = $con->prepare($sql);
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($resultado)) {
        $primeraFila = $resultado[0];
        $id_transaccion = $primeraFila['id_transaccion'];
        $fecha = $primeraFila['fecha'];
    
        // Resto del código...
    //--------------------------------------------------

    $pdf = new fpdf('P','mm',array(80,200));
    $pdf->SetMargins(4,10,4);
    $pdf->AddPage();
    # imagen de la empresa los mays
    $pdf->Image('img/image.png', 0, 0, 0, 15, 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
    $pdf->Image('img/image1.png',63.4, 0.1, 0, 15, 'PNG', '', 'L', false, 300, '', false, false, 0, false, false, false);
    
    $pdf->Ln(10);
    # Encabezado y datos de la empresa #
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(26, 96, 220 ); // Establecer color en rojo (RGB: 255, 0, 0)
    $pdf->MultiCell(0, 5, utf8_decode(strtoupper("SNNKRS Los MayChitos")), 0, 'C', false);
    
    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0,5,utf8_decode("RFC:VEAI001018LW9"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Blvd. Felipe Ángeles Km. 84.5, Venta Prieta, 42083 Pachuca de Soto, Hgo."),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Teléfono: 7712299583"),0,'C',false);
    $pdf->MultiCell(0,5,utf8_decode("Email: snkrsPachuca@gmail.com"),0,'C',false);

    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    // informacion de la empresa y cajero que lo ateinde 
    $pdf->MultiCell(0, 5, utf8_decode("Fecha de Compra: ". $fecha), 0, 'C', false); // Fecha y hora actual

    $pdf->SetFont('Arial','B',9);
    $pdf->MultiCell(0,5,utf8_decode("Agradecemos tu compra en línea"),0,'C',false);
    $pdf->SetFont('Arial','B',8);
    
    $pdf->MultiCell(0,5,utf8_decode(strtoupper("Ticket: " . $id_transaccion )),0,'C',false);
    $pdf->SetFont('Arial','',9);
    }
    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("------------------------------------------------------"),0,0,'C');
    $pdf->Ln(5);

    // datos del cliente de la base de datos 
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(0,5,utf8_decode("Datos del Cliente"),0,0,'C');
    $pdf->Ln(5);
    $pdf->SetFont('Arial','',9);
    
    $sql0 = "SELECT Nombre, Correo FROM cuentas, compras WHERE Correo = '$correo'";
    $qry = $con->prepare($sql0);
    $qry->execute();
    
    $ress = $qry->fetch(PDO::FETCH_ASSOC);
    $Nombre = $ress['Nombre'];
    $Correo = $ress['Correo'];
    
    $pdf->MultiCell(0, 5, utf8_decode("Nombre: " . $Nombre), 0, 'C');
    $pdf->MultiCell(0, 5, utf8_decode("Correo: " . $Correo), 0, 'C');
    
        
    
    $pdf->Ln(1);
    $pdf->Cell(0,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');
    $pdf->Ln(3);

    # Tabla de productos #
    $pdf->Cell(10, 5, utf8_decode("Cant."), 0, 0, 'C');
    $pdf->Cell(19, 5, utf8_decode("Precio"), 0, 0, 'C');
    $pdf->Cell(15, 5, utf8_decode("Desc."), 0, 0, 'C');
    $pdf->Cell(28, 5, utf8_decode("Total"), 0, 0, 'C');

    $pdf->Ln(3);
    $pdf->Cell(72, 5, utf8_decode("-------------------------------------------------------------------"), 0, 0, 'C');
    $pdf->Ln(5);

    /*----------  Detalles de la tabla  ----------*/
    foreach ($resultado as $fila) {
        // Obtener los datos de cada fila
        $id_transaccion_fila = $fila['id_transaccion'];
    
        // Comparar con el id_transaccion deseado
        if ($id_transaccion_fila == $id_transaccion) {
            $id_compra = $fila['id_compra'];
            $nombreP = $fila['nombre'];
            $precio = $fila['precio'];
            $desc = $fila['descuento'];
            $cantidad = $fila['cantidad'];
            $total = $fila['total'];
        
            // Generar la tabla y los detalles de los productos
            $pdf->MultiCell(0, 4, utf8_decode($nombreP), 0, 'T', false);
            $pdf->Cell(10, 4, utf8_decode($cantidad), 0, 0, 'C');
            if ($desc > 0) {
                $precio_desc = $precio - (($precio * $desc) / 100);
                $subt = ($precio_desc*$cantidad);
                $pdf->Cell(19, 4, utf8_decode("$" . number_format($precio,2,'.',',')), 0, 0, 'C');
                $pdf->Cell(19, 4, utf8_decode($desc . "%"), 0, 0, 'C');
                $pdf->Cell(28, 4, utf8_decode("$" . number_format($subt,2,'.',',')), 0, 0, 'C');
            } else {
                $subt = ($precio*$cantidad);
                $pdf->Cell(19, 4, utf8_decode("$" . $precio), 0, 0, 'C');
                $pdf->Cell(19, 4, utf8_decode("S/D"), 0, 0, 'C');
                $pdf->Cell(28, 4, utf8_decode("$" . number_format($subt,2,'.',',')), 0, 0, 'C');
            }
            $pdf->Ln(5);
        }
    }
    
    /*----------  Fin Detalles de la tabla  ----------*/




    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');

        $pdf->Ln(5);

    $pdf->Cell(32,5,utf8_decode("TOTAL"),0,0,'L');
    $pdf->Cell(32,5,utf8_decode("$".number_format($total,2,'.',',')." MX"),0,0,'R');
    $pdf->Ln(5);
    $pdf->Cell(72,5,utf8_decode("-------------------------------------------------------------------"),0,0,'C');


    $pdf->Ln(5);
    $pdf->MultiCell(0,5,utf8_decode("*** Precios de productos incluyen impuestos. Para poder realizar un reclamo o devolución debe de presentar este ticket ***"),0,'C',false);
    $pdf->Ln(4);

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,7,utf8_decode("Gracias por su compra"),'',0,'C');


    # Nombre del archivo PDF #
    $pdf->Output("I","Ticket(". $fecha .").pdf",true);