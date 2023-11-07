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

    public function login($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_login(?)");
            $consulta->execute(
                array(
                    $datos['email']
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * función para registrar el código generado, en la base de datos
     * @param $datos['idusuario']
     * @param $datos['codigo']
     */
    public function insertCode($datos =[]){
        try{
            $consulta = $this->conexion->prepare("call spu_codigos_registrar(?,?)");
            $consulta->execute(
                array(
                    $datos['idusuario'],
                    $datos['codigo']
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * función para obtener todos los datos de un registro correspondiente de un usuario
     * @param $datos['email']
     */
    public function getUsuarioEmail($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuariosEmail_get(?)");
            $consulta->execute(
                array(
                    $datos['email']
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
    
    /**
     * función para para borrar solo el cosigo de un usuario correspodiente, mediante e ID
     * @param $datos['idusuario']
     */
    public function deleteCode($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_codigos_eliminar(?)");
            $consulta->execute(
                array(
                    $datos['idusuario']
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    /**
     * función para actualizar la constraseña de un usuario mediante su ID
     * @param $datos['idusuario']
     * @param $datos['claveacceso']
     */
    public function setPassword($datos = []){

        try{
            $consulta = $this->conexion->prepare("call spu_set_password(?,?)");
            $consulta->execute(
                array(
                    $datos['idusuario'],
                    $datos['claveacceso'],
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}
