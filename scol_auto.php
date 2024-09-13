<?
set_time_limit(60);
require ("param.php");
require ("function.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$message='';
$sql1='';
$filtreok='';

//on remplit 2 tableaux avec les nom-code  groupes
$sqlquery2="SELECT groupes.* FROM groupes ";
//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2))
	{

	$ind2=$v["code"];
	$groupe_libelle[$ind2]=$v["libelle"];
	// $groupe_proprio[$ind2]=$v["login_proprietaire"];
	// $groupe_offi[$ind2]=$v["groupe_officiel"];
	// $groupe_liste[$ind2]=$v["liste_offi"];
	// $groupe_nomliste[$ind2]=$v["nom_liste"];
	// $groupe_titre_affiche[$ind2]=$v["titre_affiche"];
	// $groupe_titre_special[$ind2]=$v["titre_special"];
	// $groupe_code_ade[$ind2]=$v["code_ade"];
	// $groupe_code_ade6[$ind2]=$v["code_ade6"];	
	// $groupe_cours_complet[$ind2]=$v["groupe_cours_complet"];
	// $groupe_type_auto[$ind2]=$v["type_gpe_auto"];
	// $groupe_const[$ind2]=$v["libelle_gpe_constitutif"];
	// $groupe_clone[$ind2]=$v["recopie_gpe_officiel"];	
	// $groupe_etudconst[$ind2]=$v["gpe_etud_constitutif"];
	// $groupe_arbre[$ind2]=$v["arbre_gpe"];
	// $groupe_code[$ind]=$v["code"];
	$groupe_principal[$ind2]=$v["groupe_principal"];
	//$groupe_archive[$ind2]=$v["archive"];	
	}



$table="etudiants_scol";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="etudiants_scol";
$champs=champsfromtable($tabletemp);
$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
//on remplit 2 tableau avec les nom-code  etudiants
$sqlquery2="SELECT * FROM etudiants  order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
//on remplit un tableau indice avec les noms etudiants
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Prénom 1"];
}
$liste_champs_dates=array('date_diplome','date_demande_badge','date_remise_badge','date_retour_badge' );
//--------------------------------- synchro des fichiers etudiants et etudiants_scol 
echo"synchro en cours ...";
$supscol=0;
$suplignegpe=0;
//on parcourt la table  etudiants
$sqlquery="SELECT * FROM etudiants  ";
$resultat=   mysql_query($sqlquery,$connexion ); 
echo "il y a ".mysql_num_rows( $resultat)." fiches à traiter \n";
$existe=0;
$cree=0;
$cree3=0;
$cree4=0;
$cree5=0;
$cree6=0;
$cree7=0;
$cree8=0;
$cree9=0;
$cree10=0;
$cree11=0;
$creetous=0;

 // on vide les lignes de TOUSGI
 echo "<br>on efface les anciens membres du groupe tous les inscrits <br>";
 $query6="DELETE FROM ligne_groupe   where code_groupe='".$code_gpe_tous_inscrits."'";
$resultat6=mysql_query($query6,$connexion );
echo mysql_affected_rows($connexion) ." fiches effacées";

while ($e=mysql_fetch_object($resultat)){
	
	// on vérifie l'annee d'inscription pour savoir si on le met dans TOUSGI de l'année
	//2020 on ne prend plus les IMT ( même si ils existent dans etudiants pour l'année en cours : suppression de l'alimentation après la rentrée)
	if($e->$myetudiantsannée_univ==($annee_courante-1) and $e->$myetudiantscode_dip !='XINGIMT'  )
		
		{
					// on le met dans le groupe TOUS GI année						
						$query4 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif)
						VALUES('".$code_gpe_tous_inscrits."','". $e->$myetudiantscode_etu ."','tous',now())";
						//echo $query4."<br>";
						$result4 = mysql_query($query4,$connexion );
						$creetous++;									
			
		}
	
	

   //pour chaque code etudiant on verifie si la fiche scol associee existe
     $query = "SELECT * FROM $table where code= '".$e->$myetudiantscode_etu ."' order by code";
    $result = mysql_query($query,$connexion ); 
   //   si elle existe 
	if (mysql_num_rows( $result)!=0)
	{
	// on ne fait rien
	 $existe++;
	 //echo "L etudiant ".$e->$myetudiantscode_etu." a déjà une fiche de scol <br>\n "; 
	 }
	 // sinon c'est un nouveau :
      else 
	  {
			 //sinon on la crée
			 $query2 = "INSERT INTO $table(code) VALUES('".$e->$myetudiantscode_etu."')";
             $result2 = mysql_query($query2,$connexion);
             $cree++;

		   // on les mets dans le groupe spécial import apogee,  si ils n'y sont pas déjà 			
			//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
			$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_imp_apo."' and code_etudiant='".$e->$myetudiantscode_etu."'";
			$result4=mysql_query($query4,$connexion ); 
			if (mysql_num_rows($result4)==0)
				{
					$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
					VALUES('".$code_gpe_imp_apo."','".$e->$myetudiantscode_etu."','imp',now())";
				   //echo $query3;
				   $result3 = mysql_query($query3,$connexion);
				   	$cree3++;				
								   // et on indique l'etape ds le gpe principal			
				   $query5="update $table set annee='import-apogee ".$e->$myetudiantscode_étape."-".$e->$myetudiantsdate_iae."' where code ='".$e->$myetudiantscode_etu."'";
				   //echo $query5 ."\n ";
				   $result5 = mysql_query($query5,$connexion);
				   $cree4++;


				}
			else
				{
				echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe import apogee <br>\n ";
						echo "\n ";
				}
		   // on les mets dans le groupe spécial TOUS,  si ils n'y sont pas déjà 			
			//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
			$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_tous."' and code_etudiant='".$e->$myetudiantscode_etu."'";
			$result4=mysql_query($query4,$connexion ); 
			if (mysql_num_rows($result4)==0)
				{
					$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif)  
					VALUES('".$code_gpe_tous."','".$e->$myetudiantscode_etu."','imp',now())";
				   //echo $query3;
				   $result3 = mysql_query($query3,$connexion);
				}
			else
				{
				echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe  tous <br>\n ";
						echo "\n ";
				}
	// on regarde	si on doit inscrire automatiqmement les 		
			if($inscAutoGpe1A)					
			{	
				//____________________________ idem pour les 1A IPID dans le groupe 1A	IPID			
				// on vérifie si il est inscrit en 1A IPID
				if ( $e->$myetudiantscode_étape==$code_etape_1A_IPID)
				{
				// si oui on le met dans le groupe désigné pour les 1A	IPID	
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_1A_IPID."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_gpe_1A_IPID."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree6++;				

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel 1A IPID<br>\n ";
							echo "\n ";
					}
				
                   //et dans le groupe désigné pour les 1A		
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_1A."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_gpe_1A."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree5++;				

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel 1A  <br> \n ";
							echo "\n ";
					}				
				
				}
				// ________________________idem pour les 1A ETUDIANTS dans le groupe 1A	ETUDIANTS			
				// on vérifie si il est inscrit en 1A ETUDIANTS
				if ( $e->$myetudiantscode_étape==$code_etape_1A_ETUDIANTS)
				{
				// si oui on le met dans le groupe désigné pour les 1A	ETUDIANTS	
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_1A_ETUDIANTS."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_gpe_1A_ETUDIANTS."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree7++;				

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel 1A ETUDIANTS <br>\n ";
							echo "\n ";
					}
                   //et dans le groupe désigné pour les 1A		
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_1A."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_gpe_1A."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree5++;				

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel 1A  <br> \n ";
							echo "\n ";
					}											
				}
				// ________________________idem pour les ETUDIANTS_ETRANGERS dans le groupe ETUDIANTS_ETRANGERS			
				// on vérifie si il est inscrit en ETUDIANTS_ETRANGERS
				if ( $e->$myetudiantscode_étape==$code_etape_ETUDIANTS_ETRANGERS)
				{
				// si oui on le met dans le groupe désigné pour les ETUDIANTS_ETRANGERS
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_groupe_ETUDIANTS_ETRANGERS."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_groupe_ETUDIANTS_ETRANGERS."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree8++;		
						// si ce groupe est un groupe principal on l'indique dans la fiche scol 
						if($groupe_principal[$code_groupe_ETUDIANTS_ETRANGERS]=='oui')	
						{					
						   $query5="update $table set annee='".$groupe_libelle[$code_groupe_ETUDIANTS_ETRANGERS]."' where code ='".$e->$myetudiantscode_etu."'";
						   //echo $query5 ."\n ";
						   $result5 = mysql_query($query5,$connexion);
						}
						

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel ETUDIANTS_ETRANGERS <br>\n ";
							echo "\n ";
					}								
				}
	// ________________________idem pour les MASTER 1A dans le groupe MASTER1_SIE			
				// on vérifie si il est inscrit en MASTER1_SIE
				if ( $e->$myetudiantscode_étape==$code_etape_MASTER1_SIE)
				{
				// si oui on le met dans le groupe désigné pour les MASTER1_SIE
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_groupe_MASTER1_SIE."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_groupe_MASTER1_SIE."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree9++;		
						// si ce groupe est un groupe principal on l'indique dans la fiche scol 
						if($groupe_principal[$code_groupe_MASTER1_SIE]=='oui')	
						{					
						   $query5="update $table set annee='".$groupe_libelle[$code_groupe_MASTER1_SIE]."' where code ='".$e->$myetudiantscode_etu."'";
						   //echo $query5 ."\n ";
						   $result5 = mysql_query($query5,$connexion);
						}
						

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel MASTER1_SIE <br>\n ";
							echo "\n ";
					}								
				}
/* 				// ________________________idem pour les MASTER1_GI dans le groupe MASTER1_GI			
				// on vérifie si il est inscrit en MASTER1_GI
				if ( $e->$myetudiantscode_étape==$code_etape_MASTER1_GI)
				{
				// si oui on le met dans le groupe désigné pour les MASTER1_GI
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_groupe_MASTER1_GI."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_groupe_MASTER1_GI."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree10++;		
						// si ce groupe est un groupe principal on l'indique dans la fiche scol 
						if($groupe_principal[$code_groupe_MASTER1_GI]=='oui')	
						{					
						   $query5="update $table set annee='".$groupe_libelle[$code_groupe_MASTER1_GI]."' where code ='".$e->$myetudiantscode_etu."'";
						   //echo $query5 ."\n ";
						   $result5 = mysql_query($query5,$connexion);
						}
						

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel MASTER1_GI <br>\n ";
							echo "\n ";
					}								
				}	 */
				
				// ________________________idem pour les 2A ENSE3 dans le groupe 2A_ENSE3		
				// on vérifie si il est inscrit en 2A_ENSE3
				if ( $e->$myetudiantscode_étape==$code_etape_2A_ENSE3)
				{
				// si oui on le met dans le groupe désigné pour les 2A_ENSE3
							//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
				$query4="select *  from  ligne_groupe where code_groupe='".$code_groupe_2A_ENSE3."' and code_etudiant='".$e->$myetudiantscode_etu."'";
				$result4=mysql_query($query4,$connexion ); 
				if (mysql_num_rows($result4)==0)
					{
						$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
						VALUES('".$code_groupe_2A_ENSE3."','".$e->$myetudiantscode_etu."','imp',now())";
					   //echo $query3;
					   $result3 = mysql_query($query3,$connexion);
						$cree11++;		
						// si ce groupe est un groupe principal on l'indique dans la fiche scol 
						if($groupe_principal[$code_groupe_2A_ENSE3]=='oui')	
						{					
						   $query5="update $table set annee='".$groupe_libelle[$code_groupe_2A_ENSE3]."' where code ='".$e->$myetudiantscode_etu."'";
						   //echo $query5 ."\n ";
						   $result5 = mysql_query($query5,$connexion);
						}
						

					}
				else
					{
					echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe officiel 2A_ENSE3 <br>\n ";
							echo "\n ";
					}								
				}					
			}
			else
			{
				echo "On n'inscrit pas (plus) automatiquement  les 1A dans leurs groupes  <br> \n ";
			}
				
		}					
}
            echo "\n resultat ".$creetous ." étudiants ont été ajoutés au groupe TOUS_INSCRITS " .($annee_courante-1)."-". $annee_courante."<br>\n ";
      echo "\n resultat ".$cree ." fiches de scol on été créées<br>\n ";
	        echo "\n resultat ".$cree3 ." etudiants ont été ajoutés au groupe import_apogee<br>\n ";
			echo "\n resultat ".$cree4 ." information(s) : import apogee + code etape ont été ajoutés car gpe principal vide <br>\n ";

			echo "\n resultat ".$cree6 ." ajout dans  gpe officiel 1A IPID <br>\n ";	
			echo "\n resultat ".$cree7 ." ajout dans  gpe officiel 1A ETUDIANTS <br>\n ";	
			echo "\n resultat ".$cree5 ." ajout dans  gpe officiel 1A  <br>\n ";	
			echo "\n resultat ".$cree8 ." ajout dans  gpe officiel ETUDIANTS ETRANGERS  <br>\n ";	
			echo "\n resultat ".$cree9 ." ajout dans  gpe officiel MASTER1_SIE  <br>\n ";	
			echo "\n resultat ".$cree10 ." ajout dans  gpe officiel MASTER1_GI  <br>\n ";		
			echo "\n resultat ".$cree11 ." ajout dans  gpe officiel 2A_ENSE3  <br>\n ";			
       echo $existe." fiches existaient déjà<br>\n ";
       echo $supscol." fiches orphelines de scolarité ont été supprimées<br>\n ";
               //   on met à jour la date et l'heure dans la table param
        echo "\n et on met à jour la date et l'heure dans la table param <br>\n";
        $query = "UPDATE param SET date_import_apo=now() WHERE config='1'";
        $result = mysql_query($query, $connexion);

mysql_close($connexion);
?>