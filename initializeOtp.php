<?php 

require __DIR__."/vendor/autoload.php" ;
$giusers       =   new App\Services\EntityManagerGiUsers() ; 
// $giusers->updateOtpFromBase64Password( $_GET['hash'] ) ; 
//$redirectUrl = "/index.php" ; 
//header('Location: '.$redirectUrl);

echo "<div>SEND TOTP TO <code>gi-dev@grenoble-inp.fr</code> </div>";
echo "<br><textarea rows='10' cols='50'>".$_GET['hash']."</textarea>" ; 