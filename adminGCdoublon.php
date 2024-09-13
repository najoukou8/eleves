<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>utilitaire</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?

set_time_limit(120);
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
//on remplit 1tableau avec les libelles-code cours
$sqlquery2="SELECT * FROM cours order by CODE";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$cours_code[]=$v["CODE"] ;
$cours_libelle[]=$v["LIBELLE_COURT"] ;
$cours_libelle_a[$v["CODE"]]=$v["LIBELLE_COURT"];
}


	
$tous=0;
$query = " SELECT * FROM `tempgc` order by `groupecours`    ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   lignes </h2> ";
		$gc='';
		$id1=0;
	 while($e=mysql_fetch_object($result)) {
	 if ($gc==$e->groupecours)
	 {
	  echo" $e->groupecours $id1 est un doublon <br>";
	 echo" $e->groupecours $e->id est un doublon <br>";
	 $query2 ="update `tempgc` set `doublon` ='1' where `id`='$id1'";
	// echo $query2 ."<br>";
	$result2 = mysql_query($query2,$connexion ); 
	$query2 ="update `tempgc` set `doublon` ='2' where `id`='$e->id'";
	// echo $query2 ."<br>";
	$result2 = mysql_query($query2,$connexion );
	$tous++;
	 }

	  $gc=$e->groupecours;
	  $id1=$e->id;
	 // on récupère les libellés de matières
	 // correction 2015 pour enlever 'Sx ' de chaque libellé court , il faut  ,3 à la fin et pas ,2 -> laisse un espace
	 //$libellematiere=substr($cours_libelle_a[substr($e->groupecours,0,8)],2);
	 $libellematiere=substr($cours_libelle_a[substr($e->groupecours,0,8)],3);	
		echo "matiere ". 	 $libellematiere ."<br>";
		$libellematiere= str_replace("'","''",stripslashes($libellematiere));
			 $query2 ="update `tempgc` set `matiere` ='$libellematiere' where `id`='$id1'";
	//echo $query2 ."<br>";
	$result2 = mysql_query($query2,$connexion ); 
      } 			
		echo "<br>c'est fait : ".$tous ." doublons ";
	

	
	
	
mysql_close($connexion);
echo"</body>";
echo "</html>";
?>