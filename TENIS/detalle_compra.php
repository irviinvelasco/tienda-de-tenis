<?php 
	require 'source/dc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tenis de Hombre</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="source/app1.css">
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
				<a href="cuentas.php">Cuentas</a>
				<a href="mis_productos.php">Mis Productos</a>
				<a href="compras.php">Compras</a>
				<b><a href="">Detalles Compra</a></b>
				<a href="cerrar_sesion.php">Cerrar sesión</a>
			</div>
		</nav>
	</div>
</header>
<!--CONTENIDO-->
<main>
	<div class="content" style="padding: 100px;">
		<div class="table-responsive">
			<table class="table" style="color:white;">
				<thead>
					<tr>
						<th>ID</th>
                        <th>ID_Compra</th>
						<th>ID_Producto</th>
						<th>Nombre</th>
						<th>Precio</th>
						<th>Cantidad</th>
					</tr>
				</thead>
				<tbody>
					<?php if (!empty($resultado)) : ?>
						<?php foreach ($resultado as $fila) : ?>
							<tr>
								<td><?php echo $fila['id']; ?></td>
								<td><?php echo $fila['id_compra']; ?></td>
                                <td><?php echo $fila['id_producto']; ?></td>
								<td><?php echo $fila['nombre']; ?></td>
								<td><?php echo $fila['precio']; ?></td>
								<td><?php echo $fila['cantidad']; ?></td>
							</tr>
						<?php endforeach; ?>
					<?php else : ?>
						<tr>
							<td colspan="5">No hay detalles de compra disponibles.</td>
						</tr>
					<?php endif; ?>
                    
				</tbody>
                
			</table>
            <center>
            <div>
                        <form method="POST" style="display: inline;">
                        <button type="submit" name="vaciarTabla" class="btn btn-danger">Vaciar Tabla</button>
                        </form>
                        <form method="POST" style="display: inline;" target="_blank" action="reporte_DC.php">
                        <button class="btn btn-primary" type="submit" name="generarPDF">Generar</button>
                        </form>
                    </div>
                    </center>
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
