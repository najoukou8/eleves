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
// on supprime tous les groupes cours
$query = " delete FROM `eleves_dbo`.`groupes`  where `type_gpe_auto` = 'edt'   ";
	echo $query."<br>";
// ci dessous commenté par sécurité
//$result = mysql_query($query,$connexion ); 
//printf("Lignes effacées : %d\n", mysql_affected_rows());
	echo"import GC<br>";
	
$tous=0;
$query = " SELECT * FROM `tempgc`  where  doublon != '1' ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   lignes </h2> ";
		
	 while($e=mysql_fetch_object($result)) {
	 // pour les apostrophes
$e->matiere= str_replace("'","''",stripslashes($e->matiere));
//Pour les codes
$morceaux=explode("_",$e->groupecours);
// 2018 plus nécessaire pour ipid
//$isipid=substr($morceaux[0],0,4);
//if($isipid=='3GMA')$morceaux[2]='IPID1';
//if($isipid=='4GMA')$morceaux[2]='IPID2';
//print_r($morceaux);
// 2019 il faut transformer les codes des semestres
if (substr($morceaux[2],1) != 10) {
	$morceaux[2] ='S0'.substr($morceaux[2],1);
}




//echo $isipid;
// pour année
 			
					$query3 = "INSERT INTO `eleves_dbo`.`groupes` ( `libelle`, `proprietaire`, `visible`, `login_proprietaire`, `liste_offi`, `groupe_principal`, `groupe_officiel`, `nom_liste`, `titre_affiche`, `titre_special`, `gpe_total`, `membre_gpe_total`, `id_ens_referent`, `code_ade`, `code_ade6`, `groupe_cours_complet`, `gpe_evenement`, `url_edt_direct`, `code_pere`, `type_gpe_auto`, `arbre_gpe`, `gpe_etud_constitutif`, `libelle_gpe_constitutif`, `archive`, `niveau_parente`, `recopie_gpe_officiel`, `code_etape`)VALUES ('".$e->matiere."_".$morceaux[3]."_".$morceaux[4]."#".$morceaux[0]."', '', 'oui','','non', 'non', 'oui', '', '".$morceaux[2]."/".$e->matiere."_".$morceaux[3]."_".$morceaux[4]."#".$morceaux[0]."', 'non', 'non', 'non', 9999, '".$e->groupecours."', '".$e->groupecours."', 'non', 'non', '', '', 'edt', '".$morceaux[2]."', '', '', 'non', '', '', '')";
					
					
					
				   //echo $query3 .";<br>";
				  // ci dessous commenté par sécurité
				   $result3 = mysql_query($query3,$connexion);
				   $tous++;
			
      } 			
		echo "<br>c'est fait : ".$tous ." ajouts de groupe ";
	


	
	
mysql_close($connexion);
echo"</body>";
echo "</html>";
?>