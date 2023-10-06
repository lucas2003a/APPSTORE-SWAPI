<?php

require_once '../models/Categoria.php';

if (isset($_POST['operacion'])){

  $categoria = new Categoria();



  //¿Que operacion necesito?

  switch($_POST['operacion']){
    case 'listar':
      //El metodo listar retorna un array PHP asociativo, esto NO lo entiende el navegador
      //entonces, convertir el arreglo en un objeto JSON y lo enviamos a la vista
      //Terminos que se refieron a los datos = Asociativo
      echo json_encode($categoria->listarCategoria());
      //render: ENVIAR ETIQUETAS/DATOS NAVEGADOR
      break;
    case 'registrar';
      //Recolectar/recibir los valores enviados desde la vista
      $datosEnviar = [

        'categoria' => $_POST['categoria']
      ];
      //Enviamos el arreglo al método
      $categoria->registrarCategoria($datosEnviar);
      break;
  }

  
}

