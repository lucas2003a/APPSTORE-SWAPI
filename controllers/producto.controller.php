<?php

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
      //Recolectar/recibir los valores enviados desde la vista
      $datosEnviar = [
        'idcategoria' => $_POST['idcategoria'],
        'descripcion' => $_POST['descripcion'],
        'precio'      => $_POST['precio'],
        'garantia'    => $_POST['garantia'],
        'fotografia'  => $_POST['fotografia']
      ];
      //Enviamos el arreglo al método
      $producto->registrar($datosEnviar);
      break;
  }

  
}

