<!doctype html>
<html lang="es">

<head>
  <title>Productos</title>
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
      <strong>APP STORE - </strong> <br>LISTA PRODUCTOS
    </div>
    
    <table class="table table-sm table-striped" id="tabla-productos">
      <colgroup>
        <col width="5%">  <!-- # -->
        <col width="20%"> <!-- Categoria -->
        <col width="30%"> <!-- Descripción -->
        <col width="10%"> <!-- Precio -->
        <col width="10%"> <!-- Garantía -->
        <col width="10%"> <!-- Fotografía -->
        <col width="15%"> <!-- Comandos -->
      </colgroup>
      <thead>
        <tr>
          <th>#</th>
          <th>Categoria</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Garantía</th>
          <th>Fotografía</th>
          <th>Comandos</th>
        </tr>
      </thead>
      <tbody>
          <!-- DATOS CARGADOS DE FORMA ASINCRONA -->
      </tbody>
    </table>


  </div><!--.container -->

  <!--Zona modal-->
  
  <!-- Modal -->
  <div class="modal fade" id="modal-visor" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header bg-info text-light">
              <h5 class="modal-title" id="modalTitleId">Nombre del Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        <div class="modal-body">
          <img style ="width: 100%; max-height: 80%;" src="" id="visor" alt="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  



  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script>
    // VanillaJS (JS Puro)
    document.addEventListener("DOMContentLoaded", () => {

      // Objeto que referencie a nuestra tabla HTML
      const tabla = document.querySelector("#tabla-productos tbody");
      

      // Comunicación Controlador
      // Renderizar los datos en la Tabla > tbody
      function listarProductos(){
        // Preparar los parametros a enviar
        const parametros = new FormData();
        parametros.append("operacion", "listar")

        fetch(`../../controllers/producto.controller.php`, {
          method: 'POST', 
          body: parametros
        })
          .then(respuesta => respuesta.json())
          .then(datosRecibidos => {
            // Recorrer cada fila del arreglo
            let numFila = 1;

            tabla.innerHTML = "";

            datosRecibidos.forEach(registro => {
              let nuevafila = ``;

              // Enviar los valores obtenidos en celdas <td></td>
              nuevafila = `
              <tr>
                <td>${numFila}</td>
                <td>${registro.categoria}</td>
                <td>${registro.descripcion}</td>
                <td>${registro.precio}</td>
                <td>${registro.garantia}</td>
                <td>
                  <a href='#' class='linkFoto' data-name="${registro.descripcion}"" data-url="${registro.fotografia}" data-bs-toggle="modal" data-bs-target="#modal-visor">Ver</a>
                </td>
                <td>
                  <button class='btn btn-danger btn-sm eliminar'data-idproducto="${registro.idproducto}" type='button'>Eliminar</button>
                  <button class='btn btn-warning btn-sm editar' data-idproducto="${registro.idproducto}"type='button'>Editar</button>
                </td>
              </tr>
              `;

              tabla.innerHTML += nuevafila;
              numFila++;
            });
          })
          .catch(e => {
            console.error(e)
          })
      }

      //Detectando click sobre un elemento asíncrono
      //creado en tiempo de ejcución(VER -ELIMINAR - EDITAR)
      tabla.addEventListener("click", (event) => {
        if(event.target.classList.contains("linkFoto")){
          const ruta = event.target.dataset.url;
          console.log(event);
          document.querySelector("#visor").setAttribute("src",`../../images/${ruta}`);
          
          const descripcion = event.target.dataset.name;
          document.querySelector("#modalTitleId").innerText = descripcion;
        }

        if(event.target.classList.contains("eliminar")){
          console.log("Cuidado vas a eliminar algo")
          const idproducto = event.target.dataset.idproducto;
          const parametros = new FormData();
          parametros.append("operacion","eliminar");
          parametros.append("idproducto",idproducto);

          if(confirm("¿Estas seguro de eliminar?")){
            fetch(`../../controllers/producto.controller.php`,{
              method:"POST",
              body:parametros
            })
              .then(respuesta => respuesta)
              .then(datos =>{
                console.log(datos);
                listarProductos()
              })
              .catch( e => {
                console.error(e);
              })
          }
        }

        if(event.target.classList.contains("editar")){
          console.log("Proceso de edición")
        }

      });

      listarProductos();

    });



  </script>

</body>

</html>
