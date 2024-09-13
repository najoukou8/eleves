
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>synchro ksup</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<?

require ("param.php");
require ("function.php");
require ("style.php");
echo "</HEAD><BODY>" ;


//On se connecteà ksup 
$dsnksup="ksup_prod";
$usernameksup="metatag";
 $passwordksup="JHDE7652378623U";
 $hostksup="loire.infra.grenoble-inp.fr";
 $connexionksup =Connexion ($usernameksup, $passwordksup, $dsnksup, $hostksup);

 if ( $connexionksup )
 {
	//on récupère dans ksup
	$sqlquery2="SELECT META_CODE, META_LIBELLE_FICHE,ID_METATAG,META_CODE_RUBRIQUE,META_LIBELLE_OBJET FROM METATAG WHERE META_CODE_RUBRIQUE LIKE 'GENIE_FOR%' AND META_LIBELLE_OBJET LIKE 'cours'";
	$resultat2=mysql_query($sqlquery2,$connexionksup ); 
	while ($v=mysql_fetch_object($resultat2)){
	// on remplit des tableaux
		 // pour les apostrophes

	$META_CODE[]=str_replace("'","''",stripslashes($v->META_CODE));
	$META_LIBELLE_FICHE[]=str_replace("'","''",stripslashes($v->META_LIBELLE_FICHE));
	$ID_METATAG[]=str_replace("'","''",stripslashes($v->ID_METATAG));
	$META_CODE_RUBRIQUE[]=str_replace("'","''",stripslashes($v->META_CODE_RUBRIQUE));
	$META_LIBELLE_OBJET[]=str_replace("'","''",stripslashes($v->META_LIBELLE_OBJET));
	}

	mysql_close($connexionksup);
	// si ça c'est bien passé
	if (count($META_CODE) > 100)
	{
	 // On se connecte à begi
	$connexion =Connexion ($user_sql, $password, $dsn, $host);
	//print_r($META_CODE);
	// et on vide METATAG
	$sqlquery="delete FROM METATAG ";
	$resultat=mysql_query($sqlquery,$connexion ); 
	// et on y insere les tableaux
	$cree=0;
	for ($i=0;$i<count($META_CODE);$i++)
	{
		$sqlquery="insert into  metatag values ('".$META_CODE[$i]."' ,'".$META_LIBELLE_FICHE[$i]."' ,'".$ID_METATAG[$i]."' ,'".$META_CODE_RUBRIQUE[$i]."' ,'".$META_LIBELLE_OBJET[$i]."') ";
		//echo $sqlquery."<br>";
		$resultat=mysql_query($sqlquery,$connexion ); 
		$cree++;
	}
	
		echo "<br>on a ajoute $cree enregistrements dans metatag depuis ksup";
	
	mysql_close($connexion);

	}
	else
	// on envoie un mail
	{
	$objet="erreur synchro ksup";
	$messagem="il y a eu un problème avec la récupération des données dans ksup";
	echo "<br>il y a eu un problème avec la récupération des données dans ksup<br>";
	envoimail( $sigiadminmail,$objet,$messagem);
	}
}
else
// c'est qu'on a pas pus se connecter à la base ou au serveur
	// on envoie un mail
{
	$objet="erreur synchro ksup";
	$messagem="On a pas pu se connecter à ksup";
	echo "<br>On a pas pu se connecter à ksup<br>";
	envoimail( $sigiadminmail,$objet,$messagem);
}


?>
</body>
</html>