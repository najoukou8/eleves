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
// on supprime tous les groupes scol
$query = " delete FROM `groupes`  where `type_gpe_auto` = 'scol'   ";
	echo $query."<br>";
// ci dessous commenté par sécurité
//$result = mysql_query($query,$connexion ); 
printf("Lignes effacées : %d\n", mysql_affected_rows());
	echo"import CS<br>";
	
$tous=0;
$query = " SELECT * FROM `tempcs`    ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   lignes </h2> ";
	$listeCoursAcreer=array();
	 while($e=mysql_fetch_object($result)) {
		// on stocke dans le tableau le groupe
		$listeCoursAcreer[]=$e->groupe;
		// on stocke  le père 
		$listeCoursAcreer[]=$e->pere;
	 }
	 // on supprime les doublons
	$listeCoursAcreerUnique=array_unique($listeCoursAcreer);
	echo"<br><br>";

	foreach($listeCoursAcreerUnique as $unCours){
	 //while($e=mysql_fetch_object($result)) {


			// on ajoute le groupe 
					
					$query3 = "INSERT INTO `groupes` ( `libelle`, `proprietaire`, `visible`, `login_proprietaire`, `liste_offi`, `groupe_principal`, `groupe_officiel`, `nom_liste`, `titre_affiche`, `titre_special`, `gpe_total`, `membre_gpe_total`, `id_ens_referent`, `code_ade`, `code_ade6`, `groupe_cours_complet`, `gpe_evenement`, `url_edt_direct`, `code_pere`, `type_gpe_auto`, `arbre_gpe`, `gpe_etud_constitutif`, `libelle_gpe_constitutif`, `archive`, `niveau_parente`, `recopie_gpe_officiel`, `code_etape`)
					VALUES ('".$unCours."', '', 'oui','','non', 'non', 'oui', '', '', 'non', 'non', 'non', 9999, '', '', 'non', 'non', '', '', 'scol', '', '', '".$unCours."', 'non', '', '', '')";
									
				  echo $query3 .";<br>";
				  // ci dessous commenté par sécurité
				 //$result3 = mysql_query($query3,$connexion);
				   $tous++;
				   
				// on ajoute le groupe pere si il n'existe pas 
			
      } 			
		echo "<br>c'est fait : ".$tous ." ajouts de groupe ";
	
// 2eme passe pour ajouter les groupes peres
$query = " SELECT * FROM `tempcs`    ";
$result = mysql_query($query,$connexion ); 
// on met les correspondances dans un tableau 
	 while($e=mysql_fetch_object($result)) {
$pere[$e->groupe]=$e->pere;
$gs[]=$e->groupe;
$nivparente[$e->groupe]=$e->nivparente;
}
//print_r($pere);
echo "<br> on modifie les lignes de groupe<br>";
$tous=0;
foreach ($gs as $ungroupestruct)
{
// on recherhce le code de ce pere
$query = " SELECT * FROM `groupes` where type_gpe_auto='scol' and  libelle ='".$pere[$ungroupestruct]."'  ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
//$gpeniv2=array('-A','-B','-C','-D');

		
	 while($e=mysql_fetch_object($result)) {

			  

									 
					$query3 = "UPDATE  `groupes` set `code_pere`='".$e->code."',  `niveau_parente`='".$nivparente[$ungroupestruct]."' where libelle = '".$ungroupestruct."'";

					
					
				  echo $query3 ."<br>";
				  									  // ci dessous commenté par sécurité
				  //$result3 = mysql_query($query3,$connexion);
				   $tous++;
			
      } 
}	  
		echo "<br>c'est fait : ".$tous ." modification  de groupe ";
	
	
	
	
mysql_close($connexion);
echo"</body>";
echo "</html>";
?>