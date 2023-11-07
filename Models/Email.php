<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

class Email{

    //Create an instance; passing `true` enables exceptions
    //TAREA: TERMINAR DE HACER LA FUNCION PARA ENVIAR MENSAJES
    //$emailDestino ="", $asunto="", $mensaje=""  
    /**
     * Función que unicamente envia Emails
     * @param $datos['emailDestino']
     * @param $datos['asunto']
     * @param $datos['mensaje']
     */
    public function sendEmail($datos = []){

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
        $mail->addAddress($datos['emailDestino']);               //Name is optional //mi correo senati
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
    
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $datos['asunto'];
        $mail->Body    = $datos['mensaje'];
        $mail->AltBody = 'Hola este mensaje no contiene formato';
    
        $mail->send();
        //echo 'Message has been sent';
        $estado["enviado"] = true;
        } 
        catch (Exception $e) {
        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        $estado["enviado"] = false;
        }
        echo json_encode($estado);
    }

}

