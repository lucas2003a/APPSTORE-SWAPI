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
        <table class="table table-sm table-striped" id="tabla-usuarios">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Rol</th>
                    <th>Nacionalidad</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Operaciones</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    <!-- Modal trigger button -->
    <!--<button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#modal-avatar">
      Launch
    </button>-->
    
    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="modal-avatar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitleId">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Body
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
    
    
    <!-- Optional: Place to the bottom of scripts -->
    <!--<script>
      const myModal = new bootstrap.Modal(document.getElementById('modal-avatar'), options)
    
    </script>-->
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>

  <script>
    document.addEventListener('DOMContentLoaded',() => {

        const tabla = document.querySelector("#tabla-usuarios tbody");

        function listarUsuarios(){
          const parametros = new FormData();

          parametros.append("operacion","listar");

          fetch(`../../controllers/usuario.controller.php`,{
            method: 'POST',
            body: parametros
          })
          .then(result => result.json())
          .then(data =>{
            console.log(data);
            
            let numFila = 1;
            
            tabla.innerHTML = "";

            data.forEach(element => {
               
              let nuevaFila = ``;

              nuevaFila = `

                <td>${numFila}</td>
                <td><a 'href='#'> Ver más </td>
                <td>${element.rol}</td>
                <td>${element.nombrepais}</td>
                <td>${element.apellidos}</td>
                <td>${element.nombres}</td>
                <td>
                  <button class ='btn btn-danger btn-sm eliminar' data-idusurio="${element.idusuario}" type="button">Eliminar</button>
                  <button class ='btn btn-info btn-sm editar' data-idusurio="${element.idusuario}" type="button">Editar</button>
                </td>
               
              `;

              tabla.innerHTML += nuevaFila;
              numFila++;
          })
          .catch(e =>{
              console.error(e);
            });
          })
        }

        tabla.

        //Carga automática
        listarUsuarios();
    });
  </script>
</body>

</html>