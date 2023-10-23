<?php

require_once 'Conexion.php';

class Usuario extends Conexion{

    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

    public function listar(){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_listar()");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_registrar(?,?,?,?,?,?,?)");
            $consulta->execute(array(

                $datos['avatar'],
                $datos['idrol'],
                $datos['idnacionalidad'],
                $datos['apellidos'],
                $datos['nombres'],
                $datos['email'],
                $datos['claveacceso'],
                
            ));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminar($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_eliminar(?)");
            $status = $consulta->execute(
                array(
                    $datos['idusuario']
                )
            );

            return $status;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}