<?php 

require __DIR__."/vendor/autoload.php" ; 
use RobThree\Auth\TwoFactorAuth;
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');
$PATH_WEBSITE_TOTP  = $_ENV['PATH_WEBSITE_TOTP'];
$REDIRECT_AUTH_OK   = $_ENV['REDIRECT_AUTH_OK'] ; 

$cachePool = new \Symfony\Component\Cache\Adapter\FilesystemAdapter(
    $namespace = '',
    $defaultLifetime = 0,
    $directory = "/var/www/html/giqualite/symfony-cache/"
);

if ($cachePool->hasItem($_SERVER['PHP_AUTH_USER']))
{
    $demoString = $cachePool->getItem($_SERVER['PHP_AUTH_USER']);
    $found =  $demoString->get();

}

if(isset($found) and $found =='off'){
    $_SESSION['doubleAuth']  = true ;
}


?>
<link href="https://fonts.cdnfonts.com/css/roboto-condensed" rel="stylesheet">
                
<style>

			body {
				margin: 0px;
				padding: 0px;
				font-family: 'Roboto Condensed' !important ;
			}
			h1{
				text-transform : uppercase ; 
			}
.qr{
    border: 6px solid red;
}
</style>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 

$giusers  =   new App\Services\EntityManagerGiUsers() ; 
$tfa = new TwoFactorAuth($_SERVER['PHP_AUTH_USER'],6,30,'sha1');
$encrypt = new App\Security\MyEncryption() ; 
$secret =  $tfa->createSecret() ;

if( $giusers->getOtp($_SERVER['PHP_AUTH_USER']) == null && empty($_SESSION['secret']) ) {
	$_SESSION['secret'] = $secret ; 
}

 if (!empty($_POST['submit']) && !empty($_POST['submit']) && $_POST['submit'] == "valider" ) {
 
            if ( $giusers->getOtp($_SERVER['PHP_AUTH_USER']) == null ) {

                $test = $tfa->verifyCode($_SESSION['secret'] , $_POST['tfa_code']);
                if (  $test  ) {
                    $giusers->updateOtp( $encrypt->encrypt($_SESSION['secret'])  , $_SERVER['PHP_AUTH_USER']) ;
                    $_SESSION['doubleAuth']  = true ; 
                }
                else {
     
					$_SESSION['message'] = null ; 
					$_SESSION['message'] = 'Mot de passe incorrect' ; 
                    $redirectUrl = "/$PATH_WEBSITE_TOTP/totp.php";
					header('Location: '.$redirectUrl);
                }

            }else{

                $test = $tfa->verifyCode( $encrypt->decrypt( $giusers->getOtp($_SERVER['PHP_AUTH_USER']) )  , $_POST['tfa_code']);
                if (  $test  ) {
                    
					$_SESSION['doubleAuth']  = true ; 
					
					
					
					$days = 90 ; 
					$agalan = $_SERVER['PHP_AUTH_USER'];
					$sms = $cachePool->getItem($agalan);

					if (!$sms->isHit()) {
						$sms->set("on");
						$sms->expiresAfter(3600*24*$days  );
						$cachePool->save($sms);
					} else {
						$sms->set("on");
						$sms->expiresAfter(3600*24*$days );
						$cachePool->save($sms);
					}


                }
                else {
					$_SESSION['message'] = null ; 
					$_SESSION['message'] = 'Mot de passe incorrect' ; 
                    $redirectUrl = "/$PATH_WEBSITE_TOTP/totp.php";
					header('Location: '.$redirectUrl);
                }
            }

        }elseif(empty($_SESSION['doubleAuth']) ) { 
		
		        $form = '<body class="container-fluid bg-white"><center><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">';
                $form = $form . "<br><img style='width: 220px' src='/$PATH_WEBSITE_TOTP/sbb.png'><hr style='border-top: 4px solid #2b79b5;'><h1 style='font-weight: bold ; color: #055181 ; font-family: 'Roboto Condensed'; font-size: 2.2em'>&#9888; T-OTP Secure for " . $giusers->getNameById($_SERVER['PHP_AUTH_USER']) . " <br>
<span style='color: black;font-family: 'Roboto Condensed';font-style: italic;font-size: 25 px'></span></h1>";


            if ( $giusers->getOtp($_SERVER['PHP_AUTH_USER']) == null ) {
                $form = $form . "<p style='font-size:12px'>Veuillez installer <a href='web.gi.grenoble-inp.fr/api/apk/scanner.apk'>GI-TOOLS <a/> ou google-authenticator depuis votre playStore et scaner le code QR suivant </p>";
            }else{
                $form = $form . "<p>Vous avez perdu votre smartphone ? / Vous arrivez pas a vous connecter ? Recevez le code par mail  <a href='/$PATH_WEBSITE_TOTP/sendOtpByMail.php'> ICI </a> </p>";
            }

            if ( !empty($_SESSION['message'])  ) {
                $form = $form . "<div class='alert alert-danger text-uppercase'>" . $_SESSION['message'] . "</div>";
            }

            $form = $form . "<form class='form' action='/$PATH_WEBSITE_TOTP/totp.php/' method='post'>";
            if ( $giusers->getOtp($_SERVER['PHP_AUTH_USER']) == null ) {
                $qr = $tfa->getQRCodeImageAsDataUri('GI/T-OTP('.$_SERVER['PHP_AUTH_USER'].')', $_SESSION['secret'] ) ;
                $form = $form . "<img class='qr' src=$qr /><hr>";
            }

            $form = $form . "<input type='text' value='' name='tfa_code' style='font-size: 45px;font-family: \"Roboto Condensed\" ; text-align: center'><span style='font-size: 3em'>&#x1F510;</span><br>";
            $form = $form . "<br><input type='submit' value='valider' name='submit' class='btn btn-primary text-uppercase btn-block' style='font-size: 2em;font-family: 'Roboto Condensed';padding:2px;background-color: #055181'>            ";

            $form = $form . "</form> <a style='font-weight:bold;font-size:13px' href='https://gricad-gitlab.univ-grenoble-alpes.fr/foukan/t-otp/-/wikis/TOTP-Pour-GI-2023'> &#128073; DOCUMENTATION T-OTP BY GI-DEV@GRENOBLE-INP.ORG LAST UPDATE 16/02/2023</a> </center></body>";


            // $form = $form .' - /Or display the code to the user for manual entry :'. chunk_split($encrypt->decrypt($giusers->getOtp($_SERVER['PHP_AUTH_USER'])), 4, ' ');

            echo $form ; 
		
		}
		 
			
	if ( isset($_SESSION['doubleAuth']) && !empty($_SESSION['doubleAuth']) )  {
		header("Location: $REDIRECT_AUTH_OK");		  
	 }
	 
	 require('footer.php') ; 