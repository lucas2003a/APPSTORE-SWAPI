<?php

require_once 'Conexion.php';

class Nacionalidad extends Conexion{

    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

    public function listar(){
        try{
            $consulta = $this->conexion->prepare("call spu_listar_nacionalidades()");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);

        }catch(Exception $e){
            die($e->getMessage());
        }
    }
}