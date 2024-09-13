<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des voeux</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
set_time_limit(120);
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
if (!isset($_POST['id_stage'])) $_POST['id_stage']='';
if (!isset($_GET['filtre_id'])) $_GET['filtre_id']='';
if (!isset($_GET['filiere_test'])) $_GET['filiere_test']='';
//on ajoute NC à la liste des semestres
$tab_semestres[]='NC';
$message='';
$sql1='';
$sql2='';
$filtre='';
$listeouinon=array('oui','non') ;
$listeouinonNC=array('oui','non','NC') ;
$listeouinonpt=array('oui','non','peut être') ;
$affichetout=1;

 // on affecte le bon numero aux paramètres pour la campagne
/* $numero_campagne='20';
$texte_explic_tab_choix_jetons='tab_choix_jetons'.$numero_campagne;
$tab_choix_jetons=$$texte_explic_tab_choix_jetons;
$texte_explic_ue_conflit_edt_couleurs='ue_conflit_edt_couleurs'.$numero_campagne;
$ue_conflit_edt_couleurs=$$texte_explic_ue_conflit_edt_couleurs;
$texte_explic_groupe_icl='groupe_icl'.$numero_campagne;
$groupe_icl=$$texte_explic_groupe_icl;
$texte_explic_groupe_idp='groupe_idp'.$numero_campagne;
$groupe_idp=$$texte_explic_groupe_idp;
$texte_explic_groupe_ipid='groupe_ipid'.$numero_campagne;
$groupe_ipid=$$texte_explic_groupe_ipid;
$texte_explic_param_tot_jetons='param_tot_jetons'.$numero_campagne;
$param_tot_jetons=$$texte_explic_param_tot_jetons;
$texte_explic_param_nbr_ue_avec_jeton_par_filiere='param_nbr_ue_avec_jeton_par_filiere'.$numero_campagne;
$param_nbr_ue_avec_jeton_par_filiere=$$texte_explic_param_nbr_ue_avec_jeton_par_filiere;
$param_nbr_ue_avec_jeton_min='param_nbr_ue_avec_jeton_min'.$numero_campagne;
$param_nbr_ue_avec_jeton_min=$$param_nbr_ue_avec_jeton_min;
$texte_explic_param_nbr_ue_transvers_min='param_nbr_ue_transvers_min'.$numero_campagne;
$param_nbr_ue_transvers_min=$$texte_explic_param_nbr_ue_transvers_min; */


$idp='';
$icl='';
$ipid='';


/* $ueexclues=array();
$uecommun=array();
$uecommunidp=array();
$uecommunicl=array();
$uecommunipid=array();
$ueidp=array();
$ueicl=array();
$ueipid=array();
$uetotal_s5=array();
$ue_conflit_edt=array();
$uechoisies=array();

 //$wherecours=" `".$table_cours20."`.CODE like '5%'";
//on remplit 1tableau avec les libelles-code cours
 $sqlquery2="SELECT * FROM `".$table_cours20."` order by CODE";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$courscode[]=$v["CODE"] ;
$courslibel[$v["CODE"]]=$v["LIBELLE_COURT"];
$coursects[$v["CODE"]]=$v["CREDIT_ECTS"];
$coursjetons[$v["CODE"]]='';
} */



$query = "SELECT * FROM voeux_s5_ues where  voeuxS5idCampagne='".$idsondage20."' order by  conflit_edt_ue ";
   $result = mysql_query($query,$connexion ); 
while($u=mysql_fetch_object($result)) {
	switch ($u->type_ue){
		case "transversale icl":
		$uecommunicl[]=$u->code_ue;
		break;
		case "transversale idp":
		$uecommunidp[]=$u->code_ue;
		break;	
		case "transversale ipid":
		$uecommunipid[]=$u->code_ue;
		break;		
		case "idp":
		$ueidp[]=$u->code_ue;
		break;
		case "icl":
		$ueicl[]=$u->code_ue;
		break;
		case "ipid":
		$ueipid[]=$u->code_ue;
		break;
		}
if (!(in_array(	$u->code_ue,$uetotal_s5)))
{	
$uetotal_s5[]=$u->code_ue;		
$ue_conflit_edt[$u->code_ue]=$u->conflit_edt_ue;
}
}

if (($_GET['filiere_test']) == 'icl')
{
$icl='oui';
$uecommun=$uecommunicl;

}
elseif(($_GET['filiere_test']) == 'idp')
{
$idp='oui';
$uecommun=$uecommunidp;
}
elseif(($_GET['filiere_test']) == 'ipid')
{
$ipid='oui';
$uecommun=$uecommunipid;
}


$courspossible=array();
$courspossible2=array();
$titre=$titrevoeux20;
// on forge le where sql
//$wherecours = "  id_uni not in ".$univ_exclues." ";
$wherecourstot = " 1 ";
//foreach ($courspossible as $ci){
//$wherecours.= " or  id_uni='".$ci."'";
//$wherecourstot.= " or  id_uni='".$ci."'";
//}
$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

if ($_GET['env_orderby']=='') {$orderby='ORDER BY v_voeux1 desc,Nom';}
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
if(in_array($login,$voeux_liste20)){

	//pour le moment ok pour tous
	//$affichetout=1;

$URL =$_SERVER['PHP_SELF'];;
$table="voeux_eleves";
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
/* //on remplit 1tableau avec les libelles-code universites
$sqlquery2="SELECT *,pays.libelle_pays FROM universite left outer join pays on pays.id_pays=universite.id_pays where ".$wherecours ." order by nom_uni";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$cours_code[]=$v["id_uni"] ;
$cours_libelle[]=$v["nom_uni"]." / ".$v["ville"]." / ".$v["libelle_pays"] ;
$cours_libelle_pays_a[$v["id_uni"]]=$v["libelle_pays"];
$cours_libelle_a[$v["id_uni"]]=$v["nom_uni"];
}
$cours_code[]='9999';
$cours_libelle[]='NC';
$cours_libelle_a[9999]='NC';
$cours_libelle_pays_a[9999]='NC'; */


$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$voeux_liste20)){ 
 // il faut aussi supprimer les lignes de voeux pour cet etudiant
  $query = "DELETE FROM ligne_voeux_ues5"
      ." WHERE ligvs5_login='".$_GET['login']."' and ligvs5_code_idsondage ='".$idsondage20."' ";
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "choix de  <b>".$_GET['login'];
   $message .= "</b> supprimés <br>!";
   }
   $query = "DELETE FROM $table"
      ." WHERE v_id=".$_GET['del']."";
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
   
      else{
   echo "<center><b>seul le service autorise peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$ri_user_liste)){
 //pour modifpar
//$_POST['modifpar']=$login;
//pour les dates

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));

 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 //on ne peut que modifier les reponses
// if ($ci2!="rep_voeu_parcours1"  and $ci2!="rep_voeu_parcours2"  and $ci2!="rep_voeu_parcours3" and $ci2!="rep_voeu_parcours4" and $ci2!="rep_voeu_parcours5" and $ci2!="rep_voeu_parcours20" and $ci2!="rep_voeu_inter1"  and $ci2!="rep_voeu_inter2" and $ci2!="rep_voeu_inter3" and $ci2!="rep_voeu_inter4" and $ci2!="rep_voeu_inter5"    ){
 //on ne fait rien
 //}
if ($ci2=="v_date_modif"){
 $sql1.= $ci2."=now(),";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }

 //attention il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE v_id=".$_POST['v_id']." ";
 
//echo $query;
  $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['v_id']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>seul le service autorisé peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==
} //fin du if

if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!='' and $_POST['bouton_annul']!='Annuler'){
  //------------------------------------c'est kon a cliqué sur le lien details
// il faut aller faire une requête dans la table ligne_voeux_S5 pour récupérer les lignes qui concernent cet etudiant



 $query = "SELECT $table.*,etudiants.*,annuaire.* FROM $table 
 left outer join etudiants on upper($table.v_num_etudiant)=etudiants.`Code etu` 
 left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
					  where v_id='".$_GET['mod']."' ";
					  

		  //echo $query;

  $result = mysql_query($query,$connexion );
$x=mysql_fetch_object($result) ;
		$nom= $x->Nom;
         $prenom= $x->$myetudiantsprénom_1;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$x->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		$v_date_modif=mysql_Time($v_date_modif);
	// on split les voeux entre code université et période
/*    for ($i=1;$i<6;$i++)
   {
   $temp1='v_voeux'.$i.'_code';
   //echo $temp1;
    $temp2='v_voeux'.$i.'_periode';
	$temp3='v_voeux'.$i;
   list($$temp1,$$temp2)=explode("_",$$temp3);
   } */	
   
  echo    "<form method=post action=$URL> ";
 //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        }
         
  //echo"<input type='hidden' name='mod' value=1>";

	echo "<center><h1>$titre<br>";

  echo"       <table><tr>  ";

	 echo "</tr><tr>";
     echo affichechamp('nom ','nom',	$x->$myannuairenom_usuel,'50',1);
     echo affichechamp('prenom ','prenom',$x->$myannuaireprénom,'40',1);
	 echo "</tr><tr>";
	      echo affichechamp('email ','email',$x->$myannuairemail_effectif,'50',1);
		  echo affichechamp('Date limite ','affdatelimite',$datelimitevoeux20,'10',1);
	     // echo affichechamp('email ','email',$mail[0],'50',1);
		 echo "</tr><tr>";	 
     echo affichechamp('date modification ','nom',	$x->v_date_modif,'20',1);
     echo affichechamp('par ','prenom',$x->v_modifpar,'15',1);
echo "</tr><tr>";
    echo "</td></tr><tr><th colspan=3>
	<input type='Submit' name='bouton_annul' value='Revenir à la liste'>";
	//echo"<input type='Submit' name='bouton_mod' value='Modifier'>";
 echo "</th></tr>";             
 echo"<td>";
 echo "</table>";
 
 
 
	
	 $query2 = "SELECT distinct `".$table_cours20."`.*,ligne_voeux_ues5.* FROM `".$table_cours20."` 
	 left outer join ligne_voeux_ues5 on ligne_voeux_ues5.ligvs5_code_ue=`".$table_cours20."`.code 
	 where (ligne_voeux_ues5.ligvs5_login = '".$_GET['login']."'and ligvs5_code_idsondage='".$idsondage20."' ) 
	  order by LIBELLE_COURT " ;
	        $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) 
	{

		$courscode[]=$u->CODE;
		$courslibel[$u->CODE]= $u->LIBELLE_COURT ;
		$coursects[$u->CODE]=$u->CREDIT_ECTS;	
		$coursjetons[$u->CODE]=$u->ligvs5_jetons;	
		$courscommentaires[$u->CODE]=$u->ligvs5_commentaire;			
		
	}
	
//var_dump($coursjetons);

	echo "<table border=1>";
	echo "<th colspan=6 align=center>Evaluation des cours suivis </th>";
	echo "</tr><tr>";
	echo "<th></th><th>Code cours</th><th>Intitule</th><th>ECTS</th><th>Evaluation</th><th>Commentaires</th>";
	echo"<th>  </th>";	
	 $bgcolor='bgcolor=lightgreen';
	 $i=0;
foreach($courscode as $uecode)
	{	
		// pour les erreur qd l ue n'existe pas ds ksup
	if (!array_key_exists($uecode,$courslibel))
	{
	$courslibel[$uecode]='Absent dans KSUP';
	$coursects[$uecode]='inconnu';
	$coursjetons[$uecode]='';
	}


		 		 $bgcolor='';

				echo"   <tr bgcolor='$bgcolor' ><td>" ;    
				  if(array_key_exists ($uecode ,$fiche_code_ksup ))
				  {				
				if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$uecode].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
				}
					  else 
				  {
				  echo "n'existe pas dans ksup";
				  }
				echo"   </td><td>" ;
				echo $uecode;
				echo"   </td><td>" ;
				echo $courslibel[$uecode];
				echo"   </td><td>" ;
				echo $coursects[$uecode];
				//echo"<input type='hidden' name=champ_ue_form_code_icl".$i." value='".$uecode."' >";
				//$temp='champ_ue_form_jetons_icl'.$i;
				//echo affichemenunc('votre évaluation','v_cours_eval'.$i,$evalcours20,$coursjetons[$uecode]);
				echo affichemenuplus2tab('votre évaluation','v_cours_eval'.$i,$evalcours20,$evalcours20note,$coursjetons[$uecode]);				
				echo "<td><textarea   name=v_commentaire".$i." rows=2 cols=35 placeholder='votre commentaire' readonly>$courscommentaires[$uecode]</textarea></td> ";	
				//echo $coursjetons[$uecode];
				echo " </td> ";
				echo "</tr>";		 
			$i++;
		
	 }
	 		     echo"<input type='hidden' name='nombre_ligne_ue_icl' value=$i >";
	echo"</table>";	

	
	


	echo"</table>";	
	echo "</tr><tr>";	
	echo"   </td>" ; 
	
	
 echo"</table></form> "  ;
   
  echo"</center>";
	  }
	  }
 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
  
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage
// ordre par defaut
//$orderby="order by $table.date_creation";



  // on s occupe d'abord des eleves du gpe cible qui ont fait un voeu
  
   $query="SELECT  etudiants.Nom ,etudiants.`Prénom 1` ,etudiants.`Code etu` as codetu,etudiants.`Lib dac` as provenance , etudiants.`Code étape` as filiere, annuaire.`Mail effectif`,annuaire.`Uid` ,voeux_eleves. * , departements.dep_libelle, groupes.libelle,etudiants_scol.annee
FROM ligne_groupe
LEFT OUTER JOIN etudiants ON etudiants.`Code etu` = ligne_groupe.code_etudiant
LEFT OUTER JOIN groupes ON groupes.code = ligne_groupe.code_groupe
LEFT OUTER JOIN voeux_eleves ON upper( voeux_eleves.v_num_etudiant ) = etudiants.`Code etu`
LEFT OUTER JOIN etudiants_scol ON etudiants_scol.code = etudiants.`Code etu`
LEFT OUTER JOIN annuaire ON upper( etudiants.`Code etu` ) = annuaire.`code-etu`
LEFT OUTER JOIN departements ON etudiants.`Nationalité` = departements.dep_code
WHERE libelle = '".$gpecible20."' and (v_id_sondage='".$idsondage20."'  )
";  
      $query.="  ".$orderby;
 //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
list($jour,$mois,$annee) = explode("/",$datelimitevoeux20);
$moins1jour = date("d/m/Y", mktime(0, 0, 0, date($mois), date($jour)-1,  date($annee)));
echo "<a href=default.php> Revenir à l'accueil<br><br></a>";
echo "<center>$titrevoeux20<br>";
if ($datedebutvoeux20!='')
{echo "date debut <b>$datedebutvoeux20</b>  ";}
echo "date fin <b>$moins1jour à 23h59</b>  ";
echo "<br>groupe cible: <b> $gpecible20 </b> ";
echo "</center>";
if ($nombre>0){

echo"<center> <h2>Liste des   ";
echo $nombre;
echo" élèves </h2></center>  ";}
else{
echo"<center> <h2>Il n'y a  pas d'inscrit pour l'instant   ";
echo" </h2></center>  ";}



//echo "<a href=logout.php> Se déconnecter<br><br></a>";
echo "<a href=#bas> Pour envoyer un mail aux etudiants sans voeux</a>";

//echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] > Ajouter un voeu </a><br>";


if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";

        echo "<BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
echo "<th></th>";
echo afficheentete('Nom','etudiants.Nom',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

echo"<th>Prénom</th>";
echo"<th>Mail</th>";
echo afficheentete('filière','etudiants_scol.annee',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

echo"<th>Commentaire</th>";
echo"<th></th>";
// on initialise les listes emails
$listemail='';
$listemail2='';
$j=0;
//on initialise  $csv_output
 $csv_output="";
 // pour la premiere ligne d etitre avec leslibellés des Ues
// $csv_output .="".";"."".";"."".";"."".";"."".";"."".";"."".";";
//  foreach ($uetotal_s5 as $une_ue)
// {
//  $csv_output .=$courslibel[$une_ue].";";
// }
// $csv_output .= "\n";
 $csv_output ="code_etu".";"."nom".";"."prenom".";"."mail".";"."groupe".";"."filière".";";
 // il faut la liste de toutes les  ues déjà saisies dans cette campagne
 
  // on récupère ses choix précédents
 
 	 $query3 = "SELECT distinct ligvs5_code_ue from ligne_voeux_ues5 
	 where ( ligvs5_code_idsondage='".$idsondage20."' ) 
	   " ;
	$result3=mysql_query($query3,$connexion);

		while($z=mysql_fetch_object($result3)) {
			$touteslesues[]=$z->ligvs5_code_ue;
		}
 
 
 foreach ($touteslesues as $une_ue)
 {
  $csv_output .="eval ".$une_ue.";";
 }
  foreach ($touteslesues as $une_ue)
 {
  $csv_output .="comm ".$une_ue.";";
 }
$csv_output .= "\n";

// pour chaque etudiant
while($universite=mysql_fetch_object($result)) {
//on récupère les champs liés
		$codeetu= $universite->codetu;
		$nom= $universite->Nom;
         $prenom= $universite->$myetudiantsprénom_1;
		 $gprprincipal=	$universite->annee;
		 $filiere=$universite->filiere;
$mail=$universite->$myannuairemail_effectif;


 //on fait une boucle pour créer les variables issues de la table
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }   
 		$csv_output .=nettoiecsv($codeetu);  
		$csv_output .=nettoiecsv($nom);
		$csv_output .=nettoiecsv($prenom);
		$csv_output .=nettoiecsv($mail);	
		$csv_output .=nettoiecsv($gprprincipal);
		$csv_output .=nettoiecsv($filiere);		


      echo"   <tr><td>" ;

	 if($v_id !=''){
     echo "<A href=". $URL."?mod=$v_id&login=".$universite->Uid."&codetu=".$universite->codetu.">détails</A>";
	 // pour le moment on peut supprimer
	  if(1){ 	 
	 // if($login=='administrateur'){ 
	  echo "<A href=". $URL."?del=$v_id&login=".$universite->v_login_etud." onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce voeu?')\">-Sup</A>";  
	  }
	 }
	 	  	  echo"   </td><td>" ;
		  echo "<a href=fiche.php?code=".$universite->codetu.">".$nom."</a>";
		  echo "<a href=".$chemin_root_relatif_eleve."voeux20.php?login_clone=".$universite->Uid.">".'  test'."</a>";		  
	  	  echo"   </td><td>" ;
		  echo $prenom;
	  	  echo"   </td><td>" ;
		  echo "<a href=mailto:".$mail.">".$mail."</a>";	  
		  	  	  echo"   </td><td>" ;
			//echo $gprprincipal;		
			echo $filiere;			  
	  echo"   </td><td>" ;
         echo $v_commentaire ; 
	  	echo"        </td> </tr>";  	
				// juste dans csv reponse voeux1
/* 				$csv_output .= nettoiecsv($rep_voeu_parcours1); */

   // pour l'export excel on recupere tous ses voeux
   
 		// on ajoute au csv la liste de ses voeux
		
		 // on récupère ses choix précédents
 
 	 $query4 = "SELECT * from ligne_voeux_ues5 
	 where (ligne_voeux_ues5.ligvs5_login = '".$universite->Uid."' and ligvs5_code_idsondage='".$idsondage20."' ) 
	   " ;
	$result4=mysql_query($query4,$connexion);
	// on vide les tableaux
	$uesenregistres=array();
	$choixenregistres=array();
	$commentenreg=array();
		while($y=mysql_fetch_object($result4)) {
			$uesenregistres[]=$y->ligvs5_code_ue;
			$choixenregistres[$y->ligvs5_code_ue]=$y->ligvs5_jetons;
			$commentenreg[$y->ligvs5_code_ue]=$y->ligvs5_commentaire;
		}   
 // on recupere les jetons
 foreach ($touteslesues as $une_ue)
 {
 if (array_key_exists($une_ue,$choixenregistres))
		 {		 
		  $csv_output .=nettoiecsv($choixenregistres[$une_ue]);
		 }
		 else
		 $csv_output .="NC;";
 }
 // et les commentaires
  foreach ($touteslesues as $une_ue)
 {
 if (array_key_exists($une_ue,$choixenregistres))
		 {		 
		  $csv_output .=nettoiecsv($commentenreg[$une_ue]);
		 }
		 else
		 $csv_output .="NC;";
 }
 
$csv_output .= "\n";

       } // fin de pour chaque eudiant
	   
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
echo "<br><br><br>";
  // on s occupe maintenant  des eleves du gpe cible sans voeu
  


   $query="SELECT etudiants.Nom, etudiants.`Prénom 1` , etudiants.`Code etu` , annuaire.`Mail effectif`
FROM ligne_groupe
LEFT OUTER JOIN etudiants ON etudiants.`Code etu` = ligne_groupe.code_etudiant
LEFT OUTER JOIN annuaire ON upper( etudiants.`Code etu` ) = annuaire.`code-etu`
LEFT OUTER JOIN groupes ON groupes.code = ligne_groupe.code_groupe
WHERE etudiants.`Code etu` NOT
IN (
SELECT `v_num_etudiant`
FROM `voeux_eleves`
WHERE `v_id_sondage`='".$idsondage20."'  )
AND libelle  LIKE '".$gpecible20."'
 ORDER BY Nom";
//echo $query;
 $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);

while($u=mysql_fetch_object($result)) {
//on récupère les champs liés
		//$nom= $u->Nom;
         //$prenom= $u->$myetudiantsprénom_1;
		 //$gprprincipal=	$u->annee;
$mail=$u->$myannuairemail_effectif;
//$v_num_etudiant=$u->v_num_etudiant;

//pour generer la liste mail des non repondus
		   if ( $mail !=''){
		   $listemail.=  $mail.",<br>";
			$listemail2.=  $mail.",";
			$j++;
		   }

}


echo "<a name=bas></a>";
echo "<center><a href=mailto:$listemail2>envoyer un mail aux $j élèves qui n'ont pas saisi de voeux</a><br><br>" ;
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