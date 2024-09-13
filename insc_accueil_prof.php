<?php
// initialisation session
session_start() ;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>choix cours etudiant accueil</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

//On se connecte plus à ksup la table METATAG a été ajoutée 

// $dsnksup="GINP_DB";
// $usernameksup="metatag";
// $passwordksup="AUs4Rrp9";
// $hostksup="ksup6-inpg.grenet.fr";
// $connexionksup =Connexion ($usernameksup, $passwordksup, $dsnksup, $hostksup);
//on remplit 1 tableau de correspondance  les codes apogee/-code ksup
$sqlquery2="SELECT META_CODE, META_LIBELLE_FICHE,ID_METATAG FROM METATAG WHERE META_CODE_RUBRIQUE LIKE 'GENIE_FOR-etud' AND META_LIBELLE_OBJET LIKE 'cours'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$fiche_code_ksup[$v["META_CODE"]]=$v["ID_METATAG"];
}
$fiche_code_ksup['']='';
//mysql_close($connexionksup);



//on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
   $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);


if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_POST['sup_multiple'])) $_POST['sup_multiple']='';
if (!isset($_POST['ajout_multiple'])) $_POST['ajout_multiple']='';
if (!isset($_GET['loginacc'])) $_GET['loginacc']='';
if (!isset($_GET['details'])) $_GET['details']='';
if (!isset($_GET['login_acc'])) $_GET['login_acc']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
$emailacc='';
$message='';
$sql1='';
$sql2='';
$listeouinon=array('oui','non') ;
 $okfiche=0;
//$login='_popop';
 $messagem='';

 $tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
//  on  accede depuis l'interface prof/fiche de l'eleve donc le loginacc passé est un num etudiant definitif
// il faut recuperer le login provisoire  à partir du num etudiant definitif

$titre="Inscriptions aux cours d'un étudiant en accueil";
// on forge le where sql
// pour l'instant on prend tous les cours
$wherecours=1;

//on remplit 1tableau avec les libelles-code cours
$sqlquery2="SELECT * FROM cours where ".$wherecours ." order by CODE";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$cours_code[]=$v["CODE"] ;
$cours_libelle[]=$v["LIBELLE_COURT"] ;
$cours_libelle_a[$v["CODE"]]=$v["LIBELLE_COURT"];
}
$cours_code[]='9999';
$cours_libelle[]='NC';
$cours_libelle_a[9999]=$v["NC"];

//on verifie qu'il s'agit d'un etudiant en accueil enregistré
$query= "SELECT etudiants_accueil.*  FROM etudiants_accueil where acc_code_etu ='".$_GET['code_etu']."'";
$result=mysql_query($query,$connexion);
//echo $query;
 //si le login est bien celui d'un etudianten accueil enregistré ou de qqun des ri
 if (mysql_num_rows($result)==1 ){
 // on recupere la ligne de  etudiant dans la table etudiants accueil
$x=mysql_fetch_object($result);
//tjour vrai  pour que ça marche qd on rajoute and
$where='where 1 ';

// on vérifie si on n'est pas connecté avec l'ancien login : 2cas
//if (1){

$URL =$_SERVER['PHP_SELF'];;
$table="ligne_insc_acc";
//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille
$result = mysql_query("SHOW COLUMNS FROM $table");
if (!$result) {
   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
   exit;
}
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {
      $champs[]= $row["Field"];
	  $type[]= $row["Type"];
   }
}


	if(!$okfiche  and $_POST['bouton_annul']!='Annuler'){  
   $affichetout=0;
 //____________________________________________________On affiche les choix en cours pour cet etudiant
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
	
  //echo"<input type='hidden' name='ajout' value=1>";



	echo "<center><h1>$titre</h1>";

   echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > Revenir à la fiche de ".$x->acc_nom." ".$x->acc_prenom."</a><br><br>";

  echo"       <table><tr>  ";
  
  echo    "<form method=post action=$URL name='form_1'> ";
    echo"<input type='hidden' name='liginsc_modifpar' value=$login>";
//$nomcomplet=ask_ldap($login,'displayname');
//$prenom=ask_ldap($login,'givenname');
//$nom=ask_ldap($login,'sn');
//$mail=ask_ldap($login,'mail');
	 echo "</tr><tr>";
     echo affichechamp('nom ','aff_nom',	$x->acc_nom,'50',1);
     echo affichechamp('prenom ','aff_prenom',$x->acc_prenom,'40',1);
	  
	 echo "</tr><tr>";		 
		  	 echo "</tr><tr>";

 
   echo"       </table>  ";
 if ($_GET['details']!='1')
 {
echo "<td> <b>Inscriptions cours  GI</b></td>";

  echo "<table border=1>";
	echo "<th></th><th>Code cours</th><th>Intitule</th><th>Crédits ECTS</th>";
	$query2= "SELECT ligne_insc_acc.*,cours.*   FROM ligne_insc_acc 
left outer join cours on ligne_insc_acc.liginsc_cours=cours.code
where liginsc_login='".$x->acc_login."' order by LIBELLE_COURT";
    $result2 = mysql_query($query2,$connexion ); 
	$totects=0;
	$sauvsem='';
		//on initialise  $csv_output
				$csv_output="";		
 				 $csv_output .= "code;libelle_court;libelle_long;ects";					 
				$csv_output .= "\n";
	while($y=mysql_fetch_object($result2)) {
$sem=substr( $y->LIBELLE_COURT,0,2);
		  if ($sauvsem !=  $sem){
		  $sauvsem =$sem;
switch ($sem){
	case "FL":
	$sem_aff="FLE";
	break;
	case "SI":
	$sem_aff="International semester";
	break;
	case "FI":
	$sem_aff="FILIPE";
	break;	
	default :
	$sem_aff=$sem;
	}
		 	echo "<tr><td colspan=4 bgcolor=lightgreen align='center'>$sem_aff</td></tr>";
			}
echo"   <tr><td>" ;  
		if (array_key_exists($y->liginsc_cours,$fiche_code_ksup))
		{
		if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$y->liginsc_cours].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}			
		}
	  echo"   </td><td>" ;
     echo  $y->CODE  ;  
      echo"   </td><td>" ;
     echo  $y->LIBELLE_COURT ;
      echo"   </td><td>" ;
     echo  $y->CREDIT_ECTS  ;
	 $totects+=$y->CREDIT_ECTS ;
	 echo "</tr>";
	 $csv_output .= "\"".$y->CODE."\"".";";
				 $csv_output .= "\"".$y->LIBELLE_COURT."\"".";";
				 $csv_output .= "\"".$y->LIBELLE_LONG."\"".";";
				 $csv_output .= "\"".$y->CREDIT_ECTS."\"".";";
				 $csv_output .= "\n";
	 }
	 echo "<tr>";
	 echo "<td bgcolor=lightgreen colspan=3> TOTAL ECTS $ecole</td><td bgcolor=lightgreen >$totects</td>";
	 echo "</tr>";	 
	echo"</table>";

		echo "<br>";


	  
		echo "<br>";
echo "<td><b> Inscriptions cours autres ecoles</b></td>";

 echo "<table border=1>";
echo "<th>nom ecole</th><th>filiere</th><th>Crédits ECTS</th>";
	$query2= "SELECT cours_autres_accueil.*   FROM cours_autres_accueil 

where cours_autres_accueil.autcour_login='".$x->acc_login."'";
    $result2 = mysql_query($query2,$connexion ); 
	$totectsautcour=0;

	while($z=mysql_fetch_object($result2)) {

echo"   <tr><td>" ;  
        echo  $z->autcour_nom_ecole  ;
      echo"   </td><td>" ;
     echo  $z->autcour_filiere  ;
	  echo"   </td><td>" ;
     echo  $z->autcour_ECTS  ;
	 	   // pour que le total soit juste on corrige $ectsautcour
	   // on remplace la virgule par le point 
	   $autcour_ECTS=nettoiefloat($z->autcour_ECTS);
	 $totectsautcour+=$autcour_ECTS ;
	 echo "</tr>";
	 }
	 	 echo "<tr>";
	 	 echo "<td bgcolor=lightgreen colspan=2> TOTAL ECTS autres écoles</td><td bgcolor=lightgreen >$totectsautcour</td>";
		 	 echo "</tr>";
	echo"</table>";
	echo "<br>";

		echo "<br>";
		echo "<br>";
		echo "<br>";
		$totectsgen=$totects+$totectsautcour;
		echo "<table border=1>";
		 echo "<td bgcolor=lightgreen colspan=2><B> TOTAL ECTS</b> </td><td bgcolor=lightgreen ><b>$totectsgen</b></td>";
		echo "</table>";	

 echo "</form >";



}

 echo"</table></form> "  ;
   
  echo"</center>";
        }


echo "<center><h2>". $message."</h2> </center>";
	 



 
} //fin  si c'est bien un etudiant 
else
 {
echo"<center> désolé, mais cet étudiant n'est pas un étudiant étranger en accueil , contacter le service RI   ";
echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > Revenir à la fiche de l'étudiant </a></center><br>";
 }
mysql_close($connexion);

?>
</body>
</html>