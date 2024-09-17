<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>detail eleve</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">

<style>

header {
	background-color: 
}
</style>

<?php
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;

?>
		<style>
		table td , table th {
			padding:1px;
			vertical-align:top !important ; 
		}
		.abs {
			width:90% !important ; 
		}
		

			
		</style>
<?php 


// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
require('header.php');
$affichetout=1;
if (!isset($_GET['adddoc'])) $_GET['adddoc']='';
if (!isset($_GET['unlink'])) $_GET['unlink']='';
if (!isset($_POST['ajoutdoc'])) $_POST['ajoutdoc']='';
if (!isset($_POST['bouton_adddoc'])) $_POST['bouton_adddoc']='';
if (!isset($_POST['adddoc'])) $_POST['adddoc']='';
$URL =$_SERVER['PHP_SELF'];


if (!isset($_GET['annee'])) $_GET['annee']='';
if (!isset($_GET['orderby'])) $_GET['orderby']='';
if (!isset($_GET['nom_recherche'])) $_GET['nom_recherche']='';
if (!isset($_GET['recherche_avance'])) $_GET['recherche_avance']='';
if (!isset($_GET['options'])) $_GET['options']='';
if (!isset($_GET['bouton_ok'])) $_GET['bouton_ok']='';
if (!isset($_GET['code_groupe'])) $_GET['code_groupe']='';
if (!isset($_GET['code_groupe_peda'])) $_GET['code_groupe_peda']='';
if (!isset($_GET['code_etu_recherche'])) $_GET['code_etu_recherche']='';
if (!isset($_GET['mon_champ'])) $_GET['mon_champ']='';
if (!isset($_GET['inverse'])) $_GET['inverse']='';
if (!isset($_GET['tousgpe'])) $_GET['tousgpe']='';

$_GET['code_etu_recherche']=stripslashes((($_GET['code_etu_recherche'])));
$_GET['nom_recherche']=stripslashes($_GET['nom_recherche']);


$tabletemp="etudiants";
$champs=champsfromtable($tabletemp);
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
$tabletemp="etudiants_scol";
$champs4=champsfromtable("etudiants_scol");
foreach($champs4 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
// si on vient du formulaire d'ajout de la photo
if (isset($_POST['code'])){
$_GET['code']=$_POST['code'];
}
$where=urldecode($_GET['code']);
$where="'".$where.  "'";
$where=" WHERE `Code etu` = ".$where;

$sqlquery="SELECT annuaire.*,etudiants.*,etudiants_scol.*,etudiants_accueil.acc_code_ade FROM etudiants
                  left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
				  left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.`acc_code_etu`
                  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.`code`".$where.";";
$resultat=mysql_query($sqlquery,$connexion ); 
$e=mysql_fetch_object($resultat);
// on verifie si c'est un etudiant qui a été anonymise
if( substr($e->Commentaire,0,9)=='nettoyage')
{
	// dans ce cas on n'affiche rien
	$affichetout=0;
}



// pour la double inscription 
$sqlquerydouble="SELECT inscription_sup.* FROM inscription_sup
".$where.";";
$resultatdouble=mysql_query($sqlquerydouble,$connexion ); 
$ed=mysql_fetch_object($resultatdouble);
$double_inscription=0;
if (mysql_num_rows($resultatdouble)!=0)$double_inscription=1;
echo "<div id='bannier' style='margin-top: -7px; '><center>";
echo"<table border=0 width=56% >";
$photo=$chemin_images.$e->$myetudiantscode_etu.".jpg";
$photo_perso=$chemin_images_perso.$e->$myetudiantscode_etu.".jpg";
$photolocal =$chemin_local_images.$e->$myetudiantscode_etu.".jpg";
$photolocal_perso =$chemin_local_images_perso.$e->$myetudiantscode_etu.".jpg";
  //---------------------------------------c'est kon a cliqué sur le lien ajouter photo
 		 if($_GET['adddoc']!='')  {
   $affichetout=0;

 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
	echo "	<form method='POST' action=$URL enctype='multipart/form-data'>";
	  echo"<input type='hidden' name='ajoutdoc' value=1>";
	  //on passe tous les arg reçus en get  en hidden
	 foreach($_GET as $x=>$ci2)	
	  {

          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  
	  }
	    echo afficheonly("","Joindre une photo <br> ATTENTION format jpg et <br>taille maxi 60 Ko ",'b' ,'h3','',0);
		echo afficheonly("","  dimensions conseillées 200 X 300 pixels",'b' ,'h4');
	    //pour apres la sortie du formulaire retrouver la selection en cours
     //On limite le fichier à 100Ko 
    echo " <input type='hidden' name='MAX_FILE_SIZE' value='60000'>";
	    //echo " <input type='hidden' name='code' value=".$_GET['code'].">";
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
 if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) )  ){

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
	 $fichier =$_GET['code'].".jpg";
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
//______________________________________fin du if ajoutdoc


 
 if ($affichetout)
 {
 
echo"<tr align=center><td><h1 style='background-color:#2b79b5 ; color:white ; padding :4px ; font-size:36px ;text-transform: uppercase ; font-family : Roboto Condensed'> <span style='color:#f7ce00;font-family : Roboto Condensed'>".$e->$myetudiantsnom."</span> ".strtolower($e->$myetudiantsprénom_1)." ".strtolower($e->$myetudiantsprénom_2)." ".strtolower($e->$myetudiantsprénom_3)."</h1>";
if ($e->$myetudiantsnom_marital != ""){
echo"<br>nom d'usage ".$e->$myetudiantsnom_marital;
}
	if($_POST['ajoutdoc']!='')
		// SI  on revient du formulaire de telechargement c'est les variables post qu'il faut mettre ds le filtre :
		{
		$filtre ="&code_groupe_peda=".$_POST['code_groupe_peda']."&nom_recherche=".urlencode($_POST['nom_recherche'])."&options=".urlencode($_POST['options']);
		$filtre.="&recherche_avance=".$_POST['recherche_avance']."&mon_champ=".urlencode($_POST['mon_champ'])."&code_etu_recherche=".urlencode($_POST['code_etu_recherche']);
			$filtre.="&fromfic=1"; 
		   $filtrescol= $filtre.   "&promo=".$_POST['annee'];
		   $filtre.=   "&annee=".$_POST['annee'];
		}
	else
		{

		//on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
		   $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
		$filtre.="&recherche_avance=".$_GET['recherche_avance']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);
		   $filtre.="&fromfic=1"; 
		   $filtrescol= $filtre.   "&promo=".$_GET['annee'];
		   $filtre.=   "&annee=".$_GET['annee'];
		   //a cause du champs annee ds la table scol
			}
   //avec aussi la simulation du bouton OK
 $filtreok=$filtre."&bouton_ok=OK";  


if(in_array ($login ,$re_user_liste )){
//echo  "<center><a href=stages.php?code_etu=".$_GET['code'].$filtre.">Archives stages</a></center>";
echo  "<center><a href=".$url_estages_gestionnaire.$_GET['code'].">Ses stages (e-stages)</a></center>";
}
else
{
echo  "<center><a href=".$url_estages_etud_prof.$_GET['code'].">Ses stages (e-stages)</a></center>";
}

//echo  "<center><a href=https://stages.grenoble-inp.fr/gi/stages.php?code_etu=".$_GET['code'].">Stages</a></center>";
echo  "<center><a href=departs.php?code_etu=".$_GET['code'].$filtre.">Ses départs à l'étranger</a></center>";
//echo  "<center><a href=concours.php?code_etu=".$_GET['code'].$filtre.">infos concours</a></center>";
echo  "<center><a href=scol.php?code_etu=".$_GET['code'].$filtrescol.">Ses infos scolarité- Badges</a></center>";


 if(in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ){
echo "<A href=".$URL."?adddoc=1&code=".$_GET['code'].$filtre." >téléchargement d'une photo </a><br>";
}
 if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ) and (file_exists($photolocal_perso))){
 echo "<A href=".$URL."?unlink=1&code=".$_GET['code'].$filtre." onclick=\"return confirm('Etes vous sûr de vouloir supprimer la photo téléchargée ?')\" >suppression de la photo téléchargée</a><br>";
 }
  if(in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ){
	  
	   $query99="select * from portedocuments  where codeEtu='".urldecode($_GET['code'])."'";
    $result99 = mysql_query($query99,$connexion ); 
	$nbdocs= mysql_num_rows( $result99);	  	
	  
echo"<a href=portedocument/index.php?code_etud_rech=".$_GET['code']. ">Accéder à son porte documents</a> ( $nbdocs doc(s) )<br>";
if(in_array($login,$scol_user_liste) ){
			echo"<a href=".$chemin_root_relatif_eleve."defaultclone.php?login_clone=".$e->$myannuaireuid.">Se connecter comme  ".$e->$myetudiantsnom." ".strtolower($e->$myetudiantsprénom_1)."</a><br>";	 		 
	 }
  }
  $query2="select groupes.libelle as libellegpe, groupes.login_proprietaire as propgpe from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."'";
// $query2.= " and groupes.libelle like '".$gpeinternationaux."%' and groupe_officiel = 'oui' ";
 //2018 on utilise le code plutôt que le nom
  $query2.= " and groupes.code = '".$code_groupe_ETUDIANTS_ETRANGERS."' ";
 //echo $query2;
 $result2 = mysql_query($query2,$connexion ); 
  if (mysql_num_rows($result2)!=0){
 echo  "<center><a href=insc_accueil_prof.php?code_etu=".$_GET['code'].$filtre.">Inscriptions aux cours (étranger en accueil $annee_accueil_bascule )</a></center>";
 }
echo"</td><td>";

//on regarde d'abord ds le rep upload pour la photo téléchargée
  if (file_exists($photolocal_perso))
{
      // print "<img src= ".$photo2." width=160  height=120><br>";
      echo "<img class='imgBorder' src=".$photo_perso." width=160  >";
}
// sinon on regarde ds le rep officiel
elseif (file_exists($photolocal))
{
      // print "<img src= ".$photo2." width=160  height=120><br>";
      echo "<img class='imgBorder' src=".$photo." width=160 >";
}
// sinon dans unicampus
elseif (image_unicampus($_GET['code'])['status']=='200')
{
   //print "<i>photo non disponible </i><br><img src=".$chemin_images."default.jpg ><br>";
   echo "<img class='imgBorder' src=\"".image_unicampus($_GET['code'])['dataimg']."\" alt=\"photo_unicampus\" width=160 >";
}
else // sinon on affiche l'image non trouvée
{
	echo "<img class='imgBorder' style='width:166px;height:206px' src=".$chemin_images."Pas_dimage_disponible.svg.png ><br>";
}


echo"</tr></td></table></center> </div>";
echo "<hr>";
// fin du premier tableau
echo "<br><br>";
echo "<center>";
echo"<table>";
echo "<td>";

echo"<table>";

//echo" Renseignements supplémentaires Scolarité GI";
 foreach($champs4 as $ci2){
if ($e->$ci2!="" and $ci2!="code" ){
 $afficheligne=1;
switch ($ci2){
	case "annee":
		$ligne="<td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >Groupe principal"."</td><td>".$e->$ci2."</td></tr>";
	break;	
	case "date_diplome":
		$ligne="<td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >date diplôme"."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
	break ;
	case "date_modif":
		$ligne="<td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >fiche modifiée  "."</td><td> le ".mysql_DateTime($e->$ci2)." par ".$e->modifpar."</td></tr>";
	break ;
	case "modifpar":
		$afficheligne=0;
	 break;
		case "date_remise_badge":
		$ligne="<td bgcolor='#f7ce00' style='color:black ; padding:5px; text-transform: uppercase; text-align:center'>date remise badge" ."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
		break;
		case "date_retour_badge":
		$ligne="<td bgcolor='#f7ce00' style='color:black ; padding:5px; text-transform: uppercase; text-align:center'>date retour badge" ."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
		break;
		case "date_demande_badge":
		$ligne="<td bgcolor='#f7ce00' style='color:black ; padding:5px; text-transform: uppercase; text-align:center'>date demande badge" ."</td><td>".mysql_DateTime($e->$ci2)."</td></tr>";
		break;
	default :
		$ligne= "<td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >".$ci2."</td><td >".$e->$ci2."</td></tr>";
 } //fin du switch
 if   ($afficheligne){
  echo "<tr>  ";
 echo $ligne;}
 } //fin du if odbc_result($resultat,$ci2)!=""
 } //fin du foreach

 //echo"Informations issues d'APOGEE";
foreach($champs as $ci){
 //echo $ci."___".$e->$ci."<br>";
 $ligne='';
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
	$sqlquery="select *  from departements where dep_code = ".$e->$myetudiantspays_dept_naiss."";
	//echo $sqlquery;
	$resultat2=mysql_query($sqlquery,$connexion );	
	if($f=mysql_fetch_object($resultat2))		$correspondance= " : ".$f->dep_libelle; else $correspondance="dép inconnu";	
	$ligne="Date et lieu de naissance"."</td><td>".$e->$myetudiantsdate_naiss." à ".$e->$myetudiantsville_naiss." <i>$correspondance</i></td></tr>";
	break;
case "Code CSP parent":
	//$ligne=$ci."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_csp_parent."</i></td></tr>";
	$afficheligne=0;
	break;
case "Code CSP étudiant":
	// $ligne=$ci."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_csp_étudiant."</i></td></tr>";
	$afficheligne=0;
	break;
case "Type étab ant":
	//$sqlquery="select * from nomenclature_ecoles where code = '".$e->$myetudiantstype_étab_ant."'";
	//$resultat2=mysql_query($sqlquery,$connexion );
	//$f=mysql_fetch_object($resultat2);
	//	$correspondance= " : ".$f->libelle;
	//$sqlquery="select * from departements where dep_code = ".$e->$myetudiantsdpt_étab_ant."";

	//$resultat2=mysql_query($sqlquery,$connexion );
	//$f=mysql_fetch_object($resultat2);
	//$correspondance= $correspondance."-".$e->$myetudiantsdpt_étab_ant."-".$f->dep_libelle;
	//$ligne="dernier établ. fréquenté</td><td>".$e->$ci."<i>$correspondance</i></td></tr>";
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
	if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) or in_array($login,$power_user_liste) ))
	{
		$sqlquery="select * from nomenclature_situation_fam where code = ".$e->$myetudiantscode_sit_fam;
			$resultat2=mysql_query($sqlquery,$connexion );
			$f=mysql_fetch_object($resultat2);
		$correspondance= " : ".$f->libelle;
		$ligne="situation familiale</td><td>"."<i>$correspondance</i></td></tr>";
	}
	else
	$afficheligne=0;	
	break;
case "Code profil":
	$ligne="Profil"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_profil."</i></td></tr>";
	break;
case "Code régime":
	$ligne="Régime"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_régime."</i></td></tr>";
	break;
case "Code bac":
	//$sqlquery="select * from departements where dep_code = ".$e->$myetudiantscode_dpt_bac."";;
	//echo $sqlquery;
	//$resultat2=mysql_query($sqlquery,$connexion );
	//$f=mysql_fetch_object($resultat2);
	//$correspondance= " : ".$f->dep_libelle;
	$correspondance= " : ";
	$ligne="Bac"."</td><td>Bac ".$e->$myetudiantslib_bac."-mention ".$e->$myetudiantslib_mention."-".$e->$myetudiantsannée_obt_bac."<i>$correspondance</i></td></tr>";
	break;
case "Code dip":
	$ligne="Diplôme"."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_dip."</i></td></tr>";
	if ($double_inscription)
	{
	$ligne.="<tr><td bgcolor='yellow'>Diplôme 2"."</td><td>".$ed->$ci."-<i>".$ed->$myetudiantslib_dip."</i></td></tr>";	
	}
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
	if ($double_inscription)
	{
	$ligne.="<tr><td bgcolor='yellow'>Etape2"."</td><td>".$ed->$ci."-<i>".$ed->$myetudiantslib_étape."-<i>"."</i></td></tr>";
	}
	break;
case "Lib étab ech":

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
	$afficheligne=0;
	//$ligne=$ci."</td><td>".$e->$ci."-<i>".$e->$myetudiantslib_aide_finan."</i></td></tr>";
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
	$ligne="Adr annuelle ville" ."</td><td>".$e->$ci."-<i>".$e->$myetudiantsada_lib_commune."</i> ".$e->$myetudiantsada_lib_pays."</td></tr>";
	break;
case "Ada lib commune":
	$afficheligne=0;
	break;
case "Ada lib pays":
	$afficheligne=0;
	break;	
case "Adf lib commune":
	$afficheligne=0;
	break;	
case "Adf code BDI":
	$ligne="Adr fixe Ville" ."</td><td>".$e->$ci."-<i>".$e->$myetudiantsadf_lib_commune."</i> ".$e->$myetudiantsadf_lib_pays."</td></tr>";
	break;
	// pour les etrangers pas de code BDI mais Adf adresse
case "Adf adresse":
	$ligne="Adr fixe Ville etranger" ."</td><td>".$e->$ci."-<i>".$e->$myetudiantsadf_lib_pays."</td></tr>";
	break;	
case "Adf lib pays":
	$afficheligne=0;
	break;	
case "Adresse fixe":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;		
case "Adf rue2":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;
case "Adf rue3":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;	
case "Adresse annuelle":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;
	
case "Ada rue 2":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;	
case "Ada rue 3":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;	
	
case "Ada Num tél":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;	
case "Adf num tél":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;		
case "Num tél port":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
	break;		
case "Email perso":
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) or in_array($login,$power_user_liste) ))
	$ligne=$ci."</td><td>".$e->$ci."</td></tr>";
else
	$afficheligne=0;	
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
 	//$ligne="Provenance" ."</td><td>".$e->$ci."</td></tr>";
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
 case "Nbr enf":
	$afficheligne=0;
	break;	
   case "Lib étab":
   		// pour les DD ACCUEIL
	if($e->$myetudiantscode_profil=='DA')
	{
	$ligne="Etab Double diplôme Accueil" ."</td><td>".$e->$myetudiantslib_étab."<i></i></td></tr>";	
	}else
	{
		 $afficheligne=0;
		}
 break;
  case "Lib etb bac":
 $afficheligne=0;
 break;
  case "Commentaire":
 $afficheligne=0;
 break;
   case "Tem_web":
 $afficheligne=0;
 break;
    case "Code_handi":
 $afficheligne=0;
 break;
  case "Code_type_CGE":
 $afficheligne=0;
 break;
   case "Code_shn":
 $afficheligne=0;
 break;
  case "Lib_shn":
 //$afficheligne=0;
 	$ligne="Sport Haut niveau" ."</td><td>".$e->$ci."</td></tr>";
 break;
   case "Lib_handi":
 $afficheligne=0;
 	//$ligne="Handicap" ."</td><td>".$e->$ci."</td></tr>";
 break;
   case "Tem_cursus_amenage":
 $afficheligne=0;
 	//$ligne="Cursus amenage" ."</td><td>".$e->$ci."</td></tr>";
 break;
    case "Lib_type_CGE":
 $afficheligne=0;
 	//$ligne="Spécialité CGE" ."</td><td>".$e->$ci."</td></tr>";
 break;
   case "Type étab":
 $afficheligne=0;
 break;
    case "Pg échange":
 $afficheligne=0;
 break;
     case "Inscr  parallele/chgt inscr":
 $afficheligne=0;
 break;
     case "Numéro INE":
 $afficheligne=0;
 break;
  case "Nat. tit acc":
 $afficheligne=0;
 break;
 case "Dip. tit acc":
	switch ($e->$myetudiantsdip__tit_acc){
	case "CCPPAEI":
		$ligne="Origine"."</td><td>"."CPP GRENOBLE"."</td></tr>";
		break;
	case "CPPL":
		$ligne="Origine"."</td><td>"."CPP LORRAINE"."</td></tr>";
		break;	
	case "CPPT":
		$ligne="Origine"."</td><td>"."CPP TOULOUSE"."</td></tr>";
		break;			
	default: 
		$ligne="Origine"."</td><td>".$e->$ci."</td></tr>";
		break;
	}
	break;

	default :
	$correspondance= "";
	$ligne=$ci."</td><td>".$e->$ci."<i>$correspondance</i></td></tr>";
} // fin du switch
 if   ($afficheligne){
  echo "<tr><td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >  ";
 echo $ligne;}
 }  //fin du if$e->$ci!=""
 } //fin du foreach

 //affichage login
if((in_array($login,$scol_user_liste) or in_array($login,$re_user_liste)  or in_array($login,$power_user_liste) ))
{
 echo "<tr><td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >  ";
 echo "login"."</td><td >".$e->$myannuaireuid."</td></tr>";
  echo "<tr><td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center' >  ";
 echo "dernière maj annuaire"."</td><td >".mysql_Time($e->$myannuairedate_maj)."</td></tr>";
 }
echo "</table>";
echo "</td><td valign=top>";
echo "<table>";
   //affichage des groupes
   				if (in_array($login, $scol_user_liste)){
					// pour la scol on prend aussi les gpe où l'etudiant est exempté
    $query2="select  ligne_groupe.exempte,type_inscription,groupes.libelle as libellegpe,code_ade,code_ade6,recopie_gpe_officiel, groupes.login_proprietaire as propgpe ,type_gpe_auto ,archive,gpe_evenement,url_edt_direct  from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."' and archive !='oui'  order by libellegpe ";
				}
				else{
 $query2="select ligne_groupe.exempte,type_inscription,groupes.libelle as libellegpe,code_ade,code_ade6,recopie_gpe_officiel, groupes.login_proprietaire as propgpe ,type_gpe_auto ,archive,gpe_evenement,url_edt_direct  from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where ligne_groupe.code_etudiant='".urldecode($_GET['code'])."' and archive !='oui' and 	( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui') order by libellegpe ";
				}
    //if ($login!='administrateur'){
//$query2.=" and groupes.visible = 'oui'";}
 //echo $query2;
 	echo"<tr valign=top><td bgcolor='#537939' style='color:white ; padding:5px; text-transform: uppercase; text-align:center;vertical-align: middle !important;'>" ;
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
				echo  "<a class='abs2' href=".$URL."?code=".$_GET['code']."".$filtre."&tousgpe=1>Afficher ses groupes de cours / Display his courses groups</a>";		
				}
				else
				{
				echo  "<a class='abs' href=".$URL."?code=".$_GET['code']."".$filtre."&tousgpe=0>Masquer ses groupes de cours / Hide his courses groups</a>";	
				}
				
				echo"        </td> </tr>";
			}
		// on  parcourt la liste des gpes
		$url_directe='';
	while($u=mysql_fetch_object($result2)) {
	//on traite ceux qui vont constituer la ressource= d'ADE
//if ($u->code_ade!='' and $u->feuille_ade =='oui'){
// plus necessaire feuille ade  par contre il faut garder uniquement les  typegpeauto edt  non archives?

		if ($u->code_ade!='' and ($u->type_gpe_auto == 'edt' or $u->gpe_evenement=='oui' ) )
			{
			$liste_ress_url.="$u->code_ade,";
			}
		if ($u->code_ade6!='' and ($u->type_gpe_auto == 'edt' or $u->gpe_evenement=='oui' ) and $u->exempte != 'oui')
			{
				
				// attention si on a des espaces dans les codes ressources on doit les remplacer par des + sinon ADE ne comprend pas
			
				if (strpos($u->code_ade6,' ') ) {
                    $liste_ress_url6 .= str_replace(' ', '+', $u->code_ade6) . ",";
                }elseif( strpos($u->code_ade6,'é')  ){
                    $liste_ress_url6 .= str_replace('é', '%C3%A9', $u->code_ade6) . ",";
                } else {
                    $liste_ress_url6.=$u->code_ade6.",";
                }
				
			}			
			// condition pour l'affichage des groupes - la derniere condition c'est pour ne pas avoir les groupes offciels de promo en double
		if ( ($u->type_gpe_auto != 'edt' or $_GET['tousgpe'] ) and ( $u->recopie_gpe_officiel ==''))
			{
				echo"   <tr><td>" ; 
// pour la scol on affiche le type d'inscription
				if (in_array($login, $scol_user_liste)){
if ( $u->exempte == 'oui') $exem='<i>exempté</i>';else 	$exem='';				
				echo  $u->libellegpe.' ['.$u->type_inscription.'] '.$exem;
				}
				else{
				echo  $u->libellegpe;}	
				echo"        </td> </tr>";
			}
		if ($u->url_edt_direct != ''  )
			{
			$url_directe=$u->url_edt_direct;
			$url_directe_nom_gpe=$u->libellegpe;
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
//pour ADE 5.2
// if ($liste_ress_url != ''){
	  // echo "<a href=http://ade52-inpg.grenet.fr/ade/custom/modules/plannings/direct_planning.jsp?projectId=".$id_projetADE."&login=voirENSGI&password=ensgi&displayConfName=web&weeks=".$numsemaine."&days=0,1,2,3,4,5&resources=".$liste_ress_url." target=_blank ><b> Emploi du temps de cette semaine sur ADE</b></a>";
	  // echo "<br>";
	  // echo "<a href=http://ade52-inpg.grenet.fr/ade/custom/modules/plannings/direct_cal.jsp?calType=ical&projectId=".$id_projetADE."&login=voirENSGI&password=ensgi&nbWeeks=4&resources=".$liste_ress_url." target=_blank > lien pour synchroniser un agenda avec votre edt sur ADE (sur 4 semaines )</a>";

	  // }
if ($liste_ress_url6 != ''){
	  echo "<br>";
	 // echo $liste_ress_url6 ."<br>";

	  	 	  echo "<a class='abs' href='".$lien_ade_pers."&weeks=".$numsemaine."&days=0,1,2,3,4,&name=".$liste_ress_url6."' target=_blank > Emploi du temps sur ADE / Courses schedule on ADE ( <b>Vue pour les Personels </b>) </a>";
    echo "<br><br><a class='abs2' href='".$lien_ade_etu."&weeks=".$numsemaine."&days=0,1,2,3,4,&name=".$liste_ress_url6."' target=_blank > Emploi du temps sur ADE / Courses schedule on ADE ( <b>Vue pour les étudiants </b>) </a>";

    echo "<br><br/>";
	  echo "<b style='color:red'> Attention :</b> seuls les cours auxquels vous êtes déjà inscrits apparaissent,<br> en début d'année vérifiez vos inscriptions<br> en affichant vos groupes de cours (lien ci-dessus). <br>L'emploi du temps complet est affiché dans le hall de l'école.
<br><i> <b style='color:red'> Caution:</b> only the courses in which you are registered will be shown,<br> make sure you have all your courses groups (link above).<br> The complete schedule is posted in the school hall.</i>";	
	  echo "<br><br/>";
	  	  echo "<a class='abs' href=".$lien_synchro_ade6."&name=".$liste_ress_url6." target=_blank > Lien pour synchroniser votre agenda électronique / Link to synchronize your calendar</a> <br><br/>(smartphone, thunderbird, ical...) avec votre emploi du temps ADE  ";
	  }	  
	  else	
	  {
		  // on a pas trouvé de groupes avec code ade on affiche l'edt de genie industriel
	  echo "<br>";
	  	 	  echo "<b><a class='abs' href ='".$lien_ade_pers."&resources=".$codeaderesourcegenieindustriel."' target=_blank >Emploi du temps général sur ADE</a></b>";
	  echo "<br>";
	  echo "<br>";
	  	  echo "Lien pour synchroniser votre agenda électronique</a> <br>(smartphone, thunderbird, ical...) avec votre emploi du temps ADE  ";
	  }  
		  
if ($url_directe != ''){
	  echo "<br><a href=".$url_directe." target=_blank > Emploi du temps ".$url_directe_nom_gpe."</a>"; 
	  echo "<br>";

	  }
 echo" </tr>  <tr>" ; 	  
 echo" </tr>  <tr>" ; 
 		// LENA
		$anneeprec=$annee_courante-1;
		echo"<td colspan=2><a href=https://refens.grenoble-inp.fr/notes/etudiants/".$e->$myetudiantscode_etu."/".$anneeprec ."  target=_blank><b>Notes ".$anneeprec ."-".$annee_courante." pour  ".$e->$myetudiantsnom." ".strtolower($e->$myetudiantsprénom_1)."</b><i>(accès restreint )</i></a></td>";
 echo" </tr>  <tr>" ;
 // PISE
 if(in_array($login,$power_user_liste) or $login=='administrateur')
 {
echo"<td colspan=2><a href= https://scol.grenoble-inp.fr/pise/home/".$e->$myetudiantscode_etu ." target=_blank><b>Fiche PISE de  ".$e->$myetudiantsnom." </b><i>(accès restreint )</i></a></td>";
echo" </tr>  <tr>" ;

 }
		
 //affichage des absences
 $query2="select * from absences left join absences_statuts on absences_statuts_code=statut_absence  where code_etud='".urldecode($_GET['code'])."' order by date_debut desc  ";
 

	

    $result2 = mysql_query($query2,$connexion ); 
	if (mysql_num_rows( $result2) >0){
	echo afficheonly("","Absences :",'b' ,'h3');	
	
	echo "<table class='table1'>";
	echo "<th>Début</th><th>Fin</th><th>Type</th><th>Statut</th>";
	while($u=mysql_fetch_object($result2)) {
echo"   <tr><td>" ;  
     		echo  mysql_DateTime($u->date_debut);
		echo"   </td><td>" ;
		echo  mysql_DateTime($u->date_fin)  ;
      echo"   </td><td>" ;
	       echo $u->mot_cle ;
	   echo"   </td>" ;
      //echo $u->motif ;
	   echo"<td style='text-align:left'>" ;
	     
			if( $u->absences_statuts_texte == 'justifiée' OR $u->absences_statuts_texte == 'validée par DE' or $u->absences_statuts_texte == 'validée par DE sans justificatif'  ){
					echo "<i style='color: green' class='fa-regular fa-thumbs-up'></i>

<strong style='text-transform: uppercase;padding:4px;background-color:green ; color: white ; font-weight:normal ; min-width: 290px;display:inline-block'>" .$u->absences_statuts_texte."<strong>" ;
			}elseif( $u->absences_statuts_texte == 'Accepter par DE' ) {
							echo "<i style='color: blue' class='fa-regular fa-thumbs-up'></i>&nbsp;<strong style='text-transform: uppercase;padding:4px;background-color:#2863a1 ; color: white ; font-weight:normal; min-width: 290px;display:inline-block'>" .$u->absences_statuts_texte."<strong>" ;

			}else{
				echo "<i style='color: #ea2e43' class='fa-regular fa-thumbs-down'></i>&nbsp;<strong style='text-transform: uppercase;padding:4px;background-color:red ; color: white ; font-weight:normal; min-width: 290px;display:inline-block'>" .$u->absences_statuts_texte."<strong>" ;
			}
     echo"   </td>" ;
		  		  echo"        </tr>";
		  

	 }
	 
	echo"</table><br/>";

	}
	else{
	echo "</tr><tr><td colspan=2 style='color: red;'>Pas d'absence enregistrée actuellement pour cet élève<br>";}
			  		if(in_array ($login ,$scol_user_liste ))
		{
	
		echo"<a class='abs' href=absences/absences_gest.php?tout=1&code_etud_rech=".$_GET['code']. ">Gérer les absences de  ".$e->$myetudiantsnom." ".strtolower($e->$myetudiantsprénom_1)." pour l'année ".($annee_courante-1).'-'.$annee_courante."</a></td>";
		}
			  		if(in_array ($login ,$de_user_liste ))
		{
	
		echo"<a class='abs' href=absences/absences_de.php?tout=1&code_etud_rech=".$_GET['code']. ">Gérer les absences de  ".$e->$myetudiantsnom." ".strtolower($e->$myetudiantsprénom_1)." pour l'année ".($annee_courante-1).'-'.$annee_courante."</a></td>";
		}		
		
		
	echo "</tr><tr><td colspan=2>";

	echo"   </td>" ; 

	echo "</tr><tr>";

  echo"</table>";
 echo"</table>";
 echo"</table>";
} // fin du if affiche tout
 
 echo  "</center>";

require('footer.php');
echo"</body>";
echo "</html>";
mysql_close($connexion);
?>
