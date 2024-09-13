<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<?
// pour gérer l'erreur quand l'upload dépasse post_max_size
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
     empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0 )
{      
  $displayMaxSize = ini_get('post_max_size'); 
  $error = 'votre fichier est trop gros :  '.(round($_SERVER['CONTENT_LENGTH']/1024/1024)).'Moctets'.
           ' , il dépasse la taille  maximum fixée à   '.
           $displayMaxSize.' octets';
		   echo "<center><H2>". $error ."</H2>";
			echo"<br><a href=default.php>revenir à l'accueil</a><br></center>";
		   //exit();
}
//attention il ne doit pas y avoir de nom de colonnes identiques
// il doit y avoir un index unique (auto incrémental ou pas ) dans chaque fichier
// si on a un seul fichier laisser les infos $cleetrangere $table2  $cleprimaire2 à vide
// si on veut auroriser tout le monde laisser des array vides 
//---paramètres à configurer

require ("style.php");
require ("param.php");
require ("function.php");
$texte_table='documents joints';
$table="apprentissagedocuments";
$cleprimaire='doc_idDoc';
$autoincrement='doc_idDoc';
$cleetrangere='';
$table2="";
$cleprimaire2='';
$liste_champs_lies=array('nom','prenom');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout=array('nom','prenom');
$champsobligatoires=array('doc_libelle');
$liste_champs_dates=array();
$liste_champs_tableau=array('doc_libelle');
$tri_initial=$cleprimaire;

$pageaccueil='offresapprentissage.php';
// email correspondant au login  administrateur
$emailadmin='marc.patouillard@grenoble-inp.fr';
// incompatible avec $login_autorises vide
$login_autorises_clone=array('patouilm','administrateur');
// est ce qu'on fait appel à ldap pour récupérer les noms prenom mail ...à partir des logins
$ldapOK=1;
// attention pour vérifier les groupes autorisés après l'authentification CAS ldap est aussi utilisé
//si on laisse vide les 2 dn des groupes , tout le monde est accepté et le nomgroupe authentification vaut :' membre de grenoble-inp'
// dn du groupe1
$dngroupe1authentification1='CN=inpg-GI-personnels-GI-GSCOP,OU=Groups,DC=gi-admin,DC=inpg,DC=fr';
// nom affiché du groupe 1 
$nomgroupe1authentification1="Personnel GI-GSCOP";
// dn du groupe1
$dngroupe1authentification2='';
// nom affiché du groupe 1 
$nomgroupe1authentification2="";
//---fin de configuration

echo "<head>";
echo "<title>".$texte_table."</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";

echo "</HEAD><BODY>" ;
// On se connecte à mysql
$connexion =Connexion ($user_sql, $password, $dsn, $host);
// On récupère la liste des logins des étudiants
$login_etudiants=array();
$result = mysql_query("select * from apprentissageetudiants");	
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {
      $login_etudiants[]= $row["etu_login"];	  
   }
}
$login_autorises=array_merge(array('administrateur','anceychr','rogesj','cataldic'),$login_etudiants);
$login_autorises_ajout=array_merge(array('administrateur','anceychr','rogesj','cataldic'));
$login_autorises_suppression=array('administrateur','anceychr','rogesj','cataldic');
$login_autorises_modif=array('administrateur','anceychr','rogesj','cataldic');
$login_autorises_export=array('administrateur','anceychr','rogesj','cataldic');
$login_autorises_admin=array('administrateur','anceychr','rogesj','cataldic');



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
if (!isset($_GET['offre'])) $_GET['offre']='';
if (!isset($_POST['clone'])) $_POST['clone']='';
if (!isset($_GET['clone'])) $_GET['clone']='';
   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
if (!isset($_GET['from'])) $_GET['from']='';
if (!isset($_POST['from'])) $_POST['from']='';


$message='';
$sql1='';
$sql2='';

if (isset($_POST['offre'])) {$_GET['offre']=$_POST['offre'];}
if ( $_GET['offre']=='') {$where='';}
else {$where="and doc_idOffre = '".$_GET['offre']."'" ;}
$orderby= '';
$filtre='';


if ($_GET['env_orderby']=='') {$orderby='ORDER by ' .$tri_initial ;}
	else{
	$orderby=urldecode($_GET['env_orderby']);
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
	$orderby="ORDER BY ".$orderby;
                  if  ($_GET['env_inverse']=="1"){
                  $orderby=$orderby." desc";
                  }
	}
 
$URL =$_SERVER['PHP_SELF'];

// pour tester comme un autre
// il faut récupérer la valeur de clone  qui pourrait être passée par un formulaire en hidden
// pour la déconnexion
// echo 'GET'.$_GET['clone'];
// echo 'POST'.$_POST['clone'];
if (($_GET['clone'] !='' ))$_POST['clone']=$_GET['clone'];
//idem pour voeu
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
// pour garder clone apres un form non lancé par un lien 
if (($_POST['clone'] !='' ))$_GET['clone']=$_POST['clone'];
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
if (($_POST['from'] !='' ))$_GET['from']=$_POST['from'];

if (($_GET['from'] !='' ))$_POST['from']=$_GET['from'];
if (($_GET['from'] !='' ))$pageaccueil=$_GET['from'];
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'displayname')[0];else  $nomloginConnecte='';
if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';
if($loginConnecte=='administrateur' ) $emailConnecte=$emailadmin;
echo " <p align=right>Vous &ecirc;tes  <b>  : ".$loginConnecte."( ".$emailConnecte.")</b>  ";
echo $nomloginConnecte."<br>";
// on sauvegarde le login de primo connexion 
$loginorigine=$loginConnecte;
// on sauvegarde le email de primo connexion 
$emailorigine=$emailConnecte;
// si on a le droit 
if (in_array($loginConnecte,$login_autorises_clone) ) {
			//et qu'on est pas sur la page  de modif ou d'ajout on affiche le formulaire clone 
	if ( $_GET['add']=='' and $_GET['mod']==''  )
	 {
		   echo  "<FORM  action=$URL method=POST name='form_clone'> ";
			echo "<p align=right>Clone";echo affichechamp('','clone','',10);	
			echo"     <input type ='submit' name='bouton_clone'  value='OK'> <br> "  ;
			echo "</form>";
	 }
			// et on remplace  $login par $_POST['clone']
	if ($_POST['clone'] !=''  ) {			
			$loginConnecte=$_POST['clone'];
			echo "<p align=right><i> login clone :".$loginConnecte."</i> ";
			if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'displayname')[0];else  $nomloginConnecte='';		
			if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';			
			echo $nomloginConnecte." (".$emailConnecte.")<br>";
			echo "<A href=".$URL."?clone= >Déconnexion $loginConnecte </a><br>";
			}
}

   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
   if ($_POST['clone']!='')
	$filtrerech="clone=".$_POST['clone']."&";
	else
	$filtrerech='';

  //seules les personnes autorisées ont acces à la liste
if(in_array($loginConnecte,$login_autorises) or empty($login_autorises) ){
	$affichetout=1;
}else
	{$affichetout=0;
	}



//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille et leur commentaires
$result = mysql_query("SHOW FULL COLUMNS FROM $table");
if (!$result) {
   echo 'Impossible d\'exécuter la requête :  ' . mysql_error();
   exit;
}
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {
      $champs[]= $row["Field"];
	  $type[]= $row["Type"];
	  $comment[$row["Field"]]= $row["Comment"];	  
   }
}
// on sauvegarde le tableau des champs sans les champs lies
$champsSingle=$champs;
if ($table2!='')
{
//on cree un tableau $champstable2[] avec les noms des colonnes de la table  et leur taille et leur commentaires
$result = mysql_query("SHOW FULL COLUMNS FROM $table2");
if (!$result) {
   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
   exit;
}
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {
      $champstable2[]= $row["Field"];
	  $typetable2[]= $row["Type"];
	  $commenttable2[$row["Field"]]= $row["Comment"];	  
   }
}
//ajouter les champs lies et leur commentaires et taille
foreach($liste_champs_lies as $champs_lie){
$champs[]=$champs_lie;
$comment[$champs_lie]=$commenttable2[$champs_lie];
}
//print_r ($champs);


// ne sert plus ?

	// // on initialise le tableau à n dimensions indicé par la clé primaire pour les différents chmaps liés
	// $tableau_champs_lies=array();
	// // on remplit les tableau à n dimension  indicés par la clé primaire  des champs liés 
	// $query9="SELECT * FROM $table2  ";
	// $resultat9 = mysql_query($query9);
		// while ($r = mysql_fetch_object($resultat9)){
		// foreach($liste_champs_lies as $champs_lie){
		// $tableau_champs_lies[$champs_lie][$r->$cleprimaire2]=$r->$champs_lie;
		// }
	// }

}


// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
	
	// il faut d'abord supprimer le document pour cela il faut récupérer le nom du fichier
	$query = "SELECT *  FROM $table"
      ." WHERE ".$cleprimaire."='".$_GET['del']."'";
	 $result = mysql_query($query,$connexion);
	$r=mysql_fetch_object($result);
	$nomdoc=$chemin_local_apprentissage.$r->doc_lienDoc;
	  if (file_exists($nomdoc))
	  {
   unlink($nomdoc);
   echo "<br>fichier  ".$nomdoc." supprimé<br>";
	  }
	  else
		echo "<br>fichier  ".$nomdoc." introuvable<br>";  
   $query = "DELETE FROM $table"
      ." WHERE ".$cleprimaire."='".$_GET['del']."'";
   //  echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
      else{
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $loginConnecte == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif)){
 
// test valeurs obligatoires
	 $yaunvide=0;
	foreach($champsobligatoires as $champsobligatoire){
	 if (($_POST[$champsobligatoire]==''  )){
	 $yaunvide=1;
	}
	}
 if (!$yaunvide ){
 $_POST['modifpar']=$loginConnecte;
//pour les dates

foreach($champsSingle as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));

if ($ci2=="date_modif"){
 $sql1.= $ci2."=now(),";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }

 //attention il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE ".$cleprimaire."='".$_POST[$cleprimaire]."' ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST[$cleprimaire]." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();
    }
	}
	else{
	echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
	}
	
   else{
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $loginConnecte ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details
  if($table2=='')
  {
       $query = "SELECT * FROM $table 
					  where ".$cleprimaire ." ='".$_GET['mod']."' ";
	}
	else
	{
	$query = "SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere = $table2.$cleprimaire2 where ".$cleprimaire ." ='".$_GET['mod']."' ";
	}	
					 // echo $query;
  $result = mysql_query($query,$connexion );
$u=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table principale
   foreach($champs as $ci2){
   $$ci2=$u->$ci2;
   		   //on surcharge les dates pour les pbs de format
    if (in_array($ci2,$liste_champs_dates)){
 $$ci2=mysql_DateTime($u->$ci2);
 }
   }
		$date_modif=mysql_Time($date_modif);

     echo    "<form method=post action=$URL> ";
	     echo"<input type='hidden' name='offre' value=".$_GET['offre'].">";
  echo"<center>";
  echo"       <table><tr>  ";
	 echo "</tr><tr>";
	 foreach ($champs as $unchamps)
	 {
			 if ($comment[$unchamps]=='')
			 {
			 $commentaire=$unchamps;
			 }else
			 {
			 $commentaire=$comment[$unchamps];
			 }
			 if(in_array($unchamps,$champsobligatoires))
			 {
				 $commentaire=$commentaire." (*) ";
			 } 			 
	 	 if ($unchamps == $cleprimaire or $unchamps == $cleetrangere or in_array($unchamps,$liste_champs_lies)){
		 // en lecture seule
		 echo affichechamp($commentaire,$unchamps,$$unchamps,'40','1');	
			 }
		 	 	elseif ($unchamps =='doc_libelle'){

		 echo affichechamp($commentaire,$unchamps,$$unchamps,'40','');	
			 }
			 		 // en lecture seule
			 else{
			 echo affichechamp($commentaire,$unchamps,$$unchamps,'40','1');	
			 }
    echo "</tr><tr>";	 
	 }
  echo "</td></tr><tr><th colspan=6>";
    //on met en hidden la cle primaire - inutile si elle est déjà affichée
  //  echo"<input type='hidden' name='$cleprimaire' value=\"".$$cleprimaire."\">   ";
   if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif))
   {
  echo"<input type='Submit' name='bouton_mod' value='modifier'>";
  }
  echo"<input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
      }
	 }

 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 
   foreach($champsSingle as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		
		
 // echo    "<form method=post action=$URL> ";
  	echo "	<form method='POST' action=$URL enctype='multipart/form-data'>";
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
  // pour garder la ref de l'offre apres avoir validé le form
    echo"<input type='hidden' name='offre' value=".$_GET['offre'].">";
	
    echo"<center>";
  echo"       <table><tr>  ";
     foreach ($champsSingle as $unchamps)
	 {
	 		 if ($comment[$unchamps]=='')
			 {
			 $commentaire=$unchamps;
			 }else
			 {
			 $commentaire=$comment[$unchamps];
			 }
			 if(in_array($unchamps,$champsobligatoires))
			 {
				 $commentaire=$commentaire." (*) ";
				 $required=' required ';
			 } 
	 // si on a une table liée
	  if ($unchamps == $cleetrangere ){
	       echo affichemenusqlplus($commentaire,$unchamps,$cleprimaire2,'select * from '.$table2,$liste_champs_lies_pour_formulaire_ajout[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout[1]);
	  }
	 // on met la ref offre comme valeur par defaut pour le champ code offre
	 elseif ($unchamps== 'doc_idOffre' ){
    // echo affichechamp($commentaire,$unchamps,$_GET['offre'],'40','1');	
		echo"<input type='hidden' name='".$unchamps."' value='".$_GET['offre']."'>";	 
	 }	  
	 //Pour télécharger le doc
	 elseif ($unchamps== 'doc_lienDoc' )
	 {	


			echo afficheonly("","Joindre un document  <br> ATTENTION format .jpg,.docx,.doc,.pdf  et <br>taille maxi 1,5 Mo ",'b' ,'h3','',0);
			//pour apres la sortie du formulaire retrouver la selection en cours
		 //On limite le fichier à 100Ko -->
		echo " <input type='hidden' name='MAX_FILE_SIZE' value='1500000'>";
			//echo " <input type='hidden' name='code' value=".$_GET['code'].">";
		echo"       <table><tr>  ";
		echo "  Fichier : <input type='file' name='docfil'>";
				 echo "</tr><tr>";	
		//echo "<td> <input type='submit' name='bouton_adddoc' value='Envoyer le fichier' onClick=\"return confirmSubmit()\">";
		 //echo " <input type='submit' name='bouton_annuldoc' value='Annuler'></td>";
		//echo "</form>";
		echo "</table>";
	 }
	 elseif ($unchamps== 'doc_libelle' )	
 echo affichechamp($commentaire,$unchamps,'descriptif',40,'','','','','',$required );	
	 // on n'affiche pas le auto inc ni date_modif ni modifpar
	 elseif ($unchamps != $autoincrement and $unchamps != 'date_modif' and $unchamps != 'modifpar' ){

	 echo affichechamp($commentaire,$unchamps,'',40,'','','','','',$required );
	 }
    echo "</tr><tr>";	 
	 }

   
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;

  echo"</center>";
        }
		
		
// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si autorisé
if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
	
// d'abord on upload le fichier temporaire

$fichier = basename($_FILES['docfil']['name']);
$extfichier=pathinfo($fichier, PATHINFO_EXTENSION);
$fichier =nettoie(date('dmyhis') ."-".$fichier).".".$extfichier;

$extensions = array('.jpg','.docx','.doc','.pdf');

//Début des vérifications de sécurité...
// si on a pas de fichier temporaire c'est qu'il n' a pas été accepté par le formulaire (taile  MAX )
if($_FILES['docfil']['tmp_name']!='')
		{
	$extension = strrchr($_FILES['docfil']['name'], '.'); 
		if(!in_array(strtolower($extension), $extensions)) //Si l'extension n'est pas dans le tableau
		{
			 $erreur = 'Vous devez uploader un fichier du type autorisé : .jpg,.docx,.doc,.pdf';
		}

		}
		else{
			$erreur = 'Fichier trop volumineux';
		}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
	// $fichier =$_GET['code'].".jpg";
	 //echo "<br>". $_FILES['docfil']['tmp_name'];
    if(move_uploaded_file($_FILES['docfil']['tmp_name'], $chemin_local_apprentissage . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';	  
			}//fin du if moveupload
		     else //Sinon (la fonction renvoie FALSE).
		     {
		          echo "Echec de l'upload ! ";
		     }
	
 
	
// on positionne le nom  du fichier	
	
$_POST['doc_lienDoc']=$fichier;
	
	
// test valeurs obligatoires
	 $yaunvide=0;
	foreach($champsobligatoires as $champsobligatoire){
	 if (($_POST[$champsobligatoire]==''  )){
	 $yaunvide=1;
	}
	}
 if (!$yaunvide ){
 $_POST['modifpar']=$loginConnecte;
//valeur par defaut et pb des dates mysql

foreach($champsSingle as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }

         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(),";}
 elseif($ci2==$autoincrement)
 {
 // on ne fait rien
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
  //echo $query;
      $result = mysql_query($query,$connexion);
       if ($result){
    $message = "Fiche <b>"." - ";
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
		else
		{
		     echo affichealerte($erreur);
		}
	
    }
    else{//debut du else $loginConnecte==
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $loginConnecte ==
}		
		
		
		

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


  if($table2=='')
  {
      $query = "SELECT * FROM $table where 1 ";
	}
	else
	{
	$query = "SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere = $table2.$cleprimaire2 where 1 ";
	}	

   $query.=$where."  ".$orderby;
   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo " documents "."</H2>";}

if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1&offre=".$_GET['offre'].'&'.$filtrerech."> Ajouter un document </a><br>";
}
echo"<br><br><a href=".$pageaccueil.'?'.$filtrerech.">revenir à l'accueil</a>";
if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";


echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
		foreach ($liste_champs_tableau as  $colonne)
		{
		//if (!in_array($colonne,$liste_champs_lies))
		//if (1)
		//	{
				 		 if ($comment[$colonne]=='')
			 {
			echo afficheentete($colonne,$colonne,$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
			 }
			 else
			 {
			echo afficheentete($comment[$colonne],$colonne,$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
			 }	
		//	}
		//else
		//	{
		//	echo "<th> $colonne</th>";
		//	}
		}

//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
			 if ($comment[$champs[$i]]=='')
			 {
			$csv_output .= nettoiecsvplus($champs[$i]);
			 }
			 else
			 {	 
			$csv_output .= nettoiecsvplus($comment[$champs[$i]]);
			 }
}
$csv_output .= "\n";
while($u=mysql_fetch_object($result)) {

 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   if (in_array ($ci2 ,$liste_champs_dates))
	 { 
	 //on transforme les dates sql en dd/mm/yy
		 $$ci2=mysql_DateTime($u->$ci2);
	 $csv_output .=  nettoiecsvplus(mysql_DateTime($u->$ci2));
	 }else{
		  $$ci2=$u->$ci2;
	   $csv_output .=  nettoiecsvplus($u->$ci2);
	  }   
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format
		//on récupère les champs liés
		// on ecrit chaque ligne
		      echo"   </tr><td>" ;	
		foreach($liste_champs_tableau as  $colonne)
		{
   		//if (!in_array($colonne,$liste_champs_lies))
		if ($colonne=='doc_libelle')
		{
			echo "<a href='".$chemin_apprentissage.$doc_lienDoc ."'>".$doc_libelle."</a>";
			  echo"   </td><td>" ;
		}
			else
		{
			  echo $$colonne ;
			  echo"   </td><td>" ;
		}	 
		//else
		//	{
		//	echo $tableau_champs_lies[$colonne][$$cleetrangere];
		//	echo"   </td><td>" ;
		//	}
		
       }
	if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
     echo " <A href=".$URL."?del=".$$cleprimaire."&offre=".$_GET['offre']." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";
     echo "<A href=". $URL."?mod=".$$cleprimaire."&offre=".$_GET['offre']." >Mod</A>";	 
	 }
	 

	        echo"</td> </tr>";
	   }
	if(in_array($loginConnecte,$login_autorises_export) or empty($login_autorises_export))
		{
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
		echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
		echo "</form>";
		}

	   
echo"</table> ";
  }
  }
mysql_close($connexion);
?>
</body>
</html>
