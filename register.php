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
          <h4>Recuperar contraseña</h4>
          <form action="" id="form-usuario">
            <div class="mb-3">
              <label for="" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" autofocus required>
            </div>

            <!-- CHECK-BOX ZONE -->

            <div class="mb-3">
              <div class="form-check">
                <input type="radio" class="form-check-input" id="chk-sms" name="medioMensaje" autofocus required>
                <label for="sms" class="form-check-label">SMS</label>
              </div>
              <div class="form-check">
                <input type="radio" class="form-check-input" id="chk-email" name="medioMensaje" autofocus required>
                <label for="email" class="form-check-label">E-MAIL</label>
              </div>
            </div>

            <!-- END CHEXK-BOX-ZONE -->

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

    <!-- MODAL -->
    <!-- Button trigger modal -->

    <!-- Modal CODIGO-->
    <div class="modal" id="modal-code">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" id="form-code">
            <div class="modal-header bg-success text-light">
              <h5 class="modal-title" id="modalTitleId">Còdigo de recuperación</h5>
              <button type="button" id="modal-cerrar" class="btn-close" data-bs-dismiss="modal-register"
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <label for="code" class="form-label">Ingrese el código enviado</label>
                <input type="text" class="form-control" id="code" name="code" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="validarCode">Validar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--  -->

    <!-- MODAL CONSTRASEÑA -->
    <div class="modal" id="modal-password">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form action="" id="form-password">
            <div class="modal-header bg-success text-light">
              <h5 class="modal-title" id="modalTitleId">Cambiar contraseña</h5>
              <button type="button" id="modalPass-cerrar" class="btn-close" data-bs-dismiss="modal-register"
                aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="container-fluid">
                <div class="m-2">
                  <label for="newPassword" class="form-label">Ingrese la nueva contraseña</label>
                  <input type="text" class="form-control" id="newPassword" name="newPassword" required>
                </div>
                <div class="m-2">
                  <label for="confirmPassword" class="form-label">Confirme la nueva contraseña</label>
                  <input type="text" class="form-control" id="confirmPassword" name="confirmPassword" required>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" id="validarPassword">Validar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--  -->

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
    document.addEventListener("DOMContentLoaded", () => {

      /**
       * @typedef{object} dataUsu
       * @property {int} idusuario
       * @property {string} apellidos
       * @property {string} nombres
       * @property {string} email
       * @property {string} telefono
       */
      dataUsu = null;

      /**
       * @typedef{object}codeResult
       * @property {int} codigo
       */
      codeResult = null;

      /**
      *Función "$", sirve para poder manipular los elementos html de una forma mas rápida, mediante su id o clase.
      *
      *ejemplo por id : 
      *$("#idelemento") 
      *ejemplo por clase : 
      *$(".clase")
      * @param id{string} id - id de la etiqueta html o la clase de la etiqueta  
      */
      function $(id) {
        return document.querySelector(id);
      }
      
      /**
       * Función para resetear o limpiar las cajas de texto del modal donde modificamos la contraseña.
       *
       * @return void
       */
      function modalPasswordReinciar() {

        $("#newPassword").value = "";
        $("#confirmPassword").value = "";

      }

      /**
       * Función para resetear o limpiar las cajas de texto del modal donde ingresamos el dódigo de verificacion.
       *
       * @return void
       */
      function modalCodeReiniciar() {
      $("#code").value = "";
      }

      /**
       * Función para abrir el modal donde ingresamos el código de verificación.
       *
       * @return void
       */
      function modalCodeAbrir() {
        $("#modal-code").classList.remove("d-none");
        $("#modal-code").classList.add("d-block");
      }

      /**
       * Función para cerrar el modal donde ingresamos el código de verificación.
       *
       * @return void
       */
      function modalCodeCerrar() {

        $("#modal-code").classList.remove("d-block");
        $("#modal-code").classList.add("d-none");
        modalCodeReiniciar();
      }

      /**
       * Función para abrir el modal donde modificamos la clave del usuario.
       *
       * @return void
       */
      function modalPasswordAbrir() {
        $("#modal-password").classList.remove("d-none");
        $("#modal-password").classList.add("d-block");
      }

      /**
       * Función para cerrar el modal donde modificamos la clave del usuario.
       *
       * @return void
       */
      function modalPasswordCerrar() {

        $("#modal-password").classList.remove("d-block");
        $("#modal-password").classList.add("d-none");
        modalPasswordReinciar();
      }

      /**
       * Función para obtener los datos del usuario.
       * @param emailIngresado{string} email
       *
       */
      function getData(emailIngresado) {

        const parametros = new FormData();

        parametros.append("operacion", "getUsuarioEmail");
        parametros.append("email", emailIngresado);

        fetch(`./controllers/usuario.controller.php`, {
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {

            //asignamos a statusForm, el primer array de la respuesta json
            const statusForm = data[0];

            //asignamos a dataUsu, el segundo array de la respuesta json
            dataUsu = data[1];

            console.log(dataUsu);

            if (statusForm.status) {
              ///Enviamos los parametros y registramos el código;
              insertCode(dataUsu.idusuario);

            } else {
              alert(statusForm.mensaje);
            }

          })
          .catch(e => {
            console.error(e);
            alert("Revise bien el email ingresado, ha cometido un error!!");
          });
      }

      /**
       * Función para enviar mensajes de texto al celular
       * @param {int} codigoObtenido 
       * @param {string} telefonoObtenido 
       */
      function sendSMS(codigoObtenido,telefonoObtenido) {

        const parametros = new FormData();

        parametros.append("operacion", "sendSMS");
        parametros.append("telefono", telefonoObtenido);
        parametros.append("mensaje", codigoObtenido);

        fetch(`./controllers/usuario.controller.php`, {
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {

            if (data) {
              
              alert("mensaje enviado");
              modalCodeAbrir();

            } else {

              alert("No se pudo enviar el mensaje,revise el correo electronico por favor");

            }

          })
          .catch(e => {
            console.error(e);
          });
      }

      /**
       * Función para enviar correos, tomamos valor de la caja de texto por id
       * @param {int} codigoObtenido 
       */
      function sendEmail(codigoObtenido) {

        const parametros = new FormData();

        parametros.append("operacion", "sendEmail");
        parametros.append("emailDestino", $("#email").value);
        parametros.append("mensaje", codigoObtenido);

        fetch(`./controllers/usuario.controller.php`, {
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {

            //si existen los datos..
            if (data) {

              alert("email enviado");
              modalCodeAbrir();

            } else {

              alert("No se pudo enviar el email,revise el correo electronico por favor");

            }

          })
          .catch(e => {
            console.error(e);
          });
      }

      /**
       * Función para registrar el código generado, en la base de datos
       * @param {int} idObtenido 
       *
       * @return void
       */
      function insertCode(idObtenido) {

        const parametros = new FormData();

        parametros.append("operacion", "registrarCD");
        parametros.append("idusuario", idObtenido);


        fetch(`./controllers/usuario.controller.php`, {
          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {

            //Asignamos a codeResult los registros de data.
            codeResult = data;
            console.log(codeResult);

            //almacenamos el mensaje en una variable y concatenamos el codigo que se guardo en codeResult
            const mensaje = "El código de recuperación es : " + codeResult.codigo


            //usamos else if para verificar que solo una de los dos checkboxes esten seleccionadas
            if ($("#chk-sms").checked) {

              console.log("check sms");
              //enviamos los parametros
              sendSMS(mensaje,dataUsu.telefono);

            } else if ($("#chk-email").checked) {

              console.log("check email");
              //enviamos los parametros
              sendEmail(mensaje);

            }

          })
          .catch(e => {
            console.error(e);
          });
      }
      
      /**
       * Función para modificar la contraseña del usuario, tomamos los valores del data.idusuario
       * y de la caja de texto donde se confirma la constraseña.
       *
       * @return void
       */
      function setPassword() {

        const parametros = new FormData();

        parametros.append("operacion", "setPassword");
        parametros.append("idusuario", dataUsu.idusuario);
        parametros.append("claveacceso", $("#confirmPassword").value);

        fetch(`./controllers/usuario.controller.php`, {

          method: "POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {
            alert("se hizo el cambio correcto")
          })
          .catch(e => {
            console.error(e);
          });
      }

      /**
       * Funcion para eliminar el código generado, de de la base de datos(null)
       * @param id{int} idusuario
       *
       * @return void
       */
      function deleteCode(idObtenido){

        const parametros = new FormData();

        parametros.append("operacion","eliminarCD");
        parametros.append("idusuario",idObtenido);

        fetch(`./controllers/usuario.controller.php`,{
          method : "POST",
          body:parametros
        })
          .then(result => result.json())
          .then(data =>{
            console.log("se elimino el código");
          })
          .catch( e =>{
            console.error(e);
          });
      }

      /**
       * Función para validar que el codigo ingresado sea el mismo código que se ha guardado en la base de datos
       *
       * @return void
       */
      function validarCode() {

        if ($("#code").value != codeResult.codigo) {

          alert("EL codigo no coincide");

          //limpiamos o vaciamos la caja de texto
          modalCodeReiniciar();
        } else {
          alert("EL codigo coincide");
          modalPasswordAbrir();

          modalCodeReiniciar();
          deleteCode(dataUsu.idusuario);
        }
      }

      /**
       * Función para validar que las constraseñas ingresadas en las cajas de txto, sean iguales,
       * de no ser asi no se procederá a guardar la constraseña.
       *
       * @return void
       */
      function validarPassword() {

        const newPassword = $("#newPassword").value;
        const confirmPassword = $("#confirmPassword").value;

        //si el valor o la contraseña ingresada en ambas cajas no coinciden...
        if (confirmPassword != newPassword) {

          alert("Las contraseñas no coinciden");

        } else {

          alert("Las contraseñas coinciden");
          setPassword();
          modalPasswordCerrar();
          modalCodeCerrar();

          //limpiamos la caja
          $("#email").value = "";

          //redireccionamos hacia la formulario login, para que inicie sesión
          window.location.href = "./login.php";

        }
      }

      //al dar click en la "x" del modal de registro de codigo..
      $("#modal-cerrar").addEventListener("click", () => {
        modalCodeCerrar();
      });

      //al dar click en la "x" del modal de actualizar contraseña....
      $("#modalPass-cerrar").addEventListener("click",() => {
        modalPasswordCerrar();
        modalCodeCerrar();
      });

      //al dar click en el boton "submit" del formulario donde se ingresa el email....
      $("#form-usuario").addEventListener("submit", (event) => {

        //detenmos el evento "submit"
        event.preventDefault();
        const inputEmail = $("#email").value;
        console.log(inputEmail);
        getData(inputEmail);

      });


      //al dar click en el boton "submit" del formulario donde se ingresa el codigo....
      $("#form-code").addEventListener("submit", (event) => {
        event.preventDefault();
        validarCode();
      });

      //al dar click en el boton "submit" del formulario donde se se actualiza la contraseña....
      $("#form-password").addEventListener("submit", (event) => {
        event.preventDefault();
        validarPassword();
      });


    });
  </script>
</body>

</html>