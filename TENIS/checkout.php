<?php
require 'source/config.php';
require 'Configuracion.php';
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
}





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carrito de compras</title>
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
        <a href="source/carrito.php "><img src="img/carrito-de-compras.png" width="50"><span id="num_cart" class="badge bg-secondary">
                <?php echo $num_cart; ?>
            </span></a>		    </div>
			</nav>
		</div>
	</header>
  <!--CONTENIDO-->
<main>
<div class="content" style="padding: 120px;" >
    <div class="table-responsive">
      <table class="table" style="color:white;">
        <thead>
          <tr>
            <th></th>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th></th>
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
            <td><img src="data:image/png;base64,<?php echo  base64_encode($producto['Imagen']); ?>" height="30"></td>
            <td><?php echo $nombre; ?></td>
            <td><?php echo MONEDA . number_format($precio_desc,2,'.',','); ?></td>

            <td><p><?php echo $producto['cantidad_seleccionada']; ?></p></td>
            <td>
            <div id="subtotal_<?php $_id; ?>" name="subtotal[]"><?php echo MONEDA . number_format($subtotal,2,'.',','); ?></div>
            </td>
            <td><a id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="fas fa-trash-alt"></i>Eliminar</a></td>
            </tr>
          <?php } ?>

              <tr>
                <td colspan="3"></td>
                <td colspan="1"></td>
                <td colspan="1">
                  <p class="h3" id="total"><?php echo MONEDA . number_format ($total,2,'.',','); ?></p>
                </td>
                <td colspan="1"><input type="button" class="btn btn-danger" value="ELIMINAR TODO" onclick="eliminarTodo();"></td><br>
              </tr>
        </tbody>
        
        <?php } ?>
      </table>
    </div>
    <?php if($lista_carrito != null) { ?>
    <div class="row">
        <div class="col-md-3 offset-md-8 d-grid gap-5">
        <a href="pago.php" class="btn btn-outline-light btn-lg rounded-pill mt-2 pr-5 pl-5">PAGAR AHORA</a>
        </div>
    </div>
      <?php } ?>
      </div>
</main> 
<!-- Modal -->
<div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminaModalLabel">Arleta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Desea eliminar el producto?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button id="btn-elimina" class="btn btn-danger" onclick="elimina()">Eliminar</button>      </div>
    </div>
  </div>
</div>



        <div class="col-12"> 
            <p class="text-center text-white small"> &copy Todos los derechos reservados | Programación Web | 2023</p>
        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
  
  let eliminaModal = document.getElementById('eliminaModal')
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            // Button that triggered the modal
            let button = event.relatedTarget
            // Extract info from data-bs-* attributes
            let recipient = button.getAttribute('data-bs-id')
            let botonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina')
            botonElimina.value = recipient
        })

         function elimina() {
            let botonElimina = document.getElementById('btn-elimina')
            let recipient = botonElimina.value

            let url = 'source/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action', 'eliminar');
            formData.append('id', recipient);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors',
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload();
                    }
                })
            
        }
    
                  function eliminarTodo() {
            let url = 'source/actualizar_carrito.php';
            let formData = new FormData();
            formData.append('action', 'eliminar_todo');

            fetch(url, {
              method: 'POST',
              body: formData,
              mode: 'cors',
            }).then(response => response.json())
              .then(data => {
                if (data.ok) {
                  location.reload();
                }
              });
          }

</script>

</body>
</html>