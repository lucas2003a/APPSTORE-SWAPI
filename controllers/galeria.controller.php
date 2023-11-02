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
            
            // Directorio de destino
            $directorioDestino = "../images/";

            // Array para almacenar los nombres de archivo de las fotos
            $nombresArchivos = array();

            //ARRAY DE RESPUESTAS
            $respuetas = []; 

            if (isset($_FILES['rutafoto'])) {
                foreach ($_FILES['rutafoto']['tmp_name'] as $index => $tempName) {
                    $ahora = date("dmYhis");
                    $nombreArchivo = sha1($ahora . $index) . ".jpg";
                    $rutaCompleta = $directorioDestino . $nombreArchivo;
        
                    if (move_uploaded_file($tempName, $rutaCompleta)) {
                        $nombresArchivos[] = $nombreArchivo;
                        
                        $datosEnviar =[
            
                            "idproducto" => $_POST['idproducto'],
                            "rutafoto" => $nombreArchivo
                        ];
                        
                        $respuetas = $galeria->registrar($datosEnviar);
                    }
                }
            }

            echo json_encode($respuetas);

            

            /*if(move_uploaded_file($_FILES['rutafoto']['tmp_name'], "../images/" . $nombreArchivo)){
                $datosEnviar['rutafoto'] = $nombreArchivo;
            }*/

            break;
        
        case 'actualizar':

            $ahora = date("dmYhis");

            $nombreArchivo = sha1($ahora) . ".jpg";

            $datosEnviar =[
                "idgaleria" => $_POST['idgaleria'],
                "idproducto" => $_POST['idproducto'],
                "rutafoto" => $nombreArchivo,
            ];

            if(move_uploaded_file($_FILES['rutafoto']['temp_name'],"../images/" . ".jpg")){

                $datos['rutafoto'] = $nombreArchivo;
            }

            echo json_encode($galeria->actualizar($datosEnviar));

            break;
    }

}