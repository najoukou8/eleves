<?php
require __DIR__."/vendor/autoload.php" ; 
use RobThree\Auth\TwoFactorAuth;
use Symfony\Component\Dotenv\Dotenv;
$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/.env');


session_start();
unset($_SESSION['doubleAuth']); 
session_destroy();

header("Location:  ".$_ENV['REDIRECT_AUTH_OK']);