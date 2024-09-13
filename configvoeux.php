<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des campagnes de voeux</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
error_reporting(E_ERROR | E_PARSE);
require ("param.php");
require ("function.php");
require ("style.php");
require ("paramvoeux.php");
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
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_GET['purge'])) $_GET['purge']='';
if (!isset($_GET['numero_campagne'])) $_GET['numero_campagne']='';
 if(!isset($_POST['datelimitevoeuxRO']))$_POST['datelimitevoeuxRO']='';
$message='';
$sql1='';
$sql2='';
$where='';
$orderby= '';
$filtre='';
if ($_GET['env_orderby']=='') {$orderby='ORDER BY CAST(numero_campagne as unsigned)';}
	else{
	$orderby=urldecode($_GET['env_orderby']);
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
	$orderby="ORDER BY ".$orderby;
                  if  ($_GET['env_inverse']=="1"){
                  $orderby=$orderby." desc";
                  }
	}
   //seules les personnes autorisées ont acces à la liste
//if(in_array($login,$re_user_liste)){
// tout le monde
if(1){
	$affichetout=1;
}else
	{$affichetout=0;
	}
$URL =$_SERVER['PHP_SELF'];;
$table="param_voeux";
//on cree un tableau $champs[] avec les noms des colonnes de la table universite et leur taille
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





// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si autorisé
 if(1){
 //if($login=='administrateur'){
// test valeurs obligatoires
 if (!($_POST['titrevoeux']=='' or $_POST['gpecible']==''  or $_POST['datedebutvoeux']=='' or $_POST['datelimitevoeux']=='' or $_POST['idsondage']=='' )){
 $_POST['modifpar']=$login;
//valeur par defaut et pb des dates mysql

foreach($champs as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates_paramvoeux)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }

         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(),";}
  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
    $query = "INSERT INTO $table($sql1)";
   $query .= " VALUES($sql2)";
  //echo $query;
      $result = mysql_query($query,$connexion);
       if ($result){
    $message = "Fiche <b>".$_POST['id']." - ";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 
    }
   else{   // fin du nom=''
    echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
if($login=='administrateur'){
   $query = "DELETE FROM $table"
      ." WHERE id='".$_GET['del']."'";
   //  echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
      else{
   echo "<center><b>seul le service relations  entreprises peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
// ---------------------------------purge de la campagne
elseif($_GET['purge']!='') {
 $temp_nomgpe="voeux_liste".$_GET['numero_campagne'];
	  		if(in_array($login,$$temp_nomgpe)){	 
   $query = "DELETE FROM voeux_eleves"
         ." WHERE v_id_sondage='".$_GET['purge']."'";
   //  echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "<b>".mysql_affected_rows(). " voeux de cette campagne ";
   $message .= "</b> supprimés <br>!";
   }
   // pour la campagne 6 il faut aussi vider la table ligne_voeux_ues5
   if ($_GET['numero_campagne']=='6' or $_GET['numero_campagne']=='16' or $_GET['numero_campagne']=='19' or $_GET['numero_campagne']=='14'or $_GET['numero_campagne']=='20')
   {
	   $query = "DELETE FROM  ligne_voeux_ues5 "
			 ." WHERE  	ligvs5_code_idsondage='".$_GET['purge']."'";
	  // echo $query;
	   $result = mysql_query($query,$connexion);
	   if($result){
	   $message .= "<br><b>".mysql_affected_rows(). " ligne de voeux de cette campagne  ";
	   $message .= "</b> supprimés <br>!";
	   }
   }
    // pour la campagne 13 il faut aussi vider les tables giptabmalus et gipevaluations
   if ($_GET['numero_campagne']=='13' or $_GET['numero_campagne']=='15')
   {
	   $query = "DELETE FROM  gipevaluations "
			 ." WHERE  	gipIdCampagne='".$_GET['purge']."'";
	   //echo $query;
	   $result = mysql_query($query,$connexion);
	   if($result){
	   $message .= "<br><b>".mysql_affected_rows(). " ligne de réponses de cette campagne  ";
	   $message .= "</b> supprimés <br>!";
	   }
	    $query = "DELETE FROM  giptabmalus "
			 ." WHERE  	TabMalusIdCampagne='".$_GET['purge']."'";
	   //echo $query;
	   $result = mysql_query($query,$connexion);
	   if($result){
	   $message .= "<br><b>".mysql_affected_rows(). " fiche de malus/bonus  de cette campagne  ";
	   $message .= "</b> supprimés <br>!";
	   }
   }
    // pour la campagne 21 il faut aussi supprimer les fichiers téléchargés
   if ($_GET['numero_campagne']=='21' )
   {
	array_map('unlink', glob($chemin_local_upload21."*.*"));

	   $message .= "<br><b>tous les fichiers téléchargés ont été supprimés  ";
	   $message .= "</b>  <br>!";
	   
   }

   
   }
      else{
   echo "<center><b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

// if(in_array($login,$re_user_liste)){

// test valeurs obligatoires
 if (!($_POST['titrevoeux']=='' or $_POST['gpecible']==''  or $_POST['datedebutvoeux']=='' or $_POST['datelimitevoeux']=='' or $_POST['idsondage']=='' or $_POST['numero_campagne']==''))
 
 {
 		 $temp_nomgpe="voeux_liste".$_POST['numero_campagne'];
	  		if(in_array($login,$$temp_nomgpe))
			{	 
			 $_POST['modifpar']=$login;
			 
			 // si date RO est vide on y met date fin
			 if($_POST['datelimitevoeuxRO']=='' or $_POST['datelimitevoeuxRO']=='NC')
			 {
			 $_POST['datelimitevoeuxRO']=$_POST['datelimitevoeux'];
			 }
			 // verif datelimitevoeuxRO < datelimitevoeux
			 if (diffdatejours($_POST['datelimitevoeuxRO'],$_POST['datelimitevoeux']) >=0 AND diffdatejours($_POST['datelimitevoeuxRO'],$_POST['datedebutvoeux']) < 0 )
					 {

					//pour les dates

					foreach($champs as $ci2){
					if (!isset($_POST[$ci2])) $_POST[$ci2]='';
					 if (in_array($ci2,$liste_champs_dates_paramvoeux)){
					 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
					 }
							 //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
					 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
					 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
					 if ($ci2=="id"){
					 //on ne fait rien
					 }
					 elseif ($ci2=="date_modif"){
					 $sql1.= $ci2."=now(),";}
					  else{
					 $sql1.= $ci2."='".$_POST[$ci2]."',";}
					 }

					 //attention il faut enlever la virgule de la fin
					 $sql1=substr($sql1,0,strlen($sql1)-1) ;

					   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
					   $query = "UPDATE $table SET $sql1";
					   $query .= " WHERE id='".$_POST['id']."' ";
					  //echo $query;

					   $result = mysql_query($query,$connexion);
					   if($result){

					   $message = "Fiche numero ".$_POST['id']." modifiée <br>";}
					else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();
					}
					// echo " bon";
					} // fin du if date ro < datefin
					else
					{
					echo affichealerte( " la date de début accès des élèves en consultation uniquement doit être antérieure ou égale à la date de fin et supérieure à la date de début  Recommencez  !" );
					}// fin du else date ro < datefin								
			}
				else
			{
				   echo "<b>seul le   service autorisé peut effectuer cette operation</b><br>";
				  echo "aucune modification effectuée<br>";
			}//fin du if login
	}
   else{
	echo affichealerte("il manque des valeurs obligatoires Recommencez!");

} //fin du else valeurs obligatoires
} // fin if modif
 
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where id='".$_GET['mod']."' ";
					  //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   		   //on surcharge les dates pour les pbs de format
    if (in_array($ci2,$liste_champs_dates_paramvoeux)){
 $$ci2=mysql_DateTime($universite->$ci2);
 }
   }

		$date_modif=mysql_Time($date_modif);

		//on récupère les champs liés
     
         
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";

    echo"<input type='hidden' name='id' value=\"$id\">   ";
	 echo"<input type='hidden' name='numero_campagne' value=\"$numero_campagne\">   ";
	 	 echo"<input type='hidden' name='idsondage' value=\"$idsondage\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
  //on met en hidden le id
  if($login=='administrateur'){
     echo affichechamp('Idsondage','idsondage',$idsondage,'','');
	 echo affichechamp('numero campagne','numero_campagne',$numero_campagne,'','');
	 echo "</tr><tr>";
	 }

     echo affichechamp('Date début choix élèves *','datedebutvoeux',$datedebutvoeux,'','');
	 echo affichechamp('Date fin accès des élèves <br> que ce soit en consultation ou en modification (J-1 à 23h59) *','datelimitevoeux',$datelimitevoeux,'','');
	 echo "</tr><tr>";
	 echo affichechamp('Date fin administration *','datefinvoeuxadmin',$datefinvoeuxadmin,'','');
	 //attention ne fonctionne que pour les campagnes 3-4 et 6 et 14
	 if ($numero_campagne == 3 or $numero_campagne == 4 or $numero_campagne == 6 or $numero_campagne == 14 or $numero_campagne == 16 or $numero_campagne == 19){
	 echo affichechamp('Date début accès des élèves en consultation uniquement<br>doit être antérieure à la date de fin accès <br>et postérieure à la date de début des accès ci contre <br> Si pas souhaitée laissez vide   ','datelimitevoeuxRO',$datelimitevoeuxRO,'','');
	 echo "</tr><tr>";}
	 //attention ne fonctionne que pour les campagnes GIP 
	if ($numero_campagne == 13 or $numero_campagne == 15 ){
		
	 echo affichechamp('Date début accès  élèves restitution *','dateRestitution',$dateRestitution,'','');
	 echo "</tr><tr>";}	 
   	 echo affichechamp('Titre de la campagne *','titrevoeux',$titrevoeux,'40','');
	 echo "</tr><tr>";
	 echo affichemenusqlplusnc('Groupe cible *','gpecible','code','select * from groupes where archive !=\'oui\'  order by libelle,type_gpe_auto ','libelle',$gpecible,$connexion);
	 echo "</tr><tr>";

	 $texte_explic_numero='texteexplicatif'.$numero_campagne;
	 if (isset($$texte_explic_numero)){ 
	 echo afficheonly('',$$texte_explic_numero);}
	 echo "</tr><tr>";	 
	 echo afficheonly('', "C'est aux responsables de la campagne d'avertir les élèves du démarrage et de l'objet d'une campagne les concernant<br>Pour envoyer votre email au groupe cible, vous pouvez utiliser la base élèves en cliquant <a href=default.php?nom_recherche=&recherche_avance=non&annee=TOUS&regexp=&code_groupe_peda=".$gpecible."&options=liste+mail&bouton_ok=OK&forceFormulaireMail=1> sur ce lien</a> ",'','','',0);
	 echo "</tr><tr>";
	 echo afficheonly('', " (Signalez nous aussi le début de votre campagne à <a href=mailto:$sigiadminmail>$sigiadminmail  </a> pour que nous puissions surveiller le bon déroulement des opérations ) ",'','','',0);
	// echo affichemenusqlplusnc('Groupe cible 2 (voeux s5icl-idp)','gpecible2','code','select * from groupes where archive !=\'oui\'  order by libelle,type_gpe_auto ','libelle',$gpecible2,$connexion);
 echo" </tr>  <tr>" ; 
			echo"</table>";
			
	// pour changer les parcours /reponses campagne 3
	if ($numero_campagne == 3 ){
echo "<br>Pour cette campagne Vous pouvez modifier <a href=config_parcours_campagne3.php><b>la liste des parcours</b> </a> ainsi que <a href=config_reponses_campagne3.php><b>la liste des réponses</b></a><br>";		
	
	}
			
 //affichage des autorisations
 $query2="select * from ligne_user_voeux 
 left outer join enseignants on enseignants.uid_prof =ligne_user_voeux.ligne_user_voeux_uid
 where ligne_user_voeux_vid='".$idsondage."'";

    $result2 = mysql_query($query2,$connexion ); 
	if (mysql_num_rows( $result2) >0){
	echo afficheonly("","Personnes autorisées à administrer cette campagne :",'b' ,'h3');	
	echo "<table border=1>";
	echo "<th>nom</th>";
	while($u=mysql_fetch_object($result2)) {
		echo"   <tr><td>" ;  
			//echo $u->ligne_user_voeux_uid ;
			//echo "</td><td>";
			echo $u->prenom." ".$u->nom;

					  echo"        </td> </tr>";		  
	 }	 
	echo"</table>";
	}
	else{
	echo "</tr><tr><td colspan=2>pas d'autorisations pour cette campagne<br>";}
		echo"<table>";
				 $temp_nomgpe="voeux_liste".$numero_campagne;	
			  		if(in_array($login,$$temp_nomgpe))
	{

		echo"<td ><a href=usersvoeux.php?ligne_user_voeux_vid=".$idsondage."&numero_campagne=".$numero_campagne."&idnumero_campagne=".$id.">"."<center><h2>ajouter-supprimer des personnes autorisées</h2></CENTER></a></td>";
			 if ($numero_campagne == 6 or $numero_campagne == 16 or $numero_campagne == 14 or $numero_campagne == 19){
			echo "</tr><tr><td ><a href=ues_voeux_s5.php?voeuxS5idCampagne=".$idsondage."> <center><h2>Gérer la liste des Ues </h2></CENTER></a></td>";
			 }
		}
	echo "</tr><tr>";
    echo affichechamp('modifié par','modifpar',$modifpar,'15',1);
    echo affichechamp('le','date_modif',$date_modif,'15',1);
    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
    	  echo'(*) champ obligatoire';
		  	echo"</table>";
  echo"</center>";

      }
	  }

 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		
		
  echo    "<form method=post action=$URL> ";
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
     echo affichechamp('Identifiant de la campagne *','idsondage','','','');
	 echo affichechamp('numero campagne','numero_campagne','','','');
	 echo "</tr><tr>";
	 echo "</tr><tr>";
     echo affichechamp('Date début *','datedebutvoeux','','','');
	 echo affichechamp('Date fin élèves *','datelimitevoeux','','','');
	 echo "</tr><tr>";
	 echo affichechamp('date fin voeux admin','datefinvoeuxadmin','','','');
	 echo "</tr><tr>";
	 echo affichechamp('datelimitevoeuxRO : laissez vide','datelimitevoeuxRO','','','');
	 echo affichechamp('Date début accès  élèves restitution (campagnes gip ) : laissez vide ','dateRestitution','','',''); 
	 echo "</tr><tr>";
   	 echo affichechamp('Titre de la campagne *','titrevoeux','','40','');
	 echo "</tr><tr>";	 
	 echo affichemenusqlplusnc('Groupe cible *','gpecible','code','select * from groupes where archive !=\'oui\'  order by libelle,type_gpe_auto ','libelle','',$connexion);
	 echo "</tr><tr>";
	 //echo affichemenusqlplusnc('Groupe cible 2 (voeux s5icl-idp)','gpecible2','code','select * from groupes where archive !=\'oui\'  order by libelle,type_gpe_auto ','libelle','',$connexion);

	 echo "</tr><tr>";

   
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
   echo'(*) champ obligatoire';
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT * FROM $table where 1 ";
   $query.=$where."  ".$orderby;
   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h1 class='titrePage2'>Liste des   ";
echo $nombre;
echo" campagnes de voeux</h1>";}

 if($login=='administrateur'){
echo "<A href=".$URL."?add=1> Ajouter un enregistrement </a><br>";
}
echo"<br><br><a class='abs' href=default.php>Revenir à l'Accueil</a>";
if ($nombre>0){
echo"<BR><table class='table1'> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br><br>En vert les campagnes actuellement en cours </center>";
echo"<br><i>Attention! Pour pouvoir puger ou tester une campagne , il faut que la date de fin-admin soit passée</i> </center>";
        echo "<BR><BR><table class='table1'><tr bgcolor=\"#98B5FF\" > ";
echo afficheentete('num','numero_campagne',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo afficheentete('id','idsondage',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

echo afficheentete('titre','titrevoeux',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

echo afficheentete('debut','datedebutvoeux',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('fin','datelimitevoeux',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('fin-admin','datefinvoeuxadmin',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo "<th>Nbr d'inscris</th>";
echo "<th>Supprimer/Purger</th>";
echo "<th>Nbr réponses</th>";
echo "<th>Résultats</th>";
echo "<th>CRUD</th>";

//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";
}
$csv_output .= "\n";
while($universite=mysql_fetch_object($result)) {

// on va récupérer pour chaque campagne le nombre de réponses

   $querysuite = "SELECT * FROM voeux_eleves where v_id_sondage='".$universite->idsondage."' ";
   $resultsuite = mysql_query($querysuite,$connexion ); 
$nombre= mysql_num_rows($resultsuite);
// et le nombre d'élèves du groupe cible
//pour affichage dans le tableau
   $querysuite = "SELECT * FROM ligne_groupe left outer join annuaire on `code_etudiant`=annuaire.`code-etu` where code_groupe='".$universite->gpecible."' ";
   $resultsuite = mysql_query($querysuite,$connexion ); 
$nombretot= mysql_num_rows($resultsuite);
//et le premier et dernier uid d'un élève du groupe cible
$uidclone1='';
$uidclone='';
while($w=mysql_fetch_object($resultsuite)) {
	if($uidclone1=='') $uidclone1=$w->UId;
$uidclone=$w->UId	;
}
 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   if (in_array ($ci2 ,$liste_champs_dates_paramvoeux))

 {
 
 
 
 
 
 //on transforme les dates sql en dd/mm/yy
     $$ci2=mysql_DateTime($universite->$ci2);
 $csv_output .= mysql_DateTime($universite->$ci2).";";
 }else{
   $csv_output .= $universite->$ci2.";";
   }   
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format

		//on récupère les champs liés
		 $temp_nomgpe="voeux_liste".$numero_campagne;	
	  		// if (diffdatejours($datefinvoeuxadmin)<0 and diffdatejours($datedebutvoeux)>0 and (in_array($login,$$temp_nomgpe))){
		 // $fond="bgcolor='lightgreen'";}
		// if (diffdatejours($datefinvoeuxadmin)>=0 or  !(in_array($login,$$temp_nomgpe))){
		 // $fond="bgcolor='#FFFFFF'";}		
		if (diffdatejours($datelimitevoeux)<0 and diffdatejours($datedebutvoeux)>=0 ){
		 $fond2="bgcolor='lightgreen'";}	
else	{$fond2="bgcolor='FFFFFF'";}	 
		
      echo"   <tr >" ;
	   echo"   <td ".$fond2.">";
	   
      echo $numero_campagne ;
      //echo"   </td><td>" ;
	   
      //echo $idsondage ;
	   echo"   </td><td ".$fond2.">";

	  		if (diffdatejours($datefinvoeuxadmin)<0 and (in_array($login,$$temp_nomgpe))){
		        echo "<a style='animation: blink 1s;animation-iteration-count:infinite;border:2px #5a8aae solid;' class='abs' href=voeuxadmin".$numero_campagne.".php>".$titrevoeux."</a>" ;}
		else{
		        echo $titrevoeux ;}		

	   echo"   </td><td ".$fond2.">";
	   echo $datedebutvoeux ;
	   echo"   </td><td ".$fond2.">";
	   echo $datelimitevoeux ;
	   echo"   </td><td ".$fond2.">";
	   echo $datefinvoeuxadmin ;
	   echo"   </td><td>" ;	  
	   		   			   // cas particulier pour les gips
	   if ($numero_campagne != '13' and $numero_campagne != '15')
		   {
			 if (diffdatejours($datefinvoeuxadmin)>0 and (in_array($login,$$temp_nomgpe))){
		   echo $nombre ;
		   }else
		   {
		   echo $nombre ." / ".$nombretot;	   
		   }
	   }
	   echo"   </td><td>" ;	   	   

	    if($login=='administrateur'){
     echo " <A class='abs2' href=".$URL."?del=".$id." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette campagne ?')\">";
     echo "supprimer</A> - ";
	 }
	 if ((diffdatejours($datefinvoeuxadmin)>0 or diffdatejours($datedebutvoeux)<0 ) and (in_array($login,$$temp_nomgpe))){
	 echo " <A class='abs2' href=".$URL."?purge=".$idsondage ."&numero_campagne=".$numero_campagne." onclick=\"return confirm('Vous allez supprimer toutes les réponses des élèves prédemment stockées pour cette campagne : ceci est nécessaire avant le démarrage d\'une instance pour une nouvelle année, Est ce bien ce que vous souhaitez faire ?')\">";
     echo "purger</A> - ";
	 }
	 	   echo"   </td><td>" ;
		  if ((diffdatejours($datefinvoeuxadmin)>0 or diffdatejours($datedebutvoeux)<0 ) and (in_array($login,$$temp_nomgpe)))
		  {
		   			   // cas particulier pour les gips
					// if ($numero_campagne != '13' and $numero_campagne != '15')
		   // {
			   // cas particulier pour les formulaire choix ues S5 filieres
			   if ($numero_campagne=='6' or $numero_campagne=='19')
			   {
				   $temp='groupe_icl'.$numero_campagne;
									   // il faut récupérer un login pour chacun des groupes Choix UE S5 ICL , Choix UE S5 IdP , Choix UE S5 IPID
					$querysuiteS5 = "SELECT * FROM ligne_groupe left outer join annuaire on `code_etudiant`=annuaire.`code-etu` 
					left outer join groupes on `code_groupe`=groupes.`code` where libelle='".$$temp."' ";
					  // echo $querysuiteS5;
					   $resultsuiteS5 = mysql_query($querysuiteS5,$connexion ); 
					//et le dernier uid d'un élève du groupe cible
					$uidcloneICL='';
					while($x=mysql_fetch_object($resultsuiteS5)) {
						$uidcloneICL=$x->UId	;
					}
					$temp='groupe_idp'.$numero_campagne;
					$querysuiteS5 = "SELECT * FROM ligne_groupe left outer join annuaire on `code_etudiant`=annuaire.`code-etu` 
					left outer join groupes on `code_groupe`=groupes.`code` where libelle='".$$temp."' ";
					 //  echo $querysuiteS5;
					   $resultsuiteS5 = mysql_query($querysuiteS5,$connexion ); 
					//et le dernier uid d'un élève du groupe cible
					$uidcloneIDP='';
					while($y=mysql_fetch_object($resultsuiteS5)) {
						$uidcloneIDP=$y->UId	;
					}
					$temp='groupe_ipid'.$numero_campagne;
					$querysuiteS5 = "SELECT * FROM ligne_groupe left outer join annuaire on `code_etudiant`=annuaire.`code-etu` 
					left outer join groupes on `code_groupe`=groupes.`code` where libelle='".$$temp."' ";
					  //echo $querysuiteS5;
					   $resultsuiteS5 = mysql_query($querysuiteS5,$connexion ); 
					//et le dernier uid d'un élève du groupe cible
					$uidcloneIPID='';
					while($z=mysql_fetch_object($resultsuiteS5)) {
						$uidcloneIPID=$z->UId	;
					}
					if(($uidcloneIDP !=''))
					{
				   echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidcloneIDP." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève IDP</b></A>" ;
				 echo "<br>";				 
					}
					else
						{
							echo 'Gpe cible IDP vide';
						}
					if(($uidcloneICL!=''))
					{					
					   echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidcloneICL." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève ICL</b></A>" ;
				 echo "<br>"; 			 
					}
					if(($uidcloneIPID!=''))
					{					
					   echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidcloneIPID." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève IPID</b></A>" ;
				 echo "<br>"; 				 
					}
					else
						{
							echo 'Gpe cible IPID vide';
						}
				}
				elseif ($numero_campagne=='1' )
				{
					if($uidclone!='')			
					// pour la campagne 1 on n'ajoute pas le numéro :-((
					{
					  echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux.php?login_clone=".$uidclone." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève</b></A>" ;
					 }
					else
					{
						echo 'Gpe cible vide';
					}
				}
				elseif ($numero_campagne=='13' or $numero_campagne=='15')
				{
					if($uidclone!='')
					{
			  // echo "<A href=voeuxadmin".$numero_campagne .".php?mod=0&codetu=0&login= target=_blank><b>Afficher form. élève</b></A>" ;			
			  echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidclone." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève</b></A>" ;	
							 echo "<br>";
			  echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidclone."&restitution=1 target=_blank onclick=\"return confirm('Vous allez tester le formulaire de restitution comme un étudiant du groupe cible , vous pourrez ainsi juger de son apparence ')\"><b>Test form. restitution</b></A>" ;		  
					}
					else
						{
							echo 'Gpe cible vide';
						}
				}
			elseif($numero_campagne=='20')
				{
					if($uidclone!='' and $uidclone1!='')
					{					
		  // echo "<A href=voeuxadmin".$numero_campagne .".php?mod=0&codetu=0&login= target=_blank><b>Afficher form. élève</b></A>" ;			
		  echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidclone." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève</b></A>" ;	
		  		echo "<br>";		  
		  echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidclone1." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève1</b></A>" ;	
					}
					else
						{
							echo 'Gpe cible vide';
						}
				}											
				else
				{
					if($uidclone!='')
					{					
		  // echo "<A href=voeuxadmin".$numero_campagne .".php?mod=0&codetu=0&login= target=_blank><b>Afficher form. élève</b></A>" ;			
		  echo "<A class='abs' href=".$chemin_root_relatif_eleve."voeux".$numero_campagne .".php?login_clone=".$uidclone." target=_blank onclick=\"return confirm('Vous allez tester le formulaire comme un étudiant du groupe cible , les mails qui lui sont destinés vous seront envoyés , n\'oubliez pas de purger la campagne après ce test')\"><b>Test form. élève</b></A>" ;	
					}
					else
						{
							echo 'Gpe cible vide';
						}
				}		
			}
	  echo"        </td> <td>";
	  		if ( (in_array($login,$$temp_nomgpe))){

     echo "<A class='abs' href=voeuxadmin".$numero_campagne.".php><b>RESULTATS</b></A>";
	 }
		 	      echo"        </td> <td>";
	 	 if (in_array($login,$$temp_nomgpe)){

     echo "<A class='abs2' href=". $URL."?mod=".$id." ><b>MODIFIER</b></A>";
	 }
     echo"        </td> </tr>";
       }
	   
	//   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 //echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
//echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
  }
  }
mysql_close($connexion);
require('footer.php');
?>
</body>
</html>