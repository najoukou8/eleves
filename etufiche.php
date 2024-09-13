<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>detail eleve</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?php
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$affichetout=1;
if (!isset($_GET['adddoc'])) $_GET['adddoc']='';
if (!isset($_GET['unlink'])) $_GET['unlink']='';
if (!isset($_POST['ajoutdoc'])) $_POST['ajoutdoc']='';
if (!isset($_POST['bouton_adddoc'])) $_POST['bouton_adddoc']='';
if (!isset($_POST['adddoc'])) $_POST['adddoc']='';
if (!isset($_GET['tousgpe'])) $_GET['tousgpe']='';
$URL =$_SERVER['PHP_SELF'];
$isetudiant=0;
$filtre='';


if ($login!='administrateur' and $login!='re'){
//on verifie si c un etudiant
$reponse= ask_ldap($login,'memberof');
foreach( $reponse as $gpe){
if (stristr($gpe,'etudiant')){
$isetudiant=1;
}
}
}



$tabletemp="etudiants";
$champs=champsfromtable($tabletemp);

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


$tabletemp="etudiants_scol";
$champs4=champsfromtable($tabletemp);

foreach($champs4 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

//pour les tests
 $login='adouej';
//il faut recuperer le num etudiant à partir de son login
$query= "SELECT annuaire.`code-etu`  FROM annuaire where Uid='".$login."'";
$result=mysql_query($query,$connexion);


 //si le login est bien celui d'un etudiant
 if (mysql_num_rows($result)!=0){
$e=mysql_fetch_object($result);
//echo odbc_result($result,'code-etu')  ;
$_GET['code']= $e->$myannuairecode_etu ;
$where=urldecode($_GET['code']);
$where="'".$where.  "'";
$where=" WHERE `Code etu` = ".$where;
$sqlquery="SELECT annuaire.*,etudiants.*,etudiants_scol.*,etudiants_accueil.acc_code_ade FROM etudiants
                  left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
				  left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.`acc_code_etu`
                  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.`code`".$where.";";
$resultat=mysql_query($sqlquery,$connexion);
$e=mysql_fetch_object($resultat);
//echo $_SERVER['AUTH_USER'];
//$auth2=explode("\\",$_SERVER['AUTH_USER']);
//echo "domaine : <b>". $domaine. "</b><br>" ;
//echo  "login :  <b>". $login  . "</b><br>" ;

// si il existe bien dans la base eleves 
 if (mysql_num_rows($resultat)!=0){
 
 $photo=$chemin_images.$e->$myetudiantscode_etu.".jpg";
$photo_perso=$chemin_images_perso.$e->$myetudiantscode_etu.".jpg";
$photolocal =$chemin_local_images.$e->$myetudiantscode_etu.".jpg";
$photolocal_perso =$chemin_local_images_perso.$e->$myetudiantscode_etu.".jpg";
  //---------------------------------------c'est kon a cliqué sur le lien ajouter photo
 		 if($_GET['adddoc']!=''or $_POST['adddoc']!='')  {
   $affichetout=0;

 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
	echo "	<form method='POST' action=$URL enctype='multipart/form-data'>";
	  echo"<input type='hidden' name='ajoutdoc' value=1>";
	    echo afficheonly("","Joindre une photo <br> ATTENTION taille maxi 60 Ko ",'b' ,'h3','',0);
		echo afficheonly("","  dimensions conseillées 200 X 300 pixels",'b' ,'h4');
	    //pour apres la sortie du formulaire retrouver la selection en cours
     //On limite le fichier à 100Ko -->
    echo " <input type='hidden' name='MAX_FILE_SIZE' value='60000'>";
	  echo"       <table><tr>  ";
   echo "  Fichier : <input type='file' name='docfil'>";
			 echo "</tr><tr>";	
    echo "<td> <input type='submit' name='bouton_adddoc' value='Envoyer le fichier' onClick=\"return confirmSubmit()\">";
	 echo " <input type='submit' name='bouton_annuldoc' value='Annuler'></td>";
echo "</form>";

        }
 //---------------------------------------c'est kon a cliqué sur le lien supprimer photo
 		 if($_GET['unlink']!='')  {

//on regarde d'abord ds le rep upload pour la photo téléchargée
  if (file_exists($photolocal_perso))
   unlink($photolocal_perso);

        }
 // ----------------------------------Ajout du document
if($_POST['ajoutdoc']!='' and $_POST['bouton_adddoc']!='') {
//test si admin 
 if(in_array($login,$scol_user_liste)  or $isetudiant){
 
 $_POST['modifpar']=$login;
   $_POST['contributeur']= $login;
   
 //pb des dates mysql
 //pour les dates


$fichier = basename($_FILES['docfil']['name']);
$fichier = date('dmyhis')."-".$fichier;
$taille_maxi = 60000;
$taille = filesize($_FILES['docfil']['tmp_name']);
$extensions = array('.jpg');
$extension = strrchr($_FILES['docfil']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array(strtolower($extension), $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type jpg';
}
if($taille>$taille_maxi)
{
     $erreur = "L'image est trop grosse...";
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
	 $fichier = $e->$myetudiantscode_etu.".jpg";
	 //echo "<br>". $_FILES['docfil']['tmp_name'];
    if(move_uploaded_file($_FILES['docfil']['tmp_name'], $dossierphotos . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';	  
			}//fin du if moveupload
		     else //Sinon (la fonction renvoie FALSE).
		     {
		          echo "Echec de l\'upload ! peut être l'image est trop grosse";
		     }
		}
		else
		{
		     echo $erreur;
		}	
    }
    else{//debut du else $login==
   echo "<center><b>seul les personnes autorisées (élève concerné ou scolarité) peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==
}

 
 
 if ($affichetout)
 {
 
 
echo"<center><table border=0 width=60%>";
echo"<tr align=center><td><h2> ".$e->$myetudiantsnom." ".strtolower($e->$myetudiantsprénom_1)." ".strtolower($e->$myetudiantsprénom_2)." ".strtolower($e->$myetudiantsprénom_3)."</h2>";
if ($e->$myetudiantsnom_marital != ""){
echo"<br>nom d'usage ".$e->$myetudiantsnom_marital;
}

echo  "<center><a href=https://stages.grenoble-inp.fr/etud-gi/etuoffres.php>Consulter les offres de stage</a></center>";
//echo  "<center><a href=etustages.php>consulter un stage débutant avant le 14/03/2011</a></center>";
echo  "<center><a href=https://stages.grenoble-inp.fr/etud-gi/etustages.php>Consulter /créer un stage</a></center>";
echo  "<center><a href=accueil_international.php>Départs à l'étranger</a></center>";
// si il n'y a pas de photo du tout l'etudiant peut en telecharger une


 //if ( !(file_exists($photolocal))  and !(file_exists($photolocal_perso)) ){
  if ( !(file_exists($photolocal_perso)) ){
echo "<A href=".$URL."?adddoc=1 >téléchargement d'une photo </a><br>";
}
 // s'il y en a une perso il peut l'enlever
 if( (file_exists($photolocal_perso))){
 echo "<A href=".$URL."?unlink=1 >suppression de la photo téléchargée</a><br>";
 }
//Pour connaitr ele gpe et afficher le lien voeux eventuel


    $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible1."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux1)<0  and diffdatejours($datedebutvoeux1)>=0 and $datedebutvoeux1!=''  ){
 echo  $lienvoeux1;
 }
 }
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible2."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux2)<0  and diffdatejours($datedebutvoeux2)>=0 and $datedebutvoeux2!=''  ){
 echo  $lienvoeux2;
 }
 }
 // pour les voeux depart a l'etranger 2A
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible3."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux3)<0  and diffdatejours($datedebutvoeux3)>=0 and $datedebutvoeux3!=''  ){
 echo  $lienvoeux3;
 }
 }
  // pour les voeux depart a l'etranger 1A
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible4."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux4)<0  and diffdatejours($datedebutvoeux4)>=0 and $datedebutvoeux4!=''  ){
 echo  $lienvoeux4;
 }
 }
  // pour les voeux choix de filiere
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible5."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux5)<0  and diffdatejours($datedebutvoeux5)>=0 and $datedebutvoeux5!=''  ){
 echo  $lienvoeux5;
 }
 }
 
 // pour les voeux choix Ues S5
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible6."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux6)<0  and diffdatejours($datedebutvoeux6)>=0 and $datedebutvoeux6!=''  ){
 echo  $lienvoeux6;
 }
 }
 
  // pour les voeux anglais
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible7."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux7)<0  and diffdatejours($datedebutvoeux7)>=0 and $datedebutvoeux7!=''  ){
 echo  $lienvoeux7;
 }
 }
 
    // pour les validation de programme S5
  $query2="select groupes.libelle as libellegpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
 $query2.= " and groupes.libelle like '".$gpecible8."%' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 if (  diffdatejours($datelimitevoeux8)<0  and diffdatejours($datedebutvoeux8)>=0 and $datedebutvoeux8!=''  ){
 echo  $lienvoeux8;
 }
 }
//echo  "<center><a href=etuconcours.php>infos concours</a></center>";

echo  "<br><center>si les informations ci dessous sont incorrectes signalez le à la <a href=mailto:".$scolmail."?subject=correction-base-eleves-".$e->Nom." >scolarité de GI</a></center>";
echo"</td><td>";

//on regarde d'abord ds le rep upload pour la photo téléchargée
  if (file_exists($photolocal_perso))
{
      // print "<img src= ".$photo2." width=160  height=120><br>";
      echo "<img src=".$photo_perso." width=160  >";
}
// sinon on regarde ds le rep officiel
elseif (file_exists($photolocal))
{
      // print "<img src= ".$photo2." width=160  height=120><br>";
      echo "<img src=".$photo." width=160 >";
}
else{
   print "<i>photo non disponible </i><br><img src=".$chemin_images."default.jpg ><br>";
}
echo"</tr></td></table></center>  ";



echo  "<br><center>";





echo"<table>";
echo "<td>";
echo"<table>";
//echo" Renseignements supplémentaires Scolarité GI";
 foreach($champs4 as $ci2){
if ($e->$ci2!="" and $ci2!="code" ){
 $afficheligne=1;
switch ($ci2){
	case "annee":
		$ligne="Groupe principal"."</td><td>".$e->$ci2."</td></tr>";
	break;	
	case "date_diplome":
		$ligne="date diplôme"."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
	break ;
	case "date_modif":
		$ligne="fiche modifiée  "."</td><td> le ".mysql_DateTime($e->$ci2)." par ".$e->modifpar."</td></tr>";
	break ;
	case "modifpar":
		$afficheligne=0;
	 break;
	 case "date_remise_badge":
		$ligne="date remise badge" ."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
		break;
		case "date_retour_badge":
		$ligne="date retour badge" ."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
		break;
		case "date_demande_badge":
		$ligne="date demande badge" ."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
		break;
	default :
		$ligne= $ci2."</td><td >".$e->$ci2."</td></tr>";
 } //fin du switch
 if   ($afficheligne){
  echo "<tr><td bgcolor=aqua >  ";
 echo $ligne;}
 } //fin du if odbc_result($resultat,$ci2)!=""
 } //fin du foreach

 //echo"Informations issues d'APOGEE";
foreach($champs as $ci){
 //echo $ci."___".$e->$ci."<br>";
 $correspondance="";
 if ($e->$ci!=""){
 $afficheligne=1;
switch ($ci){
case "Code etu":
	$ligne="Numéro étudiant"."</td><td>".$e->$ci."</i></td></tr>";
	break;
	
case "Nationalité":
	$sqlquery="select *  from departements where dep_code = ".$e->Nationalité."";;
	$resultat2=mysql_query($sqlquery,$connexion );
	$f=mysql_fetch_object($resultat2);
	$correspondance= " : ".$f->dep_libelle;
	$ligne=$ci."</td><td>".$e->$ci."<i>$correspondance</i></td></tr>";
	break;
case "Pays/dept naiss":
	$sqlquery="select *  from departements where dep_code = ".$e->$myetudiantspays_dept_naiss."";;
	$resultat2=mysql_query($sqlquery,$connexion );
	$f=mysql_fetch_object($resultat2);
	$correspondance= " : ".$f->dep_libelle;
	$ligne="Date et lieu de naissance"."</td><td>".$e->$myetudiantsdate_naiss." à ".$e->$myetudiantsville_naiss." <i>$correspondance</i></td></tr>";
	break;
case "Code CSP parent":
	$ligne=$ci."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_csp_parent."</i></td></tr>";
	break;
case "Code CSP étudiant":
	$ligne=$ci."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_csp_étudiant."</i></td></tr>";
	break;
case "Type étab ant":

	//en fin de compte on ne l'affiche plus
	$afficheligne=0;
	break;
//case "Dpt/pays dac":
//	$sqlquery="select * from departements where dep_code = '".odbc_result($resultat, 'Dpt/pays dac')."'";
//	$resultat2=odbc_exec($sqlconnect, $sqlquery);
//	$correspondance= " : ".odbc_result($resultat2, 'dep_libelle');
//	$ligne=$ci."</td><td>".$e->$ci."<i>$correspondance</i></td></tr>";
//	break;
case "Code sit fam":
	$sqlquery="select * from nomenclature_situation_fam where code = ".$e->$myetudiantscode_sit_fam;
		$resultat2=mysql_query($sqlquery,$connexion );
		$f=mysql_fetch_object($resultat2);
	$correspondance= " : ".$f->libelle;
	$ligne="situation familiale</td><td>"."<i>$correspondance</i></td></tr>";
	break;
case "Code profil":
	$ligne="Profil"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_profil."</i></td></tr>";
	break;
case "Code régime":
	$ligne="Régime"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_régime."</i></td></tr>";
	break;
case "Code bac":
	$sqlquery="select * from departements where dep_code = ".$e->$myetudiantscode_dpt_bac."";
	$resultat2=mysql_query($sqlquery,$connexion );
	$f=mysql_fetch_object($resultat2);
	$correspondance= " : ".$f->dep_libelle;
	$ligne="Bac"."</td><td>Bac ".$e->$myetudiantslib_bac."-mention ".$e->$myetudiantslib_mention."-".$e->$myetudiantsannée_obt_bac."<i>$correspondance</i></td></tr>";
	break;
case "Code dip":
	$ligne="Diplôme"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_dip."</i></td></tr>";
	break;
case "Code étape":
	switch ($e->$myetudiantscode_vet){
	case "23":
		$ligne="Etape"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_étape."-<i>"."congé d'études"."</i></td></tr>";
		break;
	case "42" :
		$ligne="Etape"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_étape."-<i>"."Double diplôme accueil"."</i></td></tr>";
		break;
	default:
		$ligne="Etape"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_étape."-<i>"."</i></td></tr>";
	}
	break;
case "Pg échange":
	switch ($e->$myetudiantspg_échange){
	case "4":
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."Accord Bilatéral"."</i></td></tr>";
		break;
	case "1":
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."Erasmus"."</i></td></tr>";
		break;
	case "7":
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."Mira"."</i></td></tr>";
		break;
	case "2":
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."TEMPUS"."</i></td></tr>";
		break;
	default:
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."Accord multilatéral"."</i></td></tr>";
		
	}
	break;
case "Sens échange":
	switch ($e->$myetudiantssens_échange){
	case "E":
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."ENVOI"."</i></td></tr>";
		break;
	case "A":
		$ligne=$ci."</td><td>".$e->$ci."-<i>"."ACCUEIL"."</i></td></tr>";
		break;
	}
	break;
case "Aide financière":
	$ligne=$ci."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_aide_finan."</i></td></tr>";
	break;
case "Code bourse":
	switch ($e->$myetudiantscode_bourse){
	case "2":
		$ligne="Bourse"."</td><td>".$e->$ci."-<i>"."Bourse Enseignement supérieur"."</i></td></tr>";
		break;
	case "12" :
		$ligne="Bourse"."</td><td>".$e->$ci."-<i>"."Bourse collectivités territoriales"."</i></td></tr>";
		break;
	case "1" :
		$ligne="Bourse"."</td><td>".$e->$ci."-<i>"."Bourse gouvernement français"."</i></td></tr>";
		break;
	}
	break;
case "Code statut":
	// $ligne=$ci."</td><td>".$e->$ci."-<i>".odbc_result($resultat,'Lib statut')."</i></td></tr>";
	$afficheligne=0;
	break;
case "Ada code BDI":
	$ligne="Ada Ville" ."</td><td>".$e->$ci."-<i>".$e->$myetudiantsada_lib_commune."</i></td></tr>";
	break;
case "Ada lib commune":
	$afficheligne=0;
	break;
case "Adf code BDI":
	$ligne="Adf Ville" ."</td><td>".$e->$ci."-<i>".$e->$myetudiantsadf_lib_commune."</i></td></tr>";
	break;
case "Etat civ":
	// if ($e->$ci == "M."){
		// $ligne="Sexe" ."</td><td> M </td></tr>";
	// } else
	// {$ligne="Sexe" ."</td><td> F </td></tr>"; }
	$afficheligne=0;	
	break;
case "Dpt étab ant":
	$afficheligne=0;
	break;
case "Code VET":
	$afficheligne=0;
	break;

case "Lib bourse":
	$afficheligne=0;
	break;
case "Code VDI":
	$afficheligne=0;
	break;
case "Code dpt bac":
	$afficheligne=0;
	break;
case "Lib étab ant":
	$afficheligne=0;
	break;
case "Ville naiss":
	$afficheligne=0;
	break;
case "Date naiss":
	$afficheligne=0;
	break;
case "Nom":
	$afficheligne=0;
	break;
case "Prénom 1":
	$afficheligne=0;
	break;
case "Prénom 2":
	$afficheligne=0;
	break;
case "Prénom 3":
	$afficheligne=0;
	break;
case "Adf lib commune":
	$afficheligne=0;
	break;
case "Année obt bac":
	$afficheligne=0;
	break;
case "Lib statut":
	$afficheligne=0;
	break;
case "Lib dip":
	$afficheligne=0;
	break;
case "Code mention":
	$afficheligne=0;
	break;
case "Lib aide finan":
	$afficheligne=0;
	break;
case "Lib sit fam":
	$afficheligne=0;
	break;
case "Lib bac":
	$afficheligne=0;
	break;
case "Lib étape":
	$afficheligne=0;
	break;
case "Lib mention":
	$afficheligne=0;
	break;
case "Lib régime":
	$afficheligne=0;
	break;
case "Date IAE":
	$afficheligne=0;
	break;
case "Année Univ":
	//$afficheligne=0;
	// on la remet a cause de la non reinscription des 2a et 3A en debut d'annee : pour distinguer les vrais inscrits des reports automatiques
		$ligne="Date inscription" ."</td><td>".$e->$ci."-".$e->$myetudiantsdate_iae."</i></td></tr>";
	break;
case "Année etab ant":
	$afficheligne=0;
	break;
case "Centre gestion":
	$afficheligne=0;
	break;
case "Composante":
	$afficheligne=0;
	break;
case "Composante":
	$afficheligne=0;
	break;
case "Lib CSP parent":
	$afficheligne=0;
	break;
case "Lib CSP étudiant":
	$afficheligne=0;
	break;
case "Lib profil":
	$afficheligne=0;
	break;
case "Nb inscr cycle":
	$afficheligne=0;
	break;
case "Nb inscr dip":
	$afficheligne=0;
	break;
case "Nb inscr etp":
	$afficheligne=0;
	break;
 case "Lib dac":
 $afficheligne=0;
 break;
  case "Code étab dac":
 $afficheligne=0;
 break;
  case "Lib étab dac":
 $afficheligne=0;
 break;
  case "Type étab dac":
 $afficheligne=0;
 break;
  case "Dpt/pays dac":
 $afficheligne=0;
 break;
 case "Dip autre cursus":
 $afficheligne=0;
 break;
   case "Année suivi dac":
 $afficheligne=0;
 break;
   case "Code etb bac":
 $afficheligne=0;
 break;
   case "lib étab":
 $afficheligne=0;
 break;
   case "lib etb bac":
 $afficheligne=0;
 break;
  case "Commentaire":
 $afficheligne=0;
 break;
	default :
	$correspondance= "";
	$ligne=$ci."</td><td>".$e->$ci."<i>$correspondance</i></td></tr>";
} // fin du switch
 if   ($afficheligne){
  echo "<tr><td bgcolor=aqua >  ";
 echo $ligne;}
 }  //fin du if$e->$ci!=""
 } //fin du foreach

 //affichage login
 echo "<tr><td bgcolor=aqua >  ";
 echo "login"."</td><td >".$e->$myannuaireuid."</td></tr>";
echo "</table>";
echo "</td><td valign=top>";
echo "<table>";
   //affichage des groupes
 $query2="select groupes.libelle as libellegpe,code_ade,code_ade6,recopie_gpe_officiel, groupes.login_proprietaire as propgpe ,type_gpe_auto ,archive,gpe_evenement from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."' and archive !='oui'";
    if ($login!='administrateur'){
$query2.=" and groupes.visible = 'oui'";}
 //echo $query2;
 	echo"<tr><td bgcolor=aqua>" ;
    $result2 = mysql_query($query2,$connexion ); 
	echo "Membre des groupes : ";
	     echo"        </td> <td>";
	echo "<table border=0>";
	//echo "<th>début</th><th>fin</th><th>motif</th><th>justifiée</th>";
	$liste_ress_url='';
	$liste_ress_url6='';	
			if (mysql_num_rows($result2)!=0)
			{
					echo"   <tr><td>" ;
					if ($_GET['tousgpe']!=1)
					{
				echo  "<a href=".$URL."?code=".$_GET['code']."".$filtre."&tousgpe=1>Afficher mes groupes de cours</a>";		
				}
				else
				{
				echo  "<a href=".$URL."?code=".$_GET['code']."".$filtre."&tousgpe=0>Masquer mes groupes de cours</a>";	
				}
				echo"        </td> </tr>";
			}
	// on  parcourt la liste des gpes
	while($u=mysql_fetch_object($result2)) {
	//on traite ceux qui vont constituer la ressource= d'ADE
//if ($u->code_ade!='' and $u->feuille_ade =='oui'){
// plus necessaire feuille ade  par contre il faut garder uniquement les  typegpeauto edt  non archives?

		if ($u->code_ade!='' and ($u->type_gpe_auto == 'edt' or $u->gpe_evenement=='oui'))
			{
			$liste_ress_url.="$u->code_ade,";
			}
		if ($u->code_ade6!='' and ($u->type_gpe_auto == 'edt' or $u->gpe_evenement=='oui'))
			{
			$liste_ress_url6.="$u->code_ade6,";
			}	
			// condition pour l'affichage des groupes - la derniere condition c'est pour ne pas avoir les groupes offciels de promo en double
		if ( ($u->type_gpe_auto != 'edt' or $_GET['tousgpe'] ) and ( $u->recopie_gpe_officiel ==''))
			{
				echo"   <tr><td>" ;  
				echo  $u->libellegpe;		
				echo"        </td> </tr>";
			}

}		
	echo"</table>";
	 echo" </tr>  <tr><td colspan=2>" ;  
	//nombres de semaine depuis le debut du projet  ADE
$numsemaine=diffdate($date_debut_projetADE);
	// depuis 2018 attention on peut changer d'année ADE en année n-1
	if($numsemaine<=0)$numsemaine=0;
// pour les etudiants etrangers en accueil il faut vérifier si il existe un code ADE ds leur fiche
// inutile 2011
//if ($e->acc_code_ade !='')
//{
//$liste_ress_url = $e->acc_code_ade;
//}


if ($liste_ress_url6 != ''){
	  echo "<a href=".$lien_ade_pers."&weeks=".$numsemaine."&days=0,1,2,3,4,&name=".$liste_ress_url6." target=_blank > <b>Emploi du temps sur ADE</b></a>";
	  	  }	
 
 echo" </tr>  <tr>" ; 

//affichage des absences
 $query2="select * from absences where code_etud='".urldecode($_GET['code'])."'";
 	echo"<td>" ;

	

    $result2 = mysql_query($query2,$connexion ); 
	if (mysql_num_rows( $result2) >0){
	echo afficheonly("","Absences",'b' ,'h3');	
	echo "<table border=1>";
	echo "<th>début</th><th>fin</th><th>motif</th><th>justifiée</th><th>validée</th>";
	while($u=mysql_fetch_object($result2)) {

echo"   <tr><td>" ;  
     	echo  mysql_DateTime($u->date_debut);
		echo"   </td><td>" ;
		echo  mysql_DateTime($u->date_fin)  ;
		echo"   </td><td>" ;
		echo $u->motif ;
		echo"   </td><td>" ;
		echo $u->valide ;
		echo"   </td><td>" ;
	     echo $u->absence_justif ;
	    echo"   </td><td>" ;
		echo "<A href=absencesetu.php?modfiche=oui&mod=".$u->id_absence.">détails</A>";
		 echo"        </td> </tr>";
	 }
	echo"</table>";
	}
	else{
	echo "</tr><tr><td colspan=2>pas d'absence enregistrée actuellement pour cet élève<br>";}
	echo"   </td>" ; 
	echo "</tr><tr>";
  echo"</table>";
 echo"</table>";
 echo"</table>";
 echo  "</center>";
 //fin du if  il existe bine ds la base eleves
 } // fin du if affiche tout
 }else
 {
echo"<center> désolé, vous êtes bien dans l'annuaire AGALAN mais pas dans la base élèves
 <br>veuillez contacter le <a href=mailto:sigi@grenoble-inp.fr >SIGI</a>   </center>";
 }
 
 
 
 
 //fin du if login est celui d'un etudiant
 }else
 {
echo"<center> désolé, mais votre login : <b>".$login."</b> ne correspond à celui d'un étudiant de $ecole inscrit dans l'annuaire AGALAN 
 <br>veuillez contacter le <a href=mailto:sigi@grenoble-inp.fr >SIGI</a>   </center>";
 }
mysql_close($connexion);
?>
</body>

</html>