<?php

date_default_timezone_set("America/Lima");

require_once '../Models/Galeria.php';

if(isset($_POST['operacion'])){

    $galeria = new Galeria();

    switch($_POST['operacion']){
        
        case 'obtener':

            $datosEnviar = [
                "idproducto" => $_POST['idproducto']
            ];

            echo json_encode($galeria->getGaleria($datosEnviar));
            break;
        
        case 'registrar':

            $ahora = date("dmYhis");

            $nombreArchivo = sha1($ahora) . ".jpg";

            $datosEnviar =[

                "idprodcuto" => $_POST['iproducto'],
                "rutafoto" => $nombreArchivo
            ];

            if(move_uploaded_file($_FILES['rutafoto']['temp_name'], "../images/" . ".jpg")){
                $datos['rutafoto'] = $nombreArchivo;
            }

            
            echo json_encode($galeria->registrar($datosEnviar));
            break;
        
        case 'actualizar':

            $ahora = date("dmYhis");

            $nombreArchivo = sha1($ahora) . ".jpg";

            $datosEnviar =[
                "idgaleria" => $_POST['idgaleria'],
                "idprodcuto" => $_POST['iproducto'],
                "rutafoto" => $nombreArchivo,
            ];

            if(move_uploaded_file($_FILES['rutafoto']['temp_name'],"../images/" . ".jpg")){

                $datos['rutafoto'] = $nombreArchivo;
            }

            echo json_encode($galeria->actualizar($datosEnviar));

            break;
    }

}