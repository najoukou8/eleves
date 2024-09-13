<?
set_time_limit(120);
require ("style.php");
require ("param.php");
require ("function.php");

echo  "<center><a href='default.php'>Revenir à l'accueil</a></center>";
if(in_array($login ,$scol_user_liste) or in_array($login ,$power_user_liste))
{
	// qui a le droit ?
	echo affichealerte ("Vérification de la cohérence entre Triode et la base élèves ");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);


if (!isset($_GET['inverse'])) $_GET['inverse']='';
if (!isset($_GET['orderby'])) $_GET['orderby']='';
if (!isset($_POST['bouton_synchro'])) $_POST['bouton_synchro']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['synchro'])) $_GET['synchro']='';
if (!isset($_GET['import_annu'])) $_GET['import_annu']='';
if (!isset($_GET['affiche'])) $_GET['affiche']='';
$self=$_SERVER['PHP_SELF'];
$sql1='';
$sql2='';
$URL =$_SERVER['PHP_SELF'];
$table="annuaire";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="annuaire";
$champs=champsfromtable($tabletemp);

foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
//echo $ci2;
}
$idetablissement='Id. Établ.';
$tabletemp="etudiants";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

 //--------------------------------- import dans  annu 
   

$cree=0;
$erreur=0;
$absent=0;
$absent2=0;
$supp=0;
$new=0;


// ici on se connecte à l'annuaire et on récupère le groupe
	$server = "frontalannuaire2.inpg.fr";
	$port = "389"  ;
	$racine = "ou=inpg,dc=agalan,dc=org";
	# c'est un compte spécial qui ne sert qu'à ça et qui n'a pas de droits spéciaux
	#$rootdn="uid=radiusa,ou=people,ou=inpg,dc=agalan, dc=org";
	#$rootpw="q4Gv5Q9a";
	#$rootdn="uid=ensgia,ou=people,ou=inpg,dc=agalan, dc=org";
	#$rootpw="442Qj2gt";	
	$rootdn="uid=standarl,ou=people,ou=inpg,dc=agalan, dc=org";
	$rootpw="Cg3eB7Zw";	
	$ds = ldap_connect($server);
	$testconnect = ldap_bind($ds,$rootdn,$rootpw);
	if ($testconnect) 
		{
		$dn =   "OU=groupes,ou=inpg,dc=agalan,dc=org";
		$filtre = "(&(".$groupe_annuaire_etudiants."))";		
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		echo"<br>\n on récupère les membres de  $groupe_annuaire_etudiants...<br>\n ";
		$info = ldap_get_entries($ds,$sr);
		// on initialise le tableau
		$membres_gpe_annu=array();
		$membres_gpe_annu_uid=array();		
// boucle en cas d'attrib multi evalues
for ( $j=0; $j<sizeof( $info[0]['member'])-1 ; $j++ )
			{
				//on remplit le tableau avec les UIDs
				$uidandco=explode(',',$info[0]['member'][$j]);
				// attention il faut exclure le fake member
				if($uidandco[0]!='cn=Agalan groups fake member')
					{
						$membres_gpe_annu[]= $uidandco[0];
						$uid=explode('=',$uidandco[0]);
						$membres_gpe_annu_uid[]= $uid[1];
					}
			//echo $uidandco[0];
			//echo "<br>\n ";
			}
		// maintenant on parcourt le tableau et pour chaque uid on récupère les attributs qui nous intéressent
		$dn =   "OU=people,ou=inpg,dc=agalan,dc=org";
		$attrib=array('sn','givenname','aglnpersonstatus');
			echo"<br>\n on a récupéré ".sizeof($membres_gpe_annu)." membres dans $groupe_annuaire_etudiants.<br>\n ";
		$valeurs=array();
		
		
		echo "<table border=1>";
		
		
		for ( $i=0; $i<sizeof($membres_gpe_annu) ; $i++ )
		{

			$valeur='';
			$filtre = "(&(".$membres_gpe_annu[$i]."))";
		$sr =ldap_search($ds,$dn,$filtre);
				$nombre = ldap_count_entries($ds,$sr);
				
		$info = ldap_get_entries($ds,$sr);
		$sql='';
		//echo print_r($info);
								$valeur='';
		   for ( $k=0; $k<sizeof($attrib) ; $k++ )
		   {
				$temp=strtolower($attrib[$k]);
				if (array_key_exists($temp,$info[0]))
				{
								//echo "Pour l' etudiant ".$info[0]['uid'][0]." l'attribut $temp est OK <br>\n ";
			//pour les attrib multi evalues

						for ($z=0;$z<$info[0][$temp]["count"];$z++)
						{
						$valeur.= $info[0][$temp][$z]." , ";
						}
				}
				else		
				{
								echo "<tr>";
						echo "<td bgcolor = 'yellow'>";				
				echo "Pour l' etudiant ".$info[0]['uid'][0]." il manque l'attribut $temp <br>\n ";
						echo "</td>";
							echo "</tr>";
				#correction marc 20/09/2011
				$valeur=',';
				#fin correction marc 20/09/2011
				}
				
				// traitement des conversion nécessaire :
				//dates		
				
				// pour le decodage utf8 des noms et prenoms
				if ($attrib[$k]=='givenname' or  $attrib[$k]=='sn' or $attrib[$k]=='aglnpatronymicname'  )
				{
				$valeur=utf8_decode($valeur);
				}
				//pb des ' à doubler
				
				
			}

			//$valeurs[]=$valeur;
			//$uid=explode('=',$membres_gpe_annu[$i]);
	// on vérifie chaque membre du gpe ldap si il existe dans la base élève
	   $query="SELECT Uid FROM etudiants left join annuaire  on annuaire.`code-etu`=etudiants.`Code etu`
 where  Uid='".$membres_gpe_annu_uid[$i]."'";
$resultat=mysql_query($query,$connexion ); 
// si aucun 
			if (!mysql_num_rows($resultat))
			{$absent++;
		echo "<tr>";
		echo "<td >";
					echo  "<b>".$membres_gpe_annu_uid[$i]."</b>";

		echo "</td>";
				echo "<td >";
				echo  $valeur;

		echo "</td>";
						echo "<td bgcolor = 'red' >";
				echo  "n'existe pas dans la base ";

		echo "</td>";
		echo "</tr>";
			}
			else
				{
	// on vérifie chaque membre du gpe ldap de reference dans les groupes principaux  de la base élève
		   $query="SELECT code_etudiant,libelle,Uid,groupe_principal,date_maj FROM ligne_groupe left join annuaire  on annuaire.`code-etu`=ligne_groupe.code_etudiant
	left join groupes on groupes.`code`=ligne_groupe.code_groupe where groupe_principal='oui' and Uid='".$membres_gpe_annu_uid[$i]."' and date_maj>'2019-01-01'";
	$resultat=mysql_query($query,$connexion ); 
	// si aucun 
				if (!mysql_num_rows($resultat))
				{$erreur++;
					echo "<tr>";
					echo "<td >";
					echo  "<b>".$membres_gpe_annu_uid[$i]."</b>";

					echo "</td>";
					echo "<td>";
					echo $valeur;

					echo "</td>";
					echo "<td bgcolor = 'orange'>";
					echo  " existe dans la base mais ne fait partie d'aucun groupe principal ";

					echo "</td>";
					echo "</tr>";
				}
				}
				
				echo "</tr>";
		}
				echo "</table>";
		}// fin du if $nombre
		
	else{
	echo 'groupe INEXISTANT DANS ANNUAIRE';
		}
		}
	else{
		envoimail('gi-dev@grenoble-inp.fr', 'impossible de se connecter à '.$server, 'dans initannu-auto.php impossible de se connecter à '.$server);
		echo 'erreur connection ldap';
		}
//pour calculer l'année d'IA
	$annee=$annee_courante-1;
		

echo "<br> <br>on vérifie maintenant  les membres de la base élèves avec une IA en $annee non membres du groupe triode de ref<br><br>";
 $query="SELECT * FROM etudiants left join annuaire  on annuaire.`code-etu`=etudiants.`Code etu` where `Année Univ`='".$annee."'";
$resultat=mysql_query($query,$connexion ); 
echo "<table border=1>";
// pour chacun
			while($e=mysql_fetch_array($resultat))
				
			{
				if (!in_array($e['UId'],$membres_gpe_annu_uid))
				{
					echo "<tr>";
					echo "<td >";
echo  $e['UId'];
					echo "</td>";
					echo "<td>";
echo "<a href=fiche.php?code=".$e['Code etu'].">".$e['Nom']. " </a>";					
					echo "</td>";
					echo "<td>";
echo "existe dans la base mais pas dans groupe triode ";
					echo "</td>";
			$absent2++;
				}
			}
echo "</table border=1>";
echo "<br><br><br><br>";

echo "récapitulatif : <b>".sizeof($membres_gpe_annu)  ." </b>présents dans groupe triode de référence <br>\n ";	
echo "récapitulatif : <b>".$absent ." </b>présents dans groupe de référence mais absent dans la base élèves<br>\n ";	
echo "récapitulatif : <b>".$erreur ." </b>présents dans groupe de référence et dans la base mais sans  groupe principal <br>\n ";	
echo "récapitulatif : <b>".$absent2 ." </b>présents dans la base avec une IA en $annee  mais pas dans le groupe de référence triode <br>\n ";	
mysql_close($connexion);
}

else
{
	echo affichealerte ("Vous n'êtes pas autorisé à utiliser cette fonctionalité ");
}


?>
