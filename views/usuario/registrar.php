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
    <div class="container mt-3">
        <form action="" atocomplite="off" id="form-usuario">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    registrp de usuarios
                </div>
                <div class="card-body">
                    <div class="mt-2">
                        <label for="avatar" class="from-label">Avatar</label>
                        <input type="file" class="form-control" id="avatar" accpet=".jpg">
                    </div>
                    <div class="mt-2">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" class="form-select" id="rol">
                            <option value="">Seleccione</option>
                            <option value="1">otros</option>
                        </select required>
                            
                    </div>
                    <div class="mt-2">
                        <label for="nacionalidad" class="form-label">Nacionalidad</label>
                        <select name="" id="nombrepais" class="form-select" required>
                            <option value="">Seleccione</option>
                            <option value="1">otros</option>
                        </select>
                    </div>
                    <div class="mt-2">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text"class="form-control" id="apellidos" required>
                    </div>
                    <div class="mt-2">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" required>
                    </div>
                    <div class="mt-2">
                        <label for="email" cñass="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mt-2">
                        <label for="claveacceso" cñass="form-label">Contraseña: </label>
                        <input type="password" class="form-control" id="claveacceso" required>
                    </div>
                </div>
                <div class="card-footer text-muted mt-2">
                    <button class="btn btn-primary bnt-sm" type="submit" id="guardar">Guardar</button>
                </div>
            </div>
        </form>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {

        function $(id){
            return document.querySelector(id);
        }
        
        function getNacionalidad(){
            const parametros = new FormData();
            parametros.append("operacion","listar");

            fetch(`../../controllers/nacionalidad.controller.php`,{
                method: "POST",
                body: parametros

            })
                .then(result => result.json())
                .then(data =>{
                    data.forEach(element => {
                      const tagOption = document.createElement("option");
                      tagOption.value = element.idnacionalidad;
                      tagOption.innerText = element.nombrepais  ;
                      $("#nombrepais").appendChild(tagOption);
                    });
                })
                .catch(e =>{
                    console.error(e)
                })
        }

        function usuarioRegister(){

            const parametros = new FormData();
            parametros.append("operacion","registrar");
            parametros.append("avatar",$("#avatar").files[0]);
            parametros.append("rol",$("#rol").value);
            parametros.append("nombrepais",$("#nombrepais").value);
            parametros.append("apellidos",$("#apellidos").value);
            parametros.append("nombres",$("#nombres").value);
            parametros.append("email",$("#email").value);
            parametros.append("claveacceso",$("#claveacceso").value);

            fetch(`../../controllers/usuario.controller.php`,{
                method:"POST",
                body: parametros
            })
                .then(result => result.json())
                .then(data => {
                    console.log(datos);

                    if(datos.idusuario > 0){
                        alert(`Usuario registrado con ID:+ ${datos.idusuario}`)
                        $("#form-usuario").reset();
                    }
                })
                .catch(e => {
                    console.error(e);
                });
        }

        $("#form-usuario").addEventListener("submit",(event) =>{
            event.preventDefault();

            if(confirm("¿Estas seguro de guardar?")){
                usuarioRegister();
            }
        })

        getNacionalidad();
    })
  </script>
</body>

</html>