<?php
error_reporting(E_ERROR | E_PARSE);
error_reporting(E_ALL ^ E_NOTICE); 
session_start();


unset($_SESSION['doubleAuth']);
session_destroy();
session_unset();

//header('Location: logout.htm');
header('Location:  https://cas-inp.grenet.fr/logout?service=https://web.gi.grenoble-inp.fr/');
