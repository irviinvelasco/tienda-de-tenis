<?php
require 'config.php';
require './Configuracion.php';
$correo = $_SESSION['correo']; // Obtener el correo electrónico de la sesión
$db = new Database();
$con = $db->conectar();
$sql = $con->prepare("SELECT id, Imagen, nombre, precio FROM mis_productos WHERE activo=1 ORDER BY precio ASC");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
if ($sql->rowCount() > 0) {
    $sql1 = $con->prepare("SELECT nombre, rol FROM cuentas WHERE Correo = :correo");
    $sql1->execute(['correo' => $correo]);
    $row = $sql1->fetch(PDO::FETCH_ASSOC);
    $nombre = $row['nombre'];
    $rol = $row['rol'];
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($id == '' || $token == '') {
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);
    if ($token == $token_tmp) {

        $sql = $con->prepare("SELECT count(id) FROM mis_productos WHERE id=? AND activo=1");
        $sql->execute([$id]);
        if ($sql->fetchColumn() > 0) {

            $sql = $con->prepare("SELECT Imagen, nombre, descripcion, precio, descuento FROM mis_productos WHERE id=? AND activo=1 LIMIT 1");
            $sql->execute([$id]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $Imagen = $row['Imagen'];
            $nombre = $row['nombre'];
            $descripcion = $row['descripcion'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);
        }
    } else {
        echo 'Error al procesar la petición';
        exit;
    }
}
?>