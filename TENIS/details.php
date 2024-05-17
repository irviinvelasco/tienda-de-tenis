<?php
    require 'source/details_cf.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Descripcion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="source/app.css">
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
                <a href="hombre.php">Hombre</a>
                <a href="mujer.php">Mujer</a>
                <a href="kids.php">Niño/a</a>
                <a href="rebajas.php">Rebajas</a>
                <a href="checkout.php "><img src="img/carrito-de-compras.png" width="50"><span id="num_cart" class="badge bg-secondary">
                <?php echo $num_cart; ?>
            </span></a>
                <a href="mis_compras.php"><img src="img/mis_compras.png" width="50"></a>
                <a href="cerrar_sesion.php">Cerrar sesión</a>    
                <a href=""><?php echo $rol; ?></a>                          
            </div>
        </nav>
    </div>
</header>
<main>
    <div class="content" style="padding: 120px;">
        <div class="row">
            <div class="col-md-6 order-md-1">
                <img src="data:image/png;base64,<?php echo  base64_encode($row['Imagen']); ?>" class="d-block w-100">
            </div>
            <div class="col-md-6 order-md-2">
                <h2><?php echo $nombre;?> </h2>
                <?php if ($descuento > 0) { ?>
                    <p style="color:white;"><del><?php echo MONEDA . number_format($precio, 2, '.', ',');?></del> MX</p>
                    <h2><?php echo MONEDA . number_format($precio_desc, 2, '.', ',');?> MX
                    <smal class="text-success"><?php echo $descuento ?>% descuento</smal>
                    </h2>
                <?php } else { ?>
                    <h2 id="precio"><?php echo MONEDA . number_format($precio, 2, '.', ',');?> </h2>
                <?php } ?>
                <p class="lead" style="color:white;"> <?php echo $descripcion; ?> </p>

                <select name="talla" id="talla" class="btn btn-outline-light btn-lg rounded-pill pr-5 pl-5">
                    <option value="25" selected>25 MX</option>
                    <option value="26">26 MX</option>
                    <option value="27">27 MX</option>
                    <option value="28">28 MX</option>
                </select>
                <div>
                    <input type="button" class="btn btn-outline-light btn-lg rounded-pill mt-2 pr-5 pl-5" value="COMPRAR AHORA" onclick="addProducto('<?php echo $id;?>','<?php echo $token; ?>'); pagPago();">  
                    <input type="button" class="btn btn-outline-light btn-lg rounded-pill mt-2 pr-5 pl-5" value="AGREGAR AL CARRITO" onclick="addProducto('<?php echo $id;?>','<?php echo $token; ?>');">
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12"> 
                <p class="text-center text-white small"> &copy Todos los derechos reservados | Programación Web | 2023</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="source/script.js"></script>
<script src="source/script1.js"></script>

<script>
    function pagPago() {
        window.location.href = "pago.php";
    }
</script>
<script>
    // Obtener el elemento select
    var tallaSelect = document.getElementById('talla');

    // Agregar un event listener para el cambio en la talla seleccionada
    tallaSelect.addEventListener('change', function() {
        // Obtener el precio base y el descuento del producto desde PHP
        var precioBase = <?php echo $precio; ?>;
        var descuento = <?php echo $descuento; ?>;

        // Obtener el valor de la talla seleccionada
        var talla = tallaSelect.value;

        // Calcular el precio actualizado
        var precioActualizado = precioBase;

        if (talla === '26') {
            precioActualizado = precioBase - ((precioBase * 5) / 100); // Descuento del 5% para talla 26
        } else if (talla === '28') {
            precioActualizado = precioBase + ((precioBase * 2) / 100); // Incremento del 2% para talla 28
        }

        // Actualizar el precio mostrado en la página
        var precioElement = document.getElementById('precio');
        precioElement.textContent = '<?php echo MONEDA; ?>' + precioActualizado.toFixed(2);
    });
</script>
</body>
</html>
