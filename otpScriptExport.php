<?php

require ("function.php");

$dsn="gi_users";
$user_sql="root";
$password='*Bmanpj1*';
$host="localhost";

$connexion =Connexion ($user_sql, $password, $dsn, $host);


$query = "SELECT user_login,otp FROM gi_users.people where otp != ''" ;


$result = mysql_query($query,$connexion );

$fp = fopen('/tmp/otp.txt', 'a');
file_put_contents('/tmp/otp.txt', '');


while($e=mysql_fetch_object($result)) {

    $login = $e->user_login ;
    $otp   = $e->otp ;
    fwrite($fp, $login.";".$otp."\n" );

}

fclose($fp);