<?php

//DB details
class Database{
   private $dbHost = 'localhost';
   private $dbUsername = 'root';
   private $dbPassword = '';
   private $dbName = 'tienda';

   function conectar(){
    try{
        $conexion = "mysql:host=" . $this->dbHost . "; dbname=" . $this->dbName . ";";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        $pdo = new PDO($conexion, $this->dbUsername, $this->dbPassword, $options);

        return $pdo;
    } catch(PDOException $e){
        echo 'Error de conexion: ' . $e->getMessage();
        exit; 
    }
   }
}

// Verificar si existe un usuario con el correo y contraseña proporcionados
if (isset($_GET['Correo']) && isset($_GET['Pass'])) {
    $correo = $_GET["Correo"];
    $contra = $_GET["Pass"];

    // Conexión a la base de datos
    $db = new Database();
    $conn = $db->conectar();

    $query = "SELECT * FROM cuentas WHERE Correo = :correo AND Password = :contra";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contra', $contra);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // El usuario existe
        $_SESSION['correo'] = $correo; // Establecer el correo electrónico en la variable de sesión
        header("Location: tenis.php"); // Redirigir al usuario a la página de inicio
        exit;
    } else {
        // El usuario no existe o los datos son incorrectos
        echo "<script>alert('Correo o contraseña incorrectos');</script>";
    }
}


?>
