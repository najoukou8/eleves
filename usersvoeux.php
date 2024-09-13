<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<?
$texte_table='autorisations campagnes de voeux';
echo "<head>";
echo "<title>".$texte_table."</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";

require ("param.php");
require ("function.php");
require ("style.php");
require ("paramvoeux.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
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


$campagne_id_transmis='';
if (isset($_GET['numero_campagne'])  ) $numero_campagne_transmis=$_GET['numero_campagne'];
if ( isset($_POST['numero_campagne']) ) $numero_campagne_transmis=$_POST['numero_campagne'];
if (isset($_GET['ligne_user_voeux_vid'])  ) $campagne_id_transmis=$_GET['ligne_user_voeux_vid'];
if ( isset($_POST['ligne_user_voeux_vid']) ) $campagne_id_transmis=$_POST['ligne_user_voeux_vid'];
if (isset($_GET['idnumero_campagne'])  ) $idcle_campagne_transmis=$_GET['idnumero_campagne'];
if ( isset($_POST['idnumero_campagne']) ) $idcle_campagne_transmis=$_POST['idnumero_campagne'];
$login_autorises="voeux_liste".$numero_campagne_transmis;
$message='';
$sql1='';
$sql2='';
$where="";
if($campagne_id_transmis !='')
{
$where=" and ligne_user_voeux_vid ='".$campagne_id_transmis."'";}


$orderby= '';
$filtre='';
$table="ligne_user_voeux";
$cleprimaire='ligne_user_voeux_id';
$autoincrement='ligne_user_voeux_id';
$obligatoire1='ligne_user_voeux_vid';
$liste_champs_dates=array();
$liste_champs_tableau=array('ligne_user_voeux_uid','ligne_user_voeux_vid');
$tri_initial=$cleprimaire;
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
   //seules les personnes autorisées ont acces à la liste
if(in_array($login,$$login_autorises)){
	$affichetout=1;
}else
	{$affichetout=0;
	}
$URL =$_SERVER['PHP_SELF'];
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
 if(in_array($login,$$login_autorises)){
// test valeurs obligatoires
 if (!($_POST[$obligatoire1]==''  )){
 $_POST['modifpar']=$login;
//valeur par defaut et pb des dates mysql

foreach($champs as $ci2){
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
    else{//debut du else $login==
   echo "<center><b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$$login_autorises)){
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
   echo "<center><b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$$login_autorises)){
 
// test valeurs obligatoires
 if (!($_POST[$obligatoire1]==''  )){
 $_POST['modifpar']=$login;
//pour les dates

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 if (in_array($ci2,$liste_champs_dates)){
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
   $query .= " WHERE ".$cleprimaire."='".$_POST[$cleprimaire]."' ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['idsondage']." modifiée <br>";}
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
					  where ".$cleprimaire ." ='".$_GET['mod']."' ";
					 // echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   		   //on surcharge les dates pour les pbs de format
    if (in_array($ci2,$liste_champs_dates)){
 $$ci2=mysql_DateTime($universite->$ci2);
 }
   }
		$date_modif=mysql_Time($date_modif);
		//on récupère les champs liés             
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";
  //on met en hidden le id
 //   echo"<input type='hidden' name='idsondage' value=\"".$cleprimaire."\">   ";
  echo"<center>";
  echo"       <table><tr>  ";

if(in_array($login,$$login_autorises)){
     //echo affichechamp('Id','idsondage',$idsondage,'','');
	 echo "</tr><tr>";
	 }
	 foreach ($champs as $unchamps)
	 {
	 	 if ($unchamps == $autoincrement){
			 echo affichechamp($unchamps,$unchamps,$$unchamps,'','1');	
			 }
			 else{
			 echo affichechamp($unchamps,$unchamps,$$unchamps,'','');	
			 }
    echo "</tr><tr>";	 
	 }
 

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
 echo"<input type='hidden' name= 'numero_campagne' value='".$numero_campagne_transmis."' >";	
 echo"<input type='hidden' name= 'idnumero_campagne' value='".$idcle_campagne_transmis."' >";	
    echo"<center>";
  echo"       <table><tr>  ";
  
     foreach ($champs as $unchamps)
	 {
		 // on n'affiche pas le auto inc ni date_modif ni modifpar
		 if ($unchamps != $autoincrement and $unchamps != 'date_modif' and $unchamps != 'modifpar' )
		 {
			 if($unchamps == 'ligne_user_voeux_vid' and $campagne_id_transmis!='')
			 {
		  echo"<input type='hidden' name= 'ligne_user_voeux_vid' value='".$campagne_id_transmis."' >";	 
			 }
			 else
			 {
			// echo affichechamp($unchamps,$unchamps,'','','');	
			echo  affichemenusqlplusnc('personne à autoriser','ligne_user_voeux_uid','uid_prof','select * from enseignants order by nom','nom','',$connexion,'prenom');

			 }
			 
			echo "</tr><tr>";
		}		
	 }

   
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;

  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT * FROM $table  left outer join enseignants on enseignants.uid_prof =ligne_user_voeux.ligne_user_voeux_uid  where 1 ";
   $query.=$where."  ".$orderby;
  // echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo " ".$texte_table ."de la campagne : " .$campagne_id_transmis."</H2>";}

 if( in_array($login,$$login_autorises)){
echo "<A href=".$URL."?add=1&ligne_user_voeux_vid=".$campagne_id_transmis."&numero_campagne=".$numero_campagne_transmis."&idnumero_campagne=".$idcle_campagne_transmis."> Ajouter une autorisation </a><br>";
}
echo"<br><br><a href=configvoeux.php?mod=".$idcle_campagne_transmis.">revenir à la configuration de la campagne</a>";
if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";


        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
		echo "<th>Nom</th>";


//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";
}
$csv_output .= "\n";
while($universite=mysql_fetch_object($result)) {

 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   if (in_array ($ci2 ,$liste_champs_dates))
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
		// on ecrit chaque ligne
		      echo"   </tr><td>" ;	
			 echo  $universite->nom ." ".$universite->prenom;

      echo"   </td><td>" ; 		  
		// foreach($liste_champs_tableau as  $colonne)
		// {
   
      // echo $$colonne ;
      // echo"   </td><td>" ;    
       // }
	   	    if(in_array($login,$$login_autorises)){
     echo " <A href=".$URL."?del=".$$cleprimaire."&ligne_user_voeux_vid=".$campagne_id_transmis."&numero_campagne=".$numero_campagne_transmis."&idnumero_campagne=".$idcle_campagne_transmis." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";
	 }
     //echo "<A href=". $URL."?mod=".$$cleprimaire." >détails</A>";
	        echo"</td> </tr>";
	   }

	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 //echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
// echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
  }
  }
mysql_close($connexion);
?>
</body>
</html>