<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use Twig\Environment;

class SendMailerService
{
    private $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $twig ;
    }
    public function send($mail,$subject,$twig , $parameters , $path_pdf = null   ){
        $html = $this->twig->render($twig, $parameters );
        if($this->smtpMailer(
            $mail,
                 'nadir.fouka@fouka.ovh',
                 'no_replay@grenoble-inp.fr',
            $subject ,
            $html , $path_pdf )) {
        }else{
            dump('mail non envoyer ');
        }
    }

    public function smtpMailer($to, $from, $from_name, $subject, $body , $path_pdf = null ) {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug = 0 ;
        $mail->SMTPAuth = false ;
		$mail->port = 25 ; 
        $mail->SetFrom($from, $from_name);
        $mail->Subject = html_entity_decode($subject);
        $mail->msgHTML( $body ) ;
        $mail->AddAddress($to);
        $mail->addAttachment($path_pdf);
        $mail->CharSet = 'UTF-8';
        $mail->Priority = 1;
        $mail->AddCustomHeader("X-MSMail-Priority: High");
        $mail->AddCustomHeader("Importance: High");
        if(!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }
}