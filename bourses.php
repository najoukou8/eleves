<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des bourses</title>
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

//on cree un tableau des id /libelles des universites
 $query = "SELECT * FROM universite";
   $result = mysql_query($query,$connexion ); 
while($univ=mysql_fetch_object($result)) {
     $tab_nom_uni[]=$univ->nom_uni;
     $tab_id_uni[]=$univ->id_uni;
	$tab_uni = array($tab_id_uni,$tab_nom_uni);
	//tableau associatif id/nom
	$tab_univ_a[$univ->id_uni]=$univ->nom_uni;
}

//si on vient de valider un ajout ou une modif il faut remmettre l'id univ ds le get_var
if ($_POST['id_univ_bourse']!=''){
$_GET['filtre_id']=$_POST['id_univ_bourse'];
}

if ($_GET['filtre_id']!=''){
$where=" where id_univ_bourse=".$_GET['filtre_id']." ";
$nom_univ=$tab_univ_a[$_GET['filtre_id']];
}else{
$where='';
$nom_univ='';
}


if ($_GET['env_orderby']=='') {$orderby= '';}
	else{
	$orderby=" order by ".urldecode($_GET['env_orderby']);
	if  ($_GET['env_inverse']!="1"){
                  $orderby=$orderby." desc";}
	}


   //seules les personnes autorisées ont acces à la liste
if(in_array($login,$ri_user_liste)){
	$affichetout=1;
}else
	{$affichetout=0;
	}

$URL =$_SERVER['PHP_SELF'];;
$table="bourse";
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
 if(in_array($login,$ri_user_liste)){
   if($_POST['libel_bourse']!='' ) {
 $_POST['modifpar']=$login;
 //pb des dates mysql
 //pour les dates


foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="id_bourse"){
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
    $message = "Fiche <b>".$_POST['id_bourse']." - ";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 

    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez donnez un nom ! : Recommencez !");

	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$ri_user_liste)){
 

	 //et qu'une offre de stage n'y est pas rattachée non plus 
   $query = "DELETE FROM $table"
      ." WHERE id_bourse=".$_GET['del']."";
     // echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
   
      else{
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$ri_user_liste)){
 //pour modifpar
$_POST['modifpar']=$login;
//pour les dates

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="id_bourse"){
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
   $query .= " WHERE id_bourse=".$_POST['id_bourse']." ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['id_bourse']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>seul le   service des relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where id_bourse=".$_GET['mod']." order by libel_bourse ";
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

    echo"<input type='hidden' name='id_bourse' value=\"$id_bourse\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
  //on met en hidden le id_univ
echo"<input type='hidden' name='id_univ_bourse' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
      echo affichechamp('Intitulé de la bourse','libel_bourse',$libel_bourse,'','');
	  echo affichechamp('Site Web','site_bourse',$site_bourse,'','');
	   echo "</tr><tr>";
    echo "<td colspan=2>commentaires bourses <br><textarea name='comm_bourse' rows=3 cols=70>".$comm_bourse."</textarea></td> ";		
 echo "</tr><tr>";
    echo affichechamp('modifié par','modifpar',$modifpar,'15',1);
    echo affichechamp('le','date_modif',$date_modif,'15',1);
    echo "</tr><tr>";
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
  //on met en hidden le id_univ
echo"<input type='hidden' name='id_univ_bourse' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
      echo affichechamp('Intitulé de la bourse','libel_bourse',$libel_bourse,'','');
	  echo affichechamp('Site Web','site_bourse',$site_bourse,'','');
	   echo "</tr><tr>";
    echo "<td colspan=2>commentaires bourses <br><textarea name='comm_bourse' rows=3 cols=70>".$comm_bourse."</textarea></td> ";		

    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT * FROM $table ";
   $query.=$where."  ".$orderby;
   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo" bourses de ".$nom_univ."</h2></center>  <BR>";}
else{
echo"<center> <h2>Il n'existe pas de bourses    ";
echo" pour $nom_univ</h2></center>  <BR>";}

echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] > Ajouter une bourse </a><br>";
echo"<br><br><a href=universites.php?mod=".$_GET['filtre_id'].">revenir à la fiche de ".$nom_univ. "</a>";
echo"<br><br><a href=universites.php>revenir à l'accueil</a>";
if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";

		    if   ($_GET['env_orderby']=='libel_bourse' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=libel_bourse&env_inverse=1&filtre_id=$_GET[filtre_id]>intitulé de la bourse</a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=libel_bourse&filtre_id=$_GET[filtre_id]>libel_bourse</a></th> ";}




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
	  
     if ($site_bourse!=''){
	        echo "<a href=".$site_bourse. ">".$libel_bourse."</a>" ;
	  }else{
      echo $libel_bourse ;}
      echo"   </td><td>" ;
      
     echo " <A href=".$URL."?del=".$id_bourse."&filtre_id=$_GET[filtre_id] onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette bourse ?')\">";
     echo "sup</A> - ";
     echo "<A href=". $URL."?mod=".$id_bourse."&filtre_id=$_GET[filtre_id]>détails</A>";
     echo"        </td> </tr>";
       }
	   
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
  }
  }
mysql_close($connexion);
?>
</body>
</html>