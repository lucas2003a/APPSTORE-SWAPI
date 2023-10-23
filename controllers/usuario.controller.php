<?php

require_once '../models/Usuario.php';

    $usuario = new Usuario();

if(isset($_POST['operacion'])){

    switch($_POST['operacion']){

        case 'listar':
            echo json_encode($usuario->listar());

            break;
        
            case 'registrar':

                $datosForm =[
                    'avatar'    => '',
                    'idrol'     => $_POST['idrol'],
                    'idnacionalidad'  => $_POST['idnacionalidad'],
                    'apellidos' => $_POST['apellidos'],
                    'nombres'   => $_POST['nombres'],
                    'email'     => $_POST['email'],
                    'claveacceso'  => $_POST['claveacceso'],
                ];
                
                echo json_encode($usuario->registrar($datosForm));
    }
}