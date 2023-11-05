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
  <header>

  </header>
  <main>
  <div class="container mt-3">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <h4>Recuperar constraseña</h4>
        <form action="" id="form-usuario">
        <div class="mb-3">
          <label for="" class="form-label">Email</label>
          <input type="text" class="form-control" id="campocriterio" autofocus required>
        </div>
        <div class="mb-3">
          <div class="form-check">
            <input type="radio" class="form-check-input" id="sms" name="medioMensaje" autofocus required>
            <label for="sms" class="form-check-label">SMS</label>
          </div> 
          <div class="form-check">
            <input type="radio" class="form-check-input" id="email" name="medioMensaje" autofocus required>
            <label for="email" class="form-check-label">E-MAIL</label>
          </div> 
        </div>
        <div>
          <div class="d-grid">
            <button type="submit" class="btn btn-sm btn-primary" id="enviar">Enviar</button>
          </div>
        </div>
        </form>
      </div>
      <div class="col-md-4"></div>
    </div>
  </div>
  </main>
  <footer>

  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    document.addEventListener("DOMContentLoaded",() => {

      function $(id){
        return document.querySelector(id);
      }

      dataUsu = null;

      
      function getData(){

      const parametros = new FormData();

      parametros.append("operacion","obtenerCD");
      parametros.append("campocriterio",$("#campocriterio").value);

      fetch(`./controllers/usuario.controller.php`,{
        method: "POST",
        body: parametros
      })
        .then(result => result.json())
        .then(data =>{
          //onsole.log(data)

          const statusForm = data[0];
          dataUsu  = data[1];

          console.log(dataUsu);

          if(statusForm.status){
            //alert(statusForm.mensaje);
            insertCode();

            if($("#sms").checked){
        
              if($("#campocriterio").value.trim() == dataUsu.telefono.trim()){
                console.log("check sms");
                sendSMS()
               
              }else{
                alert("No existe el número de teléfono");
              }

            }else if($("#email").checked){
        
              if($("#campocriterio").value.trim() == dataUsu.email.trim()){
                console.log("check email");
                sendEmail();
              }else{
                alert("No existe el correo");
              }
            }

          }else{
            alert(statusForm.mensaje);
          }

        })
        .catch(e =>{
          console.error(e);
        });
      }

      function sendSMS(){

        const parametros = new FormData();

        parametros.append("operacion","sendSMS");
        parametros.append("telefono",$("#campocriterio").value);

        fetch(`./controllers/usuario.controller.php`,{
          method:"POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data =>{

            if(data){

              alert("mensaje enviado");

            }else{

              alert("No se pudo enviar el mensaje,revise el correo electronico por favor");

            }

          })
          .catch(e =>{
            console.error(e);
          });
      }

      function sendEmail(){

        const parametros = new FormData();

        parametros.append("operacion","sendEmail");
        parametros.append("emailDestino",$("#campocriterio").value);

        fetch(`./controllers/usuario.controller.php`,{
          method:"POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data =>{

            if(data){

              alert("email enviado");

            }else{

              alert("No se pudo enviar el email,revise el correo electronico por favor");

            }

          })
          .catch(e =>{
            console.error(e);
          });
      }

      function insertCode(){

        const parametros = new FormData();

        parametros.append("operacion","registrarCD");
        parametros.append("idusuario",dataUsu.idusuario);


        fetch(`./controllers/usuario.controller.php`,{
          method:"POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data =>{
            console.log("registrado");
          })
          .catch(e =>{
            console.error(e);
          });
      }

      $("#form-usuario").addEventListener("submit",(event) =>{
        event.preventDefault();
        getData();

      });
    });
  </script>
</body>

</html>