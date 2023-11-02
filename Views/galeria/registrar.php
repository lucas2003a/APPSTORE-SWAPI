<!doctype html>
<html lang="es">

<head>
  <title>Registro de hoja fotos</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <div class="container mt-4">
    <form action="" id="form-galeria">
      <div class="card">
        <div class="card-header text-end bg-primary text-light">
          Fomulario galería
        </div>
          <div class="card-body">
            <div class="m-2">
              <label for="" class="form-label">Producto</label>
              <select name="idproducto" id="idproducto" class="form-select" required>
                <option value="">Seleccione</option>
              </select>
            </div>
            <div class="m-2">
              <label for="" class="form-label">Fotografía</label> 
              <input type="file" id="rutafoto" class="form-control" accept=".jpg" multiple required>
            </div>
        </div>
        <div class="card-footer text-muted text-end">
          <button type="submit" class="btn btn-primary btn-sm" id="guardar">Guardar</button>
        </div>
      </div>

    </form>
  </div>
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

      function getProductos(){

        const parametros = new FormData();
        parametros.append("operacion","listar");

        fetch(`../../controllers/producto.controller.php`,{
          method:"POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data => {
            console.log(data)

            data.forEach(element => {
              
              SelectOption = document.createElement("option");
              SelectOption.value = element.idproducto;
              SelectOption.innerText = element.descripcion;

              $("#idproducto").appendChild(SelectOption);
            });
          })
          .catch(e => {
            console.error(e);
          });
      }

      function validarFotos(){

        const fotos = $("#rutafoto")

        if(fotos.files.length > 10){

          alert("Solo puedes elegir 10 fotos");

        }else{
          insertGaleria();
        }
      }

      function insertGaleria(){

        const parametros = new FormData();
        parametros.append("operacion","registrar");
        parametros.append("idproducto",$("#idproducto").value);
        console.log($("#idproducto").value);
        const inputFotografia = $("#rutafoto");

        const fotosSeleccionadas = inputFotografia.files;

        for(let i = 0; i < Math.min(10, fotosSeleccionadas.length); ++i){
          parametros.append("rutafoto[]",fotosSeleccionadas[i])
        }

        fetch(`../../controllers/galeria.controller.php`,{
          method:"POST",
          body: parametros
        })
          .then(result => result.json())
          .then(data =>{
            alert("Se registrò correctamente");
          })
          .catch(e => {
            console.error(e);
          });

      }

      $("#form-galeria").addEventListener("submit", (event) => {
        event.preventDefault();
        validarFotos()
      });
      getProductos();
/*
        fetch()
          .then()
          .then()
          .catch();
           */

    });
  </script>
</body>

</html>