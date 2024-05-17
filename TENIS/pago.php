<?php 
  require 'Configuracion.php';
  require 'source/config.php';
  $db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
$valorSeleccionado = isset($_GET['valor']) ? $_GET['valor'] : '';

$lista_carrito = array();

if ($productos != null) {
  foreach ($productos as $clave => $cantidad) {
    $sql = $con->prepare("SELECT id, Imagen, nombre, precio, descuento, $cantidad as cantidad, $cantidad as cantidad_seleccionada FROM mis_productos WHERE id = ? AND activo = 1");
    $sql->execute([$clave]);
    $producto = $sql->fetch(PDO::FETCH_ASSOC);
    $producto['cantidad_seleccionada'] = $cantidad;
    $lista_carrito[] = $producto;
  }
}else{
    header("Location: tenis.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pago</title>
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
				<a href="hombre.php">Hombre</a>
				<a href="mujer.php">Mujer</a>
        <a href="kids.php">Niño/a</a>
        <a href="Rebajas.php">Rebajas</a>
        <a href="checkout.php "><img src="img/carrito-de-compras.png" width="50"><span id="num_cart" class="badge bg-secondary">
                <?php echo $num_cart; ?>
            </span></a>		    </div>
			</nav>
		</div>
	</header>
  <!--CONTENIDO-->
<main>
<div class="content" style="padding: 120px;" >
<div class="row">
    <div class="col-6" style="color:white;">
        <h4>Detalles de pago</h4>
        <div id="paypal-button-container" style="color:white;"> </div>
    </div>
    <div class="col-6">
    <div class="table-responsive">
      <table class="table" style="color:white;">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php if($lista_carrito == null){
            echo'<tr><td colspan="8" class="text-center"><b>Lista vacia</b></td></tr>';
          }else{
            $total = 0;
            foreach($lista_carrito as $producto){
              $_id = $producto['id'];
              $imagen = $producto['Imagen'];
              $nombre = $producto['nombre'];
              $precio = $producto['precio'];
              $descuento = $producto['descuento'];
              $cantidad = $producto['cantidad'];
              $precio_desc = $precio - (($precio * $descuento) / 100);
              $subtotal = $cantidad * $precio_desc;
              $total += $subtotal;
           ?>
          <tr>
            
            <td><?php echo $nombre; ?></td>
            <td>
            <div id="subtotal_<?php $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',','); ?></div>
            </td>
            </tr>
          <?php } ?>

              <tr>
                <td colspan="1"></td>
                <td colspan="1">
                  <p class="h3" id="total"><?php echo MONEDA . number_format ($total,2,'.',','); ?></p>
                </td>
              </tr>            
        </tbody>
        
        <?php } ?>
      </table>
    </div>
      </div>
            </div>
            </div>
    </div>
</main> 


        <div class="col-12"> 
            <p class="text-center text-white small"> &copy Todos los derechos reservados | Programación Web | 2023</p>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://www.paypal.com/sdk/js?client-id=AUqKvEuvKAMHyrHpE_nvORidncgJEWNylAjojzi0ibOojuwWjiu1LoS5eOiQbhiUOESTpZz-ndpqXMpA&currency=MXN"></script>
<script>
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function (data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: <?php echo $total; ?>
                    }
                }]
            });
        },

        onApprove: function (data, actions) {
  let url = 'source/captura.php';
  return actions.order.capture().then(function (detalles) {
    console.log(detalles);

    // ... tu código adicional si lo tienes ...

    return fetch(url, {
      method: 'post',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        detalles: detalles
      })
    });
  }).then(function(response) {
    // Recarga la página actual después de completar la petición
    window.open('ticket.php', '_blank');
    location.reload();

  }).catch(function(error) {
    console.error('Error:', error);
  });
},


        onCancel: function (data) {
            alert("Pago cancelado");
            console.log(data);
        }
    }).render('#paypal-button-container')

</script>
</body>
</html>