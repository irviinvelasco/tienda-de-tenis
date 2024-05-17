<?php
session_start(); // Iniciar la sesión

// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";

// Conexión a la base de datos
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar si existe un usuario con el correo y contraseña proporcionados
if (isset($_GET['Correo']) && isset($_GET['Pass'])) {
    $correo = $_GET["Correo"];
    $contra = $_GET["Pass"];

    $query = "SELECT * FROM cuentas WHERE Correo = '$correo' AND Password = '$contra'";
    $resultado = mysqli_query($conn, $query);

    if (mysqli_num_rows($resultado) > 0) {
        // El usuario existe
        $_SESSION['correo'] = $correo; // Establecer el correo electrónico en la variable de sesión
        header("Location: tenis.php"); // Redirigir al usuario a la página de inicio
        exit;
    } else {
        // El usuario no existe o los datos son incorrectos
        echo "<script>alert('Correo o contraseña incorrectos');</script>";
    }
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>



<!DOCTYPE html>
<html lang="es" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>TIENDA DE TENIS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="source/app.css">
</head>
<body>
       <header class="header">
		<div class="container">
			<div class="logo">
                <img src="img/logo_.png" alt="" class="mx-auto d-block logo" width="174" height="100" >			</div>
			<nav class="menu">
                <div class="btn-menu">
				<a style="color: white; cursor: pointer;" onclick="inicio()">Inicio</a>
				<a style="color: white; cursor: pointer;" onclick="nosotros()">Nosotros</a>
				<a style="color: white; cursor: pointer;" onclick="contacto()">Contacto</a>
		</div>
			</nav>
		</div>
	</header>
    <br>
	<center>
                <section id="c0" style="display: block"><br><br>
            <h1 class="zapatilla img-fluid mx-auto d-block mt-5">BIENVENIDO</h1>
            <img src="img/IMG1.png" alt="" class="zapatilla img-fluid mx-auto d-block mt-2" width="700" >
            <input type="button" class="btn btn-outline-light btn-lg rounded-pill mt-2 pr-5 pl-5" value="ENTRAR" onclick=" entrar()">  
                    
                </section></center>
    <br><br><br>
        <section id="c1" style="display: none">
        <center> 
        <div class="form-body" id="div01">
                <img src="img/219983.png" alt="user-login" width="150px" style="margin: 20px auto">
            <p class="text">Iniciar Sesión</p>
            
        <form class="login-form" action="" method="get">
            <input type="email" placeholder="Correo" id="user-email1" name="Correo" required>
            <input type="password" placeholder="Contraseña" name="Pass" required>
            <input type="submit" value="Ingresar" id="Is">
            <input type="button" value="Registrarme" id="reg" onclick="ocultar()"/>            
            
        </form>
        </div>
        </center>
        </section>
            
        <section id="c2" style="display: none">
        <center> 
        <div class="form-body" id="div02" >
            <img src="img/219983.png" alt="user-login" width="150px" style="margin: 20px auto">  
            <p class="text" >Registro</p>
        <form class="reg-form" method="post" action="guardar.php">
            <input type="text" placeholder="Nombre Completo" id="Nc" name="Nc" maxlength="30" required> <br>
            <input type="email" placeholder="Correo" id="user-email" name="user-email" required>
            <input type="password" placeholder="Contraseña" id="password" name="password" onkeyup="validarPassword()" maxlength="15" required>
            <p id="password-error" style="color: white"></p>
            <input type="date" id="fecha_nacimiento" name="date" required> <br>
            <input type="submit" value="Guardar Datos" id="regi"> <br>
        </form>
        </div>
        </center>
        </section> 
    
    <section id="c3" style="display: none">
        <center> 
        <div class="form-body" id="div03" >
            <img src="img/219983.png" alt="user-login" width="150px" style="margin: 20px auto">                
            <p class="text" >Nosotros</p>
                <p style="color:white">¡Bienvenidos! Somos Irvin Velasco y José Sánchez, estudiantes de la materia de Programación Web del Instituto Tecnológico de Pachuca y nos complace presentarles nuestra página de venta de tenis para hombres, mujeres y niños. Nuestra pasión por la tecnología y la moda nos llevó a desarrollar esta plataforma con la finalidad de ofrecer una amplia variedad de estilos de tenis para todos los gustos y edades. Nos esforzamos por proporcionar un servicio de alta calidad y una experiencia de compra fácil y satisfactoria para nuestros clientes. Agradecemos su visita a nuestra página y esperamos que encuentre los tenis ideales para usted o su familia. ¡Gracias por elegirnos! </p>
        </div>
        </center>
        </section>
            
        <section id="c4" style="display: none">
        <center> 
        <div class="form-body" id="div04" >
        <img src="img/219983.png" alt="user-login" width="150px" style="margin: 20px auto">               
        <br>                <img src="img/insta.png" width="200px"> <p></p>
            
            <a href="https://www.instagram.com/irviinvelasco" style="color: white"><img src="img/logo_ins.png" width="50px"> IRVIN VELASCO </a>
            
            <a href="https://www.instagram.com/jose.sanchezmx/" style="color: white"><img src="img/logo_ins.png" width="50px"> JOSÉ SÁNCHEZ </a>
            <br>
            <img src="img/face.png" width="200px"> <p></p>
            <a href="https://www.facebook.com/IrvinVelascoA/" style="color: white"><img src="img/logo_fb.png" width="50px"> IRVIN VELASCO </a>
            <a href="https://www.facebook.com/Jose.montiel20" style="color: white"><img src="img/logo_fb.png" width="50px"> JOSÉ SÁNCHEZ </a> <br><br>
            </div>
            </center>
    </section>
    
        <div class="col-12">
            
            <p class="text-center text-white small"> &copy Todos los derechos reservados | Programación Web | 2023</p>
        </div>

    <script src="source/main.js"></script>
</body>
</html>