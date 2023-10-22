<?php

//Configurar la zona local
date_default_timezone_set("America/Lima");

require_once '../models/Producto.php';

if (isset($_POST['operacion'])){

  $producto = new Producto();



  //¿Que operacion necesito?

  switch($_POST['operacion']){
    case 'listar':
      //El metodo listar retorna un array PHP asociativo, esto NO lo entiende el navegador
      //entonces, convertir el arreglo en un objeto JSON y lo enviamos a la vista
      //Terminos que se refieron a los datos = Asociativo
      echo json_encode($producto->listarProductos());
      //render: ENVIAR ETIQUETAS/DATOS NAVEGADOR
      break;
    case 'registrar';
      //Generar un nombre a partir del momento exacto
      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora) . ".jpg";
      
      // Recolectar / recibir los valores enviados desde la vista
      $datosEnviar = [
        'idcategoria'   => $_POST['idcategoria'],
        'descripcion'   => $_POST['descripcion'],
        'precio'        => $_POST['precio'],
        'garantia'      => $_POST['garantia'],
        //'fotografia'    => ""
        'fotografia'    => $nombreArchivo
      ];

       if(move_uploaded_file($_FILES['fotografia']['tmp_name'],"../images/" . $nombreArchivo));{
          // Enviamos el aareglo al método
          $datosEnviar["fotografia"] = $nombreArchivo;
          //var_dump($_FILES['fotografia']);
        }
      
        echo json_encode($producto->registrar($datosEnviar));

      break;

    case 'eliminar':
      $datosEnviar = ["idproducto" => $_POST['idproducto']];
      echo $producto-> eliminar($datosEnviar);

      break;
  }

  
}

