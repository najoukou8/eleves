<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des entreprises</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
require('header.php');
if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_POST['bouton_cp_add'])) $_POST['bouton_cp_add']='';
if (!isset($_POST['bouton_cp_mod'])) $_POST['bouton_cp_mod']='';
if (!isset($_POST['bouton_cp'])) $_POST['bouton_cp']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['fromstage'])) $_POST['fromstage']='';
if (!isset($_GET['fromstage'])) $_GET['fromstage']='';
if (!isset($_POST['code_etu'])) $_POST['code_etu']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['club_indus'])) $_POST['club_indus']='';
if (!isset($_POST['villecp'])) $_POST['villecp']='';
$message='';
$sql1='';
$sql2='';
$villecode='';
$liste_effectif=array('NC','inf à 50','entre 50 et 200','entre 200 et 500','entre 500 et 2000','sup à 2000');
   //seules les personnes autorisées ont acces à la liste
if(in_array ($login ,$re_user_liste )){
	$affichetout=1;
}else
	{$affichetout=0;
	// si on ne vient pas de la creation d'un stage on affiche le texte
	 if (($_GET['fromstage']=='2' or $_POST['fromstage']=='2' )){
	 }else{
	echo affichealerte("Seul le service des relations entreprises peut accéder à la liste des entreprises");
	echo "<br><center><A class='abs' href=default.php > Revenir à l'Accueil </a></center><br><br>";
	}
	
	
	}
	
//si on vient de creation de stage et qu'on a appuyé sur annuler
    if (($_GET['fromstage']=='2' or $_POST['fromstage']=='2' )and $_POST['bouton_annul']!=''){
			echo "<center><a href=etustages.php>    revenir à la création du stage</a></center>";
}
$URL =$_SERVER['PHP_SELF'];;
$table="entreprises";
$tabletemp="entreprises";
$champs=champsfromtable($tabletemp);
$taillechamps=champstaillefromtable($tabletemp);
//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces et slashs dans les noms de champs
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si admin ent ou si on vient de creation de stage
 if((in_array ($login ,$re_user_liste )) or $_POST['fromstage'] !=''){
  // if($_POST['nom']!='' and $_POST['effectif']!='NC' ) {
  if($_POST['nom']!='' ){
 $_POST['modifpar']=$login;
 
 //on sauvegarde le nom 'brut' au  cas ou il y aurait des apostrophes
 //ceci pour pouvoir forger une url de retour ci dessous correcte
 $sauv_nom_ent=stripslashes($_POST['nom']);
foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="code"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(), ";}
 elseif ($ci2=="entreprises_SIRET"){
  $sql1.= $ci2.",";
 //on supprime les espaces
 $sql2.= "'".str_replace( ' ', '',$_POST[$ci2])."', ";}
  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  // $query = "INSERT INTO $table(nom,email)";
    $query = "INSERT INTO $table($sql1)";
   $query .= " VALUES($sql2)";
 // echo $query;
  $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
		 if ($result){
   //il faut recuperer le code du stage qui vient d'etre cree
    $sqlquery="SELECT     MAX(code) AS Expr1 FROM  entreprises ";
$resulmax=mysql_query($sqlquery,$connexion ); 
$e=mysql_fetch_object($resulmax);
    //$flg = mysql_fetch_row($resulmax);
    $max = $e->Expr1;
	}
   if  ($_POST['fromstage'] =='1'){
    $message .= "<a href=stages.php?add=1&nom_ent=".urlencode($sauv_nom_ent)."&code_etu=".$_POST['code_etu']."&code_nouvelle_entreprise=".$max .">    revenir à la création du stage</a>";
    }
   if  ($_POST['fromstage'] =='2'){
    echo "<center><a href=etustages.php?add=1&nom_ent=".urlencode($sauv_nom_ent)."&code_etu=".$_POST['code_etu']."&code_nouvelle_entreprise=".$max.">    revenir à la création du stage</a></center>";
	$affichetout=0;
    }
	if  ($_POST['fromstage'] =='3'){
    $message .= "<a href=offres.php?add=1&nom_ent=".urlencode($sauv_nom_ent)."&code_nouvelle_entreprise=".$max.">    revenir à la création de l'offre de stage</a>";
    }
    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez donnez un nom et un effectif à votre entreprise ! : Recommencez !");
	if  ($_POST['fromstage'] =='2'){
    echo "<center><a href=etustages.php>    revenir à la création du stage</a>  </center>";
		}
	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if((in_array ($login ,$re_user_liste )) or $login==$_GET['modifpar']){
//mais avant il faut verifier qu'un stage n'y est pas rattaché
   $query = "SELECT * FROM stages where code_entreprise= ".$_GET['del'] ." order by date_debut";
 // echo $query;
     $result = mysql_query($query,$connexion ); 
    $nombre = mysql_num_rows($result);
     if ($nombre <> 0){
      echo "<br><center>impossible de supprimer cette entreprise car ".$nombre." stage(s)
      lui sont associés</center><br>";
     }
	 else{
	 $query = "SELECT * FROM offres_stages where code_entreprise= ".$_GET['del'] ." order by date_modif";
 //echo $query;
     $result = mysql_query($query,$connexion ); 
    $nombre = mysql_num_rows($result);
     if ($nombre <> 0){
      echo "<br><center>impossible de supprimer cette entreprise car ".$nombre." offres de stage(s)
      lui sont associées</center><br>";	 
	 }
     else {
	 //et qu'une offre de stage n'y est pas rattachée non plus 
   $query = "DELETE FROM $table"
      ." WHERE code='".$_GET['del']."'";
     // echo $query;
  $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
   }
   }
   }
      else{
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}

//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if((in_array ($login ,$re_user_liste )) or $login==$_POST['modifpar']){
 //pour modifpar
$_POST['modifpar']=$login;

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="code"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2."=now(), ";}
 elseif ($ci2=="entreprises_SIRET"){
 //on supprime les espaces
 $sql1.= $ci2."='".str_replace( ' ', '',$_POST[$ci2])."', ";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }



 //attention il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE code='".$_POST['code']."' ";
  // echo $query;
     $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
    }
   else{
   echo "<b>seul le createur de la fiche ou le  service relations industrielles peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==


} //fin du if

if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

  $query = "SELECT * FROM $table where code=".$_GET['mod']." order by nom";
   $result = mysql_query($query,$connexion);
   $e=mysql_fetch_object($result);
         $code_entreprise= $e->code;
         $nom_entreprise= $e->nom;
         $adresse1_entreprise= $e->adresse1;
         $adresse2_entreprise= $e->adresse2;
         $code_postal_entreprise= $e->code_postal;
         $ville_entreprise= $e->ville;
		 $pays_entreprise= $e->pays;
         $commentaires_entreprise= $e->commentaires;
         $modifpar_entreprise= $e->modifpar;
         $date_modif_entreprise= mysql_Time($e->date_modif);
         $club_indus_entreprise=$e->club_indus;
         $taxeprof_entreprise=$e->taxeprof;	
		$effectif=$e->effectif;
		   //on fait une boucle pour créer les variables issues de la table
   foreach($champs as $ci2){
   $$ci2=$e->$ci2;
   }
         }
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";
   //si on revient  du choix du codepost
    if ($_POST['bouton_cp']!=''){
     foreach($_POST as $ci2){
	     // foreach($champs as $ci2){
		     $x=key($_POST)."_entreprise";
   $$x= stripslashes(current($_POST));
  // echo "$".$x."=".stripslashes(current($_POST))."<br>";
      next($_POST) ;
   }
    if (  $_POST['villecp']!=''){
	   if ($_POST['bouton_cp']=='OK'){
   $villecode=explode("_",$_POST['villecp']);
    $ville_entreprise=$villecode[0];
   $code_postal_entreprise=$villecode[1];  }
   	else {$code_postal_entreprise=$code_postal_sauv_entreprise;
	}
   }
  }
    echo"<input type='hidden' name='code' value=\"$code_entreprise\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
   echo affichechamp('Nom Entreprise','nom',$nom_entreprise,40,'',1);
   //echo affichechamp('Nom contact','responsable_adm',$responsable_adm_entreprise);
   //echo affichechamp('Qualité contact','qualite_resp',$qualite_resp_entreprise);

   echo "</tr><tr>";
   //echo affichechamp('Email','email',$email_entreprise);
   //echo affichechamp('téléphone','telephone',$telephone_entreprise,'12');
   //echo affichechamp('Fax','fax',$fax_entreprise,'12');
   echo "</tr><tr>";
   echo affichechamp('adresse','adresse1',$adresse1_entreprise);
     echo affichechamp('adresse suite','adresse2',$adresse2_entreprise);
    echo "</tr><tr>";
	// on met en hidden le code postal pour que si l'on annule la proposition du bouton on le retrouve 
		 echo"<input type='hidden' name='code_postal_sauv' value=\"".$code_postal_entreprise."\">";
    echo affichechamp('code postal','code_postal',$code_postal_entreprise,'5');

    echo affichechamp('Ville','ville',$ville_entreprise,'40','','1');
	    echo affichechamp('Pays','pays',$pays_entreprise);
    echo "</tr><tr>";
    echo" <td> <input type='Submit' name='bouton_cp_mod' value='verif code postal'></td>    ";
    echo "</tr><tr>";
    $listeouinon=array('oui','non') ;
      echo afficheradio ('membre du club des industriels','club_indus',$listeouinon,$club_indus_entreprise,'non') ;
	  if ($effectif =='')$effectif='NC';
	echo affichemenu('effectif','effectif',$liste_effectif,$effectif);
	    echo "</tr><tr>";
	    echo affichechamp('Num SIRET  (sans espaces)','entreprises_SIRET',$entreprises_SIRET,'14');
    
	echo  affichemenusqlplusnc('Code NAF ','entreprises_NAF','codes_naf_naf','select * from codes_naf order by codes_naf_naf desc','codes_naf_naf',$entreprises_NAF,$connexion,'codes_naf_libelle');
	    echo "</tr><tr>";
		echo "<td><a href=http://www.kompass.fr/ target=blank>si SIRET ou NAF pas connu voir ici</a></td>";
			    echo "</tr><tr>";
				    echo "</tr><tr>";
      echo "          <td>commentaires<br><textarea name='commentaires' cols=30 rows=5>$commentaires_entreprise</textarea ></td>    ";

 echo "</tr><tr>"; 
 //seules  les personnes autorisées voient taxeprof
 if((in_array ($login ,$re_user_liste ))){
	echo affichechamp('montant taxe apprentissage','taxeprof',$taxeprof_entreprise,15);
} else{
//mais il faut qd meme la metrre en hidden pour le k ou on passe par code postal
   	echo"<input type='hidden' name='taxeprof' value=\"$taxeprof_entreprise\">   ";
}
  // echo "          <td>modifié par</td> <td><input readonly type='text' name='modifpar' size=20 value=\"$modifpar_entreprise\"></td>    ";
	    echo "</tr><tr>";
    echo affichechamp('modifié par','modifpar',$modifpar_entreprise,'15',1);
    echo affichechamp('le','date_modif',$date_modif_entreprise,'15',1);
    //echo date();
    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";

      echo  "<center><a href=stages.php?code_ent=".$code_entreprise.">liste des stages de $nom_entreprise</a></center>";
	    echo  "<center><a href=offres.php?code_ent=".$code_entreprise.">liste des offres de stages de $nom_entreprise</a></center>";
      }
 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 if (!isset($nom_entreprise)) $nom_entreprise='';
  if (!isset($email_entreprise)) $email_entreprise='';
   if (!isset($telephone_entreprise)) $telephone_entreprise='';
    if (!isset($adresse1_entreprise)) $adresse1_entreprise='';
    if (!isset($adresse2_entreprise)) $adresse2_entreprise='';
    if (!isset($code_postal_entreprise)) $code_postal_entreprise='';
    if (!isset($ville_entreprise)) $ville_entreprise='';
    if (!isset($commentaires_entreprise)) $commentaires_entreprise='';
    if (!isset($responsable_adm_entreprise)) $responsable_adm_entreprise='';
    if (!isset($qualite_resp_entreprise)) $qualite_resp_entreprise='';
    if (!isset($fax_entreprise)) $fax_entreprise='';
    if (!isset($club_indus_entreprise)) $club_indus_entreprise='';
	if (!isset($taxeprof)) $taxeprof='';
	if (!isset($club_indus)) $club_indus='';
	if (!isset($pays_entreprise)) $pays_entreprise='';
	if (!isset($effectif)) $effectif='';
	if (!isset($entreprises_SIRET)) $entreprises_SIRET='';
	if (!isset($entreprises_NAF)) $entreprises_NAF='';
  echo    "<form method=post action=$URL> ";
  echo"       <table><tr> ";
  //if ($_POST[bouton_add]){
  echo"<input type='hidden' name='ajout' value=1>";
  //}
  //si on revient  du choix du codepost
    if ($_POST['bouton_cp']!=''){
    foreach($champs as $ci2){
    $x=$ci2."_entreprise";
   $$x= stripslashes($_POST[$ci2]);
   }

     if (  $_POST['villecp']!=''){
   $villecode=explode("_",$_POST['villecp']);
    $ville_entreprise=$villecode[0];
   $code_postal_entreprise=$villecode[1];  }


  }
   echo"<center>";

   echo"       <table><tr>  ";
   echo affichechamp('Nom Entreprise','nom',$nom_entreprise,30,'',1);
  // echo affichechamp('Nom contact','responsable_adm',$responsable_adm_entreprise);
  // echo affichechamp('Qualité contact','qualite_resp',$qualite_resp_entreprise);

   echo "</tr><tr>";
   //echo affichechamp('Email','email',$email_entreprise);
   //echo affichechamp('téléphone','telephone',$telephone_entreprise,'12');
   //echo affichechamp('Fax','fax',$fax_entreprise,'12');
   echo "</tr><tr>";
   echo affichechamp('adresse','adresse1',$adresse1_entreprise);
     echo affichechamp('adresse suite','adresse2',$adresse2_entreprise);
    echo "</tr><tr>";
    echo affichechamp('code postal','code_postal',$code_postal_entreprise,'5');

    echo affichechamp('Ville','ville',$ville_entreprise,'','','1');
	    echo affichechamp('Pays','pays',$pays_entreprise,'','','1');
    echo "</tr><tr>";
    echo" <td> <input type='Submit' name='bouton_cp_add' value='verif code postal'></td>    ";
    echo "</tr><tr>";
    //les etudiants ne remplissent pas club des indus
   // if ($_GET['fromstage']=='2' or $_POST['fromstage']=='2'){
   // }else{

      echo "          <td>commentaires<br><textarea name='commentaires' cols=30 rows=5>$commentaires_entreprise</textarea ></td>    ";
 echo "</tr><tr>";
  echo "</tr><tr>";
	    echo affichechamp('Num SIRET  (sans espaces)','entreprises_SIRET','','14');
		echo  affichemenusqlplusnc('Code NAF ','entreprises_NAF','codes_naf_naf','select * from codes_naf order by codes_naf_naf desc','codes_naf_naf','',$connexion,'codes_naf_libelle');
	    echo "</tr><tr>";
		echo "<td><a href=http://www.kompass.fr/ target=blank>si SIRET ou NAF pas connu voir ici</a></td>";
			  echo affichemenu('effectif','effectif',$liste_effectif,'NC');

			    echo "</tr><tr>";
 //seules  les personnes autorisés saisissent  club des indus et taxeprof
 if((in_array ($login ,$re_user_liste ))){
 $listeouinon=array('oui','non') ;
      echo afficheradio ('membre du club des industriels','club_indus',$listeouinon,$club_indus_entreprise,'non') ;
echo affichechamp('montant taxe apprentissage','taxeprof',$taxeprof,15);
} else{
# c'est un etudiant qui est en train de cree l'entreprise
//mais il faut qd meme les metrre en hidden pour l'initialiser correctement (et qd on passe par code postal
		echo"<input type='hidden' name='club_indus' value=\"non\">   ";

		echo"<input type='hidden' name='taxeprof' value=\"$taxeprof\">   ";
}
   //il faut mettre en hidden ces 3 au cas ou on passe par code postal
 echo "          <input type='hidden' name='modifpar' value=\"\">    ";
  echo "          <input type='hidden' name='date_modif' value=\"\">    ";
   echo "          <input type='hidden' name='code' value=\"\">    ";
   //il faut mettre en hidden ces 2 ci au cas ou  on vient de stage
   if ($_GET['fromstage']=='1' or $_POST['fromstage']=='1'){
    echo "<input type='hidden' name='fromstage' value='1'>    ";
     echo "<input type='hidden' name='code_etu' value=\"".$_GET['code_etu']."\">    "; }
     if ($_GET['fromstage']=='2' or $_POST['fromstage']=='2'){
    echo "<input type='hidden' name='fromstage' value='2'>    ";
     echo "<input type='hidden' name='code_etu' value=\"".$_GET['code_etu']."\">    "; }
	      if ($_GET['fromstage']=='3' or $_POST['fromstage']=='3'){
    echo "<input type='hidden' name='fromstage' value='3'>    ";
    }
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }
 //------------------------------------c'est kon a cliqué sur le bouton code postal
  if($_POST['bouton_cp_add']!='' or $_POST['bouton_cp_mod']!=''){
  $affichetout=0;
 echo  "<center><FORM  action=".$URL." method=POST > ";

  //il faut remettre ds le formulaire tous les champs du formulaire source sauf le bouton lui meme
   for($i=0;$i<sizeof($_POST);$i++) {
   if ( (key($_POST) != 'bouton_cp_add')and (key($_POST) != 'bouton_cp_mod') ){
  echo"<input type='hidden' name='".key($_POST)."' value=\"".stripslashes(current($_POST))."\">"."\n";
  }
    next($_POST);
  }
  if($_POST['bouton_cp_add']!='') {echo"<input type='hidden' name='add' value=1>";}
  if ($_POST['bouton_cp_mod']!=''){echo"<input type='hidden' name='mod' value=1>";  }
   if ($_POST['fromstage']!=''){echo"<input type='hidden' name='fromstage' value='".$_POST['fromstage']."'>";  }
   if ($_POST['code_etu']!=''){echo"<input type='hidden' name='code_etu' value='".$_POST['code_etu']."'>";  }

   //echo "on a cliqué sur le bouton cp";
  echo "<center><b>Vérification des Codes Postaux</b></center>";
$where="WHERE codep like '".$_POST['code_postal']."%'";
$sqlquery="SELECT * FROM codepostaux ".$where." order by commune;";

 if($_POST['code_postal']!=""){
  $resultat=mysql_query($sqlquery,$connexion ); 
 //tout ça pour compter les renregistrements retournés
     $cnt = mysql_num_rows($resultat);

if ($cnt<>0){
echo "<center>il y a  <b>$cnt</b> villes qui correspondent à ce code<br></center> <hr>";
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
echo "<input type='Submit' name='bouton_cp' value='OK'> ";
echo "<input type='Submit' name='bouton_cp' value='Annuler'> ";
echo "</form>";
echo"</center>";

 }else
//il ny a pas de corrrespondance
{ echo "il n'y pas de ville avec ce code postal<br>";
	echo "<input type='Submit' name='bouton_cp' value='OK'> ";	
}
 } //fin du if($_POST[code_postal]!="") 
 
 else {

 echo "vous n'avez rien saisi dans le champ code postal";
 echo "<input type='Submit' name='bouton_cp' value='OK'> "; }
 }  //fin du if($_POST[bouton_cp_add] ...

 if ($affichetout)  {
echo"<table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT * FROM $table order by nom";
      $result = mysql_query($query,$connexion ); 	 
   $i=1;
echo "<br><br><A href=".$URL."?add=1 class='abs'> Ajouter une entreprise </a><br>";
echo "<br/>";
echo"<h1 class='titrePage2'> Liste des   ";
$nombre=  mysql_num_rows($result);
echo $nombre;
echo" entreprises de la base</center><table class='table1'> ";
//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";}
$csv_output .= "\n";
while($e=mysql_fetch_object($result)) {
     $nom=$e->nom;
     $code=$e->code ;
     $ville=$e->ville ;
	 $modifpar=$e->modifpar ;
	 
	 foreach($champs as $ci2){
   $$ci2=$e->$ci2;
   $csv_output .= "\"".$e->$ci2."\"".";";
   }
   $csv_output .= "\n";
	 
      echo"   <tr><td>" ;
      echo $nom ;
      echo"   </td><td>" ;
      echo $ville ;
      echo"      </td><td nowrap> ";
     echo " <A class='abs2' href=".$URL."?del=".$code."&modifpar=".$modifpar. " onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette entreprise ?')\">";
     echo "Supp</A> - ";
     echo "<A class='abs' href=". $URL."?mod=".$code.">Détails</A>";
     echo"        </td> </tr>";
       }
	    echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL' class='bouton_ok'>"  ;
echo "</form>";
echo"</table> ";


  }

mysql_close($connexion);
require('footer.php');
?>
</body>
</html>