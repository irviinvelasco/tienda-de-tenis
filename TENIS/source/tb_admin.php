<?php
require 'config.php';
require './Configuracion.php';

$correo = $_SESSION['correo'];
$db = new Database();
$con = $db->conectar();

// Consultar el rol del usuario en la base de datos
$sql = "SELECT `Rol` FROM `cuentas` WHERE Correo = :correo";
$stmt = $con->prepare($sql);
$stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
$stmt->execute();

$resultado = $stmt->fetch(PDO::FETCH_ASSOC);



// Obtener todos los usuarios de la tabla `cuentas`
$sql = $con->prepare("SELECT * FROM cuentas");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

?>