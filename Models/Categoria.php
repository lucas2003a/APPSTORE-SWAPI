<?php

require_once "Conexion.php";

//MODELO = contiende la logica
//extends : Herencia (PDO) en PHP
class Categoria extends Conexion{

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
      $consulta = $this->conexion->prepare("CALL spu_categorias_listar()");
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
      $consulta = $this->conexion->prepare("CALL spu_categorias_registrar(?)");
      $consulta->execute(
        array(
          $datos['categoria']
        )
      );
    } catch (Exception $e) {
      die($e->getMessage());
    }
  }


  
}

/*Prueba - Borrar!!!
$producto = new Producto();
echo"<pre>";
var_dump($producto->listarProductos());
echo "</pre>";*/