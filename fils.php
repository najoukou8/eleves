<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Etes vous sûr de vouloir valider cette action ? ( pas d'annulation ultérieure possible )");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<title>gestion des contributions</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">

<?
require ("param.php");
require ("function.php");
require ("style.php");

echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);


if (!isset($_POST['ajoutdoc'])) $_POST['ajoutdoc']='';
if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['bouton_adddoc'])) $_POST['bouton_adddoc']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_POST['adddoc'])) $_POST['adddoc']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_GET['adddoc'])) $_GET['adddoc']='';
if (!isset($_GET['addreport'])) $_GET['addreport']='';
if (!isset($_POST['addreport'])) $_POST['addreport']='';
if (!isset($_POST['addcontribfinal'])) $_POST['addcontribfinal']='';
if (!isset($_GET['addcontribfinal'])) $_GET['addcontribfinal']='';

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

$idtut='';
$idref='';
$nometud='';
$messagem='';
$destmail='';
$listeouinon=array('oui','non') ;
$listeouinonnc=array('oui','non','NC') ;
// c pas un etudiant  acr on est ds le rep eleves
$isetudiant=0;

$URL =$_SERVER['PHP_SELF'];;
$table="fil_discussion";
//on cree un tableau $champs[] avec les noms des colonnes de la table universite et leur taille
//$result = mysql_query("SHOW COLUMNS FROM $table");
//if (!$result) {
 //  echo 'Impossible d\'exécuter la requête : ' . mysql_error();
 //  exit;
//}
//if (mysql_num_rows($result) > 0) {
 //  while ($row = mysql_fetch_assoc($result)) {

 //     $champs[]= $row["Field"];
//	  $type[]= $row["Type"];
//   }
//}
$champs=champsfromtable($table);
$taillechamps=champstaillefromtable($table);
//on remplit 2 tableaux avec les noms-codes enseignants
$sqlquery2="SELECT * FROM enseignants order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind2=$v["id"];
$ind3=$v["uid_prof"];
//on remplit 3 tableaux associatif avec les noms enseignants pour le select du formulaire
$enseignants_nom[$ind2]=$v["nom"];
$enseignants_prenom[$ind2]=$v["prenom"];
$enseignants_email[$ind2]=$v["email"];
$enseignants_uid[$ind2]=$v["uid_prof"];
//tableau associatif pour récupérer les emails à partir du login
$enseignants_email_connecte[$ind3]=$v["email"];
}
// TEST
//$login='patouilm';

if ($login !='administrateur' and $login !='re'){


// si c'est un etudiant présent dans l'annuaire AD
//if($isetudiant){
//on recupere le mail de la personne connectee dans l'annuaire
$maillogin=ask_ldap($login,'mail');
$mailconnecte=$maillogin[0];
if ($mailconnecte=='INEXISTANT DANS ANNUAIRE'){
$mailconnecte='';
}
//si c'est un enseignant on prend le mail ds le tableau associatif
//$mailconnecte=$enseignants_email_connecte[$login];
}else {
$mailconnecte='';
}

// POUR LES TESTS ON FORECE à ETUDIANT
//$isetudiant=0;


//si on vient de valider un ajout ou une modif il faut remmettre l'id univ ds le get_var
if ($_POST['id_stage']!=''){
$_GET['filtre_id']=$_POST['id_stage'];
}
// pour le cas où  on vient de cliquer sur un entete de colonne 
$filtre="filtre_id=".$_GET['filtre_id'];
//si on vient d'un stage
if ($_GET['filtre_id']!=''){
$where=" where fil_discussion.id_stage=".$_GET['filtre_id']." ";

// il faut récupérer les ids des tuteurs GI et reférent
$query= "select stages.*,etudiants.Nom,etudiants.`Prénom 1` as prenom,annuaire.`mail effectif`as mailetud, annuaire.`Uid`,entreprises.nom as entreprisenom from stages left outer join etudiants on etudiants.`Code etu`=stages.code_etudiant
left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu` 
left outer JOIN entreprises ON stages.code_entreprise = entreprises.code 
where  code_stage=".$_GET['filtre_id'];
//echo $query;
$result=mysql_query($query,$connexion );
if (mysql_num_rows($result)==1){
$e=mysql_fetch_object($result);
$idtut=$e->code_tuteur_gi;
$idref=$e->code_suiveur;
$login_tuteur=$e->login_tuteur;
$login_suiveur=$e->login_suiveur;
$sujetstagehtml=$e->sujet;
$email_tuteur_indus=$e->email_tuteur_indus;
$nomentreprisehtml=$e->entreprisenom;
$nometudhtml="<a href=mailto:".$e->mailetud .">".$e->Nom ." ". $e->prenom . " </a>"; 
$nometud=$e->Nom ." ". $e->prenom ; 
$loginetud=$e->Uid;
$type_de_stage=$e->type_de_stage;
}
// On vérifie si le connecté peut avoir acces à ce fil 
// c'est soit l'etudiant , soit un personnel et un stage non confidentiel , soit le tuteur ou le referent , soit un admin
if (($isetudiant and $login==$loginetud) or (!$isetudiant and $e->rapport_confidentiel!='oui') or ($login==$login_tuteur or $login==$login_suiveur) or in_array($login,$re_user_liste) )
	{

// calcul de la liste des semaines
$dureestage=diffdate(mysql_DateTime($e->date_debut),mysql_DateTime($e->date_fin))+1;
//echo "duree du stage : ".$dureestage . " semaines";
$liste_id_reporting=array();

for ($i=1;$i<=$dureestage;$i++)
	{
	$temp=$i;
		if ($i<10){
		$temp="S0".$temp;}
		else
		{
		$temp="S".$temp;}

	$liste_id_reporting[]=$temp;
}
//$nom_univ=$tab_univ_a[$_GET['filtre_id']];

if ($_GET['env_orderby']=='') {$orderby= '';}
	else{
	$orderby=" order by ".urldecode($_GET['env_orderby']);
	if  ($_GET['env_inverse']!="1"){
                  $orderby=$orderby." desc";}
	}


   //seules les personnes autorisées ont acces 
// if(in_array($login,$re_user_liste) or  $login ==$login_tuteur or  $login == $login_suiveur or $login == $loginetud){// on met tout le monde pour l'instant :tests
if (1){
	$affichetout=1;


// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$re_user_liste) or  $login ==$login_tuteur or  $login == $login_suiveur or $login == $loginetud){
 // il faut un texte ou alors on est en précense d'un reporting
   if($_POST['texte']!='' or $_POST['id_reporting']!='' )
   {
   // on vérifie si on a pas dépassé la date limite des contrib

   if (diffdatejours(mysql_DateTime($e->date_fin))<14 or  $login == 'patouilm')
   {
   $nombre=0;
  if( substr($_POST['id_reporting'],0,1)=='S' ) {
   // on vérifie que le id_reporting est unique 
		$sqlquery="SELECT id_reporting FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and id_reporting='".$_POST['id_reporting']."'";
		//echo $sqlquery;
		$resultat2=mysql_query($sqlquery,$connexion );
   $nombre= mysql_num_rows($resultat2);
  }
   if ($nombre ==0)
   {
 $_POST['modifpar']=$login;
  $_POST['contributeur']= $login;

if ($_POST['envoi_mail']=='oui' and $email_tuteur_indus!='' and $login != 'patouilm' ){
// on ajoute le maitre de stage
$destmail=$email_tuteur_indus;}
         // On prepare l'email : on initialise les variables
	
$objet = "ajout d'un element de discussion de la part de " .$mailconnecte;
$messagem .= "stage de " .$nometud ."\n";
$messagem .= stripslashes($_POST['texte'])."\n"  ;
if($_POST['id_reporting']!=''){
	$messagem .= "meteo :".$_POST['meteo']."\n"  ;
	if($_POST['id_reporting']!='S99'){
	$messagem .= "reporting :".$_POST['id_reporting']."\n"  ;	
	$messagem .= "position timeline :".$_POST['etape_timeline']."\n"  ;
	$messagem .= "ecarts par rapport au projet : ".stripslashes($_POST['ecarts_projet'])."\n"  ;
	$messagem .= "analyse ecarts  : ".stripslashes($_POST['analyse_ecarts_projet'])."\n"  ;
	$messagem .= "Actions à mettre en oeuvre  : ".stripslashes($_POST['actions_projet'])."\n"  ;
	}
	else{
		$messagem .= "Résumé du rapport  : ".stripslashes($_POST['resume_rapport'])."\n"  ;
	}
}
$messagem .= "Pour accéder au fil (accès enseignants) : ".$url_personnel."fils.php?filtre_id=".$_POST['id_stage'] ." \n" ;
$messagem .= "Pour accéder au fil (accès élèves) : ".$url_eleve."fils.php?filtre_id=".$_POST['id_stage'] ." \n" ;
$messagem .= "\n( Si vous êtes maître de stage, vous n'avez pas accès au fil de discussion )  \n" ;
//on n'envoie plus au referent
//if ($enseignants_email[$idref]!=''){
//$destmail=$enseignants_email[$idref];
//}
if ($enseignants_email[$idtut]!='' and $login != 'patouilm'){
$destmail.=",".$enseignants_email[$idtut];
}
if ($e->mailetud!='' and $_POST['public']=='oui' and $login != 'patouilm'){
$destmail.=",".$e->mailetud;
}
$destmail.=",marc.patouillard@grenoble-inp.fr";
   
 for($i=0;$i<sizeof($champs);$i++) {
	$ci2=$champs[$i];
	$ci3=$taillechamps[$i];
	//debug
	if ($login=='patouilm'){
	echo $i." ".$champs[$i]." ".$taillechamps[$i]."<br>";
	}
//foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 $_POST[$ci2]=tronquerPhrase($_POST[$ci2],$ci3) ;
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="id_fil"){
 //on ne fait rien
 }
 elseif ($ci2=="date_creation" or $ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(),";}
 elseif ($ci2=="liste_dest"){
 $sql1.= $ci2.",";
 $sql2.= "'".$destmail."',";}
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
// echo $query;
      $result = mysql_query($query,$connexion);
       if ($result){
    $message = "Fiche <b>"." - ";
   $message .= "</B> ajoutée !<br>";
   // et on envoie le mail si necessaire
  // if ($_POST['envoi_mail']=='oui'){
   //pour les tests on n'envoie pas le mail 
//echo "<br>pour les tests on n'envoie pas le mail  à ".$destmail."<br>";
//echo "voici le message  à ".$messagem."<br>";
envoimail($destmail,$objet,$messagem);

   //}
   }
	   else {
			  echo affichealerte("erreur de saisie ")." : ". mysql_error();
			  echo "<center>La fiche n'est pas enregistrée</b> </center>";
	    } 
	}
	else
	{
	 echo affichealerte("Code reporting $_POST[id_reporting] existe déjà   ! : Recommencez !");
	}
	} // fin du if diffdate > 15
	 else{  
    echo affichealerte("Vous avez dépassé la date limite de modification du fil   ! : Vous ne pouvez plus que consulter les élément déjà saisis !");
	}
    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez au moins saisir un texte  ! : Recommencez !");
	}
    }
    else{//debut du else $login==
   echo "<center><b>seul les personnes autorisées (tuteur, référent)  peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==
}

// ----------------------------------Ajout du document
if($_POST['ajoutdoc']!='' and $_POST['bouton_adddoc']!='') {
//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$re_user_liste) or  $login ==$login_tuteur or  $login == $login_suiveur or $login == $loginetud){
 
    // on vérifie si on a pas dépassé la date limite des contrib
   if (diffdatejours(mysql_DateTime($e->date_fin))<14 or  $login == 'patouilm')
   {
 $_POST['modifpar']=$login;
   $_POST['contributeur']= $login;
   
 //pb des dates mysql
 //pour les dates
// if ($_POST['envoi_mail']=='oui'){
         // On prepare l'email : on initialise les variables
	
$objet = "ajout d'un document de la part de " .$mailconnecte;
$messagem .= " Un document vient d'être déposé dans le fil de discussion du stage de ".$nometud." \n";
$messagem .= stripslashes($_POST['texte']) ."\n" ;
$messagem .= "Pour accéder au fil (accès enseignants) : ".$url_personnel."fils.php?filtre_id=".$_POST['id_stage'] ." \n" ;
$messagem .= "Pour accéder au fil (accès élèves) : ".$url_eleve."fils.php?filtre_id=".$_POST['id_stage'] ." \n" ;
//on n'envoie plus au ref
//if ($enseignants_email[$idref]!=''){
//$destmail=$enseignants_email[$idref];
//}
if ($enseignants_email[$idtut]!=''){
$destmail.=",".$enseignants_email[$idtut];
}
if ($e->mailetud!='' and $_POST['public']=='oui'){
$destmail.=",".$e->mailetud;
}
$destmail.=",marc.patouillard@grenoble-inp.fr";

//   }
// pour le document 


$fichier = basename($_FILES['docfil']['name']);
$fichier = date('dmyhis')."-".$fichier;
$taille_maxi = 4000000;
$taille = filesize($_FILES['docfil']['tmp_name']);
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.doc', '.pdf','.xls','.ppt','.txt','.docx','.pptx','.xlsx');
$extension = strrchr($_FILES['docfil']['name'], '.'); 
//Début des vérifications de sécurité...
if(!in_array(strtolower($extension), $extensions)) //Si l'extension n'est pas dans le tableau
{
     $erreur = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt ou doc...';
}
if($taille>$taille_maxi)
{
     $erreur = 'Le fichier est trop gros...';
}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
	 //echo "<br>". $_FILES['docfil']['tmp_name'];
    if(move_uploaded_file($_FILES['docfil']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
     {
          echo 'Upload effectué avec succès !';
		  
		  // maintenant on stocke la fiche
		  
		  foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="id_fil"){
 //on ne fait rien
 }
 elseif ($ci2=="date_creation" or $ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(),";}
 elseif ($ci2=="nom_document" ){
  $sql1.= $ci2.",";
 $sql2.= "'".$fichier."',";
 }
 elseif ($ci2=="liste_dest"){
 $sql1.= $ci2.",";
 $sql2.= "'".$destmail."',";}
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
   $message .= "</B> ajoutée !<br>";
      // et on envoie le mail si necessaire
		   if ($_POST['envoi_mail']=='oui'){
//pour les tests on n'envoie pas le mail 
//echo "pour les tests on n'envoie pas le mail  à ".$destmail."<br>";
envoimail($destmail,$objet,$messagem);
		   }
					}
					   else {
					    echo affichealerte("erreur de saisie ")." : ". mysql_error();
					  echo "<center>La fiche n'est pas enregistrée</b> </center>";
					    }
	  
			}//fin du if moveupload
		     else //Sinon (la fonction renvoie FALSE).
		     {
		          echo 'Echec de l\'upload !';
		     }
		}
		else
		{
		     echo $erreur;
		}
	} // fin du if diffdate > 15
	 else{  
    echo affichealerte("Vous avez dépassé la date limite de modification du fil   ! : Vous ne pouvez plus que consulter les élément déjà saisis !");
	}
 


    }
    else{//debut du else $login==
   echo "<center><b>seul les personnes autorisées (tuteur, référent) peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}

// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$re_user_liste)){
// on efface le doc attaché
   $query = "select * FROM $table" ." WHERE id_fil=".$_GET['del']."";
   $result = mysql_query($query,$connexion);
$res=mysql_fetch_object($result) ;
   $nomfich=$res->nom_document;
   if ($nomfich!=''){
      unlink($dossier.$nomfich);
}
   $query = "DELETE FROM $table"
      ." WHERE id_fil=".$_GET['del']."";
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

 if(in_array($login,$re_user_liste)){
 //pour modifpar
$_POST['modifpar']=$login;
    // si on a modifié le id_reporting  on vérifie que le id_reporting est unique 
	$nombre=0;
	if ($_POST['id_reporting'] != $_POST['id_reporting_sauv'])
		{
		$sqlquery="SELECT id_reporting FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and id_reporting='".$_POST['id_reporting']."'";
		$resultat2=mysql_query($sqlquery,$connexion );
   $nombre= mysql_num_rows($resultat2);
		}
   if ($nombre ==0){
//pour les dates
  $_POST['date_creation']=versmysql_Datetimeexacte($_POST['date_creation']);
foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 // Pour les champs dates

   
 if ($ci2=="id_fil"){
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
   $query .= " WHERE id_fil=".$_POST['id_fil']." ";
 // echo $query;

   $result = mysql_query($query,$connexion);
		if($result)
		{
		$message = "Fiche numero ".$_POST['id_fil']." modifiée <br>";
		}
		else 
		{
		$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
		}
	}
	else
	{
	 echo affichealerte("Code reporting $_POST[id_reporting] existe déjà   ! : Recommencez !");
	}
}
else
{
   echo "<b>seul le service des relations entreprises peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";
} //fin du else $login ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where id_fil=".$_GET['mod']." ";
					  //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		$date_modif=mysql_Time($date_modif);
		$date_creation=mysql_Time($date_creation);
//$date_fin= preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $date_fin);
		//on récupère les champs liés		
 echo    "<form method=post action=$URL> ";
    //on sauve le id_reporting avant modif
   $id_reporting_sauv=$universite->id_reporting;
   // et on le met en hidden pour la vérif d'unicité lors de l'update
   echo"<input type='hidden' name='id_reporting_sauv' value=\"".$id_reporting_sauv."\">\n";
 
     //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".$$ci2."\">\n";
        }
         
//  echo"<input type='hidden' name='modif' value=1>";
  echo"<center>";
	if ($etape_timeline!=''){
    

    		echo"<h2>TimeLine PFE</h2>";
  echo "<table border =1 width=600 > ";
		echo "<tr align=center>";
				for ($i=1;$i<=4;$i++)
				{
				if ($etape_timeline==$i){
				echo "<td bgcolor='lightblue'>  $i  </td>";
				}else{
				echo "<td >  $i  </td>";
				}
				}
				echo "</table>";
				}
  		echo"<h2>Rappel des semaines précédentes et de la météo associée</h2>";
		// on contruit le tableau des météos
		$tableau_id_reporting=array();
		$tableau_meteo=array();
		$sqlquery="SELECT * FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL) order by id_reporting ";

		//echo $sqlquery ;
		$resultat2=mysql_query($sqlquery,$connexion );
		while ($v=mysql_fetch_array($resultat2)){
			$tableau_id_reporting[]=$v["id_reporting"];
			$tableau_meteo[]=$v["meteo"];
		}
		echo "<table border =1 width=600 > ";
		echo "<tr align=center>";
		foreach($liste_id_reporting as $ci3){

			if (current($tableau_id_reporting) == $ci3)
			{
			echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)].">  ".$ci3."  </td>";
			next($tableau_meteo);
			next($tableau_id_reporting);
			}
			else
			{
			echo "<td  > $ci3 </td>";
			}
			//echo current($tableau_id_reporting)."---".current($tableau_meteo)."---".$ci3.'/';
		}
		echo" </tr></table>";
		echo afficheonly("","Informations sur la contribution",'b' ,'h3');
  echo"       <table><tr>  ";
  //on met en hidden le id_stage
  echo"<input type='hidden' name='id_stage' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";

 
		  		if ($id_reporting!='' ){
				
				if( $id_reporting!='S99'){
					echo affichemenu('code reporting','id_reporting',$liste_id_reporting,$id_reporting);
					if ($etape_timeline !='')
					{
						//echo affichemenu('index timeline','etape_timeline',$liste_etape_timeline,$etape_timeline);
						echo affichemenuplus2tab ('étape','etape_timeline',$liste_etape_timeline_libelle,$liste_etape_timeline,$etape_timeline);
						}
					}
				if ($meteo !=''){
					echo affichemenucouleur('meteo','meteo',$liste_meteo,$meteo,$liste_couleurs_meteo);
				 }
				if ($id_reporting!='S99'  ){
				echo "</tr><tr>";
				echo "<td colspan=3>Les écarts par rapport au projet<br><textarea name='texte' rows=3 cols=65>".$ecarts_projet."</textarea></td> ";	
				echo "</tr><tr>";
				echo "<td colspan=3>Analyse des écarts<br><textarea name='texte' rows=3 cols=65>".$analyse_ecarts_projet."</textarea></td> ";	
				echo "</tr><tr>";
				echo "<td colspan=3>Actions à mettre en oeuvre pour corriger ces écarts<br><textarea name='texte' rows=3 cols=65>".$actions_projet."</textarea></td> ";	
				}else
				{
				echo "</tr><tr>";
				echo "<td colspan=2>résumé du rapport (3000 caractères maxi )<br><textarea name='resume_rapport' rows=4 cols=65>".$resume_rapport."</textarea></td> ";	
echo "</tr><tr>";
				}
				
				}
				echo "</tr><tr>";
		   echo "<td colspan=3>message<br><textarea   name='texte' rows=10 cols=65>".$texte."</textarea></td> ";
	 echo "</tr><tr>";
     echo affichechamp('contributeur','contributeur',$contributeur,'',1);
	 //echo affichechamp('id','id_fil',$id_fil,'','');
	 	 echo affichechamp('date creation','date_creation',$date_creation,15,1);
echo "</tr><tr>";


			echo afficheradio ('Envoi d\'un mail d\'information au maître de stage','envoi_mail',$listeouinon,$envoi_mail,'') ;
			
		
	     echo affichechampsipasvide('destinataires mail','liste_dest',$liste_dest,'50',1);

	      echo afficheradio('public','public',$listeouinon,$public,'');
	 		  echo "</tr><tr>";		  
		  	      //echo afficheradio('visite','visite',$listeouinonnc,$visite,'');
		//echo afficheradio('contact telephone','contact_telephone',$listeouinon,$contact_telephone,'');
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
 //---------------------------------------c'est kon a cliqué sur le lien ajouter discussion
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		
		
  echo    "<form method=post action=$URL> ";
		foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".$$ci2."\">\n";
        }
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
  //pour apres la sortie du formulaire retrouver la selection en cours
  echo"<input type='hidden' name='id_stage' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
  echo afficheonly("","Participer au fil de discussion",'b' ,'h3');
 echo "</tr><tr>";


// si etudiant pas de modif du  choix public possible

			if (!$isetudiant){
            echo afficheradio ('contribution publique','public',$listeouinon,$public,'oui') ;}
			else{
			  echo"<input type='hidden' name='public' value=\"oui\">"."\n";
			  }
			   echo "</tr><tr>";
			 if ($email_tuteur_indus!='')
			{
			echo affichechamp('email maitre de stage','aff_email_indus',$email_tuteur_indus,30,1);
			echo afficheradio ('Envoi d\'un mail d\'information à l\'industriel au maître de stage','envoi_mail',$listeouinon,$envoi_mail,'non') ;
			}
//			echo afficheradio ('Visite','visite',$listeouinonnc,$visite,'NC') ;
			echo "</tr><tr>";
//			echo afficheradio('contact telephone','contact_telephone',$listeouinon,$contact_telephone,'non');

 echo "</tr><tr>";
	echo "<td colspan=2>message (apparait dans le fil de discussion)<br><textarea name='texte' rows=10 cols=65>".$texte."</textarea></td> ";	


			echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'  >
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }
		
		 if($_GET['adddoc']!=''or $_POST['adddoc']!='')  {
   $affichetout=0;
//---------------------------------------c'est kon a cliqué sur le lien ajouter document
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
	echo "	<form method='POST' action=$URL enctype='multipart/form-data'>";
	  echo"<input type='hidden' name='ajoutdoc' value=1>";
	    echo afficheonly("","Joindre un document (livrables notamment)<br> ATTENTION taille maxi 4 Mo",'b' ,'h3','',0);
	    //pour apres la sortie du formulaire retrouver la selection en cours
  echo"<input type='hidden' name='id_stage' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
     //On limite le fichier à 100Ko -->
    echo " <input type='hidden' name='MAX_FILE_SIZE' value='4000000'>";
	  echo"       <table><tr>  ";
   echo "  Fichier : <input type='file' name='docfil'>";
              if (!$isetudiant){
            echo afficheradio ('contribution publique','public',$listeouinon,$public,'oui') ;}
			else{
			  echo"<input type='hidden' name='public' value=\"oui\">"."\n";
			  }
echo affichemenu ('type de document livrable','type_doc_livrable',$liste_livrables_pfe,'NC') ;
			  // on envoie systematiquement (pas de mail au maitre de stage pour un doc)
 echo"<input type='hidden' name='envoi_mail' value=\"oui\">"."\n";
			//echo afficheradio ('Envoi d\'un mail d\'information au maître de stage','envoi_mail',$listeouinon,$envoi_mail,'non') ;

			 echo "</tr><tr>";
	echo "<td colspan=2>message (apparait dans le fil de discussion)<br><textarea name='texte' rows=10 cols=65>".$texte."</textarea></td> ";	
	echo "</tr><tr>";
    echo "<td> <input type='submit' name='bouton_adddoc' value='Envoyer le fichier' onClick=\"return confirmSubmit()\">";
	 echo " <input type='submit' name='bouton_annuldoc' value='Annuler'></td>";
echo "</form>";
		


    echo"</center>";


        }
		
 if($_GET['addreport']!=''or $_POST['addreport']!='')  {
   $affichetout=0;
//---------------------------------------c'est kon a cliqué sur le lien ajouter reporting

// on cherche le max id reporting
		$sqlquery="SELECT max(id_reporting) as maxidreporting FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL)  ";
		$resultat2=mysql_query($sqlquery,$connexion );
		$w=mysql_fetch_array($resultat2);
		$maxid_reporting=$w["maxidreporting"];
// on cherche le max etape timeline
		$sqlquery="SELECT max(etape_timeline) as maxtimeline FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL)  ";
		$resultat2=mysql_query($sqlquery,$connexion );
		$w=mysql_fetch_array($resultat2);
		$maxtimeline=$w["maxtimeline"];


 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
   echo "<center>";
		echo"<h2>Rappel des semaines précédentes et de la météo associée</h2>";

		// on contruit le tableau des météos
		$tableau_id_reporting=array();
		$tableau_meteo=array();
		$sqlquery="SELECT * FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL) order by id_reporting ";

		//echo $sqlquery ;
		$resultat2=mysql_query($sqlquery,$connexion );
		while ($v=mysql_fetch_array($resultat2)){
			$tableau_id_reporting[]=$v["id_reporting"];
			$tableau_meteo[]=$v["meteo"];
		}
		echo "<table border =1 width=600 > ";
		echo "<tr align=center>";
		foreach($liste_id_reporting as $ci3){

			if (current($tableau_id_reporting) == $ci3)
			{
			echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)].">  ".$ci3."  </td>";
			next($tableau_meteo);
			next($tableau_id_reporting);
			}
			else
			{
			echo "<td  > $ci3 </td>";
			}
			//echo current($tableau_id_reporting)."---".current($tableau_meteo)."---".$ci3.'/';
		}
		echo" </tr></table>";
	 echo    "<form method=post action=$URL> ";
	 
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
  //pour apres la sortie du formulaire retrouver la selection en cours
  echo"<input type='hidden' name='id_stage' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
  echo afficheonly("","Réaliser le reporting opérationnel ",'b' ,'h3');
 echo "</tr><tr>";

			  echo"<input type='hidden' name='public' value=\"oui\">"."\n";
			  
			//echo affichechamp ('Envoi d\'un mail d\'information ','envoi_mail',$envoi_mail,'3','1') ;
			 //echo"<input type='hidden' name='envoi_mail' value=\"oui\">"."\n";
		if ($maxid_reporting == '' )$temp=-1;
		else $temp= array_search($maxid_reporting,$liste_id_reporting);
		//echo "temp".$temp;


			echo affichemenu('code reporting','id_reporting',$liste_id_reporting,$liste_id_reporting[$temp+1]);
						echo affichemenuplus2tab ('étape','etape_timeline',$liste_etape_timeline_libelle,$liste_etape_timeline,$maxtimeline);
						 echo "</tr><tr>";
						 if ($email_tuteur_indus!='')
			{
			echo affichechamp('email maitre de stage','aff_email_indus',$email_tuteur_indus,30,1);
			echo afficheradio ('Envoi d\'un mail d\'information à l\'industriel au maître de stage','envoi_mail',$listeouinon,$envoi_mail,'non') ;
			}

//			echo afficheradio ('Visite','visite',$listeouinonnc,$visite,'NC') ;
			echo "</tr><tr>";
//			echo afficheradio('contact telephone','contact_telephone',$listeouinon,$contact_telephone,'non');

echo affichemenucouleur('meteo','meteo',$liste_meteo,'VERT',$liste_couleurs_meteo);

			
 echo "</tr><tr>";
	echo "<td colspan=2>message (apparait dans le fil de discussion)<br><textarea name='texte' rows=10 cols=65>".$texte."</textarea></td> ";	
echo "</tr><tr>";
	echo "<td colspan=2>Les écarts par rapport au projet<br><textarea name='ecarts_projet' rows=4 cols=65>".$ecarts_projet."</textarea></td> ";	
echo "</tr><tr>";
	echo "<td colspan=2>Analyse des écarts<br><textarea name='analyse_ecarts_projet' rows=4 cols=65>".$analyse_ecarts_projet."</textarea></td> ";	
echo "</tr><tr>";
	echo "<td colspan=2>Actions à mettre en oeuvre pour corriger ces écarts<br><textarea name='actions_projet' rows=4 cols=65>".$actions_projet."</textarea></td> ";	


			echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter' onClick=\"return confirmSubmit()\">
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";

        }	

		
		
 if($_GET['addcontribfinal']!=''or $_POST['addcontribfinal']!='')  {
   $affichetout=0;
//---------------------------------------c'est kon a cliqué sur le lien ajouter doc final 


 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
   echo "<center>";
		echo"<h2>Rappel des semaines précédentes et de la météo associée</h2>";

		// on contruit le tableau des météos
		$tableau_id_reporting=array();
		$tableau_meteo=array();
		$sqlquery="SELECT * FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL) order by id_reporting ";

		//echo $sqlquery ;
		$resultat2=mysql_query($sqlquery,$connexion );
		while ($v=mysql_fetch_array($resultat2)){
			$tableau_id_reporting[]=$v["id_reporting"];
			$tableau_meteo[]=$v["meteo"];
		}
		echo "<table border =1 width=600 > ";
		echo "<tr align=center>";
		foreach($liste_id_reporting as $ci3){

			if (current($tableau_id_reporting) == $ci3)
			{
			echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)].">  ".$ci3."  </td>";
			next($tableau_meteo);
			next($tableau_id_reporting);
			}
			else
			{
			echo "<td  > $ci3 </td>";
			}
			//echo current($tableau_id_reporting)."---".current($tableau_meteo)."---".$ci3.'/';
		}
		echo" </tr></table>";
	 echo    "<form method=post action=$URL> ";
	 	   //on fait une boucle pour remettre en hiden tous les champs  de la table 
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
    foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".$$ci2."\">\n";
        }
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
  //pour apres la sortie du formulaire retrouver la selection en cours
  echo"<input type='hidden' name='id_stage' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
  echo afficheonly("","Résumé du projet qui aparaitra dans le booklet PFE ",'b' ,'h3');
 echo "</tr><tr>";
 	echo "<td colspan=2><a href=http://genie-industriel.grenoble-inp.fr/entreprise/gi-questionnaire-pfe-2011-370032.kjsp 
 target=new> Cliquez ici pour remplir le questionnaire PFE </td> ";
 echo "</tr><tr>";
 // on n'envoie pas de mail au maitre de stage
 			  echo"<input type='hidden' name='envoi_mail' value=\"non\">"."\n";
	
			  echo"<input type='hidden' name='public' value=\"oui\">"."\n";
			  echo"<input type='hidden' name='id_reporting' value=\"S99\">"."\n";
			//echo affichechamp ('Envoi d\'un mail d\'information ','envoi_mail',$envoi_mail,'3','1') ;
			 //echo"<input type='hidden' name='envoi_mail' value=\"oui\">"."\n";
			  echo"<input type='hidden' name='etape_timeline' value=\"10\">"."\n";
		   

//			echo afficheradio ('Visite','visite',$listeouinonnc,$visite,'NC') ;
			echo "</tr><tr>";
//			echo afficheradio('contact telephone','contact_telephone',$listeouinon,$contact_telephone,'non');

//echo affichemenucouleur('meteo','meteo',$liste_meteo,'VERT',$liste_couleurs_meteo);

			
 echo "</tr><tr>";
	echo "<td colspan=2>message (apparait dans le fil de discussion)<br><textarea name='texte' rows=10 cols=65>".$texte."</textarea></td> ";	
echo "</tr><tr>";

	echo "<td colspan=2>résumé du rapport (3000 caractères maxi )<br><textarea name='resume_rapport' rows=4 cols=65>".$resume_rapport."</textarea></td> ";	
echo "</tr><tr>";
			   //	echo afficheradio ('Envoi d\'un mail d\'information au maître de stage','envoi_mail',$listeouinon,$envoi_mail,'non') ;


			echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter' onClick=\"return confirmSubmit()\">
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";

        }
		
 if ($affichetout)  {
echo"<BODY> <table width=100% height=100%><tr><td>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage
// ordre par defaut
if($orderby==''){
$orderby="order by $table.date_creation desc";
}
// si c'est un etudiant il faut ne pas montrer les contrib non publiques
if ($isetudiant){
$where.= " and $table.public = 'oui' ";

}

   $query = "SELECT $table.*,stages.* FROM $table 
	 left outer join stages on fil_discussion.id_stage=stages.code_stage
   left outer join etudiants on stages.code_etudiant=`Code etu`  ";
   $query.=$where."  ".$orderby;
   
   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0)
	{
	echo"<center><h2>Liste des   ";
	echo $nombre;
	echo" contributions pour le stage de  $nometudhtml</h2> </center> ";
	}
	else{
	echo"<center> <h2>Il n'existe pas de contributions    ";
	echo" pour le stage de  $nometudhtml</h2> </center>  ";
	}
	 echo "<table>"; echo"<tr>";
	 echo "<td><b>Entreprise</b></td>";
	 echo "<td colspan=1><input type=text  readonly size=120 value=\"".$nomentreprisehtml."\"></td> ";
	 echo"</tr><tr>";
	 echo "<td><b>Sujet du stage:</b></td>";
	 echo "<td colspan=1><textarea  readonly name='sujstage' rows=5 cols=100>".$sujetstagehtml."</textarea></td> ";	
	 echo"</tr><tr>";
	 echo "</tr></table>";
	

//$email_etu= ask_ldap('patouilm','mail');
//echo $reponse[0]."<br>";
    echo "<center> Enseignant tuteur :<b> ".$enseignants_nom[$idtut]."</b>";
if ($idref!='')
		{
		echo "  -   enseignant référent: <b>". $enseignants_nom[$idref]."</b>";
		}
	echo "<br><br>";	
	echo "</center>";
echo "<center>";
 echo "<table>";
echo "<td align=left><h3>";
				if ($isetudiant ){
					if($type_de_stage=='11')
						{
						echo "<A href=".$URL."?addreport=1&filtre_id=$_GET[filtre_id] >1-Réaliser le reporting opérationnel</a><br>";
						echo "<A href=".$URL."?adddoc=1&filtre_id=$_GET[filtre_id] >2-Joindre un document (livrables notamment) </a><br>";
						echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] >3-Participer à la discussion </a><br>";
						echo "<A href=".$URL."?addcontribfinal=1&filtre_id=$_GET[filtre_id] >4-Déposer le résumé du projet pour le booklet des PFE   </a><br>";
						echo"<br><a href=etustages.php?mod=".$_GET['filtre_id'].">revenir à la fiche du stage </a>";
						}
						// pour les stages IA
						if($type_de_stage=='3')
						{
						echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] >1-Participer à la discussion </a><br>";
						echo "<A href=".$URL."?adddoc=1&filtre_id=$_GET[filtre_id] >2-Joindre un document  </a><br>";						
						echo"<br><a href=etustages.php?mod=".$_GET['filtre_id'].">revenir à la fiche du stage </a>";
						}
				}
				else
				{
				if(in_array($login,$re_user_liste) or  $login ==$login_tuteur or  $login == $login_suiveur )
					{
					echo "<A href=".$URL."?add=1&filtre_id=$_GET[filtre_id] >1-Participer à la discussion </a><br>";	
					echo "<A href=".$URL."?adddoc=1&filtre_id=$_GET[filtre_id] >2-Joindre un document  </a><br>";	
					}							
				echo"<br><br><a href=stages.php?mod=".$_GET['filtre_id'].">revenir à la fiche du stage </a>";
				}
echo "</td>";
echo "</table>";
echo"<a href=default.php>revenir à l'accueil<br><br><br></a>";
echo "</h3>";

// on construit la timeline
		$sqlquery="SELECT max(etape_timeline) as maxtimeline FROM $table ";
		$sqlquery .=$where;
		$sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL)  ";
		$resultat2=mysql_query($sqlquery,$connexion );
		$w=mysql_fetch_array($resultat2);
		$maxtimeline=$w["maxtimeline"];
		// si on a déjà renseigné la time linne : maxtimeline >0
		if ($maxtimeline>0)
		{
echo"<b><i>TimeLine PFE</i></b>";
  echo "<table border =0 width=500 > ";
		echo "<tr align=center>";
				for ($i=1;$i<=4;$i++)
				{
				if ($i<=$maxtimeline){
				echo "<td bgcolor=lightblue>  $i  </td>";
				}else{
				echo "<td >  $i  </td>";
				}
				}
	echo "</table>";
// on affiche l'image				
				echo "<img  src=".$chemin_images."pfe.png>";
		}
 // on contruit le tableau des météos
   $tableau_id_reporting=array();
   $tableau_meteo=array();
   $tableau_id_fil=array();
   $sqlquery="SELECT id_reporting,id_fil,meteo  FROM $table ";
   $sqlquery .=$where;
      $sqlquery .= " and (id_reporting != '' and id_reporting  is not NULL) order by id_reporting ";
	  
	  //echo $sqlquery ;
$resultat2=mysql_query($sqlquery,$connexion );
if (mysql_num_rows($resultat2)!=0){
				echo"<br><b><i>Rappel des semaines précédentes et de la météo associée</i></b><br>";
				echo"Vous pouvez cliquer sur une semaine pour avoir le détail du reporting";

		while ($v=mysql_fetch_array($resultat2)){
		$tableau_id_reporting[]=$v["id_reporting"];
		$tableau_id_fil[]=$v["id_fil"];
		$tableau_meteo[]=$v["meteo"];
		}
		   echo "<table border =1 width=600> ";
		   echo "<tr align=center>";
		foreach($liste_id_reporting as $ci3){

				if (current($tableau_id_reporting) == $ci3)
				{
				echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)]."> <A href=". $URL."?mod=".current($tableau_id_fil)."&filtre_id=$_GET[filtre_id]>".$ci3." </td>";
				//echo "<td bgcolor=".$correspondance_couleur[current($tableau_meteo)]."> ".$ci3." </td>";
				
				next($tableau_meteo);
				next($tableau_id_reporting);
				next($tableau_id_fil);
				}
				else
				{
				echo "<td > $ci3 </td>";
				}
		//echo current($tableau_id_reporting)."---".current($tableau_meteo)."---".$ci3.'/';
		}
		  echo" </tr></table>";
  }
if ($nombre>0){


echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes , En cliquant sur le nom du contributeur ,vous pouvez lui envoyer un mail</center>";
        echo "<BR><BR><table align=center border=1><tr bgcolor=\"#98B5FF\" > ";
echo afficheentete('date','date_creation',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);		
echo afficheentete('contributeur','contributeur',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('reporting','id_reporting',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);

echo"<th>envoi mail <br>pour maître</th>";
echo"<th>document</th>";
echo"<th>public</th>";
echo"<th>meteo</th>";
echo"<th>message</th>";
echo"<th></th>";
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
     
	  if ($contributeur !='administrateur' and $contributeur !='re'){
//on verifie si c un etudiant
// $isetudiantcontrib=0;
//$reponse=is_in_ldap_groupe($contributeur,$groupe_annuaire_etudiants);
//echo "<br>reponse : $reponse";
// if (is_in_ldap_groupe($contributeur,$groupe_annuaire_etudiants))
// {
// $isetudiantcontrib=1;
// }

//if($isetudiantcontrib){
//on recupere le mail de la personne  dans l'annuaire
$mail=ask_ldap($contributeur,'mail');
$mail=$mail[0];
//si c'est un enseignant on prend le mail ds le tableau associatif
//}else
//{
// $mail=$enseignants_email_connecte[$contributeur];
//}

 $nomcomplet = ask_ldap($contributeur,'displayname');
 }else
 { $mail= '';}
	 //$modifpar=odbc_result($result,"modifpar") ;
      echo"   <tr><td>" ;
	  echo mysql_Time($date_creation);
	  	  echo"   </td><td>" ;
	       if ($mail!='' and $mail!='INEXISTANT DANS ANNUAIRE'){
	        echo "<a href=mailto:".$mail. ">".$nomcomplet[0]."</a>" ;
	  }else{
      echo $contributeur ;}

      echo"   </td><td>" ;
	  if ($id_reporting=='S99' ){
	  		echo "résumé rapport";
		}	  
		elseif ($id_reporting!='' ){
	      echo "<b>".$id_reporting."</b>" ; }
		  else{
		echo "non";
		}		  
      echo"   </td><td>" ;	  
      echo $envoi_mail ;

	  echo"   </td><td>" ;
	  	  if ($nom_document!=''){
      echo "<a href=".$url_personnel."upload/".$nom_document.">".substr($nom_document,13)."</a>";
	  		  echo "<br><br>type document :<br>".$type_doc_livrable."";
	  }
	  echo"   </td><td>" ;
	  if($public !='')
      echo $public ;
	  else echo 'non';
     if ($meteo !=''){				  
				 echo affichemenucouleur('','meteo',$liste_meteo,$meteo,$liste_couleurs_meteo,'disabled');
				 }else 
				 
	  	 echo"   </td><td>" ;
           //echo $texte ;
		   echo "<td colspan=1><textarea  readonly name='texte' rows=3 cols=45>".$texte."</textarea></td> ";	

	  	  	  echo"   </td><td>" ;
			  		    if(in_array($login,$re_user_liste)){
     echo " <A href=".$URL."?del=$id_fil&filtre_id=$_GET[filtre_id] onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette contribution ?')\">";
	 
     echo "sup</A> - ";
															}
     echo "<A href=". $URL."?mod=$id_fil&filtre_id=$_GET[filtre_id]>détails</A>";
     echo"        </td> </tr>";
       }
	  //INUTILE ICI 
	   //echo  "<FORM  action=export.php method=POST name='form_export'> ";
// echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
//echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
//echo "</form>";
	   
echo"</table> ";
  }
  }
  }else{
// si on ne passe pas l'id satge en param on ne fait rien

//tjour vrai  pour que ça marche qd on rajoute and
$where='where 1 ';
//$nom_univ='';
		}
	} // fin du  if (($ietudiant and $login==$loginetud) )
	else
	{
	echo affichealerte("Acces non autorisé à ce fil de discussion ");
	}
  }
  else
	{echo affichealerte("Acces non autorisé sans paramètre de stage");
	}
echo "</BODY></HTML> " ;
mysql_close($connexion);
?>
</body>
</html>