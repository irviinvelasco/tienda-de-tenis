<?php
session_start();

require 'Configuracion.php';
$db = new Database();
$con = $db->conectar();

$correo = $_SESSION['correo'];

$sql = "SELECT `Rol` FROM `cuentas` WHERE Correo = :correo";
$stmt = $con->prepare($sql);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();
$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

if ($resultado['Rol'] !== 'administrador') {
    // El usuario no tiene privilegios de administrador, redirigir o mostrar mensaje de acceso denegado
    header('Location: acceso_denegado.php'); // Cambia "acceso_denegado.php" por la página de acceso denegado correspondiente
    exit();
}

if (isset($_POST['vaciarTabla'])) {
    // Vaciar la tabla de detalles de compra
    $sql = "TRUNCATE TABLE detalle_compra";
    $con->exec($sql);

    // Redirigir a la página actual
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$sql = "SELECT * FROM detalle_compra";
$resultado = $con->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>