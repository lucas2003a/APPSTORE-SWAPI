<!doctype html>
<html lang="es">

<head>
  <title>Ristro de hoja de información</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
 <div class="container m-4">
    <form action="" id="form-datasheet">
        <div class="card">
            <div class="card-header bg-primary text-light text-end">
                <strong calss="">Añadir DataSheet</strong>
            </div>
            <div class="card-body m-4">
                <div class="m-4">
                    <label for="idproducto" class="form-label" name="idproducto">Clave</label>
                    <select name="idproducto" id="idproducto" class="form-select" required>
                        <option value="">Seleccione</option>
                    </select>
                </div>
                <div class="m-4">
                    <label for="clave" class="form-label" name="clave">Clave</label>
                    <input type="text" class="form-control" id="clave" name="clave" required>
                </div>
                <div class="m-4">
                    <label for="valor" class="form-label" name="valor">Valor</label>
                    <textarea class="form-control" name="valor" id="valor" cols="30" rows="10" required></textarea>
                </div>  
            </div>
            <div class="card-footer text-end">
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
            parametros.append("operacion","listar") ;

            fetch(`../../controllers/producto.controller.php`,{
            method:"POST",
            body: parametros
            })
                .then(result => result.json())
                .then(data =>{
                    console.log(data);

                    
                    data.forEach(element => {
                        
                        SelectOption = document.createElement("option");
                        SelectOption.value =  element.idproducto;
                        SelectOption.innerText = element.descripcion;

                        $("#idproducto").appendChild(SelectOption);
                    });
                })
                .catch(e => {
                    console.error(e);
                });
        }

        function insertDatasheet(){

            const parametros = new FormData();

            parametros.append("operacion","registrar");
            parametros.append("idproducto",$("#idproducto").value);
            parametros.append("clave",$("#clave").value);
            parametros.append("valor",$("#valor").value);

            fetch(`../../controllers/datasheet.controller.php`,{
                method:"POST",
                body: parametros
            })
            .then(result => result.json())
            .then(data => {
                alert("registrado correctamente");
                $("#form-datasheet").reset();
            })
            .catch(e =>{
                console.error(e);
            });

        }

        $("#form-datasheet").addEventListener("submit",(event) =>{
            event.preventDefault();
            insertDatasheet();
        });

        getProductos();
    });


    /*
            fetch(``,{})
            .then()
            .then()
            .catch();*/
  </script>
</body>

</html>