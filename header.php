<link rel="icon" type="image/png" href="https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico" />
<link rel="shortcut icon" href="https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link href="https://fonts.cdnfonts.com/css/roboto-condensed" rel="stylesheet">
<?php
require __DIR__."/vendor/autoload.php" ;
$container = require __DIR__."/src/container.php" ;
error_reporting(E_ERROR | E_PARSE);

$casOn=0;
$ldapOK=1;
// pour le php cas
if($casOn)
{
// nom de la variable de session
$nomSession='sess123';
require ("casgenerique.php");
$loginConnecte = $login;
}
else
{
	// inutile si on utilise  paramcommun
//// on récupère le login du connecté dans $_SERVER (authentification http ldap )
 if(isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] !=''){
	 $loginConnecte=$_SERVER['PHP_AUTH_USER'];
	 $loginConnecte=strtolower($loginConnecte);}
	 else
	 { $loginConnecte=''; }
}

// $login='demichev';
//$loginConnecte = 'demichev' ;

if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'givenname')[0]." ".ask_ldap($loginConnecte,'sn')[0];else  $nomloginConnecte='';
if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';


if($loginConnecte=='administrateur' )
{$emailConnecte=$emailadmin;
$nomloginConnecte='Administrateur';
}
//echo "<div style='background-color: '> <p>Vous &ecirc;tes  <b>  : ".$loginConnecte."( ".$emailConnecte.")</b></div>";
//echo $nomloginConnecte."<br>";

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

$agalan =  $_SERVER['PHP_AUTH_USER'] ; 

?>

<div class="header" style='color:white'>
  <a href="/eleves/default.php" class="logo"><img style='width:140px;' src='https://web.gi.grenoble-inp.fr/eleves/icons/logo2.png'/> </a>
  <div class="header-right">
				<div style="float: left ;margin-top:4px ">
                        <input type="checkbox" id="totp" name="totp" <?php  if ($found == 'on' ) { echo "checked"; } ?> />
                        <label for="totp" title="Durée de 90jours -après on redemande un nouveau jeton ">OTP</label>
                    </div>

      <a class="active1" style='color:white' href="/eleves/default.php">&#x1F935; <?php echo " ".$emailConnecte ; ?></a>
      <a href="logout.php" style='color:white' title="Se déconnecter " class="bouton_ok" style="margin-top:6px ; height: 18px ; color: white ; background-color: #e12727;text-decoration: none"><i class="fa fa-sign-out" aria-hidden="true"></i></a>


					
  </div>
</div>


<style>
.bascule {
   position: fixed;
   right: 0;
   bottom: 0;
   width: 50%;
   background-color: #c81d1d;
   color: white;
   text-align: center;
   text-transform: uppercase;
   font-size:8px;
}
option {
	font-size:12px !important ; 
	font-family : arial ; 
	
}
</style>



<script>
                    $('#totp').change(function () {


                        if (this.checked){

                            console.log("change on ...");

                            $.ajax({
                                type: "GET",
                                url:"/eleves/cacheOn.php?key=<?php echo $agalan;?>",
                                success: function(arg){
                                    console.log(arg);
                                                    Swal.fire({
														icon: "success",
														title: "T-OTP" ,
														html: 'La double authentification est activée',
														footer: '<a href="#">GI-DEV</a>' 
													});
                                }
                            });

                        }else{

                            console.log("change off ...");
                            $.ajax({
                                type: "GET",
                                url:"/eleves/cacheOff.php?key=<?php echo $agalan;?>",
                                success: function(arg){
                                    console.log(arg);
                                             Swal.fire({
														icon: "error",
														title: "T-OTP" ,
														html: 'La double authentification  est désactivée',
														footer: '<a href="#">GI-DEV</a>'
													});
                                }
                            });

                        }

                    });
                </script>
