<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/PHPMailer/src/SMTP.php';


function sendmail($to,$nameto,$subject,$message,$altmess)  {
    $from           = "no-reply@sharpxchange.com";
    $namefrom       = "SharpXchange";
    $mail           = new PHPMailer();  
    $mail->CharSet  = 'UTF-8';
    $mail->isSMTP();   
    $mail->SMTPAuth   = true;   
    $mail->Host       = "server125.web-hosting.com";
    $mail->Port       = 465;
    $mail->Username   = $from;  
    $mail->Password   = "EtbK4ADLwU7X";
    $mail->SMTPSecure = "ssl";     
    $mail->setFrom($from,$namefrom);   
    $mail->addCC($from,$namefrom);      
    $mail->Subject  = $subject;
    $mail->AltBody  = $altmess;
    $mail->Body     = $message;
    $mail->addAddress($to, $nameto);
    return $mail->send();
}

// sendmail("imranhadid03@gmail.com", "Imran Hadid", "test", "testMessage", "AltMessage");
?>