<?php

require_once "Conexion.php";

//MODELO = contiende la logica
//extends : Herencia (PDO) en PHP
class Producto extends Conexion{

  // Objeto que almacene la conexion que viene desde el padre(Conexion) y la compartira con todos los metodos (CRUD+)
  private $conexion;

  //Constructor, INICIALIZAR
  public function __CONSTRUCT(){
    $this->conexion = parent::getConexion(); // El valor de retorno (getConexion) de esta funcion ha sido asignada a este objeto (conexion)
  }

  //Metodo listar 
  public function listar(){


    try {
      // 1. Preparamos la consulta
      $consulta = $this->conexion->prepare("CALL spu_productos_listar()");
      // 2. Ejecutamos la consulta
      $consulta->execute();
      // 3. Devolvemos la consulta(array asociativo)
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e){
      die($e->getMessage()); //Desarrollo > Producción
    }
  }

  public function registrar($datos = []){

    try {
      $consulta = $this->conexion->prepare("CALL spu_productos_registrar(?,?,?,?,?)");
      $consulta->execute(
        array(
          $datos['idcategoria'],
          $datos['descripcion'],
          $datos['precio'],
          $datos['garantia'],
          $datos['fotografia'],
        )
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
      
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }

  
  public function eliminar($datos = []){
    try{

      $consulta = $this->conexion->prepare("call spu_products_eliminar(?)");
      $status = $consulta->execute(
        array(
          $datos['idproducto']
        )
      );
      return $status;

    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }



  public function listarOfertasCat($datos = []){
    try{
        $conexion = $this->conexion->prepare("call spu_products_categoria(?)");
        $conexion->execute(
          array(
            $datos['idcategoria']
          )
        );
        
        return $conexion->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  
}

/*Prueba - Borrar!!!
$producto = new Producto();
echo"<pre>";
var_dump($producto->listarProductos());
echo "</pre>";*/