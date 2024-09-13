<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des voeux 13</title>
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
if (!isset($_GET['mod_evalue'])) $_GET['mod_evalue']='';
if (!isset($_POST['mod_evalue'])) $_POST['mod_evalue']='';
if (!isset($_POST['fromstage'])) $_POST['fromstage']='';
if (!isset($_GET['fromstage'])) $_GET['fromstage']='';
if (!isset($_POST['code_etu'])) $_POST['code_etu']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_POST['id_stage'])) $_POST['id_stage']='';
if (!isset($_GET['filtre_id'])) $_GET['filtre_id']='';
if (!isset($_GET['commvalid'])) $_GET['commvalid']='';
if (!isset($_POST['gipCommentaireValide'])) $_POST['gipCommentaireValide']='';
if (!isset($_POST['validallcom'])) $_POST['validallcom']='';

$message='';
$sql1='';
$sql2='';
$filtre='';
$listeouinon=array('oui','non') ;
$affichetout=1;


//on remplit 2 tableaux avec les noms-codes  etudiants
$sqlquery2="SELECT * FROM etudiants  order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind2=$v["Code etu"];
$tabcodeetu[]=$ind2;
//on remplit un tableau indice avec les noms etudiants
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Prénom 1"];
}

// on crée le tableau des groupes GIP
// les groupes GIP doivent être nommés GIP-01 GIP-02 GIP-03 ......
$query3="select substr(groupes.libelle,5,2) as gpegip, code_etudiant from ligne_groupe
left outer join groupes on groupes.code=ligne_groupe.code_groupe
 where groupes.libelle like 'GIP-%' ";
 $result3 = mysql_query($query3,$connexion );
	$tabEtuCodeGipCode=array();
	$tabGipCodeEtuCode=array();
  if (mysql_num_rows( $result3)!=0){
 while($r=mysql_fetch_assoc($result3))
	{
	$tabEtuCodeGipCode[$r['gpegip']][]=$r['code_etudiant'];
	
	$tabGipCodeEtuCode[$r['code_etudiant']]=$r['gpegip'];
	
	}
}
else
{
echo 'erreur pas de groupe GIP dans la base élèves';
}
//print_r($tabGipCodeEtuCode);
//print_r($tabEtuCodeGipCode);

// verif si c un etudiant
//si on vient de valider un ajout ou une modif il faut remmettre l'id univ ds le get_var
$where="where etudiants_scol.annee like '".$gpecible13."%' ";
//$nom_univ='';

$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

if ($_GET['env_orderby']=='') {$orderby='ORDER BY gpegip,etudiants.Nom';}
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
if(in_array($login,$voeux_liste13)){

	//pour le moment ok pour tous
	//$affichetout=1;

$URL =$_SERVER['PHP_SELF'];;
$table="gipevaluations";
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




$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si admin ent ou si on vient de creation de stage
 if(1){
 // on efface 
   $query = "delete from giptabmalus  where TabMalusIdEleve='".$_POST['codeEtudiant']."' and TabMalusIdCampagne ='".$idsondage13."'";

   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>";
   $message .= "</b> supprimée <br>!";
   }
 
 // on cree
  $query = "insert into giptabmalus  (TabMalusIdEleve,TabMalusIdCampagne,TabMalusNote,TabMalusDateModif,TabMalusModifpar)values (".$_POST['codeEtudiant'].",'".$idsondage13."',".$_POST['TabMalusNote'].",now(),'".$login."')";
//echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>";
   $message .= "</b> ajoutée <br>!";
   }
 
 
    }
    else{//debut du else $login==
   echo "<center><b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
}
//--------------------------------- Modif des commentaires
elseif($_POST['gipCommentaireValide']!='' and  $_POST['validallcom']){
$_GET['commvalid']=1;
 if(1){
 //pour modifpar
$_POST['gipModifPar']=$login;	
 //pb des dates mysql
 //pour les dates
   
   //pas de test si 2 fois le meme choix
   //if (!($_POST['v_voeux3']== $_POST['v_voeux2'] or $_POST['v_voeux3']== $_POST['v_voeux1'] or $_POST['v_voeux2']== $_POST['v_voeux1'] or $_POST['v_voeux1']=='9999' or $_POST['v_voeux2']=='9999'or $_POST['v_voeux3']=='9999' )) {
  if (1){
//	for ($i=0;$i<count($_POST['gipIdEvalue']);$i++)	 
//{
$sql1='';
$sql2='';
foreach($champs as $ci2){

	//ajoute ds le post les champs absents du formulaire
	if (!isset($_POST[$ci2])) $_POST[$ci2]='';
			 //tout ce cirque à cause des apostrophes des magics quotes
	 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));	
		if ($ci2!="gipCommentaireValide")
		{
		//on ne fait rien
		}
		else
		{
	 $sql1.= $ci2."='".$_POST[$ci2]."',";
	 }	 	
}
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
//if (!isset($ci2[$i])) $ci2[$i]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
//$ci2[$i]= str_replace("'","''",stripslashes($ci2[$i]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

#$sql1='gipIdEvaluateur,gipIdEvalue,gipNote1,gipNote2,gipNote3,gipNote4,gipCommentaire,gipDateModif';
#$sql2="'$gipIdEvaluateur[$i]','$gipIdEvalue[$i]',$gipNote1[$i],$gipNote2[$i],$gipNote3[$i],$gipNote4[$i],'$gipCommentaire[$i]',now()";
    $query = "UPDATE $table SET $sql1";
	   $query .= " WHERE gipIdEvaluateur=".$_POST['gipIdEvaluateur']." and gipIdEvalue=".$_POST['gipIdEvalue'] ." and gipIdCampagne='".$idsondage13."'";

 //echo $query;
      $result = mysql_query($query,$connexion);
       if ($result){
	   // la requete s'est bien enregistrée
   }
   else {
   echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 
//} // fin du for next 




   $okfiche=1;

    }
   else{   // fin du nom=''
    //echo affichealerte("Vous n'avez pas saisi tous les champs obligatoires! : Recommencez !");
    echo affichealerte("Vous avez saisi 2 voeux identiques ou bien vous avez laissé un choix vide! : Recommencez !");
	}
    }
	
   else{
   echo "<b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==
} //fin du if

elseif($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!='' and $_POST['bouton_annul']!='Annuler'){
  //------------------------------------c'est kon a cliqué sur le lien details
  $monGpe=recursive_array_search($_GET['mod'],$tabEtuCodeGipCode);
  //  on vérifie s'il y a déjà une fiche de voeu pour cet élève 
// et on les récupère
$query= "SELECT $table.*  FROM $table where gipIdEvaluateur='".$_GET['mod'] ."'and gipIdCampagne='".$idsondage13."'";
//echo $query ;
$result=mysql_query($query,$connexion);
while($y=mysql_fetch_object($result)){
$gipCommentaire[$y->gipIdEvalue]=$y->gipCommentaire;
$gipCommentaireValide[$y->gipIdEvalue]=$y->gipCommentaireValide;
 $gipNote1[$y->gipIdEvalue]=$y->gipNote1;   
 $gipNote2[$y->gipIdEvalue]=$y->gipNote2;   
 $gipNote3[$y->gipIdEvalue]=$y->gipNote3;   
 $gipNote4[$y->gipIdEvalue]=$y->gipNote4;    
$date_modif_prec=mysql_Time($y->gipDateModif);
  
 }
  
  
 //on fait une boucle pour créer les variables issues de la table stage
 echo "<center><h1>$titrevoeux13<br>";
 //echo "Vous avez déjà créé une fiche de voeux le " .$date_modif_prec."<br>"; 
 //   echo "<br><b>Vous pouvez les modifier ci dessous</b>"; 
  echo"<center>";  
 // on affiche le formulaire 
echo    "<form name='tableaunote' method=post action=$URL> ";

  echo"<input type='hidden' name='v_modifpar' value=$login>";
  echo "<table>";
	 echo "</tr><tr>";
     echo affichechamp('nom évaluateur','nom',$etudiants_nom[$_GET['mod']],'50',1);
     echo affichechamp('prenom ','prenom',$etudiants_prenom[$_GET['mod']],'40',1);
	 echo "</tr><tr>";
	echo affichechamp('Date modification','affdatemodif',$date_modif_prec,'',1);
	  echo affichechamp('Date limite ','affdatelimite',$datelimitevoeux13,'10',1);

  echo "</table>";


echo "<table border=1>";
echo "<th>Nom évalué</th>";
foreach ($criteresGip as $criterelib)
{
echo "<th>".$criterelib."</th>";
}
echo "<th>commentaire</th>";
echo "<th>Commentaire<br>validé</th>";

foreach ($tabEtuCodeGipCode[$monGpe] as $codeEtu)
{
echo "<tr></tr>";
echo "<td>".$etudiants_nom[$codeEtu] ." " .$etudiants_prenom[$codeEtu]."</td>";

	
	echo"<input type='hidden' name='gipIdEvalue[]' value=\"".$codeEtu."\">";
	echo"<input type='hidden' name='gipIdEvaluateur[]' value=\"".$_GET['mod']."\">";	
	//echo"<input type='hidden' name='critere[]' value=\"".$criterelib."\">";		
		echo afficheonly ('',$appreciationsLibGip[array_search($gipNote1[$codeEtu],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($gipNote1[$codeEtu],$appreciationsNotesGip)]."'");
		echo afficheonly ('',$appreciationsLibGip[array_search($gipNote2[$codeEtu],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($gipNote2[$codeEtu],$appreciationsNotesGip)]."'");
		echo afficheonly ('',$appreciationsLibGip[array_search($gipNote3[$codeEtu],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($gipNote3[$codeEtu],$appreciationsNotesGip)]."'");		
		echo afficheonly ('',$appreciationsLibGip[array_search($gipNote4[$codeEtu],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($gipNote4[$codeEtu],$appreciationsNotesGip)]."'");		

	// echo affichemenuplus2tab ('','gipNote1[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote1[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote2[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote2[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote3[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote3[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote4[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote4[$codeEtu]);
	
	echo "<td ><textarea   name='gipCommentaire[]' rows=2 cols=30 readonly>".$gipCommentaire[$codeEtu]."</textarea></td>";
//	if ($gipCommentaire[$codeEtu]!="")
	//{
	//echo affichemenu('','gipCommentaireValide[]',$listeouinon,$gipCommentaireValide[$codeEtu]);
	//}
	//else
	//{

	    echo affichechamp('','gipCommentaireValide[]',$gipCommentaireValide[$codeEtu],'5',1);
	//}
	//echo affichemenu('','gipMalusNote[]',$bonusMalusNotesGip,$gipMalusNote[$codeEtu]);
}
echo "</tr><tr>";
  // echo "</td></tr><tr><th colspan=8><input type='Submit' name='bouton_mod' value='Valider'>";
echo"	<input type='Submit' name='bouton_annul' value='Revenir'>";
 echo "</th></tr>";             

echo "</table>";
//echo affichealerte('Patientez quelques instants après avoir cliqué sur Modifier');

echo    "</form > ";
	  }
	  }
	  

elseif($_GET['mod_evalue']!='' or $_POST['mod_evalue']!='' ){
$affichetout=0;
if($_GET['mod_evalue']!='' and $_POST['bouton_annul']!='Annuler'){
  //------------------------------------c'est kon a cliqué sur le lien afficher réponse pour un évalué
  $monGpe=recursive_array_search($_GET['mod_evalue'],$tabEtuCodeGipCode);

 
 //on fait une boucle pour créer les variables issues de la table stage
 echo "<center><h1>$titrevoeux13<br>";
 //echo "Vous avez déjà créé une fiche de voeux le " .$date_modif_prec."<br>"; 
 //   echo "<br><b>Vous pouvez les modifier ci dessous</b>"; 
  echo"<center>";  
 // on affiche le formulaire 
echo    "<form name='tableaunote' method=post action=$URL> ";

  echo"<input type='hidden' name='v_modifpar' value=$login>";
  echo "<table>";
	 echo "</tr><tr>";
     echo affichechamp('nom évalué ','nom',$etudiants_nom[$_GET['mod_evalue']],'50',1);
     echo affichechamp('prenom ','prenom',$etudiants_prenom[$_GET['mod_evalue']],'40',1);


  echo "</table>";

echo "<table border=1>";
echo "<th>Nom évaluateur</th>";
foreach ($criteresGip as $criterelib)
{
echo "<th>".$criterelib."</th>";
}
echo "<th>commentaire</th>";
echo "<th>Commentaire<br>validé</th>";
  //  on vérifie s'il y a déjà une fiche de voeu pour cet élève 
// et on les récupère
$query= "SELECT $table.*  FROM $table where gipIdEvalue='".$_GET['mod_evalue'] ."' and gipIdCampagne='".$idsondage13."'";
//echo $query ;
$result=mysql_query($query,$connexion);
while($y=mysql_fetch_object($result)){



echo "<tr></tr>";
echo "<td>".$etudiants_nom[$y->gipIdEvaluateur] ." " .$etudiants_prenom[$y->gipIdEvaluateur]."</td>";

	
	//echo"<input type='hidden' name='gipIdEvalue[]' value=\"".$codeEtu."\">";
	//echo"<input type='hidden' name='gipIdEvaluateur[]' value=\"".$_GET['mod']."\">";	
	//echo"<input type='hidden' name='critere[]' value=\"".$criterelib."\">";		
		echo afficheonly ('',$appreciationsLibGip[array_search($y->gipNote1,$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($y->gipNote1,$appreciationsNotesGip)]."'");
		echo afficheonly ('',$appreciationsLibGip[array_search($y->gipNote2,$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($y->gipNote2,$appreciationsNotesGip)]."'");
		echo afficheonly ('',$appreciationsLibGip[array_search($y->gipNote3,$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($y->gipNote3,$appreciationsNotesGip)]."'");		
		echo afficheonly ('',$appreciationsLibGip[array_search($y->gipNote4,$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($y->gipNote4,$appreciationsNotesGip)]."'");		

	// echo affichemenuplus2tab ('','gipNote1[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote1[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote2[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote2[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote3[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote3[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote4[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote4[$codeEtu]);
	
	echo "<td ><textarea   name='gipCommentaire[]' rows=2 cols=30 readonly>".$y->gipCommentaire."</textarea></td>";
	echo afficheonly ('',$y->gipCommentaireValide);
	//echo affichemenu('','gipMalusNote[]',$bonusMalusNotesGip,$gipMalusNote[$codeEtu]);
 }
echo "</tr><tr>";
   echo "</td></tr><tr><th colspan=8>";
  //<input type='Submit' name='bouton_mod' value='Valider'>";
echo"	<input type='Submit' name='bouton_annul' value='Revenir'>";
 echo "</th></tr>";             

echo "</table>";
//echo affichealerte('Patientez quelques instants après avoir cliqué sur Modifier');

echo    "</form > ";
	  }
	  }	  



	  
	  
	  
 elseif($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   
	$sqlquery2="SELECT * FROM giptabmalus where TabMalusIdEleve =  '".$_GET['add']."' and TabMalusIdCampagne='".$idsondage13."'";
	//echo $sqlquery2;
	$resultat2=mysql_query($sqlquery2,$connexion );
	  if (mysql_num_rows($resultat2)!=0)
	  { 
		while ($v=mysql_fetch_array($resultat2))
			{
			//on remplit un tableau indice avec les malus etudiants
			$etudiants_malus=$v["TabMalusNote"];
			$date_malus=mysql_Time($v["TabMalusDateModif"]);
			$modifpar_malus=$v["TabMalusModifpar"];
			}
	}
	else
	{
			$etudiants_malus=0;
			$date_malus='01/01/1901 00:00';
			$modifpar_malus='';
	}
		
		
  echo    "<form method=post action=$URL> ";
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";


  echo afficheonly("","Bonus Malus",'b' ,'h3');
	 echo "</tr><tr>";
	   echo"<input type='hidden' name='codeEtudiant' value=".$_GET['add'].">";
     echo affichechamp('nom ','nom',$etudiants_nom[$_GET['add']],'40',1);
     echo affichechamp('prenom ','prenom',$etudiants_prenom[$_GET['add']],'40',1);
	 echo "</tr><tr>";
	 if($date_malus != '01/01/1901 00:00')
	{	 
     echo affichechamp('date modif ','TabMalusDateModif',$date_malus,'30',1);
	 }
	 if($modifpar_malus != '')
	{	 
     echo affichechamp('modif par ','TabMalusModifpar',$modifpar_malus,'40',1);
	 }
	 echo "</tr><tr>";
echo affichemenu('Vous pouvez changer le Bonus/malus','TabMalusNote',$bonusMalusNotesGip,$etudiants_malus);
	
	      
		  echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='enregistrer'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }
if($_GET['commvalid']!='' ){
$affichetout=0;
if($_GET['commvalid']!='' and $_POST['bouton_annul']!='Annuler'){
  //------------------------------------c'est kon a cliqué sur le lien valider les commentaires

  //  on récupère les fiches avec commentaire non vide
// et on les récupère
$query= "SELECT $table.*  FROM $table where gipCommentaire !='' and  gipCommentaire is not null and gipIdCampagne='".$idsondage13."'";
//echo $query ;
$result=mysql_query($query,$connexion);
if (mysql_num_rows($result) >0)

{
 echo "<center><h1>$titrevoeux13<br>";
  echo "<center><a href=$URL>Revenir à l'accueil de l'évaluation</a>";
  echo"<center>";  
 // on affiche le formulaire 

  echo "<table>";
  
echo "<table border=1>";
echo "<th>GIP</th>";
echo "<th>Nom évaluateur</th>";
echo "<th>Nom évalué</th>";
foreach ($criteresGip as $criterelib)
{
echo "<th>".$criterelib."</th>";
}
echo "<th>commentaire</th>";
echo "<th>Commentaire<br>validé</th>";
// on remplit un tableau à partir des résultats de la requete , pour pouvoir trier par gip
while($y=mysql_fetch_object($result)){
$tabValidCommentaires[] = ['gip'=>$tabGipCodeEtuCode[$y->gipIdEvaluateur]
							,'evaluateur'=>$y->gipIdEvaluateur
							,'evalue'=>$y->gipIdEvalue												
							,'note1'=>$y->gipNote1
							,'note2'=>$y->gipNote2
							,'note3'=>$y->gipNote3
							,'note4'=>$y->gipNote4							
							,'commentaire'=>$y->gipCommentaire
							,'commentairevalide'=>$y->gipCommentaireValide					
							];

}
// Pour le tri , comme il s'agit d'un tableau à 2 dimensions
// on extrait dans un tableau la colonne du tri 
foreach ($tabValidCommentaires as $key => $row) {
    $gip[$key]  = $row['gip'];
}
// Trie les données par rang croissant
// Ajoute $tabValidCommentaires en tant que dernier paramètre, pour trier par la clé commune
array_multisort($gip, SORT_ASC, $tabValidCommentaires);

//print_r($tabValidCommentaires);
//$result=mysql_query($query,$connexion);
		$sauv_ordre='';
		$gipOrdre=0;
foreach ($tabValidCommentaires as $tabValidCommentaires) {
  	  $valcourante=$tabValidCommentaires['gip'];
	  					$gipOrdre++;
	  		  if ($sauv_ordre !=  $valcourante and  $gipOrdre>1){

					$sauv_ordre=$valcourante;
					//echo "</tr><td colspan=13 bgcolor='red'><tr>";
					echo "</tr><tr>";
					 //echo "</td></tr><tr><th colspan=9><input type='Submit' name='bouton_annul' value='Revenir'>";
					echo "</th></tr>";
					//echo"	<input type='Submit' name='bouton_mod' value='Enregistrer'> ";
					echo "<th>GIP</th>";
					echo "<th>Nom évaluateur</th>";
					echo "<th>Nom évalué</th>";
					foreach ($criteresGip as $criterelib)
					{
					echo "<th>".$criterelib."</th>";
					}
					echo "<th>commentaire</th>";
					echo "<th>Commentaire<br>validé</th>";					
             
			}
echo "<tr></tr>";
// debut du form sur une ligne
echo    "<form name='tableaunote' method=post action=$URL> ";

  echo"<input type='hidden' name='v_modifpar' value=$login>";
    echo"<input type='hidden' name='validallcom'' value=1>";
echo "<td>".$tabValidCommentaires['gip']."</td>";
echo "<td>".$etudiants_nom[$tabValidCommentaires['evaluateur']] ." " .$etudiants_prenom[$tabValidCommentaires['evaluateur']]."</td>";
echo "<td>".$etudiants_nom[$tabValidCommentaires['evalue']] ." " .$etudiants_prenom[$tabValidCommentaires['evalue']]."</td>";
	
	echo"<input type='hidden' name='gipIdEvalue' value=\"".$tabValidCommentaires['evalue']."\">";
	echo"<input type='hidden' name='gipIdEvaluateur' value=\"".$tabValidCommentaires['evaluateur']."\">";	
	//echo"<input type='hidden' name='critere[]' value=\"".$criterelib."\">";		
		echo afficheonly ('',$appreciationsLibGip[array_search($tabValidCommentaires['note1'],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($tabValidCommentaires['note1'],$appreciationsNotesGip)]."'");
		echo afficheonly ('',$appreciationsLibGip[array_search($tabValidCommentaires['note2'],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($tabValidCommentaires['note2'],$appreciationsNotesGip)]."'");
		echo afficheonly ('',$appreciationsLibGip[array_search($tabValidCommentaires['note3'],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($tabValidCommentaires['note3'],$appreciationsNotesGip)]."'");		
		echo afficheonly ('',$appreciationsLibGip[array_search($tabValidCommentaires['note4'],$appreciationsNotesGip)],'font',"font color='".$appreciationsNotesCouleursGip[array_search($tabValidCommentaires['note4'],$appreciationsNotesGip)]."'");		

	// echo affichemenuplus2tab ('','gipNote1[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote1[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote2[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote2[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote3[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote3[$codeEtu]);
	// echo affichemenuplus2tab ('','gipNote4[]',$appreciationsLibGip,$appreciationsNotesGip,$selection=$gipNote4[$codeEtu]);
	
	echo "<td ><textarea   name='gipCommentaire' rows=2 cols=30 readonly>".$tabValidCommentaires['commentaire']."</textarea></td>";
	//echo affichemenu('','gipCommentaireValide',$listeouinon,$tabValidCommentaires['commentairevalide']);
	echo affichemenu('','gipCommentaireValide',$listeouinon,$tabValidCommentaires['commentairevalide'],' onchange=\'submit()\' ');
	//echo affichemenu('','gipMalusNote[]',$bonusMalusNotesGip,$gipMalusNote[$codeEtu]);
	echo    "</form > ";
}
echo "</tr><tr>";
					//echo "</td></tr><tr><th colspan=9><input type='Submit' name='bouton_annul' value='Revenir'>";
					//echo"	<input type='Submit' name='bouton_mod' value='Enregistrer'> ";
 echo "</th></tr>";             

echo "</table>";
// echo affichealerte('Patientez quelques instants après avoir cliqué sur Modifier');
  echo "<center><a href=$URL>Revenir à l'accueil de l'évaluation</a>";

	  }
	  else
	  {
	   echo "<center><h1>pas de commentaire à valider<br>";
	   echo "<a href=voeuxadmin13.php> Revenir</a>";
	  }

	  }
	}		

if ($affichetout)  {
 // --------------------------------------sélection de toutes les fiches et affichage-------------------------------------
 echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;


  // $query.=$where."  ".$orderby;
    $query="SELECT  etudiants.Nom ,etudiants.`Prénom 1` ,etudiants.`Code etu` as codetu,etudiants.`Lib dac` as provenance , annuaire.`Mail effectif`  , departements.dep_libelle, substr(groupes.libelle,5,2) as gpegip,etudiants_scol.annee ,giptabmalus.*
FROM ligne_groupe
LEFT OUTER JOIN etudiants ON etudiants.`Code etu` = ligne_groupe.code_etudiant
LEFT OUTER JOIN groupes ON groupes.code = ligne_groupe.code_groupe
LEFT OUTER JOIN etudiants_scol ON etudiants_scol.code = etudiants.`Code etu`
LEFT OUTER JOIN annuaire ON upper( etudiants.`Code etu` ) = annuaire.`code-etu`
LEFT OUTER JOIN departements ON etudiants.`Nationalité` = departements.dep_code
LEFT OUTER JOIN giptabmalus ON concat(etudiants.`Code etu`,'".$idsondage13."')  = concat(giptabmalus.TabMalusIdEleve,giptabmalus.TabMalusIdCampagne)
 where groupes.libelle like 'GIP-%'";
//WHERE libelle = '".$gpecible13."' ";
      $query.="  ".$orderby;
  // echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
list($jour,$mois,$annee) = explode("/",$datelimitevoeux13);
$moins1jour = date("d/m/Y", mktime(0, 0, 0, date($mois), date($jour)-1,  date($annee)));
echo "<a href=default.php> Revenir à l'accueil<br><br></a>";
echo "<center>$titrevoeux13<br>";
if ($datedebutvoeux13!='')
{echo "date debut <b>$datedebutvoeux13</b>  ";}
echo "date fin <b>$moins1jour à 23h59</b>  ";
echo "<br>groupe cible: <b> $gpecible13 </b> ";
echo "</center>";
if ($nombre>0){

echo"<center> <h2>Liste des   ";
echo $nombre;
echo" élèves </h2></center>  ";}
else{
echo"<center> <h2>Il n'y a  pas d'inscrit pour l'instant   ";
echo" </h2></center>  ";}

echo "<a href=#bas> Pour envoyer un mail aux etudiants sans réponse</a>";

//echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] > Ajouter un voeu </a><br>";


if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br><Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
echo "<br><A href=". $URL."?commvalid=1>Afficher/Modifier  les commentaires<br></a>";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
//echo afficheentete('numero etu','v_num_etudiant',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('Nom','etudiants.Nom',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo"<th>Prénom</th>";
echo afficheentete('GIP','gpegip',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo"<th colspan=2>Bonus</th>";
//echo"<th>voeu1</th>";
//echo afficheentete('voeu1','v_voeux1',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo afficheentete('voeu2','v_voeux2',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo afficheentete('voeu3','v_voeux3',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo"<th>Commentaire</th>";
echo"<th>Réponses<br>de sa part</th>";
echo"<th>Réponses<br>le concernant</th>";
foreach($criteresGipAbreges as $critAbr)
{
echo"<th>Moy<br>". $critAbr."</th>";
}
echo"<th>Moy<br>Générale</th>";
echo"<th>Date rest</th>";
// on initialise les listes emails
$listemail='';
$listemail2='';
$j=0;
//on initialise  $csv_output
 $csv_output="";
 $csv_output .="Groupe".";"."Nom evaluateur".";"."prenom".";"."Nom evalue".";"."prenom".";"."id campagne".";";
 foreach($criteresGipAbreges as $critAbr)
{
  $csv_output .= $critAbr.";";
}
  $csv_output .="commentaire".";"."valid commentaire".";"."date modif".";"."date rest".";";
 //pour l'export en totalité au cas ou

$csv_output .= "\n";
// on parcourt la selection du groupe cible
		$sauv_ordre='';
while($universite=mysql_fetch_object($result)) {

	  $valcourante=$universite->gpegip;
	  		  if ($sauv_ordre !=  $valcourante){
		  $sauv_ordre=$valcourante;
		 	echo "</tr><td colspan=13 bgcolor='red'><tr>";
			}
//on récupère les champs liés
		$nom= $universite->Nom;
         $prenom= $universite->$myetudiantsprénom_1;
		 //$gprprincipal=	$universite->annee;
		$mail=$universite->$myannuairemail_effectif;
		$codeetu=$universite->codetu;
		$malus=$universite->TabMalusNote;
		$dateRest=mysql_DateTime($universite->TabMalusDateRest);
		if ($dateRest=='01/01/1901')$dateRest='';
// pour chaque eleve du groupe on recupere ses voeux
 // $query2="SELECT  voeux_eleves. *  FROM voeux_eleves WHERE v_id_sondage='".$idsondage13."' and v_num_etudiant='".$codeetu"'";
$query2= "SELECT $table.*  FROM $table where gipIdEvaluateur='".$codeetu ."' and gipIdCampagne='".$idsondage13."'";
$result2 = mysql_query($query2,$connexion ); 
$nombre2= mysql_num_rows($result2);
// si pas de voeux 
// on stocke les emails
if ($nombre2 == 0 and $mail !='' ){
			$listemail.=  $mail.",<br>";
			$listemail2.=  $mail.",";
			$j++;
			}
//echo $query2;
// on positionne à vide les variable de la table voeux
foreach($champs as $ci2){
   $$ci2='';
   }

		  // on cree les lignes du tableau
      echo"   <tr><td>" ;
	 // echo $v_num_etudiant;
	  	//  echo"   </td><td>" ;
		  echo 	 "<a href=fiche.php?code=".$codeetu.">".$nom."</a>";
	  	  echo"   </td><td>" ;
		  echo $prenom;
	  	  echo"   </td><td>" ;
		  echo $universite->gpegip;
		  	  	  echo"   </td><td align = center>" ;
		if ($malus !='')
			{
					  echo $malus ;
			}
			else
			{
			echo "non défini";
			}
	  	  echo"   </td><td>" ;
	  	 	echo " &nbsp;&nbsp;   <A href=". $URL."?add=".$codeetu.">Changer</A>";

   // on récupère les réponses DONNEES  par cet eleve
 
		while($u2=mysql_fetch_object($result2)) {

		 //on fait une boucle pour créer les variables issues de la table voeux et on leur affecte le resultat du select
		   foreach($champs as $ci2){
		   $$ci2=$u2->$ci2;
		   }
				  //pour l'export excel 
				$csv_output .=$universite->gpegip.";".$etudiants_nom[$gipIdEvaluateur].";".$etudiants_prenom[$gipIdEvaluateur].";".$etudiants_nom[$gipIdEvalue].";".$etudiants_prenom[$gipIdEvalue].";";
				   foreach($champs as $ci2){
		   //$csv_output .= $$ci2.";";
		   if ($ci2 != 'gipIdEvaluateur' and $ci2 != 'gipIdEvalue' and $ci2 != 'gipIdEvaluation' and $ci2 != 'gipModifPar')
				{
				$csv_output .= nettoiecsvplus($$ci2);
				}
		   }
				//$csv_output .=$gipNote1.";".$gipNote2.";".$gipNote3.";".$gipNote4.";".$gipCommentaire.";";
					$csv_output .= nettoiecsvplus($dateRest);
		   $csv_output .= "\n";

		  } // fin du while
		  
 // on récupère toutes les notes RECUES par cet eleve
				$tot1=0;
			   $tot2=0 ;
			   $tot3=0;
			   $tot4=0  ;
		  $query3= "SELECT $table.*  FROM $table where gipIdEvalue='".$codeetu ."' and gipIdCampagne='".$idsondage13."'";
$result3 = mysql_query($query3,$connexion ); 
$nombre3= mysql_num_rows($result3);
			while($u3=mysql_fetch_object($result3)) 
			{	  
			 //on fait une boucle pour créer les variables issues de la table voeux et on leur affecte le resultat du select
			   foreach($champs as $ci2){
			   $$ci2=$u3->$ci2;
			   }
		   // calcul totaux pour les  moyennes
			$tot1+=$gipNote1;
			 $tot2+=$gipNote2;
			$tot3+=$gipNote3;
			$tot4+=$gipNote4; 

			} // fin du while  
			
	 	 echo"   </td><td>" ;
		 	  	 if($nombre2 >0)
				 {
				echo "<A href=". $URL."?mod=".$codeetu.">réponses</A>";
				 echo"   </td>" ;
				}
	 	 echo"   </td><td>" ;
		 	  	 if($nombre3 >0)
				 {
				echo "<A href=". $URL."?mod_evalue=".$codeetu.">voir les réponses</A>";
				 echo"   </td>" ;
				}			
			
			
			
			
		  // affichage des moyennes
		  if($nombre3!=0)
		  {
				 $i=0;
				 $moy1=round($tot1/$nombre3,2);
					foreach($appreciationsMoyCouleursGip as $appreciationsCouleur)
						{
						//echo "if($moygenerale<= $seuilsMoyennesGip[$i+1] && $moygenerale > $seuilsMoyennesGip[$i])";
								if($moy1<= $seuilsMoyennesGip[$i+1] && $moy1 > $seuilsMoyennesGip[$i]){								
									$couleurCellule="bgcolor='".$appreciationsCouleur."'";
									break;
								}
						$i++;
						}
				echo"   </td><td ".$couleurCellule.">" ;
				echo $moy1;
				 echo"   </td>" ;		  
				 $i=0;
				 $moy2=round($tot2/$nombre3,2);
					foreach($appreciationsMoyCouleursGip as $appreciationsCouleur)
						{
						//echo "if($moygenerale<= $seuilsMoyennesGip[$i+1] && $moygenerale > $seuilsMoyennesGip[$i])";
								if($moy2<= $seuilsMoyennesGip[$i+1] && $moy2 > $seuilsMoyennesGip[$i]){								
									$couleurCellule="bgcolor='".$appreciationsCouleur."'";
									break;
								}
						$i++;
						}
				echo"   </td><td ".$couleurCellule.">" ;
				echo $moy2;
				 echo"   </td>" ;			  
				 $i=0;
				 $moy3=round($tot3/$nombre3,2);;
					foreach($appreciationsMoyCouleursGip as $appreciationsCouleur)
						{
						//echo "if($moygenerale<= $seuilsMoyennesGip[$i+1] && $moygenerale > $seuilsMoyennesGip[$i])";
								if($moy3<= $seuilsMoyennesGip[$i+1] && $moy3 > $seuilsMoyennesGip[$i]){								
									$couleurCellule="bgcolor='".$appreciationsCouleur."'";
									break;
								}
						$i++;
						}
				echo"   </td><td ".$couleurCellule.">" ;
				echo $moy3;
				 echo"   </td>" 	;		  
				 $i=0;
				 $moy4=round($tot4/$nombre3,2);;
					foreach($appreciationsMoyCouleursGip as $appreciationsCouleur)
						{
						//echo "if($moygenerale<= $seuilsMoyennesGip[$i+1] && $moygenerale > $seuilsMoyennesGip[$i])";
								if($moy4<= $seuilsMoyennesGip[$i+1] && $moy4 > $seuilsMoyennesGip[$i]){								
									$couleurCellule="bgcolor='".$appreciationsCouleur."'";
									break;
								}
						$i++;
						}
				echo"   </td><td ".$couleurCellule.">" ;
				echo $moy4;
				 echo"   </td>" 	;
				 $i=0;
				 $moygenerale=round(($tot1/$nombre3+$tot2/$nombre3+$tot3/$nombre3+$tot4/$nombre3)/4,2);
					// if($moygenerale>=1.5){
						// $couleurCellule="bgcolor='".$appreciationsMoyCouleursGip[4]."'";
					// }
					// if($moygenerale<1.5 && $moygenerale>=1){
						// $couleurCellule="bgcolor='".$appreciationsMoyCouleursGip[3]."'";
					// }
					// if($moygenerale<1 && $moygenerale>0.5){
						// $couleurCellule="bgcolor='".$appreciationsMoyCouleursGip[2]."'";
					// }
					// if($moygenerale <= 0.5 && $moygenerale>=-0.5){
						// $couleurCellule="bgcolor='".$appreciationsMoyCouleursGip[1]."'";
					// }
					// if($moygenerale<= -0.5){
						// $couleurCellule="bgcolor='".$appreciationsMoyCouleursGip[0]."'";
					// }
					foreach($appreciationsMoyCouleursGip as $appreciationsCouleur)
						{
						//echo "if($moygenerale<= $seuilsMoyennesGip[$i+1] && $moygenerale > $seuilsMoyennesGip[$i])";
								if($moygenerale<= $seuilsMoyennesGip[$i+1] && $moygenerale > $seuilsMoyennesGip[$i]){								
									$couleurCellule="bgcolor='".$appreciationsCouleur."'";
									break;
								}
						$i++;
						}					
					
				echo"   </td><td ".$couleurCellule.">" ;
				echo $moygenerale;
				 echo"   </td>" ;	
				 echo"   <td>". $dateRest."</td>";
	//$csv_output .= nettoiecsvplus($moygenerale);

	//$csv_output .= "\n";	
			}
			else echo"   </td><td></td><td></td><td></td><td></td><td>" ;
		
			{
	// fin de  la ligne
	

	echo"        </td> </tr>";
			}
	   }
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
echo "<br><br><br>";
echo "<a name=bas></a>";
echo "<center><a href=mailto:$listemail2>envoyer un mail aux $j élèves qui n'ont pas contribué</a><br><br>" ;
echo " <br>si le lien ci dessus ne fonctionne pas<br>copier et coller cette liste dans le champ destinataire de votre message</center><br>";
echo $listemail;
  }
  } // fin du ifaffichetout
  } // fin du test personnes autorisées
  else
  {
 echo "désolé, vous n'avez pas les autorisations requises pour accéder à cette page"; 
  }
mysql_close($connexion);
?>
</body>
</html>
