 <?php
 require_once '../header2.php';
 ?>
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
          <div class="modal-header bg-info text-light">
            <h5 class="modal-title" id="modalTitleId">Modal title</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <img style ="width: 100%; max-height: 80%;" src="" alt="" id="visor-avatar">
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
                <td><a 'href='#' class='linkFoto' data-url='${element.avatar}' data-name='${element.nombres} ${element.apellidos}' data-bs-toggle="modal" data-bs-target="#modal-avatar">Ver avatar</td>
                <td>${element.rol}</td>
                <td>${element.nombrepais}</td>
                <td>${element.apellidos}</td>
                <td>${element.nombres}</td>
                <td>
                  <button class ='btn btn-danger btn-sm eliminar' data-idusuario="${element.idusuario}" type="button">Eliminar</button>
                  <button class ='btn btn-info btn-sm editar' data-idusuario="${element.idusuario}" type="button">Editar</button>
                </td>
               
              `;

              tabla.innerHTML += nuevaFila;
              numFila++;
            })
          })
          .catch(e =>{ 
              console.error(e);
            });
        }

        tabla.addEventListener("click",(event) => {

          if(event.target.classList.contains("linkFoto")){

            const ruta = event.target.dataset.url;
            console.log(event); 

            document.querySelector("#visor-avatar").setAttribute("src",`../../images/${ruta}`);

            const nombres = event.target.dataset.name;
            document.querySelector("#modalTitleId").innerText = nombres;
          }

          if(event.target.classList.contains("eliminar")){

            console.log("Cuidado con eliminar algo :)");

            const idusuario = event.target.dataset.idusuario;
            const parametros = new FormData();

            parametros.append("operacion","eliminar");
            parametros.append("idusuario",idusuario);

            if(confirm("¿Estas seguro de eliminar?")){

              fetch(`../../controllers/usuario.controller.php`,{
                method : 'POST',
                body: parametros
              })
                .then(result => result.json())
                .then(data => {
                  console.log(data);
                  listarUsuarios();
                })
                .catch(e => {
                  console.error(e);
                })
            }
          }
        });

        //Carga automática
        listarUsuarios();
    });
  </script>
</body>

</html>