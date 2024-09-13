

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">


<html>

<head>
<title>gestion des etudiants_accueil</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
echo "</HEAD><BODY>" ;
// pour changer l'annee courante de cette page et pas prendre celui de paramcommun car les bascules ne correspondent pas forcément
// c'est normalement  la partie droite de l'annee scolaire courante
$annee_courante='2024';
if ( isset($_GET['an'])){
$filtre = "&an=".urlencode($_GET['an']);

$filtreok=$filtre."&bouton_ok=OK";}
// valeur par defaut 
else{
$filtre="&an=".$annee_courante;
$filtreok='';
}


// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
require('header.php');
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
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['club_indus'])) $_POST['club_indus']='';
if (!isset($_POST['villecp'])) $_POST['villecp']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_POST['code_etud'])) $_POST['code_etud']='';
if (!isset($_GET['recap'])) $_GET['recap']='';
// valeur par défaut
if (!isset($_GET['an'])) $_GET['an']=$annee_courante;
if (!isset($_POST['an'])) $_POST['an']='';
if (!isset($_POST['liginsc_code_groupe'])) $_POST['liginsc_code_groupe']='';
if (!isset($_POST['modcodegroupe'])) $_POST['modcodegroupe']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_GET['annee'])) $_GET['annee']='';
// on récupère l'annee scolaire  pour pointer vers la bonne table d'archive de cours
$table_annee=$_GET['annee'];
$message='';
$message_entete='';
$sql1='';
$sql2='';
if ($_GET['env_orderby']=='') {$orderby= ' order by acc_nom';}
	else{
	$orderby=" order by ".urldecode($_GET['env_orderby']);
	if  ($_GET['env_inverse']!="1"){
                  $orderby=$orderby." desc";}
	}


//si on vient de modifier un code groupe on repasse le login en GET qu'on vient de récupérer en POST
if ($_POST['mod']!='')$_GET['mod']=$_POST['mod'];

$liste_champs_dates=array('acc_date_limite');

$liste_semestre=array('automne','printemps','année','double diplôme','NC');
   $listeouinon=array('non','oui');
   $whereuniv='1';
   $where=' where 1';
   
   $tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces et slashs dans les noms de champs
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
   
   
//on remplit 1tableau avec les libelles-code universites
$sqlquery2="SELECT * FROM universite where ".$whereuniv ." order by nom_uni";

$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$universite_code[]=$v["id_uni"] ;
$universite_libelle[]=$v["nom_uni"] ;
$universite_libelle_a[$v["id_uni"]]=$v["nom_uni"];
}
$universite_code[]='9999';
$universite_libelle[]='NC';
$universite_libelle_a[9999]=$v["NC"];

//on remplit 1tableau avec les libelles-code des groupes ade
$sqlquery2="SELECT * FROM codes_ade_groupes ";

$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$groupe_ade_libelle[$v["code"]]=$v["libelle_ade"];
}





   //tout le monde a acces à la liste
if(in_array($login,$ri_user_liste)){
	$affichetout=1;
}else
	{$affichetout=1;
	}
$URL =$_SERVER['PHP_SELF'];;
$table="etudiants_accueil";
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


//_______________________________________________________________
//modif groupe dans tableau

if ($_POST['modcodegroupe']!=''){
 if(in_array($login,$ri_user_liste)){
 
$query = "UPDATE ligne_insc_acc SET liginsc_code_groupe = '". $_POST['liginsc_code_groupe']."',liginsc_traitee='non' ";
   $query .= " WHERE liginsc_code_ligne='".$_POST['liginsc_code_ligne']."' ";
//echo $query;
$result = mysql_query($query,$connexion);
       if ($result){
    $message = "Fiche <b>";
   $message .= "</B> modifiée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    }
}
 
      else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}
}

// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$ri_user_liste)){
   if($_POST['acc_login']!='' ) {
 $_POST['modifpar']=$login;


foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
  //pb des dates mysql
//si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }


if ($ci2=="acc_date_modif"){
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
    $message = "Fiche <b>";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 

    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez donnez un login ! : Recommencez !");

	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service RI peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$ri_user_liste)){
 

	 //il faut vérifier  qu'une inscription  n'y est pas rattachée 
	 
	 
	   $query = "SELECT * FROM ligne_insc_acc where ligne_insc_acc.liginsc_login = '" .$_GET['del']."'";
	  $result = mysql_query($query,$connexion);
	  //echo $query;
	  $query2 = "SELECT * FROM cours_autres_accueil where autcour_login = '" .$_GET['del']."'";
	  $result2 = mysql_query($query2,$connexion);

	   if (mysql_num_rows($result)==0 and mysql_num_rows($result2)==0) {
	   
   $query = "DELETE FROM $table"
      ." WHERE acc_login='".$_GET['del']."'";
      //echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
   else{
    echo "<center><b>impossible de supprimer cet étudiant car il est inscrit à des cours</b><br>";
   }
   }
   
      else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$ri_user_liste)){
 //pour modifpar
$_POST['acc_modifpar']=$login;


foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
 
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
if ($ci2=="acc_date_modif"){
 $sql1.= $ci2."=now(),";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }

 //attention il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE acc_login='".$_POST['acc_login']."' ";
 // echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['acc_login']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>seul le   service RI peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée <br>";

} //fin du else $login ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;




if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where acc_login='".$_GET['mod']."'";
					 //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   //pour les dates
    if (in_array($ci2,$liste_champs_dates)){
$$ci2=mysql_DateTime($universite->$ci2)  ;
   }
   }

//$date_fin= preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $date_fin);
		//on récupère les champs liés
     
         
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";


  echo"<center>";
  echo"       <table ><tr>  ";

  echo affichechamp('Nom','acc_nom',$acc_nom,40);
  	   echo "</tr><tr>";

        echo affichechamp('Prénom','acc_prenom',$acc_prenom,40);
			echo affichechamp('Code étudiant apogée','acc_code_etu',$acc_code_etu,15,1);
		   if(in_array($login,$ri_user_liste)){
   echo affichechamp('Login Provisoire','acc_login',$acc_login,10,1);  
   		echo "</tr><tr>";
        echo affichechamp('Mail perso','acc_mail',$acc_mail,50);
		echo affichechamp('ECTS demandés','acc_ects',$acc_ects,2);
		echo "</tr><tr>";
		if ($acc_annee=='')$acc_annee='NC';
		echo affichemenu('Année','acc_annee',$annees_liste,$acc_annee);
		if ($acc_semestre=='')$acc_semestre='NC';
		echo affichemenu('Semestre','acc_semestre',$liste_semestre,$acc_semestre);
		 echo affichechamp('Date limite saisie','acc_date_limite',$acc_date_limite,10);
	   echo "</tr><tr>";
	   echo affichemenuplus2tab ('Université','acc_id_uni',$universite_libelle,$universite_code,$acc_id_uni);
	   //echo affichemenusqlplus('université','acc_id_uni','nom_uni','select * from universites','LIBELLE_COURT','',$connexion,'id_uni');


		echo affichemenusqlplusnc('Inscription apogée','acc_code_etu',$myetudiantscode_etu,"SELECT *  from etudiants order by Nom ",'Nom',$acc_code_etu,$connexion,$myetudiantsprénom_1);

    echo "</tr><tr>";
	    echo "<td colspan=2 >Remarques<br><textarea name='acc_remarques' rows=4 cols=50>".$acc_remarques."</textarea></td> ";
		    echo "</tr><tr>";
    echo affichechamp('Modifié par','acc_modifpar',$acc_modifpar,'30',1);
    echo affichechamp('Le','acc_date_modif',$acc_date_modif,'30',1);
	}
	   if(in_array($login,$ri_user_liste)){

  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'><input type='Submit' name='bouton_annul' value='Revenir'></th></tr></table></form> "  ;}
  else {
    echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_annul' value='Revenir'></th></tr></table></form> "  ;
  }
  	if ( $acc_annee==$annee_accueil_bascule)
	{
				$listeGroupesCours="";	
				$listeGroupesCoursParents='';				
			  echo "<b>Liste de ses choix GI</b>";
			  echo "<table class='table1'>";
				echo "<th>Code cours</th><th>Intitule<th>groupe</th><th> edt</th>";

					$query2= "SELECT ligne_insc_acc.*,cours.*   FROM ligne_insc_acc 
				left outer join cours on ligne_insc_acc.liginsc_cours=cours.code
				where liginsc_login='".$acc_login."'";				
			$result2 = mysql_query($query2,$connexion ); 
		while($x=mysql_fetch_object($result2)) 
		{

				echo"   <tr><td>" ;  
			if (array_key_exists($x->liginsc_cours,$fiche_code_ksup))
			{				
						if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$x->liginsc_cours].$url_ksup_suffixe." >"."plus d'infos"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."plus d'infos"."</a>";}
			}
			  echo"   </td><td>" ;
			 echo  $x->LIBELLE_COURT  ;
			 echo "<form name='formligne' method=post action=$URL>";
				   echo"<input type='hidden' name='mod' value='".$_GET['mod']."'>";
			   echo"<input type='hidden' name='liginsc_code_ligne' value=".$x->liginsc_code_ligne.">";
			   echo"<input type='hidden' name='modcodegroupe' value=1>";
		//echo affichemenusqlplusncsubmit('choississez le groupe','liginsc_code_groupe','code','select * from groupes where groupe_principal = \'oui\' and groupe_officiel = \'oui\' ','libelle',$x->liginsc_code_groupe,$connexion);
		$temp='select groupes.*,codes_ade_groupes.code as codeade,if(codes_ade_groupes.libelle_ade is null,\'vide\' ,codes_ade_groupes.libelle_ade) ,concat(libelle,\' (\', if(codes_ade_groupes.libelle_ade is null,\' \' ,codes_ade_groupes.libelle_ade),\' )\') as titrecorrespondance from groupes left outer join codes_ade_groupes on codes_ade_groupes.code=groupes.code_ade6 where right(libelle,8)=\''.$x->liginsc_cours.'\' ';
		//echo $temp;
			echo affichemenusqlplusncsubmit('choisissez le groupe ','liginsc_code_groupe','code',$temp,'titrecorrespondance',$x->liginsc_code_groupe,$connexion);
			if ($x->liginsc_code_groupe !='')
				{
				// il nous faut le code ADE du gpe 
				$query3="select * from groupes where code= '".$x->liginsc_code_groupe."'";
				//echo $query3;
					$result3 = mysql_query($query3,$connexion ); 
					$y=mysql_fetch_object($result3);
									//$listeGroupesCours.=$y->code_ade6.",";
													// attention si on a des espaces dans les codes ressources on doit les remplacer par des + sinon ADE ne comprend pas
						if (strpos($y->code_ade6,' '))
					$listeGroupesCours.=str_replace(' ','+',$y->code_ade6).",";
					else
					$listeGroupesCours.=$y->code_ade6.",";	

				// il faut aussi les codes ADE des groupes  parents
				//$listeGroupesCoursParents="";
				//d'abord niveau +1
				// on a le code dans la fiche du groupe 
				$codeparentniv1=$y->code_pere;
				// si il n 'est pas vide on continue 
					if ($codeparentniv1!='')
						{
							// on récupère la fiche de ce groupe 
							$query4="select * from groupes where code= '".$codeparentniv1."'";
							$result4 = mysql_query($query4,$connexion ); 
							$z=mysql_fetch_object($result4);	
			
						// on ajoute le code ADE à l'url
						if (strpos($z->code_ade6,' '))
								$listeGroupesCoursParents.=str_replace(' ','+',$z->code_ade6).",";
								else
								$listeGroupesCoursParents.=$z->code_ade6.",";	
						// On continue pour le niveau +2
						//on a le code dans la fiche du groupe 
								$codeparentniv2=$z->code_pere;
					// si il n 'est pas vide on continue 
							if ($codeparentniv2!='')
							{	
							// on récupère la fiche de ce groupe 
											$query5="select * from groupes where code= '".$codeparentniv2."'";
											$result5 = mysql_query($query5,$connexion ); 
											$za=mysql_fetch_object($result5);	
							
							// on ajoute le code ADE à l'url
							if (strpos($za->code_ade6,' '))
									$listeGroupesCoursParents.=str_replace(' ','+',$za->code_ade6).",";
									else
									$listeGroupesCoursParents.=$za->code_ade6.",";	
							// On continue pour le niveau +3
				//on a le code dans la fiche du groupe 
							$codeparentniv3=$za->code_pere;
				// si il n 'est pas vide on continue 
									if ($codeparentniv3!='')
									{
								// on récupère la fiche de ce groupe 
												$query6="select * from groupes where code= '".$codeparentniv3."'";
												$result6 = mysql_query($query6,$connexion ); 
												$zb=mysql_fetch_object($result6);	
								
								// on ajoute le code ADE à l'url
								if (strpos($zb->code_ade6,' '))
										$listeGroupesCoursParents.=str_replace(' ','+',$zb->code_ade6).",";
										else
										$listeGroupesCoursParents.=$zb->code_ade6.",";	
								// On continue pour le niveau4

								}			

							}									
				
						}

	 //nombre de semaines depuis le debut du projet  ADE
	$numsemaine=diffdate($date_debut_projetADE);
		// depuis 2018 attention on peut changer d'année ADE en année n-1
	if($numsemaine<=0)$numsemaine=0;
					//$lien_edt="<a href=http://ade52-inpg.grenet.fr/ade/custom/modules/plannings/direct_planning.jsp?projectId=".$id_projetADE."&login=voirENSGI&password=ensgi&displayConfName=web&weeks=".$numsemaine."&days=0,1,2,3,4,5&resources=".$y->code_ade." target=_blank > Emploi du temps </a>";	
					$semestre=substr($y->arbre_gpe,-3);

					if($semestre=='S05' or $semestre=='S07' or $semestre=='S09')
						{
							if ($y->code_ade6!='')
							{
								$lien_edt="<a href=".$lien_ade_pers."&name=".$listeGroupesCoursParents.$y->code_ade6."&weeks=3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24&days=0,1,2,3,4,5 target=_blank >- Emploi du temps de ce cours pour le $semestre</a>";
						
							
							}
	
						}
						else
						{
							if ($y->code_ade6!='')
							{
								$lien_edt="<a href=".$lien_ade_pers."&name=".$listeGroupesCoursParents.$y->code_ade6."&weeks=25 target=_blank >- Emploi du temps de ce cours pour le $semestre</a>";					
							}

						}
					echo "<td>".$lien_edt."</td>";
						}
						echo "</form name='formligne'>";
			 echo "</tr>";

			 $listeGroupesCours.=$listeGroupesCoursParents;
		}

			 // on rajoute un lien pour l'edt résultant des choix au dessus 
			 			 			$lien_edt="<a href=".$lien_ade_etr_pers."&name=".$listeGroupesCours."&weeks=3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24&days=0,1,2,3,4,5"." target=_blank > Emploi du temps résultant de cet élève </a>";

			echo "<tr>";
			echo "<td></td>";
			echo "<td></td>";	
			echo "<td></td>";			
			echo "<td>".$lien_edt."</td>";
			echo"</table>";
	}//fin du if annee anne en cours
		else
		{
		echo "<b>Liste de ses choix GI</b>";
			  echo "<table border=1>";
				echo "<th>Code cours</th><th>Intitule<th>groupe</th>";

					$query2= "SELECT ligne_insc_acc.*,`cours_annee-".$table_annee."`.*   FROM ligne_insc_acc 
				left outer join `cours_annee-".$table_annee."`	on ligne_insc_acc.liginsc_cours=`cours_annee-".$table_annee."`.code
				where liginsc_login='".$acc_login."'";
				
			$result2 = mysql_query($query2,$connexion ); 
			while($x=mysql_fetch_object($result2)) {

				echo"   <tr><td>" ;  
			  echo  $x->liginsc_cours;
			  echo"   </td><td>" ;
			 echo  $x->LIBELLE_COURT  ;


				//echo affichemenusqlplusncsubmit('choississez le groupe ','liginsc_code_groupe','code','select * from groupes where right(libelle,8)= \''.$x->liginsc_cours.'\'  ','titre_affiche',$x->liginsc_code_groupe,$connexion);
echo  afficheonlychampsql('groupe','liginsc_code_groupe_aff','select * from groupes where right(libelle,8)= \''.$x->liginsc_cours.'\'  ','titre_affiche',$connexion,'60');

			 echo "</tr>";
			 }
			echo"</table>";
		}
		// fin du if autres annees
  echo "<b> Inscriptions cours autres ecoles</b>";
 
 echo "<table class='table1'>";
echo "<th>nom ecole</th><th>filiere</th>";
	$query2= "SELECT cours_autres_accueil.*   FROM cours_autres_accueil 

where cours_autres_accueil.autcour_login='".$acc_login."'";
    $result2 = mysql_query($query2,$connexion ); 
	while($z=mysql_fetch_object($result2)) {

echo"   <tr><td>" ;  
        echo  $z->autcour_nom_ecole  ;
      echo"   </td><td>" ;
     echo  $z->autcour_filiere  ;

	 echo "</tr>";
	 }
	echo"</table>";
  
  
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
  echo affichechamp('Login Provisoire','acc_login',$acc_login,10);  
  echo affichechamp('Nom','acc_nom',$acc_nom,40);
  	   echo "</tr><tr>";

        echo affichechamp('Prénom','acc_prenom',$acc_prenom,40);
        echo affichechamp('Mail','acc_mail',$acc_mail,50);
		echo affichechamp('priorité','acc_ects',$acc_ects,2);
		echo "</tr><tr>";
		echo affichemenu('Année','acc_annee',$annees_liste,'NC');
		echo affichemenu('Semestre','acc_semestre',$liste_semestre,'NC');
		echo affichechamp('Date limite de saisie(jj/mm/aa)','acc_date_limite','',10);
	   echo "</tr><tr>";
	   echo affichemenuplus2tab ('université','acc_id_uni',$universite_libelle,$universite_code,'9999');
	   //echo affichemenusqlplus('université','acc_id_uni','nom_uni','select * from universites','LIBELLE_COURT','',$connexion,'id_uni');
		echo affichechamp('Code étudiant apogée','acc_code_etu',$acc_code_etu,15,1);
		
		echo affichemenusqlplusnc('inscription apogée','acc_code_etu',$myetudiantscode_etu,"SELECT *  from etudiants order by Nom ",'Nom',$acc_code_etu,$connexion,$myetudiantsprénom_1);
		echo "</tr><tr>";
	    echo "<td colspan=2 >Remarques<br><textarea name='acc_remarques' rows=4 cols=50>".$acc_remarques."</textarea></td> ";
		echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }

		//============================================================recap ================================================================
if($_GET['recap']!='')  {		
//$query = "select  * from etudiants_accueil left outer join ligne_insc_acc on acc_login=liginsc_login  left outer join cours on  liginsc_cours=code left outer join annuaire on upper(etudiants_accueil.acc_code_etu)=annuaire.`code-etu` order by liginsc_cours ";	

 
 if ( $_GET['an']!='' and $_GET['an']!='tous' ) {
 
     $where .= " and etudiants_accueil.acc_annee = '".($_GET['an'])."-".($_GET['an']+1)."' ";
     $message_entete="de la période ".$_GET['an']."-".($_GET['an']+1);
      }
 
 $query = "select  * from etudiants_accueil 
 left outer join ligne_insc_acc on acc_login=liginsc_login  
 left outer join cours on  liginsc_cours=code 
 left outer join annuaire on upper(etudiants_accueil.acc_code_etu)=annuaire.`code-etu` ".$where ."  order by LIBELLE_COURT 
 ";	
 //echo $query;
 
$result = mysql_query($query,$connexion ); 	

		//on initialise  $csv_output
$csv_output="";		
$csv_output .= "libelle_cours;code_apo;nom;prenom;login;universite;code_etu;semestre;annee;priorite;ects demandés";
$csv_output .= "\n";

echo "<center>";
echo" <table class='table1'>  ";

echo "  <th>nom de l'élève</th><th>prenom</th><th>université</th><th>code étudiant</th><th>semestre</th><th>année</th><th>priorité</th><th>ects demandés</th>";
$sauvcours="";
$sauvcoursinitiale="";
$tot=0;
$couleurfond='lightgreen';			 
while($u=mysql_fetch_object($result))
 {
 if ($u->LIBELLE_LONG==''){
		$libelle= "Pas d'inscription enregistrée ";}
		else
		{$libelle=$u->LIBELLE_LONG;
		}
if ($u->acc_code_etu==''){
		$code_etu= "Pas encore inscrit";}
		else
		{$code_etu= $u->acc_code_etu;
		}
// changement de cours		
if ($libelle!=$sauvcours){
// pour la premiere fois on n'affiche pas le total
if ($sauvcours!='')
{
echo "<tr><td colspan=7  align='center'><b>Total pour $sauvcours - $tot inscrit(s)</b></td> </tr>";
$tot=0;
}
// changement de semestre
if (substr($u->LIBELLE_COURT,0,2)!=$sauvcoursinitiale){
$sauvcoursinitiale=substr($u->LIBELLE_COURT,0,2);
if ($couleurfond=='lightgreen')
{$couleurfond='lightblue';}
elseif ($couleurfond=='lightblue')
{$couleurfond='lightgreen';}
if ($sauvcoursinitiale !='' and $sauvcoursinitiale !='(S')
		{
echo "<tr><td colspan=8 bgcolor=$couleurfond align='center'><h1>Cours $sauvcoursinitiale</h1></td></tr>";
		}	
}
echo "<tr><td colspan=8 bgcolor='".$couleurfond."' align='center'><h1>$libelle -$u->LIBELLE_COURT </h1></td> </tr>";
$sauvcours=$libelle;
}


$tot++;
 echo"   <tr><td>" ;
		//echo $libelle_court;
      //echo"   </td><td>" ;
		echo "<a href=".$URL."?mod=".$u->acc_login.">".$u->acc_nom."</a>";
      echo"   </td><td>" ;	  
	echo $u->acc_prenom;
      echo"   </td><td>" ;
	  echo $universite_libelle_a[$u->acc_id_uni];
	  echo"   </td><td>" ;
	  echo $code_etu;
      echo"   </td><td>" ;
	  echo $u->acc_annee." ".$u->acc_semestre;
      echo"   </td><td>" ;
      echo $u->acc_annee;
       echo"   </td><td>" ;
	   echo $u->liginsc_ordre_preference;
      echo"   </td>" ;
      echo"   </td><td>" ;
	   echo $u->acc_ects;
      echo"   </td>" ;	  
	  $csv_output .=  nettoiecsv($libelle);
	  				$csv_output .= nettoiecsv($u->CODE);
				 $csv_output .= nettoiecsv($u->acc_nom);
				 $csv_output .= nettoiecsv($u->acc_prenom);
				  $csv_output .= nettoiecsv($u->UId);
				 $csv_output .= nettoiecsv($universite_libelle_a[$u->acc_id_uni]);
				 $csv_output .= nettoiecsv($code_etu);
				$csv_output .= nettoiecsv($u->acc_annee." ".$u->acc_semestre);
                $csv_output .= nettoiecsv($u->acc_annee);
				$csv_output .= nettoiecsv($u->liginsc_ordre_preference);
				$csv_output .= nettoiecsv($u->acc_ects);				
				 $csv_output .= "\n";
}
// pour la derniere ligne
echo "<tr><td colspan=7  align='center'><b>Total pour $sauvcours - $tot inscrit(s)</b></td> </tr>";
$affichetout=0;

echo "<h1 class='titrePage2'>Récapitulatif des inscriptions des élèves étrangers aux cours ";
echo $message_entete."</h1>";
echo "<center>";
echo "<a href=".$URL.">Revenir à la liste</a><br><br>";
echo  "<FORM  action=export.php method=POST name='form_export'>";
			 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input class='bouton_ok' type ='submit' name='bouton_export'  value='Export vers EXCEL'>  </center><br> "  ;
			echo "</form name='form_export'>";
	
echo" </table> ";


}	





	
 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage

if ( $_GET['an']!='' and $_GET['an']!='tous' ) {
     $where .= " and acc_annee = '".($_GET['an'])."-".($_GET['an']+1)."'";
     $message_entete="de la période ".$_GET['an']."-".($_GET['an']+1);
      }
	   elseif( $_GET['an']=='tous' and $_GET['pays_rech']!='')
		 {
		 $where.=" and libelle_pays ='".$_GET['pays_rech'] ."' "  ;
		 $message_entete=" toutes périodes et pays " .$_GET['pays_rech'] ;
		  } 
   $query = "SELECT * FROM $table left join universite on acc_id_uni=id_uni
left join pays on universite.id_pays=pays.id_pays";
   $query.=$where."  ";
   $query.=$orderby."  ";

   //echo $query;
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";

if ($nombre>0){
	echo"<center> <h1 class='titrePage2'>Liste des   ";
	echo $nombre;
	echo" étudiants en accueil  ";
	echo " $message_entete";
	echo " </h1></center>";
	      }
else{
	echo"<center> <h2>Il n'y a pas d'etudiants en accueil enregistrés    ";
	echo" pour cette période</h2></center>  <BR>";
    }
echo " <a href=$URL?an=tous> Tous</a>";
echo "<br>";echo "<br>";
echo " <a href=$URL?an=".($annee_courante-2).">" .($annee_courante-2)."-".($annee_courante-1)."</a>";
echo "-";
echo " <a href=$URL?an=".($annee_courante-1).">" .($annee_courante-1)."-".($annee_courante)."</a>";

echo " <a href=$URL?an=".($annee_courante).">" .($annee_courante)."-".($annee_courante+1)."</a>";
echo "<br>";echo "<br>";

 if(in_array($login,$ri_user_liste)){
echo "<A href=".$URL."?add=1 > Ajouter un etudiant en accueil </a><br>";
echo "<br>";
echo "<A href=peuplement_gpes.php > Inscrire les étudiants dans les groupes cours </a><br>";
echo "<br>";
echo "<A href=config_ue_accueil.php > Configurer les cours au choix </a><br>";
}
echo "<br><A href=".$URL."?recap=1".$filtre." > Récapitulatif des inscriptions </a><br>";
 echo "<br><A class='abs2' href=default.php > Revenir à l'accueil </a><br>";
if ($nombre>0){
echo"<table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";

        echo "<BR><BR><table class='table1'><tr bgcolor=\"#98B5FF\" > ";

echo afficheentete('nom','acc_nom',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('prénom','acc_prenom',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('université','acc_id_uni',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('pays','libelle_pays',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('semestre','acc_semestre',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('année','acc_annee',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
echo afficheentete('Code Etu','acc_code_etu',$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);




while($universite=mysql_fetch_object($result)) {

 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   //pour les dates
    if (in_array($ci2,$liste_champs_dates)){
$$ci2=mysql_DateTime($universite->$ci2)  ;
   }
   }

 if ($acc_code_etu==''){
		$code_etu= "Pas encore inscrit";}
		else
		{$code_etu= $acc_code_etu;
		}
		//on récupère les champs liés
     
	 
	 //$modifpar=odbc_result($result,"modifpar") ;
      echo"   <tr><td>" ;
		//echo $acc_login;
      //echo"   </td><td>" ;
		echo $acc_nom;
      echo"   </td><td>" ;
		echo $acc_prenom;
      echo"   </td><td>" ;
	  //echo $acc_mail;
      //echo"   </td><td>" ;
	  echo $universite_libelle_a[$acc_id_uni];
      echo"   </td><td>" ;
	  	  echo $universite->libelle_pays;
      echo"   </td><td>" ;
	  echo $acc_annee." ".$acc_semestre;
      echo"   </td><td>" ;
    echo $acc_annee;
    echo"   </td><td>" ;
	   echo $code_etu;
      echo"   </td><td>" ;
	   if(in_array($login,$ri_user_liste)){
     echo " <A class='abs2' href=".$URL."?del=".urlencode($acc_login)." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet etudiant ?')\">";
     echo "Supp</A>";
	 if ( $acc_annee >= $annee_accueil_bascule)
	 {
		echo "<A class='abs' href=insc_accueil.php?loginacc=".urlencode($acc_login).">Inscrip</A>";
		echo "<A class='abs' href=". $URL."?mod=".urlencode($acc_login).">détails</A>";
	 }else
	 {
	 	 echo "<A class='abs' href=insc_accueilro.php?loginacc=".urlencode($acc_login)."&annee=".$acc_annee.">Inscrip (ro)</A>";
		 echo "<A class='abs' href=". $URL."?mod=".urlencode($acc_login)."&annee=".$acc_annee.">Détails</A>";

	 }
	 
	 }

     echo"        </td> </tr>";
       }
	   

echo "</form>";
	   
echo"</table> ";
  }
  }
 mysql_close($connexion);
 require('footer.php');
?>
</body>
</html>
