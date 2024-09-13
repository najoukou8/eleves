<?
// 2020 ne sert plus ??
set_time_limit(60);
require ("param.php");
require ("function.php");
// acces uniquement en ligne de commande :
if (!isset($_SERVER['PHP_AUTH_USER']))
{
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$message='';
$sql1='';
$filtreok='';
$table="etudiants_scol";

//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="etudiants_scol";
$champs=champsfromtable($tabletemp);
$tabletemp="ext_ia_";
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
//--------------------------------- synchro des fichiers etudiants et etudiants_scol  permet de gèrer les doubles inscriptions
echo"synchro en cours ...";
$supscol=0;
$suplignegpe=0;
//on parcourt la table  etudiants
$sqlquery="SELECT * FROM ext_ia_  ";
$resultat=   mysql_query($sqlquery,$connexion ); 
echo "il y a ".mysql_num_rows( $resultat)." fiches à traiter \n ";
$existe=0;
$existepas=0;
$cree=0;
$cree3=0;
$cree4=0;
while ($e=mysql_fetch_object($resultat)){

   //pour chaque code etudiant on verifie si la fiche scol associee existe
     $query = "SELECT * FROM $table where code= '".$e->$myext_ia_code_etu ."' order by code";
    $result = mysql_query($query,$connexion ); 
   //   si elle existe  pas
	if (mysql_num_rows( $result)==0)
	{
	// on ne fait rien
	 $existepas++;
	 echo "L etudiant ".$e->$myext_ia_code_etu." n'a pas une fiche de scol \n "; 
	 }
      else 
	  {
			 
	

			   // et on indique l'etape ds le gpe principal
			   //il faut determiner l'annee à partir du code etape
	           $cod_etape = $e->$myext_ia_code_étape;
// Modif Marc 22-10-2010
	           $cod_vet = $e->$myext_ia_code_vet;

	           $annee_etp = $e->$myext_ia_nb_inscr_etp;

// Modif Marc 22-10-2010
				   $lib_etape=$cod_etape.$cod_vet;				
				   
				   // il faut mettre l'étudiant dans le groupe de son etape
				   // on vérifie d'abord que le groupe de cette etape existe
echo "vet : ".$e->$myext_ia_code_vet." voila \n";
	$query7="SELECT * FROM groupes where code_etape='".$lib_etape."'  ;";
					$resultat7=mysql_query($query7,$connexion );
					if(mysql_num_rows($resultat7)!=0)
					{
					// si oui on verifie si l'etudiant n'y est pas déjà
					while ($f=mysql_fetch_object($resultat7))
						{
						$query4="select *  from  ligne_groupe where code_groupe='".$f->code ."' and code_etudiant='".$e->$myext_ia_code_etu."'";
					$result4=mysql_query($query4,$connexion ); 
						if(mysql_num_rows($result4)==0)											
							// si non on ajoute l'etudiant dans ce groupe
							{
							$query8="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
							VALUES ('".$f->code."','".$e->$myext_ia_code_etu."','apo',now())";
							echo "on ajoute l'etudiant dans le groupe: ".$query8."\n ";
							$result8=mysql_query($query8,$connexion ); 
								if ($result8){
								echo "<center><b>La fiche est enregistrée</b> </center>";
								$cree++;}
								else {
								echo affichealerte("erreur de saisie ")." : ". mysql_error();
								echo "<center>La fiche n'est pas enregistrée</b> </center>";
								}							
							}
							else
							//si oui on ne fait  rien	
							{
							echo "L etudiant ".$e->$myext_ia_code_etu." est déjà dans ce groupe ".$f->code."\n ";
							}
						}// fin du while
					}// fin du if
					else
					{
						// si non on crée le groupe
 						$query9="insert into groupes (libelle,type_gpe_auto,visible,groupe_officiel,code_etape,login_proprietaire,archive,groupe_a_stage,groupe_enseignants) VALUES ('".$e->$myext_ia_composante."-".$lib_etape."','apo','oui','oui','".$lib_etape."','administrateur','non','non','non')";
						echo "creation du groupe ".$query9."\n ";
						$result9=mysql_query($query9,$connexion );
						echo  afficheresultatsql($result9,$connexion);
						echo"\n ";
						// il  nous faut récupérer le code groupe qui vient d'être créé						
						$sqlquery="SELECT     MAX(code) AS Expr1 FROM  groupes ";
						$resulmax=mysql_query($sqlquery,$connexion ); 
						$h=mysql_fetch_object($resulmax);
						$max = $h->Expr1;
						// et on ajoute l'étudiant dedans 													
							$query10="insert into ligne_groupe (code_groupe,code_etudiant,type_inscription,date_modif) 
							VALUES ('".$max."','".$e->$myext_ia_code_etu."','apo',now())";
							echo $query10."\n ";
							$result10=mysql_query($query10,$connexion ); 
								if ($result10){
								echo "<center>La fiche est enregistrée apres creation du gpe</b> </center>";
								$cree++;}
								else {
								echo affichealerte("erreur de saisie ")." : ". mysql_error();
								echo "<center>La fiche n'est pas enregistrée</b> </center>";
								}// fin du else												
					}
							

			}
      }
      
      echo "\n resultat ".$cree ." fiches de scol on été créées\n ";
	        echo "\n resultat ".$cree3 ." etudiants ont été ajoutés au groupe import_apogee\n ";
			echo "\n resultat ".$cree4 ." information(s) : import apogee + code etape ont été ajoutés car gpe principal vide \n ";
       echo $existe." fiches existaient déjà\n ";
       echo $supscol." fiches orphelines de scolarité ont été supprimées\n ";
               //   on met à jour la date et l'heure dans la table param
        echo "\n et on met à jour la date et l'heure dans la table param \n ";
        $query = "UPDATE param SET date_import_apo=now() WHERE config='1'";
        $result = mysql_query($query, $connexion);

mysql_close($connexion);
}
else echo "accès interdit";
?>
