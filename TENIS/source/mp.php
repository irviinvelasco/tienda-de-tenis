<?php
require './Configuracion.php';
$db = new Database();
$con = $db->conectar();
$sql = "SELECT `Rol` FROM `cuentas` WHERE Correo = :correo";
$stmt = $con->prepare($sql);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();

$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario tiene privilegios de administrador


// Obtener todos los productos de la tabla `mis_productos`
$sql = $con->prepare("SELECT * FROM mis_productos");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario de actualización
// Procesar el formulario de actualización
if (isset($_POST['actualizar'])) {
    $producto_id = $_POST['producto_id'];
    $nuevo_nombre = $_POST['nuevo_nombre'];
    $nueva_descripcion = $_POST['nueva_descripcion'];
    $nuevo_precio = $_POST['nuevo_precio'];
    $nuevo_descuento = $_POST['nuevo_descuento'];
    $nueva_cantidad = $_POST['nueva_cantidad'];
    $nuevo_categoria = $_POST['nuevo_categoria'];
    $nuevo_activo = $_POST['nuevo_activo'];

    // Obtener los datos actuales del producto
    $sql = "SELECT * FROM mis_productos WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
    $stmt->execute();
    $producto_actual = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar y actualizar los campos modificados
    if (!empty($nuevo_nombre)) {
        $producto_actual['nombre'] = $nuevo_nombre;
    }
    if (!empty($nueva_descripcion)) {
        $producto_actual['descripcion'] = $nueva_descripcion;
    }
    if (!empty($nuevo_precio)) {
        $producto_actual['precio'] = $nuevo_precio;
    }
    if (!empty($nuevo_descuento)) {
        $producto_actual['descuento'] = $nuevo_descuento;
    }
    if (!empty($nueva_cantidad)) {
        $producto_actual['cantidad'] = $nueva_cantidad;
    }
    if (!empty($nuevo_categoria)) {
        $producto_actual['id_categoria'] = $nuevo_categoria;
    }
    if (!empty($nuevo_activo)) {
        $producto_actual['activo'] = $nuevo_activo;
    }

    // Actualizar los datos del producto en la base de datos
    $sql = "UPDATE mis_productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, descuento = :descuento, cantidad = :cantidad, id_categoria = :id_categoria, activo = :activo WHERE id = :id";
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':nombre', $producto_actual['nombre'], PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $producto_actual['descripcion'], PDO::PARAM_STR);
    $stmt->bindParam(':precio', $producto_actual['precio'], PDO::PARAM_STR);
    $stmt->bindParam(':descuento', $producto_actual['descuento'], PDO::PARAM_STR);
    $stmt->bindParam(':cantidad', $producto_actual['cantidad'], PDO::PARAM_INT);
    $stmt->bindParam(':id_categoria', $producto_actual['id_categoria'], PDO::PARAM_INT);
    $stmt->bindParam(':activo', $producto_actual['activo'], PDO::PARAM_STR);
    $stmt->bindParam(':id', $producto_id, PDO::PARAM_INT);
    $stmt->execute();

    // Redirigir a la página de productos actualizada o mostrar un mensaje de éxito
    header('Location: mis_productos.php'); // Cambia "mis_productos.php" por la página correspondiente
    exit();
}

?>
