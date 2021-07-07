<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    class SendEmail{

        public function __construct(){

            require 'src/Exception.php';
            require 'src/PHPMailer.php';
            require 'src/SMTP.php';
            $this->Conecta();
        }

        public function Conecta(){
            $mail = new PHPMailer;
            return $mail;
        }
        
    }

?>