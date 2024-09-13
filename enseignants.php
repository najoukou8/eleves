<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des enseignants</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
require __DIR__."/vendor/autoload.php";
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
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_POST['id_univ_bourse'])) $_POST['id_univ_bourse']='';
$message='';
$sql1='';
$sql2='';
$cmp = 0 ;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
$cache = new FilesystemAdapter();


$where='';
//$orderby= ' order by nom';




if ($_GET['env_orderby']=='') {$orderby= ' order by nom';}
	else{
	$orderby=" order by ".urldecode($_GET['env_orderby']);
	if  ($_GET['env_inverse']!="1"){
                  $orderby=$orderby." desc";}
	}


   //seules les personnes autorisées ont acces à la liste
 if(in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ){
	$affichetout=1;
}else
	{$affichetout=0;
	}

$URL =$_SERVER['PHP_SELF'];;
$table="enseignants";
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
//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ){
// test valeurs obligatoires
 if (!($_POST['nom']=='' or $_POST['email']==''  or $_POST['uid_prof']=='' )){
 $_POST['modifpar']=$login;
 //pb des dates mysql
 //pour les dates


foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="id"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
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
   echo "<center><b>seul le service relations entreprises peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ){
 

	//mais avant il faut verifier qu'un stage n'y est pas rattaché
   $query = "SELECT * FROM stages where code_tuteur_gi= ".$_GET['del'] ."  or code_tut1_prop= ".$_GET['del']."  or code_tut2_prop= ".$_GET['del']."  or code_tut3_prop= ".$_GET['del']." order by date_debut";
 // echo $query;
     $result = mysql_query($query,$connexion ); 
    $nombre = mysql_num_rows($result);
     if ($nombre <> 0){
      echo affichealerte("impossible de supprimer cet enseignant car ".$nombre." stage(s)
      lui est (sont)  associé(s) comme tuteur proposé ou réel");
     }
	 else{
   $query = "DELETE FROM $table"
      ." WHERE id=".$_GET['del']."";
     // echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
   }
      else{
   echo "<center><b>seul le service relations  entreprises peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$scol_user_liste) or in_array($login,$re_user_liste) ){
 
 // test valeurs obligatoires
 if (!($_POST['nom']=='' or $_POST['email']==''  or $_POST['uid_prof']=='' )){
 
 //pour modifpar
$_POST['modifpar']=$login;
//pour les dates

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
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
   $query .= " WHERE id=".$_POST['id']." ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['id']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();
    }
	}
	else{
	echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
	}
	
   else{
   echo "<b>seul le   service des relations entreprises peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where id=".$_GET['mod']." order by nom ";
					  //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		$date_modif=mysql_Time($date_modif);
//$date_fin= preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $date_fin);
		//on récupère les champs liés
     
         
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";

    echo"<input type='hidden' name='id' value=\"$id\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
  //on met en hidden le id_univ

      echo affichechamp('Nom(*)','nom',$nom,'','');
	  echo affichechamp('Prenom','prenom',$prenom,'','');
	   echo "</tr><tr>";
   	  echo affichechamp('Email(*)','email',$email,'40','');
	  echo affichechamp('login (*)','uid_prof',$uid_prof,'8','');
	  	   echo "</tr><tr>";
	echo afficheradio ('Est en activité','enActivite',$listeouinon,$enActivite,'oui');
 echo "</tr><tr>";
    echo affichechamp('modifié par','modifpar',$modifpar,'15',1);
    echo affichechamp('le','date_modif',$date_modif,'15',1);
    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
    	  echo'(*) champ obligatoire';
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
  //on met en hidden le id

      echo affichechamp('Nom (*)','nom',$nom,'','');
	  echo affichechamp('Prenom','prenom',$prenom,'','');
	   echo "</tr><tr>";
   	  echo affichechamp('Email (*)','email',$email,'40','');
	  echo affichechamp('login (*)','uid_prof',$uid_prof,'8','');
   
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
   echo'(*) champ obligatoire';
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT * FROM $table where nom != 'NC' ";
   $query.=$where."  ".$orderby;
   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2 class='titrePage2'>Liste des   ";
echo $nombre;
echo" Enseignants</H2>";}


echo "<A class='abs2' href=".$URL."?add=1> Ajouter un enseignant </a><br>";

echo"<br><a class='abs' href=default.php>Revenir à l'Accueil</a>";
if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
        echo "<BR><BR><table class='table1'><tr bgcolor=\"#98B5FF\" > ";

		    if   ($_GET['env_orderby']=='nom' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=nom&env_inverse=1>Nom</a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=nom&>Nom</a></th> ";}
 if   ($_GET['env_orderby']=='prenom' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=prenom&env_inverse=1>Prenom</a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=prenom&>Prenom</a></th> ";}
 if   ($_GET['env_orderby']=='email' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=email&env_inverse=1>Email/a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=email&>Email</a></th> ";}
echo "<th>Email annuaire </th>";

//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";}
$csv_output .= "\n";
while($universite=mysql_fetch_object($result)) {

 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   $csv_output .= $universite->$ci2.";";
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format

		//on récupère les champs liés
     
	 
	 //$modifpar=odbc_result($result,"modifpar") ;
      echo"   <tr><td>" ;
     
      echo $nom ;
      echo"   </td><td>" ;
       echo $prenom ;
	   echo"   </td><td>" ;
       echo $email ;
      echo"   </td><td>" ;
	  if ($uid_prof<>''){
	  $mailprofannu=ask_ldap($uid_prof,'mail');
	  
	  
	  if( $mailprofannu[0] == 'INEXISTANT DANS ANNUAIRE' ) {
			echo "<spane style='border-radius: 30px;font-size: 10px;background-color: red;color: white;padding: 4px;'> <i class='fa-solid fa-triangle-exclamation' style='display: inline !important;'></i> ".$mailprofannu[0]."</spane>";
	  }else {
			echo $mailprofannu[0];
	  }
	  
	  
      if( $mailprofannu[0] == "INEXISTANT DANS ANNUAIRE" ) { $cmp++ ; }
	  }
	  else{echo "pas de login";}
	   echo"   </td><td>" ;
     echo " <A class='abs2' href=".$URL."?del=".$id." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enseignant ?')\">";
     echo "Supp</A> - ";
     echo "<A class='abs' href=". $URL."?mod=".$id." >Détails</A>";
     echo"        </td> </tr>";
       }
	   
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export' class='bouton_ok' value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
  }
  }
mysql_close($connexion);
require('footer.php');
$cachePool = new FilesystemAdapter(
    $namespace = '',
    $defaultLifetime = 0,
    $directory = "/var/www/html/giqualite/symfony-cache/"
);

// 1. store string values
$cmp_cours = $cachePool->getItem('cmp_enseignants');
if (!$cmp_cours->isHit())
{
    $cmp_cours->set($cmp);
	$cmp_cours->expiresAfter(3600*24*15 );
    $cachePool->save($cmp_cours);
}else {
	$cmp_cours->set($cmp);
	$cmp_cours->expiresAfter(3600*24*15 );
    $cachePool->save($cmp_cours);
}

?>

</body>
</html>