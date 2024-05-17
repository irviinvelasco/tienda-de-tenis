<?php 
    require 'source/mp.php';
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
                <b><a href="">Mis Productos</a></b>
                <a href="compras.php">Compras</a>
                <a href="detalle_compra.php">Detalles Compra</a>
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
                        <th></th>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>Cantidad</th>
                        <th>ID_Categoría</th>
                        <th>Activo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultado as $fila): ?>
                        <tr>
                            <td><img src="data:image/png;base64,<?php echo  base64_encode($fila['Imagen']); ?>" class="d-block w-10" height="50"></td>
                            <td><?php echo $fila['id']; ?></td>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['descripcion']; ?></td>
                            <td><?php echo $fila['precio']; ?></td>
                            <td><?php echo $fila['descuento']; ?></td>
                            <td><?php echo $fila['cantidad'];?></td>
                            <td><?php echo $fila['id_categoria']; ?></td>
                            <td><?php echo $fila['activo']; ?></td>
                            <!-- Resto del código HTML -->

                        <td>
                            <form method="POST">
                                <input type="hidden" name="producto_id" value="<?php echo $fila['id']; ?>">
                                <input type="text" name="nuevo_nombre" placeholder="Nuevo nombre">
                                <input type="text" name="nueva_descripcion" placeholder="Nueva descripción">
                                <input type="text" name="nuevo_precio" placeholder="Nuevo precio">
                                <input type="text" name="nuevo_descuento" placeholder="Nuevo descuento">
                                <input type="text" name="nueva_cantidad" placeholder="Nueva cantidad"> <!-- Corregir el nombre del campo -->
                                <input type="text" name="nuevo_categoria" placeholder="Nueva categoría">
                                <input type="text" name="nuevo_activo" placeholder="Nuevo estado activo">
                                <button type="submit" name="actualizar" class="btn btn-primary">Actualizar</button>
                            </form>
                        </td>

<!-- Resto del código HTML -->

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <center>
            <div>

                        <form method="POST" style="display: inline;" target="_blank" action="reporte_MP.php">
                        <button class="btn btn-primary" type="submit" name="generarPDF">Generar</button>
                        </form>
                    </div>
                    </center>
        </div>
    </div>
</main>

<div class="col-12">
    <p class="text-center text-white small">&copy; Todos los derechos reservados | Programación Web | 2023</p>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="source/script.js"></script>
</body>
</html>
