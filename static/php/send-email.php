<?php
// Replace this with your own email address
include("../../config/basic.php");
$to = EMAIL_TO_RECEIVE;

function url()
{
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $arquivo_phpmailer = UrlPadraoDocumento . "/app/PHPMailer/Autoload.php";
} else {
    $arquivo_phpmailer = UrlPadraoDocumento . "/seguro-de-carga/app/PHPMailer/Autoload.php";
}
require($arquivo_phpmailer);
$test = new SendEmail();
$mail = $test->Conecta();

// Charset para evitar erros de caracteres
$mail->Charset = 'UTF-8';
// Dados de quem está enviando o email
$mail->From = 'PsiuDev@gmail.com';
$mail->FromName = 'PsiuDev';

if ($_POST) {
    $name = trim(stripslashes($_POST['nome']));
    $email = trim(stripslashes($_POST['email']));
    $telefone = trim(stripslashes($_POST['telefone']));
    $cnpj = trim(stripslashes($_POST['cnpj']));
    $periodo = trim(stripslashes($_POST['periodo']));

    // Set Message
    $msg .= "Formulário de cadastro no site<br />";
    $msg .= "Nome: " . $name . "<br />";
    $msg .= "Email: " . $email . "<br />";
    $msg .= "Telefone: " . $telefone . "<br />";
    $msg .= "Cnpj: " . $cnpj . "<br />";
    $msg .= "Quer receber um contato: " . $periodo . "<br />";
    $msg .= nl2br($contact_message);
    $msg .= "<br /> ----- <br /> O email foi enviado de seu site " . url() . " com PsiuDev. <br />";

    // Setando o conteudo
    $mail->IsHTML(true);
    $mail->Subject = "PsiuDev - Alerta de Cadastro no site";
    $mail->Body = utf8_decode($msg);

    // Validando a autenticação
    // $mail->AddCC('meu.direito.bra@gmail.com');
    $mail->IsSMTP();
    $mail->SMTPAuth = true;
    $mail->Host     = "ssl://smtp.gmail.com";
    $mail->Port     = 465; //465
    $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
    $mail->SMTPAutoTLS = false;
    $mail->Username = EMAIL_USERNAME;
    $mail->Password = EMAIL_PASSWORD;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Setando o endereço de recebimento
    $mail->AddAddress($to);

    // Enviando o e-mail para o usuário
    if ($mail->Send()) {
        echo 'OK';
    } else {
        // echo $mail->ErrorInfo;
        // die;
        echo 'Algo deu errado. Por favor tente novamente.';
    }
}
