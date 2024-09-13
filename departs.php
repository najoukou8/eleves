<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Gestion des départs à l'étranger</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
// pour changer l'annee courante de cette page et pas ds paramcommun
$annee_courante='2024';
require('header.php');

//else{
//$filtre='';
//$filtreok='';
//}
$liste_champs_dates=array('date_depart' ,'date_retour');
$liste_champs_dates_courts=array('date_depart' ,'date_retour');
$liste_champs_dates_longs=array('date_modif','date_demande');
$liste_champs_exclus_csv=array('code_depart','code_periode','date_modif','modifpar','log_workflow','commentaire_arrivee','bilan_mi_sejour');
$villecode='';
$message='';
$message_entete='';
$sql1='';
$sql2='';
$afficheliste=1;
$self=$_SERVER['PHP_SELF'];
if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_POST['modif'])) $_POST['modif']='';
if (!isset($_POST['code_etu_filtre'])) $_POST['code_etu_filtre']='';
if (!isset($_POST['code_periode_filtre'])) $_POST['code_periode_filtre']='';
if (!isset($_POST['bouton_cp_mod'])) $_POST['bouton_cp_mod']='';
if (!isset($_POST['bouton_cp_adm_mod'])) $_POST['bouton_cp_adm_mod']='';
if (!isset($_POST['bouton_cp'])) $_POST['bouton_cp']='';
if (!isset($_POST['bouton_cp_adm'])) $_POST['bouton_cp_adm']='';
if (!isset($_POST['bouton_cp_add'])) $_POST['bouton_cp_add']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_periode'])) $_GET['code_periode']='';
//if (!isset($_GET['nom_ent'])) $_GET['nom_ent']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_GET['addfromvoeux'])) $_GET['addfromvoeux']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_POST['code_etudiant'])) $_POST['code_etudiant']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['villecp'])) $_POST['villecp']='';
if (!isset($_POST['imp_convention'])) $_POST['imp_convention']='';
if (!isset($_GET['st_mon_champ'])) $_GET['st_mon_champ']='';
if (!isset($_GET['st_recherche'])) $_GET['st_recherche']='' ;
if (!isset($_GET['st_recherche_avance'])) $_GET['st_recherche_avance']='' ;
if (!isset($_GET['st_orderby'])) $_GET['st_orderby']='' ;
if (!isset($_GET['st_inverse'])) $_GET['st_inverse']='' ;
if (!isset($_GET['st_bouton_ok'])) $_GET['st_bouton_ok']='';
if (!isset($_GET['annees'])) $_GET['annees']='';
if (!isset($_GET['vuetut'])) $_GET['vuetut']='';
if (!isset($_GET['an'])) $_GET['an']='';
if (!isset($_POST['an'])) $_POST['an']='';
if (!isset($_POST['ajoutfromvoeux'])) $_POST['ajoutfromvoeux']='';
if (!isset($_POST['OKcours'])) $_POST['OKcours']='';
if (!isset($_POST['PASOKcours'])) $_POST['PASOKcours']='';
if (!isset($_POST['OKcoursv2'])) $_POST['OKcoursv2']='';
if (!isset($_POST['PASOKcoursv2'])) $_POST['PASOKcoursv2']='';
if (!isset($_POST['decision_finale'])) $_POST['decision_finale']='';
if (!isset($_GET['code_groupe_peda'])) $_GET['code_groupe_peda']='';
if (!isset($_GET['nom_recherche'])) $_GET['nom_recherche']='';
if (!isset($_GET['recherche_avance'])) $_GET['recherche_avance']='';
if (!isset($_GET['annee'])) $_GET['annee']='';
if (!isset($_GET['mon_champ'])) $_GET['mon_champ']='';
if (!isset($_GET['code_etu_recherche'])) $_GET['code_etu_recherche']='';
if (!isset($_GET['options'])) $_GET['options']='';
if (!isset($_GET['clone'])) $_GET['clone']='';
if (!isset($_GET['en_cours'])) $_GET['en_cours']='';
if (!isset($_GET['tous'])) $_GET['tous']=''; 


 $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche'])."&clone=".urlencode($_GET['clone'])."&vuetut=".urlencode($_GET['vuetut']) ; 


//on a choisi une annee
if ( isset($_GET['an'])){
$filtre.=  "&an=".urlencode($_GET['an']);
}


// pour le popupsubmit
//if (!isset($_POST['etape'])) $_POST['etape']='';
 
if ($_GET['st_orderby']=='') {$orderby='ORDER BY etudiants.nom';}
	else{
	$orderby=urldecode($_GET['st_orderby']);
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
	$orderby="ORDER BY ".$orderby;
                  if  ($_GET['st_inverse']=="1"){
                  $orderby=$orderby." desc";
                  }
	}
	
	
// pour tester comme un autre
// il faut récupérer la valeur de clone et num etudiant qui pourrait être passée par un formulaire en hidden
if (isset($_POST['clone']))$_GET['clone']=$_POST['clone'];
//idem pour vuetut
if (isset($_POST['vuetut']))$_GET['vuetut']=$_POST['vuetut'];


if (!isset($_GET['clone'])) $_GET['clone']='';
if (($_GET['clone']) !=''  and in_array($login,$ri_user_liste)) 
{$login=$_GET['clone'];
echo ("reloggué come $login");
}
$URL =$_SERVER['PHP_SELF'];
$table="departs";
// on recupere le nom de la personne logguée
$sqlquery5="select * from enseignants where  uid_prof = '".$login."'";
$resultat5=mysql_query($sqlquery5,$connexion );
$nomprenomprof='';
while ($u=mysql_fetch_array($resultat5)){
	$nomprenomprof=$u['prenom'].' ' .$u['nom'];
}
$ouinon=array('non','oui');
$ouinonenattente=array('en attente','non','oui');
$tabletemp="departs";
$champs=champsfromtable($tabletemp);
$taillechamps=champstaillefromtable($tabletemp);
//print_r($taillechamps);

//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces et slashs dans les noms de champs
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);

foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
$tabletemp="etudiants";
$champs3=champsfromtable($tabletemp);

foreach($champs3 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
//on remplit 1 tableaux avec les valeurs de la table periodes_departs
$sqlquery2="select * from periodes_departs order by pdp_nouveautype desc,pdp_libelle asc ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$tab_semestres[]=$v["pdp_libelle"] ;
}
$tab_semestres[]='NC';
//on remplit 1 tableaux avec les nom-code  enseignants
$sqlquery2="select * from enseignants  ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$tab_enseignants[$v["uid_prof"]]=$v["prenom"] ." ".$v["nom"];
}
//on remplit 2 tableaux avec les nom-code  etudiants
$sqlquery2="SELECT * FROM etudiants  order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
//on remplit un tableau indice avec les noms etudiants pour le select du formulaire
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Prénom 1"];
$etudiants_code[$ind]=$v["Code etu"];
$etudiants_code2[]=$v["Code etu"];}
//on remplit 2 tableaux avec les noms-codes universites
$sqlquery2="SELECT * FROM universite order by nom_uni ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom_uni"] ;
$ind2=$v["id_uni"];
//on remplit un tableau associatif avec les noms universites  pour le select du formulaire
$universites_nom[$ind2]=$v["nom_uni"];
$universites_ville[$ind2]=$v["ville"];
//on remplit un tableau associatif avec les codes universites pour le insert
$universites_code[$ind]=$v["id_uni"];
$universites_code2[]=$v["id_uni"];
}
//inutile
// $sqlquery2="SELECT *,universite.*  FROM periode_envoi left outer join universite on  periode_envoi.id_univ_periode=universite.id_uni order by nom_uni  ";
// $resultat2=mysql_query($sqlquery2,$connexion ); 
// while ($v=mysql_fetch_array($resultat2)){
// $ind=$v["sem_depart"] ;
// $ind2=$v["id_periode_envoi"];
//on remplit un tableau associatif avec les noms universites  pour le select du formulaire
// $periode_envoi_nom[$ind2]=$v["sem_depart"] ;
// $periode_envoi_universite[$ind2]=$v["nom_uni"] ;
// $periode_envoi_ville[$ind2]=$v["ville"] ;
//on remplit un tableau associatif avec les codes universites pour le insert
// $periode_envoi_code[$ind]=$v["id_periode_envoi"];
// $periode_envoi_code2[]=$v["id_periode_envoi"];
// }
//inutile
//si on revient de creation d'entreprise (à partir du lien ci dessous section ajouter) on recupere le code cree
// if ($_GET['nom_ent']!=''){
// $_GET['code_ent'] = $entreprises_code[urldecode(stripslashes($_GET['nom_ent']))]  ;
// }

$tabletemp="departs";
$st_champs=champsfromtable($tabletemp);




if($_POST['ajout']!='') { // ------------Ajout de la fiche--------------------
if($login == 'administrateur' or in_array($login,$ri_user_liste)){

$_POST['modifpar']=$login;
foreach($champs as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle generee automatiquement par sqlserver

   if ($ci2=="code_depart"){
 

 }
elseif ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(), ";}
 elseif ($ci2=="etape"){
 $sql1.= $ci2.",";
 $sql2.= "'0', ";}
 elseif ($ci2=="uid_enseignant"){
 $sql1.= $ci2.",";
 $sql2.= "'NC', ";}
  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  $query = "INSERT INTO $table($sql1)";
  $query .= " VALUES($sql2)";
//echo $query."<br>";
   $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
}
   else{
   echo "<center><b>Seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucun ajout effectuée<br></center>";

} //fin du else $login ==
}
elseif($_POST['ajoutfromvoeux']!='') { // ------------Ajout de la fiche depuis form voeux--------------------
if($login == 'administrateur' or in_array($login,$ri_user_liste)){
$_POST['modifpar']=$login;
$log="\r\nEtape -}0 Départ créé depuis la fiche voeux par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
foreach($champs as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle generee automatiquement par sqlserver

   if ($ci2=="code_depart"){
 }
elseif ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(), ";}
elseif ($ci2=="etape"){
 $sql1.= $ci2.",";
 $sql2.= "'0', ";}
 elseif ($ci2=="log_workflow"){
 $sql1.= $ci2.",";
 $sql2.= "'".$log."', ";}
  elseif ($ci2=="uid_enseignant"){
 $sql1.= $ci2.",";
 $sql2.= "'NC', ";}
  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  $query = "INSERT INTO $table($sql1)";
  $query .= " VALUES($sql2)";
//echo $query."<br>";
   $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
}
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucun ajout effectuée<br></center>";

} //fin du else $login ==
}
elseif($_GET['del']!='') { //--------------- Suppression de la fiche--------------------

if($login == 'administrateur' or in_array($login,$ri_user_liste)){
//il faut vérifier s'il n'existe pas de cours pour ce depart
   $query = "select * FROM cours_departs where code_depart= '". $_GET['del']."'" ;
	$result = mysql_query($query,$connexion ); 
	if (mysql_num_rows($result)>0)
	{echo affichealerte ( "il existe des cours liés à ce départ , supprimez les d'abord");
	}
	else{


   $query = "DELETE FROM $table"
      ." WHERE code_depart='".$_GET['del']."'";
	     $result = mysql_query($query,$connexion ); 
		 echo afficheresultatsql($result,$connexion);
		 } 
		 }
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune suppression effectuée<br></center>";

} //fin du else $login ==
}



elseif($_POST['OKcours']!='') { //----------------Le prof ou ri  a validé les cours en appuyant sur bouton---------------------
if(($login==$_POST['uid_enseignant'] and $_POST['etape'] ==2 ) or  in_array($login,$ri_user_liste)){
//pour modifpar
$_POST['modifpar']=$login;
//On passe en étape 3
	$_POST['etape']='3';

// on vérifie les modifications qui vont donner lieu à des actions spécifiques

	$_POST['log_workflow'].="Etape -}3 par validation des cours effectuée par :".$tab_enseignants[$_POST['uid_enseignant']]. " par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
	$_POST['log_workflow'].="voici la liste des cours validés : \r\n".$_POST['listecours']  ."\r\n";
	// il faut aussi envoyer un mail à l'étudiant
			// On prepare l'email : on initialise les variables

			$objet = "passage  d'un  départ en etape 3 par validation du learning agreement   " ;
			$messagem = "La liste des cours du départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'être validée par ".$tab_enseignants[$_POST['uid_enseignant']]."  "." \n" ;
			if ($_POST['commentaire_validation'] != '')
			{
			$messagem .= "Voici son commentaire : \n";
			$messagem .= $_POST['commentaire_validation']." \n";
			//On ajoute le commentaire dans l'historique
			$_POST['log_workflow'].="-avec le commentaire suivant :".$_POST['commentaire_validation']  ."\r\n";				
			}
			//$messagem .= "il va falloir en terminer la saisie\n";
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!='')){
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);			
			}
// pour commentaire validation
 $_POST['commentaire_validation']= str_replace("'","''",stripslashes($_POST['commentaire_validation']));			
foreach($champs as $ci2){			
			         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
}
	
 
  $query = "UPDATE $table SET `etape`='".$_POST['etape']."',`date_modif`=now(),`modifpar`='".$_POST['modifpar']."',`log_workflow`='".$_POST['log_workflow']."'";
   $query .= " WHERE code_depart='".$_POST['code_depart']."' ";
 //  echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_depart']." modifiée <br>";
   // on verrouille les cours validés
     $query = "UPDATE cours_departs SET `verrouille`='oui'";
   $query .= " WHERE code_depart='".$_POST['code_depart']."' ";
 // echo $query."<br>";
   $result = mysql_query($query,$connexion );
   
   // on duplique les cours pour en créer une liste  modifiable pour la 2eme validation
 $query="  INSERT INTO cours_departs (code_depart, intitule_cours, url, niveau, ects,code_cours_long,descriptif)
SELECT code_depart, intitule_cours, url, niveau, ects,code_cours_long,descriptif
FROM cours_departs
WHERE code_depart='".$_POST['code_depart']."' ";
 // echo $query;
     $result = mysql_query($query,$connexion ); 
   
   
   
   
   
   
   
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>La fiche n'est pas modifiée</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations internationales peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==

}

elseif($_POST['PASOKcours']!='') { //----------------Le prof ou ri a refusé de valider les cours en appuyant sur bouton ---------------------
if(($login==$_POST['uid_enseignant'] and $_POST['etape'] ==2 ) or  in_array($login,$ri_user_liste)){
//pour modifpar
$_POST['modifpar']=$login;
//On passe en étape 1
	$_POST['etape']='1';


// on vérifie les modifications qui vont donner lieu à des actions spécifiques

	$_POST['log_workflow'].="refus de validation des cours effectuée par :".$tab_enseignants[$_POST['uid_enseignant']]. " par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
	$_POST['log_workflow'].="voici la liste des cours non validés : \r\n ".$_POST['listecours']  ."\r\n";	

	// il faut aussi envoyer un mail à l'étudiant
			// On prepare l'email : on initialise les variables

			$objet = "refus de validation du learning agreement   " ;
			$messagem = "La liste des cours du départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " n'a pas été validée par ".$tab_enseignants[$_POST['uid_enseignant']]."  "." \n" ;
			if ($_POST['commentaire_validation'] != '')
			{
			$messagem .= "Voici son commentaire : \n";
			$messagem .= $_POST['commentaire_validation']." \n";
			//On ajoute le commentaire dans l'historique
			$_POST['log_workflow'].="-avec le commentaire suivant :".$_POST['commentaire_validation']  ."\r\n";		
			}
			$messagem .= "il va falloir reprendre la saisie de votre liste de cours\n";
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!='')){
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
// pour commentaire validation
 $_POST['commentaire_validation']= str_replace("'","''",stripslashes($_POST['commentaire_validation']));				
foreach($champs as $ci2){			
			         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
}			
		
  $query = "UPDATE $table SET `etape`='".$_POST['etape']."',`date_modif`=now(),`modifpar`='".$_POST['modifpar']."',`log_workflow`='".$_POST['log_workflow']."'";
   $query .= " WHERE code_depart='".$_POST['code_depart']."' ";
  //echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_depart']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>La fiche n'est pas modifiée</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations internationales peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==
}
elseif($_POST['OKcoursv2']!='') { //----------------Le prof ou ri a validé les cours v2 en appuyant sur bouton ---------------------
if(($login==$_POST['uid_enseignant'] and $_POST['etape'] ==7 ) or  in_array($login,$ri_user_liste)){
//pour modifpar
$_POST['modifpar']=$login;
//On passe en étape 8
	$_POST['etape']='8';

// on vérifie les modifications qui vont donner lieu à des actions spécifiques

	$_POST['log_workflow'].="Etape -}8 par validation des cours effectuée après arrivée par :".$tab_enseignants[$_POST['uid_enseignant']]. " par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
		$_POST['log_workflow'].="voici la liste des cours validés : \r\n ".$_POST['listecours2']  ."\r\n";
	// il faut aussi envoyer un mail à l'étudiant
			// On prepare l'email : on initialise les variables

			$objet = "passage  d'un  départ en etape 8 par 2eme validation du learning agreement   " ;
			$messagem = "La liste des cours du départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'être validée pour la deuxième fois par ".$tab_enseignants[$_POST['uid_enseignant']]."  "." \n" ;
			$messagem .= " La prochaine étape concerne le bilan de mi-séjour à compléter  "." \n" ;			
			if ($_POST['commentaire_validation'] != '')
			{
			$messagem .= "Voici son commentaire : \n";
			$messagem .= $_POST['commentaire_validation']." \n";
			//On ajoute le commentaire dans l'historique
			$_POST['log_workflow'].="-avec le commentaire suivant :".$_POST['commentaire_validation']  ."\r\n";				
			}
			//$messagem .= "il va falloir en terminer la saisie\n";
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!='')){
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
	// pour commentaire validation
 $_POST['commentaire_validation']= str_replace("'","''",stripslashes($_POST['commentaire_validation']));			
foreach($champs as $ci2){			
			         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
}
	
 
  $query = "UPDATE $table SET `etape`='".$_POST['etape']."',`date_modif`=now(),`modifpar`='".$_POST['modifpar']."',`log_workflow`='".$_POST['log_workflow']."'";
   $query .= " WHERE code_depart='".$_POST['code_depart']."' ";
 //  echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_depart']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>La fiche n'est pas modifiée</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations internationales peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==

}

elseif($_POST['PASOKcoursv2']!='') { //---------------Le prof ou ri a refusé de valider les cours v2 en appuyant sur bouton ---------------------
if(($login==$_POST['uid_enseignant'] and $_POST['etape'] ==7 ) or  in_array($login,$ri_user_liste)){
//pour modifpar
$_POST['modifpar']=$login;
//On passe en étape 6
	$_POST['etape']='6';


// on vérifie les modifications qui vont donner lieu à des actions spécifiques

	$_POST['log_workflow'].="refus de validation des cours après arrivée effectuée par :".$tab_enseignants[$_POST['uid_enseignant']]. " par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
		$_POST['log_workflow'].="voici la liste des cours non validés : \r\n ".$_POST['listecours2']  ."\r\n";	

	// il faut aussi envoyer un mail à l'étudiant
			// On prepare l'email : on initialise les variables

			$objet = "refus de 2eme validation du learning agreement   " ;
			$messagem = "La liste des cours du départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " n'a pas été validée pour la deuxième fois par ".$tab_enseignants[$_POST['uid_enseignant']]."  "." \n" ;
			if ($_POST['commentaire_validation'] != '')
			{
			$messagem .= "Voici son commentaire : \n";
			$messagem .= $_POST['commentaire_validation']." \n";
			//On ajoute le commentaire dans l'historique
			$_POST['log_workflow'].="-avec le commentaire suivant :".$_POST['commentaire_validation']  ."\r\n";		
			}
			$messagem .= "il va falloir reprendre la saisie de votre liste de cours\n";
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!='')){
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
// pour commentaire validation
 $_POST['commentaire_validation']= str_replace("'","''",stripslashes($_POST['commentaire_validation']));				
foreach($champs as $ci2){			
			         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
}			
		
  $query = "UPDATE $table SET `etape`='".$_POST['etape']."',`date_modif`=now(),`modifpar`='".$_POST['modifpar']."',`log_workflow`='".$_POST['log_workflow']."'";
   $query .= " WHERE code_depart='".$_POST['code_depart']."' ";
  //echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_depart']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>La fiche n'est pas modifiée</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations internationales peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==
}
//-------------------------------------------------------------------------------------------------------
//------------------------------------------------------------ Modif de la fiche---------------------
// on a appuyé sur le bouton modifier dans le formulaire de modification 
//elseif($_POST['modif']!=''  or $_POST['etape']!='' ) { 
elseif($_POST['modif']!='' ) { 
if($login == 'administrateur' or in_array($login,$ri_user_liste)){

//pour modifpar
$_POST['modifpar']=$login;
// on vérifie les modifications qui vont donner lieu à des actions spécifiques
// referent changé?
if($_POST['uid_enseignant_sauv']!= $_POST['uid_enseignant'] and $_POST['uid_enseignant']!='NC')
{
	if($_POST['etape']=='0')
	{
	$_POST['etape']='1';
	$_POST['log_workflow'].="affectation Enseignant :".$tab_enseignants[$_POST['uid_enseignant']]. " par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
	// il faut aussi envoyer un mail à l'étudiant
			// On prepare l'email : on initialise les variables

			$objet = "passage  d'un  départ en etape 1 par désignation d'un référent  " ;
			$messagem = "Le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'etre passé en étape 1 par la désignation du référent :  ".$tab_enseignants[$_POST['uid_enseignant']]." \n" ;
			//$messagem .= "Pour accéder à la fiche du stage : ".$url_eleve." \n";
			//$messagem .= "il va falloir en terminer la saisie\n";
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!='')){
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
	}
	else{
		$_POST['log_workflow'].="Enseignant modifié ancien : ".$tab_enseignants[$_POST['uid_enseignant_sauv']]." nouveau : ".$tab_enseignants[$_POST['uid_enseignant']]. " par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
			// il faut aussi envoyer un mail à l'étudiant
			// On prepare l'email : on initialise les variables

			$objet = "modification du référent  " ;
			$messagem = "Pour le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " l'ancien référent ".$tab_enseignants[$_POST['uid_enseignant_sauv']]." vient d'etre remplacé par ".$tab_enseignants[$_POST['uid_enseignant']]. "   "." \n" ;
			//$messagem .= "Pour accéder à la fiche du stage : ".$url_eleve." \n";
			//$messagem .= "il va falloir en terminer la saisie\n";
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!='')){
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
	}
}


// est ce que tout est OK pour passer en etape 4
// on regarde si on a modifié la validation départ par jury et si on était en étape 3
if($_POST['validation_depart_jury']== 'oui' and $_POST['validation_depart_jury_sauv']!= 'oui' and $_POST['etape']=='3')
{
	$_POST['etape']='4';
	$_POST['log_workflow'].="Etape".$_POST['etape_sauv'] ."-}4 suite à validation du jury par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
	

			//envoi du mail à l'étudiant
			$objet = "passage  d'un  départ en etape 4 par validation jury   " ;
			$messagem = "Le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'etre passé en étape 4 par la validation du jury  "." \n" ;
			$messagem .= " Vous devez obligatoirement valider les consignes du départ en cliquant sur le bouton dans votre fiche  "." \n" ;
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!=''))
			{
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}

}
// est ce que tout est OK pour passer en etape 10
// inutile ???
if($_POST['contribwiki_etud']== 'oui' and $_POST['contribwiki_etud_sauv']!= 'oui' and $_POST['etape']=='9')
{
	$_POST['etape']='10';
	$_POST['log_workflow'].="Etape".$_POST['etape_sauv'] ."-}10 suite à contribution wiki par élève par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
	

			//envoi du mail à RI
			$objet = "passage  d'un  départ en etape 10 par  contribution wiki   " ;
			$messagem = "Le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'etre passé en étape 10 par le fait que l'étudiant déclare avoir contribué au WIKIRI  "." \n" ;
			$messagem .= " Veuillez vérifier et valider à votre tour  "." \n" ;


			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);	

}
// est ce que tout est OK pour passer en etape 11

if($_POST['contrib_wiki']== 'oui' and $_POST['contrib_wiki_sauv']!= 'oui' and $_POST['etape']=='10')
{
	$_POST['etape']='11';
	$_POST['log_workflow'].="Etape".$_POST['etape_sauv'] ."-}11 suite à validation de la contribution wiki par élève par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
	

			//envoi du mail à RI
			$objet = "passage  d'un  départ en etape 11 par  validation de la contribution wiki   " ;
			$messagem = "Le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'etre passé en étape 11 par validation de la contribution  au WIKIRI  "." \n" ;			
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!=''))
			{
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
			

}
// est ce que tout est OK pour passer en etape 12

if($_POST['reception_bulletin']== 'oui' and $_POST['reception_bulletin_sauv']!= 'oui' and $_POST['etape']=='11')
{
	$_POST['etape']='12';
	$_POST['log_workflow'].="Etape".$_POST['etape_sauv'] ."-}12 suite à validation de la réception du bulletin de notes  par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
	

			//envoi du mail à étudiant
			$objet = "passage  d'un  départ en etape 12 par  validation de la réception du bulletin de notes   " ;
			$messagem = "Le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'etre passé en étape 12 par validation de la réception du bulletin de notes   "." \n" ;			
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!=''))
			{
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
			

}
// est ce que tout est OK pour passer en etape 13

if($_POST['decision_finale']== 'oui' and $_POST['decision_finale_sauv']!= 'oui' and $_POST['etape']=='12')
{
	$_POST['etape']='13';
	$_POST['log_workflow'].="Etape".$_POST['etape_sauv'] ."-}13 suite à validation du jury final  par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
	

			//envoi du mail à étudiant
			$objet = "passage  d'un  départ en etape 13 (finale) par  validation par validation du jury final   " ;
			$messagem = "Le départ de ".$_POST['nom_etudiant']." à  ".$_POST['nom_universite']." \n" ;
			$messagem .= " vient d'etre passé en étape 13 (finale) par validation du jury final "." \n" ;			
			$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
			if (($_POST['mail_etudiant']!=''))
			{
			envoimail($_POST['mail_etudiant'],$objet,$messagem);
			envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);				
			}
			

}
//est ce que l'étape a été modifiée ?
if($_POST['etape_sauv']!= $_POST['etape'])
{
	$_POST['log_workflow'].="Etape".$_POST['etape_sauv'] ."-}".$_POST['etape'] ." par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
	
}
 for($i=0;$i<sizeof($champs);$i++) {
 $ci2=$champs[$i];
  $ci3=$taillechamps[$i];
   // debug echo $ci2."_".$ci3."<br>";
   //si c'est une date//petit bidouillage sur les dates

 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
  if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
  // on tronque tout ce qui depasse la longueur du champ ds la table
  $_POST[$ci2]=tronquerPhrase($_POST[$ci2],$ci3) ;
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="code_depart"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2."=now(), ";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $query = "UPDATE $table SET $sql1";
   $query .= " WHERE code_depart='".$_POST['code_depart']."' ";
 //  echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_depart']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>La fiche n'est pas modifiée</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations internationales peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==

}



echo"<table width=100% height=100%><tr><td><center>";
echo $message;
   
    //debut
   // ___________sélection de tous les stages ou du stage de l'etudiant si arrivee depuis fiche.php________

   //$query = "SELECT etudiants.[Nom],$table.* FROM $table left outer join etudiants on $table.[code_etudiant]=etudiants.[Numéro INE] order by code_stage";
   // $query = "SELECT etudiants.[Nom],entreprises.[nom],$table.* FROM $table,etudiants,entreprises where [code_etudiant]=etudiants.[Code etu] and  [code_entreprise]=entreprises.code order by date_debut";

     //ça c'est kan on arrive depuis fiche.php ou kan on a clique apres sur details ou sup
     //ds les 2 cas on filtre la liste sur le code etudiant
     if ( $_GET['mod']!='') {
    //lien pour revenir à l'accueil des stages un stage
  echo "<A class='abs' href=".$URL."?vuetut=".$_GET['vuetut']."&clone=".$_GET['clone']."&an=".$_GET['an']." > Revenir à la liste des départs </a><br><br/>";

     }else
     {
     if ( $_GET['code_etu']!='') {
     $where="and (code_etudiant='".$_GET['code_etu']. "')"   ;

     $message_entete="de ".$etudiants_nom[$_GET['code_etu']];
      }
	  elseif($_GET['en_cours']!='' and $_GET['pays_rech']=='')
		 {
		 $where=" and ( annee_scolaire = '". ($annee_courante-1) .'-'.$annee_courante. "' and etape >=6 )"   ;
		 $message_entete=" actuellement en cours";
		  } 
	elseif($_GET['en_cours']!='' and $_GET['pays_rech']!='')
		 {
		 $where=" and ( annee_scolaire = '". ($annee_courante-1) .'-'.$annee_courante. "' and etape >=6 and libelle_pays ='".$_GET['pays_rech']."')"   ;
		 $message_entete=" actuellement en cours : pays ".$_GET['pays_rech'];
		  }
	elseif($_GET['tous']!='' and $_GET['pays_rech']!='')
		 {
		 $where=" and ( etape >=0 and libelle_pays ='".$_GET['pays_rech']."')"   ;
		 $message_entete=" toutes périodes : pays ".$_GET['pays_rech'];
		  }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter apres fiche.php
      elseif ( $_POST['code_etu_filtre']!='') {
     $where="and code_etudiant='".$_POST['code_etudiant']."' "   ;
     //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_etu']=$_POST['code_etudiant'];
     //pour afficher le message correct
     $message_entete="de ".$etudiants_nom[$_GET['code_etu']];
      }
      //ça c'est kan on arrive depuis entreprise.php ou kan on a clique apres sur details ou sup
     //ds les 2 cas on filtre sur le code universite
     elseif ( $_GET['code_periode']!='') {
     $where="and code_periode='".$_GET['code_periode']."' "   ;
     $message_entete="de la période".$_GET['code_periode'];
      }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter
     elseif ( $_POST['code_periode_filtre']!='') {
     $where="and code_periode='".$_POST['code_periode']."' "   ;
      //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_periode']=$_POST['code_periode'];
     $message_entete="de la période".$_GET['code_periode'];
     }
	  elseif ( $_GET['an']!='' and $_GET['vuetut']!='1' ) {


     $where = " and annee_scolaire = '".($_GET['an'])."-".($_GET['an']+1)."'";
     $message_entete="de la période ".$_GET['an']."-".($_GET['an']+1);
		  
      }
	  
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter et qu'on a modifier l'année par défaut
     elseif ( $_POST['an']!='' and $_POST['an']!= $annee_courante-1) {
	       //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['an']=$_POST['an'];
		$where = " and annee_scolaire = '".($_GET['an'])."-".($_GET['an']+1)."'";

     $message_entete="de la période ".$_GET['an']."-".($_GET['an']+1);
     }
	 
	 
	 
      else{
	  //si on est en recherche avancee
	    if($_GET["st_recherche_avance"]=="oui" and $_GET["st_mon_champ"]!=''){
		//il faut traiter le cas recherche avnce est egal à vide
if ($_GET['st_recherche']=='vide') {  $_GET['st_recherche']='';}
// et date est égal à NC 
if ($_GET['st_recherche']=='NC') {  $_GET['st_recherche']='01/01/1900';}
		  $where="and ".$table.".`".$_GET["st_mon_champ"]."` = '".$_GET["st_recherche"]."'";

		}		
		//sinon on prend tout
		elseif($_GET['annees']=='all'){				
     $message_entete="pour toutes les périodes ";    
      $where="";}
	  // pour la premiere fois on prend l'année en cours
	  else{
	 // $_GET['an']=$annee_courante-1;
	  		  // pour la vue tuteur
		  if ( $_GET['vuetut']=='1')
		  {
			  if ($_GET['an']=='')$_GET['an']=$annee_courante-1;
     $where = " and annee_scolaire = '".($_GET['an'])."-".($_GET['an']+1)."' and uid_enseignant= '".$login."'";
     $message_entete="de la période ".$_GET['an']."-".($_GET['an']+1) ." pour lesquels ".$nomprenomprof ." est tuteur";			  
		  }
		  else
		  {
			  	  // pour la premiere fois on prend l'année en cours
			  $_GET['an']=$annee_courante-1;
	  		$where = " and annee_scolaire = '".($_GET['an'])."-".($_GET['an']+1)."'";
		 $message_entete="de la période ".$_GET['an']."-".($_GET['an']+1);
			}
		}
	  }
	  
   
	   
//____________________________________________________________________________________________________________________________
  //AFFICHAGE DES liens  pour ajouter un stage et revenir a l'accueil si pas mod et si pas retour de code postal
  if ( $_GET['add']!='1' and $_GET['mod']=='' and  $_POST['mod']=='' and $afficheliste) {
  
  // echo "<br><A href=default.php?".$filtreok." > Revenir à la liste des départs </a><br>"; 
		echo "<A href=accueil_international.php > Retour à l'accueil des départs à l'étranger</a><br><br>"; 
	if(in_array($login,$ri_user_liste)){
		echo "<br><A class='abs' href=".$URL."?add=1&code_etu=".$_GET['code_etu']."&code_periode=".$_GET['code_periode']."&an=".$_GET['an']." > Ajouter un départ</a>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;            <A class='abs2' href=periodes_departs.php > Gérer les périodes de départ</a><br><br>";
	
	}


echo " Les départs dont je suis le tuteur en <a href=$URL?vuetut=1&clone=".$_GET['clone']."&an=".($annee_courante-1).">" .($annee_courante-1)."-".($annee_courante)."</a> <a href=$URL?vuetut=1&clone=".$_GET['clone']."&an=".($annee_courante).">" .($annee_courante)."-".($annee_courante+1)."</a><br>";
echo " <br>Tous les départs ";
echo " <a href=$URL?an=".($annee_courante-2)."&clone=".$_GET['clone'].">" .($annee_courante-2)."-".($annee_courante-1)."</a>";
echo "-";
echo " <a href=$URL?an=".($annee_courante-1)."&clone=".$_GET['clone'].">" .($annee_courante-1)."-".($annee_courante)."</a>";

echo " <a href=$URL?an=".($annee_courante)."&clone=".$_GET['clone'].">" .($annee_courante)."-".($annee_courante+1)."</a>";
echo " <a href=departs.php?annees=all>&nbsp;Toutes années</a>";
echo "<br>";echo "<br>";
// echo " <a href=departs.php?an=2012> 2012-2013</a>";
// echo "-";
// echo " <a href=departs.php?an=2013> 2013-2014</a>";
// echo "<br>";echo "<br>";
// echo " <a href=departs.php?an=2014> 2014-2015</a>";
// echo "<br>";echo "<br>";
 }
  //lien pour revenir
  if ( $_GET['code_etu']!='') {
  //si on arrive depuis fiche.php
     $temp= $_GET['code_etu'] ;
      echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > Revenir à la fiche de ". $etudiants_nom[$temp]."</a><br><br>";
    }
    //si on arrive depuis entreprises
    elseif ( $_GET['code_periode']!='') {
      echo "<A href=universites.php > <br>Revenir à la liste des universites </a><br><br>";
    }
    //else{
  //dans l tous les  cas
      
	   
	
}//fin du bouton_ok=ok

  if($_GET['mod']!='' or $_POST['mod']!='' ){//--------------------------------------c'est kon a cliqué sur detail 
  $afficheliste=0;
   echo    "<form method=post action=$URL> "; 

   
   
  if ($_GET['clone']!='')
  {
echo"<input type='hidden' name='clone' value=".$_GET['clone'].">"; 	  
  }
    if ($_GET['vuetut']!='')
  {
echo"<input type='hidden' name='vuetut' value=".$_GET['vuetut'].">"; 	  
  } 
  if($_GET['mod'] !=''){
  //si on a cliqué sur détails
  //1ere version de la requete
//   $query = "SELECT etudiants.[Nom],entreprises.[nom],Enseignants.[email],$table.* FROM $table,etudiants,entreprises,Enseignants where [code_etudiant]=etudiants.[Code etu]
//    and  [code_entreprise]=entreprises.code and  [code_tuteur_gi]=Enseignants.id and code_stage=$_GET[mod] order by date_debut";
   $query = "SELECT etudiants.Nom AS nom_etud ,etudiants.`prénom 1` AS prenom_etud, etudiants.* ,etudiants_scol.*,universite.nom_uni   , annuaire.`Mail effectif`,$table.*,pays.* FROM $table  
	 left outer join etudiants on upper(etudiants.`Code etu`)=departs.code_etudiant       
	 left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code 
	left outer join universite on  code_periode=universite.id_uni
	left outer join pays on  universite.id_pays=pays.id_pays
	left outer JOIN
        annuaire  ON departs.code_etudiant = annuaire.`Code-etu` 
	
WHERE     departs.code_depart = ".$_GET['mod'];

   $result = mysql_query($query,$connexion );
$e=mysql_fetch_object($result); 
$i=1;
   //on fait une boucle pour créer les variables issues de la table departs
   foreach($champs as $ci2){
   $$ci2=$e->$ci2;
   }
           //on surcharge les dates pour les pbs de format
        $date_depart=mysql_DateTime($e->date_depart)  ;
        $date_retour=mysql_DateTime($e->date_retour) ;


        //on récupère les champs liés
        $nom_etudiant=$e->nom_etud; 
		$prenom_etudiant=$e->prenom_etud; 
        $code_etudiant= $e->code_etudiant;      
        $mail_etudiant=$e->$myannuairemail_effectif;      
       
        $tel_etudiant=$e->$myetudiantsada_num_tél;   
      
		$adresse_fixe_etudiant=$e->$myetudiantsadresse_fixe;
		$adf_rue2_etudiant=$e->$myetudiantsadf_rue2;
		$adf_rue3_etudiant=$e->$myetudiantsadf_rue3;
		$adf_code_bdi_etudiant=$e->$myetudiantsadf_code_bdi;
		$adf_lib_commune_etudiant=$e->$myetudiantsadf_lib_commune;
		$lib_bourse=$e->$myetudiantslib_bourse;
        $nom_universite=$e->nom_uni;
		//$periode=$e->sem_depart;
        $date_modif=mysql_Time($e->date_modif) ;
		$annee_etudiant=$e->annee;
		$double_cursus=$e->double_cursus;
		$libelle_pays=$e->libelle_pays;
		//$uid_referent=$e->uid_referent;

    }
   //si on revient  du choix du codepost
/*  //on remet le contenu des champs avec les valeurs sauvegardées
    if ($_POST['bouton_cp'] !=''){
   foreach($_POST as $ci2){
    $x=key($_POST);
   $$x= stripslashes(current($_POST));
   next($_POST) ;
   }
   if (  $_POST['villecp']!='' ){
   if ($_POST['bouton_cp']=='OK'){
   $villecode=explode("_",$_POST['villecp']);
    $ville=$villecode[0];
    $code_postal=$villecode[1];  }
	else {$code_postal=$code_postal_sauv;
		$resp_adm_code_postal=$resp_adm_code_postal_sauv;
	}
	}
  } */
  
 
  


        //ça c pour garder l'info comme koi on est arrivé depuis fiche.php apres click sur le modifier

       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";

        echo"<input type='hidden' name='code_etudiant' value=".$_GET['code_etu'].">";
        }
             else  if ( $_GET['code_periode']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_periode_filtre' value='1'>"; }
		if ( $_GET['an']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='an' value=".$_GET['an'].">";}
		
	
		
   //-------------------------------------------------------------------------------------------------debut affichage  modification de fiche
        //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
						//on stocke ds des champs cachés les valeur en entrant dans le formulaire pour pouvoir savoir si elles ont été modifiées
        echo"<input type='hidden' name='".$ci2."_sauv' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";				
        }
        echo"       <table><tr>  ";


        echo "<h1 class='titrePage2'>Statut du départ</h1>" ;
				        echo "</tr><tr>";	
		//echo affichemenusql('Etape','etape','code_etape','SELECT * FROM intitules_etapes_departs ','libelle_etape',$etape,$connexion);
		//echo "SELECT * FROM intitules_etapes_departs where code_etape='".$etape."' ";
		       // echo affichechamp('id etape','idetape',$etape,'30',1);
	 if (in_array($login,$ri_user_liste))	
		 {		 
		//echo affichechamp('code Etape','aff_etape',$etape,'2',1);
		echo affichemenusqlplus('Etape','etape','code_etape','SELECT * FROM intitules_etapes_departs ','code_etape',$etape,$connexion,'libelle_etape');
		 }
		else
		{
		echo affichechamp('Etape','aff_etape',$etape,'2',1);
		echo afficheonlychampsql('Libellé Etape','aff_libetape',"SELECT * FROM intitules_etapes_departs where code_etape='".$etape."' ",'libelle_etape',$connexion,$taille=40)	;
		}		
	
        echo "</tr><tr>";				
                echo afficheonly("","L'étudiant",'b' ,'h1');

        echo "</tr><tr>";
        echo affichechamp('Nom étudiant','nom_etudiant',$nom_etudiant." ".$prenom_etudiant,'30',1);
		echo affichechamp('Année','annee_etudiant',$annee_etudiant,'30',1);
		echo "</tr><tr>";
        echo affichechamp('Email étudiant','mail_etudiant',$mail_etudiant,'30',1);
		 		       echo "</tr><tr>";   
		echo affichechamp('Téléphone sur place','tel_surplace',$tel_surplace,15);
		echo affichechamp('Email hors GI','email_permanent',$email_permanent,40);
			echo "</tr><tr>";
		echo affichechamp('Adresse sur place','adr_surplace',$adr_surplace,60);       
		        echo "      </tr><tr> ";  
		
		if ($lib_bourse!=''){
				echo affichechamp('Boursier','lib_bourse',$lib_bourse,'40',1);
        echo "      </tr><tr> ";    
       		}
                echo afficheonly("","Avant le départ",'b' ,'h1');
        echo "</tr><tr>";   
echo affichechamp('Université','nom_universite',$nom_universite,'40',1);
echo affichechamp('Pays','libelle_pays',$libelle_pays,'25',1);		
echo affichemenu('Année de départ','annee_scolaire',$annees_liste,$annee_scolaire);  	  
        echo "</tr><tr>";   
        echo affichechamp('Date debut au plus tôt(jj/mm/aa)','date_depart',$date_depart,10);
        echo affichechamp('Date fin au plus tard(jj/mm/aa)' ,'date_retour',$date_retour,10);
		
		echo affichemenu('Semestre de départ','semestre',$tab_semestres,$semestre);
		//echo affichemenusql('Semestre de départ','semestre','pdp_libelle',"select * from periodes_departs order by pdp_nouveautype desc ",'pdp_libelle',$semestre,$connexion);
	        echo "</tr><tr>";  
   	   echo affichemenu('Double diplome','dd',$ouinon,$dd);	
   	   echo affichemenu('Master','master',$ouinon,$master);		
		echo  affichemenusqlplusnc('Référent','uid_enseignant','uid_prof','select * from enseignants where enActivite<>\'non\' order by nom','nom',$uid_enseignant,$connexion,'prenom');	
	        echo "</tr><tr>";  
   	   echo affichemenu('Envoi du mail aux partenaires','envoi_mail_univ_parten',$ouinon,$envoi_mail_univ_parten);		
   	   echo affichemenu('Dossier candidature OK','Dossier_OK',$ouinon,$Dossier_OK);		   
	   echo affichemenu('Dossier Bourse','dossier_bourse',$ouinon,$dossier_bourse);		
			echo "</tr><tr>";
	   echo affichemenu('Réponse université d\'accueil','reponse_univ_accueil',$ouinon,$reponse_univ_accueil);	
	   echo affichemenu('Validation départ par jury','validation_depart_jury',$ouinonenattente,$validation_depart_jury);	   
	   	echo affichemenu('Validation du départ par étudiant','validation_depart_etud',$ouinon,$validation_depart_etud);
			echo "</tr><tr>";
		echo afficheonly("","Programme d'études prévisionnel ",'b' ,'h1');
	echo "</tr><tr>";
	echo "<td></td>";
	
	echo "</tr><tr>";
	echo"<td colspan =3>" ;	
	echo "<table class='table1'>";
	echo "<th>Code cours</th><th>Intitule</th><th>Niveau</th><th>Nbre de crédits (ECTS ou autre)</th>";
		 if ($etape <=2 )
		 {
	 $query2 = "SELECT * FROM cours_departs where code_depart = ".$code_depart  ;
		 }
		 else
		 {
	 $query2 = "SELECT * FROM cours_departs where code_depart = ".$code_depart  ." and verrouille='oui'";			 
		 }
    $result2 = mysql_query($query2,$connexion ); 
$listecours='';	
	while($u=mysql_fetch_object($result2)) {
$listecours.=$u->intitule_cours ."\r\n" ;
echo"   <tr><td>" ;  
      echo  $u->code_cours_long;
      echo"   </td><td>" ;
     echo  $u->intitule_cours  ;
      echo"   </td><td>" ;
     echo  $u->niveau  ;
      echo"   </td><td>" ;	  
      echo $u->ects ;
     echo"        </td> </tr>";
	 }

	echo"</table>";
		echo "<input type='hidden' name='listecours' value=\"".$listecours."\" >";
	echo"   </td>" ; 
	echo "</tr><tr>";
	if($etape <=2 )
	{
		echo"<td> <a href=cours_depart.php?code_depart=".$code_depart."&code_etu=".$code_etudiant."&clone=".$_GET['clone'].">Détails-Ajouter-Modifier les cours de  ".$nom_etudiant." ".$prenom_etudiant. "</a></td>";
	}
	echo "</tr><tr>";

		if(($login==$uid_enseignant and $etape ==2 ) or  (in_array($login,$ri_user_liste) and $etape ==2 ))
		{

			echo "<td colspan=3><label for=\"commentaire_validation\">Commentaire de l'enseignant<br>.</label><textarea  row = \"4\" cols=\"90\" name=commentaire_validation id=commentaire_validation></textarea></td>";
			echo "</tr><tr colspan=3>";
			echo "<td colspan=3>";
			echo"       <input type=\"Submit\" name=\"OKcours\" value=\"Je valide ce programme de cours\">";	
			echo"       <input type=\"Submit\" name=\"PASOKcours\" value=\"Je ne valide pas ce programme de cours\">";	

		}
	
			echo "</td>";
				echo "</tr><tr>";
		echo afficheonly("","Après le départ",'b' ,'h1');
		echo "</tr><tr>";
		echo affichemenu('Validation arrivée','validation_arrivee',$ouinon,$validation_arrivee)	;	
		echo "</tr><tr>";
		
		echo "<td colspan=2><label for=\"commentaire_arrivee\">Commentaire validation d'arrivée (facultatif)<br>.</label><textarea  row = \"6\" cols=\"90\" name=commentaire_arrivee id=commentaire_arrivee>".$commentaire_arrivee."</textarea></td>";	
	echo "</tr><tr>";	
	if($etape >=3 )
	{	
				echo afficheonly("","Programme d'études final",'b' ,'h1');
			echo "</tr><tr>";
			echo "<td></td>";
			
			echo "</tr><tr>";
			echo"<td colspan =3>" ;	
			echo "<table class='table1'>";
			echo "<th>Code cours</th><th>Intitule</th><th>Niveau</th><th>Nbre de crédits (ECTS ou autre)</th>";
			 $query2 = "select * from cours_departs where code_depart = ".$code_depart ." and verrouille!='oui'";
			// echo $query2;
			// on passe en hidden la liste des cours 
			$result2 = mysql_query($query2,$connexion ); 
			$listecours2='';	
			while($u=mysql_fetch_object($result2)) {
			$listecours2.=$u->intitule_cours ."\r\n" ;
			echo"   <tr><td>" ;  
			  echo  $u->code_cours_long;
			  echo"   </td><td>" ;
			 echo  $u->intitule_cours  ;
			  echo"   </td><td>" ;
			 echo  $u->niveau  ;
			  echo"   </td><td>" ;	  
			  echo $u->ects ;
			 echo"        </td> </tr>";
			 }
			echo"</table>";
			echo "<input type='hidden' name='listecours2' value=\"".$listecours2."\" >";
			echo"   </td>" ; 
			echo "</tr><tr>";
			echo"<td> <a href=cours_depart.php?code_depart=".$code_depart."&code_etu=".$code_etudiant."&clone=".$_GET['clone'].">Détails-Ajouter-Modifier les cours de  ".$nom_etudiant." ".$prenom_etudiant. "</a></td>";
			echo "</tr><tr>";			
	}
	
			if(($login==$uid_enseignant and $etape ==7 ) or  (in_array($login,$ri_user_liste) and $etape ==7 ))
		{

			echo "<td colspan=3><label for=\"commentaire_validation\">Commentaire de l'enseignant<br>.</label><textarea  row = \"4\" cols=\"90\" name=commentaire_validation id=commentaire_validation></textarea></td>";
			echo "</tr><tr colspan=3>";
			echo "<td colspan=3>";
			echo"       <input type=\"Submit\" name=\"OKcoursv2\" value=\"Je valide ce programme de cours après arrivée\">";	
			echo"       <input type=\"Submit\" name=\"PASOKcoursv2\" value=\"Je ne valide pas ce programme de cours après arrivée\">";	

		}	
	
			echo "</td>";
		echo "</tr><tr colspan=2>";		
		echo "<td colspan=2><label for=\"bilan_mi_sejour\">bilan_mi_sejour<br>.</label><textarea  row = \"10\" cols=\"90\" name=bilan_mi_sejour id=bilan_mi_sejour>".$bilan_mi_sejour."</textarea></td>";
			echo "</tr><tr colspan=2>";
		//echo affichemenu('Bilan mi séjour','bilan_mi_sejour',$ouinon,$bilan_mi_sejour);			

				echo "</tr><tr>";
			echo affichemenu('Contribution WiKi RI élève','contribwiki_etud',$ouinon,$contribwiki_etud);				
			echo affichemenu('Validation de la Contribution WiKi RI','contrib_wiki',$ouinon,$contrib_wiki);
			
				echo "</tr><tr>";
		echo affichechamp('Note M2e (sur 20)','note_m2e',$note_m2e,5);
		echo affichechamp('Note Mp2e (sur 20)','note_mp2e',$note_mp2e,5);
		echo affichechamp('Note totale (sur 20)','note_totale',$note_totale,5);
		echo "</tr><tr>";
		 echo affichemenu('Réception bulletin','reception_bulletin',$ouinon,$reception_bulletin);
		 echo affichemenu('Validation des ECTS','validation_ECTS',$ouinon,$validation_ECTS)	;	   

		 echo "</tr><tr >";
		echo "<td colspan=2><label for=\"decision_finale_commentaire\">commentaire sur validation finale<br>.</label><textarea  row = \"6\" cols=\"90\" name=decision_finale_commentaire id=decision_finale_commentaire>".$decision_finale_commentaire."</textarea></td>";		 
		 echo affichemenunc('Validation finale du jury','decision_finale',$ouinon,$decision_finale)	;	 

			echo "</tr><tr colspan=2>";			 
		echo "</tr><tr>";
		echo "<td colspan=3><label for=\"log_workflow\">Historique<br>.</label><textarea readonly row = \"8\" cols=\"150\" name=log_workflow id=log_workflow>".$log_workflow."</textarea></td>";
		echo "</tr><tr>";
		
		
		
		
		
		
        echo affichechamp('modifié par','modifpar',$modifpar,'20',1);

        echo affichechamp('le','date_modif',$date_modif,'15',1);
        
        echo "</tr><tr>";
        echo"        <th colspan=5>";
			 if(in_array($login,$ri_user_liste)){
               echo"  <input type='Submit' name='modif' value='modifier'>";
			 }
			   echo "<input type='Submit' name='bouton_annul' value='Annuler'>
                </th>
            </tr></table>
        </form> "  ;
}
 elseif($_GET['add']!='' or $_POST['add']!=''){ 
 //--------------------------------------------------------------------------------------------------------------------------c'est kon a cliqué sur ajouter
 $afficheliste=0;

 if($login == 'administrateur' or in_array($login,$ri_user_liste)){
//on initialise les variables de tous les champs
 foreach($champs as $ci2){
 $$ci2='';
}
 //echo"<input type='hidden' name='ajout' value=1>";
  echo    "<form method=post action=$URL> "; 
  		if ( $_GET['an']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='an' value=".$_GET['an'].">";}
        echo"       <table>";
        echo "</tr><tr><td>";   


     //on arrive pas par fiche.php donc on affiche le select avec toutes les periodes

             echo "<br>  Université <br><select name='code_periode'>  ";
   for($i=0;$i<sizeof($universites_code2);$i++) {
        $temp=$universites_code2[$i];
	 echo "  <option  value=\"".$temp."\"";
	   if  ($universites_nom[$temp]== 'NC' ){
       echo " SELECTED "; }
        echo ">";
    // echo "  <option value=\"$temp\">";
     echo $universites_nom[$temp]."--".$universites_ville[$temp];


      echo"</option> " ;
    }
   echo"</select> " ;
           echo "</tr><tr>"; 
   	   echo affichemenu('Semestre de départ','semestre',$tab_semestres,'NC');
	  //echo affichemenusql('Semestre de départ','semestre','pdp_libelle',"select * from periodes_departs order by pdp_nouveautype desc ,pdp_libelle ",'pdp_libelle','NC',$connexion);
           echo "</tr><tr>";
         echo "</td><td>";
       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
         $temp= $_GET['code_etu'] ;
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";
        echo"<input type='hidden' name='code_etudiant' value='".$_GET['code_etu']."'>";
     //on arrive par fiche.php donc on affiche directement le nom de l'etudiant
      echo " Etudiant<br> <input type='text' readonly  name='affiche_nom_etudiant' value=\"$etudiants_nom[$temp]\">  ";
    }
    else{
    //on arrive pas par fiche.php donc on affiche le select avec tous les etudiants
    echo " Etudiant<br> <select name='code_etudiant'>  ";

   for($i=0;$i<sizeof($etudiants_code2);$i++) {
 $temp= $etudiants_code2[$i];
      echo "  <option  value=\"".$temp."\">";
    echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp]);
    echo"</option> " ;
 }
      echo"</select> " ;
}


        
     echo "</tr><tr>";
     //echo "<td align=center><a href=entreprises.php?add=1&fromstage=1&code_etu=".$_GET['code_etu'].">    La période  n'est pas dans la liste</a>";

            echo "</tr><tr>";
    
   $date_depart='NC';
      $date_retour='NC';
	  echo affichemenu('Année de départ','annee_scolaire',$annees_liste,$annees_liste[0]);  
	  echo "</tr><tr>";  
   echo affichechamp('date debut (jj/mm/aa)','date_depart',$date_depart,10);
    echo affichechamp('date fin (jj/mm/aa)','date_retour',$date_retour,10);
echo "</tr><tr>";  
   	   echo affichemenu('Double diplome','dd',$ouinon,$dd);	
   	   echo affichemenu('Master','master',$ouinon,$master);		
 
   echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='ajout' value='Ajouter'><input type='Submit' name='bouton_annul' value='Annuler'>
            </th>
         </tr></table> ";
      echo"   </form> "  ;

         }
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==

      }//fin du ajouter
	  
elseif($_GET['addfromvoeux']!='' ){ 
 //--------------------------------------------------------------------------------------------------------------------------c'est kon arrive directement depuis les voeux
 $afficheliste=0;
 if($login == 'administrateur' or in_array($login,$ri_user_liste)){
//on initialise les variables de tous les champs
 foreach($champs as $ci2){
 $$ci2='';
}
// on récupère les champs envoyés depuis le formulaire des voeux
$_GET['code_etu']= $_POST['v_num_etudiant'];
// sur quel bouton a t on appuyé ?
//echo "test : ".$_POST['bouton_creedepart']."<br>";
$anneelimite=substr($_POST['affdatelimite'],-4);
$periodechoisie=($anneelimite)."-".($anneelimite+1);
$univchoisie=$_POST['v_voeux'.$_POST['bouton_creedepart']];
$semchoisi=$_POST['v_voeux'.$_POST['bouton_creedepart'].'_periode'];
//echo "test : ".$_POST['v_voeux'.$_POST['bouton_creedepart']]."<br>";
 //echo"<input type='hidden' name='ajout' value=1>";
		echo    "<form method=post action=$URL> "; 
  		if ( $_GET['an']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='an' value=".$_GET['an'].">";}

        echo"       <table>";
        echo "</tr><tr>";   
		echo affichemenusql('Université','code_periode','id_uni','SELECT * FROM universite','nom_uni',$univchoisie,$connexion);
           echo "</tr><tr>"; 
   	   echo affichemenu('Semestre de départ','semestre',$tab_semestres,$semchoisi);
	  //echo affichemenusql('Semestre de départ','semestre','pdp_libelle',"select * from periodes_departs order by pdp_nouveautype desc ,pdp_libelle ",'pdp_libelle','NC',$connexion);
           echo "</tr><tr>";
         echo "</td><td>";
       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
         $temp= $_GET['code_etu'] ;
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";
        echo"<input type='hidden' name='code_etudiant' value='".$_GET['code_etu']."'>";
     //on arrive par fiche.php donc on affiche directement le nom de l'etudiant
      echo " Etudiant<br> <input type='text' readonly  name='affiche_nom_etudiant' value=\"$etudiants_nom[$temp]\">  ";
    }        
     echo "</tr><tr>";
     //echo "<td align=center><a href=entreprises.php?add=1&fromstage=1&code_etu=".$_GET['code_etu'].">    La période  n'est pas dans la liste</a>";
            echo "</tr><tr>";  
	  echo affichemenu('Année de départ','annee_scolaire',$annees_liste,$periodechoisie);  
	  echo "</tr><tr>";  
   echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='ajoutfromvoeux' value='Ajouter'><input type='Submit' name='bouton_annul' value='Annuler'>
            </th>
         </tr></table> ";
      echo"   </form> "  ;

         }
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==

      }	  
	  
	  
//-----------------------------------------------------------------------------------------------recherche avancee---------------------------------------------------------------------------------------   
	
echo  "<FORM  action=".$self." method=GET name='monform'> ";		
	   if($_GET["st_recherche_avance"]=="oui"){
 echo "<a href=".$self."?st_recherche_avance=non&st_bouton_ok=OK>recherche simple</a><br>";
 //on remet la valeur ds le formulaire en cache pour la conserver
 echo "<input type=hidden name=st_recherche_avance value='oui'> ";
    echo "<br>";
  if($_GET["st_mon_champ"]==""){
  $_GET["st_mon_champ"]="date_depart";}
echo " <select name='st_mon_champ'  onchange='monform.submit()'>  ";
for($i=0;$i<sizeof($st_champs);$i++) {
    echo "  <option ";
    //pour la premiere fois
    if($_GET["st_mon_champ"]==$st_champs[$i]){
         echo "SELECTED";}
    echo">";
    echo  $st_champs[$i];
    echo"</option> " ;
    }
echo "</select> ";

$temp= urldecode($_GET['st_mon_champ']);

$sqlquery2="SELECT distinct `".$temp ."` FROM ".$table."  order by  `".$temp ."` desc";

//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion);

echo "est égal à  ";
echo " <select name='st_recherche'>  ";
while($e=mysql_fetch_object($resultat2)){
$valeur= $e->$temp;
if ($valeur==''){
  $valeuraffichee='vide';}
  else{
  $valeuraffichee=$valeur;}
if (in_array($_GET["st_mon_champ"],$liste_champs_dates_courts)) {
$valeuraffichee=mysql_datetime($valeur);
}
if (in_array($_GET["st_mon_champ"],$liste_champs_dates_longs)) {
$valeuraffichee=mysql_time_sec($valeur);
}

 echo "  <option  value="."\"".$valeur."\"";
 //a cause des apotsrophes  dsles donnees apogee
 if(($_GET['st_recherche'])==$valeur){
         echo "SELECTED";}

    echo  ">".$valeuraffichee."</option> ";

}
	  echo"     <input type ='submit' name='st_bouton_ok'  value='OK'> <br> "  ;
  } //fin du if recherche avancee
  else {
  //on n'affiche le lienrecherche avancee pas en modif et pas quand on masque la liste et pas en retour de codepostagl
  if ($_GET['add']!='1' and $afficheliste ){
   echo "<center><a class='abs' href=".$self."?st_recherche_avance=oui>recherche avancée</a></center>";}
    echo "<input type=hidden name=st_recherche_avance value='non'> ";
  } //fin du else  recherche avancee


  
	echo "</form><br/>";   
	   
	  
	  
 //___________________________________AFFICHAGE TABLEAU_______________________________	
if  ($_GET['st_bouton_ok']=="OK" or ($_GET['st_recherche_avance']!="oui"  and  $_GET['add']!='1' and  $_GET['addfromvoeux']!='1' ) ){	
	  	     if ($afficheliste){
    $query = "SELECT etudiants.Nom AS nom_etud ,etudiants.`prénom 1` AS prenom_etud ,etudiants_scol.*,universite.nom_uni   , annuaire.`Mail effectif`,$table.*,pays.* FROM $table  
	 left outer join etudiants on upper(etudiants.`Code etu`)=departs.code_etudiant       
	 left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code 
	left outer join universite on  code_periode=universite.id_uni
	left outer join pays on  universite.id_pays=pays.id_pays
	left outer JOIN annuaire  ON departs.code_etudiant = annuaire.`Code-etu`  where '1'='1'
	 ";
	 $query.=$where.$orderby;
	//echo $query;
  $result=mysql_query($query,$connexion );
  $i=1;
        $nombre=  mysql_num_rows($result);
         echo"  <h1 class='titrePage2'>Liste des $nombre departs à l'etranger ".$message_entete."</h1>";
        echo "<table class='table1'><tr bgcolor=\"#98B5FF\" > ";

         echo" <tr>";
		 if   ($_GET['st_orderby']=='etudiants.nom' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=etudiants.nom&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Nom</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=etudiants.nom&st_bouton_ok=OK".$filtre.">Nom</a></th> ";}

		 if   ($_GET['st_orderby']=='etudiants_scol.annee' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=etudiants_scol.annee&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Année</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=etudiants_scol.annee&st_bouton_ok=OK".$filtre.">Année</a></th> ";}

		 if   ($_GET['st_orderby']=='pays.libelle_pays' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=pays.libelle_pays&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Pays</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=pays.libelle_pays&st_bouton_ok=OK".$filtre.">Pays</a></th> ";}

 if   ($_GET['st_orderby']=='type_de_stage' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=universite.nom_uni&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Université</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=universite.nom_uni&st_bouton_ok=OK".$filtre.">Université</a></th> ";}

 if   ($_GET['st_orderby']=='date_depart' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=date_depart&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Départ</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=date_depart&st_bouton_ok=OK".$filtre.">Départ</a></th> ";}

 if   ($_GET['st_orderby']=='date_fin' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=date_retour&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Fin</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=date_retour&st_bouton_ok=OK".$filtre.">Fin</a></th> ";}

 if   ($_GET['st_orderby']=='semestre' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=semestre&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Période</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=semestre&st_bouton_ok=OK".$filtre.">Période</a></th> ";}
echo "<th>DD ou Master</th> ";
 if   ($_GET['st_orderby']=='etape' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=etape&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Etape</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=etape&st_bouton_ok=OK".$filtre.">Etape</a></th> ";}


		//echo"</th><th>action</th></tr>";
		
//pour l'export CSV
//on ecrit d'abord les  noms des colonnes
//Premiere ligne = nom des champs (si on en a besoin)
//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
//for($i=0;$i<sizeof($champs);$i++) {
//$csv_output .= $champs[$i].";";}
$csv_output = "nom;prenom;annee;universite;";
for($i=0;$i<sizeof($st_champs);$i++) {
 if (!in_array ($st_champs[$i] ,$liste_champs_exclus_csv )){
  
 $csv_output .= $st_champs[$i].";" ; }
 }
    
$csv_output .= "\n";

		
		
      while($e=mysql_fetch_object($result)) {
		  
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// il faut récupérer le nombre de docs associés au départ
	
	$req2 = "SELECT * FROM departsdocuments  where  	doc_idDepart ='".$e->code_depart."' ";
		$result2 = mysql_query($req2,$connexion ); 
	$nombreDocs= mysql_num_rows($result2);

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		  
		  
		  
      $prenom_etudiant=$e->prenom_etud;
        $nom_etudiant=$e->nom_etud;
		$annee_etudiant=$e->annee;
        $code_etudiant= $e->code_etudiant;
        //$code_universite= $e->id_uni;
        $code_depart= $e->code_depart;
        $date_depart=mysql_DateTime($e->date_depart)  ;
        $date_fin=mysql_DateTime($e->date_retour) ;
        $nom_universite=$e->nom_uni;
		        //$periode=$e->sem_depart;
				$semestre=$e->semestre;
				$dd=$e->dd;
				$master=$e->master;
				$etape=$e->etape;
				//on calcule les champs calculés
		if ($dd=='oui' or $master=='oui' ){
	 $ddmaster='oui';}else{$ddmaster='-';}
     
	 $libelle_pays=$e->libelle_pays;
				
				
        //$type_de_stage=$e->type_de_stage;
         //$etape=$e->etape;
$csv_output .= $nom_etudiant.";".$prenom_etudiant.";".$annee_etudiant.";".$nom_universite.";";
for($i=0;$i<sizeof($st_champs);$i++) {
$val_csv=str_replace("\r\n"," ",$e->{$st_champs[$i]});
// si c'est un champ date 
 
  if (in_array ($st_champs[$i] ,$liste_champs_exclus_csv )){
  }
  elseif (in_array ($st_champs[$i] ,$liste_champs_dates_courts ))
 {
 //on transforme les dates sql en dd/mm/yy
 $val_csv=mysql_DateTime($e->{$st_champs[$i]});
 $csv_output .= $val_csv.";" ; 
 } else{
  $val_csv=$e->{$st_champs[$i]};
 $csv_output .= $val_csv.";" ; 
 }
 
    
	}
$csv_output .= "\n";		 
		 
              echo"<tr><td><a class='abs' href=fiche.php?code=". $code_etudiant.">". $nom_etudiant." ".$prenom_etudiant."</a> </td><td> ".$annee_etudiant." </td><td> ".$libelle_pays." </td><td> ".$nom_universite." </td><td> ".$date_depart." </td><td> ".$date_fin." </td><td> ".$semestre." </td><td> ".$ddmaster ." </td><td> ".$etape ;
        echo "   </td><td nowrap>";
		     echo "<a class='abs' href=cours_depart.php?code_depart=".$code_depart."&code_etu=".$_GET['code_etu'].">Cours</A>";
	  echo"      </td><td nowrap> ";
	  	 if(in_array($login,$ri_user_liste)){
         echo "<A class='abs2' href=".$URL."?del=".$code_depart."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_periode']."&an=".$_GET['an'];

         echo" onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce départ ?')\">Sup</A> - ";
		 }
		 if ($_GET['clone']!='')
			 {
			 echo "<A class='abs2' href=".$URL."?mod=".$code_depart."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_periode']."&an=".$_GET['an']."&clone=".$_GET['clone']."&vuetut=".$_GET['vuetut'];
			 }
			 else // on masque &clone si vide
			 {
			echo "<A  class='abs1' href=".$URL."?mod=".$code_depart."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_periode']."&an=".$_GET['an']."&vuetut=".$_GET['vuetut'];	 
			 }
          echo ">Détails</A> ";
		  
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 	 	  
     echo "<A class='abs' href=documentdepart.php?offre=".$e->code_depart."from=gest > Docs(".$nombreDocs. ").</A>";	
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		echo "  </td></tr> ";
       $i++; 
	   }
	   
	   if($login == 'administrateur' or in_array($login,$ri_user_liste)){
	
	   echo  "<center><FORM  action=export.php method=POST name='form_export'> </center>";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='EXPORT vers EXCEL'> <br> "  ;
echo "</form>";
}
       echo "</table> ";
      }
	  } //fin du affiche liste

 echo "</td></tr></table>";
 mysql_close($connexion);
 require('footer.php');
 ?>
</body>
</html>
