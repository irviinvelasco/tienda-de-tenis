<?php
require 'config.php';
require '../Configuracion.php';

if(isset($_POST['action'])){
  $action = $_POST['action'];
  $id = isset($_POST['id']) ? $_POST['id'] : 0;

  if($action == 'agregar'){
    $cantidad = isset($_POST['cantidad']) ? $_POST['cantidad'] : 0;
    $respuesta = agregar($id, $cantidad);
    if($respuesta > 0){
      $datos['ok'] = true;
    }else{
      $datos['ok'] = false;
    }
  }else if($action == 'eliminar'){
    $datos['ok'] = eliminar($id);
  }else if($action == 'eliminar_todo'){
    $datos['ok'] = eliminarTodo();
  }else
   $datos['ok'] = false;
}else{
  $datos['ok'] = false;
}

echo json_encode($datos);

function agregar($id, $cantidad){
  $res = 0;
  if($id > 0 && $cantidad > 0 && is_numeric($cantidad)){
    if(isset($_SESSION['carrito']['productos'][$id])){
      $_SESSION['carrito']['productos'][$id] = $cantidad;

      // Aquí es donde puedes extraer el valor del <select> y guardarlo en una variable

      // Luego, puedes enviar el valor seleccionado a otro archivo PHP utilizando una solicitud POST o GET
      // Aquí hay un ejemplo de cómo hacerlo con una solicitud POST

      $opciones = array(
        'http' => array(
          'header' => "Content-type: application/x-www-form-urlencoded\r\n",
          'method' => 'POST',
          'content' => http_build_query($datos),
        ),
      );

      $contexto = stream_context_create($opciones);
      $resultado = file_get_contents($url, false, $contexto);

      // Continúa con el resto del código...
    }
  }else{
    return $res;
  }
}

function eliminar($id){
  if($id > 0){
    if(isset($_SESSION['carrito']['productos'][$id])){
      unset($_SESSION['carrito']['productos'][$id]);
      return true;
    }
  }else{
    return false;
  }
}

function eliminarTodo(){
  unset($_SESSION['carrito']['productos']);
  return true;
}

?>
