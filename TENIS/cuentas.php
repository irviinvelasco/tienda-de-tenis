<?php
require 'source/tb_admin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenis de Hombre</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="source/app.css">
</head>
<body>
<header class="header">
	<div class="container">
		<div class="logo">
			<img src="img/logo_.png" alt="" class="mx-auto d-block logo" width="174" height="100">
		</div>
		<nav class="menu">
			<div class="btn-menu">
				<a href="tenis.php">Regresar al Inicio</a>
				<b><a href="">Cuentas</a></b>
				<a href="mis_productos.php">Mis Productos</a>
				<a href="compras.php">Compras</a>
				<a href="detalle_compra.php">Detalles Compra</a>
				<a href="cerrar_sesion.php">Cerrar sesión</a>
			</div>
		</nav>
	</div>
</header>
<!-- CONTENIDO -->
<main>
	<div class="content" style="padding: 100px;">
		<div class="table-responsive">
			<table class="table" style="color:white;">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nombre</th>
						<th>Correo</th>
						<th>Password</th>
						<th>Fecha</th>
						<th>Rol</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($resultado as $fila): ?>
						<tr>
							<td><?php echo $fila['id']; ?></td>
							<td><?php echo $fila['Nombre']; ?></td>
							<td><?php echo $fila['Correo']; ?></td>
							<td><?php echo $fila['Password']; ?></td>
							<td><?php echo $fila['Fecha']; ?></td>
							<td><?php echo $fila['Rol']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
            <section id="c2">
        <center> 
        <div class="form-body" id="div02" style="padding-top: 30px;">
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
