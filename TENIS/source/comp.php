<?php
require 'Configuracion.php';
$db = new Database();
$con = $db->conectar();

if (isset($_POST['vaciarTabla'])) {
    // Vaciar la tabla de compras
    $sql = "TRUNCATE TABLE compras";
    $con->exec($sql);

    // Redirigir a la página actual
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

$sql = $con->prepare("SELECT * FROM compras");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);
?>