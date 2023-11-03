<?php

//TAREA: TERMINAR DE HACER LA FUNCION PARA ENVIAR MENSAJES
function sendEmail($emailDestino ="", $asunto="", $mensaje=""  ){


}
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$estado = ["enviado" => false];

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'lucasatuncar1@gmail.com';                     //SMTP username
    $mail->Password   = 'okbnitfdorbgapls';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('lucasatuncar1@gmail.com', 'Admin');
    //$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('1392696@senati.pe');               //Name is optional //mi correo senati
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Ejemplo correo';
    $mail->Body    = '<h1>Hola</h1> 
        <p>Este mensaje contiene</p> 
        <img src="https://static.mercadonegro.pe/wp-content/uploads/2017/10/27160609/22815135_916150281870460_820360796721820140_n.jpg">
        <h3>Formato</h3>';
    $mail->AltBody = 'Hola este mensaje no contiene formato';

    $mail->send();
    //echo 'Message has been sent';
    $estado["enviado"] = true;
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    $estado["enviado"] = false;
}
echo json_encode($estado);