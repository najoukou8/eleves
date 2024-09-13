<?php 

require __DIR__."/vendor/autoload.php" ;


$giusers       =   new App\Services\EntityManagerGiUsers() ; 
$secret        =   $giusers->getOtp($_SERVER['PHP_AUTH_USER']);
$cryptSecurity =   new App\Security\MyEncryption() ; 
$loader        =   new Twig\Loader\FilesystemLoader(array(__DIR__."/twig") );
$twig          =   new Twig\Environment($loader ,
                    array('debug'      => true ,
                         'auto_reload' => true  ,
                         'cache' => '/tmp/cache'
                    ));
					
$template      = $twig->load('otp.html.twig');
$mail          = $giusers->getMailById($_SERVER['PHP_AUTH_USER']) ;

if($secret and $secret != "" ) {
	
	        $tfa = new RobThree\Auth\TwoFactorAuth($_SERVER['PHP_AUTH_USER'],6,30,'sha1');
            $secretKey = $cryptSecurity->decrypt($secret) ;
            $qr = $tfa->getQRCodeImageAsDataUri('GI-OTP<'.$_SERVER['PHP_AUTH_USER'].'>', $secretKey );
            $digit =  $tfa->getCode($secretKey) ;
            $encoded_url = $giusers->getPasswordCrypted($_SERVER['PHP_AUTH_USER']);
			$render = $template->render( [
			    'nom'        =>   $giusers->getNameById($_SERVER['PHP_AUTH_USER']),
                'qr'      =>   $qr,
                'code'    =>   $digit ,
                'hash'    =>   base64_encode($encoded_url)
            ] );
			
           $html          =   $render  ; 
		   $mailer        = new App\Services\SendMailerService($twig) ; 

            if( $mailer->smtpMailer(
                $mail ,
                'no_reply@grenoble-inp.fr',
                'no_reply@grenoble-inp.fr',
                ' 🔐 Secret T-OTP Génie Industriel' ,
                $html )) {
            }else{
                echo "Erreur interne , contacter gi-dev AT grenoble-inp.fr " ;
            }
			
			$redirectUrl = "/eleves/default.php" ; 
			header('Location: '.$redirectUrl);
	
}