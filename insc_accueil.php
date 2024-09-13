<?php
//error_reporting(error_reporting() & ~E_NOTICE);
// initialisation session
session_start() ;
error_reporting(E_ALL ^ E_NOTICE);  
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>choix voeux accueil</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">


<?



require ("param.php");
require ("function.php");
require ("style.php");
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

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$uesok=array();
$blocue=array(array());
// on tente la  récupération des paramètres depuis la bdd
$query = "SELECT * FROM param_ues_accueil";   
   //echo $query;
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
if ($nombre>0){
while($e=mysql_fetch_array($result)){
$uesok[]=$e['param_ues_accueil_code'];
if ($e['param_ues_accueil_bloc'] !='')
{
	$blocue[$e['param_ues_accueil_bloc']][]=$e['param_ues_accueil_code'];

}

}

}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// pour le php cas



if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';

if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['modif_ects'])) $_POST['modif_ects']='';

if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';

if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';

if (!isset($_POST['sup_multiple'])) $_POST['sup_multiple']='';
if (!isset($_POST['ajout_multiple'])) $_POST['ajout_multiple']='';
if (!isset($_GET['loginacc'])) $_GET['loginacc']='';
if (!isset($_GET['details'])) $_GET['details']='';
if (!isset($_GET['login_acc'])) $_GET['login_acc']='';
if (!isset($_GET['modpriorite'])) $_GET['modpriorite']='';
if (!isset($_POST['mod_priorite'])) $_POST['mod_priorite']='';
if (!isset($_POST['bouton_annul_priorite'])) $_POST['bouton_annul_priorite']='';
$emailacc='';
$message='';
$sql1='';
$sql2='';
$filtre='';
$listeouinon=array('oui','non') ;
 $okfiche=0;
//$login='_popop';
 $messagem='';
$numbloc=array();
$numblocpris=array();
 $tabletemp="annuaire";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
// si c'est ri qui est connecté 
 if(in_array($login,$ri_user_liste)){
 // le login recherche est celui passé en paramètre et on le met ds la var de session
 if ($_GET['loginacc']!=''){
$_SESSION['loginacc']=$_GET['loginacc'];
}
 $loginacc=$_SESSION['loginacc'];
 }
 else {
 // est ce que c'est un compte provisoire devenu définitif ?
 // on recherche avec son nouveau login , son code etu et son ancien login
 $sqlquery="SELECT annuaire.*,etudiants_accueil.*  FROM etudiants_accueil
                  left outer join annuaire on upper(etudiants_accueil.acc_code_etu)=annuaire.`code-etu`
                  where annuaire.UId='".$login."'";
				  //echo  $sqlquery;
$resultat=mysql_query($sqlquery,$connexion);
 // on prend son ancien login
if(mysql_num_rows($resultat)!=0){
$z=mysql_fetch_object($resultat);
 $loginacc=$z->acc_login ;
 $emailacc=$z->$myannuairemail_effectif ;
} // sinon c'est un compte temporaire on prend  le login du connecté
else{
 $loginacc=$login;
}
}

$titre="Inscriptions étudiants en accueil";
if(in_array($login,$ri_user_liste)){
$titre.="<br><a href=etud_accueil.php>Revenir à la liste</a>";
}
// pas utilisé pour l'instant
$courspossible=array('4GUL09A8','4GUL09B8','4GUL09C8','4GUL09D8','4GUC00EE8');
// on forge le where sql
$wherecours = " 0 ";
foreach ($courspossible as $ci){
$wherecours.= " or  code='".$ci."'";
}
// pour l'instant on prend tous les cours
$wherecours=1;

//on remplit 1tableau avec les libelles-code cours
$sqlquery2="SELECT * FROM cours where ".$wherecours ." order by CODE";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$cours_code[]=$v["CODE"] ;
$cours_libelle[]=$v["LIBELLE_COURT"] ;
$cours_libelle_a[$v["CODE"]]=$v["LIBELLE_COURT"];
}
$cours_code[]='9999';
$cours_libelle[]='NC';
$cours_libelle_a[9999]=$v["NC"];




//on verifie qu'il s'agit d'un etudiant en accueil enregistré pour l année courante
$query= "SELECT etudiants_accueil.*  FROM etudiants_accueil where acc_login='".$loginacc."' and acc_annee ='".$annee_accueil_bascule."'";

$result=mysql_query($query,$connexion);
//echo $query;
 //si le login est bien celui d'un etudianten accueil enregistré ou de qqun des ri
 if (mysql_num_rows($result)!=0 or in_array($login,$ri_user_liste)){
	  	 
 // on recupere la ligne de  etudiant dans la table etudiants accueil
$x=mysql_fetch_object($result);
//tjour vrai  pour que ça marche qd on rajoute and
$where='where 1 ';

// on vérifie si on n'est pas connecté avec l'ancien login : 2cas
//if (1){
if (($login!=$x->acc_login )or ($login==$x->acc_login  and $x->acc_code_etu =='') or in_array($login,$ri_user_liste)){
// si c'est bien un etudiant qui a droit  : inscrit def connecté sous son nouveau login  ou prov ou ri

$URL =$_SERVER['PHP_SELF'];;
$table="ligne_insc_acc";
//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille
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

if($_POST['modif_ects']!='') { //--------------- modification crédits ECTS dans bdd-------------------
			$queryects= "update   etudiants_accueil set acc_ects =".$_POST['acc_ects']."  where  acc_login='".$_POST['acc_login']."'";
//echo $query ;
    $resultects = mysql_query($queryects,$connexion ); 
	echo afficheresultatsql($resultects,$connexion);
$_GET['details']='1';
	}		



 if($_POST['ajout_multiple']!='') { //--------------- Ajout de choix multiples-------------------


	//on verifie si on a coché qqchose dans les radio boxes
	$casecoche=0;
		for($i=1;$i<count($blocue);$i++)
		{
			$temp="ajoutlignebloc".$i;
		if (isset($_POST[$temp]))
		{$casecoche=1;}
		}
	//on verifie si on a coché qqchose dans les checkboxes	
		if (isset($_POST['ajoutligne']))
		{
		$var=$_POST['ajoutligne'];
		}
if (isset($var) or $casecoche)   {
	//on ajoute les radio boxes
	for($i=1;$i<count($blocue);$i++)
	{
	//$var[]='5';
	$temp="ajoutlignebloc".$i;
	if (isset($_POST[$temp]))
		{
			if($_POST[$temp]!='')
				{
				$var[]= $_POST[$temp];
				}
		}
	}
	//on recupere les code apogée rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	{
	
		// il faut verifier si cette ligne n'existe pas déjà (appui sur reload)
		$query = "select * from $table  where  liginsc_cours='".$var[$i]."' and liginsc_login='".$_POST['aff_login']."'";
		$result = mysql_query($query,$connexion );
		if (mysql_num_rows($result) ==0)
		{
		// on cree les lignes
		$query = "insert into $table   (liginsc_cours,liginsc_login) values ('".$var[$i]."','".$_POST['aff_login']."')";
		//echo $query;
		$result = mysql_query($query,$connexion ); 
		$message .=  afficheresultatsql($result,$connexion);
				if($result){
						
							$message = "<center> Vos choix ont été enregistrés </center> <br>";
							}
				else
							{echo "<center>probleme lors de l'ajout  : aucun changement effectué</center>";}				
		}
				else
							{echo "<center> vous aviez déjà choisi ce cours  : ajout non  effectué</center>";}		
	}//fin du for
				}
				else{ echo"<center><b>vous n'avez rien coché </b><br>";}  
}

if($_POST['sup_multiple']!='') { //--------------- suppression  de choix multiples-------------------


	//on verifie si on a coché qqchose
if (isset($_POST['supligne'])) {
	$var=$_POST['supligne'];
	//on recupere les code apogée rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	{
	
		

		// on efface  les lignes
			$query= "delete  FROM $table where  $table.liginsc_code_ligne='".$var[$i]."'";
		//echo $query;
		$result = mysql_query($query,$connexion ); 
		$message .=  afficheresultatsql($result,$connexion);
				if($result){
							$message = "<center> Vos choix ont été supprimés </center> <br>";
							}
				else
							{echo "<center>probleme lors de la suppression  : aucun changement effectué</center>";}
	}//fin du for
				}
				else{ echo"<center><b>vous n'avez rien coché </b><br>";}
				}
if($_GET['modpriorite']!='') { //--------------- affichage formulaire modification priorité -------------------


 $query = "SELECT * FROM $table 
					  where liginsc_code_ligne=".$_GET['modpriorite'];
					  //echo $query;

  $result = mysql_query($query,$connexion );
$u=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$u->$ci2;
   }
	$tab_priorite=array();
		  for ($i=0;$i<$_GET['nb_cours_select'];$i++)
		  {
		  $tab_priorite[]=$i+1;
		  }
		  $tab_priorite[]='NC';		 
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";

    echo"<input type='hidden' name='liginsc_code_ligne' value=\"$liginsc_code_ligne\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
  //on met en hidden le id_univ

	   echo "</tr><tr>";
   	  echo affichechamp('code cours','liginsc_cours',$liginsc_cours,'20',1);
	  echo affichechamp('login ','liginsc_login',$liginsc_login,'10',1);
 echo "</tr><tr>";
 if($liginsc_ordre_preference=='')$liginsc_ordre_preference='NC';
 echo  affichemenu ('Priorité','liginsc_ordre_preference' ,$tab_priorite,$liginsc_ordre_preference);

    echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='mod_priorite' value='modifier'><input type='Submit' name='bouton_annul_priorite' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
   $okfiche=1;
	}
				
if($_POST['mod_priorite']!='') { //--------------- modification priorité dans bdd-------------------
		// on vérifie que cette priorité n'est pas déjà utilisée pour les choix de cet étudiant
		$query= "select * from   $table  where liginsc_ordre_preference!='NC' and liginsc_ordre_preference='".$_POST['liginsc_ordre_preference']."' and liginsc_login='".$_POST['liginsc_login']."'";
		 $result = mysql_query($query,$connexion ); 
		 if (mysql_num_rows($result) == 0)
		 {
		//echo "<b>on met à jour la priorité</b>";
			$query= "update   $table set liginsc_ordre_preference='".$_POST['liginsc_ordre_preference']."'  where  $table.liginsc_code_ligne='".$_POST['liginsc_code_ligne']."'";
//echo $query ;
    $result = mysql_query($query,$connexion ); 
	echo afficheresultatsql($result,$connexion);
		}
		else
		{
		echo affichealerte ("Vous avez choisi 2 fois la  priorité ".$_POST['liginsc_ordre_preference']." : la fiche n'a pas été modifiée , recommencez svp <br>",0);
		}
$_GET['details']='1';
	}		
 //------------------------------------------------------------Fin de la saisie
if($_POST['bouton_add']=='Quitter' ){


 //pour modifpar
$_POST['v_modifpar']=$login;
//pour les dates

   $message = "<b> Votre choix a bien été enregistré </B><br>";
      $message .= "<b> Un mail de confirmation va vous être envoyé </B><br><br><br>";

	  // On prepare l'email : on initialise les variables
$objet = "Choix de cours  pour etudiant en accueil :  ".$_POST['aff_prenom'] ."  ".$_POST['aff_nom'] ." ".$_POST['email']."\n";
$query2= "SELECT $table.*,cours.*   FROM $table 
left outer join cours on $table.liginsc_cours=cours.code
where liginsc_login='".$loginacc."'";
 $messagem .= "Vos choix : \n" ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
      $messagem .= "- ".	$u->LIBELLE_COURT  ."-".$u->CODE  ." priorité : ".$u->liginsc_ordre_preference."\n\n" ;
	 $message.=	 "- ".	$u->LIBELLE_COURT  ."-".$u->CODE  ." priorité : ".$u->liginsc_ordre_preference."<br><br> ";
	   //test si les priorités ont été correctement positionnées
	   if (	$u->liginsc_ordre_preference == '' )
		{
			 $message.="<font color='red'><b>ATTENTION !  VOUS N'AVEZ PAS INDIQUE DE PRIORITE POUR LE COURS : "  .$u->LIBELLE_COURT .", Veuillez corriger<br><br></b></font>	 ";
			 $messagem.="	ATTENTION !  VOUS N'AVEZ PAS INDIQUE DE PRIORITE POUR LE COURS : "  .$u->LIBELLE_COURT .", Veuillez corriger\n\n ";
		}
	}
// idem avec autres cours

 $messagem .= "ont bien été enregistrés \n" ;
// On envoi l’email à l'etudiant et aux RI
if ($_POST['email']!=''){
$message .="<b> ".$objet  ."<br><b> ".$messagem; 
envoimail($_POST['email'],$objet,$messagem);
}
//$rimail='marc.patouillard@grenoble-inp.fr';
envoimail($rimail,$objet,$messagem); 
   $okfiche=1;
}




// ----------------------------------Ajout de la fiche
 
if( $_POST['bouton_add']=='enregistrer') {

}


	if(!$okfiche  and $_POST['bouton_annul']!='Annuler' or $_POST['bouton_annul_priorite']=='Annuler'){  
   $affichetout=0;
 //____________________________________________________On affiche les choix en cours pour cet etudiant
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
	
		


  //echo"<input type='hidden' name='ajout' value=1>";



	echo "<center><h1>$titre</h1>";

    echo "<br><b>saisissez vos voeux ci dessous</b>"; 

  echo"       <table><tr>  ";
  
  echo    "<form method=post action=$URL name='form_1'> ";
    echo"<input type='hidden' name='liginsc_modifpar' value=$login>";
//$nomcomplet=ask_ldap($login,'displayname');
//$prenom=ask_ldap($login,'givenname');
//$nom=ask_ldap($login,'sn');
//$mail=ask_ldap($login,'mail');
	 echo "</tr><tr>";
     echo affichechamp('nom ','aff_nom',	$x->acc_nom,'50',1);
     echo affichechamp('prenom ','aff_prenom',$x->acc_prenom,'40',1);
	  
	 echo "</tr><tr>";
	 echo affichechamp('Identifiant ','aff_login',$x->acc_login,'10',1);
	 if ($emailacc==''){
	      echo affichechamp('email ','email',$x->acc_mail,'50',1);
		  }
		  else{
		  echo affichechamp('email ','email',$emailacc,'50',1);
		  }
	     // echo affichechamp('email ','email',$mail[0],'50',1);
		  		 
		  	 echo "</tr><tr>";

 
   echo"       </table>  ";
 if ($_GET['details']!='1' and $_POST['bouton_annul_priorite']!='Annuler' )
 {
$listeGroupesCours="";	
$listeGroupesCoursParents="";	 
echo "<td> <b>Inscriptions cours  GI</b></td>";

  echo "<table border=1>";
	echo "<th></th><th>Code cours</th><th>Intitule</th><th>Crédits ECTS</th><th>Priorité</th><th>Groupe</th><th>EdT du groupe</th>";
	$query2= "SELECT ligne_insc_acc.*,cours.*,groupes.libelle as libelle_gpe   FROM ligne_insc_acc 
left outer join cours on ligne_insc_acc.liginsc_cours=cours.code
left outer join groupes on ligne_insc_acc.liginsc_code_groupe=groupes.code
where liginsc_login='".$x->acc_login."' order by LIBELLE_COURT";
 $query2;
    $result2 = mysql_query($query2,$connexion ); 
	$totects=0;
	$ectspartiel=0;
	$sauvsem='';
	$sem='';
		//on initialise  $csv_output
				$csv_output="";		
 				 $csv_output .= "code;libelle_court;libelle_long;ects;priorite;groupe";					 
				$csv_output .= "\n";
	while($y=mysql_fetch_object($result2)) {
$sem=substr( $y->LIBELLE_COURT,0,2);
		  if ($sauvsem !=  $sem){


switch ($sem){
	case "FL":
	$sem_aff="FLE";
	break;
	case "SI":
	$sem_aff="International semester";
	break;
	case "FI":
	$sem_aff="FILIPE";
	break;	
	default :
	$sem_aff=$sauvsem;
	}
			if( $ectspartiel==0)
			{
			$libectspartiel='';
			}
			else
			{
			$libectspartiel=$ectspartiel;
			}
		 	echo "<tr><td colspan=3 bgcolor=lightgreen align='center'>$sem_aff </td><td bgcolor=lightgreen><b> $libectspartiel</b></td><td colspan=2 bgcolor=lightgreen align='center'></td></tr>";
			$ectspartiel=0;
			$sauvsem =$sem;
			}
echo"   <tr><td>" ;  
	if (array_key_exists($y->liginsc_cours,$fiche_code_ksup))
	{
		if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$y->liginsc_cours].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
	}
	  echo"   </td><td>" ;
     echo  $y->CODE  ;  
      echo"   </td><td>" ;
     echo  $y->LIBELLE_COURT ;
      echo"   </td><td>" ;
     echo  $y->CREDIT_ECTS  ;
	 $totects+=$y->CREDIT_ECTS ;
	 $ectspartiel+=$y->CREDIT_ECTS ;
	 echo"   </td><td>" ;
	 if ( $y->liginsc_ordre_preference=='NC' or $y->liginsc_ordre_preference==''){ echo affichealerte('Attention!<br> priorité obligatoire',0); }else{echo $y->liginsc_ordre_preference; }

	 echo"   </td>";
	 if($y->liginsc_code_groupe=='')
	 {
	 $y->liginsc_code_groupe=0;
	 }
	 echo afficheonlychampsql('','libelle','select * from groupes where  code = '.$y->liginsc_code_groupe.' ','libelle',$connexion,'50');	 
	 if ($y->liginsc_code_groupe !='0')
		{
		// il nous faut le code ADE du gpe 
		$query3="select * from groupes where code= '".$y->liginsc_code_groupe."'";
		//echo $query3;
		    $result3 = mysql_query($query3,$connexion ); 
			$z=mysql_fetch_object($result3);
		// attention si on a des espaces dans les codes ressources on doit les remplacer par des + sinon ADE ne comprend pas
				if (strpos($z->code_ade6,' '))
			$listeGroupesCours.=str_replace(' ','+',$z->code_ade6).",";
			else
			$listeGroupesCours.=$z->code_ade6.",";	
// il faut aussi les codes ADE des groupes  parents
$listeGroupesCoursParents="";
//d'abord niveau +1
// on a le code dans la fiche du groupe 
$codeparentniv1=$z->code_pere;
// si il n 'est pas vide on continue 
if ($codeparentniv1!='')
{
	// on récupère la fiche de ce groupe 
					$query4="select * from groupes where code= '".$codeparentniv1."'";
					$result4 = mysql_query($query4,$connexion ); 
					$za=mysql_fetch_object($result4);	
	
	// on ajoute le code ADE à l'url
	if (strpos($za->code_ade6,' '))
			$listeGroupesCoursParents.=str_replace(' ','+',$za->code_ade6).",";
			else
			$listeGroupesCoursParents.=$za->code_ade6.",";	
	// On continue pour le niveau +2
	//on a le code dans la fiche du groupe 
			$codeparentniv2=$za->code_pere;
// si il n 'est pas vide on continue 
				if ($codeparentniv2!='')
				{
			// on récupère la fiche de ce groupe 
							$query5="select * from groupes where code= '".$codeparentniv2."'";
							$result5 = mysql_query($query5,$connexion ); 
							$zb=mysql_fetch_object($result5);	
			
			// on ajoute le code ADE à l'url
			if (strpos($zb->code_ade6,' '))
					$listeGroupesCoursParents.=str_replace(' ','+',$zb->code_ade6).",";
					else
					$listeGroupesCoursParents.=$zb->code_ade6.",";	
			// On continue pour le niveau +3
//on a le code dans la fiche du groupe 
			$codeparentniv3=$zb->code_pere;
// si il n 'est pas vide on continue 
					if ($codeparentniv3!='')
					{
				// on récupère la fiche de ce groupe 
								$query6="select * from groupes where code= '".$codeparentniv3."'";
								$result6 = mysql_query($query6,$connexion ); 
								$zc=mysql_fetch_object($result6);	
				
				// on ajoute le code ADE à l'url
				if (strpos($zc->code_ade6,' '))
						$listeGroupesCoursParents.=str_replace(' ','+',$zc->code_ade6).",";
						else
						$listeGroupesCoursParents.=$zc->code_ade6.",";	
				// On continue pour le niveau4

			}			

		}
		
}			
			

			
			 //nombres de semaine depuis le debut du projet  ADE
		$numsemaine=diffdate($date_debut_projetADE);
			// depuis 2018 attention on peut changer d'année ADE en année n-1
	if($numsemaine<=0)$numsemaine=0;
		 	//$lien_edt="<a href=http://ade52-inpg.grenet.fr/ade/custom/modules/plannings/direct_planning.jsp?projectId=".$id_projetADE."&login=voirENSGI&password=ensgi&displayConfName=web&weeks=".$numsemaine."&days=0,1,2,3,4,5&resources=".$y->code_ade." target=_blank > Emploi du temps </a>";	
		 $semestre=substr($z->arbre_gpe,-3);
					if($semestre=='S05' or $semestre=='S07' or $semestre=='S09')
						{
							if ($z->code_ade6!='')
							{
								$lien_edt="<a href=".$lien_ade_etr_pers."&name=".$listeGroupesCoursParents.$z->code_ade6."&weeks=3,4,5,6,7,8,9,10,11,12,13,14,15,16&days=0,1,2,3,4,5"." target=_blank ><- Emploi du temps de ce cours pour le $semestre</a>";
						
							}

						}
						else
						{
							if ($z->code_ade6!='')
							{
								$lien_edt="<a href=".$lien_ade_etr_pers."&name=".$listeGroupesCoursParents.$z->code_ade6."&weeks=25"." target=_blank ><- Emploi du temps v6 de ce cours pour le $semestre</a>";
						
							}

						}
						echo afficheonly('',$lien_edt,'font','font size=2','',0);
						
				}	 
	 echo "</tr>";
	 $csv_output .= "\"".$y->CODE."\"".";";
				 $csv_output .= "\"".$y->LIBELLE_COURT."\"".";";
				 $csv_output .= "\"".$y->LIBELLE_LONG."\"".";";
				 $csv_output .= "\"".$y->CREDIT_ECTS."\"".";";
				 if ( $y->liginsc_ordre_preference==''){
				$temp='NC'; }else{$temp= $y->liginsc_ordre_preference; }
				 $csv_output .= "\"".$temp."\"".";";
				 $csv_output .= "\"".$y->libelle_gpe."\"".";";
				 $csv_output .= "\n";
				 
			 $listeGroupesCours.=$listeGroupesCoursParents;
			 }

			 // on rajoute un lien pour l'edt résultant des choix au dessus 
			 			 			$lien_edt="<a href=".$lien_ade_etr_pers."&name=".$listeGroupesCours."&weeks=3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24&days=0,1,2,3,4,5"." target=_blank > Emploi du temps résultant de cet élève </a>";

	 echo "<tr>";
	 switch ($sem){
	case "FL":
	$sem_aff="FLE";
	break;
	case "SI":
	$sem_aff="International semester";
	break;
	case "FI":
	$sem_aff="FILIPE";
	break;	
	default :
	$sem_aff=$sauvsem;
	}
			if( $ectspartiel==0)
			{
			$libectspartiel='';
			}
			else
			{
			$libectspartiel=$ectspartiel;
			}
		 	echo "<tr><td colspan=3 bgcolor=lightgreen align='center'>$sem_aff </td><td bgcolor=lightgreen><b> $libectspartiel</b></td><td colspan=2 bgcolor=lightgreen align='center'></td></tr>";
 
		 echo "<tr>";
	 echo "<td bgcolor=lightgreen colspan=3> TOTAL ECTS $ecole</td><td bgcolor=lightgreen ><b>$totects</b></td>";

			echo "<td></td>";	
			echo "<td></td>";
	 echo afficheonly('',$lien_edt,'','','',0);
	 echo "</tr>";	 
	 
	echo"</table>";

		echo "<br>";
		// test si date limite pas dépassée ou RI

		 if (  diffdatejours(mysql_DateTime($x->acc_date_limite))<0 or in_array($login,$ri_user_liste) or mysql_DateTime($x->acc_date_limite)=='NC'){
	echo"<td><a href=".$URL."?details=1>Détails-Ajouter-Modifier mes inscriptions à GI</a></td>";
	}
	else 
	{
	echo"<td>Vous ne pouvez plus modifier vos choix depuis le ". mysql_DateTime($x->acc_date_limite)."</td>";
	}
	echo "<br>";
	  
		echo "<br>";
echo "<td><b> Inscriptions cours autres ecoles</b></td>";

 echo "<table border=1>";
echo "<th>nom ecole</th><th>filiere</th><th>Crédits ECTS</th>";
	$query2= "SELECT cours_autres_accueil.*   FROM cours_autres_accueil 

where cours_autres_accueil.autcour_login='".$x->acc_login."'";
    $result2 = mysql_query($query2,$connexion ); 
	$totectsautcour=0;

	while($z=mysql_fetch_object($result2)) {

echo"   <tr><td>" ;  
        echo  $z->autcour_nom_ecole  ;
      echo"   </td><td>" ;
     echo  $z->autcour_filiere  ;
	  echo"   </td><td>" ;
     echo  $z->autcour_ECTS  ;
	 	   // pour que le total soit juste on corrige $ectsautcour
	   // on remplace la virgule par le point 
	   $autcour_ECTS=nettoiefloat($z->autcour_ECTS);
	 $totectsautcour+=$autcour_ECTS ;
	 echo "</tr>";
	 }
	 	 echo "<tr>";
	 	 echo "<td bgcolor=lightgreen colspan=2> TOTAL ECTS autres écoles</td><td bgcolor=lightgreen >$totectsautcour</td>";
		 	 echo "</tr>";
	echo"</table>";
	echo "<br>";
		 if (  diffdatejours(mysql_DateTime($x->acc_date_limite))<0 or in_array($login,$ri_user_liste) or mysql_DateTime($x->acc_date_limite)=='NC'){
 echo"<td><a href=autre_cours_accueil.php>Détails-Ajouter-Modifier mes inscriptions </a></td>";
 }
	else 
	{
	echo"<td>Vous ne pouvez plus modifier vos choix depuis le ". mysql_DateTime($x->acc_date_limite)."</td>";
	}
		echo "<br>";
		echo "<br>";
		$totectsgen=$totects+$totectsautcour;
		echo "<table border=1>";
		 echo "<td bgcolor=lightgreen colspan=2><B> TOTAL ECTS</b> </td><td bgcolor=lightgreen ><b>$totectsgen</b></td>";
		echo "</table>";
		echo "<br>";		
		echo "<br>";	
		echo "<table border=1>";
		echo"<tr><td>";
echo "<b>INFORMATIONS A LIRE AVANT DE SAISIR LES CHOIX DE COURS !!!</b> <br>
<b>ATTENTION :  Pour participer à un cours vous devez avoir les pré-requis nécessaires (a vérifier sur le descriptif du cours)  <br>
de plus certains cours ne sont pas ouverts aux étudiants internationaux, le nombre d'étudiants internationaux par cours peut être limité.</b><br>
Vous recevrez prochainement un email de validation de votre programme de cours.<br>
<b>L'emploi du temps  </b>peut être consulté à l'adresse suivante à partir de Juin : <br>";
echo "<a href=".$lien_ade_etr_pers."&resources=".$codeaderesourcegenieindustriel."&weeks=3> emploi du temps</a><br><br>";
		echo"</td></tr><tr><td>";
echo "<b>IMPORTANT INFORMATIONS BEFORE YOU CHOOSE THE COURSES !!! </b> <br>
<b>PAY ATTENTION : Please note that to attend courses you must have the <font color='red'>needed prerequisites</font>,</b>  <br>
also some courses are not open to international students and/or the number of students is limited.<br>
You will soon receive an email confirmation of your curriculum.<br>
<b>The timetable </b> is available from June  at:  <br>";
echo "<a href=".$lien_ade_etr_pers."&resources=".$codeaderesourcegenieindustriel."&weeks=3> Timetable</a><br><br>";

				echo"</td></tr>";
		echo "</table>";
	 
if(!in_array($login,$ri_user_liste)){
echo"	<input type='Submit' name='bouton_add' value='Quitter'>";
echo "<br><b>un mail récapitulatif vous sera envoyé</b>";
}

 echo "</form >";
 if($login == 'administrateur' or in_array($login,$ri_user_liste))
			{
			echo  "<center><FORM  action=export.php method=POST name='form_export'>";
			 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'>  </center><br> "  ;
			echo "</form name='form_export'>";
			}
//echo affichealerte('Patientez quelques instants après avoir cliqué sur enregistrer');


}
//si on affiche détails___________________________________________________________________________

if ($_GET['details']=='1' or $_POST['bouton_annul']=='Annuler' or $_POST['bouton_annul_priorite']=='Annuler')
{
echo "<br><a href=$URL>Revenir page accueil étudiant</a><br><br>";

// modification credits ects
// on a besoin de relire les infos 
$querya= "SELECT etudiants_accueil.*  FROM etudiants_accueil where acc_login='".$loginacc."'" ;
$resulta=mysql_query($querya,$connexion);
$a=mysql_fetch_object($resulta) ;
	
echo "<table border=1>";
	echo "<tr><th colspan=6 align=center>Crédits ECTS</th>";
	echo "</tr><tr>";
	 	  echo affichechamp('Indiquez le nombre de crédits ECTS validé par votre établissement d\'origine','acc_ects',$a->acc_ects,'3');
	echo"<td> <input type='hidden' name='acc_login' value='".$a->acc_login."'>
	<input type='Submit' name='modif_ects' value='enregistrer' onclick=\"return confirm('Etes vous sûr de vouloir enregistrer  cette valeur ?')\"></td>";
		  echo " </td> ";
		 echo "</tr>";	 
	echo"</table>";
// fin modification credits ects


	echo "<table border=1>";
	echo "<th colspan=6 align=center>Voici les cours que vous avez déjà sélectionnés</th>";
	echo "</tr><tr>";
	echo "<th></th><th>Code cours</th><th>Intitule</th><th>Crédits ECTS</th><th>Priorité</th>";
	echo"<th>  <input type='Submit' name='sup_multiple' value='supprimer de ma sélection' onclick=\"return confirm('Etes vous sûr de vouloir enregistrer  ces choix ?')\"></th>";

$query2= "SELECT $table.*,cours.*   FROM $table 
left outer join cours on $table.liginsc_cours=cours.code
where liginsc_login='".$loginacc."' order by LIBELLE_COURT ";
    $result2 = mysql_query($query2,$connexion ); 
$nb_cours_select=mysql_num_rows($result2);
	while($u=mysql_fetch_object($result2)) 
	{
	// on vérifie les UE choisies qui appartiennent à des blocs
	//on met les num des blocs trouvés dans un tableau
	$numblocpris[]=recursive_array_search($u->CODE,$blocue);
		echo"   <tr><td>" ;  
	if (array_key_exists($u->liginsc_cours,$fiche_code_ksup))
	{
		if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$u->liginsc_cours].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
	}
		  echo"   </td><td>" ;
	     echo  $u->CODE;  
	      echo"   </td><td>" ;
	     echo  $u->LIBELLE_COURT  ;
	      echo"   </td><td>" ;
	     echo  $u->CREDIT_ECTS  ;
		  echo"   </td><td align=center>" ;
		  
			if ( $u->liginsc_ordre_preference=='' or  $u->liginsc_ordre_preference=='NC' ){
				
			echo affichealerte('pas de priorité !<br> ',0); 	
echo  "<a href=".$URL."?modpriorite=".$u->liginsc_code_ligne."&nb_cours_select=".$nb_cours_select.">".'<b>Définir</b>'."</a>";					
			}else{
				echo ' <b>'.$u->liginsc_ordre_preference."</b> "; 
echo  "<a href=".$URL."?modpriorite=".$u->liginsc_code_ligne."&nb_cours_select=".$nb_cours_select.">".'modifier'."</a>";				
				}
	  
		  
		 // echo "</form name='form_2'>";
		 echo"</td><td><center><INPUT TYPE=CHECKBOX NAME=supligne[] value=".$u->liginsc_code_ligne."></center>";
		  echo " </td> ";
		 echo "</tr>";
	 }
	echo"</table>";
	echo"   </td>" ; 
	echo "</tr><tr>";
	echo "</tr><tr>";
	if (count($uesok)==0){
echo affichealerte("La liste des cours à choix n'a pas été paramétrée  : contactez votre gestionnaire");
	}
	  //echo afficheonly("","Liste des cours",'b' ,'h3');
	echo "<table border=1>";
	echo "<th colspan=5 align=center>Voici les cours que vous pouvez sélectionner</th>";
	echo "</tr><tr>";
	echo "<th></th><th>Code cours</th><th>Intitule</th><th>Crédits ECTS</th>";
	echo"<th>  <input type='Submit' name='ajout_multiple' value='Ajouter à ma sélection' onclick=\"return confirm('Etes vous sûr de vouloir enregistrer  ces choix ?')\"></th>";
// on recupère les cours auxquels n'est pas inscrit l'etudiant	
	$courspaspriscode = array();
	 $query2 = "SELECT   cours.* FROM cours
where cours.code not in (
	 SELECT distinct cours.CODE FROM cours left outer join ligne_insc_acc on ligne_insc_acc.liginsc_cours=cours.code where ligne_insc_acc.liginsc_login = '$loginacc' )   order by LIBELLE_COURT " ;
//echo 	 $query2;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) 
	{
	//il faut ne laisser que  les ues autorisé de la liste complète et les ues membres d'un bloc où on a déjà choisi une ue mais garder les ue non membre d'un bloc
		if ((in_array($u->CODE,$uesok)) and (!(recursive_array_search($u->CODE,$blocue)) or !(in_array(recursive_array_search($u->CODE,$blocue),$numblocpris))))
		
		
		
				//if (!(in_array($u->CODE,$ueexclues)) )
		{
		$courspaspriscode[]=$u->CODE;
		$courspasprislibel[$u->CODE]= $u->LIBELLE_COURT ;
		$courspasprisects[$u->CODE]=$u->CREDIT_ECTS;	
		}
	}
	//il faut créer un tableau de fusion  pour que les blocs soient contigus 
	$courspaspriscodetrie=array();
	//Je prends le 1er elt
	foreach($courspaspriscode as $uepaspriscodetemp)
		{
		// est ce qu'il existe ds un bloc  ?
			$numbloc=recursive_array_search($uepaspriscodetemp,$blocue);
			//non on le met ds le tableau trié
			if (!$numbloc)
			{		
			$courspaspriscodetrie[]=$uepaspriscodetemp;
			}
			// sinon on verifie si il est place en 1ere position du bloc , on le met ds le tableau trie ainsi que  tout le bloc
			elseif ( $blocue[$numbloc][0]==$uepaspriscodetemp)
			{
				foreach($blocue[$numbloc] as $temp)
				{
					$courspaspriscodetrie[]=$temp;
				}
			}
			else
			{
			// si il n'est pas en 1ere position c'est qu'on l'a déja traité on ne fait rien
			}	
		
		}
	 $bgcolor='bgcolor=lightblue';
	 $sauvnumbloc='';
	foreach($courspaspriscodetrie as $uepaspriscode)
	{
	//$numbloc=recursive_array_search($u->CODE,$blocue);
	$numbloc=recursive_array_search($uepaspriscode,$blocue);
			 
	$changementbloc=0;
		// si ce n'est pas un bloc on affiche les checkboxes
		if (!$numbloc)
		{			
			echo"   <tr><td>" ;  
	      //echo  "<a href='".'http://genie-industriel.grenoble-inp.fr/'.$u->CODE.'/0/fiche___cours/'."'>".'fiche détaillée'."</a>";  
		if (array_key_exists($uepaspriscode,$fiche_code_ksup))
		{		  
		  if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$uepaspriscode].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
		  }
	      echo"   </td><td>" ;
	    // echo  $u->CODE  ;   
		echo $uepaspriscode;
		 echo"   </td><td>" ;
	     //echo  $u->LIBELLE_COURT  ;
		 echo $courspasprislibel[$uepaspriscode];
	      echo"   </td><td>" ;
	     //echo  $u->CREDIT_ECTS  ;
		 echo $courspasprisects[$uepaspriscode];

		 //echo"<td><center><INPUT TYPE=CHECKBOX NAME=ajoutligne[] value=".$u->CODE."></center>";
		 echo"<td ><center><INPUT TYPE=CHECKBOX NAME=ajoutligne[] value=".$uepaspriscode."></center>";
		  echo " </td> ";
		 echo "</tr>";

		 }
		 else
		 // c'est un elt d'un bloc  on affiche les radioboxes
		 {
					if ($sauvnumbloc!=$numbloc)
					 {
						 if ($bgcolor=='bgcolor=lightblue')
						 {
						 $bgcolor='bgcolor=lightgreen';
						 }
						 else
						 {
						 $bgcolor='bgcolor=lightblue';
						 }
					}
		 $sauvnumbloc=$numbloc;
			
		 echo"   <tr><td $bgcolor>" ;  
	      //echo  "<a href='".'http://genie-industriel.grenoble-inp.fr/'.$u->CODE.'/0/fiche___cours/'."'>".'fiche détaillée'."</a>";
		if (array_key_exists($uepaspriscode,$fiche_code_ksup))
		{		  
		  if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$uepaspriscode].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
		 }
	      echo"   </td><td $bgcolor>" ;
	     echo  $uepaspriscode  ;     
		 echo"   </td><td $bgcolor>" ;
	     echo  $courspasprislibel[$uepaspriscode];
	      echo"   </td><td $bgcolor>" ;
	     echo $courspasprisects[$uepaspriscode];

		 echo"<td $bgcolor><center><INPUT TYPE=radio NAME=ajoutlignebloc$numbloc value=".$uepaspriscode."></center>";

		  echo " </td> ";
		 echo "</tr>";

		 
		 }
	 }
	echo"</table>";
	echo"   </td>" ; 
} //fin de détails
 echo"</table></form> "  ;
   
  echo"</center>";
        }


echo "<center><h2>". $message."</h2> </center>";
	 
} //fin  si c'est bien un etudiant  pas apogee
else
 {
echo"<center> désolé, mais  votre ancien  login : <b>".$login."</b>  ne peut plus être utilisé  , vous devez vous connecter avec vos identifiants définitifs  à la base élèves
 <br> en cas de difficultés veuillez contacter le <a href=mailto:nadia.dehemchi@grenoble-inp.fr >service RI</a>   </center>";
 }


 
} //fin  si c'est bien un etudiant 
else
 {
echo"<center> désolé, mais votre login : <b>".$login."</b> ne correspond pas à celui d'un étudiant en accueil inscrit en $annee_accueil_bascule
 <br>veuillez contacter le <a href=mailto:nadia.dehemchi@grenoble-inp.fr >service RI</a>   </center>";
 }
mysql_close($connexion);

?>
</body>
</html>
