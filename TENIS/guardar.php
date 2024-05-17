<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);
$nombre = $_POST['Nc'];
$correo = $_POST['user-email'];
$pass = $_POST['password'];
$date = date('Y-m-d', strtotime($_POST['date']));
$fecha_array = explode('/', $date);
$fecha_nueva = implode('-', array_reverse($fecha_array));


// Preparar la consulta INSERT
$sql = "SELECT * FROM cuentas WHERE correo = '$correo'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    echo "El correo ya está registrado";
} else {
    // Insertar los datos en la tabla
    $sql = "INSERT INTO cuentas (Nombre, Correo, Password, Fecha)
    VALUES ('$nombre', '$correo', '$pass', '$fecha_nueva')";

    if ($conn->query($sql) === TRUE) {
         echo "<script>alert('Registro exitoso.');</script>";

        header("Location: index.php"); // Redirigir al usuario a la página de inicio
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>