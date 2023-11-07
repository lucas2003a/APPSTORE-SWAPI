<?php
session_start();
//Configurar la zona local
date_default_timezone_set('America/Lima');

require_once '../models/Usuario.php';
require_once '../models/Sms.php';
require_once '../models/Email.php';

    $usuario    = new Usuario();
    $sms        = new Sms();
    $email      = new Email();

    $codigo = rand(100000,999999);

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

        case 'registrarCD':

            $datosEnviar=[
                "idusuario" => $_POST['idusuario'],
                "codigo" => $codigo
            ];

            echo json_encode($usuario->insertCode($datosEnviar));

            break;

        case 'getUsuarioEmail':

            $datosEnviar=[
                "email" => $_POST['email']
            ];

            $statusForm = [

                "status" => false,
                "mensaje" => ""
            ];

            $registro = $usuario->getUsuarioEmail($datosEnviar);

            if(!$registro){

                $statusForm["mensaje"] = "Email incorrecto, vuelva a ecribir";
            }else{
                $statusForm["status"] = true;
                $statusForm["mensaje"] = "Email encontrado";
            }

            $result = [$statusForm,$registro];

            echo json_encode($result);
            //echo json_encode($registro);
            //echo json_encode($statusForm);

            break;
        
        case 'eliminarCD':
            $datosEnviar=[
                "idusuario" => $_POST['idusuario'],
            ];

            echo json_encode($usuario->deleteCode($datosEnviar));

            break;

        case 'sendSMS':
            $datosEnviar=[
                "telefono" => $_POST['telefono'],
                "mensaje" => $_POST['mensaje']
            ];

            echo json_encode($sms->sendSMS($datosEnviar));
            break;
        
        case 'sendEmail':


            $datosEnviar=[
                "emailDestino" => $_POST['emailDestino'],
                "asunto" => "recuperacion de contraseña",
                "mensaje" => $_POST['mensaje']
            ];

            $email->sendEmail($datosEnviar);
            break;

        case 'setPassword':

            $datosEnviar = [
                "idusuario" => $_POST['idusuario'],
                "claveacceso" => password_hash($_POST['claveacceso'],PASSWORD_BCRYPT)
            ];

            echo json_encode($usuario->setPassword($datosEnviar));
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

