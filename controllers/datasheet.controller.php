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
    }
}