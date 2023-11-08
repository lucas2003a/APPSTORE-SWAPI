<?php

//1.-Componente COMPOSER
require_once '../../vendor/autoload.php';

//2.-Nanmespaces
use Spipu\Html2Pdf\Html2Pdf; //CORE => nucleo   

//Control de exepciones
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

try{
    //Intentar => acciones que deseamos ejecutar
    //3.-Instancia
    //En el constructor vamos a colocar (Orienteación[Portrait | Landscape],TipoPapel, idioma)
    $reporte = new Html2Pdf("P","A4","es");
    $reporte->setDefaultFont("Arial");

    $reporte->writeHTML("<h1>Hola mundo</h1>");

    $reporte->output("SENATI.pdf");

}
catch(Html2PdfException $e){
    //Error => debemos realizar alguna acción
    $reporte->clean();

    //Formateamos el error y lo guardamos en un objeto
    $datosError = new ExceptionFormatter($e);

    //Mostramos el error en el navegador
    echo $datosError->getHtmlMessage();
}


//4.-Escribir (Enviar información)
//$reporte->writeHTML("<h1>Hola mundo</h1>");

//5.-Exportar el contenido como PDF
//$reporte->output();