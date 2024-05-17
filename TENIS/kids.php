<?php
require 'Configuracion.php';
require 'source/config.php';

$correo = $_SESSION['correo']; // Obtener el correo electrónico de la sesión

$db = new Database();
$con = $db->conectar();

$sql= $con->prepare("SELECT id,Imagen,nombre,precio from mis_productos WHERE id_categoria=3 and activo=1");
$sql->execute();
$resultado = $sql->fetchALL(PDO::FETCH_ASSOC);
if ($sql->rowCount() > 0) {
  $sql1 = $con->prepare("SELECT nombre,rol FROM cuentas WHERE Correo = :correo");
  $sql1->execute(['correo' => $correo]);
  $row = $sql1->fetch(PDO::FETCH_ASSOC);
  $nombre = $row['nombre'];
  $rol = $row['rol'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenis de Niño/a</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="source/app1.css">
</head>
<body>
<header class="header">
		<div class="container">
			<div class="logo">
                <img src="img/logo_.png" alt="" class="mx-auto d-block logo" width="174" height="100" >			
      </div>
			<nav class="menu">
                <div class="btn-menu">
				<a href="tenis.php">Nuevos lanzamientos</a>
				<a href="hombre.php" class="nav-link active">Hombre</a>
				<a href="mujer.php">Mujer</a>
        <b><a href="">Niño/a</a></b>
        <a href="rebajas.php">Rebajas</a>
        <a href="checkout.php "><img src="img/carrito-de-compras.png" width="50"><span id="num_cart" class="badge bg-secondary">
                <?php echo $num_cart; ?>
            </span></a>
        <a href="mis_compras.php"><img src="img/mis_compras.png" width="50"></a>
        <a href="cerrar_sesion.php">Cerrar sesión</a>
          </div>
			</nav>
		</div>
	</header>
  <!--CONTENIDO-->
  <div class="col-12">
    <br><br><br><br><br>
</div>
<center>
<h3 style="color:white">Tenis de Niños/as</h3></center>
  <main>
  <div class="content" style="padding: 50px;">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
      <?php foreach($resultado as $row) { ?>  
        <div class="col" ALIGN="center">
          <div class="card hover-card" style="box-shadow: 0 0 5px 2px rgba(0, 0, 0, 0.2);">
            
              <img src="data:image/png;base64,<?php echo  base64_encode($row['Imagen']); ?>" class="d-block w-100" height="200">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
              <p class="card-text">$<?php echo number_format($row['precio'],2,'.',','); ?></p>
              <a href="details.php?id=<?php echo $row['id']; ?>&token=<?php echo hash_hmac('sha1', $row['id'], KEY_TOKEN); ?>" class="btn btn-primary">Detalles</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</main>
        <div class="col-12"> 
            <p class="text-center text-white small"> &copy Todos los derechos reservados | Programación Web | 2023</p>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="source/script.js"></script>
</body>
</html>