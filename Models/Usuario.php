<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';
require_once 'Conexion.php';

class Usuario extends Conexion{

    private $conexion;

    public function __CONSTRUCT(){
        $this->conexion = parent::getConexion();
    }

    //Create an instance; passing `true` enables exceptions
    //TAREA: TERMINAR DE HACER LA FUNCION PARA ENVIAR MENSAJES
    //$emailDestino ="", $asunto="", $mensaje=""  
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

    //$numero = "", $mensaje = ""
    public function sendSMS($datos=[]){

        $token = "NjAwNjQ5Mjg4NjoyNDg5MjE5QkNFNUM=";
        $autorization = "Authorization: Bearer ".$token;
        $fields_string = "";
        $smsnumber = $datos['telefono'];
        $smstext = $datos['mensaje'];
        $smstype = "1"; // 0: remitente largo, 1: remitente corto
        $shorturl = "0"; // acortador URL
        
        //Preparamos las variables que queremos enviar
        $url = 'https://api3.gamanet.pe/token/smssend';
        $fields = array(
                                'smsnumber'=>urlencode($smsnumber),
                                'smstext'=>urlencode($smstext),
                                'smstype'=>urlencode($smstype),
                                'shorturl'=>urlencode($shorturl)
                        );
        
        //Preparamos el string para hacer POST (formato querystring)
        foreach($fields as $key=>$value) { 
               $fields_string .= $key.'='.$value.'&'; 
        }
        $fields_string = rtrim($fields_string,'&');
        
        
        //abrimos la conexion
        $ch = curl_init();
        
        //configuramos la URL, numero de variables POST y los datos POST
        curl_setopt($ch,CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded', $autorization));
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false); //Descomentarlo si usa HTTPS
        curl_setopt($ch,CURLOPT_POST,count($fields));
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
        
        //ejecutamos POST
        $result = curl_exec($ch); //$result es un JSON
        
        //cerramos la conexion
        curl_close($ch);
        
        //Resultado
        //json_encode() : objeto > json
        //json_decode() : json < objeto
        //$array = json_decode($result,true);
        return $result;
        
        //echo "error:".$array["message"];
        //echo "uniqueid:".$array["uniqueid"];          
    }
    
              
    public function listar(){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_listar()");
            $consulta->execute();

            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function registrar($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_registrar(?,?,?,?,?,?,?)");
            $consulta->execute(array(

                $datos['avatar'],
                $datos['idrol'],
                $datos['idnacionalidad'],
                $datos['apellidos'],
                $datos['nombres'],
                $datos['email'],
                $datos['claveacceso'],
                
            ));

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function eliminar($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_eliminar(?)");
            $status = $consulta->execute(
                array(
                    $datos['idusuario']
                )
            );

            return $status;
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function login($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_usuarios_login(?)");
            $consulta->execute(
                array(
                    $datos['email']
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function insertCode($datos =[]){
        try{
            $consulta = $this->conexion->prepare("call spu_codigos_registrar(?,?)");
            $consulta->execute(
                array(
                    $datos['idusuario'],
                    $datos['codigo']
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }

    public function getCode($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_codigos_obtener(?)");
            $consulta->execute(
                array(
                    $datos['campocriterio']
                )
            );

            return $consulta->fetch(PDO::FETCH_ASSOC);
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
    
    public function deleteCode($datos = []){
        try{
            $consulta = $this->conexion->prepare("call spu_codigos_eliminar(?)");
            $consulta->execute(
                array(
                    $datos['idusuario']
                )
            );
        }
        catch(Exception $e){
            die($e->getMessage());
        }
    }
}
/*
$resultado = sendSMS("982253594","Estamos probando mensajes API");
echo "<pre>";
var_dump($resultado);
echo "</pre>";
**/