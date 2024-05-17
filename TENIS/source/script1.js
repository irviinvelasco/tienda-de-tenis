function actualizaCantidad(cantidad, id){
  let url = 'source/actualizar_carrito.php';
  let formData = new FormData();
  formData.append('action','eliminar')
  formData.append('id', id);
  formData.append('cantidad', cantidad);

  fetch(url,{
    method: 'POST',
    body: formData,
    mode: 'cors'
  }).then(response => response.json())
  .then((data) => {
    if (data.ok) {
      let divsubtotal = document.getElementById('subtotal_' + id)
      divsubtotal.innerHTML = data.sub
    }
  })
}