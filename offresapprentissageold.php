<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<?
//attention il ne doit pas y avoir de nom de colonnes identiques
// il doit y avoir un index unique (auto incrémental ou pas ) dans chaque fichier
// si on a un seul fichier laisser les infos $cleetrangere $table2  $cleprimaire2 à vide
// si on veut auroriser tout le monde laisser des array vides 
//---paramètres à configurer

require ("style.php");
require ("param.php");
require ("function.php");
$texte_table='Offres';
$table="apprentissageoffres";
$cleprimaire='off_idOffre';
$autoincrement='off_idOffre';
$cleetrangere='';
$table2="";
$cleprimaire2='';
$login_etudiants=array();
$liste_champs_lies=array('nom','prenom');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout=array('nom','prenom');
$champsobligatoires=array();
$liste_champs_dates=array('off_dateSaisie');
$liste_champs_tableau=array('off_idOffre','off_Entreprise','off_ville','off_pourvue','off_refOffre');
$tri_initial=$cleprimaire;


$pageaccueil='default.php';

//---fin de configuration

echo "<head>";
echo "<title>".$texte_table."</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";
echo "</HEAD><BODY>" ;
// On se connecte à mysql
$connexion =Connexion ($user_sql, $password, $dsn, $host);
// On récupère la liste des logins /noms des étudiants
$result = mysql_query("select * from apprentissageetudiants");	
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {
      $login_etudiants[]= $row["etu_login"];
	  $nom_etudiants[$row["etu_login"]]=$row["etu_nom"];
	  $prenom_etudiants[$row["etu_login"]]=$row["etu_prenom"]	;  
	  
   }
}

$login_autorises=array_merge($ipid_user_liste,$login_etudiants);
$login_autorises_ajout=array_merge($ipid_poweruser_liste,$login_etudiants);
$login_autorises_suppression=$ipid_poweruser_liste;
$login_autorises_modif=$ipid_poweruser_liste;
$login_autorises_export=$ipid_user_liste;
$login_autorises_admin=$ipid_user_liste;
//print_r($login_autorises);



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

if (!isset($_POST['bouton_ajout_mot'] )) $_POST['bouton_ajout_mot'] ='';
if (!isset($_POST['bouton_supp_mot'])) $_POST['bouton_supp_mot']='';

if (!isset($_POST['choixmot'])) $_POST['choixmot']='';
$message='';
$sql1='';
$sql2='';
$where='';
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
	
   //seules les personnes autorisées ont acces à la liste
if(in_array($loginConnecte,$login_autorises) or empty($login_autorises) ){
	$affichetout=1;
}else
	{$affichetout=0;
	  echo affichealerte(" Vous n'êtes pas autorisé à consulter cette page");
	}
$URL =$_SERVER['PHP_SELF'];
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

}



// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si autorisé
if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
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
 elseif($ci2==$autoincrement or $ci2=='off_pourvue')
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
   $message .= "</B> ajoutée !<br>";
    // si c'est un étudiant qui a ajouté  on envoie un mail à la gestionnaire
   if ( in_array($loginConnecte,$login_etudiants))
		   {

			   //echo "on envoie un mail à la gestionnaire";
			   $objet = "Ajout   d'une offre " ;
			$messagem = "\n"."".$prenom_etudiants[$login]." " .$nom_etudiants[$login]." vient d'ajouter une offre pour l'entreprise ".$_POST['off_Entreprise'] ." \n" ;
			$messagem .= "\n"."Voici son descriptif :". str_replace("''","'",stripslashes($_POST['off_descriptif']))." \n" ;			
			//$messagem .= "\n Pour accéder à la fiche de l'offre :  ".$serveur."offresapprentissage.php?mod=".$_POST['com_idOffre']." \n" ;
			 envoimail($ipidmail,$objet,$messagem); 
			 //envoimailori($ipidmail,$objet,$messagem);  			 
			   
		   }  
   
   
   }
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 
    }
   else{   // fin du nom=''
    echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
    }
    else{//debut du else $loginConnecte==
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $loginConnecte ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
   $query = "DELETE FROM $table"
      ." WHERE ".$cleprimaire."='".$_GET['del']."'";
   //  echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
    // il faut aussi supprimer les lignes mots qui font référence à cette offre
    $query = "DELETE FROM apprentissagelignemots"
      ." WHERE lig_idOffre ='".$_GET['del']."'";
   //  echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message .= "liaison(s) des mots clés de cette fiche num <b>".$_GET['del'];
   $message .= "</b> supprimée(s) <br>!";
   }  
   }
      else{
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $loginConnecte == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif)or $_POST['modifpar']==$login){
 
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


// ----------------------------------Ajout multiple  de  mots
if($_POST['bouton_ajout_mot']!='' ) {
	// pour réafficher la fiche en modif 
$_GET['mod']=	$_POST['off_idOffre'];
if (isset($_POST['code_motclef'])) {
 $var=$_POST['code_motclef'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-mot
	{
    $query = "INSERT INTO apprentissagelignemots (lig_idOffre,lig_idMot) ";
   $query .= " VALUES('".$_POST['off_idOffre']."','".$var[$i]."')";
   //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
  if ($result){

   $messagem = "</b>mot  ajouté à l'offre <br>";


   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>L ajout du mot clef n'est pas enregistrée</b> </center>";
    }
}//fin du for
	
echo $messagem;
}

				else{ echo"<center><b>vous n'avez pas sélectionné de mot clef</b>, Recommencez !<br>";}
}
	 
// ----------------------------------suppression  multiple  de  mots
if($_POST['bouton_supp_mot']!='' ) {
	
// pour réafficher la fiche en modif 
$_GET['mod']=	$_POST['off_idOffre'];
if (isset($_POST['membres'])) {
 $var=$_POST['membres'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-mot
	{
    $query = "DELETE FROM apprentissagelignemots  ";
   $query .= " WHERE lig_idOffre ='".$_POST['off_idOffre']."' and lig_idMot='".$var[$i]."'";
   //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
  if ($result){

   $messagem = "</b>mot  supprimé  à l'offre <br>";


   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>La suppression  du mot clef n'est pas enregistrée</b> </center>";
    }
}//fin du for
	
echo $messagem;
}

				else{ echo"<center><b>vous n'avez pas sélectionné de mot clef</b>, Recommencez !<br>";}
				
}
	 






if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''  ){
  //------------------------------------c'est kon a cliqué sur le lien details
    // on récupère les mots clefs dans un tableau 
$indMotclef=array();	
$libelleMotclef=array();
$indMotclefOffre=array();
     $sqlquery="SELECT * FROM apprentissagemotsclef order by mot_libelle";
//echo $sqlquery2;
$resultat=mysql_query($sqlquery,$connexion ); 
while ($v=mysql_fetch_array($resultat)){
$ind=$v["mot_idMot"] ;	
$indMotclef[]=$v["mot_idMot"] ;
$libelleMotclef[$ind]=$v["mot_libelle"];
}
  
//On récupère les mots clés liés  
  // on récupère les mots clefs dans un tableau 
     $sqlquery2="SELECT apprentissagelignemots.*,apprentissagemotsclef.* FROM apprentissagelignemots left outer join apprentissagemotsclef
on 	 apprentissagelignemots.lig_idMot =apprentissagemotsclef.mot_idMot  where lig_idOffre  ='".$_GET['mod']."' ";
//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($w=mysql_fetch_array($resultat2)){
	
$ind2=$w["mot_idMot"] ;	
$indMotclefOffre[]=$w["mot_idMot"] ;
//$libelleMotclefOffre[$indMotclefOffre]=$v["mot_libelle"];
}
  
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
	 	 if ($unchamps == $cleprimaire or $unchamps == $cleetrangere or in_array($unchamps,$liste_champs_lies)){
		 // en lecture seule
		 echo affichechamp($commentaire,$unchamps,$$unchamps,'40','1');	
			 }
			 elseif($unchamps =='off_descriptif'){
			 echo "<td >$commentaire<br><textarea name='".$unchamps."' rows=6 cols=65>".$$unchamps."</textarea></td> ";		
			 }			 

			 elseif($unchamps =='off_pourvue'){
			 echo afficheradio($commentaire,$unchamps,$listeouinon,$$unchamps,'','');	
			 }			 
			 
			 else{
			 echo affichechamp($commentaire,$unchamps,$$unchamps,'40','');	
			 }
			 echo "</tr><tr>";	
		 }
 
	 }
  echo "</td></tr><tr><th colspan=6>";
    //on met en hidden la cle primaire - inutile si elle est déjà affichée
  //  echo"<input type='hidden' name='$cleprimaire' value=\"".$$cleprimaire."\">   ";

  
  
  
  
   if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif) or $modifpar==$login)
   {
  echo"<input type='Submit' name='bouton_mod' value='modifier'>";
  }
  echo"<input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
  
    // pour l'affichage/ajout des mots clefs
	echo "<center>";
    echo    "<form    method=post action=$URL name='ajoutenleve'> ";
	//on met l'id de l'offre en hidden pour l'ajout/supp de mots cles
	 echo"<input type='hidden' name='$cleprimaire' value=\"".$$cleprimaire."\">   ";
  echo "<table>";
  
echo"<td>";
echo sizeof($indMotclefOffre)." mots clefs pour cette offre:";
echo " <br>  <select name='membres[]' multiple size=5>  ";
 for($i=0;$i<sizeof($indMotclefOffre);$i++) {
 $temp= $indMotclefOffre[$i];
      echo "  <option  value=\"".$temp."\">";	
	    echo $libelleMotclef[$temp];
    echo"</option> " ;
 }
    echo"</select> " ;
  echo "</td><td>";
 // echo "test" ;print_r($indMotclefOffre);
 $non_membres=array_diff($indMotclef,$indMotclefOffre);
 
 echo  sizeof($non_membres)." mots clefs possibles :";
echo " <br>  <select name='code_motclef[]' multiple size=5>  ";
  foreach ($non_membres as $temp){
 if ($temp !=""){
      echo "  <option  value=\"".$temp."\">";
    echo $libelleMotclef[$temp];
    echo"</option> " ;
    }
 }
   echo"</select> " ;
  echo "</td><td>";
 
  
    echo "</table>";
	   echo"<input type='Submit' name='bouton_ajout_mot' value='ajouter mot clef'>";
	   echo"<input type='Submit' name='bouton_supp_mot' value='supprimer mot clef'>";
	echo "</form>";
		echo "</center>";
      
	 }

	 
	 
	 
	 
 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 
   foreach($champsSingle as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		
		
  echo    "<form method=post action=$URL> ";
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
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
	 // si on a une table liée
	  if ($unchamps == $cleetrangere ){
	       echo affichemenusqlplus($commentaire,$unchamps,$cleprimaire2,'select * from '.$table2,$liste_champs_lies_pour_formulaire_ajout[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout[1]);
	  }
	  			 elseif($unchamps =='off_descriptif'){
			 echo "<td >$commentaire<br><textarea name='".$unchamps."' rows=6 cols=65 placeholder=\"saisissez ici le descriptif de l'offre :\"></textarea></td> ";			
			 }	
	 // on n'affiche pas le auto inc ni date_modif ni modifpar
	 elseif ($unchamps != $autoincrement and $unchamps != 'date_modif' and $unchamps != 'modifpar' and $unchamps != 'off_pourvue' ){
     echo affichechamp($commentaire,$unchamps,'','40','');	
	 }
    echo "</tr><tr>";	 
	 }

   
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;

  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage

if($_POST['choixmot']=='')
{
$query = "SELECT * FROM $table where 1 ";
}	
else {
      $query = "SELECT distinct apprentissageoffres.* FROM apprentissagelignemots 
	  left join apprentissagemotsclef on apprentissagemotsclef.mot_idMot = apprentissagelignemots.lig_idMot
	  left join apprentissageoffres on apprentissageoffres.off_idOffre = apprentissagelignemots.lig_idOffre
	   where lig_idMot= '".$_POST['choixmot']."'";
}	
// pour les etudiants on filtre les offres pourvues
if(!in_array($loginConnecte,$login_autorises_modif)) $where=" and off_pourvue != 'oui' ";
//echo $query;
   $query.=$where."  ".$orderby;
 // echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
//if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo " ".$texte_table ."</H2>";
//}
if(in_array($loginConnecte,$login_autorises_admin) or empty($login_autorises_admin)){
echo "<A href=motscleapprentissage.php> Gestion des mots clés </a><br>";
echo "<A href=etudapprentissage.php> Gestion des étudiants</a><br>";
}
echo "<br>";
if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1> Ajouter une offre </a><br>";
}
echo"<br><br><a href=".$pageaccueil.">revenir à l'accueil</a>";
echo"<BR><table border=1> ";
     echo    "<form method=post action=$URL> ";
echo  affichemenusqlplusncsubmit('choisissez un mot clé pour filtrer la liste','choixmot','mot_idMot','select * from  apprentissagemotsclef  order by mot_libelle','mot_libelle',$_POST['choixmot'],$connexion);
echo "</form> ";

if ($nombre>0){

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
	
	// il faut récupérer le nombre de commentaires associés à l'offre
	$query2 = "SELECT * FROM apprentissagecomment  where  	com_idOffre =".$u->off_idOffre." ";
	//echo 	$query2."<br>";
	   $result2 = mysql_query($query2,$connexion );
	   $nombreCommentaires=mysql_num_rows($result2);

	// il faut récupérer le nombre de docs associés à l'offre
	$query2 = "SELECT * FROM apprentissagedocuments  where  	doc_idOffre =".$u->off_idOffre." ";
	//echo 	$query2."<br>";
	   $result2 = mysql_query($query2,$connexion );
	   $nombreDocs=mysql_num_rows($result2);	   
	   
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
		//if (1)
		//	{
			  echo $$colonne ;
			  echo"   </td><td>" ;
		//	}	 
		//else
		//	{
		//	echo $tableau_champs_lies[$colonne][$$cleetrangere];
		//	echo"   </td><td>" ;
		//	}
		
       }
	if((in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)) and $nombreCommentaires==0 and $nombreDocs ==0 ){
     echo " <A href=".$URL."?del=".$$cleprimaire." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";

	 }
	 	  echo "<A href=". $URL."?mod=".$$cleprimaire." >Détails -</A>";
		   echo" </td><td>";

     echo "<A href=commentapprentissage.php?offre=".$$cleprimaire." >Commentaires(".$nombreCommentaires. ") -</A>";	 

		  echo" </td><td>";
	  
     echo "<A href=documentapprentissage.php?offre=".$$cleprimaire." >Docs(".$nombreDocs. ").</A>";	 	 

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
