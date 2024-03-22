<?php

require "bibliotecas/PHPMailer/Exception.php";
require "bibliotecas/PHPMailer/OAuth.php";
require "bibliotecas/PHPMailer/POP3.php";
require "bibliotecas/PHPMailer/SMTP.php";
require "bibliotecas/PHPMailer/PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// print_r($_POST);

class Mensagem{
    private $destinatario = null;
    private $assunto = null;
    private $mensagem = null;
    public $status = array('codigo_status' => null, 'descricao_status' => '');

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

$mail = new PHPMailer(true);
try {
    //Server settings
    $mail->SMTPDebug = false;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-mail.outlook.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = '';   //preencha este campo com seu email outlook                  //SMTP username
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
    // echo 'Message has been sent';
} catch (Exception $e) {
    // echo "Estamos com um problema e não foi possível enviar este email! Tente novamente  mais tarde. <br>Detalhes: {$mail->ErrorInfo}";
}

?>

<html>
<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	</head>

	<body>
        <div class="container">

            <div class="py-3 text-center">
                <img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
                <h2>Send Mail</h2>
                <p class="lead"><b>Seu</b> app de envio de e-mails particular!</p>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <h1 class="display-4 text-danger">Erro!</h1>
                    <p>
                        Estamos com um problema e não foi possível enviar este email! Tente novamente  mais tarde.
                    </p>
                    <?php echo "Detalhes:<br>{$mail->ErrorInfo}" ?>
                </div>
            </div>
            
            <div class="mt-4">
                <a href="index.php" class="btn btn-primary">Voltar</a>
            </div>

        </div>
    <body>
</html>