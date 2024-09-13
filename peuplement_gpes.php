<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>calcul des codes etu et des codes ccp depuis l'annuaire</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?

function rewrite($label)
{
	/* Expression régulière permettant le changement des caractères accentués en
	* caractères non accentués.
	*/
	$search = array ('@[éèêëÊË]@i','@[àâäÂÄ]@i','@[îïÎÏ]@i','@[ûùüÛÜ]@i','@[ôöÔÖ]@i','@[ç]@i','@[^a-zA-Z0-9]@');
	$replace = array ('e','a','i','u','o','c',' ');
	$label =  preg_replace($search, $replace, $label);
	//if ($enminuscule!='')
	//{
	//$label = strtolower($label); // toutes les lettres de la chaîne en minuscule
	//}
	$label = str_replace(" ",'',$label); // remplace les espaces par rien 
	$label = preg_replace('#\-+#','',$label); // enlève les autres caractères inutiles
	$label = preg_replace('#([-]+)#','-',$label);
	trim($label,'-'); // remplace les espaces restants par des tirets
	return $label;
}

set_time_limit(120);
require ("style.php");
require ("param.php");
require ("function.php");
require ("header.php") ;
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

// pour les urls Ksup
$sqlquery2="SELECT META_CODE, META_LIBELLE_FICHE,ID_METATAG FROM METATAG WHERE META_CODE_RUBRIQUE LIKE 'GENIE_FOR%' AND META_LIBELLE_OBJET LIKE 'cours'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$fiche_code_ksup[$v["META_CODE"]]=$v["ID_METATAG"];
}
$fiche_code_ksup['']='';

if (!isset($_GET['inverse'])) $_GET['inverse']='';
if (!isset($_GET['orderby'])) $_GET['orderby']='';
if (!isset($_POST['bouton_synchro'])) $_POST['bouton_synchro']='';
if (!isset($_POST['bouton_synchro2'])) $_POST['bouton_synchro2']='';
if (!isset($_POST['bouton_synchro1'])) $_POST['bouton_synchro1']='';
if (!isset($_POST['bouton_synchro_test'])) $_POST['bouton_synchro_test']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['synchro'])) $_GET['synchro']='';
if (!isset($_GET['synchro2'])) $_GET['synchro2']='';
if (!isset($_GET['synchro1'])) $_GET['synchro1']='';
if (!isset($_GET['import_annu'])) $_GET['import_annu']='';
$self=$_SERVER['PHP_SELF'];
$sql1='';
$sql2='';
$messagem ='';

$URL =$_SERVER['PHP_SELF'];
$table="annuaire";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="annuaire";
$champs=champsfromtable($tabletemp);

foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
    $gauche='';
    $droite='' ;
	$partie3='';
 $test=0; 

// ----------------------------------Ajout de la fiche
   //inutile
// ---------------------------------Suppression de la fiche
   //inutile
//--------------------------------- peuplement des groupes cours depuis pré inscription  etrangers
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='1'  ){
echo"peuplement des groupes cours depuis insc etrangers...<br>";
//on parcourt la table  gpe pour recuperer les codes apogees
$query="SELECT * FROM groupes where type_gpe_auto='edt'  ;";
$resultat=mysql_query($query,$connexion ); 
while ($e=mysql_fetch_object($resultat))
	{	
		$tableau_libelle[$e->code]=$e->libelle;	
		$tableau_codepere[$e->code]=$e->code_pere;
	}
$sup=0;	
$cree=0;
$dejafait=0;

$query2="SELECT * FROM ligne_insc_acc left outer join etudiants_accueil on  ligne_insc_acc.liginsc_login= etudiants_accueil.acc_login order by ligne_insc_acc.liginsc_login";
$result2=mysql_query($query2,$connexion ); 
while ($f=mysql_fetch_object($result2)){
// si c'est un etudiants bien inscrit ds apogee et si c'est la  bonne annee et si il y un code de groupe et si on n'a pas déjà traité la préinscription
if ( $f->acc_code_etu!='' and $f->acc_annee==$annee_accueil and $f->liginsc_code_groupe!='' and $f->liginsc_traitee!='oui'){


	// il faut vérifier si cet étudiant n'existe pas déjà ds des gpes de la même UE

	$query5="select *  from  ligne_groupe left outer join groupes on groupes.code=ligne_groupe.code_groupe 
	where groupes.libelle like '%#".$f->liginsc_cours."%'   and code_etudiant='".$f->acc_code_etu."'";
	//echo "<br>$query5<br>";
	$result5=mysql_query($query5,$connexion ); 
	while ($res=mysql_fetch_object($result5))
			{
				// si oui on supprime ses inscriptions  
				$query3="delete from ligne_groupe where code_ligne='".$res->code_ligne."'";
				//echo $query3;
					echo "<br>";
				if (!$test)
				{
				$result3=mysql_query($query3,$connexion ); 
				if ($result3){
					echo "<br> on supprime l'inscription de l'etudiant". $f->acc_nom." ".$f->acc_prenom . " ds le gpe cours de la même UE".$tableau_libelle[$res->code_groupe]."<br>";				   
				   	$sup++;
				   }
				   else {
				    echo affichealerte("erreur ")." : ". mysql_error();
				  echo "<center>La fiche n'est pas effacée</b> </center>";
				    } 
				//echo "<br>";
				}
			}
			



	//echo  $f->acc_nom." ".$f->acc_prenom ." à inscrire dans le groupe ".$f->liginsc_cours ."qui a pour code : ".$f->liginsc_code_groupe ;
	//echo "<br>";

		// il faut regarder si c'est un gpe TP qui va donner lieu a une inscription TD et CM
		// on verifie s'il y a un groupe pere l
		if ($tableau_codepere[$f->liginsc_code_groupe]!='')
		{	
		$ilyaunpere=$tableau_codepere[$f->liginsc_code_groupe];
					// on verifie s'il y a un groupe gdpere l
			if ($tableau_codepere[$ilyaunpere]!='')
			// si il y en a un on inscrit aussi l'étudiant à ce groupe
			{	
			$ilyaungrandpere=$tableau_codepere[$ilyaunpere];
				// on verifie s'il y a un groupe arrieregdpere 
				if ($tableau_codepere[$ilyaungrandpere]!='')
				// si il y en a un on inscrit aussi l'étudiant à ce groupe
				{	
				$ilyaunarrieregrandpere=$tableau_codepere[$ilyaungrandpere];					
				}		
				else
				{
				$ilyaunarrieregrandpere='';				
				}
			}
			else
			{
			$ilyaungrandpere='';
			$ilyaunarrieregrandpere='';				
			}			
		}
		else
		{
		$ilyaunpere='';
		$ilyaungrandpere='';
		$ilyaunarrieregrandpere='';		
		}

		
		
		
		if ($ilyaunpere!='')
		{
		// si il y en a un on inscrit aussi l'étudiant à ce groupe		

		//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
			$query4="select *  from  ligne_groupe where code_groupe='".$ilyaunpere ."' and code_etudiant='".$f->acc_code_etu."'";

			$result4=mysql_query($query4,$connexion ); 
			if (mysql_num_rows($result4)==0)
			{
				$query3="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif) 
				VALUES ('".$ilyaunpere ."','".$f->acc_code_etu."','etr','".$login."',now())";
				//echo $query3;
				//	echo "<br>";
				if (!$test)
				{
				$result3=mysql_query($query3,$connexion ); 
				if ($result3){

				   echo "<br> on inscrit l'etudiant ". $f->acc_nom." ".$f->acc_prenom . " ds le gpe cours pere".$tableau_libelle[$ilyaunpere]."<br>";
				   	$cree++;
				   }
				   else {
				    echo affichealerte("erreur de saisie ")." : ". mysql_error();
				  echo "<center>La fiche n'est pas enregistrée</b> </center>";
				    } 
				echo "<br>";
				}
			}
			else
			{
			$dejafait++;
			//echo "On ne fait rien etudiant numero". $f->acc_code_etu . " déjà inscrit dans le groupe ".$tableau_libelle[$ilyaunpere]."<br>";

				//	echo "<br>";
			}				
		}
		if ($ilyaungrandpere!='')
					{
					// si il y en a un on inscrit aussi l'étudiant à ce groupe		

					//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
						$query4="select *  from  ligne_groupe where code_groupe='".$ilyaungrandpere ."' and code_etudiant='".$f->acc_code_etu."'";
						$result4=mysql_query($query4,$connexion ); 
						if (mysql_num_rows($result4)==0)
						{
							$query3="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif) 
							VALUES ('".$ilyaungrandpere ."','".$f->acc_code_etu."','etr','".$login."',now())";
							//echo $query3;
							//	echo "<br>";
							if (!$test)
							{
							$result3=mysql_query($query3,$connexion ); 
							if ($result3){

								echo "<br> on inscrit l'etudiant ". $f->acc_nom." ".$f->acc_prenom . " ds le gpe cours grand pere ".$tableau_libelle[$ilyaungrandpere]."<br>";							   
							   	$cree++;
							   }
							   else {
							    echo affichealerte("erreur de saisie ")." : ". mysql_error();
							  echo "<center>La fiche n'est pas enregistrée</b> </center>";
							    } 
							echo "<br>";
							}
						}
						else
						{
						$dejafait++;
						//echo "etudiant numero". $f->acc_code_etu . " déjà inscrit dans le groupe ".$tableau_libelle[$ilyaungrandpere]."<br>";
						//	echo "<br>";
						}				
					}
			if ($ilyaunarrieregrandpere!='')
					{
					// si il y en a un on inscrit aussi l'étudiant à ce groupe		

					//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
						$query4="select *  from  ligne_groupe where code_groupe='".$ilyaunarrieregrandpere ."' and code_etudiant='".$f->acc_code_etu."'";
						$result4=mysql_query($query4,$connexion ); 
						if (mysql_num_rows($result4)==0)
						{
							$query3="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif)  
							VALUES ('".$ilyaunarrieregrandpere ."','".$f->acc_code_etu."','etr','".$login."',now())";
							//echo $query3;
							//	echo "<br>";
							if (!$test)
							{
							$result3=mysql_query($query3,$connexion ); 
							if ($result3){

								echo "<br> on inscrit l'etudiant ". $f->acc_nom." ".$f->acc_prenom . " ds le gpe cours arriere grand pere ".$tableau_libelle[$ilyaunarrieregrandpere]."<br>";							   
							   	$cree++;
							   }
							   else {
							    echo affichealerte("erreur de saisie ")." : ". mysql_error();
							  echo "<center>La fiche n'est pas enregistrée</b> </center>";
							    } 
							echo "<br>";
							}
						}
						else
						{
						$dejafait++;
						//echo "etudiant numero". $f->acc_code_etu . " déjà inscrit dans le groupe ".$tableau_libelle[$ilyaungrandpere]."<br>";
						//	echo "<br>";
						}				
					}

	//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
	$query4="select *  from  ligne_groupe where code_groupe='".$f->liginsc_code_groupe ."' and code_etudiant='".$f->acc_code_etu."'";
	$result4=mysql_query($query4,$connexion ); 
	if (mysql_num_rows($result4)==0)
			{
				$query3="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif)
				VALUES ('".$f->liginsc_code_groupe ."','".$f->acc_code_etu."','etr','".$login."',now())";
				//echo $query3;
				//	echo "<br>";
				if (!$test)
				{
				$result3=mysql_query($query3,$connexion ); 
				if ($result3){
					echo "<br> on inscrit l'etudiant ". $f->acc_nom." ".$f->acc_prenom . " ds le gpe cours de base".$tableau_libelle[$f->liginsc_code_groupe]."<br>";				   
				   	$cree++;
											// il faut modifier l'info : fiche traitée à 'oui'  dans les preinscriptions 
						$query6="update ligne_insc_acc  set liginsc_traitee ='oui' where liginsc_code_ligne='".$f->liginsc_code_ligne."'";

						$result6=mysql_query($query6,$connexion ); 
						if ($result6){
							echo "<br> on indique que la pre inscription a été traitée pour ". $f->acc_nom." ".$f->acc_prenom . " ds le gpe cours de base ".$tableau_libelle[$f->liginsc_code_groupe]."<br>";				   							
						   }
						   else {
							echo affichealerte("erreur de saisie ")." : ". mysql_error();
						  echo "<center>La fiche n'est pas enregistrée</b> </center>";
							} 
						echo "<br>";
										
				   }
				   else {
				    echo affichealerte("erreur de saisie ")." : ". mysql_error();
				  echo "<center>La fiche n'est pas enregistrée</b> </center>";
				    } 
				echo "<br>";
				}

			}
			else
			{
			$dejafait++;
			//echo "on ne fait rien :etudiant numero". $f->acc_code_etu . " déjà inscrit dans le groupe ".$tableau_libelle[$f->liginsc_code_groupe]."<br>";

			//		echo "<br>";
			}
	
	
	}

}
  
  
 //pour chaque code etudiant on cree le code etu et le code ccp
           // $query2 = "UPDATE  $table set `code-etu`='$code_etu',`code-ccp`='$code_ccp'  WHERE `Id. Établ.`='$id'";
           //echo $query2."| $gauche |$droite |$partie3| $partie4<br>";
		//$result2=mysql_query($query2,$connexion ); 
           //  $cree++;
  echo "<br>resultat ".$sup ." inscriptions dans la même UE ont été supprimées <br>";
 echo "<br>resultat ".$cree ." inscriptions ont été effectuées<br>";
  echo "<br>resultat ".$dejafait ." inscriptions étaient déjà effectives et n'ont pas été effectuées<br>";
 }
 //--------------------------------- ajout des code pere ds les gpes edt nécessaires pour les inscription en cascade des étrangers dans les gpes cours ( à n'utiliser qu'une seule fois 
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='12' and $login=='administrateur' ){
echo"ajout des code pere ds les gpes edt en cours ...<br>";
//on parcourt la table  gpe pour recuperer les codes apogees
$cree=0;

   $query="SELECT * FROM groupes where type_gpe_auto='edt'  ;";
$resultat=mysql_query($query,$connexion ); 
while ($e=mysql_fetch_object($resultat)){
	//if (substr($e->libelle,0,3)=='5GU' or substr($e->libelle,0,2)=='4G' or substr($e->libelle,0,1)=='W')
	//{
	//echo substr($e->libelle,0,8);
	//echo $e->code;
	//echo "<br>";
	if (strpos($e->libelle,'#'))
		{
	$souslibel=explode('#',$e->libelle);
	$libellecodeapo=$souslibel[1];
				if (strpos($souslibel[0],'_'))
				{
				$libellecourt=substr($souslibel[0],0,strpos($souslibel[0],'_'));
				$libellegpeapo=stristr($souslibel[0],'_');
				$libellegpeapo=substr($libellegpeapo,1,strlen($libellegpeapo)-1);
					if (strpos($libellegpeapo,'_'))
					{
					$libellegpeapo_filiere=substr($libellegpeapo,0,strpos($libellegpeapo,'_'));	
					$libellegpeapo_sans_filiere=stristr($libellegpeapo,'_');			
					$libellegpeapo_sans_filiere=substr($libellegpeapo_sans_filiere,1,strlen($libellegpeapo_sans_filiere)-1);
					}
					else
					{
					$libellegpeapo_sans_filiere=$libellegpeapo;
					$libellegpeapo_filiere='';
					}
				
				}
				else
				{
				$libellecourt=$souslibel[0];
				$libellegpeapo='non';
				}
		}
		else
		{
		
		}
	$tableau_libelle[$e->code]=$e->libelle;	
	$tableau_codegpe[$libellecodeapo]=$e->code;
	$tableau_codeapogpe[$libellecodeapo.$libellegpeapo]=$e->code;	
	$tableau_codeapo[$e->code]=$libellecodeapo;
	$tableau_libellegpeapo[$e->code]=$libellegpeapo;
	$tableau_libellegpeapo_filiere[$e->code]=$libellegpeapo_filiere;
	$tableau_libellegpeapo_sans_filiere[$e->code]=$libellegpeapo_sans_filiere;
	
	//echo "libelle depart: ".$e->libelle ."  libelle code apo->". $libellecodeapo ."  libellegpe_complet->".$libellegpeapo ."  libelle filiere->".$libellegpeapo_filiere."  libellegpesansfiliere->".$libellegpeapo_sans_filiere."<br>";
	//}
}
   $query="SELECT * FROM groupes where type_gpe_auto='edt' ;";
$resultat=mysql_query($query,$connexion ); 
while ($e=mysql_fetch_object($resultat)){

	echo "<br>";
$codesousgroupe=$tableau_libellegpeapo[$e->code];
$codesousgroupe_sans_filiere=$tableau_libellegpeapo_sans_filiere[$e->code];
		// il faut regarder si c'est un gpe TP qui va donner lieu a une inscription TD et CM
		// on verifie le codegpeapogee
		if ($codesousgroupe!='CM' and  $codesousgroupe!='non')
		// si c'est un gpe TP/TD
		{	
		echo $codesousgroupe." c'est un gpe tp ou td"."<br>";
		// il faut trouver les autres gpes
					$filiere=$tableau_libellegpeapo_filiere[$e->code];
					if ($filiere !='')
					{
					$filiere.="_";
					//$filierecm="_";
					}
					switch ($codesousgroupe_sans_filiere)
					{
					case "GA1":	
					case "GA2":
					$parent1=$tableau_codeapo[$e->code].$filiere."GA";
					//$parent2=$tableau_codeapo[$e->code]."CM";
					break;	
					case "GB1":	
					case "GB2":
					$parent1=$tableau_codeapo[$e->code].$filiere."GB";
					//$parent2=$tableau_codeapo[$e->code]."CM";
					break;
					case "GC1":	
					case "GC2":
					$parent1=$tableau_codeapo[$e->code].$filiere."GC";
					//$parent2=$tableau_codeapo[$e->code]."CM";
					break;
					case "GD1":	
					case "GD2":
					$parent1=$tableau_codeapo[$e->code].$filiere."GD";
					//$parent2=$tableau_codeapo[$e->code]."CM";
					break;	
					case "GE1":	
					case "GE2":
					$parent1=$tableau_codeapo[$e->code].$filiere."GE";
					//$parent2=$tableau_codeapo[$e->code]."CM";
					break;
					case "GA":	
					case "GB":	
					case "GC":					
					case "GD":	
					case "GE":
					$parent1=$tableau_codeapo[$e->code]."CM";
					//$parent2="";
					break;					
					default :
					$parent1="";
					//$parent2="";
					}
			//et les indiquer ds le champ parent de la fiche du groupe	
					echo $parent1  ." <-parent1  libelle ->".$e->libelle."<br>"  ;
					//echo $parent2  ." <-parent2  libelle ->".$e->libelle."<br>"  ;
					if ($parent1!='' and $tableau_codeapogpe[$parent1]!= ''){
					echo $parent1  ." <-parent1 code->".$tableau_codeapogpe[$parent1]."<br>"  ;
					$sqlquery="update groupes set code_pere='".$tableau_codeapogpe[$parent1]."' where code='".$e->code."' and (code_pere='' or code_pere is NULL)";
					echo $sqlquery."<br>";
				if (!$test)
				{
				$result=mysql_query($sqlquery,$connexion ); 
				if ($result){
				    $message = "Fiche <b>";
				   $message .= "</B> ajoutée !<br>";
				   	$cree++;
				   }
				   else {
				    echo affichealerte("erreur de saisie ")." : ". mysql_error();
				  echo "<center>La fiche n'est pas enregistrée</b> </center>";
				    } 
				echo "<br>";
				}
					}
					//if ($parent2!=''and $tableau_codeapogpe[$parent2]!= ''){
					//echo $parent2  ." <-parent2 code->".$tableau_codeapogpe[$parent2]."<br>"  ;
					//}
		}
		else
		{
		echo $codesousgroupe ." CE N'EST PAS un gpe tp ou td on ne fait rien"."<br>";
	}
	
}

 echo "<br>resultat ".$cree ." fiches on été modifiées<br>";

 }

 
//--------------------------------- peuplement des groupes  TP depuis insc etrangers
// inutile 2011


 //--------------------------------- peuplement des groupes  peres   depuis groupes fils
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='3'){
echo"synchro des groupes  peres   depuis groupes fils en cours ...<br>";
$cree=0;
$creetot=0;
$sup=0;
$test=0; 
$messagem .= "\n"."Le service SCOLARITE (".$login.") vient de lancer la procédure de peuplement des groupes peres \n " ;
$messagem .= "\n\n\n\n\n"."On s'occupe des groupes SCOL   \n " ;
echo"On s'occupe des groupes SCOL    <br>";
// on recupere la liste des codes des groupes peres ds les gpes fils
    $query=" SELECT distinct code_pere FROM groupes where code_pere != '' and type_gpe_auto='scol' order by libelle desc ";
	$result=mysql_query($query,$connexion ); 
//on supprime les membres des groupes peres (TD )
while ($e=mysql_fetch_object($result))
		{
		$query4="delete from ligne_groupe where code_groupe= '".$e->code_pere."'";
	
				if (!$test)
				{
				$result4=mysql_query($query4,$connexion );			
				$sup = $sup + mysql_affected_rows() ;
				}
				 if ($login == 'administrateur' or $login =='marc.patouillard' )
				 {
				echo $query4."-".mysql_affected_rows()."<br>";
				}
		}
echo "<br> $sup fiches supprimée dans les groupes SCOL pères";
  // on recupere les groupes fils  dans l ordre du niveau   parent
$query2=" SELECT * FROM groupes where code_pere != '' and type_gpe_auto='scol'  order by niveau_parente ";
$result2=mysql_query($query2,$connexion ); 
  // pour chaque groupe fils 
		while ($f=mysql_fetch_object($result2))
			{
			echo affichealerte(" groupe fils :".$f->code ."-".$f->libelle . " de niveau ".$f->niveau_parente);
			$messagem .=" groupe fils :".$f->code ."-".$f->libelle . " de niveau ".$f->niveau_parente."\n";
			//on recupere ses membres
			$query3=" SELECT distinct code_etudiant,semestre,type_inscription FROM ligne_groupe where code_groupe='".$f->code."' ";
			$result3=mysql_query($query3,$connexion ); 
					while ($g=mysql_fetch_object($result3)){
					// puis on les ajoute au groupe pere s'ils n'existaient pas déjà 

					$query5=" SELECT  code_etudiant,type_inscription  FROM ligne_groupe where code_groupe='".$f->code_pere."' and code_etudiant ='".$g->code_etudiant."'";
					$result5=mysql_query($query5,$connexion ); 
							if (mysql_num_rows($result5) == 0)
							{
							$query4="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,exempte,semestre,modifpar,date_modif) 
							VALUES ('".$f->code_pere."','".$g->code_etudiant."','fils','','".$g->semestre."','".$login."',now())";
							 if ($login == 'administrateur' or $login =='marc.patouillard' )
							{
							echo $query4."<br>";
							}
								if (!$test)
								{
								$result4=mysql_query($query4,$connexion ); 
									if ($result4){
									$message = "Fiche <b>";
									$message .= "</B> ajoutée !<br>";
									$cree++;}
									else {
									echo affichealerte("erreur de saisie ")." : ". mysql_error();
									echo "<center>La fiche n'est pas enregistrée</b> </center>";
									}
								}
							}							
						   else{
							   	while ($h=mysql_fetch_object($result5)){
						   				 if ($login == 'administrateur' or $login =='marc.patouillard' )
											{
										   echo affichealerte($g->code_etudiant." existe déjà dans le groupe père  inscription [".$h->type_inscription."]");
										   }
								}
						   }
						
					   }
						echo "<br>";
				echo "<br>resultat ".$cree ." fiches on été ajoutées dans le groupes pere de type scol ".$f->code_pere." <br>";
							$messagem .=" resultat ".$cree ." fiches on été ajoutées dans le groupes pere de type scol ".$f->code_pere."\n";
				$creetot+=$cree;
				$cree=0;
			}
$messagem .= "\n\n"."On a créé $creetot fiches\n " ;
echo"On a créé $creetot fiches  <br>";
// il faut aussi s'occuper des groupes cours  qui ont des indications de parenté 
$cree=0;
$creetot=0;
$sup=0;
$messagem .= "\n\n"."On s'occupe des groupes COURS qui ont des indications de parenté  \n " ;
echo"On s'occupe des groupes COURS qui ont des indications de parenté    <br>";
// on recupere la liste des codes des groupes peres ds les gpes fils
    //$query=" SELECT distinct code_pere FROM groupes where code_pere != '' and type_gpe_auto='edt' and ( gpe_etud_constitutif is null or gpe_etud_constitutif ='' or gpe_etud_constitutif ='VIDE' ) order by libelle desc ";
	$query=" SELECT distinct code_pere FROM groupes where code_pere != '' and type_gpe_auto='edt' order by libelle desc ";
	$result=mysql_query($query,$connexion ); 
//on supprime les membres des groupes peres (TD et plus ) inscrits précédemment :code [FILS2]
while ($e=mysql_fetch_object($result))
		{
		$query4="delete from ligne_groupe  WHERE  code_groupe= '".$e->code_pere."' and type_inscription = 'fils2'";
	
				if (!$test)
				{
				$result4=mysql_query($query4,$connexion );			
				$sup = $sup + mysql_affected_rows() ;
				}
				 if ($login == 'administrateur' or $login =='marc.patouillard' )
				 {
				echo $query4."-".mysql_affected_rows()."<br>";
				}
		}
echo "<br> $sup fiches supprimée dans les groupes cours pères";
  // on recupere les groupes fils  dans l ordre du niveau   parent
//$query2=" SELECT * FROM groupes where code_pere != '' and type_gpe_auto='edt' and ( gpe_etud_constitutif is null or gpe_etud_constitutif ='' or gpe_etud_constitutif ='VIDE')  order by niveau_parente ";
$query2=" SELECT * FROM groupes where code_pere != '' and type_gpe_auto='edt' order by niveau_parente ";
$result2=mysql_query($query2,$connexion ); 
  // pour chaque groupe fils 
		while ($f=mysql_fetch_object($result2))
			{
			echo affichealerte(" groupe fils :".$f->code ."-".$f->libelle . " de niveau ".$f->niveau_parente);
			$messagem .=" groupe fils :".$f->code ."-".$f->libelle . " de niveau ".$f->niveau_parente."\n";
			//on recupere ses inscrits de type auto ' à la main ' : code []
			//$query3=" SELECT distinct code_etudiant,exempte FROM ligne_groupe WHERE  code_groupe='".$f->code."' ";
			$query3=" SELECT distinct code_etudiant,exempte,type_inscription FROM ligne_groupe WHERE  code_groupe='".$f->code."' and (type_inscription ='' or type_inscription is null or type_inscription ='fils2')";
			$result3=mysql_query($query3,$connexion ); 
					while ($g=mysql_fetch_object($result3)){
					// puis on les ajoute au groupe pere s'ils n'existaient pas déjà 

					$query5=" SELECT  code_etudiant,type_inscription FROM ligne_groupe where code_groupe='".$f->code_pere."' and code_etudiant ='".$g->code_etudiant."'";
					$result5=mysql_query($query5,$connexion ); 
							if (mysql_num_rows($result5) == 0)
							{

							$query4="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,exempte,semestre,modifpar,date_modif)  
							VALUES ('".$f->code_pere."','".$g->code_etudiant."','fils2','".$g->exempte."','','".$login."',now())";
							 if ($login == 'administrateur' or $login =='marc.patouillard' )
							{
								echo $query4 ."<br>";
							}
								if (!$test)
								{
											$result4=mysql_query($query4,$connexion ); 

												if ($result4){
												$message = "Fiche <b>";
												$message .= "</B> ajoutée !<br>";
												$cree++;}
												else {
												echo affichealerte("erreur de saisie ")." : ". mysql_error();
												echo "<center>La fiche n'est pas enregistrée</b> </center>";
												}
								}
							}								
						   else{
							   		while ($h=mysql_fetch_object($result5)){
						   				 if ($login == 'administrateur' or $login =='marc.patouillard' )
											{
										   echo affichealerte($g->code_etudiant." existe déjà dans le groupe père , inscription type [".$h->type_inscription."]");
										   }
									}
						   }
						
					   }
						echo "<br>";
				echo "<br>resultat ".$cree ." inscriptions  on été ajoutées dans le groupes pere de type cours ".$f->code_pere." <br>";
							$messagem .="  RESULTAT  ".$cree ." inscriptions  on été ajoutées dans le groupes pere de type cours ".$f->code_pere."\n";
				$creetot+=$cree;
				$cree=0;
			}
$messagem .= "\n\n"."On a créé $creetot fiches\n " ;
echo"On a créé $creetot fiches  <br>";
		
			// il faut aussi s'occuper des groupes offciels de promo qui doivent être recopiés  partir des gpes scol de promo
	// on recupere la liste des codes des groupes qui doivent être recopiés  partir des gpes scol de promo
	$cree=0;
	$creetot=0;
	$messagem .= "\n\n"."On s'occupe des groupes des groupes officiels de promo qui doivent être recopiés  partir des gpes scol de promo \n " ;
echo"On s'occupe des groupes officiels de promo qui doivent être recopiés  partir des gpes scol de promo   <br>";
    $query=" SELECT *  FROM groupes where recopie_gpe_officiel != '' and recopie_gpe_officiel is not NULL ";
	$result=mysql_query($query,$connexion ); 

while ($e=mysql_fetch_object($result))
		{	
						 if ($login == 'administrateur' or $login =='marc.patouillard' )
							{
							echo affichealerte(" groupe officiel  à traiter :".$e->code ."-".$e->libelle . "doit être peuplé avec : ".$e->recopie_gpe_officiel);
							$messagem .= "\n groupe officiel  à traiter :".$e->code ."-".$e->libelle . "doit être peuplé avec : ".$e->recopie_gpe_officiel;
							}
			// pour chaque groupe on efface ses membres	
			// correction 03-2014 on efface tous ses membres sans distinction : sinon il peut y avoir des doublons
			// correction 2018 on rétablit la conditon  sur le type d'inscription 
		$query4="delete from ligne_groupe where code_groupe= '".$e->code."' and type_inscription='offi'";
			//	$query4="delete from ligne_groupe where code_groupe= '".$e->code."' ";

				if (!$test)
				{
				$result4=mysql_query($query4,$connexion );			
				//$sup = $sup + mysql_affected_rows() ;
				}
								 if ($login == 'administrateur' or $login =='marc.patouillard' )
									 {
									echo $query4."-".mysql_affected_rows()." fiches effacees<br>";	
									}
// ensuite on le remplit à partir du gpe scol corrrespondant 	
			//on recupere ses membres
			$query3=" SELECT distinct code_etudiant,semestre FROM ligne_groupe where code_groupe='".$e->recopie_gpe_officiel."' ";
			$result3=mysql_query($query3,$connexion ); 
					while ($g=mysql_fetch_object($result3)){
					// puis on les ajoute au groupe offi  si il s n'y sont pas déjà 
						if (!$test)
						{
						$sqlquery10="SELECT  * FROM ligne_groupe    where code_etudiant='".$g->code_etudiant."' and code_groupe='".$e->code."' ";
						//echo "<br>".$sqlquery5."<br>";
						$resultat10 = mysql_query($sqlquery10,$connexion );
							if (mysql_num_rows ($resultat10) == 0)
							{
							$query4="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,exempte,semestre,modifpar,date_modif) 
							VALUES ('".$e->code."','".$g->code_etudiant."','offi','','".$g->semestre."','".$login."',now())";
							//echo $query4;

							$result4=mysql_query($query4,$connexion ); 
								if ($result4){
								$message = "Fiche <b>";
								$message .= "</B> ajoutée !<br>";
								$cree++;}
								else {
								echo affichealerte("erreur de saisie ")." : ". mysql_error();
								echo "<center>La fiche n'est pas enregistrée</b> </center>";
								}	
							}								
						}
									
					   }
							 if ($login == 'administrateur' or $login =='marc.patouillard' )
								 {		   
								echo "<br>resultat ".$cree ." fiches on été ajoutées dans le groupe ".$e->libelle." <br>";
								}
				$creetot+=$cree;
				$cree=0;
			}
$messagem .= "\n\n"."On a créé $creetot fiches\n " ;
echo"On a créé $creetot fiches  <br>";
			echo "<br> ------------FIN DU TRAITEMENT------------------<br>";
				   // On prepare l'email : on initialise les variables
$objet = "peuplement des groupes peres " ;

$messagem .= "\n"." ------------FIN DU TRAITEMENT------------------ \n " ;
$messagem .= " \n";
envoimail($sigiadminmail,$objet,$messagem);	
envoimail($scoltousmail,$objet,$messagem);
}

 //--------------------------------- génération des fiches de  groupes depuis les fiches de cours v1 inutile 2011


 //--------------------------------- génération des fichiers export ADE
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='5'and $login=='administrateur' ){
			 							
}
//--------------------------------- verif table cours
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='6'  ){
	echo"vérification de la correspondance table cours et groupes .<br>";

	  // on recupere les cours
       $query2=" SELECT * FROM groupes  where  type_gpe_auto='edt' order by libelle";
		$result2=mysql_query($query2,$connexion );
$nombre= mysql_num_rows($result2);
echo"<center> <h2>Liste des groupes cours sans correspondance dans refens ";		
  		echo" </h2></center>  <BR>";
		echo"<BR><table border=1> ";
  
  // pour chaque cours
		while ($g=mysql_fetch_object($result2))
		{
		// il faut récupérer le code apogee
			$souslibel=explode('#',$g->libelle);
	$libellecodeapo=$souslibel[1];
$query3=" SELECT * FROM cours where  CODE = '".$libellecodeapo."'";
			   //echo $query3 ."<br>";
				$result3=mysql_query($query3,$connexion ); 
				$correspondance=mysql_num_rows($result3);
								// si  aucun cours correspondant existe
								
				if (!$correspondance)
				{
				echo "<TR>";
				echo "<td> ". $g->libelle."</TD>";	
echo "delete from ligne_groupe where code_groupe ='". $g->code	."';"."<br>";				
echo "delete from groupes where code ='". $g->code	."';"."<br>";			
				echo "</TR>";
								
				}

		}
        echo"</table>";



}
 //--------------------------------- création des fiches groupes depuis les fiches de cours v3-2012 
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='7'and $login=='administrateur' ){	
}

//--------------------------------- export ksup
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='8' and (in_array ($login ,$scol_user_liste ) or  in_array ($login ,$ri_admin_liste ))){
	//echo"export ksup<br>";
$tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query = " SELECT * FROM `cours` order by code ";
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";}
$csv_output .= "\n";




echo"<center> <h2>Liste des ".$nombre."   fiches de cours ";
		echo" </h2></center>  <BR>";
		echo"<BR><table border=1> ";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
        echo "<th>code</th><th>lien ksup</th> <th>libelle court</th><th>email responsable(s)</th>";     
        while($r=mysql_fetch_object($result)) {
		
	foreach($champs as $ci2){
   $csv_output .= nettoiecsvplus($r->$ci2);
   }
   $csv_output .= "\n";
        	echo"   <tr><td>" ;
			echo $r->CODE;
		      echo"   </td><td>" ;
			  					if (array_key_exists($r->CODE,$fiche_code_ksup))
				{
				if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$r->CODE].$url_ksup_suffixe." >"."$r->CODE"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."$r->CODE"."</a>";}
				}
			echo"   </td><td>" ;
			echo $r->LIBELLE_COURT;
		      echo"   </td><td>" ;
			echo $r->emailResponsable;			
			echo"   </td></tr>" ;			
        }
		echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
        echo"</table>";       	
}

//--------------------------------- peuplement auto des groupes de cours 'edt' avec les groupes constitutifs 
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='9')
{
	echo"peuplement auto des groupes de cours avec les groupes constitutifs <br>";
	$cree=0;
	$err=0;
	$test=0;
	$gpe_const_vide=0;
		if(!($test))
		{
		// // on efface les ligne gpes type gpe edt  // attention ne pas effacer les etrangers inscrits autrement  ni les exemptes
		// $sqlquery="delete FROM `ligne_groupe` WHERE `type_inscription`='edt' and ( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui') ";
		// $result=mysql_query($sqlquery,$connexion );
		// //echo  afficheresultatsql($result,$connexion);
		// if ($login == 'administrateur' or $login =='marc.patouillard' )
			// {	
			// echo mysql_affected_rows(). "fiches effacees";
			// echo"<br>";
			// }
		}
	
	// tout d'abord on cree un tableau avec correpondance libelle gpe constitutif/ code _gpe constitutif
	$sqlquery2="SELECT groupes.* FROM groupes where libelle_gpe_constitutif != '' ";
		$resultat2=mysql_query($sqlquery2,$connexion ); 
		while ($v=mysql_fetch_array($resultat2))
		{
		//$ind=$v["libelle"] ;
		$ind3=$v["libelle_gpe_constitutif"] ;
		//$ind2=$v["code"];
		$groupe_code_constitutif[$ind3]=$v["code"];		
		//$groupe_libelle[$ind2]=$v["libelle"];
		//$groupe_code_simple[]=$v["code"];
		}
		echo print_r($groupe_code_constitutif);
		echo "<br>";
	// pour chaque groupe de cours 'edt' avec un gpe_etud_constitutif non vide (cas du bidouillage 2eme semestre 1A 2013-2014 )
	$query = " SELECT * FROM `groupes` where type_gpe_auto='edt'  ";
		//$query.=$where."  ";
	$result = mysql_query($query,$connexion ); 
	$nombre= mysql_num_rows($result);
	echo "<br> Nous avons $nombre groupe(s) de type edt à traiter<br>";
		        while($r=mysql_fetch_object($result)) 
				{
				$gpe_const=$r->gpe_etud_constitutif;
				$code_groupe_cours=$r->code;
// 2018 les semetres sont sur 2 chiffres				
				//$semestre_groupe_cours=substr($r->arbre_gpe,-2);
				$semestre_groupe_cours=substr($r->arbre_gpe,-3);				
				if ($login == 'administrateur' or $login =='marc.patouillard' )
				{	
				echo " groupe".$r->libelle."-".$r->code." semestre ".$semestre_groupe_cours." à peupler avec :  ".$gpe_const." <br>";
				}
					// 2021 inutile , si $gpe_const est vide il faut quant même supprimer les inscriptions [edt] pour ce groupe
					//if ($gpe_const !='' and strtoupper($gpe_const) !='VIDE')
						if (1)
					{
						//  on efface les lignes gpes type gpe edt de ce groupe // attention ne pas effacer les etrangers inscrits autrement  ni les exemptes
						$sqlquery6="delete FROM `ligne_groupe` WHERE  code_groupe='".$r->code ."' and `type_inscription`='edt' and ( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui') ";
						if ($login == 'administrateur' or $login =='marc.patouillard' )
						{
						echo "<br> Pour groupe $r->code requete ,  $sqlquery6<br>";
						}
						if(!($test))
						{
						$result6 = mysql_query($sqlquery6,$connexion );
						$lignes_eff=mysql_affected_rows();
							if ($login == 'administrateur' or $login =='marc.patouillard' )
							{
							echo "<br> Pour groupe $r->code ,  $lignes_eff  lignes effacées<br>";
							}
						}				
					// on va récupérer les membre de ces gpe constitutif (si ils existent) ds ligne gpe
					// on isole les groupes constitutifs séparés par des virgules
					$listeGrpeConst =explode(',',$gpe_const);
					foreach($listeGrpeConst as $un_gpe_const )											
						{
							//echo "<br> debug : $un_gpe_const<br>";
							if (array_key_exists($un_gpe_const,$groupe_code_constitutif))
							{						
							$query2 = " SELECT * FROM `ligne_groupe` where  code_groupe='".$groupe_code_constitutif[$un_gpe_const]."' ";
							//echo "<br> debug : $query2 <br>";
							$result2 = mysql_query($query2,$connexion ); 
								if (mysql_num_rows($result2) !=0)
								{
									while($s=mysql_fetch_object($result2))
									{
									$temp=$s->code_etudiant;
									// on inscrit  les ligne gpes correspondantes si elles n'existent pas déjà et si le semestre est OK 
									$sqlquery5="SELECT  * FROM ligne_groupe    where code_etudiant='".$temp."' and code_groupe='".$code_groupe_cours."' ";
									//echo "<br>".$sqlquery5."<br>";
									$resultat5 = mysql_query($sqlquery5,$connexion );
										if (mysql_num_rows ($resultat5) == 0)
										{
										// on vérifie pour les semestres
												if ( $s->semestre=='' or  $s->semestre==$semestre_groupe_cours)
												// c'est bon 
													{
														if ($login == 'administrateur' or $login =='marc.patouillard' )
														{	
														echo "<center><b>on inscrit ".$temp ." dans le groupe $code_groupe_cours</b></center> <br>";
														}
												$cree++;
												$sql="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif)  
												values ('".$code_groupe_cours."','".$temp."','edt','".$login."',now())";
													if(!($test))
													{
													$result3 = mysql_query($sql,$connexion ); 
													if ($login == 'administrateur' or $login =='marc.patouillard' )
														{	
													//echo $sql ."<br>";
														echo afficheresultatsql($result3,$connexion);
														}
													}
													else
													{
													if ($login == 'administrateur' or $login =='marc.patouillard' )
														{
														echo $sql ."<br>";
														}
													}	
													}else
													{
														if ($login == 'administrateur' or $login =='marc.patouillard' )
														{	
													echo "".$temp ." les semestres ne correspondent pas semestre inscription :".$s->semestre." semestre groupe :".$semestre_groupe_cours." pour le groupe $code_groupe_cours <br>";
														}
													}
										}else
										{
											if ($login == 'administrateur' or $login =='marc.patouillard' )
											{	
										echo "".$temp ." est déjà dans le groupe $code_groupe_cours <br>";
											}
										}
									}
								}
								else
								{
								echo " le groupe constitutif ".$un_gpe_const." existe mais est vide <br>";
								}

							}
							else
							{
							echo affichealerte( " le groupe constitutif  ".$un_gpe_const." n'existe pas ");
							$err++;
							}
						}// fin du foreach					
					}
					else
					{
					echo " On saute le groupe ".$r->libelle."-".$r->code." car il ne possède pas de groupe constitutif ou bien le groupe constitutif est le groupe 'VIDE' <br>";
					$gpe_const_vide++;
					}						
				}			
	echo "<br> ------------FIN DU TRAITEMENT------------------<br>";
	echo "$cree fiches ligne cours créées-----<br>";
	echo "$err cas de fiches de groupe constitutif qui n existent pas-----<br>";
	echo "$gpe_const_vide cas de fiches de groupe cours sans groupe  constitutif ou bien avec le groupe constitutif est le groupe 'VIDE'-----<br>";
	   // On prepare l'email : on initialise les variables
$objet = "peuplement des groupes cours" ;
$messagem .= "\n"."Le service SCOLARITE (".$login.") vient de lancer la procédure de peuplement des groupes cours \n " ;
$messagem .= "\n"."$cree fiches ligne cours créées----- \n " ;
$messagem .= "\n"."$err cas de fiches de groupe constitutif qui n existent pas----- \n " ;
$messagem .= "\n"."$gpe_const_vide cas de fiches de groupe cours sans groupe  constitutif ----- \n " ;
$messagem .= " \n";
envoimail($sigiadminmail,$objet,$messagem);	
envoimail($scoltousmail,$objet,$messagem);	

}

//--------------------------------- génération des fichiers  AGALAN
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='10' and $login=='administrateur' )
{
	echo"génération des fichiers  AGALAN <br>";
	$cree=0;
	$err=0;
	$creepop=0;
	$repfichier="begi2agalan/";
	$table="annuaire";
	$gpedegpe='';
	// on cree un tableau pour stocker les membres du groupe englobant pour chaque ue
	$membre_ue=array();
	$oldue='';
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="annuaire";
$champs=champsfromtable($tabletemp);

foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
	
	// tout d'abord on cree un tableau avec correpondance libelle gpe/ code _gpe
	$sqlquery2="SELECT groupes.* FROM groupes ";
		$resultat2=mysql_query($sqlquery2,$connexion ); 
		while ($v=mysql_fetch_array($resultat2))
		{
		$ind=$v["libelle"] ;
		$ind3=$v["libelle_gpe_constitutif"] ;
		$ind2=$v["code"];
		$groupe_code_constitutif[$ind3]=$v["code"];		
		$groupe_libelle[$ind2]=$v["libelle"];
		$groupe_code_simple[]=$v["code"];
		}
		//echo print_r($groupe_code_constitutif);
		echo "<br>";
		
		// on efface les ancien fichiers

$dossier_traite = $repfichier;
 
$repertoire = opendir($dossier_traite); //on définit le répertoire dans lequel on souhaite travailler
 
while (false !== ($fichier = readdir($repertoire))) //on lit chaque fichier du répertoire dans la boucle
{
$chemin = $dossier_traite."/".$fichier; //on définit le chemin du fichier à effacer
 
//si le fichier n'est pas un répertoire
if ($fichier != ".." AND $fichier != "." AND !is_dir($fichier))
       {
       unlink($chemin); //on efface
	   echo "on efface ".$chemin."<br>";
       }
}
closedir($repertoire); //Ne pas oublier de fermer le dossier !EN DEHORS de la boucle ! Ce qui évitera à PHP bcp de calculs et des pbs liés à l'ouverture du dossier

		

	// pour chaque groupe de cours 'edt'
	//attention le libelle n'est pas sufffisant comme ordre de tri : il faut extraire du libellé le code apogee
	$query = " SELECT * FROM `groupes` where type_gpe_auto='edt'   order by SUBSTRING_INDEX(`libelle`, '#', -1)";
		//$query.=$where."  ";
	$result = mysql_query($query,$connexion ); 
	$nombre= mysql_num_rows($result);
	echo "<br> Nous avons $nombre groupe(s) de type edt à traiter<br>";
					echo "<br>-------------debut du fichier go---------------<br>";
									// on va creer le fichier  go
				$Fgo = $repfichier."go"; 
				$inFgo = fopen($Fgo,"w");
				fclose($inFgo);	
					echo "<br>-------------debut du fichier inf---------------<br>";
									// on va creer le fichier .inf
				$Finf = $repfichier."begi.inf"; 
				$inFinf = fopen($Finf,"w"); 
		        while($r=mysql_fetch_object($result)) 
				{
				$code_groupe_cours=$r->code;
				echo " groupe ".$r->libelle." <br>";
// on recupere le code apogee du cours 

				$souslibel=explode('#',$r->libelle);
				$libellebrut=$souslibel[1];
				if (strpos($souslibel[0],'_'))
				{
				// attention sur ensgiweb avec la version  de php on ne peut pas ajouter true pour stristr
				//$libellecourt=stristr($souslibel[0],'_',true);
				$libellecourt=substr($souslibel[0],0,strpos($souslibel[0],'_'));
				
				$libellegpe=stristr($souslibel[0],'_');
				$libellegpe=substr($libellegpe,1,strlen($libellegpe)-1);
				}
				else
				{
				$libellecourt=$souslibel[0];
				$libellegpe=$libellecourt;
				}
				$libellecourt=ucwords($libellecourt);
				$libellecourt=rewrite($libellecourt);
				$libellegpe=rewrite($libellegpe);
				
				echo "<br>".$r->libelle ."-----".$libellebrut ."-----".$libellecourt ."-----".$libellegpe ."-----"."<br>";
	
				if($oldue=='')
					{// pour la premiere fois 
					$oldue=$libellebrut;
					$oldibelcourt=$libellecourt;
					$ligneinf="#v1-0";
					fwrite($inFinf,$ligneinf."\r\n");
					}
					
					echo "oldue-".$oldue ."_________".$r->libelle ."____________".$libellebrut." <br>";
								if($oldue!=$libellebrut)
									{	
																		
									// si oui on dumpe le tableau $membre_ue
									
									//$Fpoptot = $repfichier.$libellebrut.$libellecourt."_Groupe-Tous".".pop"; 
									$Fpoptot = $repfichier.$oldue.$oldibelcourt."_Groupe-Tous".".pop"; 
									echo "<br>On DUMPE le tableau membre_ue dans ".$Fpoptot."<br>";
									$inFpoptot = fopen($Fpoptot,"w");
									for ($i=0;$i<sizeof($membre_ue);$i++)
										{
										$temp=$membre_ue[$i];
										// on recupere lesligne gpes correspondantes
										$lignepoptot = "inpg;;;;;;inpg_apo-".$temp;
										fwrite($inFpoptot,$lignepoptot."\r\n");
										}
										$creepop++;
									// Pour créer le gpe de gpe on stocke la chaine ds une variable	
									$gpedegpe.=",inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."_Groupe-Tous"; 
									fclose($inFpoptot);

									// on efface le tableau membre_ue
									$membre_ue=array();
									// on ecrit une ligne ds le inf
									$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."_Groupe-Tous".";Groupe Tous base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$oldue.$oldibelcourt."_Groupe-Tous".".pop";
									fwrite($inFinf,$ligneinf."\r\n");
									$cree++;
									$oldue=$libellebrut;
									$oldibelcourt=$libellecourt;
									}
									else
									{// sinon  on ne fait rien 
									}
					
				echo "<br>".$libellebrut."<br>";
				$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$libellebrut.$libellecourt."_Groupe-".$libellegpe.";Groupe base eleves;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$libellebrut.$libellecourt."_Groupe-".$libellegpe.".pop";
				fwrite($inFinf,$ligneinf."\r\n");
				$cree++;
				// on cree le fichier pop correpondant
				$Fpop = $repfichier.$libellebrut.$libellecourt."_Groupe-".$libellegpe.".pop"; 
				$inFpop = fopen($Fpop,"w"); 
				// on va récupérer les membres de ce gpe   ds ligne gpe						
						$query2 = " SELECT `Code etu` as code_etu FROM `ligne_groupe` 
						left outer join etudiants on upper(ligne_groupe.`code_etudiant`)=etudiants.`Code etu`
						where  code_groupe='".$code_groupe_cours."' ";
						$result2 = mysql_query($query2,$connexion ); 

								while($s=mysql_fetch_object($result2))
								{
								$temp=$s->code_etu;
								// on recupere lesligne gpes correspondantes
								$lignepop = "inpg;;;;;;inpg_apo-".$temp;
								fwrite($inFpop,$lignepop."\r\n");
								echo "on inscrit inpg_apo-".$temp ." <br>";								
								//on ajoute le membre au tableau  si il n'y est pas déja
									
									if (!(in_array($temp,$membre_ue)))
										{
										$membre_ue[]=$temp;
										}
										else
										{
										echo $temp ."_________existe deja on ne l'ajoute pas au fichier tot <br>";
										}					
								}
								fclose($inFpop);
								// on verifie si on a changé d'UE
								
								
				echo "<br>-------------fin du fichier pop pour  $libellebrut ---------------<br>";								
				}
				//ici il faut traiter le cas du dernier groupe de la liste
									$Fpoptot = $repfichier.$oldue.$oldibelcourt."_Groupe-Tous".".pop"; 
									echo "<br>On DUMPE le tableau membre_ue dans ".$Fpoptot."<br>";
									$inFpoptot = fopen($Fpoptot,"w");
									for ($i=0;$i<sizeof($membre_ue);$i++)
										{
										$temp=$membre_ue[$i];
										// on recupere lesligne gpes correspondantes
										$lignepoptot = "inpg;;;;;;inpg_apo-".$temp;
										fwrite($inFpoptot,$lignepoptot."\r\n");
										}
										$creepop++;
									// Pour créer le gpe de gpe on stocke la chaine ds une variable	
									$gpedegpe.=",inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."_Groupe-Tous"; 
									fclose($inFpoptot);
									// on efface le tableau membre_ue
									$membre_ue=array();
									// on ecrit une ligne ds le inf
									$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."_Groupe-Tous".";Groupe Tous base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$oldue.$oldibelcourt."_Groupe-Tous".".pop";
									fwrite($inFinf,$ligneinf."\r\n");
									$cree++;
									//inutile pour le dernier
									//$oldue=$libellebrut;
									//$oldibelcourt=$libellecourt;
				
				// on ferme le fichier
				echo "<br>-------------fin du fichier inf---------------<br>";
				fclose($inFinf); 
				// on cree le deuxieme inf pour generer le gpe de gpe :  plus la peine
				 //il faut enlever la virgule au debut
				$gpedegpe=substr($gpedegpe,1,strlen($gpedegpe)-1) ;
				$Finf = $repfichier."begi2.inf"; 
				// pour le moment onne créé plus ce fichier, le gpe de gpe est créé par un filtre
				$inFinf = fopen($Finf,"w"); 
					$ligneinf="#v1-0";
					fwrite($inFinf,$ligneinf."\r\n");
				$ligneinf="inpg;INPG;inpg-Ecole_GI-Appli_Dokeos-Classe_Tous;Groupe de gpes pour dokeos  base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;;;;".$gpedegpe;
				fwrite($inFinf,$ligneinf."\r\n");
				fclose($inFinf);	

				
						
							
	echo "<br> ------------FIN DU TRAITEMENT------------------<br>";
	echo "$cree groupes créés-----<br>";
		echo "$creepop groupes tot créés-----<br>";
		//echo "$err cas de fiches de groupe constitutif qui n existent pas-----<br>";
}
//--------------------------------- récupération codes ressources ADE  et modif code ADE ds fiches groupe
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='11' and $login=='administrateur' )
{
	
	}
//---------------------------------calcul et ajout des code_groupe_begi dans code_ade_groupes 2012
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='13' and $login=='administrateur' )
{
	}	
	
//---------------------------------calcul et ajout des code_groupe_begi dans code_ade_groupes 2014
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='17' and $login=='administrateur' )
{	
	}	
	
		
//---------------------------------remplissage  emails membres jury par connexion ldap
if($_POST['bouton_synchro']=='OK' and $_POST['synchro']== '14' and $login=='administrateur' ){
echo"fonctionnalité supprimée";

}  	
//--------------------------------- récupération codes ressources ADE  et modif code ADE ds fiches groupe
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='15' and $login=='administrateur' )
{
	echo"récupération codes ressources ADE et ajout dans fiches groupes<br>";
	// simulation ou pas ?

	$cree=0;
	$err=0;
$query = " SELECT * FROM codes_ade_import left outer join groupes on groupes.libelle=codes_ade_import.libelle_groupe_begi  where code_ade_imp != ''  ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>Liste des ".$nombre."   groupes à modfier ";
		echo" </h2></center>  <BR>";
		echo"<BR><table border=1> ";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
        echo "<th>libelle gpe import </th><th>libelle gpe begi</th> <th>code gpe</th><th>code ade import</th>";    
$querytot='';		
	 while($r=mysql_fetch_object($result)) {
        echo "<tr><td>$r->libelle_groupe_begi</td><td>$r->libelle</td><td>$r->code</td> <td>$r->code_ade_imp</td></tr>";  	

	$query2 = " update  `groupes` set code_ade6='".$r->code_ade_imp."' where  code='".$r->code."';<br>";
$querytot.=$query2;
	//$result2 = mysql_query($query2,$connexion ); 
	
      }
	  			echo"<BR></table border=1> ";
		echo $querytot."<br>";
	}	
//--------------------------------- peuplement groupe tous
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='16' and $login=='administrateur' )
{
	echo"peuplement groupe 'TOUS'<br>";
	// on recupere tous les etudiants
$tous=0;
$query = " SELECT * FROM `etudiants`    ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   étudiants </h2> ";
		
	 while($e=mysql_fetch_object($result)) {
		   // on les mets dans le groupe spécial TOUS,  si ils n'y sont pas déjà 			
			//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
			$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_tous."' and code_etudiant='".$e->$myetudiantscode_etu."'";
			$result4=mysql_query($query4,$connexion ); 
			if (mysql_num_rows($result4)==0)
				{
					$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif) 
					VALUES('".$code_gpe_tous."','".$e->$myetudiantscode_etu."','imp','".$login."',now())";
				  // echo $query3 ."<br>";
				   $result3 = mysql_query($query3,$connexion);
				   $tous++;
				}
			else
				{
				echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe  tous <br>\n ";
						echo "\n ";
				}
      } 			
		echo "c'est fait : ".$tous ." ajouts dans le groupe tous ";
	}	
//--------------------------------- synchro cours REFENS
if(($_POST['bouton_synchro']=='OK' or $_POST['bouton_synchro_test']!='')  and  $_POST['synchro']=='18' and $login=='administrateur' )
{

	if( $_POST['bouton_synchro_test']!='')
	echo"<center>SIMULATION synchro cours REFENS $anneeRefens</center><br>";else echo"<center>synchro cours REFENS $anneeRefens</center><br>";
	// on ferme la connexion sur la base eleves:
	mysql_close($connexion);
	// on se connecte sur refens
$dsnrefens="REFENS_GI";
$usernamerefens="READ_GI";
$passwordrefens="Gb2hs9fdzQ";
$hostrefens="corbeau.infra.grenoble-inp.fr";

$connexionrefens =Connexion ($usernamerefens, $passwordrefens, $dsnrefens, $hostrefens);

// on parcourt la selection de refens  

$sqlquery2="SELECT M.id, M.codeApogee 'apogee', D.nomCourt 'nom court', D.nomLong 'nom long', M.ectsParDefaut 'ECTS',P.nom 'semestre',''
FROM Matiere M JOIN DescriptionMatiere D on D.matiere_id=M.id
JOIN Cours C on C.matiere_id=M.id
JOIN Periode P on P.id=C.periode_id
WHERE M.idComposante=4
AND M.anneeVersion=".$anneeRefens."
AND  not estDesactive 
AND D.langue_id % 2 = 1 
 ; ";

//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexionrefens ); 
$nombrerefens= mysql_num_rows($resultat2);
//echo $nombrerefens ."<br>";
$i=0;
while ($v=mysql_fetch_array($resultat2)){
	//echo $i." ".$v['apogee']." ".$v['semestre']." ".$v['nom court']." ".$v['id']." <br>";
	$coursrefensId[]=$v['id'];
	$coursrefens[]=$v['apogee'];
	$coursrefensApogee[]=$v['apogee'];	
	$coursrefensNomCourt[]=$v['nom court'];
	$coursrefensNomLong[]=$v['nom long'];	
	$coursrefensSemestre[]=$v['semestre'];	
	$coursrefensECTS[]=$v['ECTS'];		
	$i++;	
}

// pour récupérer les emails des responsables
foreach($coursrefensId as $uncours)
{
	$sqlquery3="SELECT M.codeApogee 'apogee', D.nomCourt 'nom court', D.nomLong 'nom long', M.ectsParDefaut 'ECTS',P.nom 'semestre', E.email,E.idAgalan FROM Matiere M JOIN DescriptionMatiere D on D.matiere_id=M.id JOIN Cours C on C.matiere_id=M.id JOIN Periode P on P.id=C.periode_id JOIN Cours_Enseignant CE on CE.Cours_id=C.id JOIN Enseignant E ON E.id=CE.responsables_id WHERE M.id='".$uncours."' and  M.idComposante=4 AND M.anneeVersion=".$anneeRefens." AND D.langue_id % 2 = 1  AND not  estDesactive ; ";
//echo $sqlquery3;
	$resultat3=mysql_query($sqlquery3,$connexionrefens );
$emailresp='';
$emailrespold='';
$uidresp='';

	while ($w=mysql_fetch_array($resultat3)){	

			if($emailrespold!=$w['email']) 
			{
				$emailresp.=$w['email'].',';
				$uidresp.=$w['idAgalan'].',';
			}
		else
		{
		//on ne fait rien , c'est un doublon
		}
		$emailrespold=$w['email'];		
			}
			//pour enlever la virgule à la fin
			 $emailresp=substr($emailresp,0,strlen($emailresp)-1) ;
			 $uidresp=substr($uidresp,0,strlen($uidresp)-1) ;			 
	$courefensEmail[]=$emailresp;
	$courefensIdResp[]=$uidresp;

}

// pour récupérer les volumes horaires
foreach($coursrefensId as $uncours)
{
	$sqlquery4="SELECT M.id, V.nbHeures,M.codeApogee 'apogee', M.ectsParDefaut 'ECTS',V.matiere_id,T.nom,H.eqTD FROM VolumeHoraire V 
JOIN Matiere M ON M.id=V.matiere_id
JOIN TypeHeure T on V.typeHeure_id=T.id
JOIN TypeHeureHelico H on H.id=T.typeHelico_id
WHERE V.matiere_id='".$uncours."' AND M.idComposante=4 AND M.anneeVersion=".$anneeRefens  ;
	
	
	
//echo $sqlquery4;
	$resultat4=mysql_query($sqlquery4,$connexionrefens );
$totheure=0;
$detailHeures='';
	while ($w=mysql_fetch_array($resultat4)){	
	$totheure +=$w['nbHeures']*$w['eqTD'];
	$detailHeures.=$w['nom'].":".$w['nbHeures'].' ';
			}
		
$courefensHeures[]=$totheure;
$courefensDetailHeures[] =$detailHeures;
}



/* echo "<xmp>";
var_dump($courefensHeures);
echo "</xmp>"; */
echo "<br>";	
mysql_close($connexionrefens);
// on rouvre la connexion à la base élèves
$connexion =Connexion ($user_sql, $password, $dsn, $host);
	if( $_POST['bouton_synchro_test']=='')
	{
// on vide la table cours sauf IA Long et IA
$query = " DELETE  FROM cours  where CODE !='5GUC0308' and CODE !='5GUC0307' ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_affected_rows();
echo"<center> <h2>on vient d'effacer   ".$nombre."  fiches de  cours </h2> ";
	}
$cree=0;
$erreur=0;
$anomalie=0;



for($i=0;$i<count($coursrefensApogee);$i++){	
		// il faut tester le cas ou le semestre ne correspond pas au code apogee cours bidons créés dans refens uniquement pour affichage KSUP (master SIE)
		//il ne faut pas prendre ceux dont le code apogee commence par  (5 ou W (sauf les WGUS )) et S3 et  ceux dont le code apogee commence par  (4 )) et S2 et S1 :
		
if (!(((substr($coursrefensApogee[$i],0,1) == '5' or (substr($coursrefensApogee[$i],0,1) == 'W') and substr($coursrefensApogee[$i],0,4) != 'WGUS')and
 (substr($coursrefensSemestre[$i],-1) =='3')) or 
((substr($coursrefensApogee[$i],0,1) == '4' )and(substr($coursrefensSemestre[$i],-1) =='2'))
 or 
((substr($coursrefensApogee[$i],0,1) == '4' )and(substr($coursrefensSemestre[$i],-1) =='1'))
))

	{	
					echo "on importe le cours : ---  ". $coursrefensApogee[$i]."|".$coursrefensNomCourt[$i]."|".$coursrefensNomLong[$i]."|".$coursrefensECTS[$i]."|".
					$coursrefensSemestre[$i]."|".
					$courefensEmail[$i]."|".					
					$courefensIdResp[$i]."|".
					$courefensHeures[$i]."|".
					$courefensDetailHeures[$i]."|".
					"<br>";

					$cree++;
	if( $_POST['bouton_synchro_test']=='')
	{			
$query3 = "INSERT INTO cours (CODE,`nom court court`,LIBELLE_LONG,CREDIT_ECTS,semestre,emailResponsable,uidResponsable,heuresEqTD,heuresDetail) 
VALUES('".$coursrefensApogee[$i]."','".str_replace("'","''",stripslashes($coursrefensNomCourt[$i]))."','".str_replace("'","''",stripslashes($coursrefensNomLong[$i]))."','".$coursrefensECTS[$i]."','".$coursrefensSemestre[$i]."','".$courefensEmail[$i]."','".$courefensIdResp[$i]."','".$courefensHeures[$i]."','".$courefensDetailHeures[$i]."')";
					  $result3 = mysql_query($query3,$connexion);
					 	if ($result3){$cree++;} else {
						//echo  $query3 ."<br>";
						echo mysql_error()."<br>";
						$erreur++;}
	}			
	}
	else
	{	
	echo affichealerte("non correspondance code apo / semestre : cours dupliqué ?  ". $coursrefensNomCourt[$i]."|".$coursrefensApogee[$i]."<>".$coursrefensSemestre[$i]);
	$coursrefensNomCourt[$i]='NON IMPORTE';
	$anomalie++;
	}
}
echo"on a créé ".$cree." fiches de cours dans la table Cours<br>";
echo"on a rencontré ".$erreur." erreurs lors de la création  dans la table Cours<br>";
echo"on a rencontré ".$anomalie." anomalies dans Ksup qu'on a pas importées<br>";
echo"on modifie la colonne libelle_court  pour récupérer le numéro de semestre par  requete (marche pas pour IPID)<br>";
$query4 = "update cours set libelle_court = concat('S',right(semestre,1),' ',libelle_long) ";
//on est pas en test
	if( $_POST['bouton_synchro_test']=='')
	{
$result4 = mysql_query($query4,$connexion);
				  	if ($result4){echo "modification OK<br>";} else {
					 echo  $query4 ."<br>";
					echo mysql_error()."<br>";
					 $erreur++;}
	}								
$sqlquery5="SELECT * from cours ";
$resultat5=mysql_query($sqlquery5,$connexion ); 
$nombre= mysql_num_rows($resultat5);									
echo "<table border=1>";
//var_dump($coursrefensApogee);
while ($v=mysql_fetch_array($resultat5))
	{
		$danslabase[]=$v['CODE'];
	$coursbaseNomCourt[$v['CODE']]=$v['nom court court'];
	$coursbaseNomLong[$v['CODE']]=$v['LIBELLE_LONG'];	
	$coursbaseSemestre[$v['CODE']]=$v['semestre'];	
	$coursbaseECTS[$v['CODE']]=$v['CREDIT_ECTS'];			
	$coursbaseEmail[$v['CODE']]=$v['emailResponsable'];		
	$coursbaseheuresEqTD[$v['CODE']]=$v['heuresEqTD'];			
	$coursbaseheuresDetail[$v['CODE']]=$v['heuresDetail'];			
		
		
		
		
		
	// on affiche les lignes
	echo "<tr>";
	 echo "<td>";
	echo $v['CODE'];	
	echo "</td><td>";
	echo $v['nom court court']; 
	echo "</td><td>";
	echo $v['LIBELLE_LONG'];
	echo "</td><td>";
	echo $v['CREDIT_ECTS'];
	echo "</td><td>";
	echo $v['semestre'];
	echo "</td><td>";
	echo $v['LIBELLE_COURT'];
	echo "</td><td>";
	echo $v['emailResponsable'];
	echo "</td><td>";
	echo $v['heuresEqTD'];	
	echo "</td><td>";
	echo $v['heuresDetail'];		
	echo "</tr>";
	
	// on recherche le même code dans le tableau des nouveaux cours
	$ref= array_keys($coursrefensApogee, $v['CODE']);

	if(sizeof($ref)==1 )
	{		
	echo "<tr bgcolor=lightgreen>";
	if ($v['CODE']!=$coursrefensApogee[$ref[0]])$bgcol='red';else $bgcol='';
	 echo "<td bgcolor=$bgcol>";
	echo $coursrefensApogee[$ref[0]];
	if ($v['nom court court']!=$coursrefensNomCourt[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensNomCourt[$ref[0]];
	if ($v['LIBELLE_LONG']!=$coursrefensNomLong[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	if ($v['CODE']!=$coursrefensApogee[$ref[0]])$bgcol='red';else $bgcol='';	 
	echo $coursrefensNomLong[$ref[0]];
	if ($v['CREDIT_ECTS']!=$coursrefensECTS[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensECTS[$ref[0]];
	if ( $v['semestre']!=$coursrefensSemestre[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensSemestre[$ref[0]];
	echo "</td><td>";
	//echo $v['LIBELLE_COURT'];
	if ( $v['emailResponsable']!=$courefensEmail[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensEmail[$ref[0]];
	if ( $v['heuresEqTD']!=$courefensHeures[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensHeures[$ref[0]];
	if (  $v['heuresDetail']!=$courefensDetailHeures[$ref[0]])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensDetailHeures[$ref[0]];	
	echo "</tr>";		
	}
	
	// c'est qu'il y avait plus d'une correspondance avec le code apogee , on supprime celles qui n'ont pas été importées avec la règle ci dessus
	elseif(sizeof($ref)>1 ){
		foreach($ref as $unref)
		{
			if($coursrefensNomCourt[$unref]=='NON IMPORTE')
			{
	echo "<tr bgcolor=lightblue>";
	if ($v['CODE']!=$coursrefensApogee[$unref])$bgcol='red';else $bgcol='';
	 echo "<td bgcolor=$bgcol>";
	echo' <b>'.$coursrefensApogee[$unref];
	if ($v['nom court court']!=$coursrefensNomCourt[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensNomCourt[$unref];
	if ($v['LIBELLE_LONG']!=$coursrefensNomLong[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	if ($v['CODE']!=$coursrefensApogee[$unref])$bgcol='red';else $bgcol='';	 
	echo $coursrefensNomLong[$unref];
	if ($v['CREDIT_ECTS']!=$coursrefensECTS[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensECTS[$unref];
	if ( $v['semestre']!=$coursrefensSemestre[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensSemestre[$unref];
	echo "</td><td>";
	//echo $v['LIBELLE_COURT'];
	if ( $v['heuresEqTD']!=$courefensHeures[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensHeures[$unref];	
	if ( $v['heuresDetail']!=$courefensDetailHeures[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensDetailHeures[$unref].'</b>';
	echo "</tr>";
			}				
			
			
			else
			{
	echo "<tr bgcolor=aqua>";
	if ($v['CODE']!=$coursrefensApogee[$unref])$bgcol='red';else $bgcol='';
	 echo "<td bgcolor=$bgcol>";
	echo' <b>'.$coursrefensApogee[$unref];
	if ($v['nom court court']!=$coursrefensNomCourt[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensNomCourt[$unref];
	if ($v['LIBELLE_LONG']!=$coursrefensNomLong[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	if ($v['CODE']!=$coursrefensApogee[$unref])$bgcol='red';else $bgcol='';	 
	echo $coursrefensNomLong[$unref];
	if ($v['CREDIT_ECTS']!=$coursrefensECTS[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensECTS[$unref];
	if ( $v['semestre']!=$coursrefensSemestre[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $coursrefensSemestre[$unref].'</b>';
	echo "</td><td>";
	//echo $v['LIBELLE_COURT'];
	if ( $v['emailResponsable']!=$courefensEmail[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensEmail[$unref];
	if ( $v['heuresEqTD']!=$courefensHeures[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensHeures[$unref];	
	if ($v['heuresDetail']!=$courefensDetailHeures[$unref])$bgcol='red';else $bgcol='';	
	 echo "</td><td bgcolor=$bgcol>";
	echo $courefensDetailHeures[$unref];	
	echo "</tr>";
			}
		}	
}
else 	{
	// c'est qu'il n'y a plus ce code dans le refens actuel
echo "<tr bgcolor='orange'>";
		 echo "<td>";
		echo 'pas de correspondance dans refens';
		echo "</td><td>";	
		echo "</tr>";	
}

	}
	echo "</table>";
	
		echo"il y a ".sizeof($danslabase) ." cours ".$anneeRefens."<br>";
	echo"il y a ".sizeof($coursrefensApogee) ." dans refens <br>";
		// on recherche les exclus de l'import
	$nonimp= array_keys($coursrefensNomCourt, 'NON IMPORTE');
	echo"il y a ".sizeof($nonimp) ." 'NON IMPORTE' dans refens <br>";	
	if (sizeof($nonimp) +sizeof($danslabase) ==sizeof($coursrefensApogee)) 	echo "il y a le meme nombre d'éléments dans la base et  dans refens <br>";	else echo "ATTENTION n'y a pas le meme nombre d'éléments dans la base et  dans refens <br>";
	//var_dump($danslabase);

	$diff1=array_diff($coursrefensApogee,$danslabase);
	if(sizeof($diff1)>0)	echo " dans ce cas on affiche 	les cours présents dans refens et pas dans la base : ils seront créés<br>";
		echo "<table>";
		foreach(	$diff1 as $unref)
		{	
		//echo $unref ."<br>";
		//var_dump($coursrefensApogee);
	$ref= array_keys($coursrefensApogee,$unref);
		if(sizeof($ref)==1 )
	{
		//echo $ref ."<br>";	
		echo "<tr bgcolor='yellow'>";
		 echo "<td>";
		echo $coursrefensApogee[$ref[0]];
		echo "</td><td>";
		echo $coursrefensNomCourt[$ref[0]];
		echo "</td><td>";
		echo $coursrefensNomLong[$ref[0]];
		echo "</td><td>";
		echo $coursrefensECTS[$ref[0]];
		echo "</td><td>";
		echo $coursrefensSemestre[$ref[0]];
		echo "</td><td>";
		//echo $v['LIBELLE_COURT'];
		echo "</td><td>";
		echo $courefensEmail[$ref[0]];		
		echo "</tr>";
	}		
		}	
	echo "</table>";
	

		$diff2=array_diff($danslabase,$coursrefensApogee);
		if(sizeof($diff2)>0)echo "dans ce cas on affiche  les cours présents dans la base et pas dans refens : ils seront supprimés<br>sauf IA Long '5GUC0308' et IA
'5GUC0307";		
		echo "<table>";
		foreach(	$diff2 as $unref)
		{			
		echo "<tr bgcolor='yellow'>";
		 echo "<td>";
		echo $unref;
		echo "</td><td>";
		echo $coursbaseNomCourt[$unref];
		echo "</td><td>";
		echo $coursbaseNomLong[$unref];
		echo "</td><td>";
		echo $coursbaseECTS[$unref];
		echo "</td><td>";
		echo $coursbaseSemestre[$unref];
		echo "</td><td>";
		//echo $v['LIBELLE_COURT'];
		echo "</td><td>";
		echo $coursbaseEmail[$unref];		
		echo "</tr>";				
		}	
	echo "</table>";
	
	}		
//--------------------------------- bascule  gpes offi
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='19' and $login=='administrateur' )
{
	 $annee_scol_nmoins1=($annee_courante-2).'-'.($annee_courante-1);
			 $annee_scol_n=($annee_courante-1).'-'.($annee_courante);	
	echo"bascule d'année $annee_scol_nmoins1->$annee_scol_n  des   gpes offi à l'exception de tous inscrits xxxx-xxxx et import apogee xxxx-xxxx<br>";
	// on recupere tyous les groupes officiels
$tous=0;
$query = " SELECT * FROM `groupes` where groupe_officiel ='oui' and archive ='non'  and type_gpe_auto=''  ";
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   gpes offi non archivés </h2> ";
		// pour chaque groupe sauf 
	 while($e=mysql_fetch_object($result)) {
		 //if ($e->code != $code_gpe_tous_inscrits and $e->code != $code_gpe_imp_apo)
             if (true )
		 {
			 $lib=$e->libelle;
			 //ex  renommage 2019-2020 en 2020-2021
					 
			 $nouveaulib=str_replace( $annee_scol_nmoins1,$annee_scol_n,$lib);

             $annee_scol_nmoinsSlash=($annee_courante-2).'/'.($annee_courante-1);
             $annee_scolSlash=($annee_courante-1).'/'.($annee_courante);



             $new_titre_affiche = str_replace("$annee_scol_nmoinsSlash", $annee_scolSlash , $e->titre_affiche );


					$query3 = "update groupes set libelle='".$nouveaulib."' , titre_affiche = '".$new_titre_affiche."' where code='".$e->code."';";
				  echo $query3 ."<br>";
				  //à décommenter si pas simulation
				  $result3 = mysql_query($query3,$connexion);
				   
			// creation du groupe 	à archiver :




				  $query4=" insert into  groupes(libelle,proprietaire,visible,login_proprietaire,liste_offi,groupe_principal,groupe_officiel,nom_liste,titre_affiche,titre_special,gpe_total,membre_gpe_total,id_ens_referent,code_ade,code_ade6,groupe_cours_complet,gpe_evenement,url_edt_direct,code_pere,type_gpe_auto,arbre_gpe,gpe_etud_constitutif,libelle_gpe_constitutif,archive,niveau_parente,recopie_gpe_officiel,code_etape,nomail,date_modif) 
				  VALUES('".$lib."','administrateur','oui','administrateur','','','oui','','".$e->titre_affiche."','".$e->titre_special."','','','','','','','','','','','','','','oui','','','','', now() );";
				  
				  
				  
				  echo $query4."<br>";
				  //à décommenter si pas simulation
				  $result4 = mysql_query($query4,$connexion);
// récupération de l'id du groupe créé
					$query5 = "select max(code)as maxid from groupes ";
				 // echo $query5."<br>";
				  $result5=mysql_query($query5);
				  	$w=mysql_fetch_object($result5);
				  $maxid=$w->maxid;
				   //echo 'max id :'.$maxid."<br>";

			// déplacement  des membres vers le nouveau groupe  archivé
				$query6 = "update  ligne_groupe set  code_groupe='".$maxid ."' where code_groupe=$e->code;";
				echo $query6."<br>";	
			 //à décommenter si pas simulation
				$result6 = mysql_query($query6,$connexion);
			// suppression des membres du  groupe d'origine pas la peine puisqu'on a déplacé les membres ci dessus 

					$tous++;			  
		 }
		 else 
			 echo "c'est le groupe spécial  : ".$e->libelle ." on ne fait rien  <br>";
      } 			
		echo "c'est fait : ".$tous ." bascules ";
	}	


//--------------------------------- synchro gpes gi_users
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='20' and $login=='administrateur' )
{
	echo"debut synchro gpes gi_users<br>";
	//$id_gpe_resp=7;

	//accès à la table  on peut aussi les mettre dans un fichier de param séparé (param .php)
$dsn_users="gi_users";
$user_sql_users="apache";
$password_users='Bmanpj1';
$host_users="localhost";

$connexion_users =Connexion($user_sql_users, $password_users, $dsn_users, $host_users);
// on récupère les groupes des responsables de cours dans un tableau
//inutile pour l'instant 
/* $groupesrespcours=array();
$query12= " select * from groups where  group_libelle like 'responsables_cours%'  ";
$result12 = mysql_query($query12,$connexion_users ); 
while($z=mysql_fetch_object($result12)) {
$groupesrespcours[$z->group_id]=$z->group_libelle;	
} */

$requetegroupesrespcours=array(
'7'=>'',
'8'=>"where substring(cours.CODE,1,1) = '3' and substring(cours.CODE,4,1) = 'A'",
'9'=>"where substring(cours.CODE,1,1) = '4' and substring(cours.CODE,4,1) = 'P'",
'10'=>"where substring(cours.CODE,1,1) = '5' ",
'11'=>"where substring(cours.CODE,1,1) = 'W' and substring(cours.CODE,4,1) != 'S'",
'12'=>"where substring(cours.CODE,1,1) = 'W' and substring(cours.CODE,4,1) = 'S'",
'13'=>"where substring(cours.CODE,1,1) = '3' and substring(cours.CODE,4,1) = 'C'",
'14'=>"where substring(cours.CODE,1,1) = '4' and substring(cours.CODE,4,1) = 'C'",
'15'=>"where substring(cours.CODE,1,1) = 'W' and substring(cours.CODE,4,1) = 'S'",
'26'=>"where substring(cours.CODE,1,1) = '4' and substring(cours.CODE,4,1) = 'A'",
);

foreach ($requetegroupesrespcours as $id_gpe_resp=>$unwhere)
{
	$cree=0;
	$erreur=0;	
	$vide=0;
$where=$unwhere;
	// on recupere  les uids des responsables de cours dans un tableau
$uidresps=array();
$query = " SELECT * FROM `cours`  ".$where;
echo "<br>".$query;
$result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);	
	echo"<center> <h2>il y a  ".$nombre."   cours  pour la condition $where</h2> ";
		// pour chaque cours sauf 
	 while($e=mysql_fetch_object($result)) {
		 // il faut d'abord exploser si besoin
		 if ($e->uidResponsable !='')
		 {
			 $tab_resp= explode(',',$e->uidResponsable);
			 foreach($tab_resp as $unresp)
			 {			
				$uidresps[]=$unresp;
			 }
		 }
		 else{
			 $vide++;
		 }
		 
      }
	  	//  var_dump($uidresps);
	  //On supprime les doublons :
	  $uidrespsuniq=array_unique($uidresps);
	  	//  var_dump($uidrespsuniq);
	  // on efface les lignes du groupe
	  $query="delete from lignes_groupes where groupe_id='".$id_gpe_resp."'";
	  $result10 = mysql_query($query,$connexion_users ); 
	  echo "<br> ".mysql_affected_rows()." lignes du groupe  $id_gpe_resp effacées";
	  // on ajoute les nouvelles
	  		 foreach($uidrespsuniq as $uidresp)
			 {
				 
				 // on vérifie si il existe dans people
				$query11= " select * from people where  user_login ='".$uidresp."'  ";
					$result11 = mysql_query($query11,$connexion_users );
if (mysql_num_rows($result11)==0)
echo "<br> ERREUR 	$uidresp n'existe pas dans people";
else
{

			$query = " insert into lignes_groupes  (groupe_id,people_id) VALUES ('".$id_gpe_resp."','".$uidresp."')  ";
				$result9 = mysql_query($query,$connexion_users ); 
				if ($result9){$cree++;} else {					 
					 $erreur++;}
				 
			 }
			 }
//print_r($uidresps);	  
		echo "<br>c'est fait :  $cree ajout de lignes et $erreur erreurs ( $vide responsables vides) ";
		
	}	
}

//--------------------------------- nettoyage des données personnelles
if($_POST['bouton_synchro']=='OK' and  $_POST['synchro']=='30' and $login=='administrateur')
{
	if (isset($_POST['anneesuppression']) and $_POST['anneesuppression']>2000  and $_POST['anneesuppression']<2030)
	{
	$anneesuppression='2021';
	$anneesuppression=$_POST['anneesuppression'];
	echo"debut synchro nettoyage des données personnelles<br>";
	echo"debut synchro nettoyage des données personnelles<br>";
	
echo "<h3>pour pouvoir utiliser les données anciennes à des fins de statistiques , on n'efface pas  mais on anonymise :
On ne garde plus d'info personnelle pour les eleves dont la dernière inscription est  antérieure à " 
.$anneesuppression ."</h3>" ;

echo"<h2> on nullifie les infos personnelles de la table etudiants et on ajoute l'info 'nettoyage'+date dans le champ commentaire :</h2>"	;
	
	$query ="update etudiants set `Nom`=NULL, `Nom marital`=NULL, `Prénom 1`=NULL,
`Prénom 2` = NULL, `Prénom 3` = NULL, `Adresse annuelle` = NULL, `Ada rue 2` = NULL, `Ada rue 3` = NULL, `Ada adresse` = NULL, `Ada code BDI`= NULL, `Ada lib commune`= NULL, `Ada Num tél` = NULL,
`Num tél port` = NULL, `Email perso` = NULL,`Commentaire` = NULL,
`Ville naiss` = NULL, `Ada lib commune` = NULL, `Adresse fixe` = NULL, `Adf rue2` = NULL, `Adf rue3` = NULL, `Adf lib commune` = NULL, `Adf num tél` = NULL,
`Commentaire` = concat('nettoyage_' ,now())
WHERE `Année Univ` <'".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches étudiant anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
echo"<h2> on nullifie les infos personnelles de la table inscription_sup :</h2>"	;
	
	$query ="update inscription_sup set `Nom`=NULL, `Nom marital`=NULL, `Prénom 1`=NULL,
`Prénom 2` = NULL, `Prénom 3` = NULL, `Adresse annuelle` = NULL, `Ada rue 2` = NULL, `Ada rue 3` = NULL, `Ada adresse` = NULL, `Ada Num tél` = NULL,
`Num tél port` = NULL, `Email perso` = NULL,`Commentaire` = NULL,
`Ville naiss` = NULL, `Ada lib commune` = NULL, `Adresse fixe` = NULL, `Adf rue2` = NULL, `Adf rue3` = NULL, `Adf lib commune` = NULL, `Adf num tél` = NULL
WHERE `Année Univ` <'".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches inscription_sup anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
echo"<h2> on nullifie les infos personnelles de la table etudiants_scol  :</h2>";	
	
	$query ="update `etudiants_scol` left outer join etudiants on etudiants.`Code etu` =`etudiants_scol`.`code`
SET `etudiants_scol`.`cursus_specifique`=NULL,num_badge=NULL,date_remise_badge=NULL,caution_badge=NULL,date_retour_badge=NULL,date_demande_badge=NULL,
badge_perdu=NULL,commentaire_badge=NULL,num_secu=NULL,modifpar=NULL
WHERE etudiants.`Année Univ` <'".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches etudiants_scol  anonymisées<br>";	
echo "<br><br><br>//*****************************************//***************************************";
echo"<h2> on nullifie les infos personnelles de la table etudiants_accueil (sauf acc_login qu'on hash car index unique)  :</h2>";	
	
	$query ="update `etudiants_accueil` left outer join etudiants on etudiants.`Code etu` =etudiants_accueil.acc_code_etu
SET `etudiants_accueil`.`acc_nom`=NULL,acc_prenom=NULL,acc_login=md5(concat(acc_login,now())),acc_mail=NULL,acc_modifpar=NULL,acc_remarques=NULL
WHERE etudiants.`Année Univ` <'".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches etudiants_accueil  anonymisées<br>";		
echo "<br><br><br>//*****************************************//***************************************";
	
echo"<h2> on nullifie les infos personnelles de la table departs  :</h2>";	
	
	$query ="update `departs` left outer join etudiants on etudiants.`Code etu` =`departs`.`code_etudiant`
SET `departs`.`adr_surplace`=NULL,tel_surplace=NULL,email_permanent=NULL,decision_finale_commentaire=NULL,log_workflow=NULL,commentaire_arrivee=NULL,modifpar=NULL
WHERE etudiants.`Année Univ` < '".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches departs  anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
	
echo"<h2> on nullifie les infos personnelles de la table absences  :</h2>";	
	
	$query ="update `absences` left outer join etudiants on etudiants.`Code etu` =`absences`.`code_etud`
SET `absences`.`motif`=NULL,commentaire_absence=NULL,modifpar=NULL,absence_log=NULL
WHERE etudiants.`Année Univ` <  '".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches absences  anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
echo"<h2> on nullifie les infos personnelles de la table interculture  :</h2>";	
	
	$query ="update `interculture` left outer join etudiants on etudiants.`Code etu` =`interculture_code_etud`
SET `interculture`.`interculture_detail`=NULL,interculture_commentaire=NULL,interculture_log=NULL,interculture_description=NULL,interculture_modifpar=NULL
WHERE etudiants.`Année Univ` <  '".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches interculture  anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
	
echo"<h2> On ne garde plus que l'année à la place de la date de naissance : on force la date au 01/07 :  :</h2>";	
	
	$query ="update etudiants set `Date naiss`= concat('01/07/',right( `Date naiss`,2))
WHERE `Année Univ` <  '".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." date naissance  anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
	
echo"<h2> On ne garde plus que l'année à la place de la date de naissance dans inscription_sup :  :</h2>";	
	
	$query ="update inscription_sup set `Date naiss`= concat('01/07/',right( `Date naiss`,2))
WHERE `Année Univ` <  '".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." date naissance inscription_sup  anonymisées<br>";	
	
echo "<br><br><br>//*****************************************//***************************************";

echo"<h2> On supprime les lignes de la table annuaire correspondantes :  :</h2>";	
	
	$query ="DELETE a FROM `annuaire` a left outer join etudiants e on e.`Code etu` =a.`code-etu`
WHERE e.`Année Univ` <  '".$anneesuppression."'";
	
$result = mysql_query($query,$connexion );
echo "<br>  ".mysql_affected_rows()." fiches annuaire supprimmées <br>";	
	
echo "<br><br><br>//*****************************************//***************************************";
		
		//$anneesuppression='2022';
	
	echo"<h2>on s'occupe des photos</h2><br>";	
	$ok=0;
	$err=0;
	$req = "select  etudiants.`Code etu` as code from etudiants where  `Année Univ` <'".$anneesuppression."'";
$result = mysql_query($req,$connexion ); 
while ($r=mysql_fetch_object($result))
{
    $nomdoc=$chemin_local_images.$r->code.".jpg";
    $nomdoc2=$chemin_local_images.$r->code.".JPG";
    $nomdoc3=$chemin_local_images.$r->code.".png";	
	if (file_exists($nomdoc))
	{
   unlink($nomdoc);
   echo "<br>fichier en jpg  ".$nomdoc." supprimé<br>";
   $ok++;
      }
      elseif(file_exists($nomdoc2))
	  {
	  unlink($nomdoc2);
   echo "<br>fichier en JPG  ".$nomdoc2." supprimé<br>";
   $ok++;
	  }
      elseif(file_exists($nomdoc3))
	  {
	  unlink($nomdoc3);
   echo "<br>fichier en png  ".$nomdoc3." supprimé<br>";
   $ok++;
	  }	 
	else{	  
	  
        //echo "<br>erreur fichier  ".$nomdoc. " ".$nomdoc2. " ".$nomdoc3. " "." introuvable<br>";
	$err++;
	}
	
}
	
	echo "<br> resultat $ok photos supprimées et $err erreurs";
	
//*****************************************
echo"<h2>on s'occupe des photos téléchargées par les étudiants</h2><br>";	
	$ok=0;
	$err=0;
	$req = "select  etudiants.`Code etu` as code from etudiants where  `Année Univ` <'".$anneesuppression."'";
$result = mysql_query($req,$connexion ); 
while ($r=mysql_fetch_object($result))
{
    $nomdoc=$chemin_local_images_perso.$r->code.".jpg";
    $nomdoc2=$chemin_local_images_perso.$r->code.".JPG";
    $nomdoc3=$chemin_local_images_perso.$r->code.".png";	
	if (file_exists($nomdoc))
	{
   unlink($nomdoc);
   echo "<br>fichier en jpg  ".$nomdoc." supprimé<br>";
   $ok++;
      }
      elseif(file_exists($nomdoc2))
	  {
	  unlink($nomdoc2);
   echo "<br>fichier en JPG  ".$nomdoc2." supprimé<br>";
   $ok++;
	  }
      elseif(file_exists($nomdoc3))
	  {
	  unlink($nomdoc3);
   echo "<br>fichier en png  ".$nomdoc3." supprimé<br>";
   $ok++;
	  }	 
	else{	  
	  
        //echo "<br>erreur fichier  ".$nomdoc. " ".$nomdoc2. " ".$nomdoc3. " "." introuvable<br>";
	$err++;
	}
	
}
	
	echo "<br> resultat $ok photos supprimées et $err erreurs";
	
//*****************************************	
	echo "<br><br><br>//*****************************************//***************************************";
	echo"<h2>on s'occupe des docs absences téléchargés</h2> <br>";	
	$ok=0;
	$err=0;
	$req = "select doc_lienDoc from absences left join absencesdocuments on id_absence=doc_idAbsences left join etudiants on code_etud=`Code etu`
where doc_idDoc is not null and `Année Univ` <'".$anneesuppression."'";
$result = mysql_query($req,$connexion ); 
while ($r=mysql_fetch_object($result))
{
	$nomdoc=$chemin_local_absences.$r->doc_lienDoc;
    
	if (file_exists($nomdoc))
	{
   unlink($nomdoc);
   echo "<br>fichier  ".$nomdoc." supprimé<br>";
   $ok++;
      }
      
	else{	  
	  
      //  echo "<br>erreur fichier  ".$nomdoc. " "." introuvable<br>";
	$err++;
	}
	
}
	
	echo "<br> resultat $ok doc absences supprimés et $err erreurs :  fichiers déjà supprimés";	
	
//*****************************************
	
	echo "<br><br><br>//*****************************************//***************************************";
	echo"<h2>on s'occupe des docs eleveacteur téléchargés</h2> <br>";	
	$ok=0;
	$err=0;
	$req = "select doc_lienDoc from eleveacteur left join eleveacteurdocuments on eleveacteur_id=doc_idEleveacteur  left join etudiants on eleveacteur_code_etud=`Code etu`
where doc_idDoc is not null and `Année Univ` < '".$anneesuppression."'";
//echo $req;
$result = mysql_query($req,$connexion ); 
while ($r=mysql_fetch_object($result))
{
	$nomdoc=$chemin_local_eleve_acteur.$r->doc_lienDoc;
    
	if (file_exists($nomdoc))
	{
   unlink($nomdoc);
   echo "<br>fichier  ".$nomdoc." supprimé<br>";
   $ok++;
      }
      
	else{	  
	  
        echo "<br>erreur fichier  ".$nomdoc. " "." introuvable<br>";
	$err++;
	}
	
}
	
	echo "<br> resultat $ok doc eleve acteur supprimés et $err erreurs";		
		
//*****************************************
	//$anneesuppression='2021';
	echo "<br><br><br>//*****************************************//***************************************";
	echo"<h2>on s'occupe  des documents porte documents téléchargés</h2> <br>";	
	$ok=0;
	$err=0;
	$req = "select doc_lienDoc from portedocuments left join portedocumentsdocuments on 	id_portedocument=doc_idportedocument  left join etudiants on codeEtu=`Code etu`
where doc_idDoc is not null and `Année Univ` < '".$anneesuppression."'";
//echo $req;
$result = mysql_query($req,$connexion ); 
while ($r=mysql_fetch_object($result))
{
	$nomdoc=$chemin_local_portedocuments.$r->doc_lienDoc;
    
	if (file_exists($nomdoc))
	{
   unlink($nomdoc);
   echo "<br>fichier  ".$nomdoc." supprimé<br>";
   $ok++;
      }
      
	else{	  
	  
        echo "<br>erreur fichier  ".$nomdoc. " "." introuvable<br>";
	$err++;
	}
	
}
	
	echo "<br> resultat $ok doc portedocuments supprimés et $err erreurs";			
//*****************************************		
	echo "<br><br><br>//*****************************************//***************************************";
	echo"<h2>on supprime  les  porte documents </h2> <br>";	
	$ok=0;
	$err=0;
	$req = "DELETE a FROM `portedocuments` a left outer join etudiants e on e.`Code etu` =a.`codeEtu`
WHERE e.`Année Univ`  < '".$anneesuppression."'";
	
//echo $req;
$result = mysql_query($req,$connexion ); 	
	echo "<br>  ".mysql_affected_rows()." porte documents supprimés<br>";	
		
		
//*****************************************
	
	echo "<br><br><br>//*****************************************//***************************************";
	echo"<h2>on s'occupe des docs interculture téléchargés</h2> <br>";	
	$ok=0;
	$err=0;
	$req = "select doc_lienDoc from interculture left join interculturedocuments on interculture_id=doc_idInterculture  left join etudiants on interculture_code_etud=`Code etu`
where doc_idDoc is not null and `Année Univ` < '".$anneesuppression."'";
//echo $req;
$result = mysql_query($req,$connexion ); 
while ($r=mysql_fetch_object($result))
{
	$nomdoc=$chemin_local_interculture.$r->doc_lienDoc;
    
	if (file_exists($nomdoc))
	{
   unlink($nomdoc);
   echo "<br>fichier  ".$nomdoc." supprimé<br>";
   $ok++;
      }     
	else{	  	  
        echo "<br>erreur fichier  ".$nomdoc. " "." introuvable<br>";
	$err++;
	}
	
}
	
	echo "<br> resultat $ok doc  interculture supprimés et $err erreurs :  fichiers déjà supprimés";		
		
		
		
	}
	else{
		
	echo affichealerte ("Erreur dans la saisie de l'année 	");
	}
		
		
		
		
}









	
	
// --------------------------------------sélection de toutes les fiches et affichage
//si on n'a pas appuyé sur le bouton detail ou  kon a appuyé sur le bouton annuler de la fiche on affiche la page d'accueil et si on arrive pas de fiche.php
echo "<center style='background-color: #ffa4a4 ; text-transform: uppercase ;'>";

echo "<h1 class='titrePage2'> [ATTENTION] : OPERATION  ADMINISTRATION  </h1>"  ;

if ($login == 'administrateur' or $login =='foukan')
{
echo "<A href=".$URL."?synchro=1 >1- insc aux groupes cours depuis insc etrangers pour année <b>$annee_accueil</b>  </a><br>";
#echo "<br><br><A href=".$URL."?synchro=0 >2- Vide  </a><br>";
echo "<br><br><A href=".$URL."?synchro=3 >3- <b>peuplement des groupes scol et cours  peres depuis groupes fils</b>  </a><br>";
#echo "<br><br><A href=".$URL."?synchro=0 >4- génération des groupes depuis les fiches de cours premiere version  </a><br>";
#echo "<br><br><A href=".$URL."?synchro=5 >5- génération des fichiers export ADE 2010 </a><br>";
#echo "<br><br><A href=".$URL."?synchro=6 >6- suppression des groupes cours sans correspondance dans table cours 2012</a><br>";
#echo "<br><br><A href=".$URL."?synchro=7 >7- création des groupes cours inexistants-2012</a><br>";
echo "<br><br><A href=".$URL."?synchro=8 >8- export/affichage des cours refens </a><br>";
echo "<br><br><A href=".$URL."?synchro=9 >9- <b>peuplement auto des groupes de cours avec les groupes scol constitutifs </b> </a><br>";
#echo "<br><br><A href=".$URL."?synchro=10 >10- génération des fichiers agalan  </a><br>";
#echo "<br><br><A href=".$URL."?synchro=11 >11- récupération codes ressources ADE  2012 </a><br>";
#echo "<br><br><A href=".$URL."?synchro=12 >12- ajout des code pere ds les gpes edt 2012</a><br>";
#echo "<br><br><A href=".$URL."?synchro=13 >13- calcul et ajout des code_groupe_begi dans code_ade_groupes 2012</a><br>";
#echo "<br><br><A href=".$URL."?synchro=14 >14- remplissage  uids personnels  connexion ldap 2013</a><br>";
#echo "<br><br><A href=".$URL."?synchro=15 >15- ajout des codes ADE ds groupes par import de fichier</a><br>";
echo "<br><br><A href=".$URL."?synchro=16 >16- Peuplement du groupe tous</a><br>";
#echo "<br><br><A href=".$URL."?synchro=17 >17- récupération codes ressources ADE  2014 </a><br>";
echo "<br><br><A href=".$URL."?synchro=18 >18- synchro cours REFENS  $anneeRefens  </a><br>";
echo "<br><br><A href=".$URL."?synchro=19 >19- bascule groupes officiels ( renommage /creation du groupe archivé/déplacement des membres ) </a><br>";
echo "<br><br><A href=".$URL."?synchro=20 >20- synchro groupes enseignants de gi_users </a><br>";
echo "<br><br><A href=".$URL."?synchro=30 >30- nettoyage annuel </a><br>";
}
elseif (in_array ($login ,$scol_user_liste ) )
{
echo "<br><br><A href=".$URL."?synchro=8 >- export/affichage des cours refens</a><br>";
echo "<br><br><A href=".$URL."?synchro=3 >- peuplement des groupes scol et cours  peres depuis groupes fils   </a><br>";
echo "<br><br><A href=".$URL."?synchro=9 >- peuplement auto des groupes de cours avec les groupes scol constitutifs</a><br>";
}
if (in_array ($login ,$ri_admin_liste ))
{
echo "<br><br><A href=".$URL."?synchro=1 >1- insc aux groupes cours depuis insc etrangers pour année <b>$annee_accueil</b> </a><br>";
echo "<br><br><A href=".$URL."?synchro=8 >- export/affichage des cours refens</a>";
}
 

echo "</center>";
  if($_GET['synchro'])  {
 //---------------------------------------c'est kon a cliqué sur le lien synchroniser
 if ($login == 'administrateur' or $login =='foukan' or in_array ($login ,$scol_user_liste )){

      echo    "<form method=post action=$URL> ";
  echo"<input type='hidden' name='synchro' value='".$_GET['synchro']."'>";

   echo"<center>";
    echo"       <table><tr> ";
		if ($_GET['synchro']==30)
	{
		echo"<br>";
		echo " rentrez l'année d'inscription limite à partir de laquelle vous voulez conservez les données ";
		echo"<input type='input' name='anneesuppression'>";
		echo"<br>";
		echo " ATTENTION toutes les données personnelles des étudiants dont la dernière inscription est antérieure à cette valeurs seront anonymisées<br> ";

	}
   echo "<br><br><b>ATTENTION êtes vous sur de vouloir activer OPTION ".$_GET['synchro']."?</b>";
   echo "</td></tr><tr><th colspan=6>";
   if($_GET['synchro']==18)echo"<td><input type='Submit' name='bouton_synchro_test' value='simulation'>";
   echo" <input type='Submit' name='bouton_synchro' value='OK'><input type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";

        }
        else
        { 
   echo "<b>seul l'administrateur peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";
         }  //fin du else
        } //fin du if $_GET[synchro])

mysql_close($connexion);
  require('./footer.php') ;
echo"</body>";
echo "</html>";
?>