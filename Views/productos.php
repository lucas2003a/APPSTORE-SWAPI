<!doctype html>
<html lang="es">

<head>
  <title>Producto</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container mt-3">
    <div class="alert alert-info" role="alert">
      <strong>Módulo Productos</strong>
      <div>Datos registrados</div>
    </div>
    
    <table class="table table-sm" id="tabla-productos">
      <colgroup>
      <col width="5"> <!-- # -->
      <col width="20"> <!-- Categoria -->
      <col width="30"> <!-- Descripcion -->
      <col width="10"> <!-- Precio -->
      <col width="10"> <!-- Garantia -->
      <col width="10"> <!-- Fotografia -->
      <col width="15"> <!-- Comandos -->
    </colgroup>
      <thead>
        <tr>
          <th>#</th>
          <th>Categoría</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Garantía</th>
          <th>Fotografía</th>
          <th>Comandos</th>
        </tr>
      </thead>
      <tbody>
        <!--Datos cargados de forma asincrona-->
      </tbody>
    </table>
  </div>



  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

<script>
  //VanillaJS (JS Puro)
  document.addEventListener("DOMContentLoaded", () =>{

    //Objeto que referencie a nuestra tabla HTML
    const tabla = document.querySelector("#tabla-productos tbody");
    
    //Comunicacion controlador
    //renderizar los datos en la tabla>tbody
    //then = luego
    function listarProductos(){
      //Preparar los parametros a enviar
      //datosRecibidos es el array 
      const parametros = new FormData()
      parametros.append("operacion","listar")

      fetch(`../controllers/producto.controller.php`, {
        method: 'POST',
        body: parametros
      })
        .then(respuesta => respuesta.json())
        .then(datosRecibidos =>{
          //Recorrer cada fila del arreglo
            let numFila = 1;
          datosRecibidos.forEach(registro => {
            let nuevaFila = ``;

            //Enviar los valores obtenidos en celdas <td></td>
            nuevaFila = `
            <tr>
              <td>${numFila}</td>
              <td>${registro.categoria}</td>
              <td>${registro.descripcion}</td>
              <td>${registro.precio}</td>
              <td>${registro.garantia}</td>
              <td><a href='#'>Ver</a></td>
              <td>
              <button class ='btn btn-danger btn-sm' type='button'>Eliminar</button>
              <button class ='btn btn-info btn-sm' type='button'>Editar</button>
              </td>
            </tr>
            `;

            tabla.innerHTML += nuevaFila;
            numFila++;
          });
        } )
        .catch(e =>{
          console.error(e)
        })
    }
    
    listarProductos();

  });

</script>



</html>