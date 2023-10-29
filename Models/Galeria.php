<?php

require_once 'Conexion.php';

class Galeria extends Conexion{

    private $conexion;

    public function __CONSTRUCT(){

        $this->conexion = parent::getConexion();
    }

    public function getGaleria($datos=[]){

        try{
            $consulta = $this->conexion->prepare("call spu_galeria_listar(?)");
            $consulta->execute(array(

                    $datos['idproducto']
                )
            );

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrar($datos=[]){
        try{
            $consulta = $this->conexion->prepare("call spu_galeria_registrar(?,?)");
            $consulta->execute(
                array(
                    $datos['idproducto'],
                    $datos['rutafoto'],
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function actualizar($datos=[]){
        try{
            $consulta = $this->conexion->prepare("call spu_galeria_actualizar(?,?,?)");
            $consulta->execute(
                array(
                    $datos['idgaleria'],
                    $datos['idproducto'],
                    $datos['rutafoto'],
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

}