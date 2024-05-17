<?php
require 'config.php';
require '../Configuracion.php';
$correo = $_SESSION['correo'];
$db = new Database();
$con = $db->conectar();

$sql = "SELECT Correo FROM cuentas WHERE Correo = :correo";
$stmt = $con->prepare($sql);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();

// Obtener el resultado de la primera consulta
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT id FROM cuentas WHERE Correo = :correo";
$stmt = $con->prepare($sql);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();

// Obtener el resultado de la segunda consulta
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$id_cliente = $result['id'];


$json = file_get_contents('php://input');
$datos = json_decode($json, true);

if (is_array($datos)) {
    // Aquí se están obteniendo diferentes valores del JSON decodificado
    $id_transaccion = $datos['detalles']['id'];
    $monto = $datos['detalles']['purchase_units'][0]['amount']['value'];
    $status = $datos['detalles']['status'];
    $fecha = $datos['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    
    
    // Establecer la zona horaria a Ciudad de México
    date_default_timezone_set('America/Mexico_City');
    
    // Convertir la fecha a la zona horaria de Ciudad de México
    $fecha_convertida = new DateTime($fecha_nueva, new DateTimeZone('UTC'));
    $fecha_convertida->setTimezone(new DateTimeZone('America/Mexico_City'));
    $fecha_convertida->sub(new DateInterval('PT3H'));
    $fecha_nueva_mexico = $fecha_convertida->format('Y-m-d H:i:s');
    

    $sql = $con->prepare("INSERT INTO compras (id_transaccion, fecha, status, email, id_cliente, total) VALUES (?, ?, ?, ?, ?, ?)");
    $sql->execute([$id_transaccion, $fecha_nueva_mexico, $status, $correo, $id_cliente, $monto]);
    $id_compra = $con->lastInsertId();
    
    if ($id_compra > 0) {
        $productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
    
        if ($productos != null) {
            $sql_insert = $con->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?, ?, ?, ?, ?)");
    
            foreach ($productos as $clave => $cantidad) {
                $sql_producto = $con->prepare("SELECT nombre, precio, descuento, cantidad FROM mis_productos WHERE id = ? AND activo = 1");
                $sql_producto->execute([$clave]);
                $producto = $sql_producto->fetch(PDO::FETCH_ASSOC);
    
                $precio = $producto['precio'];
                $descuento = $producto['descuento'];
                $precio_desc = $precio - (($precio * $descuento) / 100);
    
                $sql_insert->execute([$id_compra, $clave, $producto['nombre'], $precio_desc, $cantidad]);
    
                $nueva_cantidad = $producto['cantidad'] - $cantidad;
    
                $sql_act = $con->prepare("UPDATE mis_productos SET cantidad = ? WHERE id = ?");
                $sql_act->execute([$nueva_cantidad, $clave]);
            }
        }
    
        unset($_SESSION['carrito']);
    }
}
?>    