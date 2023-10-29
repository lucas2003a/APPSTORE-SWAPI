<?php

require_once '../Models/Datasheet.php';

if(isset($_POST['operacion'])){

    $datasheet = new Datasheet();

    switch($_POST['operacion']){

        case 'listar':

            $datosEnviar =[
                "idproducto" => $_POST['idproducto']
            ];

            echo json_encode($datasheet->listar($datosEnviar));

            break;
        
        case 'registrar':

            $datosEnviar=[
                "idproducto"    => $_POST['idproducto'],
                "clave"         => $_POST['clave'],
                "valor"         => $_POST['valor'],
            ];

            echo json_encode($datasheet->registrar($datosEnviar));

            break;

        case 'actualizar':

            $datosEnviar=[
                "idespecificacion"    => $_POST['idespecificacion'],
                "idproducto"    => $_POST['idproducto'],
                "clave"         => $_POST['clave'],
                "valor"         => $_POST['valor'],
            ];

            echo json_encode($datasheet->actualizar($datosEnviar));
            break;
    }
}