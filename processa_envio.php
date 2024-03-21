<?php

require "./bibliotecas/PHPMailer/Exception.php";
require "./bibliotecas/PHPMailer/OAuth.php";
require "./bibliotecas/PHPMailer/POP3.php";
require "./bibliotecas/PHPMailer/SMTP.php";
require "./bibliotecas/PHPMailer/PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// print_r($_POST);

class Mensagem{
    private $destinatario = null;
    private $assunto = null;
    private $mensagem = null;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function validaMensagem(){
        if(empty($this->destinatario) || empty($this->mensagem)){
            return false;
        }else{
            return true;
        }
    }

    public function validaAssuntoVazio(){
        if(empty($this->assunto)){
            $assuntoVazio = true;
            return $assuntoVazio;
        }
    }

    public function mensagemValidada(){

    }
}

$mensagem = new Mensagem();
$mensagem->__set('destinatario', $_POST['destinatario']);
$mensagem->__set('assunto', $_POST['assunto']);
$mensagem->__set('mensagem', $_POST['mensagem']);


$mensagem->validaMensagem();
if(!$mensagem->validaMensagem()){
    echo 'Mensagem não é válida';
    header("Location: index.php?msg=erro");
}

$mensagem->validaAssuntoVazio();
if($mensagem->validaAssuntoVazio() && $mensagem->validaMensagem()){
    header("Location: index.php?msg=assuntovazio");
}

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';   //preencha este campo com email outlook                  //SMTP username
    $mail->Password   = '';  //preencha com a senha do email                             //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  //STARTTLS       //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('apps3ndma1l@outlook.com', 'App Send Mail');
    $mail->addAddress($mensagem->__get('destinatario'), 'Send Mail');     //Add a recipient
    // $mail->addAddress('ellen@example.com');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $mensagem->__get('assunto');
    $mail->Body    = $mensagem->__get('mensagem');
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    header("Location: index.php?msg=enviado");
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
