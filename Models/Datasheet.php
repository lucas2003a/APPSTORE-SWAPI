<?php

require_once 'Conexion.php';

class Datasheet extends Conexion{

    private $conexion;

    public function __construct()
    {
        $this->conexion = parent::getConexion();
    }

    public function listar($datos = []){

        try{
            $consulta = $this->conexion->prepare("call spu_datasheet_listar(?)");
            $consulta->execute(
                array(
                    $datos['idproducto']
                )
            );

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}