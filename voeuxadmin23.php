<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des voeux 23</title>
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
$message='';
$sql1='';
$sql2='';
$filtre='';
$listeouinon=array('oui','non') ;
$affichetout=1;
// verif si c un etudiant
//si on vient de valider un ajout ou une modif il faut remmettre l'id univ ds le get_var
$where="where etudiants_scol.annee like '".$gpecible23."%' ";
//$nom_univ='';

$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

if ($_GET['env_orderby']=='') {$orderby='ORDER BY Nom';}
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
if(in_array($login,$voeux_liste23)){

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

//on remplit 1tableau avec les libelles-code cours

foreach ($courspossible23 as $coursenum ){
$cours_code[]=$coursenum ;
$cours_libelle[]=$coursenum ;
$cours_libelle_a[$coursenum]=$coursenum;
}
$cours_code[]='9999';
$cours_libelle[]='NC';
$cours_libelle_a[9999]="NC";

$tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$ri_user_liste)){
   if($_POST['nom']!='' ) {

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
 elseif ( $ci2=="date_modif" or $ci2=="date_creation"){
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
    $message = "Fiche <b>"." - ";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 

    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez saisir votre  nom ! : Recommencez !");

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
 // il faut d'abord supprimer le fichier téléchargé

	 //et qu'une offre de stage n'y est pas rattachée non plus 
   $query = "DELETE FROM $table"
      ." WHERE v_id=".$_GET['del']."";

   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
   
      else{
   echo "<center><b>seul le service com peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$ri_user_liste)){
 //pour modifpar
$_POST['v_modifpar']=$login;
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
   $query .= " WHERE id=".$_POST['v_id']." ";
 echo $query;

  // $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['id']." modifiée <br>";}
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
$v=mysql_fetch_object($result) ;
		$nom= $v->Nom;
         $prenom= $v->$myetudiantsprénom_1;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$v->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		$v_date_modif=mysql_Time($v_date_modif);
   
  echo    "<form method=post action=$URL> ";
 //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        }
         
  //echo"<input type='hidden' name='mod' value=1>";



	echo "<center><h1>$titrevoeux23</h1><br>";

  echo"<center>";  
  echo"       <table><tr>  ";
  
//$nomcomplet=ask_ldap($login,'displayname');
//$prenom=ask_ldap($login,'givenname');
//$nom=ask_ldap($login,'sn');
//$mail=ask_ldap($v_login_etud,'mail');
	 echo "</tr><tr>";
     echo affichechamp('nom ','nom',	$nom,'50',1);
     echo affichechamp('prenom ','prenom',$prenom,'40',1);
	 echo "</tr><tr>";
	      echo affichechamp('email ','email',$v->$myannuairemail_effectif,'50',1);
	     // echo affichechamp('email ','email',$mail[0],'50',1);
				  	 echo "</tr><tr>";  		 
    echo affichechamp('modifié par','modifpar',$v_modifpar,'15',1);
    echo affichechamp('le','date_modif',$v_date_modif,'15',1);
	
		  	 echo "</tr><tr>";
if (isset($choix23_1))
	if(!empty($choix23_1))
		echo affichemenunc('1er choix','v_voeux1',$choix23_1,$v_voeux1);
	else
		 echo affichechamp('1er choix','v_voeux1',$v_voeux1);
if (isset($choix23_2))
	if(!empty($choix23_2))
			echo affichemenunc('2eme choix','v_voeux2',$choix23_2,$v_voeux2);
	else
		 echo affichechamp('2eme choix','v_voeux2',$v_voeux2);
	 		  	 echo "</tr><tr>";
if ($v_voeux5!='')
{
			echo "<td><a href='".$chemin_upload23.$v_voeux5 ."'>"."récupérer le document téléchargé : "."</a>$v_voeux5</td>";
		
//echo affichechamp ('lien','v_voeux2',$v_voeux2,'',1);			
}
//echo affichemenusqlplus('Voeu 1','v_voeux1','CODE','select * from cours','LIBELLE_COURT','',$connexion,'CODE');


//echo affichemenuplus2tab ('Voeu 2','v_voeux2',$cours_libelle,$cours_code,$v_voeux2);


//echo affichemenuplus2tab ('Voeu 3','v_voeux3',$cours_libelle,$cours_code,$v_voeux3);	
echo "</tr><tr>";



		  echo "<td>Commentaire</td>";
		  	  		 echo "</tr><tr>";
					 if ($v_commentaire==''){
						echo "<td colspan=3><textarea   name='v_commentaire' rows=6 cols=60 placeholder=\"".$question_commentaire23_1."\"></textarea></td> ";	
						}
						else
						{
						echo "<td colspan=3><textarea   name='v_commentaire' rows=3 cols=45>$v_commentaire</textarea></td> ";	
						}
echo "</tr><tr>";
    echo "</td></tr><tr><th colspan=6>
	<input type='Submit' name='bouton_annul' value='Annuler'>

 </th></tr>";             
 echo"<td>";

echo "</tr><tr>";
echo "</tr><tr>";
	  //echo afficheonly("","Liste des cours",'b' ,'h3');
	
	echo"   </td>" ; 

 echo"</table></form> "  ;
   
  echo"</center>";
	  }
	  }
 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
   // ne sert plus 
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 
        }

 if ($affichetout)  {
 // --------------------------------------sélection de toutes les fiches et affichage-------------------------------------
 echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;


  // $query.=$where."  ".$orderby;
    $query="SELECT  etudiants.Nom ,etudiants.`Prénom 1` ,etudiants.`Code etu` as codetu,etudiants.`Lib dac` as provenance , annuaire.`Mail effectif`  , departements.dep_libelle, groupes.libelle,etudiants_scol.annee
FROM ligne_groupe
LEFT OUTER JOIN etudiants ON etudiants.`Code etu` = ligne_groupe.code_etudiant
LEFT OUTER JOIN groupes ON groupes.code = ligne_groupe.code_groupe
LEFT OUTER JOIN etudiants_scol ON etudiants_scol.code = etudiants.`Code etu`
LEFT OUTER JOIN annuaire ON upper( etudiants.`Code etu` ) = annuaire.`code-etu`
LEFT OUTER JOIN departements ON etudiants.`Nationalité` = departements.dep_code
WHERE libelle = '".$gpecible23."' ";
      $query.="  ".$orderby;
  // echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
list($jour,$mois,$annee) = explode("/",$datelimitevoeux23);
$moins1jour = date("d/m/Y", mktime(0, 0, 0, date($mois), date($jour)-1,  date($annee)));
echo "<a href=default.php> Revenir à l'accueil<br><br></a>";
echo "<center>$titrevoeux23<br>";
if ($datedebutvoeux23!='')
{echo "date debut <b>$datedebutvoeux23</b>  ";}
echo "date fin <b>$moins1jour à 23h59</b>  ";
echo "<br>groupe cible: <b> $gpecible23 </b> ";
echo "</center>";
if ($nombre>0){

echo"<center> <h2>Liste des   ";
echo $nombre;
echo" élèves </h2></center>  ";}
else{
echo"<center> <h2>Il n'y a  pas d'inscrit pour l'instant   ";
echo" </h2></center>  ";}

echo "<a href=#bas> Pour envoyer un mail aux etudiants sans voeux</a>";

//echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] > Ajouter un voeu </a><br>";


if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";

        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
//echo afficheentete('numero etu','v_num_etudiant',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('Nom','etudiants.Nom',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo"<th>Prénom</th>";
echo"<th>Mail</th>";
echo afficheentete('Groupe princ','etudiants_scol.annee',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
if (isset($choix23_1))echo"<th>voeu1</th>";
if (isset($choix23_2))echo"<th>voeu2</th>";
//echo afficheentete('voeu1','v_voeux1',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo afficheentete('voeu2','v_voeux2',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
//echo afficheentete('voeu3','v_voeux3',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo"<th>Document</th>";
echo"<th width=60>Commentaire</th>";
echo"<th></th>";
// on initialise les listes emails
$listemail='';
$listemail2='';
$j=0;
//on initialise  $csv_output
 $csv_output="";
 $csv_output .="nom".";"."prenom".";"."mail".";"."groupe".";";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";}
$csv_output .= "\n";
// on parcourt la selection du groupe cible
while($universite=mysql_fetch_object($result)) {
//on récupère les champs liés
		$nom= $universite->Nom;
         $prenom= $universite->$myetudiantsprénom_1;
		 $gprprincipal=	$universite->annee;
		$mail=$universite->$myannuairemail_effectif;
		$codeetu=$universite->codetu;
		$csv_output .=$nom.";".$prenom.";".$mail.";".$gprprincipal.";";
// pour chaque eleve du groupe on recupere ses voeux
   $query2="SELECT  voeux_eleves. * 
FROM voeux_eleves
WHERE v_id_sondage='".$idsondage23."' and v_num_etudiant='".$codeetu."'
";
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
   // normalement un seul voeu par eleve et idsondage
while($universite2=mysql_fetch_object($result2)) {

 //on fait une boucle pour créer les variables issues de la table voeux et on leur affecte le resultat du select
   foreach($champs as $ci2){
   $$ci2=$universite2->$ci2;
   }
		  } // fin du while
		  //pour l'export excel
		   foreach($champs as $ci2){
   //$csv_output .= $$ci2.";";
      $csv_output .= nettoiecsvplus($$ci2);
   }
   $csv_output .= "\n";
		  // on cree les lignes du tableau
      echo"   <tr><td>" ;
	 // echo $v_num_etudiant;
	  	//  echo"   </td><td>" ;
		  echo $nom;
	  	  echo"   </td><td>" ;
		  echo $prenom;
	  	  echo"   </td><td>" ;
		  echo "<a href=mailto:".$mail.">".$mail."</a>";		  
		  	  	  echo"   </td><td>" ;
		  echo $gprprincipal;
	if (isset($choix23_1))
		{
		  echo"   </td><td>" ;
				  if ($v_voeux1!=''){
		 echo  $v_voeux1;}
		 else{
		 echo 'NC';
		 }
		}
	if (isset($choix23_2))
		{
		  echo"   </td><td>" ;
				  if ($v_voeux2!=''){
		 echo  $v_voeux2;}
		 else{
		 echo 'NC';
		}
	}  
	  echo"   </td><td>" ;
      echo $v_voeux5 ;	
	  echo"   </td><td>" ;
      echo $v_commentaire ;
	  
	  echo"   </td><td>" ;
	  	 if($v_id !=''){
    if($login=='administrateur'){ 
	  echo "<A href=". $URL."?del=$v_id onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce voeu?')\">-Sup- </A>";  
	  }
     echo "<A href=". $URL."?mod=$v_id>détails</A>";
	 }
	  	 if($v_voeux5 !=''){
	  echo "<a href='".$chemin_upload23.$v_voeux5 ."'>"."-doc téléchargé"."</a>"; 
		 }		 
	 
     echo"        </td> </tr>";

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
