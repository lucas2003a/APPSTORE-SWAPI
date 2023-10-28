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

</head>

<body>


    <input type="" id="idproducto" name="idproducto">

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

        function $(id){
            return document.querySelector(id)
        }

        const newID = idobtenido;

        $("#idproducto").value = newID;

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

                        console.log("no hay info")
                    }else{
                        
                        console.log(data);
                    }
                })
                .catch(e =>{
                    console.error(e);
                });
        }

        //CARGA AUTOMATICA
        getDatasheet();

    });
  </script>
</body>

</html>