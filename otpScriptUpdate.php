<?php

require ("function.php");

$dsn="gi_users";
$user_sql="root";
$password='*Bmanpj1*';
$host="localhost";

$connexion =Connexion ($user_sql, $password, $dsn, $host);



$handle = fopen('/tmp/otp.txt', 'r');


if ($handle) {
    while (($line = fgets($handle)) !== false) {


        $split = explode(";", $line);
        $agalan = $split[0] ;
        $otp    = $split[1] ;

        $update = "UPDATE people SET otp = '$otp' WHERE user_login = '$agalan' " ;
        $result = mysql_query($update,$connexion);

        echo "Query Update Injector for user \t: $agalan \n" ;

    }

    fclose($handle);
}
