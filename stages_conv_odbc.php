<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>gestion des stages</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">

<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
//si on vient de la fiche.php on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
if (isset($_GET['fromfic'])){
 $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);
$filtreok=$filtre."&bouton_ok=OK";
}
else{
$filtre='';
$filtreok='';
}
$liste_champs_dates=array('date_debut' ,'date_fin','date_envoi' ,'date_reception','interruption_debut' ,'interruption_fin' ,'date_depot_fiche_verte','date_depot_fiche_confident','date_debut_avenant','date_fin_avenant','soutenance_date' ,'courrier_debut_date' ,'soutenance_date_envoi' ,'date_rdv_1jour','date_demande','debut_echange','fin_echange');
$liste_champs_dates_courts=array('date_debut' ,'date_fin','date_envoi' ,'date_reception','interruption_debut' ,'interruption_fin' ,'date_depot_fiche_verte','date_depot_fiche_confident','date_debut_avenant','date_fin_avenant','soutenance_date' ,'courrier_debut_date' ,'soutenance_date_envoi' ,'date_rdv_1jour','debut_echange','fin_echange');
$liste_champs_dates_longs=array('date_modif','date_demande');
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
if (!isset($_POST['code_ent_filtre'])) $_POST['code_ent_filtre']='';
if (!isset($_POST['bouton_cp_mod'])) $_POST['bouton_cp_mod']='';
if (!isset($_POST['bouton_cp_adm_mod'])) $_POST['bouton_cp_adm_mod']='';
if (!isset($_POST['bouton_cp'])) $_POST['bouton_cp']='';
if (!isset($_POST['bouton_cp_adm'])) $_POST['bouton_cp_adm']='';
if (!isset($_POST['bouton_cp_add'])) $_POST['bouton_cp_add']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_ent'])) $_GET['code_ent']='';
if (!isset($_GET['nom_ent'])) $_GET['nom_ent']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_GET['add'])) $_GET['add']='';
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

$URL =$_SERVER['PHP_SELF'];
$table="stages";

$tabletemp="stages";
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

//on remplit 2 tableaux avec les nom-code stages
$sqlquery2="SELECT * FROM intitules_stage order by code";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["libelle"] ;
$ind2=$v["code"];
//on remplit 2 tableaux associatifs avec les noms-codes libelle pour le select du formulaire
$libelle_stage[$ind2]=$v["libelle"];
$code_libelle[$ind]=$v["code"];}
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
//on remplit 2 tableaux avec les noms-codes entreprises
$sqlquery2="SELECT * FROM entreprises order by nom ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom"] ;
$ind2=$v["code"];
//on remplit un tableau associatif avec les noms entreprises pour le select du formulaire
$entreprises_nom[$ind2]=$v["nom"];
$entreprises_ville[$ind2]=$v["ville"];
//on remplit un tableau associatif avec les codes entreprises pour le insert
$entreprises_code[$ind]=$v["code"];
$entreprises_code2[]=$v["code"];
}

//si on revient de creation d'entreprise (à partir du lien ci dessous section ajouter) on recupere le code cree
if ($_GET['nom_ent']!=''){
$_GET['code_ent'] = $entreprises_code[urldecode(stripslashes($_GET['nom_ent']))]  ;
}
//on remplit 2 tableaux avec les noms-codes enseignants
$sqlquery2="SELECT * FROM enseignants order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom"] ;
$ind2=$v["id"];
//on remplit 3 tableaux associatif avec les noms enseignants pour le select du formulaire
$enseignants_nom[$ind2]=$v["nom"];
$enseignants_prenom[$ind2]=$v["prenom"];
$enseignants_email[$ind2]=$v["email"];
//on remplit un tableau associatif avec les codes enseignants pour le insert
$enseignants_code[$ind]=$v["id"];}
//est ce bien utile ?
$tabletemp="stages";
$st_champs=champsfromtable($tabletemp);




if($_POST['ajout']!='') { // ------------Ajout de la fiche--------------------
if($login == 'administrateur' or $login ==$ent_user){

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

   if ($ci2=="code_stage"){
 
 //on calcule le nouveau code stage
    $sqlquery="SELECT     MAX(code_stage) AS Expr1
FROM         stages ";
$resulmax=mysql_query($sqlquery,$connexion ); 
$e=mysql_fetch_object($resulmax);
    //$flg = mysql_fetch_row($resulmax);
    $max = $e->Expr1;
$_POST[$ci2] =  $max+1;
 }
if ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(), ";}

  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  $query = "INSERT INTO $table($sql1)";
  $query .= " VALUES($sql2)";

   $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
}
   else{
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucun ajout effectuée<br></center>";

} //fin du else $login ==
}
elseif($_GET['del']!='') { //--------------- Suppression de la fiche--------------------

if($login == 'administrateur' or $login ==$ent_user){
   $query = "DELETE FROM $table"
      ." WHERE code_stage='".$_GET['del']."'";
	     $result = mysql_query($query,$connexion ); 
		 echo afficheresultatsql($result,$connexion);
		 } 
   else{
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune suppression effectuée<br></center>";

} //fin du else $login ==
}

elseif($_POST['modif']!='') { //---------------- Modif de la fiche---------------------
if($login == 'administrateur' or $login ==$ent_user){
//pour modifpar
$_POST['modifpar']=$login;

//si on etait en etape=1 on passe etape à 2 et on envoie un mail  à la cellule(la cellule a validé à la place du prof)
if( $_POST['etape_sauv']=="1" ) {
$_POST['etape']="2"  ;
// On prepare l'email : on initialise les variables
$temp= $_POST['code_tuteur_gi']  ;

$objet = "passage manuel d'un  stage en etape 2  " ;
$messagem = "Le stage de".$_POST['nom_etudiant']." chez ".$_POST['nom_entreprise']." \n" ;
$messagem .= " vient d'etre validé par $login "." \n" ;
$messagem .= " : ".$url_personnel."etustages.php?mod=".$_POST['code_stage']."\n";

// On envoie l’email
envoimail($entmail,$objet,$messagem);
//envoimail($_POST['mail_etudiant'],$objet,$messagem);
}
// si il y a eu un changement d'etape on le note dans dans l'historique
if( $_POST['etape_sauv']!=$_POST['etape'] ) {
$_POST['historique'].=  "Etape ".$_POST['etape_sauv']." ->" .$_POST['etape'] ." par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\n";
}
//pour code etudiant et entreprise on a les noms mais pas les codes :
//il faut les retrouver ds le tableau associatif
//$etnom=$_POST['nom_etudiant'] ;
//$_POST['code_etudiant']= $etudiants_code[$etnom];


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
 if ($ci2=="code_stage"){
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
   $query .= " WHERE code_stage='".$_POST['code_stage']."' ";
 //  echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_stage']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>Le stage n'est pas modifié</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations industrielles peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==

}
elseif($_POST['imp_convention']!='') { //---------------- impression convention---------------------

//on verifie qu'on est en etape 3 ou plus
if ($_POST['etape']>='3'){
echo "on prepare l'impression de la convention<br>";
//on efface d'abord  les lignes de mailing_convention
 $query = "DELETE FROM mailing_convention";
 $result = mysql_query($query,$connexion);

foreach($champs as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour les dates NC on ne met rien
 if ($_POST[$ci2]=='NC'){$_POST[$ci2]='';}
} 
// pour les champs qui ne sont pas dans la table stage
	$_POST['statut_tuteur_gi']= str_replace("'","''",stripslashes($_POST['statut_tuteur_gi'])); 
		$_POST['tel_etudiant']= str_replace("'","''",stripslashes($_POST['tel_etudiant'])); 
	$_POST['adresse_fixe_etudiant']= str_replace("'","''",stripslashes($_POST['adresse_fixe_etudiant'])); 
	$_POST['adf_rue2_etudiant']= str_replace("'","''",stripslashes($_POST['adf_rue2_etudiant'])); 
	$_POST['adf_rue3_etudiant']= str_replace("'","''",stripslashes($_POST['adf_rue3_etudiant'])); 
	$_POST['adf_lib_commune_etudiant']= str_replace("'","''",stripslashes($_POST['adf_lib_commune_etudiant'])); 
		$_POST['mail_etudiant']= str_replace("'","''",stripslashes($_POST['mail_etudiant'])); 
		$etudiants_nom_conv=str_replace("'","''",stripslashes($etudiants_nom[$_POST['code_etudiant']]));
		$etudiants_prenom_conv=str_replace("'","''",stripslashes($etudiants_prenom[$_POST['code_etudiant']]));
		$entreprises_nom_conv=str_replace("'","''",stripslashes($entreprises_nom[$_POST['code_entreprise']]));
//on recopie ensuite les donnees de la fiche stage en cours
$query = "INSERT  INTO mailing_convention(nomeleve,prenomeleve,entreprise,adresserespADM,CPrespADM,RESPONSABLE_ADMINISTRATIF,sujet,";
$query.="adressestage,Cpstage,du,au,periodesemaines,interruption_prévue_du,interruption_prévue_au,";
$query.="TUTEUR_INDUS,TUTEURGI,qualitéindus,qualitéGI,telGI4n,mailGI,";
$query.="TelADM,FaxADM,MailADM,telindus,faxindus,mailindus,";
$query.="tel_etudiant,adresse_fixe_etudiant,adf_rue2_etudiant,adf_rue3_etudiant,adf_code_bdi_etudiant,mail_etudiant,adf_lib_commune_etudiant)";
$query.=" VALUES('";
//$query.=$etudiants_nom[$_POST['code_etudiant']]."','";
$query.=$etudiants_nom_conv."','";
//$query.=$etudiants_prenom[$_POST['code_etudiant']]."','";
$query.=$etudiants_prenom_conv."','";
//$query.=$entreprises_nom[$_POST['code_entreprise']]."','";
$query.=$entreprises_nom_conv."','";
$query.=$_POST['resp_adm_adresse1']." ".$_POST['resp_adm_adresse2']."','";
$query.=$_POST['resp_adm_code_postal']." ".$_POST['resp_adm_ville']."','";
$query.=$_POST['resp_adm']."','";
$query.=$_POST['sujet']."','";
$query.=$_POST['adresse1']." ".$_POST['adresse2']."','";
$query.=$_POST['code_postal']." ".$_POST['ville']."','";
$query.=$_POST['date_debut']."','"; 
$query.=$_POST['date_fin']."','"; 
$query.=diffdate($_POST['date_debut'],$_POST['date_fin'])."','"; 
$query.=$_POST['interruption_debut']."','";  
$query.=$_POST['interruption_fin']."','";  
$query.=$_POST['nom_tuteur_industriel']."','";  
$query.=$enseignants_nom[$_POST['code_tuteur_gi']]." ".$enseignants_prenom[$_POST['code_tuteur_gi']]."','";  
$query.=$_POST['indus_qualite']."','"; 
$query.=$_POST['statut_tuteur_gi']."','"; 
$query.="0476574795"."','"; 
$query.="marie.glorion@ensgi.inpg.fr"."','"; 
$query.=$_POST['resp_tel']."','"; 
$query.=$_POST['resp_fax']."','"; 
$query.=$_POST['resp_mail']."','"; 
$query.=$_POST['telindus']."','"; 
$query.=$_POST['faxindus']."','"; 
$query.=$_POST['email_tuteur_indus']."','"; 
$query.=$_POST['tel_etudiant']."','"; 
$query.=$_POST['adresse_fixe_etudiant']."','"; 
$query.=$_POST['adf_rue2_etudiant']."','"; 
$query.=$_POST['adf_rue3_etudiant']."','"; 
$query.=$_POST['adf_code_bdi_etudiant']."','"; 
$query.=$_POST['mail_etudiant']."','"; 
$query.=$_POST['adf_lib_commune_etudiant']."'"; 

 $query.=")";
//echo $query;
 $result = mysql_query($query,$connexion);
//on passe le stage en etape 4  // il y a eu un changement d'etape on le note dans dans l'historique
$_POST['historique'].=  "Etape 3 ->4 (convention) par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\n";
$query=" UPDATE stages SET etape='4',historique='".$_POST['historique']."'";
 $query .= " WHERE code_stage='".$_POST['code_stage']."' ";
  $result = mysql_query($query,$connexion);
}else
{
echo affichealerte("impossible d'imprimer cette convention : elle n'est pas en étape 3 !");
}
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
  echo "<br><A href=".$URL." > Revenir à la liste des stages </a><br>";

     }else
     {
     if ( $_GET['code_etu']!='') {
     //il faut aussi chercher si l etudiant n'est pas le num 2 ou le num 3 d'un stage etude de terrain
     $where="and (code_etudiant='".$_GET['code_etu']."' or code_etudiant_2='".$_GET['code_etu']. "' or code_etudiant_3='".$_GET['code_etu']. "')"   ;

     $message_entete="de ".$etudiants_nom[$_GET['code_etu']];
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
     //ds les 2 cas on filtre sur le code entreprise
     elseif ( $_GET['code_ent']!='') {
     $where="and code_entreprise='".$_GET['code_ent']."' "   ;
     $message_entete="de ".$entreprises_nom[$_GET['code_ent']];
      }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter
     elseif ( $_POST['code_ent_filtre']!='') {
     $where="and code_entreprise='".$_POST['code_entreprise']."' "   ;
      //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_ent']=$_POST['code_entreprise'];
     $message_entete="de ".$entreprises_nom[$_GET['code_ent']];
     }
      else{
	  //si on est en recherche avancee
	    if($_GET["st_recherche_avance"]=="oui" and $_GET["st_mon_champ"]!=''){
		//il faut traiter le cas recherche avnce est egal à vide
if ($_GET['st_recherche']=='vide') {  $_GET['st_recherche']='';}
// et date est égal à NC 
if ($_GET['st_recherche']=='NC') {  $_GET['st_recherche']='01/01/1900';}
		  $where="and stages.`".$_GET["st_mon_champ"]."` = '".$_GET["st_recherche"]."'";

		}
		//sinon on prend tout
		else{
      $where="";}
	  }
	  
	  

 //------------------------------------c'est kon a cliqué sur le bouton code postal
if($_POST['bouton_cp_add']!='' or $_POST['bouton_cp_mod']!='' or $_POST['bouton_cp_adm_mod']!=''){
$afficheliste=0;
 echo  "<FORM  action=".$URL." method=POST > ";

  //il faut remettre ds le formulaire tous les champs du formulaire source sauf le bouton qui l'a envoyé
  for($i=0;$i<sizeof($_POST);$i++) {
  if ( (key($_POST) != 'bouton_cp_add')and (key($_POST) != 'bouton_cp_mod') and (key($_POST) != 'bouton_cp_adm_mod')){
  //$temp= stripslahes(current($_POST));
  echo"<input type='hidden' name='".key($_POST)."' value=\"".stripslashes(current($_POST))."\">"."\n";
  }
  next($_POST);
  }
  if($_POST['bouton_cp_add']!='') {echo"<input type='hidden' name='add' value='oui'>";}
  if ($_POST['bouton_cp_mod']!=''){echo"<input type='hidden' name='mod' value='oui'>";  }
  if ($_POST['bouton_cp_adm_mod']!=''){echo"<input type='hidden' name='mod' value='oui'>";  }
   //echo "on a cliqué sur le bouton cp";
  echo "<center><b>Vérification des Codes Postaux</b></center>";
if ($_POST['bouton_cp_adm_mod']!=''){
$where="WHERE codep like '".$_POST['resp_adm_code_postal']."%'";
}else{  
$where="WHERE codep like '".$_POST['code_postal']."%'";
}
$sqlquery="SELECT * FROM codepostaux ".$where." order by commune;";

  if(($_POST['bouton_cp_mod']!='' and $_POST['code_postal']!='') or ( $_POST['bouton_cp_adm_mod']!='' and $_POST['resp_adm_code_postal']!='')) 
  {
  $resultat=mysql_query($sqlquery,$connexion ); 
 //tout ça pour compter les renregistrements retournés
//$sqlcount="SELECT * FROM codepostaux ".$where.";";
//$e=mysql_fetch_object($resultat);
    $cnt = mysql_num_rows($resultat);

echo "<center><b>";
if ($cnt<>0){
echo "il y a  <b>$cnt</b> villes qui correspondent à ce code<br> <hr>";
//$index=0;
while($v=mysql_fetch_array($resultat)){
//on remplit 2 tableaux indices
$tabcommune[]=$v["Commune"];
$tabcodep[]=$v["codep"]; }

/* On fabrique le menu deroulant */
echo "<select name=\"villecp\" >";
  for($i=0;$i<sizeof($tabcommune);$i++) {
echo " <option  value=\"".$tabcommune[$i]."_".$tabcodep[$i]."\"\n >";
echo $tabcommune[$i]." ".$tabcodep[$i];
echo "</option>";}
echo "</select>";
if ($_POST['bouton_cp_adm_mod']!=''){
echo "<input type='Submit' name='bouton_cp_adm' value='OK'> ";
echo "<input type='Submit' name='bouton_cp_adm' value='Annuler'> ";
}else{
echo "<input type='Submit' name='bouton_cp' value='OK'> ";
echo "<input type='Submit' name='bouton_cp' value='Annuler'> ";
}
}else
//il ny a pas de corrrespondance
{ echo "il n'y pas de ville avec ce code postal<br>";
if ($_POST['bouton_cp_adm_mod']!=''){
echo "<input type='Submit' name='bouton_cp_adm' value='OK'> ";
}else{
	echo "<input type='Submit' name='bouton_cp' value='OK'> ";
	}
}

 } //fin du if($_POST[code_postal]!="")
 else {
 echo "vous n'avez rien saisi dans le champ code postal";
 echo "<input type='Submit' name='bouton_cp' value='OK'> "; }
 echo "</form>";
 echo "</b></center>";
 }  //fin du if($_POST[bouton_cp_add] ...	   
	   
//____________________________________________________________________________________________________________________________
  //AFFICHAGE DES liens  pour ajouter un stage et revenir a l'accueil si pas mod et si pas retour de code postal
  if ( $_GET['add']!='1' and $_GET['mod']=='' and  $_POST['mod']=='' and $afficheliste) {
  echo "<br><br><A href=".$URL."?add=1&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent']." > Ajouter un stage </a><br><br>";
 echo "<br><A href=default.php?".$filtreok." > Revenir à l'accueil </a><br><br>"; 
 }
  //lien pour revenir
  if ( $_GET['code_etu']!='') {
  //si on arrive depuis fiche.php
     $temp= $_GET['code_etu'] ;
      echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > Revenir à la fiche de ". $etudiants_nom[$temp]."</a><br><br>";
    }
    //si on arrive depuis entreprises
    elseif ( $_GET['code_ent']!='') {
      echo "<A href=entreprises.php > <br>Revenir à la liste des entreprises </a><br><br>";
    }
    //else{
  //dans l tous les  cas
      
	   
	
}//fin du bouton_ok=ok

  if($_GET['mod']!='' or $_POST['mod']!='' ){//--------------------------------------c'est kon a cliqué sur detail ou kon revient du code postal
  $afficheliste=0;
   echo    "<form method=post action=$URL> "; 

  if($_GET['mod'] !=''){
  //si on a cliqué sur détails
  //1ere version de la requete
//   $query = "SELECT etudiants.[Nom],entreprises.[nom],enseignants.[email],$table.* FROM $table,etudiants,entreprises,enseignants where [code_etudiant]=etudiants.[Code etu]
//    and  [code_entreprise]=entreprises.code and  [code_tuteur_gi]=enseignants.id and code_stage=$_GET[mod] order by date_debut";
   $query="SELECT     etudiants.Nom , entreprises.nom ,entreprises.club_indus , enseignants.email , annuaire.`Mail effectif`,enseignants.statut,etudiants.`Ada Num tél`,etudiants.`Adresse fixe`,etudiants.`Adf rue2`,etudiants.`Adf rue3`,etudiants.`Adf code BDI`,etudiants.`Adf lib commune`,entreprises.adresse1 , entreprises.ville ,stages.*
FROM         stages left outer JOIN
                      etudiants ON stages.code_etudiant = etudiants.`Code etu` left outer JOIN
                      entreprises ON stages.code_entreprise = entreprises.code left outer JOIN
                      enseignants ON stages.code_tuteur_gi = enseignants.id  left outer JOIN
                      annuaire  ON stages.code_etudiant = annuaire.`Code-etu` left outer JOIN
                      etudiants_scol ON stages.code_etudiant = etudiants_scol.code
WHERE     stages.code_stage = ".$_GET['mod'];

   $result = mysql_query($query,$connexion );
$e=mysql_fetch_object($result); 
$i=1;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$e->$ci2;
   }
           //on surcharge les dates pour les pbs de format
        $date_debut=mysql_DateTime($e->date_debut)  ;
        $date_fin=mysql_DateTime($e->date_fin) ;
        $date_envoi=mysql_DateTime($e->date_envoi) ;
        $date_reception=mysql_DateTime($e->date_reception) ;
        $soutenance_date=mysql_DateTime($e->soutenance_date) ;
        $date_depot_fiche_verte=mysql_DateTime($e->date_depot_fiche_verte) ;
        $date_depot_fiche_confident=mysql_DateTime($e->date_depot_fiche_confident) ;     
        $interruption_debut=mysql_DateTime($e->interruption_debut) ;     
        $interruption_fin=mysql_DateTime($e->interruption_fin) ; 
        $date_debut_avenant=mysql_DateTime($e->date_debut_avenant) ; 
        $date_fin_avenant=mysql_DateTime($e->date_fin_avenant) ; 
        $courrier_debut_date=mysql_DateTime($e->courrier_debut_date) ;
        $soutenance_date_envoi=mysql_DateTime($e->soutenance_date_envoi) ;
        $debut_echange=mysql_DateTime($e->debut_echange) ;   
        $fin_echange=mysql_DateTime($e->fin_echange) ;
        $date_rdv_1jour=mysql_DateTime($e->date_rdv_1jour) ; 
        $date_demande=mysql_Time($e->date_demande) ; 

        //on récupère les champs liés
        $nom_etudiant=$e->Nom;       
        $nom_entreprise=$e->nom;
        $club_indus=$e->club_indus;
        $email_tuteur_gi =$e->email;
        $mail_etudiant=$e->$myannuairemail_effectif;      
        $statut_tuteur_gi=$e->statut;
        $tel_etudiant=$e->$myetudiantsada_num_tél;   
        //$num_ss=$e->num_secu;
		$adresse_fixe_etudiant=$e->$myetudiantsadresse_fixe;
		$adf_rue2_etudiant=$e->$myetudiantsadf_rue2;
		$adf_rue3_etudiant=$e->$myetudiantsadf_rue3;
		$adf_code_bdi_etudiant=$e->$myetudiantsadf_code_bdi;
		$adf_lib_commune_etudiant=$e->$myetudiantsadf_lib_commune;
        $adresse_entreprise=$e->adresse1." ".$e->ville;
        $date_modif=mysql_Time($e->date_modif) ;

    }
   //si on revient  du choix du codepost
 //on remet le contenu des champs avec les valeurs sauvegardées
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
  }
  
   //si on revient  du choix du codepost responsable adm
  //on remet le contenu des champs avec les valeurs sauvegardées
    if ($_POST['bouton_cp_adm'] !=''){
   foreach($_POST as $ci2){

    $x=key($_POST);
   $$x= stripslashes(current($_POST));
   next($_POST) ;
   }
   if (  $_POST['villecp']!=''){
   if ($_POST['bouton_cp_adm']=='OK'){
   $villecode=explode("_",$_POST['villecp']);
    $resp_adm_ville=$villecode[0];
    $resp_adm_code_postal=$villecode[1];  }
	else {$code_postal=$code_postal_sauv;
		$resp_adm_code_postal=$resp_adm_code_postal_sauv;
	}
	}
  }
  


        //ça c pour garder l'info comme koi on est arrivé depuis fiche.php apres click sur le modifier

       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";

        echo"<input type='hidden' name='code_etudiant' value=".$_GET['code_etu'].">";
        }
             else  if ( $_GET['code_ent']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_ent_filtre' value='1'>"; }
   //-------------------------------------------------------------------------------------------------debut affichage  modification de fiche
        //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".$$ci2."\">\n";
        }
        echo"       <table><tr>  ";
                echo afficheonly("","L'étudiant",'b' ,'h3');
        echo "</tr><tr>";
        echo affichechamp('Nom étudiant','nom_etudiant',$nom_etudiant,'30',1);
        echo affichechamp('Email étudiant','mail_etudiant',$mail_etudiant,'30',1);
		        echo affichechamp('Tel étudiant','tel_etudiant',$tel_etudiant,'15',1);
		        echo "      </tr><tr> ";  
		echo affichechamp('Adresse étudiant','adresse_fixe_etudiant',$adresse_fixe_etudiant,'30',1);
		echo"<input type='hidden' name='adf_rue2_etudiant' value=$adf_rue2_etudiant>";
				echo"<input type='hidden' name='adf_rue3_etudiant' value=$adf_rue3_etudiant>";
		echo affichechamp('code postal etudiant','adf_code_bdi_etudiant',$adf_code_bdi_etudiant,'5',1);
		echo affichechamp('ville étudiant','adf_lib_commune_etudiant',$adf_lib_commune_etudiant,'30',1);		
      
        echo "      </tr><tr> ";    
       // echo affichechamp('numéro SS','num_ss',$num_ss,'15',1); 
        echo "      </tr><tr> ";
                echo afficheonly("","Le stage",'b' ,'h3');
        echo "</tr><tr>";   

        echo "<td>";
        echo " type de stage<br> <select name='type_de_stage'>  ";
        for($i=0;$i<sizeof($libelle_stage);$i++) {
            //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
            echo "  <option  value=\"".current($code_libelle)."\" ";
            if  ($type_de_stage== current($code_libelle) ){
                echo " SELECTED ";
            }
            echo ">";
            echo current($libelle_stage);
            next($libelle_stage);
            next($code_libelle);
            echo"</option> " ;
        }
        echo"</select> " ;
        echo affichechamp('Etape','etape',$etape,'2');
		//on stocke ds un champ cache l'etape pour pouvoir savoir si elle a été modifiée
		echo"<input type='hidden' name='etape_sauv' value=\"".$etape."\">";
        echo "</td></tr><tr>";
        echo affichechamp('date debut (jj/mm/aa)','date_debut',$date_debut,10);
        echo affichechamp('date fin (jj/mm/aa)','date_fin',$date_fin,10);
        echo affichechamp('date de dépot','date_demande',$date_demande,'15',1);     
        echo "      </tr><tr> ";    
        echo affichechamp('interruption debut (jj/mm/aa)','interruption_debut',$interruption_debut,10);
        echo affichechamp('interruption fin (jj/mm/aa)','interruption_fin',$interruption_fin,10);
        $listeobtention=array('gi','direct','Candidature spontanée','Presse','Web','Forum','Contact Perso','Offre reçue à GI','suite J3E','autre') ;

        echo affichemenu('obtention du stage','mode_obtention',$listeobtention,$mode_obtention);
        



        echo "</td></tr><tr>";

        //cas du stage etude de terrain
        if ($libelle_stage[$type_de_stage]=='Etude de terrain'){
            //on affiche la liste de tous les etudiants pour le 2eme si il existe

            echo "<td>";
            echo " <br> etudiant 2<br> <select name='code_etudiant_2'>";
            echo "<option value=''";
            if ($code_etudiant_2==''){
                echo " SELECTED ";}
            echo ">aucun</option>";
            for($i=0;$i<sizeof($etudiants_nom);$i++) {

                echo "  <option value=\"".$etudiants_code[current($etudiants_nom)] ."\" ";
                if ($code_etudiant_2!=''){
                    if  ($etudiants_code[current($etudiants_nom)]==$code_etudiant_2  ){
                        echo " SELECTED ";}
                }
                echo ">";
                echo current($etudiants_nom)." " .current($etudiants_prenom);
                next($etudiants_nom);next($etudiants_prenom);
                echo"</option>\n " ;
            }

            echo"</select> " ;
            echo "</td>";
            //on remet le pointeur en debut des tableaux nom prenoms etudiants
            reset ( $etudiants_nom);
            reset ( $etudiants_prenom);
            //on affiche la liste de tous les etudiants pour le 3eme
            echo "<td>";
            echo " <br> etudiant 3<br> <select name='code_etudiant_3'>";
            echo "<option value=''";
            if ($code_etudiant_3==''){
                echo " SELECTED ";}
            echo ">aucun</option>";
            for($i=0;$i<sizeof($etudiants_nom);$i++) {

                echo "  <option value=\"".$etudiants_code[current($etudiants_nom)] ."\" ";
                if ($code_etudiant_3!=''){
                    if  ($etudiants_code[current($etudiants_nom)]==$code_etudiant_3  ){
                        echo " SELECTED ";}
                }
                echo ">";
                echo current($etudiants_nom)." " .current($etudiants_prenom);
                next($etudiants_nom);next($etudiants_prenom);
                echo"</option>\n " ;
            }
            echo"</select> " ;
            echo "</td>";
            echo "</td></tr><tr>";
        }
        echo "</tr><tr>";
                    echo "</td></tr><tr>";

        echo "<td colspan=3 >descriptif de la mission<br><textarea name='sujet' rows=4 cols=90>".$sujet."</textarea></td> ";
        echo "      </tr><tr> ";
        echo afficheonly("","L'entreprise",'b' ,'h3');
        echo "</tr><tr>";
        echo affichechamp("Nom de l'entreprise",'nom_entreprise',$nom_entreprise,'30',1);
		//$temp=strleft($adresse_entreprise." ".$ville_entreprise,10);
        echo affichechamp("Adresse du siège social",'adresse_entreprise',$adresse_entreprise,'45',1);
		// echo affichechamp("Ville",'ville_entreprise',$ville_entreprise,'30',1);
        echo affichechamp("Membre du club",'club_indus',$club_indus,'3',1);
        echo "</tr><tr>";       
        echo affichechamp('adresse du stage','adresse1',$adresse1);
        echo affichechamp('adresse du stage (suite)','adresse2',$adresse2);
        echo "      </tr><tr> ";
			// on met en hidden le code postal pour que si l'on annule la proposition du bouton on le retrouve 
		 echo"<input type='hidden' name='code_postal_sauv' value=\"".$code_postal."\">";
        echo "<td>code postal stage<br><input type='text' size=5 name='code_postal' value=\"".$code_postal."\">";
//      echo affichechamp('code postal','code_postal',$code_postal,5);
        echo "  <input type='Submit' name='bouton_cp_mod' value='verif code '>  </td>  ";       
        echo affichechamp('ville','ville',$ville);
        echo affichechamp('Pays','pays',$pays);
        echo "      </tr><tr> ";
        echo affichechamp('tuteur industriel','nom_tuteur_industriel',$nom_tuteur_industriel);
        echo affichechamp('qualité tuteur industriel','indus_qualite',$indus_qualite);
        echo affichechamp('email tuteur industriel','email_tuteur_indus',$email_tuteur_indus,'40'); 
        echo "      </tr><tr> ";        
        echo affichechamp('Tel tuteur industriel','telindus',$telindus,'17');
        echo affichechamp('Fax tuteur industriel','faxindus',$faxindus,'17');
		
		
    echo "</tr><tr>";
                echo afficheonly("","Tuteur enseignant",'b' ,'h3');
        echo "</tr><tr>"; 
		//si code tuteur est vide on affice NC
        if ( $code_tuteur_gi =='' ){
                $code_tuteur_gi=9999;}
        echo "<td> tuteur GI<br> <select name='code_tuteur_gi'>  ";
        for($i=0;$i<sizeof($enseignants_nom);$i++) {
            echo "  <option  value=\"".current($enseignants_code)."\" ";
            if  ($code_tuteur_gi== current($enseignants_code) ){
                echo " SELECTED ";}
            echo  ">".current($enseignants_nom)." ".current($enseignants_prenom)."</option> ";
            next($enseignants_code) ;
            next($enseignants_nom);
            next($enseignants_prenom);}
        echo "</select></td>";
        reset($enseignants_code);
        reset($enseignants_nom);
        reset($enseignants_prenom);     
        echo affichechamp('email','email_tuteur_gi',$email_tuteur_gi,'40',1);
        //c'est pour que le statut tuteur GI soit passé aussi pour l'impression de la convention (il ne fait pas partie de la table stage)
        echo"<input type='hidden' name='statut_tuteur_gi' value=\"$statut_tuteur_gi\">";      
        
//on affiche la suite que si c'est administrateur, responsable stages ou le tuteur concerné
        
     if($login == 'administrateur' or $login ==$ent_user or $login==$login_tuteur){ 


        echo "</tr><tr>";   
        echo afficheonly("","Responsable administratif dans l'entreprise",'b' ,'h3','2');       
        echo "<td colspan=2><br> C'est la personne qui doit recevoir et signer<br> la convention de stage <i>(souvent le service RH ou stages)</i></td>";
        echo "</tr><tr>";
        echo affichechamp('Nom du responsable administratif' ,'resp_adm',$resp_adm,'40');
        echo affichechamp('qualité du responsable administratif ','resp_qualite',$resp_qualite,'30');
        echo affichechamp('email du responsable administratif','resp_mail',$resp_mail,'30');
        echo "</tr><tr>";
        echo affichechamp('Tel du responsable administratif','resp_tel',$resp_tel,'17');
        echo affichechamp('Fax du responsable administratif','resp_fax',$resp_fax,'17');
        echo "</tr><tr>";
        
        echo affichechamp('adresse resp administratif','resp_adm_adresse1',$resp_adm_adresse1,'30');
        echo affichechamp('adresse resp administratif (suite)','resp_adm_adresse2',$resp_adm_adresse2,'30');
        echo "</tr><tr>";
// on met en hidden le code postal pour que si l'on annule la proposition du bouton on le retrouve 
		 echo"<input type='hidden' name='resp_adm_code_postal_sauv' value=\"".$resp_adm_code_postal."\">";
        echo "<td>code postal resp adm<br><input type='text' size=5 name='resp_adm_code_postal' value=\"".$resp_adm_code_postal."\">";
        echo " <input type='Submit' name='bouton_cp_adm_mod' value='verif code '>  </td>  ";
        echo affichechamp('ville resp adm','resp_adm_ville',$resp_adm_ville,30);

          
        echo "      </tr><tr> ";
                echo afficheonly("","Informations relatives à la convention de stage",'b' ,'h3','2');   
        echo "      </tr><tr> ";                
             $listeconv=array('Convention ENSGI','Convention Entreprise','CDD/Intérim','convention université accueil','NC') ;
            echo afficheradio('type de convention','convention_type',$listeconv,$convention_type,'NC');
            $listeconvremun=array('NON','OUI <30% SMIC','OUI >30% SMIC','NC') ;
            echo afficheradio('Rémunération (30% du SMIC=360 euros)','remuneration_type',$listeconvremun,$remuneration_type,'NC');
        echo affichechamp("montant de l'indemnité",'remuneration_montant',$remuneration_montant,'10');
        echo "      </tr><tr> ";            
        //----------------------------------------------------------------------------------------debut différenciation suivant stage
                echo afficheonly("","Renseignements divers",'b' ,'h3');
                echo "      </tr><tr> ";    
        switch ($libelle_stage[$type_de_stage]){
        case 'Etude de terrain':
        if ( $code_tuteur_gi_shs =='' ){
                $code_tuteur_gi_shs=9999;}
            echo "<td> tuteur GI SHS<br> <select name='code_tuteur_gi_shs'>  ";
            for($i=0;$i<sizeof($enseignants_nom);$i++) {
                echo "  <option  value=\"".current($enseignants_code)."\" ";
                if  ($code_tuteur_gi_shs== current($enseignants_code) ){
                    echo " SELECTED ";} 
                echo  ">".current($enseignants_nom)." ".current($enseignants_prenom)."</option> ";
                next($enseignants_code) ;
                next($enseignants_nom);
                next($enseignants_prenom);}
            echo "</select></td>";
					if		($code_tuteur_gi_shs !=9999){
            echo affichechamp('email tuteur gi shs','aff_email_tuteur_gi_shs',$enseignants_email[$code_tuteur_gi_shs],'30',1);
			}
            echo "      </tr><tr> ";                
            echo affichechamp('contact 1er jour','contact_1jour',$contact_1jour,30);
            echo affichechamp('tel contact 1er jour','tel_contact_1jour',$tel_contact_1jour,10);
            echo affichechamp('date rdv 1er jour','date_rdv_1jour',$date_rdv_1jour,8);  
            echo affichechamp('heure rdv 1er jour','heure_rdv_1jour',$heure_rdv_1jour,6);   
            echo "      </tr><tr> ";    
            echo affichechamp('date 1(jj/mm/aa)','debut_echange',$debut_echange,8); 
            echo affichechamp('date 2(jj/mm/aa)','fin_echange',$fin_echange,6);         
            break;
        case 'PFE':
            echo affichechamp('interruption debut (jj/mm/aa)','interruption_debut',$interruption_debut,10);
            echo affichechamp('interruption fin (jj/mm/aa)','interruption_fin',$interruption_fin,10);
            echo "</td></tr><tr>";
            $listeouinon=array('oui','non') ;
            echo afficheradio ('rapport confidentiel','rapport_confidentiel',$listeouinon,$rapport_confidentiel,'oui') ;
            echo "</tr><tr>";  
            echo affichechamp('avenant debut (jj/mm/aa)','date_debut_avenant',$date_debut_avenant,10);
            echo affichechamp('avenant fin (jj/mm/aa)','date_fin_avenant',$date_fin_avenant,10);
            echo "</td></tr><tr>";
            
            echo affichechamp('date envoi convention(jj/mm/aa)','date_envoi',$date_envoi,10);
            echo affichechamp('date réception convention (jj/mm/aa)','date_reception',$date_reception,10);
            echo "</tr><tr>";
           echo affichechamp('date soutenance(jj/mm/aa)','soutenance_date',$soutenance_date,10);
            echo affichechamp('heure soutenance','soutenance_heure',$soutenance_heure,5);              
            echo affichechamp('lieu soutenance','soutenance_lieu',$soutenance_lieu,40);
             echo "</tr><tr>";
			 //si code president jury est vide on affice NC
			         if ( $code_president_jury =='' ){
               $code_president_jury=9999;}
                    echo "<td> Président du jury<br> <select name='code_president_jury'>  ";
        for($i=0;$i<sizeof($enseignants_nom);$i++) {
            echo "  <option  value=\"".current($enseignants_code)."\" ";
            if  ($code_president_jury== current($enseignants_code) ){
                echo " SELECTED ";}
            echo  ">".current($enseignants_nom)." ".current($enseignants_prenom)."</option> ";
            next($enseignants_code) ;
            next($enseignants_nom);
            next($enseignants_prenom);}
        echo "</select></td>";
        reset($enseignants_code);
        reset($enseignants_nom);
        reset($enseignants_prenom);    
		if		($code_president_jury !=9999){
			echo affichechamp('email président du jury','aff_email_president_jury',$enseignants_email[$code_president_jury],'30',1);
			}
        //echo affichechamp('email','email_tuteur_gi',$email_tuteur_gi,'40',1);
                    $listeouinon=array('oui','non') ;
            echo afficheradio ('suivi par embauche','embauche_apres',$listeouinon,$embauche_apres,'non') ;
            break;
        case 'Ingénieur Adjoint':
            echo affichechamp('interruption debut (jj/mm/aa)','interruption_debut',$interruption_debut,10);
            echo affichechamp('interruption fin (jj/mm/aa)','interruption_fin',$interruption_fin,10);
            echo "</td></tr><tr>";
            $listeouinon=array('oui','non') ;
            echo afficheradio ('rapport confidentiel','rapport_confidentiel',$listeouinon,$rapport_confidentiel,'oui') ;
            echo "</tr><tr>";   
            echo affichechamp('date envoi convention(jj/mm/aa)','date_envoi',$date_envoi,10);
            echo affichechamp('date réception convention (jj/mm/aa)','date_reception',$date_reception,10);
            echo "</tr><tr>";
            echo affichechamp('date soutenance(jj/mm/aa)','soutenance_date',$soutenance_date,10);
            echo affichechamp('lieu soutenance','soutenance_lieu',$soutenance_lieu,40);
            break;
        case 'Opérateur':
            echo affichechamp('début échange(jj/mm/aa)','debut_echange',$debut_echange,8);  
            echo affichechamp('fin échange(jj/mm/aa)','fin_echange',$fin_echange,6);    
            break;
            
            
        default:
        }//fin du switch    
        echo "</td></tr><tr>";
        echo "<td>Remarques<br><textarea name='commentaires' rows=3 cols=40>".$commentaires."</textarea></td> ";
				echo "</tr><tr>";
		echo "<td colspan=2>Historique du traitement du stage<br><textarea name='historique' rows=3 cols=70 readonly>".$historique."</textarea></td> ";

        echo "</td><td>";
                echo "</tr><tr>";
} //fin du if login==administrateur
		echo "</tr><tr>";
        echo affichechamp('modifié par','modifpar',$modifpar,'20',1);

        echo affichechamp('le','date_modif',$date_modif,'15',1);
        if($login == 'administrateur' or $login ==$ent_user){
        echo"        <td><input type='Submit' name='imp_convention' value=\"impression convention\">";
        }
        echo "</tr><tr>";
        echo"        <th colspan=5>
                <input type='Submit' name='modif' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'>
                </th>
            </tr></table>
        </form> "  ;
}
 elseif($_GET['add']!='' or $_POST['add']!=''){ //--------------------------------------------------c'est kon a cliqué sur ajouter
 $afficheliste=0;

 if($login == 'administrateur' or $login ==$ent_user){
//on initialise les variables de tous les champs
 foreach($champs as $ci2){
 $$ci2='';
}
 //echo"<input type='hidden' name='ajout' value=1>";
  echo    "<form method=post action=$URL> "; 
        echo"       <table>";
        echo "</tr><tr><td>";   
    if ( $_GET['code_ent']!='') {
     //on arrive donc par la fiche de l'entreprise
   //il faut sauvegarder ds une variable l'info arrivée par get car apres
   //validation du formulaire avec post on perdra l'info
   $temp= $_GET['code_ent'] ;
   echo "<input type='hidden' name='code_ent_filtre' value='1'>";
    echo"<input type='hidden' name='code_entreprise' value='".$_GET['code_ent']."'>";
     //on arrive par fiche.php donc on affiche directement le nom de l'entreprise
      echo "  entreprise<br> <input type='text' readonly  name='affiche_nom_entreprise' value=\"".$entreprises_nom[$_GET['code_ent']]."\">  ";
    }
     else{
     //on arrive pas par fiche.php donc on affiche le select avec toutes les entreprises

             echo "<br>  entreprise <select name='code_entreprise'>  ";
   for($i=0;$i<sizeof($entreprises_code2);$i++) {
        $temp=$entreprises_code2[$i];
	 echo "  <option  value=\"".$temp."\"";
	   if  ($entreprises_nom[$temp]== 'NC' ){
       echo " SELECTED "; }
        echo ">";
    // echo "  <option value=\"$temp\">";
     echo $entreprises_nom[$temp]."--".$entreprises_ville[$temp];
      //next($entreprises_ville);
     //next($entreprises_nom);
     //next($entreprises_code);	 

      echo"</option> " ;
    }
   echo"</select> " ;
      }
         echo "</td><td>";
       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
         $temp= $_GET['code_etu'] ;
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";
        echo"<input type='hidden' name='code_etudiant' value='".$_GET['code_etu']."'>";
     //on arrive par fiche.php donc on affiche directement le nom de l'etudiant
      echo " etudiant<br> <input type='text' readonly  name='affiche_nom_etudiant' value=\"$etudiants_nom[$temp]\">  ";
    }
    else{
    //on arrive pas par fiche.php donc on affiche le select avec tous les etudiants
    echo " etudiant<br> <select name='code_etudiant'>  ";

   for($i=0;$i<sizeof($etudiants_code2);$i++) {
 $temp= $etudiants_code2[$i];
      echo "  <option  value=\"".$temp."\">";
    echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp]);
    echo"</option> " ;
 }
      echo"</select> " ;
}


         if (!isset($code_tuteur_gi)) $code_tuteur_gi='';
         echo "<td> tuteur GI<br> <select name='code_tuteur_gi'>  ";
          for($i=0;$i<sizeof($enseignants_code);$i++) {
      echo "  <option  value=\"".current($enseignants_code)."\" ";
      if  ($code_tuteur_gi== current($enseignants_code) ){
       echo " SELECTED ";}
       //si code tuteur est vide on affice NC
      if ((current($enseignants_code)==9999 )and $code_tuteur_gi =='' ){
       echo " SELECTED ";}
    echo  ">".current($enseignants_nom)." ".current($enseignants_prenom)."</option> ";
    next($enseignants_code) ;
    next($enseignants_nom);
    next($enseignants_prenom);}
    echo "</select></td>";
     echo "</tr><tr>";
     echo "<td align=center><a href=entreprises.php?add=1&fromstage=1&code_etu=".$_GET['code_etu'].">    L'entreprise n'est pas dans la liste</a>";

            echo "</tr><tr><td>";
    //pour initialiser
    $type_de_stage='PFE';
   echo " type de stage<br> <select name='type_de_stage'>  ";
          for($i=0;$i<sizeof($libelle_stage);$i++) {
    //echo "  <option >";
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      echo "  <option  value=\"".current($code_libelle)."\" ";
      if  ($type_de_stage== current($code_libelle) ){
       echo " SELECTED ";
      }
      echo ">";
    echo current($libelle_stage);
    next($libelle_stage);
    next($code_libelle);
    echo"</option> " ;
    }
   echo"</select> " ;
   $date_debut='NC';
      $date_fin='NC';
   echo affichechamp('date debut (jj/mm/aa)','date_debut',$date_debut,10);
    echo affichechamp('date fin (jj/mm/aa)','date_fin',$date_fin,10);

 
   echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='ajout' value='Ajouter'><input type='Submit' name='bouton_annul' value='Annuler'>
            </th>
         </tr></table> ";
      echo"   </form> "  ;

         }
   else{
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==

      }//fin du ajouter
//-----------------------------------------------------------------------------------------------recherche avancee---------------------------------------------------------------------------------------   
	
echo  "<FORM  action=".$self." method=GET name='monform'> ";		
	   if($_GET["st_recherche_avance"]=="oui"){
 echo "<a href=".$self."?st_recherche_avance=non&st_bouton_ok=OK>recherche simple</a><br>";
 //on remet la valeur ds le formulaire en cache pour la conserver
 echo "<input type=hidden name=st_recherche_avance value='oui'> ";
    echo "<br>";
  if($_GET["st_mon_champ"]==""){
  $_GET["st_mon_champ"]="date_debut";}
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

$sqlquery2="SELECT distinct `".$temp ."` FROM stages  order by  `".$temp ."` desc";

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
   echo "<center><a href=".$self."?st_recherche_avance=oui>recherche avancée</a></center>";}
    echo "<input type=hidden name=st_recherche_avance value='non'> ";
  } //fin du else  recherche avancee


  
	echo "</form>";   
	   
	  
	  
 //___________________________________AFFICHAGE TABLEAU_______________________________	
if  ($_GET['st_bouton_ok']=="OK" or ($_GET['st_recherche_avance']!="oui"  and  $_GET['add']!='1' ) ){	
	  	     if ($afficheliste){
     $query = "SELECT etudiants.Nom AS nom_etud ,etudiants.`prénom 1` AS prenom_etud ,entreprises.nom AS nom_ent ,$table.* FROM $table,etudiants,entreprises where code_etudiant=etudiants.`Code etu`  and  code_entreprise=entreprises.code ";
	 $query.=$where.$orderby;
	 //echo $query;
  $result=mysql_query($query,$connexion );
  $i=1;
        $nombre=  mysql_num_rows($result);
         echo"   _________ Liste des $nombre Stages ".$message_entete." ___________ ";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";

         echo" <tr>";
		 if   ($_GET['st_orderby']=='etudiants.nom' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=etudiants.nom&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Nom</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=etudiants.nom&st_bouton_ok=OK".$filtre.">Nom</a></th> ";}
		 if   ($_GET['st_orderby']=='entreprises.nom' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=entreprises.nom&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Entreprise</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=entreprises.nom&st_bouton_ok=OK".$filtre.">Entreprise</a></th> ";}

 if   ($_GET['st_orderby']=='type_de_stage' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=type_de_stage&st_inverse=1"."&st_bouton_ok=OK". $filtre.">type</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=type_de_stage&st_bouton_ok=OK".$filtre.">type</a></th> ";}

 if   ($_GET['st_orderby']=='date_debut' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=date_debut&st_inverse=1"."&st_bouton_ok=OK". $filtre.">debut</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=date_debut&st_bouton_ok=OK".$filtre.">debut</a></th> ";}

 if   ($_GET['st_orderby']=='date_fin' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=date_fin&st_inverse=1"."&st_bouton_ok=OK". $filtre.">fin</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=date_fin&st_bouton_ok=OK".$filtre.">fin</a></th> ";}

 if   ($_GET['st_orderby']=='etape' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=etape&st_inverse=1"."&st_bouton_ok=OK". $filtre.">étape</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=etape&st_bouton_ok=OK".$filtre.">étape</a></th> ";}

		echo"</th><th>action</th></tr>";
		
//pour l'export CSV
//on ecrit d'abord les  noms des colonnes
//Premiere ligne = nom des champs (si on en a besoin)
//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
//for($i=0;$i<sizeof($champs);$i++) {
//$csv_output .= $champs[$i].";";}
$csv_output = "nom;prenom;entreprise;type;";
for($i=0;$i<sizeof($st_champs);$i++) {
 $csv_output .= $st_champs[$i].";" ; 
    }
$csv_output .= "\n";

		
		
      while($e=mysql_fetch_object($result)) {
	  
      $prenom_etudiant=$e->prenom_etud;
        $nom_etudiant=$e->nom_etud;
        $code_etudiant= $e->code_etudiant;
        $code_entreprise= $e->code_entreprise;
        $code_stage= $e->code_stage;
        $date_debut=mysql_DateTime($e->date_debut)  ;
        $date_fin=mysql_DateTime($e->date_fin) ;
        $nom_entreprise=$e->nom_ent;
        $type_de_stage=$e->type_de_stage;
         $etape=$e->etape;
$csv_output .= $nom_etudiant.";".$prenom_etudiant.";".$nom_entreprise.";".$libelle_stage[$type_de_stage].";";
for($i=0;$i<sizeof($st_champs);$i++) {
$val_csv=str_replace("\r\n"," ",$e->$st_champs[$i]);
// si c'est un champ date 
 if (in_array ($st_champs[$i] ,$liste_champs_dates_courts ))
 {//on transforme les dates sql en dd/mm/yy
 $val_csv=mysql_DateTime($e->$st_champs[$i]);
 
 }
 if (in_array ($st_champs[$i] ,$liste_champs_dates_longs ))
 {//on transforme les dates sql en dd/mm/yy
 $val_csv=mysql_Time($e->$st_champs[$i]);
 
 }
    $csv_output .= $val_csv.";" ; 
	}
$csv_output .= "\n";		 
		 
              echo"<tr><td>". $nom_etudiant." ".$prenom_etudiant." </td><td> ".$nom_entreprise." </td><td> ".$libelle_stage[$type_de_stage]." </td><td> ".$date_debut." </td><td> ".$date_fin." </td><td> ".$etape ;
        echo "   </td><td nowrap>";
         echo "<A href=".$URL."?del=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'];
         echo" onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce stage ?')\">sup</A> - ";
         echo "<A href=".$URL."?mod=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'];
          echo ">détails</A> </td></tr> ";
       $i++; }
	   
	   if($login == 'administrateur' or $login ==$ent_user){
	
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
 ?>

</body>

</html>