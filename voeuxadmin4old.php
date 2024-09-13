<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des voeux</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php"); require ("paramvoeux.php");
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
if (!isset($_POST['id_stage'])) $_POST['id_stage']='';
if (!isset($_GET['filtre_id'])) $_GET['filtre_id']='';
//on ajoute NC à la liste des semestres
$tab_semestres_voeux4[]='NC';
$message='';
$sql1='';
$sql2='';
$filtre='';
$listeouinon=array('oui','non') ;
$listeouinonpt=array('oui','non','peut être') ;
$affichetout=1;
// verif si c un etudiant
//si on vient de valider un ajout ou une modif il faut remmettre l'id univ ds le get_var

//$gpecible='2A';
//$where="where etudiants_scol.annee like '".$gpecible."%' ";

//$nom_univ='';
$courspossible=array();
$courspossible2=array();
$titre=$titrevoeux4;
// on forge le where sql
//$wherecours = " (pays.continent='Europe' or commentaire  like '%voeux1A%' ) ";
//$wherecours = "  id_uni not in ".$univ_exclues4." ";
//$wherecourstot = "(pays.continent='Europe' or commentaire  like '%voeux1A%' ) ";
//$wherecourstot = "  id_uni not in ".$univ_exclues4." ";
$wherecours = "  ouv_cand2 = 'Oui' ";
$wherecourstot = " 1 ";
$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

if ($_GET['env_orderby']=='') {$orderby='ORDER BY Nom,v_voeux1 desc';}
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
if(in_array($login,$voeux_liste4)){

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
//on remplit 1tableau avec les libelles-code universites
$sqlquery2="SELECT universite.* ,pays.continent,pays.libelle_pays FROM universite left outer join pays on universite.id_pays =pays.id_pays where ".$wherecours ." order by nom_uni";
//echo $sqlquery2;
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
$cours_libelle_pays_a[9999]='NC';

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
 if(in_array($login,$voeux_liste4)){ 
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
 //si c'est un voeux on concatene
 if (stripos($ci2, 'voeux')){
// echo 'test';
 $_POST[$ci2]= $_POST[$ci2].'_'.$_POST[$ci2.'_periode'];
 }
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="v_id"){
 //on ne fait rien
 }
 elseif ($ci2=="v_date_modif"){
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
   for ($i=1;$i<6;$i++)
   {
   $temp1='v_voeux'.$i.'_code';
   //echo $temp1;
    $temp2='v_voeux'.$i.'_periode';
	$temp3='v_voeux'.$i;
	if (strpos($$temp3,'_')===false)
		{
		$$temp1='';
		$$temp2='';	
	// y a pas de _ on ne fait rien et ça évite le message d'erreur
		}else
		{
		list($$temp1,$$temp2)=split("_",$$temp3);
		}
   }	
   
  echo    "<form method=post action=$URL> ";
 //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        }
         
  //echo"<input type='hidden' name='mod' value=1>";

	echo "<center><h1>$titre<br>";

  echo"<center>";  
  echo"       <table><tr>  ";
  
//$nomcomplet=ask_ldap($login,'displayname');
//$prenom=ask_ldap($login,'givenname');
//$nom=ask_ldap($login,'sn');
//$mail=ask_ldap($login,'mail');
	 echo "</tr><tr>";
     echo affichechamp('nom ','nom',	$x->$myannuairenom_usuel,'50',1);
     echo affichechamp('prenom ','prenom',$x->$myannuaireprénom,'40',1);
	 echo "</tr><tr>";
	      echo affichechamp('email ','email',$x->$myannuairemail_effectif,'50',1);
		  echo affichechamp('Date limite ','affdatelimite',$datelimitevoeux4,'10',1);
	     // echo affichechamp('email ','email',$mail[0],'50',1);
				  	 echo "</tr><tr>";  		 
    echo affichechamp('modifié par','modifpar',$v_modifpar,'15',1);
    echo affichechamp('le','date_modif',$v_date_modif,'15',1);
		  	 echo "</tr><tr>";	
	echo affichemenu('Souhaitez- vous réaliser un séjour académique à l\'étranger','v_sup1',$listeouinonpt,$v_sup1);
		  	 echo "</tr><tr>";	
	echo affichemenu('Souhaitez- vous réaliser votre stage IA à l\'étranger','v_sup2',$listeouinonpt,$v_sup2);	
		  	 echo "</tr><tr>";	
	echo affichemenu('Souhaitez- vous réaliser votre stage PFE à l\'étranger','v_sup3',$listeouinonpt,$v_sup3);	
		  	 echo "</tr><tr>";	
	echo affichemenu('Souhaitez- vous réaliser une année de césure','v_sup6',$listeouinonpt,$v_sup6);	
		  	 echo "</tr><tr>";	
	echo affichechamp('Quelles sont les langues (hormis le l\'anglais et le français) que vous pratiquez','v_sup4',$v_sup4,80);	echo "</tr><tr>";	
	echo affichechamp('TOEFL officiel (et payant ...)','v_sup5',$v_sup5,80);			
		  	 echo "</tr><tr>";
echo affichemenuplus2tab ('Voeu 1','v_voeux1',$cours_libelle,$cours_code,$v_voeux1_code);
echo affichemenu('Période','v_voeux1_periode',$tab_semestres_voeux4,$v_voeux1_periode);  
		  	 echo "</tr><tr>";
echo affichemenuplus2tab ('Voeu 2','v_voeux2',$cours_libelle,$cours_code,$v_voeux2_code);
echo affichemenu('Période','v_voeux2_periode',$tab_semestres_voeux4,$v_voeux2_periode); 
		  	 echo "</tr><tr>";
echo affichemenuplus2tab ('Voeu 3','v_voeux3',$cours_libelle,$cours_code,$v_voeux3_code);
echo affichemenu('Période','v_voeux3_periode',$tab_semestres_voeux4,$v_voeux3_periode); 
		  	 echo "</tr><tr>";
echo affichemenuplus2tab ('Voeu 4','v_voeux4',$cours_libelle,$cours_code,$v_voeux4_code);
echo affichemenu('Période','v_voeux4_periode',$tab_semestres_voeux4,$v_voeux4_periode); 
		  	 echo "</tr><tr>";
echo affichemenuplus2tab ('Voeu 5','v_voeux5',$cours_libelle,$cours_code,$v_voeux5_code);
echo affichemenu('Période','v_voeux5_periode',$tab_semestres_voeux4,$v_voeux5_periode); 
			echo "</tr><tr>";
		
			

		  echo "<td>Commentaire</td>";
		  	  		 echo "</tr><tr>";
echo "<td colspan=3><textarea   name='v_commentaire' rows=3 cols=45>$v_commentaire</textarea></td> ";	
echo "</tr><tr>";
    echo "</td></tr><tr><th colspan=6>
	<input type='Submit' name='bouton_annul' value='Revenir à la liste'>
	<input type='Submit' name='bouton_mod' value='Modifier'>
 </th></tr>";             
 echo"<td>";
 echo "</table>";
 //echo afficheonly("","Liste des cours",'b' ,'h3');
 echo "<center>";
	echo "<table border=1>";
	echo "<th colspan=5 align=center>Cliquez sur le nom de l'université pour avoir plus d'informations</th>";
	echo "</tr><tr>";
	echo "<th>université d'accueil</th><th>Ville</th><th>site Web</th>";
	 $query2="SELECT universite.* ,pays.continent FROM universite left outer join pays on universite.id_pays =pays.id_pays where ".$wherecours ." order by nom_uni";
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
	echo"   <tr><td>" ;  
    echo  "<a href=universites.php?mod=".$u->id_uni." target=_blank >".$u->nom_uni."</a>" ;
	 echo"   </td><td>" ; 
	echo $u->ville;
	echo"   </td><td>" ; 
	if ($u->site_web!=''){
	echo "<a href=".$u->site_web." target=_blank>".$u->site_web."</a>";}
     echo"        </td> </tr>";
	 }
	echo"</table>";
	 echo "</center>";
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



  

   

   $query="SELECT  etudiants.Nom ,etudiants.`Prénom 1` ,etudiants.`Code etu` as codetu,etudiants.`Lib dac` as provenance , annuaire.`Mail effectif` ,voeux_eleves. * , departements.dep_libelle, groupes.libelle,etudiants_scol.annee
FROM ligne_groupe
LEFT OUTER JOIN etudiants ON etudiants.`Code etu` = ligne_groupe.code_etudiant
LEFT OUTER JOIN groupes ON groupes.code = ligne_groupe.code_groupe
LEFT OUTER JOIN voeux_eleves ON upper( voeux_eleves.v_num_etudiant ) = etudiants.`Code etu`
LEFT OUTER JOIN etudiants_scol ON etudiants_scol.code = etudiants.`Code etu`
LEFT OUTER JOIN annuaire ON upper( etudiants.`Code etu` ) = annuaire.`code-etu`
LEFT OUTER JOIN departements ON etudiants.`Nationalité` = departements.dep_code
WHERE libelle LIKE '".$gpecible4."'";
   
      $query.="  ".$orderby;
  echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
list($jour,$mois,$annee) = explode("/",$datelimitevoeux4);
$moins1jour = date("d/m/Y", mktime(0, 0, 0, date($mois), date($jour)-1,  date($annee)));
echo "<a href=default.php> Revenir à l'accueil<br><br></a>";
echo "<center>$titrevoeux4<br>";
if ($datedebutvoeux4!='')
{echo "date debut <b>$datedebutvoeux4</b>  ";}
echo "date fin <b>$moins1jour à 23h59</b>  ";
echo "<br>groupe cible: <b> $gpecible4 </b> ";
echo "</center>";
if ($nombre>0){

echo"<center> <h2>Liste des   ";
//echo $nombre;
echo" élèves </h2></center>  ";}
else{
echo"<center> <h2>Il n'y a  pas d'inscrit pour l'instant   ";
echo" </h2></center>  ";}
echo "<a href=#bas> Pour envoyer un mail aux etudiants sans voeux</a>";

//echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] > Ajouter un voeu </a><br>";


if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";

        echo "<BR><table border=1><tr bgcolor=\"#98B5FF\" > ";

echo afficheentete('Nom','etudiants.Nom',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

echo"<th>Prénom</th>";
echo afficheentete('Nationalité','departements.dep_libelle',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('Origine','provenance',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo"<th>Nationalité</th>";
echo"<th>Mail</th>";
echo afficheentete('filière','etudiants_scol.annee',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('séjour etranger','v_sup1',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('stage IA étranger','v_sup2',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('stage PFE étranger','v_sup3',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('Année césure','v_sup6',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('langues','v_sup4',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('TOEFL','v_sup5',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('voeu1','v_voeux1',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('voeu2','v_voeux2',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('voeu3','v_voeux3',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('voeu4','v_voeux4',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('voeu5','v_voeux5',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo"<th>Commentaire</th>";
echo"<th></th>";
// on initialise les listes emails
$listemail='';
$listemail2='';
$j=0;
//on initialise  $csv_output
 $csv_output="";
 $csv_output .="nom".";"."prenom".";"."nationalité".";"."provenance".";"."mail".";"."groupe".";"."séjour étranger".";"."stage IA étranger".";"."stage PFE étranger".";"."année césure".";"."langues".";"."TOEFL".";"."periode".";"."voeu 1".";"."pays".";"."periode".";"."voeu 2".";"."pays".";"."periode".";"."voeu 3".";"."pays".";"."periode".";"."voeu 4".";"."pays".";"."periode".";"."voeu 5".";"."pays".";"."commentaire".";";

$csv_output .= "\n";
while($universite=mysql_fetch_object($result)) {


//on récupère les champs liés
		$nom= $universite->Nom;
         $prenom= $universite->$myetudiantsprénom_1;
		 $gprprincipal=	$universite->annee;
$mail=$universite->$myannuairemail_effectif;


 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }

		   //on surcharge les dates pour les pbs de format
		   


							
//pour generer la liste mail des non repondus
		   if ($v_num_etudiant =='' and $mail !=''){
		   $listemail.=  $mail.",<br>";
			$listemail2.=  $mail.",";
			$j++;
		   }
		
      echo"   <tr><td>" ;
		  echo "<a href=fiche.php?code=".$universite->codetu.">".$nom."</a>";
		  $csv_output .=$nom.";";
	  	  echo"   </td><td>" ;
		  echo $prenom;
		  $csv_output .=$prenom.";";
		  echo"   </td><td>" ;
		  echo $universite->dep_libelle;
		  $csv_output .=$universite->dep_libelle.";";
	  	  echo"   </td><td>" ;
		  echo $universite->provenance;
		  $csv_output .=$universite->provenance.";";
	  	  echo"   </td><td>" ;
		  echo "<a href=mailto:".$mail.">".$mail."</a>";	
		  $csv_output .=$mail.";";		  
		  	  	  echo"   </td><td>" ;
		  echo $gprprincipal;
		  $csv_output .=$gprprincipal.";";
		  // pour ceux qui ont déjà fait un voeu ds cette campagne

	 if($v_id_sondage  == $idsondage4){
	 
	 		    // on splite les voeux entre code université et période
			
   for ($i=1;$i<6;$i++)
    {
	   $temp1='v_voeux'.$i.'_code';
		//echo $temp1;
		$temp2='v_voeux'.$i.'_periode';
		$temp3='v_voeux'.$i;
   		   if ($$temp3!='')
				{
   list($$temp1,$$temp2)=split("_",$$temp3);
				}else{
				$$temp1=9999;
				$$temp2='NC';				
				}
   }
		  
			echo"   </td><td>" ;
		  echo $v_sup1;
		  	$csv_output .=nettoiecsv($v_sup1);
		  			echo"   </td><td>" ;
		  echo $v_sup2;
		  $csv_output .=nettoiecsv($v_sup2);
		  			echo"   </td><td>" ;
		  echo $v_sup3;
		  	$csv_output .=nettoiecsv($v_sup3);		  
					echo"   </td><td>" ;
			echo $v_sup6;
		  	$csv_output .=nettoiecsv($v_sup6);		  
		  			echo"   </td><td>" ;
		  echo $v_sup4;
		  	$csv_output .=nettoiecsv($v_sup4);		  
		  			echo"   </td><td>" ;
		  echo $v_sup5;
		  	$csv_output .=nettoiecsv($v_sup5);
	  	  echo"   </td><td>" ;
		  echo $v_voeux1_periode."-".$cours_libelle_a[$v_voeux1_code];
		  		  	$csv_output .=$v_voeux1_periode.";".$cours_libelle_a[$v_voeux1_code].";".$cours_libelle_pays_a[$v_voeux1_code].";";

      echo"   </td><td>" ;
	  		   echo $v_voeux2_periode."-".$cours_libelle_a[$v_voeux2_code];
		  		  	$csv_output .=$v_voeux2_periode.";".$cours_libelle_a[$v_voeux2_code].";".$cours_libelle_pays_a[$v_voeux2_code].";";;
	  echo"   </td><td>" ;	  
	  		   echo $v_voeux3_periode."-".$cours_libelle_a[$v_voeux3_code];
			   $csv_output .=$v_voeux3_periode.";".$cours_libelle_a[$v_voeux3_code].";".$cours_libelle_pays_a[$v_voeux3_code].";";;
 	  echo"   </td><td>" ;	  
	  		   echo $v_voeux4_periode."-".$cours_libelle_a[$v_voeux4_code];
			   		  		  	$csv_output .=$v_voeux4_periode.";".$cours_libelle_a[$v_voeux4_code].";".$cours_libelle_pays_a[$v_voeux4_code].";";;
	echo"   </td><td>" ;	  
	   echo $v_voeux5_periode."-".$cours_libelle_a[$v_voeux5_code];
	   		  		  	$csv_output .=$v_voeux5_periode.";".$cours_libelle_a[$v_voeux5_code].";".$cours_libelle_pays_a[$v_voeux5_code].";";;
	  echo"   </td><td>" ;
      echo $v_commentaire ;
	  		  	$csv_output .= nettoiecsv($v_commentaire);

	  echo"   </td><td>" ;
    // echo " <A href=".$URL."?del=$v_id onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette inscription ?')\">";
     //echo "sup</A> - ";

     echo "<A href=". $URL."?mod=$v_id>détails</A>";
	  if($login=='administrateur'){ 
	  echo "<A href=". $URL."?del=$v_id onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce voeu?')\">-Sup</A>";  
	  }
	 }
	 // pour ceux qui n'ont pas encore fait de voeux ds cette campagne
	 else
	 {
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
	 			echo"   </td><td>" ;
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');				
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');
				$csv_output .= nettoiecsv('');				
	 }
     echo"        </td> </tr>";
	 $csv_output .= "\n";
       
	}  
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
echo "<br><br><br>";
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