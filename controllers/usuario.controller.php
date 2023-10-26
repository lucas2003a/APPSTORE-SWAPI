<?php
session_start();
//Configurar la zona local
date_default_timezone_set('America/Lima');

require_once '../models/Usuario.php';

    $usuario = new Usuario();

if(isset($_POST['operacion'])){

    switch($_POST['operacion']){

        case 'listar':
            echo json_encode($usuario->listar());

            break;

        case 'registrar':

            //Generando el nombre del avatar
            $ahora = date('dmYhis');
            $nombreArchivo = sha1($ahora) . ".jpg";

            $datosForm = [

                "avatar"            => $nombreArchivo,
                "idrol"             =>$_POST['idrol'],
                "idnacionalidad"    =>$_POST['idnacionalidad'],
                "apellidos"         =>$_POST['apellidos'],
                "nombres"           =>$_POST['nombres'],
                "email"             =>$_POST['email'],
                "claveacceso"       =>password_hash($_POST['claveacceso'],PASSWORD_BCRYPT),
            ];

            if(move_uploaded_file($_FILES['avatar']['tmp_name'],"../images/" . $nombreArchivo)){
                
                //Enviamos el arreglo al método
                $datosForm['avatar'] = $nombreArchivo;
            }

            echo json_encode($usuario->registrar($datosForm));

            break; 
        
        case 'eliminar':

            $datosForm = [
                "idusuario" => $_POST['idusuario']
            ];

            echo json_encode($usuario->eliminar($datosForm));

            break;
        
        case 'login':

            $datosEnviar = [
                "email" => $_POST['email']
            ];

            $statusLogin = [
                "acceso"    => false,
                "mensaje"   => ""
            ];

            $registro = $usuario->login($datosEnviar);

            if($registro == false){

                $_SESSION["status"] = false;
                $statusLogin["mensaje"] = "El correo no existe";
            }else{

                $ClaveEncriptada = $registro['claveacceso'];
                $_SESSION["idusuario"] = $registro["idusuario"];
                $_SESSION["rol"] = $registro["rol"];
                $_SESSION["apellidos"] = $registro["apellidos"];
                $_SESSION["nombres"] = $registro["nombres"];

                if(password_verify($_POST['claveacceso'],$ClaveEncriptada)){

                    $_SESSION["status"] = true;
                    $statusLogin["acceso"] = true;
                    $statusLogin["mensaje"] = "Acceso correcto";
                }else{
                    $_SESSION["status"] = false;
                    $statusLogin["mensaje"]  = "La contraseña es incorrecta";
                }
            }

            echo json_encode($statusLogin);

        break;
        
    }

}

if(isset($_GET['operacion'])){
        
    if($_GET['operacion'] == 'destroy'){

        session_destroy();
        session_unset();

        header("Location:../index.php");
    }
 }

