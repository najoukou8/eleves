<?php

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

set_time_limit(60);
require ("style.php");
require ("param.php");
require ("function.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);


if (!isset($_GET['inverse'])) $_GET['inverse']='';
if (!isset($_GET['orderby'])) $_GET['orderby']='';
if (!isset($_POST['bouton_synchro'])) $_POST['bouton_synchro']='';
if (!isset($_POST['bouton_synchro2'])) $_POST['bouton_synchro2']='';
if (!isset($_POST['bouton_synchro1'])) $_POST['bouton_synchro1']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['synchro'])) $_GET['synchro']='';
if (!isset($_GET['synchro2'])) $_GET['synchro2']='';
if (!isset($_GET['synchro1'])) $_GET['synchro1']='';
if (!isset($_GET['import_annu'])) $_GET['import_annu']='';
$self=$_SERVER['PHP_SELF'];
$sql1='';
$sql2='';
$date = date("d-m-Y");
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

//--------------------------------- génération des fichiers  AGALAN

	echo"génération des fichiers  AGALAN <br>";
	$cree=0;
	$err=0;
	$creepop=0;
	$repfichier="/var/www/html/eleves/begi2agalan/";
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
				$Finf = $repfichier."begi1.inf"; 
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
									
									//2014
									//$Fpoptot = $repfichier.$oldue.$oldibelcourt."-Groupe_Tous".".pop"; 									
									$Fpoptot = $repfichier.$oldue."-Groupe_Tous".".pop"; 
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
									// 2014
									//$gpedegpe.=",inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."-Groupe_Tous"; 									
									$gpedegpe.=",inpg-Ecole_GI-Cours_".$oldue."-Groupe_Tous"; 
									fclose($inFpoptot);

									// on efface le tableau membre_ue
									$membre_ue=array();
									// on ecrit une ligne ds le inf
									//2014
									//$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."-Groupe_Tous".";Groupe Tous base eleve ".$date.";C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$oldue.$oldibelcourt."-Groupe_Tous".".pop";
									$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$oldue."-Groupe_Tous".";Groupe Tous base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$oldue."-Groupe_Tous".".pop";									
									fwrite($inFinf,$ligneinf."\r\n");
									$cree++;
									$oldue=$libellebrut;
									$oldibelcourt=$libellecourt;
									}
									else
									{// sinon  on ne fait rien 
									}
					
				echo "<br>".$libellebrut."<br>";
				//2014
				//$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$libellebrut.$libellecourt."-Groupe_".$libellegpe.";Groupe base eleves ".$date.";C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$libellebrut.$libellecourt."-Groupe_".$libellegpe.".pop";
				$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$libellebrut."-Groupe_".$libellegpe.";Groupe base eleves;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$libellebrut."-Groupe_".$libellegpe.".pop";				
				fwrite($inFinf,$ligneinf."\r\n");
				$cree++;
				// on cree le fichier pop correpondant
				$Fpop = $repfichier.$libellebrut."-Groupe_".$libellegpe.".pop"; 
				$inFpop = fopen($Fpop,"w"); 
				// on va récupérer les membres de ce gpe   ds ligne gpe						
						$query2 = " SELECT `Code etu` as code_etu FROM `ligne_groupe` 
						left outer join etudiants on upper(ligne_groupe.`code_etudiant`)=etudiants.`Code etu`
						where  code_groupe='".$code_groupe_cours."'  and ( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui')";
				//2020 il ne faut pas prendre les etudiants  qui ne sont plus dans triode	pour celà on peut regarder la dernière date de maj et on  applique une sécurité de 10j
				// mais c'est peut être dangereux si date_maj n'est plus inscrite correctement et qu'on ne s'en aperçoit pas on peut ne plus rien exporter...
/* 						$query2 = " SELECT `Code etu` as code_etu,annuaire.date_maj FROM `ligne_groupe` 
						left outer join etudiants on upper(ligne_groupe.`code_etudiant`)=etudiants.`Code etu`
						left outer join annuaire on upper(ligne_groupe.`code_etudiant`)=annuaire.`code-etu`						
						where  code_groupe='".$code_groupe_cours."'  and ( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui')
						and date_maj > DATE_SUB(CURDATE(), INTERVAL 10 DAY)";	 */			
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
													// correction 2014 on n'indique plus le libellé
									//$Fpoptot = $repfichier.$oldue.$oldibelcourt."-Groupe_Tous".".pop"; 
									$Fpoptot = $repfichier.$oldue."-Groupe_Tous".".pop"; 
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
									// correction 2014 on n'indique plus le libellé
									//$gpedegpe.=",inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."-Groupe_Tous"; 
									$gpedegpe.=",inpg-Ecole_GI-Cours_".$oldue."-Groupe_Tous"; 									
									fclose($inFpoptot);
									// on efface le tableau membre_ue
									$membre_ue=array();
									// on ecrit une ligne ds le inf
									//$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$oldue.$oldibelcourt."-Groupe_Tous".";Groupe Tous base eleve ".$date.";C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$oldue.$oldibelcourt."-Groupe_Tous".".pop";

									// correction 2014 on n'indique plus le libellé
									$ligneinf="inpg;INPG;inpg-Ecole_GI-Cours_".$oldue."-Groupe_Tous".";Groupe Tous base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$oldue."-Groupe_Tous".".pop";
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
				echo "<br>-------------fin du fichier inf2---------------<br>";				
				fclose($inFinf);	
				// on cree le troisième inf pour generer les groupes officiels  : 
				$Finf = $repfichier."begi3.inf"; 
				$query = "SELECT * FROM `groupes` where groupe_officiel='oui' and archive !='oui' and type_gpe_auto !='scol' and type_gpe_auto !='edt'";
				$result = mysql_query($query,$connexion ); 
				$nombre= mysql_num_rows($result);
				while ($v=mysql_fetch_array($result))	
					{
					$tab_groupes_promo[]=$v["libelle"];
					$tab_groupes_promo_code[]=$v["code"];
					}	

				// $tab_groupes_promo[]="inpg-Ecole_GI-Promo_1A";
				// $tab_groupes_promo[]="inpg-Ecole_GI-Promo_2A";
				// $tab_groupes_promo[]="inpg-Ecole_GI-Promo_2AICL";
				// $tab_groupes_promo[]="inpg-Ecole_GI-Promo_2AIDP";			
	
				// $tab_groupes_promo_code[]="1096";
				// $tab_groupes_promo_code[]="1095";
				// $tab_groupes_promo_code[]="1092";
				// $tab_groupes_promo_code[]="1093";				
			

				$inFinf = fopen($Finf,"w"); 
					$ligneinf="#v1-0";
					fwrite($inFinf,$ligneinf."\r\n");
				foreach($tab_groupes_promo as $groupe_promo)
				{	
				$nomgpe="inpg-Ecole_GI-groupeoffi_".rewrite($groupe_promo);
				$ligneinf="inpg;INPG;".$nomgpe.";Groupe annee base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$nomgpe.".pop";
				fwrite($inFinf,$ligneinf."\r\n");
				}		
				echo "<br>-------------fin du fichier inf-3--------------<br>";				
				fclose($inFinf);	
$creepromo=0;
				// on cree les pop correspondants
				for($i=0;$i<sizeof($tab_groupes_promo_code);$i++)
				{	
				$nomgpe="inpg-Ecole_GI-groupeoffi_".rewrite($tab_groupes_promo[$i]);
				$Fpopgpe = $repfichier.$nomgpe.".pop"; 
				$inFpopgpe = fopen($Fpopgpe,"w"); 
				// on va récupérer les membres de ce gpe   ds ligne gpe						
						$query2 = " SELECT `Code etu` as code_etu FROM `ligne_groupe` 
						left outer join etudiants on upper(ligne_groupe.`code_etudiant`)=etudiants.`Code etu`
						where  code_groupe='".$tab_groupes_promo_code[$i]."' ";
						//echo $query2;
						echo "<br>";
						$result2 = mysql_query($query2,$connexion ); 
								while($s=mysql_fetch_object($result2))
								{
								$temp=$s->code_etu;
								// on recupere lesligne gpes correspondantes
								$lignepop = "inpg;;;;;;inpg_apo-".$temp;
								fwrite($inFpopgpe,$lignepop."\r\n");
								echo " pour ".$tab_groupes_promo[$i]." on inscrit inpg_apo-".$temp ." <br>";													
								}
								fclose($inFpopgpe);
				$creepromo++;
				echo "<br>-------------fin du fichier pop--------------<br>";						
				}	
				// on cree le quatrième inf pour generer les groupes de personnels  : 
				$Finf = $repfichier."begi4.inf"; 
/* 				$query = "SELECT * FROM `groupes` where groupe_officiel='oui' and archive !='oui' and type_gpe_auto !='scol' and type_gpe_auto !='edt'";
				$result = mysql_query($query,$connexion ); 
				$nombre= mysql_num_rows($result);
				while ($v=mysql_fetch_array($result))	
					{
					$tab_groupes_promo[]=$v["libelle"];
					$tab_groupes_promo_code[]=$v["code"];
					} */	

				$tab_groupes_personnels[]="responsablescourstous";
				$tab_groupes_personnels[]="responsablescours1aipid";
				$tab_groupes_personnels[]="responsablescours2aidp";
				$tab_groupes_personnels[]="responsablescours3a";			
				$tab_groupes_personnels[]="responsablescoursm2gi";
				$tab_groupes_personnels[]="responsablescoursm1sie";
				$tab_groupes_personnels[]="responsablescours1agen";
				$tab_groupes_personnels[]="responsablescours2aicl";
				$tab_groupes_personnels[]="responsablescoursm2sie";
				$tab_groupes_personnels[]="responsablescours2aipid";
				
				 $tab_groupes_personnels_code[]="7";
				$tab_groupes_personnels_code[]="8";
				$tab_groupes_personnels_code[]="9";
				$tab_groupes_personnels_code[]="10";				
				$tab_groupes_personnels_code[]="11";	
				$tab_groupes_personnels_code[]="12";	
				$tab_groupes_personnels_code[]="13";	
				$tab_groupes_personnels_code[]="14";	
				$tab_groupes_personnels_code[]="15";
				$tab_groupes_personnels_code[]="26";			

				$inFinf = fopen($Finf,"w"); 
					$ligneinf="#v1-0";
					fwrite($inFinf,$ligneinf."\r\n");
				foreach($tab_groupes_personnels as $groupe_personnels)
				{	
				$nomgpe="inpg-Ecole_GI-groupeens_".rewrite($groupe_personnels);
				$ligneinf="inpg;INPG;".$nomgpe.";Groupe enseignants base eleve;C;;uid=ensgia,ou=people,ou=inpg,dc=agalan,dc=org;cn=inpg-GI-groupe-administrateurs,ou=groupes,ou=inpg,dc=agalan,dc=org;".$nomgpe.".pop";
				fwrite($inFinf,$ligneinf."\r\n");
				}		
				echo "<br>-------------fin du fichier inf-4--------------<br>";				
				fclose($inFinf);	
				$creepersonnels=0;
				$dsn_users="gi_users";
				$user_sql_users="apache";
				$password_users='Bmanpj1';
				$host_users="localhost";
				$connexion_users =Connexion($user_sql_users, $password_users, $dsn_users, $host_users);
				// on cree les pop correspondants
				for($i=0;$i<sizeof($tab_groupes_personnels_code);$i++)
				{	
				$nomgpe="inpg-Ecole_GI-groupeens_".rewrite($tab_groupes_personnels[$i]);
				$Fpopgpe = $repfichier.$nomgpe.".pop"; 
				$inFpopgpe = fopen($Fpopgpe,"w"); 
				// on va récupérer les membres de ce gpe   ds ligne gpe						
						$query2 = " SELECT people_id FROM `lignes_groupes` 						
						where  groupe_id='".$tab_groupes_personnels_code[$i]."' ";
						//echo $query2;
						echo "<br>";
						$result2 = mysql_query($query2,$connexion_users ); 
								while($s=mysql_fetch_object($result2))
								{
								$temp=$s->people_id;
								// on recupere lesligne gpes correspondantes
								$lignepop = "inpg;;;;;;;;;;;;;;;;;;;;;;".$temp;
								fwrite($inFpopgpe,$lignepop."\r\n");
								echo " pour ".$tab_groupes_personnels[$i]." on inscrit ".$temp ." <br>";													
								}
								fclose($inFpopgpe);
				$creepersonnels++;
				echo "<br>-------------fin du fichier pop--------------<br>";						
				}							
	echo "<br> ------------FIN DU TRAITEMENT------------------<br>";
	echo "$cree groupes créés-----<br>";
		echo "$creepop groupes tot créés-----<br>";
			echo "$creepromo groupes officiels créés-----<br>";
						echo "$creepersonnels groupes enseignants créés-----<br>";
		//echo "$err cas de fiches de groupe constitutif qui n existent pas-----<br>";


mysql_close($connexion);
?>