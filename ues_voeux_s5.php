<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>

<html>

<head>
<title>gestion des ues </title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?


require ("param.php");
require ("function.php");
require ("style.php");
require ("paramvoeux.php");

echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

//On se connecte plus à ksup la table METATAG a été ajoutée 

// $dsnksup="GINP_DB";
// $usernameksup="metatag";
// $passwordksup="AUs4Rrp9";
// $hostksup="ksup6-inpg.grenet.fr";
// $connexionksup =Connexion ($usernameksup, $passwordksup, $dsnksup, $hostksup);
//on remplit 1 tableau de correspondance  les codes apogee/-code ksup
$sqlquery2="SELECT META_CODE, META_LIBELLE_FICHE,ID_METATAG FROM METATAG WHERE META_CODE_RUBRIQUE LIKE 'GENIE_FOR%' AND META_LIBELLE_OBJET LIKE 'cours'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$fiche_code_ksup[$v["META_CODE"]]=$v["ID_METATAG"];
}
$fiche_code_ksup['']='';
//mysql_close($connexionksup);





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
if (!isset($_GET['voeuxS5idCampagne'])) $_GET['voeuxS5idCampagne']='';


//pour recuperer les parametres en GET depuis les sous formulaires (POST )
if (isset($_POST['voeuxS5idCampagne'] )){$_GET['voeuxS5idCampagne'] = $_POST['voeuxS5idCampagne'];}
if ($_GET['voeuxS5idCampagne']!='')
{
	$filtre="&voeuxS5idCampagne=".$_GET['voeuxS5idCampagne']."&";
	//$filtre='';
}
	else
	$filtre='';
// pour récupérer le numero de la campagne à partir de voeuxS5idCampagne
$query="select * from param_voeux where idsondage = '".$_GET['voeuxS5idCampagne']."'";

$result = mysql_query($query,$connexion);
$nombre= mysql_num_rows($result);
// si nombre different de 1 pb 
  if ($nombre!=1){ 
echo "Erreur de paramètre, recommencez<br>";
  }
  else
  // c'est OK
  {
$w=mysql_fetch_object($result);
 $numero_campagne= $w->numero_campagne ;
 
 // on affecte le bon numero aux paramètres
// if($numero_campagne != 6)
 //{
$texte_explic_type_ue='liste_type_ue'.$numero_campagne;
$liste_type_ue=$$texte_explic_type_ue;
$texte_explic_liste_code_couleur_conflit='liste_code_couleur_conflit'.$numero_campagne;
$liste_code_couleur_conflit=$$texte_explic_liste_code_couleur_conflit;
$texte_explic_cours='table_cours'.$numero_campagne;
$table_cours=$$texte_explic_cours;
 //}
 
 
 
 
$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}



$message='';
$sql1='';
$sql2='';
$where='';
//$filtre='';

if ($_GET['env_orderby']=='') {$orderby='ORDER BY code_ue';}
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
$temp="voeux_liste".$numero_campagne;
if(in_array($login,$$temp)){
	$affichetout=1;
}else
	{$affichetout=0;
	}

$URL =$_SERVER['PHP_SELF'];;
$table="voeux_s5_ues";
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
$temp="voeux_liste".$numero_campagne;
if(in_array($login,$$temp)){
   if($_POST['code_ue']!='' ) {
 $_POST['modifpar']=$login;
 //pb des dates mysql
 //pour les dates


foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=='voeuxS5id'){
 //on ne fait rien
 }
 //elseif ($ci2=="date_modif"){
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
    $message = "Fiche <b>".$_POST['code_ue']." - ";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 

    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez donnez au moins un code UE ! : Recommencez !");

	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
$temp="voeux_liste".$numero_campagne;
if(in_array($login,$$temp)){
 // on vérifie les voeux atachés à cette ue
 
    $query = "select * FROM ligne_voeux_ues5 
	left outer join `".$table_cours."` on ligne_voeux_ues5.ligvs5_code_ue =`".$table_cours."`.CODE
	LEFT OUTER JOIN annuaire ON ligne_voeux_ues5.ligvs5_login = annuaire.`UId`"
      ." WHERE ligvs5_code_ue='".$_GET['codeUE']."' and ligvs5_jetons > 0 and ligvs5_code_idsondage ='".$_GET['voeuxS5idCampagne']."'";
     //echo $query;
   $result = mysql_query($query,$connexion);
   // pour chaque voeu on envoie un mail à l'étudiant 
   
   echo "<center>il y avait  " . mysql_num_rows($result) ." voeux passés sur cette ue  </center><br>";
 echo "on efface ce choix et on envoie un mail à chaque étudiant concerné<br>";

while($u=mysql_fetch_object($result)) {

   $query2 = "DELETE FROM ligne_voeux_ues5 "
      ." WHERE ligvs5_code_ue='".$u->ligvs5_code_ue."' and ligvs5_login='".$u->ligvs5_login. "' and ligvs5_code_idsondage ='".$_GET['voeuxS5idCampagne']. "'";
 $result2 = mysql_query($query2,$connexion);
  if($result2){
		$messagem = " Attention vous aviez fait un voeu pour l'UE ". $u->LIBELLE_COURT ." qui vient d'être supprimée de la liste des choix possibles\n";
		$messagem .= "Il va falloir modifier vos choix\n";
		$messagem .=  "Accédez à  : https://web.gi.grenoble-inp.fr/etud-auth/   pour modifier mes voeux \n";
		$messagem .=  "destinataire de ce mail ".$u->$myannuairemail_effectif."\n";
		$objet = "Choix de voeux  : suppresion d'une UE  " ;
		// On envoi l’email
		// pas a l'étudiant car phase de test
		//envoimail($u->$myannuairemail_effectif,$objet,$messagem);
		envoimail('marc.patouillard@grenoble-inp.fr',$objet,$messagem); 
		//envoimail('fabien.mangione@grenoble-inp.fr',$objet,$messagem); 
				}
	}
 
   $query = "DELETE FROM $table"
      ." WHERE voeuxS5id='".$_GET['del']."' and  voeuxS5idCampagne = '".$_GET['voeuxS5idCampagne']."'";
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
$temp="voeux_liste".$numero_campagne;
if(in_array($login,$$temp)){
 //pour modifpar
$_POST['modifpar']=$login;
//pour les dates

foreach($champs as $ci2){
//echo $ci2."<br>";
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par mysql
 if ($ci2=='voeuxS5id'){
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
   $query .= " WHERE voeuxS5id='".$_POST['mod']."' ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['mod']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>Accès réservé</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==
} //fin du if
if($_GET['mod']!=''  ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where voeuxS5id='".$_GET['mod']."'" ;
					  //echo $query;

  $result = mysql_query($query,$connexion );
$u=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$u->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		$date_modif=mysql_Time($date_modif);
//$date_fin= preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $date_fin);
		//on récupère les champs liés
     
         

     echo    "<form method=post action=$URL> ";
echo"<input type='hidden' name='mod' value=".$voeuxS5id." >";
echo"<input type='hidden' name='voeuxS5idCampagne' value=".$_GET['voeuxS5idCampagne']." >";
    //echo"<input type='hidden' name='id_bourse' value=\"$id_bourse\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
 
           echo affichechamp('code UE','code_ue',$code_ue,'',1);
	  echo affichemenuplus2tab('type ue','type_ue',$liste_type_ue6,$liste_type_ue,$type_ue);
	  	  echo affichemenu('conflit edt','conflit_edt_ue',$liste_code_couleur_conflit,$conflit_edt_ue);
	 // echo affichechamp('conflit edt','conflit_edt_ue',$conflit_edt_ue,'','');	
    echo "</tr><tr>";	  
    echo affichechamp('modifié par','modifpar',$modifpar,'15',1);
    echo affichechamp('le','date_modif',$date_modif,'15',1);
    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'><input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo "</table>";
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
  echo"<input type='hidden' name='voeuxS5idCampagne' value=".$_GET['voeuxS5idCampagne']." >";
  //echo "test".$_GET['voeuxS5idCampagne'];
    echo"<center>";
  echo"       <table><tr>  ";

      //echo affichechamp('code UE','code_ue',$code_ue,'','');
	  echo affichemenusqlplusnc('code UE','code_ue','CODE','select * from cours order by CODE','CODE',$code_ue,$connexion,'LIBELLE_LONG');
	  echo affichemenuplus2tab('type ue','type_ue',$liste_type_ue6,$liste_type_ue,$type_ue);
	  	  echo affichemenu('conflit edt','conflit_edt_ue',$liste_code_couleur_conflit,$conflit_edt_ue);
   	

    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo "</table>";
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage

$where = " and  voeuxS5idCampagne = '".$_GET['voeuxS5idCampagne']."'";
// pour le choix d'ue de rattrapage (14) il faut pointer vers les cours de l'année précédente
// on utilise la variable instanciée $table_cours


   $query = "SELECT * FROM $table left outer join `".$table_cours."` on $table.code_ue=`".$table_cours."`.CODE where 1   ";

   $query.=$where."  ".$orderby;
 //  echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo" UES pour campagne $numero_campagne </h2></center>  <BR>";}
else{
echo"<center> <h2>Il n'existe pas d'UEs saisies </h2></center>  <BR>   ";
}

echo "<A href=".$URL."?add=1&voeuxS5idCampagne=".$_GET['voeuxS5idCampagne'].$filtre." > Ajouter une UE </a><br>";
echo"<br><br><a href=voeuxadmin".$numero_campagne.".php>revenir </a>";
if ($nombre>0){
echo"<BR><table border=1> ";
echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
echo "<th></th>";
echo afficheentete('Code ue','code_ue',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo "<th>libellé UE</th>";
echo afficheentete('type ue','type_ue',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('conflit edt','conflit_edt_ue',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";}
$csv_output .= "\n";
while($u=mysql_fetch_object($result)) {

 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$u->$ci2;
   $csv_output .= $u->$ci2.";";
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format

		//on récupère les champs liés
     $libelle_ue=$u->LIBELLE_COURT;
	 
	 //$modifpar=odbc_result($result,"modifpar") ;
      echo"   <tr><td>" ;  
	  if(array_key_exists ($code_ue ,$fiche_code_ksup ))
	  {
	  if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$code_ue].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
	  }
	  else 
	  {
	  echo "n'existe pas dans ksup";
	  }
	 echo"   </td><td>" ;
  	echo $code_ue;	
  echo"   </td><td>" ;
  	echo $libelle_ue;	
      echo"   </td><td>" ;
  	echo $type_ue;
      echo"   </td><td>" ;
	echo $conflit_edt_ue;
      echo"   </td><td>" ;	  
     echo " <A href=".$URL."?del=".$voeuxS5id."&codeUE=".$code_ue.$filtre."  onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet élément ?')\">";
     echo "sup</A> - ";
     echo "<A href=". $URL."?mod=".$voeuxS5id.$filtre." >détails</A>";
     echo"        </td> </tr>";
       }
	   
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
  }
  }
  }// fin du  if ($nombre!=1){ 
mysql_close($connexion);
?>
</body>
</html>