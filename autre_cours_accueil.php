<?php
// initialisation session
session_start() ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>gestion des autres cours accueil</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);



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
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['club_indus'])) $_POST['club_indus']='';
if (!isset($_POST['villecp'])) $_POST['villecp']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_POST['code_etud'])) $_POST['code_etud']='';
$message='';
$sql1='';
$sql2='';
$liste_champs_dates=array('autcour_date_modif');
$liste_ecole=array('Sélectionnez une école INP ci dessous ou remplissez le champ Autre école','E3','PAGORA','PHELMA','ENSIMAG','ESISAR');
$liste_code_ecole=array('autre','E3','PAGORA','PHELMA','ENSIMAG','ESISAR');

$liste_ects=array('1','1.5','2','2.5','3','3.5','4','4.5','5','5.5','6');

   $listeouinon=array('non','oui');
   $whereuniv='1';
   $where=' where 1';

 $affichetout=1;

//$login="_popop";
// est ce que c'est RI ?
if (isset($_SESSION['loginacc']))
{
 $loginacc=$_SESSION['loginacc'];
 }
 // sinon 
 else {
 // est ce que c'est un compte provisoire devenu définitif ?
 // on recherche avec son nouveau login , son code etu et son ancien login
 $sqlquery="SELECT annuaire.*,etudiants_accueil.*  FROM etudiants_accueil
                  left outer join annuaire on upper(etudiants_accueil.acc_code_etu)=annuaire.`code-etu`
                  where annuaire.UId='".$login."'";
				  //echo  $sqlquery;
$resultat=mysql_query($sqlquery,$connexion);
 // on prend son ancien login
if(mysql_num_rows($resultat)!=0){
$z=mysql_fetch_object($resultat);
 $loginacc=$z->acc_login ;
} // sinon c'est un compte temporaire on prend  le login du connecté
else{
 $loginacc=$login;
}
}




//on verifie qu'il s'agit d'un etudiant en accueil enregistré
$query= "SELECT etudiants_accueil.*  FROM etudiants_accueil where acc_login='".$loginacc."'";
$result=mysql_query($query,$connexion);
//echo $query;
 //si le login est bien celui d'un etudianten accueil enregistré ou de qqun des ri
 if (mysql_num_rows($result)!=0 or in_array($login,$ri_user_liste))
 {
	
$URL =$_SERVER['PHP_SELF'];;
$table="cours_autres_accueil";
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





// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
// test de validite autre ecole-ecole inp
   if (!(($_POST['autcour_autre_ecole']=='' and $_POST['autcour_nom_ecole']=='autre'   ) or ($_POST['autcour_autre_ecole']!='' and $_POST['autcour_nom_ecole']!='autre'   ) ) ){
   
 $_POST['autcour_modifpar']=$login;
//pour les credits ects mal saisis
$_POST['autcour_ECTS']=nettoiefloat($_POST['autcour_ECTS']);

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
  //pb des dates mysql
//si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
if ($ci2=="autcour_id"){
 //on ne fait rien
 }
elseif ($ci2=="autcour_date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(),";}
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
  //echo $query;
      $result = mysql_query($query,$connexion);
       if ($result){
    $message = "Fiche <b>";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 
    }
   else{   // fin du nom=''
    echo affichealerte("choix d'école-inp autres écoles incomptatibles! : Recommencez !");

	}
    
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 //if(in_array($login,$scol_user_liste)){
  // bon pour tout le monde
 if(1){

	 //et qu'une inscription  n'y est pas rattachée non plus 
   $query = "DELETE FROM $table"
      ." WHERE autcour_id='".$_GET['del']."'";
      //echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
   
      else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 //if(in_array($login,$scol_user_liste)){
 // bon pour tout le monde
 if(1){
 //pour modifpar
$_POST['autcour_modifpar']=$login;
//pour les credits ects mal saisis
$_POST['autcour_ECTS']=nettoiefloat($_POST['autcour_ECTS']);

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
 
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
if ($ci2=="autcour_date_modif"){
 $sql1.= $ci2."=now(),";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }

 //attention il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE autcour_id='".$_POST['autcour_id']."' ";
 // echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['autcour_id']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>seul le   service scolarité peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée <br>";

} //fin du else $login ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=2;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details
   $affichetout=0;
 $query = "SELECT * FROM $table 
					  where autcour_id='".$_GET['mod']."'";
					  //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		   //on surcharge les dates pour les pbs de format

		$acc_date_modif=mysql_Time($autcour_date_modif);
//$date_fin= preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $date_fin);
		//on récupère les champs liés
   
         
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";
 //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        } 

  echo"<center>";
  echo"       <table><tr>  ";
   echo affichechamp('Login','autcour_login',$autcour_login,10,1);  
       	   echo "</tr><tr>";
	   echo affichemenuplus2tab ('Ecole INP','autcour_nom_ecole',$liste_ecole,$liste_code_ecole,$autcour_nom_ecole);


        echo affichechamp('Autre Ecole','autcour_autre_ecole',$autcour_autre_ecole,50);
  	   echo "</tr><tr>";
		echo affichechamp('Filière','autcour_filiere',$autcour_filiere,50);		
		echo "</tr><tr>";
		echo affichechamp('nom du cours','autcour_titre',$autcour_titre,50);
		echo affichechamp('nom du prof','autcour_prof',$autcour_prof,50);
		echo "</tr><tr>";
		echo affichechamp('nombre d\'heures','autcour_heures',$autcour_heures,3);
        echo affichechamp('Crédits ECTS','autcour_ECTS',$autcour_ECTS,3);
		echo "</tr><tr>";
        echo affichechamp('Semestre','autcour_semestre',$autcour_semestre,10);
		echo "</tr><tr>";


	   
    echo "</tr><tr>";
	   
    echo affichechamp('modifié par','autcour_modifpar',$autcour_modifpar,'15',1);
    echo affichechamp('le','autcour_date_modif',$autcour_date_modif,'15',1);
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;

  
  
  
  
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
  echo affichechamp('Identifiant','autcour_login',$loginacc,10,1);  

    	   echo "</tr><tr>";
		//if ($autcour_nom_ecole=='')$autcour_nom_ecole='NC';
		//echo affichemenu('Ecole INP ','autcour_nom_ecole',$liste_ecole,'');
	   echo affichemenuplus2tab ('Ecole INP','autcour_nom_ecole',$liste_ecole,$liste_code_ecole,'autre');

		echo affichechamp('Autre Ecole','autcour_autre_ecole','',50);
  	   echo "</tr><tr>";
		echo affichechamp('Filière','autcour_filiere','',50);		
		echo "</tr><tr>";
		echo affichechamp('nom du cours','autcour_titre','',50);
		echo affichechamp('nom du prof','autcour_prof','',50);
		echo "</tr><tr>";
       
		echo affichechamp('nombre d\'heures','autcour_heures','',3);
		 echo affichechamp('Crédits ECTS','autcour_ECTS','',3);
		 		echo "</tr><tr>";
       
        echo affichechamp('Semestre','autcour_semestre','',10);
		echo "</tr><tr>";
		echo "</tr><tr>";


  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT * FROM $table  where autcour_login = '".$loginacc."'";
  // $query.=$where."  ";
   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo" cours autres que $ecole d'étudiants en accueil </h2></center>  <BR>";}
else{
echo"<center> <h2>Il n'y a pas d'autres cours enregistrés    ";
echo" </h2></center>  <BR>";}

echo "<A href=".$URL."?add=1 > Ajouter un cours </a><br>";
echo "<A href=insc_accueil.php > Revenir </a><br>";

if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";

        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";


echo "<th>login</th> <th>nom ecole</th><th>filiere</th><th>autre ecole</th>";





while($universite=mysql_fetch_object($result)) {

 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;

   }

		   //on surcharge les dates pour les pbs de format
        
		//on récupère les champs liés
     
	 
	 //$modifpar=odbc_result($result,"modifpar") ;
      echo"   <tr><td>" ;
		echo $autcour_login;
      echo"   </td><td>" ;
		echo $autcour_nom_ecole;
      echo"   </td><td>" ;
		echo $autcour_filiere;
      echo"   </td><td>" ;
	  echo $autcour_autre_ecole;
      echo"   </td><td>" ;
	  
     echo " <A href=".$URL."?del=".$autcour_id." onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce cours ?')\">";
     echo "sup</A> - ";
     echo "<A href=". $URL."?mod=".$autcour_id.">Modifier</A>";

     echo"        </td> </tr>";
       }
	   

echo "</form>";
	   
echo"</table> ";
  }
  }
  }//si ce n'est pas un etudianten accueil enregistré ou de qqun des ri
  else
 {
echo"<center> désolé, mais votre login : <b>".$login."</b> ne correspond à celui d'un étudiant en accueil inscrit 
 <br>veuillez contacter le <a href=mailto:nadia.dehemchi@grenoble-inp.fr >service RI</a>   </center>";
 }
 mysql_close($connexion);

?>
</body>
</html>