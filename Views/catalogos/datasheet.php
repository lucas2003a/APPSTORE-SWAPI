<?php 
if(isset($_GET['id'])){

    $idproducto = $_GET['id'];

    //CREAMOS LA CONSTANTE idobtenido QUE ALMACENARA EL ID DEL PRODUCTO Y SERA USADA EN EL JAVA SCRIPT
    echo "
    <script>
     const idobtenido = ".json_encode($idproducto) .";
    </script>
    ";
}
?>

<!doctype html>
<html lang="es">

<head>
  <title>Datasheet</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

  <!-- Iconos Font-awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="../../styles/modal.css">
</head>

<body>
  <div class="container">

    <input type="" id="idproducto" name="idproducto">

    <div class="m-4" id="mensaje">
      <div class="row">
        <div class="col-md-8">
          <div class="card text-start">
            <div class="card-body" id="card-body">
              <img class='card-img' id="visor-1" style='width: 100%; height: 600px;' src="" alt="">
            </div>
            <div class="card-footer" id="card-footer">

            <!-- RENDERIZAMOS LAS IMAGENES -->
            </div>
          </div>
        </div>
        <div class="col-md-4" id="alerts">

          <!-- RENDEREIZAMOS LOS ALERTS -->


          <div class="m-4" id="alerts">
            <div class="alert alert-primary" role="alert">
              <h4 class="alert-heading"><strong>Descripción:</strong></h4>
              <hr>
              <h6 id="alert-descripcion">Descripción del productos:</h6>
            </div>
          </div>

          <div class="m-4">
            <div class="alert alert-primary" role="alert">
              <h4 class="alert-heading"><strong>Garantía:</strong></h4>
              <hr>
              <h6 id="alert-garantia">Descripción del producto:</h6>
            </div>
          </div>
          
          <div class="m-4">
            <div class="alert alert-primary" role="alert">
              <h4 class="alert-heading"><strong>Precio:</strong></h4>
              <hr>
              <h6 id="alert-precio">Descripción del producto:</h6>
            </div>
          </div>

          <div class="m-4">
            <div class="alert alert-primary" role="alert">
              <h4 class="alert-heading"><strong>Fecha de ingreso:</strong></h4>
              <hr>
              <h6 id="alert-fecha">Descripción del producto:</h6>
            </div>
        </div>
      </div>
    </div>
  
    <div class="m-4">
      <hr>
      <h2>INFORMACIÓN:</h2>
      <hr>
    </div>

    <div class="m-4">
      <table class="table table-striped table-warning">
        <thead id="cabezera">
          
          <!-- RENDERIZAMO LAS CLAVES Y VALORES -->

          <colgroup>
            <col width="20%">
            <col width="80%">
          </colgroup>
          <!--<tr>
            <th><strong class="text-uppercase">clave a:</strong></th>
            <th>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates sapiente deleniti error, animi ex facere dolorem itaque, consectetur cumque voluptas facilis, reiciendis sed consequatur officiis modi ullam impedit dolor! Dolore.</th>
          </tr> -->

        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <!-- MODAL DE IMAGEN -->

  <div id="modal-visor" class="my-modal">

    <span class="close">&times;</span>

    <img id="img-modal2" class="modal-content" src="" alt="">

    <div id="caption"></div>

  </div>

  <header>
    <!-- place navbar here -->
  </header>
  <main>

  </main>
  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script>
    document.addEventListener('DOMContentLoaded',() =>{

        //idobtenido es la constante creada en la parte superior con PHP

        console.log(idobtenido);

        const newID = idobtenido;

        function $(id){
            return document.querySelector(id)
        }
        
        $("#idproducto").value = newID;
        
        const cabezera = $("#cabezera");

        const mensaje = $("#mensaje");

        const cardFooter = $("#card-footer");

        const modal = $("#modal-visor");

        const imgModal = $("#img-modal2");
        
        const textImg  = $("#caption");
        
        const span     = $(".close");


        function getGaleria(){

          const parametros = new FormData();

          parametros.append("operacion","obtener");
          parametros.append("idproducto",$("#idproducto").value);

          fetch(`../../controllers/galeria.controller.php`,{
            method: "POST",
            body: parametros
          })
            .then(result => result.json())
            .then(data => {
              console.log(data);

              if(data.length == 0){

                let cardFooterER = ``;

                cardFooterER = `
                  <div class="m-4">
                    <div class="alert alert-danger" role="alert">
                      <h4 class="alert-heading"><strong>Algo salió mal</strong></h4>
                      <hr>
                      <h6>No contamos con suficiente imagenes por el momento</h6>
                      </div>
                    </div>
                  `;
                cardFooter.innerHTML = cardFooterER;
              }else{

                cardFooter.innerHTML = "";
  
                data.forEach(element => {
                  
                  const rutafoto = (element.rutafoto == null) ? "noImage.jfif" :  element.rutafoto;
  
                  //RENDERIZAMOS LAS IMAGENES DE LA GALERIÌA
  
                    let newCardfooter = ``;
  
                    newCardfooter = `
  
                      <img src='../../images/${rutafoto}' alt='${element.descripcion}' data-descripcion='${element.descripcion}' data-ruta='../../images/${rutafoto}' style='width: 15%; height: 100px;'>
  
                    `;
  
                    cardFooter.innerHTML += newCardfooter;               
                });

              }
            })
            .catch(e => {
              console.error(e);
            });

        }

        function getDatasheet(){
            
            const parametros = new FormData();

            parametros.append("operacion","listar");
            parametros.append("idproducto",$("#idproducto").value);

            fetch(`../../controllers/datasheet.controller.php`,{
                method: "POST",
                body: parametros
            })
                .then(result => result.json())
                .then(data =>{
                    if(data.length == 0){

                        const mensajeError = `
                        <div class="m-4">
                          <div class="alert alert-danger" role="alert">
                            <h4 class="alert-heading"><strong>Algo salió mal</strong></h4>
                            <hr>
                            <h6>No contamos con suficiente informaión por el momento</h6>
                          </div>
                        </div>
                        `;
                        $("#cabezera").innerHTML= mensajeError;
                    }else{
                      console.log(data);
                      //RENERIZAMOS LOS ALERTS
                      numAlert = 1;

                      cabezera.innerHTML = ``;
                        
                      data.forEach(element => {
                      
                        let newCabezera = ``;
                        
                        newCabezera = `
                        <tr>
                        <th><strong class="text-uppercase">${element.clave}:</strong></th>
                        <th>${element.valor}</th>
                        </tr>
                        `;
                          
                      cabezera.innerHTML += newCabezera;
                      });
                    }
                })
                .catch(e =>{
                    console.error(e);
                });
        }


        function getProductos(){

          const parametros = new FormData();
          parametros.append("operacion","obtener");
          parametros.append("idproducto",$("#idproducto").value);

          fetch(`../../controllers/producto.controller.php`,{
            method:"POST",
            body: parametros
          })
            .then(result => result.json())
            .then(data =>{
              console.log(data);

                const rutaImagen = (data.fotografia == null) ? "noImage.jfif" :  data.fotografia;

                //CAMBIAMOS LA IMAGEN PRINCIPAL

                $("#visor-1").setAttribute("src","../../images/"+rutaImagen);
                //RENDERIZAMOS LOS ALERTS

                $("#alert-descripcion").innerHTML = data.descripcion;
                $("#alert-garantia").innerHTML = data.garantia;
                $("#alert-precio").innerHTML = data.precio;
                $("#alert-fecha").innerHTML = data.create_at;

                getGaleria();
                getDatasheet();
            })
            .catch(e => {
              console.error(e);
            });
          
        }

        function abrirImagen(url,descrip){

          modal.setAttribute("style","display: block;");
          imgModal.setAttribute("src",url);
          textImg.innerText = descrip;
        }

        function reinciarFormulario(){

          $("#fotografias").classList.add("d-none");
          $("#modal-descripcion").value = "";

        }

        $("#card-footer").addEventListener("click",(event) => {

          const urlImagen = event.target.dataset.ruta;

          console.log(urlImagen);

          const descripcion = event.target.dataset.descripcion;
          console.log(descripcion);

          abrirImagen(urlImagen,descripcion);
        });

        span.addEventListener("click",() =>{
          
          modal.setAttribute("style","display: none");
        });

        //CARGA AUTOMATICA
        
        getProductos();

    });
  </script>
</body>

</html>