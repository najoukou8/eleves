<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>production d'un json pour jpivot</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<?



require ("param.php");
require ("function.php");
require ("style.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);




echo "</HEAD><BODY>" ;



$query="select * from  etudiants ";

$total=0;
$x=0;
$xdouble=0;
$dataPoints=array();
$resultats=array();
$resultatsdouble=array();
$translit=array('4G-STG'=>'Erasmus accueil');
$result = executesql($query,$connexion);	

$jsonoutput='[';	
$jsonoutput.='["code_etape","Ann�e Univ"],';

	// on remplit un tableau avec les r�sultats
	while ($r=mysql_fetch_array($result))
	{			
$jsonoutput.='["'.$r['Code �tape'].'","'.$r['Ann�e Univ'].'"],';
		//$resultats[]=array('code_etape'=>$r['Code �tape'],'Ann�e_Univ'=>$r['Ann�e Univ']);
				}		
	
	// pour les doubles inscriptions il faut v�rifier dans le tableau  $resultatsdoub[]	
	
			// si c'est cesure ou master on les ajoute au total de la 2eme inscription , et on les enleve au total de la premiere inscription

		//
$jsonoutput.=']';		
echo $jsonoutput;


?>

</body>
</html>