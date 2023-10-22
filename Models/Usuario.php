<?php

require_once 'Conexion.php';

class Usuario extends Conexion{

    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

    public function listar(){
        try{
            $consulta = $this->conexion->prepare("call spu_listar_usuarios()");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_registrar_usuarios(?,?,?,?,?,?,?)");
            $consulta->execute(array(
                $datos['avatar'],
                $datos['idrol'],
                $datos['idnacionalidad'],
                $datos['apellidos'],
                $datos['nombres'],
                $datos['email'],
                $datos['claveacceso'],
            ));
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminar($datos = []){
        try{
            $consulta = $this->conexion->preapare("call spu_eliminar_usuario(?)");
            $status = execute(
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