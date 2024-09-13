<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>photo eleve</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?php
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
//on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
   $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);
$affichetout=1;
if (!isset($_GET['adddoc'])) $_GET['adddoc']='';
if (!isset($_GET['unlink'])) $_GET['unlink']='';
if (!isset($_POST['ajoutdoc'])) $_POST['ajoutdoc']='';
if (!isset($_POST['bouton_adddoc'])) $_POST['bouton_adddoc']='';
if (!isset($_POST['adddoc'])) $_POST['adddoc']='';

$URL =$_SERVER['PHP_SELF'];



  //---------------------------------------c'est kon a cliqué sur le lien ajouter photo
 		 if($_GET['adddoc']!=''or $_POST['adddoc']!='')  {
   $affichetout=0;
$photo=$chemin_images.$_GET['code'].".jpg";
$photo_perso=$chemin_images_perso.$_GET['code'].".jpg";
$photolocal =$chemin_local_images.$_GET['code'].".jpg";
$photolocal_perso =$chemin_local_images_perso.$_GET['code'].".jpg";
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 

	echo "	<form method='POST' action=$URL enctype='multipart/form-data'>";
	  echo"<input type='hidden' name='ajoutdoc' value=1>";
	    echo afficheonly("","Joindre une photo <br> ATTENTION taille maxi 60 Ko ",'b' ,'h3','',0);
		echo afficheonly("","  dimensions conseillées 200 X 300 pixels",'b' ,'h4');
	    //pour apres la sortie du formulaire retrouver la selection en cours
     //On limite le fichier à 100Ko -->
    echo " <input type='hidden' name='MAX_FILE_SIZE' value='60000'>";
	    echo " <input type='hidden' name='code' value=".$_GET['code'].">";
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
 if(in_array($login,$scol_user_liste)  ){
 
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
 
 if ($affichetout)
 {

} // fin du if affiche tout
 
 echo  "</center>";
mysql_close($connexion);
?>
</body>

</html>