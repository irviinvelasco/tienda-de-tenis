<?php
require './Configuracion.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$valorSeleccionado = isset($_GET['valor']) ? $_GET['valor'] : '';

$lista_carrito = array();

if ($productos != null) {
  foreach ($productos as $clave => $cantidad) {
    $sql = $con->prepare("SELECT id, Imagen, nombre, precio, descuento, $cantidad as cantidad, $cantidad as cantidad_seleccionada FROM mis_productos WHERE id = ? AND activo = 1");
    $sql->execute([$clave]);
    $producto = $sql->fetch(PDO::FETCH_ASSOC);
    $producto['cantidad_seleccionada'] = $cantidad;
    $lista_carrito[] = $producto;
  }
}else{
    header("Location: tenis.php");
    exit;
}


?>