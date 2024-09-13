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
//$login="blancoe";
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

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
if (!isset($_GET['st_lienreferent']))$_GET['st_lienreferent']=''; 
if (!isset($_GET['st_lientuteur']))$_GET['st_lientuteur']=''; 
if (!isset($_GET['st_orderby'])) $_GET['st_orderby']='' ;
if (!isset($_GET['st_inverse'])) $_GET['st_inverse']='' ;
if (!isset($_GET['st_bouton_ok'])) $_GET['st_bouton_ok']='';
if (!isset($_GET['an'])) $_GET['an']='';
if (!isset($_POST['an'])) $_POST['an']='';
if (!isset($_POST['st_recherche_avance']))$_POST['st_recherche_avance']='';

if (!isset($_GET['libstag'])) $_GET['libstag']='';
if (!isset($_POST['libstag'])) $_POST['libstag']='';
if (!isset($_POST['voir'])) $_POST['voir']='';
if (!isset($_POST['voir2'])) $_POST['voir2']='';
if (!isset($_GET['campagne_de_stage'])) $_GET['campagne_de_stage']='';
if (!isset($_POST['campagne_de_stage'])) $_POST['campagne_de_stage']='';
if (!isset($_GET['code_nouvelle_entreprise'])) $_GET['code_nouvelle_entreprise']='';
if ( $_POST['st_recherche_avance']!='') {
	 
	       //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['st_recherche_avance']=$_POST['st_recherche_avance'];
	      $_GET['st_mon_champ']=$_POST['st_mon_champ'];
	      $_GET['st_recherche']=$_POST['st_recherche'];		  
   	      $_GET['st_bouton_ok']=$_POST['st_bouton_ok'];  
		  $_GET['st_lienreferent']=$_POST['st_lienreferent']; 
		  $_GET['st_lientuteur']=$_POST['st_lientuteur']; 		  
     }

if ( $_POST['an']!='') {

	       //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['an']=$_POST['an'];
	      $_GET['libstag']=$_POST['libstag'];
 
     }	 


//si on vient de la fiche.php on remet  les parametres  ds l'url  des en tetes pour retrouver l'environnement de départ
if (isset($_GET['fromfic'])){
 $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);
$filtreok=$filtre."&bouton_ok=OK";
}
//ou qu'on a choisi une annee et pas en rech avancee
elseif ( isset($_GET['an']) and $_GET['st_recherche_avance'] !='oui') {


$filtre = "&an=".urlencode($_GET['an'])."&libstag=".urlencode($_GET['libstag']);

$filtre.="&st_recherche_avance=".$_GET['st_recherche_avance']."&st_mon_champ=".urlencode($_GET['st_mon_champ'])."&st_recherche=".urlencode($_GET['st_recherche']);
$filtreok=$filtre."&bouton_ok=OK";
}
else{
$filtre="&st_recherche_avance=".$_GET['st_recherche_avance']."&st_mon_champ=".urlencode($_GET['st_mon_champ'])."&st_recherche=".urlencode($_GET['st_recherche'])."&st_bouton_ok=".urlencode($_GET['st_bouton_ok'])."&st_lienreferent=".urlencode($_GET['st_lienreferent'])."&st_lientuteur=".urlencode($_GET['st_lientuteur']);
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
$messagem='';
$where='';
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
$csv_output="";
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
$sqlquery2="SELECT Nom,`Prénom 1`,`Code etu`,annuaire.`Mail effectif` FROM etudiants  left outer join  annuaire on etudiants.`Code etu`=annuaire.`code-etu` order by nom ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
//on remplit un tableau indice avec les noms etudiants pour le select du formulaire
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Prénom 1"];
$etudiants_email[$ind2]=$v["Mail effectif"];
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
$entreprises_pays[$ind2]=$v["pays"];
//on remplit un tableau associatif avec les codes entreprises pour le insert
$entreprises_code[$ind]=$v["code"];
$entreprises_code2[]=$v["code"];
}

//si on revient de creation d'entreprise (à partir du lien ci dessous section ajouter) on recupere le code cree
if ($_GET['code_nouvelle_entreprise']!=''){
$_GET['code_ent'] = $_GET['code_nouvelle_entreprise']  ;
}
//on remplit 2 tableaux avec les noms-codes enseignants
$sqlquery2="SELECT * FROM enseignants order by nom ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom"] ;
$ind2=$v["id"];

//on remplit 3 tableaux associatif avec les noms enseignants pour le select du formulaire
$enseignants_nom[$ind2]=$v["nom"];
$enseignants_prenom[$ind2]=$v["prenom"];
$enseignants_email[$ind2]=$v["email"];
$enseignants_uid[$ind2]=$v["uid_prof"];
$enseignants_code2[]=$v["id"];
}

//on remplit 1 tableaux avec les code etud des eleves ayant pour referent le connecté :

$sqlquery2="select etudiants.Nom ,etudiants.`Code etu`, groupes.id_ens_referent from ligne_groupe left outer join groupes on groupes.code =ligne_groupe.code_groupe left outer join etudiants on etudiants. `Code etu` =ligne_groupe.code_etudiant  left outer join enseignants on enseignants.id= groupes.id_ens_referent where  enseignants.uid_prof='".$login."'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
// on initialise les tab au cas ou il n'y ait pas de résultat
$suivis_par_ref_code=array();
$suivis_par_ref_nom=array();
while ($v=mysql_fetch_array($resultat2)){
$suivis_par_ref_code[]=$v["Code etu"];
$suivis_par_ref_nom[]=$v["Nom"];
}




$tabletemp="stages";
$st_champs=champsfromtable($tabletemp);




if($_POST['ajout']!='') { // ------------Ajout de la fiche--------------------
if((in_array ($login ,$re_user_liste ))){

$_POST['modifpar']=$login;
 //pour le mode d'obtention on met NC par défaut à la place de vide
 $_POST['mode_obtention']='NC';
foreach($champs as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle generee automatiquement par sqlserver

 
// on recupere les logins tuteur 
$temp= $_POST['code_tuteur_gi']  ;
if ($temp!=''){
$logintut=$enseignants_uid[$temp];
}else{
$logintut='NC';
}

   if ($ci2=="code_stage"){
   // on ne fait rien
 }
elseif ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(), ";}

 elseif( $ci2=="login_tuteur"){
  $sql1.= $ci2.",";
  $sql2.= "'".$logintut."',"; 
 }
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

if((in_array ($login ,$re_user_liste ))){
// est ce qu'il y a des fils associés ?

   $query = "select * FROM fil_discussion "
      ." where id_stage='".$_GET['del']."'";
	     $result = mysql_query($query,$connexion ); 
		 
		 if (mysql_num_rows($result)!=0){
		 


//on efface les elts de fil associés
echo "on efface  les ".mysql_num_rows($result)." fils associés<br>";
   $query = "DELETE FROM fil_discussion "
      ." where id_stage='".$_GET['del']."'";
	     $result = mysql_query($query,$connexion ); 
		 echo afficheresultatsql($result,$connexion);
		 }
		 // puis le stage lui meme
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
if((in_array ($login ,$re_user_liste ))){
//pour modifpar
$_POST['modifpar']=$login;
// on recupere les logins tuteur et referents
$temp= $_POST['code_tuteur_gi']  ;
if ($temp!='' ){
$logintut=$enseignants_uid[$temp];
}else{
$logintut='NC';
}
$temp= $_POST['code_suiveur']  ;
if ($temp!=''){
$loginref=$enseignants_uid[$temp];
}else{
$loginref='NC';
}

//si la cellule a passé un stage de etape 1 à 2 on envoie un mail  à l'etudiant  et  aux tuteurs  et referents
if( $_POST['etape_sauv']=="1" and $_POST['etape']=="2"  ) {
//$_POST['etape']="2"  ;
// On prepare l'email : on initialise les variables

$objet = "passage manuel d'un  stage en etape 2 par la cellule " ;
$messagem = "Le stage de".$_POST['nom_etudiant']." chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " vient d'etre passé en étape 2 par la cellule entreprise  "." \n" ;
$messagem .= "Pour accéder à la fiche du stage : ".$url_eleve." \n";
$messagem .= "il va falloir en terminer la saisie\n";
$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
// On envoie l’email
//envoimail($entmail,$objet,$messagem);
if (($_POST['mail_etudiant']!='Julien.Adoue@ensgi.inpg.fr')){
envoimail($_POST['mail_etudiant'],$objet,$messagem);
}
// On prepare l'email : on initialise les variables
if ($_POST['code_tuteur_gi']!='' and $_POST['code_tuteur_gi']!='9999'){
$messagem = "Le stage de ".$_POST['nom_etudiant']." chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " dont vous êtes tuteur   "." \n" ;
$messagem .= " vient d'etre passé en étape 2 par la cellule entreprise  "." \n" ;

$messagem .= "Pour accéder à la fiche du stage : ".$url_personnel."stages.php?mod=".$_POST['code_stage']." \n";

$messagem .= "Votre email :".$enseignants_email[$_POST['code_tuteur_gi']]." \n";
// On envoie l’email
//envoimail($entmail,$objet,$messagem);
envoimail($enseignants_email[$_POST['code_tuteur_gi']],$objet,$messagem);
}
if ($_POST['code_suiveur']!='' and $_POST['code_suiveur']!='9999'){
$messagem = "Le stage de ".$_POST['nom_etudiant']." chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " dont vous êtes  referent  "." \n" ;
$messagem .= " vient d'etre passé en étape 2 par la cellule entreprise  "." \n" ;

$messagem .= "Pour accéder à la fiche du stage : ".$url_personnel."stages.php?mod=".$_POST['code_stage']." \n";

$messagem .= "Votre email :".$enseignants_email[$_POST['code_suiveur']]." \n";
// On envoie l’email
//envoimail($entmail,$objet,$messagem);
envoimail($enseignants_email[$_POST['code_suiveur']],$objet,$messagem);
}


}

//si la cellule a modifié  le code tuteur et on envoie un mail  à l'etudiant  et  au tuteur sauf si on passe à NC
if ($_POST['code_tuteur_gi_sauv'] != $_POST['code_tuteur_gi'] ) {
// si on a pas mis NC
if ( $_POST['code_tuteur_gi'] !='9999') {
// cas 1 le tuteru precedent est vide
// On prepare l'email etudiant : on initialise les variables
$objet = "désignation d'un tuteur par la cellule RE" ;
$messagem ="";
$messagem .= " Bonjour  \n Nous vous informons que   "." \n" ;
$messagem .= "votre  stage  chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " sera encadré par    ".$enseignants_prenom[$_POST['code_tuteur_gi']]." ".$enseignants_nom[$_POST['code_tuteur_gi']]." \n" ;
$messagem .= "Pour accéder à la fiche du stage : ".$url_eleve." \n";

$messagem .= "Votre email :".$_POST['mail_etudiant']." \n";
// On envoie l’email à l'étudiant sauf ADOUE : TEST
if (($_POST['mail_etudiant']!='Julien.Adoue@ensgi.inpg.fr')){
envoimail($_POST['mail_etudiant'],$objet,$messagem);
}
//envoimail('marc.patouillard@grenoble-inp.fr',$objet,$messagem);
// On prepare l'email pour le tuteur : on initialise les variables
$objet = "désignation d'un tuteur par la cellule RE" ;
$messagem ="";
$messagem .= "Bonjour  \n  Nous vous informons que   "." \n" ;
$messagem .= "Le stage de ".$_POST['nom_etudiant']."(".$_POST['mail_etudiant'].") chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " sera encadré par vous :    \n" ;
$messagem .= "Pour accéder à la fiche du stage : ".$url_personnel."stages.php?mod=".$_POST['code_stage']." \n";

$messagem .= "Votre email :".$enseignants_email[$_POST['code_tuteur_gi']]." \n";
// On envoie l’email
//envoimail($entmail,$objet,$messagem);
envoimail($enseignants_email[$_POST['code_tuteur_gi']],$objet,$messagem);
}//fin de si on  pas mis NC
// dans tous les cas 
//// est ce qu' il y avait déjà un tuteur?
if ($_POST['code_tuteur_gi_sauv']!='' and $_POST['code_tuteur_gi_sauv'] !='9999')
{
if ( $_POST['code_tuteur_gi'] !='9999') {
// On prepare l'email pour l'ancien tuteur : on initialise les variables
$objet = "changement de tuteur par la cellule RE" ;
$messagem ="";
$messagem .= "Bonjour  \n  Nous vous informons que   "." \n" ;
$messagem .= "Le stage de ".$_POST['nom_etudiant']."(".$_POST['mail_etudiant'].") chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " a été confié à un autre tuteur:    \n" ;
$messagem .= " ce sera  ".$enseignants_prenom[$_POST['code_tuteur_gi']]." ".$enseignants_nom[$_POST['code_tuteur_gi']]." \n" ;
}
//si on a mis NC on change le message 
else {
$objet = "effacement du tuteur par la cellule RE " ;
$messagem ="";
$messagem .= "Bonjour  \n  Nous vous informons que   "." \n" ;
$messagem .= "Le stage de ".$_POST['nom_etudiant']."(".$_POST['mail_etudiant'].") chez ".$entreprises_nom[$_POST['code_entreprise']]." \n" ;
$messagem .= " ne vous est plus affecté    \n" ;
}
$messagem .= "Votre email :".$enseignants_email[$_POST['code_tuteur_gi_sauv']]." \n";
// On envoie l’email
//envoimail($entmail,$objet,$messagem);
envoimail($enseignants_email[$_POST['code_tuteur_gi_sauv']],$objet,$messagem);
}

// on le note dans dans l'historique dans tous les cas 

$_POST['historique'].=  "affectation du tuteur  ".$enseignants_nom[$_POST['code_tuteur_gi']]."-".$enseignants_email[$_POST['code_tuteur_gi']]." par ".$login." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\n";

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
  if (in_array($ci2,$liste_champs_dates_courts)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
 if (in_array($ci2,$liste_champs_dates_longs)){
 $_POST[$ci2]=versmysql_Datetimeexacte($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 // pour les problemes de sujet  mal affiché
 $_POST[$ci2]= str_replace(">","}",$_POST[$ci2]);
  // on tronque tout ce qui depasse la longueur du champ ds la table
  $_POST[$ci2]=tronquerPhrase($_POST[$ci2],$ci3) ;
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="code_stage"){
 //on ne fait rien
 }
 elseif ($ci2=="login_tuteur"){
 $sql1.= $ci2."='".$logintut."',";}
  elseif ($ci2=="login_suiveur"){
 $sql1.= $ci2."='".$loginref."',";}
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2."=now(), ";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $query = "UPDATE $table SET $sql1";
   $query .= " WHERE code_stage='".$_POST['code_stage']."' ";
 //echo $query;
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
elseif($_POST['imp_convention']!=''  ) { //---------------- impression convention---------------------

//on verifie qu'on est en etape 3 ou plus
if ($_POST['etape']>='3'){
echo "on prepare l'impression de la convention<br>";
//pour l'export CSV
//on ecrit d'abord les  noms des colonnes
//Premiere ligne = nom des champs (si on en a besoin)
//on initialise  $csv_output
 $csv_output="";

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
				$entreprises_pays_conv=str_replace("'","''",stripslashes($entreprises_pays[$_POST['code_entreprise']]));
//on recopie ensuite les donnees de la fiche stage en cours

//ligne de titres
$csv_output = "";
$csv_output .= "nomeleve;prenomeleve;entreprise;adresserespADM;CPrespADM;RESPONSABLE_ADMINISTRATIF;sujet;";
$csv_output.="adressestage;Cpstage;du;au;periodesemaines;interruption_prévue_du;interruption_prévue_au;";
$csv_output.="TUTEUR_INDUS;TUTEURGI;qualitéindus;qualitéGI;telGI4n;mailGI;";
$csv_output.="TelADM;FaxADM;MailADM;telindus;faxindus;mailindus;";
$csv_output.="tel_etudiant;adresse_fixe_etudiant;adf_rue2_etudiant;adf_rue3_etudiant;adf_code_bdi_etudiant;mail_etudiant;adf_lib_commune_etudiant;";
$csv_output.="date_soutenance;heure_soutenance;pays;qualite_resp_administratif;";
$csv_output.="referent;referent_mail;";
$csv_output .= "\n";
//$query.=$etudiants_nom[$_POST['code_etudiant']]."','";
$csv_output .= nettoiecsv($etudiants_nom_conv);
//$query.=$etudiants_prenom[$_POST['code_etudiant']]."','";
$csv_output .=nettoiecsv($etudiants_prenom_conv);
//$query.=$entreprises_nom[$_POST['code_entreprise']]."','";
$csv_output.=nettoiecsv($entreprises_nom_conv);
$csv_output.=nettoiecsv($_POST['resp_adm_adresse1']." ".$_POST['resp_adm_adresse2']);
$csv_output.=nettoiecsv($_POST['resp_adm_code_postal']." ".$_POST['resp_adm_ville']);
$csv_output.=nettoiecsv($_POST['resp_adm']);
$csv_output.=nettoiecsv($_POST['sujet']);
$csv_output.=nettoiecsv($_POST['adresse1']." ".$_POST['adresse2']);
$csv_output.=nettoiecsv($_POST['code_postal']." ".$_POST['ville']);
$csv_output.=nettoiecsv($_POST['date_debut']); 
$csv_output.=nettoiecsv($_POST['date_fin']); 
$csv_output.=nettoiecsv(diffdate($_POST['date_debut'],$_POST['date_fin'])+1); 
$csv_output.=nettoiecsv($_POST['interruption_debut']);  
$csv_output.=nettoiecsv($_POST['interruption_fin']);  
$csv_output.=nettoiecsv($_POST['nom_tuteur_industriel']);  
$csv_output.=nettoiecsv($enseignants_nom[$_POST['code_tuteur_gi']]." ".$enseignants_prenom[$_POST['code_tuteur_gi']]);  
$csv_output.=nettoiecsv($_POST['indus_qualite']); 
$csv_output.=nettoiecsv($_POST['statut_tuteur_gi']); 
$csv_output.=nettoiecsv("0476574795"); 
$csv_output.=nettoiecsv($enseignants_email[$_POST['code_tuteur_gi']]); 
$csv_output.=nettoiecsv($_POST['resp_tel']); 
$csv_output.=nettoiecsv($_POST['resp_fax']); 
$csv_output.=nettoiecsv($_POST['resp_mail']); 
$csv_output.=nettoiecsv($_POST['telindus']); 
$csv_output.=nettoiecsv($_POST['faxindus']); 
$csv_output.=nettoiecsv($_POST['email_tuteur_indus']); 
$csv_output.=nettoiecsv($_POST['tel_etudiant']); 
$csv_output.=nettoiecsv($_POST['adresse_fixe_etudiant']); 
$csv_output.=nettoiecsv($_POST['adf_rue2_etudiant']); 
$csv_output.=nettoiecsv($_POST['adf_rue3_etudiant']); 
$csv_output.=nettoiecsv($_POST['adf_code_bdi_etudiant']); 
$csv_output.=nettoiecsv($_POST['mail_etudiant']); 
$csv_output.=nettoiecsv($_POST['adf_lib_commune_etudiant']);  
$csv_output.=nettoiecsv($_POST['soutenance_date']);  
$csv_output.=nettoiecsv($_POST['soutenance_heure']); 
$csv_output.=nettoiecsv($entreprises_pays_conv); 
$csv_output.=nettoiecsv($_POST['resp_qualite']); 

// gestion du cas vide referent PFE
if ($_POST['code_suiveur']=='')$temp='9999'; 
				else $temp=$_POST['code_suiveur'];
		 
$csv_output.=nettoiecsv($enseignants_nom[$temp]." ".$enseignants_prenom[$temp]); 
$csv_output.=nettoiecsv($enseignants_email[$temp]); 
$csv_output .= "\n";
echo "<center>";
echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='EXPORT vers convention'> <br> "  ;
echo "<a href=stages.php>Accueil stages</a>";
echo "<br><br>";
echo "</center>";
$afficheliste=0;
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
	//echo "<br><A href=".$URL." > Revenir à la liste des stages </a><br>";

	echo "<a href='#' onclick=\"window.open('pdfstage.php?mod=".$_GET['mod']."&format=A4"."','nom','location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=1,width=800,height=600')\">imprimer la fiche résumée </a>  ";
     }else
	 //debut du else tres long 
     {
     if ( $_GET['code_etu']!='') {
     //il faut aussi chercher si l etudiant n'est pas le num 2 ou le num 3 d'un stage etude de terrain : on arrive par fiche.php
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
	   elseif ( $_POST['voir2']=='Tous') {
	 // si on a cliqué sur bouton Tous
     $where = "";
     }
	  //elseif ( $_GET['an']!='') {
     //$where = " and date_debut < '".($_GET['an']+1)."-09-01' and date_debut > '".($_GET['an'])."-31-08'";
     //$message_entete="de la période ".$_GET['an'];
      //}
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter
     elseif ( $_POST['code_ent_filtre']!='') {
     $where="and code_entreprise='".$_POST['code_entreprise']."' "   ;
      //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_ent']=$_POST['code_entreprise'];
     $message_entete="de ".$entreprises_nom[$_GET['code_ent']];
     }
	 // on a choisi filtrer
	  elseif ( $_GET['an']!='' or  $_GET['libstag']!='' ) {

		if ($_GET['libstag']=='' and $_GET['an']=='NC' ){
		$where ='';
		}
		  elseif ($_GET['libstag']=='' and $_GET['an']!='' ){

					//$where = " and date_debut < '".($_GET['an']+1)."-09-01' and date_debut > '".($_GET['an'])."-31-08'";
						$where .= " and date_fin < '".(substr($_GET['an'],0,4)+1)."-09-30' and date_fin >= '".substr($_GET['an'],0,4)."-09-30'";	

				}elseif ($_GET['libstag']!='' and $_GET['an']=='NC' ){
				$where = " and type_de_stage = '".($_GET['libstag'])."'";
				}
					else{
					// si on a choisi un type de stage il faut traiter à part le type ia 
								if ($_GET['libstag']=='3'){				
								$where .= " and date_debut >= '".(substr($_GET['an'],0,4))."-06-01' and date_debut < '".(substr($_GET['an'],0,4)+1)."-06-01'"." and type_de_stage = '".($_GET['libstag'])."'";
								}
								else
								{
								$where .= " and date_fin < '".(substr($_GET['an'],0,4)+1)."-09-30' and date_fin >= '".substr($_GET['an'],0,4)."-09-30'"." and type_de_stage = '".($_GET['libstag'])."'";	
								}
						}
			$message_entete="de la Période ".$_GET['an'] . " et de type ".$libelle_stage[$_GET['libstag']];
			}
	 //on a pas choisi filtrer
      else{

	  //si on est en recherche avancee
	    if($_GET["st_recherche_avance"]=="oui" and $_GET["st_mon_champ"]!=''){
		
		//il faut traiter le cas recherche avnce est egal à vide
			if ($_GET['st_recherche']=='vide') {  $_GET['st_recherche']='';}
			// et date est égal à NC 
			if ($_GET['st_recherche']=='NC') {  $_GET['st_recherche']='01/01/1900';}

			$where="and stages.`".$_GET["st_mon_champ"]."` = '".$_GET["st_recherche"]."'";
			// pour que le lien les stages dont je suis le tuteur ou le referent ne renvoient que les stages de l'année en cours ou +
						if ($_GET['st_lienreferent']!='' or $_GET['st_lientuteur']!='') {
						$_GET['an']=$annee_courante;
				$where .= " and (( date_fin >= '".substr($_GET['an'],0,4)."-09-30' and type_de_stage != '3')";
				$where .= " or (date_debut >= '".(substr($_GET['an'],0,4))."-06-01'  and type_de_stage = '3'))";				
						}
		}
		//sinon on est au début on ne prend rien
		else{
      $where=" and false ";}
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
   echo "<br><A href=default.php?".$filtreok." > Revenir à l'accueil </a><br>"; 

  if((in_array ($login ,$re_user_liste ))){
  echo "<br><A href=".$URL."?add=1&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'].$filtre." > Ajouter un stage </a><br>";
}
   echo "<br><A href=".$URL."?st_recherche_avance=oui&st_mon_champ=login_tuteur&st_recherche=".$login."&st_bouton_ok=OK&st_lientuteur=1 >Les stages dont je suis le tuteur en ".$annee_courante." -".($annee_courante+1)."</a><br> ";
   echo "<br><A href=".$URL."?st_recherche_avance=oui&st_mon_champ=login_suiveur&st_recherche=".$login."&st_bouton_ok=OK&st_lienreferent=1 >Les stages dont je suis le référent(PFE) en ".$annee_courante." -".($annee_courante+1)."</a><br> ";
  echo    "<form method=post action=$URL> "; 
  // echo "<br><A href=".$URL."st_bouton_ok=OK&st_lienreferent=2 >La liste des étudiants  dont je suis le référent(PFE) en ".$annee_courante.": </a><br> <br>";
  echo    "<form method=post action=$URL> "; 
        echo"       <table>";
	


	$an=$_GET["an"];
	if ($an==''){
	//si c'est vide : à l'arrivée sur la page on prend comme defaut l'annee courante
	$an=$filtre_etu_annee_courante;
	}
	$libstag=$_GET["libstag"];
   	echo "<td>ou recherche parmis tous les stages par :</td>";
		   	echo affichemenu ('Année','an',$annees_liste,$an);
		 //echo affichemenu ('type de stage','libstag',$libelle_stage,$libstag);
		 //pour initialiser
    $type_de_stage=$libelle_stage[$_GET['libstag']];

	  	echo "</td><td>";
   echo " type de stage<br> <select name='libstag'>  ";
          for($i=0;$i<sizeof($libelle_stage);$i++) {
    //echo "  <option >";
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
      echo "  <option  value=\"".current($code_libelle)."\" ";
      if  ($type_de_stage== current($libelle_stage) ){
       echo " SELECTED ";
      }
      echo ">";
    echo current($libelle_stage);
    next($libelle_stage);
    next($code_libelle);
    echo"</option> " ;
    }
   echo"</select> " ;
		echo "</tr><tr>";   
		echo "</tr><tr>";
		echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='voir' value='Filtrer'>
			     <input type='Submit' name='voir2' value='Tous'>
				 			 
            </th>
			</tr></table> ";
      echo"   </form> "  ;
 
  


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

}
//fin du else tres long  bouton_ok=ok

  if($_GET['mod']!='' or $_POST['mod']!='' ){//--------------------------------------c'est kon a cliqué sur detail ou kon revient du code postal

    $afficheliste=0;
   echo    "<form method=post action=$URL> "; 
   echo "<br><input type='Submit' name='bouton_annul' value='Revenir à la liste des stages'><br>";
   		if((in_array ($login ,$re_user_liste )) ){
        echo" <input type='Submit' name='imp_convention' value=\"impression convention\"><br>";
        }

  if($_GET['mod'] !=''){
  //si on a cliqué sur détails
  //1ere version de la requete
//   $query = "SELECT etudiants.[Nom],entreprises.[nom],enseignants.[email],$table.* FROM $table,etudiants,entreprises,enseignants where [code_etudiant]=etudiants.[Code etu]
//    and  [code_entreprise]=entreprises.code and  [code_tuteur_gi]=enseignants.id and code_stage=$_GET[mod] order by date_debut";
   $query="SELECT     etudiants.Nom , entreprises.nom as entnom ,entreprises.club_indus , enseignants.email,enseignants.uid_prof , annuaire.`Mail effectif`,enseignants.statut,etudiants.`Ada Num tél`,etudiants.`Adresse fixe`,etudiants.`Adf rue2`,etudiants.`Adf rue3`,etudiants.`Adf code BDI`,etudiants.`Adf lib commune`,entreprises.adresse1 as entadresse1, entreprises.ville as entville ,stages.*
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
        $nom_entreprise=$e->entnom;
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
        $adresse_entreprise=$e->entadresse1." ".$e->entville;
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
             if ( $_GET['code_ent']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_ent_filtre' value='1'>"; }
				if ( $_GET['an']!=''   ) {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='an' value=".$_GET['an'].">";
		echo"<input type='hidden' name='libstag' value=".$_GET['libstag'].">";
		
		}
		
		if (  $_GET['st_recherche_avance']!=''  ) {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
       echo"<input type='hidden' name='st_recherche_avance' value=".$_GET['st_recherche_avance'].">";
       echo"<input type='hidden' name='st_mon_champ' value=".$_GET['st_mon_champ'].">";		
       echo"<input type='hidden' name='st_recherche' value=".$_GET['st_recherche'].">";
	     echo"<input type='hidden' name='st_bouton_ok' value=".$_GET['st_bouton_ok']	.">";
		 echo"<input type='hidden' name='st_lienreferent' value=".$_GET['st_lienreferent']	.">";
		echo"<input type='hidden' name='st_lientuteur' value=".$_GET['st_lientuteur']	.">";
   
		}
		// on verifie si on affiche le lien fil de discussion
		
		 if((in_array($login,$re_user_liste) or  $login ==$login_tuteur or  $login == $login_suiveur) and ($type_de_stage=='11' or $type_de_stage=='3') ){
		
		
	echo "<br><A href=fils.php?filtre_id=".$_GET['mod']." > Fil de discussion pour ce stage </a><br>";	
	}
   //-------------------------------------------------------------------------------------------------debut affichage  modification de fiche
        //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".$$ci2."\">\n";
        }
		
		
        echo"       <table><tr>  ";

        echo "</tr><tr>";
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
        //echo affichechamp('numéro SS','num_ss',$num_ss,'15',1); 
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
		        $listeetapes=array('','1','2','3','4','5','6') ;

        //echo affichemenu('Etape','etape',$listeetapes,$etape);
		
		echo affichemenusqlplus('Etape','etape','code','select * from nomenclature_etape ','code',$etape,$connexion,'libelle');
        //echo affichechamp('Etape','etape',$etape,'1');
		//on stocke ds un champ cache l'etape pour pouvoir savoir si elle a été modifiée
		echo"<input type='hidden' name='etape_sauv' value=\"".$etape."\">";
		
        echo "</td></tr><tr>";
        echo affichechamp('date debut (jj/mm/aa)','date_debut',$date_debut,10);
        echo affichechamp('date fin (jj/mm/aa)','date_fin',$date_fin,10);
        echo affichechamp('date de dépot','date_demande',$date_demande,'15',1);     
        echo "      </tr><tr> ";    
        echo affichechamp('interruption debut (jj/mm/aa)','interruption_debut',$interruption_debut,10);
        echo affichechamp('interruption fin (jj/mm/aa)','interruption_fin',$interruption_fin,10);
        $listeobtention=array('gi','direct','Candidature spontanée','Presse','Web','Forum','Contact Perso','Offre reçue à GI','suite J3E','autre','NC') ;

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

        echo "<td colspan=2 >descriptif de la mission<br><textarea name='sujet' rows=4 cols=90>".$sujet."</textarea></td> ";
		// cas du PFE
		if ($type_de_stage=='11'){
		echo "<td colspan=2 >motivations<br><textarea name='motivation' rows=4 cols=50>".$motivation."</textarea></td> ";}
        echo "      </tr><tr> ";
        echo afficheonly("","L'entreprise",'b' ,'h3');
        //echo affichechamp("Nom de l'entreprise",'nom_entreprise',$nom_entreprise,'30',1);
		      echo "</tr><tr>";
		//$temp=strleft($adresse_entreprise." ".$ville_entreprise,10);
		// pour NC
		        if ( $nom_entreprise =='' ){
                $nom_entreprise='NC';}
			
		echo "<td colspan=2>  Entreprise <br><select name='code_entreprise'>  ";
   for($i=0;$i<sizeof($entreprises_code2);$i++) {
        $temp=$entreprises_code2[$i];
	 echo "  <option  value=\"".$temp."\"";
	   if  ($entreprises_nom[$temp]== $nom_entreprise ){
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

   		      echo "</td></tr><tr>";
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
        echo affichechamp('Maître de stage en entreprise','nom_tuteur_industriel',$nom_tuteur_industriel);
        echo affichechamp('qualité Maître de stage en entreprise','indus_qualite',$indus_qualite);
        echo affichechamp('email Maître de stage en entreprise','email_tuteur_indus',$email_tuteur_indus,'40'); 
        echo "      </tr><tr> ";        
        echo affichechamp('Tel Maître de stage en entreprise','telindus',$telindus,'17');
        echo affichechamp('Fax Maître de stage en entreprise','faxindus',$faxindus,'17');
		
		
    echo "</tr><tr>";
                echo afficheonly("","Suivi enseignant",'b' ,'h3');
        echo "</tr><tr>"; 

				// cas du PFE
				if ($type_de_stage=='11'){
				// gestion du cas vide
				if ($code_suiveur=='')$code_suiveur='9999';
				 echo "<td> référent <br> <select name='code_suiveur'>  ";

	for($i=0;$i<sizeof($enseignants_code2);$i++) {
        $temp=$enseignants_code2[$i];
      echo "  <option  value=\"".$temp."\" ";
      	if  ($code_suiveur== $temp){
       echo " selected "; }    
	echo  ">".$enseignants_nom[$temp]." ".$enseignants_prenom[$temp]."</option> ";
	}

        echo "</select></td>";
     
				
				
		        echo affichechamp('email référent','aff_email_ref',$enseignants_email[$code_suiveur],'40',1);
						if((in_array ($login ,$re_user_liste ))){
		echo affichechamp('login référent' ,'login_suiveur',$login_suiveur,'9',1);}
		

		 		echo "</tr><tr>";
				if((in_array ($login ,$re_user_liste )) or ($login_suiveur==$login)){
				// pas besoin de stocker les valeurs puisqu'elles ne peuvent pas être modifiés : on les affiche seulement
if ($code_tut1_prop=='')$code_tut1_prop='9999';
    echo affichechamp('tuteur 1 proposé','aff_tut1_prop',$enseignants_nom[$code_tut1_prop]." ".$enseignants_prenom[$code_tut1_prop],'30',1);
if ($code_tut2_prop=='')$code_tut2_prop='9999';	
    echo affichechamp('tuteur 2 proposé','aff_tut2_prop',$enseignants_nom[$code_tut2_prop]." ".$enseignants_prenom[$code_tut2_prop],'30',1);
if ($code_tut3_prop=='')$code_tut3_prop='9999';
	 echo affichechamp('tuteur 3 proposé','aff_tut3_prop',$enseignants_nom[$code_tut3_prop]." ".$enseignants_prenom[$code_tut3_prop],'30',1);
}
				 		
	// pas nécesssaire car les tut propose ne sont jamais modifiés							
//echo affichemenusqlplus('tuteur 2 proposé','code_tut2_prop','id',"SELECT * from enseignants order by nom",'nom',$code_tut2_prop,$connexion);

		 		}	//fin du if $type_de_stage=='11'
		 		 echo "</tr><tr>";
				 
				 
		 		//si code tuteur est vide on affiche NC
        if ( $code_tuteur_gi =='' ){
                $code_tuteur_gi=9999;}
				//on sauvegarde l'ancienne valeur du code tuteur
		echo"<input type='hidden' name='code_tuteur_gi_sauv' value=\"".$code_tuteur_gi."\">";
			
        echo "<td> tuteur <br> <select name='code_tuteur_gi'>  ";

	for($i=0;$i<sizeof($enseignants_code2);$i++) {
        $temp=$enseignants_code2[$i];
      echo "  <option  value=\"".$temp."\" ";
      	if  ($code_tuteur_gi== $temp){
       echo " selected "; }    
	echo  ">".$enseignants_nom[$temp]." ".$enseignants_prenom[$temp]."</option> ";
	}

               echo "</select></td>";
            
        echo affichechamp('email tuteur','email_tuteur_gi',$email_tuteur_gi,'40',1);
		if((in_array ($login ,$re_user_liste ))){
						        echo affichechamp('login tuteur' ,'login_tuteur',$login_tuteur,'9',1);}
			

        //c'est pour que le statut tuteur  soit passé aussi pour l'impression de la convention (il ne fait pas partie de la table stage)
        echo"<input type='hidden' name='statut_tuteur_gi' value=\"$statut_tuteur_gi\">";      
        
//on affiche la suite que si c'est administrateur, responsable stages ou le tuteur concerné
        
     if((in_array ($login ,$re_user_liste )) or $login==$login_tuteur or $login==$login_suiveur or (in_array ($login ,$scol_user_liste ))){ 


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
            echo "<td> tuteur SHS<br> <select name='code_tuteur_gi_shs'>  ";

	for($i=0;$i<sizeof($enseignants_code2);$i++) {
        $temp=$enseignants_code2[$i];
      echo "  <option  value=\"".$temp."\" ";
      	if  ($code_tuteur_gi_shs== $temp){
       echo " selected "; }    
	echo  ">".$enseignants_nom[$temp]." ".$enseignants_prenom[$temp]."</option> ";
	}

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

 	for($i=0;$i<sizeof($enseignants_code2);$i++) {
        $temp=$enseignants_code2[$i];
      echo "  <option  value=\"".$temp."\" ";
      	if  ($code_president_jury== $temp){
       echo " selected "; }    
	echo  ">".$enseignants_nom[$temp]." ".$enseignants_prenom[$temp]."</option> ";
	}

        echo "</select></td>";
    
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
            echo affichechamp('heure soutenance','soutenance_heure',$soutenance_heure,5);              
            echo affichechamp('lieu soutenance','soutenance_lieu',$soutenance_lieu,40);
            break;
		 case 'IA Long':
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
            echo affichechamp('heure soutenance','soutenance_heure',$soutenance_heure,5);              
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
        		echo "</tr><tr>";
		
        echo"        <th colspan=5>";
		 if((in_array ($login ,$re_user_liste ))){
                echo "<input type='Submit' name='modif' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'>";
				}else{
				echo "<input type='Submit' name='bouton_annul' value='Revenir'>";
				}
               echo" </th>
            </tr></table>
        </form> "  ;
}
 elseif($_GET['add']!='' or $_POST['add']!=''){ //--------------------------------------------------c'est kon a cliqué sur ajouter

 $afficheliste=0;
 if((in_array ($login ,$re_user_liste ))){
//on initialise les variables de tous les champs
 foreach($champs as $ci2){
 $$ci2='';
}
 //echo"<input type='hidden' name='ajout' value=1>";
  echo    "<form method=post action=$URL> "; 
        echo"       <table>";
        echo "</tr><tr><td>";  
 //ça c pour garder l'info comme koi on est arrivé depuis fiche.php apres click sur le modifier

       if ( $_GET['code_etu']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_etu_filtre' value='1'>";

        echo"<input type='hidden' name='code_etudiant' value=".$_GET['code_etu'].">";
        }
             if ( $_GET['code_ent']!='') {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='code_ent_filtre' value='1'>"; }
				if ( $_GET['an']!=''   ) {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
        echo"<input type='hidden' name='an' value=".$_GET['an'].">";
		echo"<input type='hidden' name='libstag' value=".$_GET['libstag'].">";
		
		}
		
		if (  $_GET['st_recherche_avance']!=''  ) {
       //il faut sauvegarder ds une variable l'info arrivée par get car apres
       //validation du formulaire avec post on perdra l'info
       echo"<input type='hidden' name='st_recherche_avance' value=".$_GET['st_recherche_avance'].">";
       echo"<input type='hidden' name='st_mon_champ' value=".$_GET['st_mon_champ'].">";		
       echo"<input type='hidden' name='st_recherche' value=".$_GET['st_recherche'].">";
	     echo"<input type='hidden' name='st_bouton_ok' value=".$_GET['st_bouton_ok']	.">";
		 echo"<input type='hidden' name='st_lienreferent' value=".$_GET['st_lienreferent']	.">";
		echo"<input type='hidden' name='st_lientuteur' value=".$_GET['st_lientuteur']	.">";
   
		}


		
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


         echo "<td> tuteur <br> <select name='code_tuteur_gi'>  ";
          for($i=0;$i<sizeof($enseignants_code2);$i++) {
        $temp=$enseignants_code2[$i];
      echo "  <option  value=\"".$temp."\" ";
      	if  ($enseignants_nom[$temp]== 'NC' ){
       echo " selected "; }    
	echo  ">".$enseignants_nom[$temp]." ".$enseignants_prenom[$temp]."</option> ";
	}
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
      if  ($type_de_stage== current($libelle_stage) ){
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
///si on est en rech avanc e et pas en modif
	   if($_GET["st_recherche_avance"]=="oui" and $_GET["mod"]==""){
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
$selected=0;
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
         echo "SELECTED";
		 $selected=1;
		 }

    echo  ">".$valeuraffichee."</option> ";
}

// si pour login_tuteur ou referent on arrive à la fin de la selection et qu'on a pas de correspondance il faut ajouter le login courant
if (!$selected and ($_GET["st_mon_champ"]=='login_tuteur' or $_GET["st_mon_champ"]=='login_suiveur')){
echo " <option  value="."\"".$login."\"";
 echo " SELECTED";
  echo  ">".$login."</option> ";
}
echo "</select> ";
// si on est ds le cas ou on a cliqué sur les lien les stages dont je suis le .... on ajoute l'année
if ($_GET['st_lienreferent']!='' or $_GET['st_lientuteur']!='') {
echo "ET année scolaire >= ".$annee_courante."-".($annee_courante+1); 
}
	  echo"     <input type ='submit' name='st_bouton_ok'  value='OK'> <br> "  ;
  } //fin du if recherche avancee
  else {
  //on n'affiche le lienrecherche avancee pas en modif et pas quand on masque la liste et pas en retour de codepostagl
  if ($_GET['add']!='1' and $afficheliste ){
  if((in_array ($login ,$re_user_liste ))){
   echo "<center>ou <a href=".$self."?st_recherche_avance=oui> recherche avancée</a></center>";}
    echo "<input type=hidden name=st_recherche_avance value='non'> ";
	}//fin du if login ==entuser
  } //fin du else  recherche avancee


  
	echo "</form>";   
	   
	  
	  
 //___________________________________AFFICHAGE TABLEAU_______________________________	
if  ($_GET['st_bouton_ok']=="OK" or ($_GET['st_recherche_avance']!="oui"  and  $_GET['add']!='1' ) ){	
	  	     if ($afficheliste){
			 
     $query = "SELECT etudiants.Nom AS nom_etud ,etudiants.`prénom 1` AS prenom_etud,etudiants.`Lib étape` as etape_etud ,entreprises.nom AS nom_ent,entreprises.club_indus AS club_ent ,$table.* FROM $table,etudiants,entreprises where code_etudiant=etudiants.`Code etu`  and  code_entreprise=entreprises.code ";
	 $query.=$where.$orderby;
	 if ($login=='administrateur'){
	// echo "DEBUG  :".$query."<br>";
	 }
	 //echo "<br>";
	 //echo $_GET['an'];
  $result=mysql_query($query,$connexion );
  $i=1;
        $nombre=  mysql_num_rows($result);
		if ( $nombre!=0)
		{
         echo"   _________ Liste des $nombre Stages ".$message_entete." ___________ ";
		$whereurl=urlencode($where);
		 echo "<a href='#' onclick=\"window.open('pdfstagebooklet.php?whereurl=".$whereurl."','nom','location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=1,width=800,height=600')\"><br>imprimer le booklet pour cette sélection </a>  ";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
         echo" <tr>";
		 //if ($_GET['libstag']=='11'){
		 echo "<th>reporting</th>";
		 //}
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
echo "<th>tuteur </th>";
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
$csv_output = "nom;prenom;etape;entreprise;club;type;nom_ref;prenom_ref;";
for($i=0;$i<sizeof($st_champs);$i++) {
 $csv_output .= nettoiecsv($st_champs[$i]) ; 
 // on rajoute le mail du tuteur dans les titres
 if ($st_champs[$i]=='code_tuteur_gi'){
 $csv_output .="email_tuteur_gi;";
 }

    }
$csv_output .= "\n";

// on initialise les tab au cas ou il n'y ait pas de résultat
$suivis_par_ref_avec_stage_code=array();		
		
      while($e=mysql_fetch_object($result)) {
	  
      $prenom_etudiant=$e->prenom_etud;
        $nom_etudiant=$e->nom_etud;
        $code_etudiant= $e->code_etudiant;
		$etape_etudiant= $e->etape_etud;
        $code_entreprise= $e->code_entreprise;
        $code_stage= $e->code_stage;
        $date_debut=mysql_DateTime($e->date_debut)  ;
        $date_fin=mysql_DateTime($e->date_fin) ;
        $nom_entreprise=$e->nom_ent;
		$club_entreprise=$e->club_ent;
        $type_de_stage=$e->type_de_stage;
         $etape=$e->etape;
		 $login_tuteur=$e->login_tuteur;
		 $login_suiveur=$e->login_suiveur;
		 // gestion du cas vide
				if ($e->code_suiveur=='')$temp='9999'; 
				else $temp=$e->code_suiveur ;
		if (array_key_exists($temp,$enseignants_nom)) $nom_ref=$enseignants_nom[$temp];else $nom_ref='NC';
		if (array_key_exists($temp,$enseignants_prenom)) $prenom_ref=$enseignants_prenom[$temp];else $prenom_ref='NC';
$csv_output .=	nettoiecsv($nom_etudiant);	 
$csv_output .=	nettoiecsv($prenom_etudiant);
$csv_output .=	nettoiecsv($etape_etudiant);	
$csv_output .=	nettoiecsv($nom_entreprise);	
$csv_output .=	nettoiecsv($club_entreprise);	
$csv_output .=	nettoiecsv($libelle_stage[$type_de_stage]);	
$csv_output .=	nettoiecsv($nom_ref);
$csv_output .=	nettoiecsv($prenom_ref);	
// on stocke les code etudiants dans un tableau pour la liste des sans stages
$suivis_par_ref_avec_stage_code[]=$e->code_etudiant;
//$csv_output .= $nom_etudiant.";".$prenom_etudiant.";".$nom_entreprise.";".$club_entreprise.";".$libelle_stage[$type_de_stage].";".$nom_ref.";".$prenom_ref.";";
for($i=0;$i<sizeof($st_champs);$i++) {
$temp=$st_champs[$i];
$val_csv=$e->$temp;
//inutile avec nettoiecsv
//on enleve les eventuels ;
//$val_csv=str_replace(";",", ",$e->$st_champs[$i]);
//on enleve les eventuels RC
//$val_csv=str_replace("\n"," ",$val_csv);
//$val_csv=str_replace("\r"," ",$val_csv);
// si c'est un champ date 
 if (in_array ($st_champs[$i] ,$liste_champs_dates_courts ))
 {//on transforme les dates sql en dd/mm/yy
 $val_csv=mysql_DateTime($e->$temp);
 }
 if (in_array ($st_champs[$i] ,$liste_champs_dates_longs ))
 {//on transforme les dates sql en dd/mm/yy
 $val_csv=mysql_Time($e->$temp);
 
 }
 $champsprofs=array('code_tut1_prop','code_tut2_prop','code_tut3_prop');
 if (in_array ($st_champs[$i] , $champsprofs ) and $val_csv !='' and $val_csv !='NC')
{
//on remplace les code des profs par leur nom
 $val_csv=$enseignants_nom[ $val_csv]." ".$enseignants_prenom[ $val_csv];
 
 }
 // on rajoute le mail du tuteur
 if ($st_champs[$i]=='code_tuteur_gi' and $val_csv !='' and $val_csv !='NC'){
 $val_csv=$enseignants_nom[ $val_csv]." ".$enseignants_prenom[ $val_csv].";".$enseignants_email[ $val_csv];
 }
 
    $csv_output .= nettoiecsv($val_csv) ; 

	}
$csv_output .= "\n";		 
		 		 // gestion du cas vide
				if ($e->code_tuteur_gi=='')$temp='9999'; 
				else $temp=$e->code_tuteur_gi ;
				
			echo "<tr>";
			echo "<td>";
							// si c'est un PFE il faut afficher les reportings
				if ($type_de_stage=='11'){
							


						  // timeline

 // on contruit le tableau des météos
						   $tableau_id_reporting=array();
						   $tableau_meteo=array();
						   $tableau_id_fil=array();
						   $sqlquery="SELECT id_reporting,id_fil,meteo  FROM fil_discussion ";
						   $sqlquery .=" where id_stage='".$code_stage."' ";
						      $sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL) order by id_reporting ";
							  //on vérifie si pour ce PFE il existe des reportings
									//echo $sqlquery ;
									$resultat2=mysql_query($sqlquery,$connexion );
									while ($v=mysql_fetch_array($resultat2))
									{
									
									$tableau_id_reporting[]=$v["id_reporting"];
									$tableau_id_fil[]=$v["id_fil"];
									$tableau_meteo[]=$v["meteo"];
									}
									if (sizeof($tableau_id_reporting)>0)
									{
									// calcul de la liste des semaines
										$dureestage=diffdate(mysql_DateTime($e->date_debut),mysql_DateTime($e->date_fin))+1;
										//echo "duree du stage : ".$dureestage . " semaines";
									$liste_id_reporting=array();

									for ($i=1;$i<=$dureestage;$i++)
									{
									$temp1=$i;
										if ($i<10){
										$temp1="S0".$temp1;}
										else
										{
										$temp1="S".$temp1;}

									$liste_id_reporting[]=$temp1;
									}
						   echo "<table border =1 width=400> ";
						   echo "<tr align=center>";
								foreach($liste_id_reporting as $ci3)
								{

								if (current($tableau_id_reporting) == $ci3)
								{
								echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)]."> ".substr($ci3,1,2)." </td>";
								//echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)]."> ".$ci3." </td>";
								
								next($tableau_meteo);
								next($tableau_id_reporting);
								next($tableau_id_fil);
								}
								else
								{
								echo "<td > ".substr($ci3,1,2)." </td>";
								}
//echo current($tableau_id_reporting)."---".current($tableau_meteo)."---".$ci3.'/';
								}		
						  echo" </tr></table>";
								}
					}
			echo "</td>";				
              echo"<td>". $nom_etudiant. " ".$prenom_etudiant." </td><td> ".$nom_entreprise." </td><td> ".$libelle_stage[$type_de_stage]." </td><td> ".$enseignants_nom[$temp]." ".$enseignants_prenom[$temp]." </td><td> ".$date_debut." </td><td> ".$date_fin." </td><td> ".$etape ;
        echo "   </td><td nowrap>";
		if((in_array ($login ,$re_user_liste ))){
         echo "<A href=".$URL."?del=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'].$filtre;
         echo" onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce stage ?')\">sup</A> - ";
		 }
         echo "<A href=".$URL."?mod=".$code_stage."&code_etu=".$_GET['code_etu']."&code_ent=".$_GET['code_ent'].$filtre;
          echo ">détails</A>";
					 		 if ($type_de_stage=='11'){
		           echo "-<A href=fils.php?filtre_id=".$code_stage.$filtre;
					echo ">fil</A>-";
					}
		  		if($etape == 1  and ($login_tuteur==$login or $login_suiveur==$login)){
         echo "<A href=".$url_personnel."profstages.php?mod=".$code_stage;
         echo" onclick=\"return confirm('Vous allez être redirigé vers le formulaire de validation de ce stage ?')\"> -valider</A>  ";
		 }
		 echo  "</td></tr> ";
       $i++; }
	   
	   if((in_array ($login ,$re_user_liste ))){
	echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='EXPORT vers EXCEL'> <br> "  ;

echo "</form>";
}
       echo "</table> ";
	   // pour les eleves sans stages ds liste du referent
	   if ($_GET['st_lienreferent']!='')
		{
		$sans_stages_code=array_diff($suivis_par_ref_code,$suivis_par_ref_avec_stage_code);
		
		echo "<br>liste des ".sizeof($sans_stages_code)." élèves sans stage dont je suis le référent <br><br>";
		echo "<table border=1>";
		foreach ($sans_stages_code as $ci)
			{
			echo "<tr><td align = left >";
			echo $etudiants_nom[$ci]." ".$etudiants_prenom[$ci];
			echo "</td><td>";
			echo "<a href=mailto:".$etudiants_email[$ci].">".$etudiants_email[$ci]."</a>";
			echo "</td><td>";
			echo "<a href=fiche.php?code=".$ci.">Détails</a>";
			echo "</td></tr>";
			}
		echo "</table>";
		}
		} //fin du if nombre
      }//fin du affiche liste
	  } 

 echo "</td></tr></table>";
  mysql_close($connexion);
 ?>

</body>
</html>