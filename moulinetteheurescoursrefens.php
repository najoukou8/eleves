<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>moulinette</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<?
// On se connecte
	
$dsn="helico_extr2022";
$user_sql="root";
$password="*Bmanpj1*";
$host="localhost";
require("paramcommun.php");
require ("function.php");
require ("style.php");
$connexion =Connexion ($user_sql, $password, $dsn, $host);
 
echo "</HEAD><BODY>" ;
echo "login ".$login."<br>";
if($login=='administrateur' or $login=='foukan' ){
// On se connecte

   $query = "SELECT * FROM effectifs ";   
   echo "base utilisée :".$dsn."<br>";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
if ($nombre>0){
echo"<center> <h2>il y a   ";
echo $nombre;
echo"  cours </H2>";}
while($e=mysql_fetch_array($result)){

	//echo "<br>";
	
	$query2 = "SELECT * FROM refens_extr where matiere='".$e['code apogee']."'";   
   //echo $query;
$result2 = mysql_query($query2,$connexion ); 
$nombre2= mysql_num_rows($result2);
	//echo "<br>";
	//echo " pour ".$e['code apogee']." il y a " .$nombre2 ." lignes";
	$heqtd=0;
	
	while($f=mysql_fetch_array($result2)){
		$coef=1;
		if($f['type_heure']=='CM')$coef=1.5;
		if($f['type_heure']=='CTD')$coef=1.25;
		if($f['type_heure']=='DSTP')$coef=0.25;
		if($f['type_heure']=='TPG')$coef=0.25;	
		if($f['type_heure']=='Travail personnel')$coef=0;			
	$heqtd+=$f['groupes']*$f['heure']*$coef;	
	//echo "<br>le type heure est ". $f['type_heure']."  le coeff est  $coef";
	}

	
	
	
	// echo "<br> le total eq td  pour ".$e['code apogee'] ." est $heqtd";
	
	$query3 = "update  effectifs set `heures eqtd`=".$heqtd." where`code apogee`='".$e['code apogee']."'";   
   echo $query3.";";
   echo "<br>";
//$result3 = mysql_query($query3,$connexion );

  // pour vérifier les heures :
/*   $query3 = "select `heures eqtd` as heqtd from effectifs  where`code apogee`='".$e['code apogee']."'";   
$result3 = mysql_query($query3,$connexion ); 
$nombre3=mysql_num_rows($result3);
	if ($nombre3==1)
	{
		$g=mysql_fetch_array($result3);
		$temp=(24*1.5)+24+(8.14*7);
		if ($g['heqtd'] !=$heqtd )
				//if (strval($g['heqtd']) !==  strval($heqtd))
		{
					echo "<br>";
		echo " pb avec ".$e['code apogee']. "heures  calculées  refens_extr : ".var_dump($heqtd)."  heures effectifs :".var_dump($g['heqtd']);
		echo "<br>";
				echo "<br>";
		}
		else
		{
		echo " PAS de pb avec ".$e['code apogee']. "heures  calculées  refens_extr : ".var_dump($heqtd)."  heures effectifs :".var_dump($g['heqtd']);
		echo "<br>";
		}
	
	}
	
	elseif ($nombre3==0)
	{
		echo " pb avec ".$e['code apogee']. "introuvable dans effectifs";
		echo "<br>";
	}
	elseif ($nombre3>1)
	{
		echo " pb avec ".$e['code apogee']. "plusieurs occurences  dans effectifs";
		echo "<br>";
	} */	
	
}
	

mysql_close($connexion);
 }
 else
	 echo "acces non autorisé";
?>
</body>
</html>