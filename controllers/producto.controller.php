<?php

//Configurar la zona local
date_default_timezone_set("America/Lima");

require_once '../models/Producto.php';

if (isset($_POST['operacion'])){

  $producto = new Producto();

  // ¿Que operación es?
  switch ($_POST['operacion']) {
    case 'listar':
      // EL método listar retorna un array PHP asociativo, esto no lo entiende el navegador
      // Entonces convertimos el arreglo en un objeto JSON y lo enviamos a la vista.
      echo json_encode($producto->listar());
      // render... ENVIAR ETIQUETAS / DATOS NAVEGADOR
      break;
      
    case 'registrar':
      //Generar un nombre a partir del momento exacto
      $ahora = date('dmYhis');
      $nombreArchivo = sha1($ahora) . ".jpg";
      
      // Recolectar / recibir los valores enviados desde la vista
      $datosEnviar = [
        'idcategoria'   => $_POST['idcategoria'],
        'descripcion'   => $_POST['descripcion'],
        'precio'        => $_POST['precio'],
        'garantia'      => $_POST['garantia'],
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
    
    case 'listarOfertasCat':
      
      $datosEnviar = [
        "idcategoria" => $_POST['idcategoria']
      ];

      echo json_encode($producto->listarOfertasCat($datosEnviar));

      break;

    case 'obtener':

      $datosEnviar=[
        "idproducto" => $_POST['idproducto']
      ];

      echo json_encode($producto->getProducto($datosEnviar));
      break;

    case 'actualizar':

      $ahora = date("dmYhis");
      $nombreArchivo = sha1($ahora) . ".jpg";

      $datosEnviar = [
        "idproducto"  => $_POST['idproducto'],
        "idcategoria" => $_POST['idcategoria'],
        "descripccion"=> $_POST['descripccion'],
        "precio"      => $_POST['precio'],
        "garantia"    => $_POST['garantia'],
        "fotografia"  => $nombreArchivo,
      ];

      if(move_uploaded_file($_FILE['fotografia']['temp_name'],"../images/" . +$nombreArchivo));{

        $datosEnviar['fotografia'] = $nombreArchivo;
      }

      echo json_encode($producto->actualizarProducto($datosEnviar));
      
      break;
  }

}