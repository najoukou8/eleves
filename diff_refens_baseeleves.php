<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<head>
<title>moulinette</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<?
// pour visualiser les différences entre  les cours récupérés dans refens par export ADE et ceux importés dans tempgc avec requete de Jan
// On se connecte
	

require ("style.php");
require ("param.php");
require ("function.php");
$connexion =Connexion ($user_sql, $password, $dsn, $host);
 if($login=='administrateur'){
echo "</HEAD><BODY>" ;
// On se connecte

   $query = "SELECT * FROM temptempgc ";   
   //echo $query;
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
if ($nombre>0){
echo"<center> <h2>il y a   ";
echo $nombre;
echo"  lignes dans  refens </H2>";}
while($e=mysql_fetch_array($result)){

	//echo "<br>";
	
	$query2 = "SELECT * FROM tempgc where groupecours='".$e['code']."'";   
   //echo $query;
$result2 = mysql_query($query2,$connexion ); 
$nombre2= mysql_num_rows($result2);
	//echo "<br>";
	//echo " pour ".$e['code apogee']." il y a " .$nombre2 ." lignes";
	
if ($nombre2==0)
{
			
	echo "<br>". $e['code'] ." est dans refens et pas dans export";
}	
}
//=================================================

 $query = "SELECT * FROM tempgc ";   
   //echo $query;
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
if ($nombre>0){
echo"<center> <h2>il y a   ";
echo $nombre;
echo"  lignes dans  export </H2>";}
while($e=mysql_fetch_array($result)){

	//echo "<br>";
	
	$query2 = "SELECT * FROM temptempgc where code ='".$e['groupecours']."'";   
   //echo $query;
$result2 = mysql_query($query2,$connexion ); 
$nombre2= mysql_num_rows($result2);
	//echo "<br>";
	//echo " pour ".$e['code apogee']." il y a " .$nombre2 ." lignes";
	
if ($nombre2==0)
{
			
	echo "<br>". $e['groupecours'] ." est dans export et pas dans refens";
}	



}
	

mysql_close($connexion);
 }
?>
</body>
</html>