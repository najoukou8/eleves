<?php 

require __DIR__."/vendor/autoload.php" ;
$giusers       =   new App\Services\EntityManagerGiUsers() ; 
$giusers->updateOtpFromBase64Password( $_GET['hash'] ) ; 
$redirectUrl = "/giqualite/index.php" ; 
header('Location: '.$redirectUrl);