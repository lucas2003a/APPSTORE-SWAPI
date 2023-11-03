<?php


?>

<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
          <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav me-auto mt-2 mt-lg-0">
                    <a class="nav-item">
                        <!-- <a href="../../categoria/categoria.php" class="nav-link">Lista de categorias</a>
                        <a href="../../producto/listar.php"class="nav-link">Lista de productos</a>
                        <a href="../../producto/registrar.php" class="nav-link">Registro de productos</a>
                        <a href="../../usuario/listar.php" class="nav-link">Lista de usuarios</a>
                        <a href="../../usuario/registrar.php" class="nav-link">Registro de usuarios</a>
                        <a href="/.php" class="nav-link"></a> -->
                   
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Operaciones</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">
                            <a class="dropdown-item" href="login.php">Login</a>
                            <a class="dropdown-item" href="#">Cambiar contraseña</a>
                        </div>
                    </li>
                </ul>
            </div>
      </div>
    </nav>

  <div class="container mt-3">

    <div class="alert alert-primary" role="alert">
      <h4 class="alert-heading"><strong>CATALOGOS</strong></h4>
      <div>Productos</div>
      <hr>
      <p class="mb-0">Catalogo productos</p>
    </div>

    <div class="container m-4 content-body">
        <div class="m-4">  
           <form action="" id="form-catalogo">
            <label for="categorias" class="form-label">Categorías:</label>
            <select name ="categoria" class="form-select" id="categoria">
                <option value="0">Todos</option>
            </select>
            <div class="mt-2">
            <button type="submit" class="btn btn-sm btn-primary" id="buscar">Buscar</button>
            </div>
           </form>
        </div>
            <div class ="row">
              <div class="col-md-2">
                <div>
                  <label for="">Precio</label>
                  <input type="text" id="precioFiltro" value="1000" >
                  <input type="range" min="1" max="5000" value="1000" id="precioRango">
                  <button class="btn btn-sm btn-primary" id="mostrarFiltro" type="button">Filtrar</button>
                </div>
              </div>
              <div class="col-md-10">
                <div class="row"  id="card-products"></div>
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
    document.addEventListener('DOMContentLoaded',() =>{

      function $(id){
        return document.querySelector(id);
      }

      const card = $("#card-products");

      let dataObtenida = null;

      function getCategorias(){

      //Datos que enviaremos al controlador
      const parametros = new FormData();
      parametros.append("operacion","listar");

      //Conexión, el valoe obtenido, el proceso; el error
      fetch(`./controllers/categoria.controller.php`,{
        method: "POST",
        body : parametros
      })
        .then(respuesta => respuesta.json())
        .then(datos => {
            //Operaciones, procesos
            console.log(datos);
            datos.forEach(element => {
                const tagOption = document.createElement("option");
                tagOption.value = element.idcategoria
                tagOption.innerText = element.categoria
                $("#categoria").appendChild(tagOption);
          });
        })
        .catch(e =>{
            console.error(e);
        });
      }

      function listarOfertas(){

        const parametros = new FormData();
        parametros.append("operacion","listarOfertasCat");
        parametros.append("idcategoria",$("#categoria").value);

        fetch(`./controllers/producto.controller.php`,{
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {
            dataObtenida = data;
            console.log(dataObtenida);
            if(dataObtenida.length == 0){
              card.innerHTML = `    
              <div class='alert alert-danger' role='alert'>
                <h4 class='alert-heading'><strong>CATALOGOS</strong></h4>
                  <div>Productos</div>
                  <hr>
                <p class='mb-0'>Pronto tendremos más novedades</p>
              </div>`
            }else{
              
              //Evalua si hay una foto
              

              //Render
              let numCard = 1;
  
              card.innerHTML = "";
              
              dataObtenida.forEach(element => {

                const rutaImagen =(element.fotografia == null) ? "noImage.jfif" : element.fotografia;
                
                let nuevoCard = ``;
  
                nuevoCard = `
  
                <div class='col-md-3'>
                  <div class='m-2'>
                    <div class='card text-start'>
                      <div>
                      <img class='card-img' style='width: 100%; height: 250px;' src='./images/${rutaImagen}' alt='${element.descripcion}'>
                      </div>
                        <div class="card-body" >
                          <h4 class="card-title" style='width: 100%; height: 150px;'>${element.descripcion}</h4>
                          <p class="card-text">$/${element.precio}</p>
                        </div>
                        <div class="card-footer">
                          <div class='d-grid'>
                            <a href ='./views/catalogos/datasheet.php?id=${element.idproducto}' type='submit' class='btn btn-sm btn-success'>Lo quiero!</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                `;
                  //AGREGAMOS EN href LA DIRECCION DE NUESTRO ARCHIVO DE DESTINO Y UNA OPERACION ID QUE ALMACENA EL ID DEL PRODUCTO
                  //Y LO ENVIA AL ARCHIVO DE DESTINNO
                card.innerHTML += nuevoCard;
              });

            }


          })
          .catch(e =>{
            console.error(e);
          });
      }

      $("#precioRango").addEventListener("change",() => {
        $("#precioFiltro").value = $("#precioRango").value;
      });

      //Al dar click en el boton buscar
      $("#form-catalogo").addEventListener("submit",(event) =>{

        event.preventDefault();
        listarOfertas();
      });

      //Al dar cambiar de categoria en el select
      $("#categoria").addEventListener("change",listarOfertas);

      $("#mostrarFiltro").addEventListener("click",() => {

        console.log(dataObtenida);

        const precio = parseFloat($("#precioFiltro").value);
                      //Render
              let numCard = 1;
  
              card.innerHTML = "";
              
              dataObtenida.forEach(element => {

                const rutaImagen =(element.fotografia == null) ? "noImage.jfif" : element.fotografia;
                
                if(precio >= parseFloat(element.precio)){

                let nuevoCard = ``;
  
                nuevoCard = `
  
                <div class='col-md-3'>
                  <div class='m-2'>
                    <div class='card text-start'>
                      <div>
                      <img class='card-img' style='width: 100%; height: 250px;' src='./images/${rutaImagen}' alt='${element.descripcion}'>
                      </div>
                        <div class="card-body" >
                          <h4 class="card-title" style='width: 100%; height: 150px;'>${element.descripcion}</h4>
                          <p class="card-text">$/${element.precio}</p>
                        </div>
                        <div class="card-footer">
                          <div class='d-grid'>
                            <a href ='./views/catalogos/datasheet.php?id=${element.idproducto}' type='submit' class='btn btn-sm btn-success'>Lo quiero!</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                `;
                  //AGREGAMOS EN href LA DIRECCION DE NUESTRO ARCHIVO DE DESTINO Y UNA OPERACION ID QUE ALMACENA EL ID DEL PRODUCTO
                  //Y LO ENVIA AL ARCHIVO DE DESTINNO
                card.innerHTML += nuevoCard;
              }
              });

        
      });

      getCategorias();
      listarOfertas();

    });
    

  </script>
</body>

</html>