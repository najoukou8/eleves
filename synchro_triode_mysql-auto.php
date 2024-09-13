<?
set_time_limit(240);
//require ("param.php");
require ("function.php");
// acces uniquement en ligne de commande :
if (!isset($_SERVER['PHP_AUTH_USER']))
	// pour les tests
	//if(1)
{
// On se connecte


$dsn="gi_users";
$user_sql="apache";
$password='Bmanpj1';
$host="localhost";


$connexion =Connexion ($user_sql, $password, $dsn, $host);



$self=$_SERVER['PHP_SELF'];
$sql1='';
$sql2='';
$URL =$_SERVER['PHP_SELF'];
$table="annuaire";



 //--------------------------------- import dans  gi_users 
$groupe_annuaire_personnels='cn=inpg-appli-ksup-GI-personnels-intra-flat';
$groupe_annuaire_etudiants='cn=inpg-GI-etudiants-ETU-flat';
$groupe_annuaire_etupersonnels='cn=inpg-gi-etupersonnel-admin';

$id_groupe_personnels=1;
$id_groupe_etudiants=2;
$id_groupe_etupersonnels=5;

echo"<br>\n import ldap  vers table  en cours ...";
$cree=0;
$creelignes=0;
$erreur=0;
$erreurgpe=0;
$erreuruid=0;
$supp=0;
$new=0;
$sqlquery="select * from people_tampon  ";
$resultat=mysql_query($sqlquery,$connexion ); 
echo "<br>\n  il y a ".mysql_num_rows($resultat)." enregistrement  dans la table people_tampon";


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
	

		
		echo"<br>\n on s'est connecté à l'anuaire on peut vider les tables tampons";		
		echo"<br>\n on vide  la table  lignes_groupes_tampon...";
		$sqlquery="DELETE FROM lignes_groupes_tampon ";
		$resultat=mysql_query($sqlquery,$connexion ); 
		echo afficheresultatsql($resultat,$connexion);
		echo"<br>\n on vide  la table  people_tampon";
		$sqlquery="DELETE FROM people_tampon  ";
		$resultat=mysql_query($sqlquery,$connexion ); 
		echo afficheresultatsql($resultat,$connexion);

		echo " <br> on traite les PERSONNELS <br>";




	
		$dn =   "OU=groupes,ou=inpg,dc=agalan,dc=org";
		// pour les personnels :
		$filtre = "(&(".$groupe_annuaire_personnels."))";		
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		echo"<br>\n on récupère les membres de  $groupe_annuaire_personnels...<br>\n ";
		$info = ldap_get_entries($ds,$sr);
		// on initialise le tableau
		$membres_gpe_annu=array();
// boucle en cas d'attrib multi evalues
for ( $j=0; $j<sizeof( $info[0]['member'])-1 ; $j++ )
			{
				//on remplit le tableau avec les UIDs
				$uidandco=explode(',',$info[0]['member'][$j]);
				// attention il faut exclure le fake member
				if($uidandco[0]!='cn=Agalan groups fake member')
					{
						$membres_gpe_annu[]= $uidandco[0];
					}
			//echo $uidandco[0];
			//echo "<br>\n ";
			}
				
		// maintenant on parcourt le tableau et pour chaque uid on récupère les attributs qui nous intéressent
		$dn =   "OU=people,ou=inpg,dc=agalan,dc=org";
		//$attrib=array('sn','aglnpatronymicname','aglnorganizationuid','mail','mail','uid','aglnpersonstatus','employeetype','aglnine','aglndateofbirth','aglnmodificationdate','aglnadmissiondate','aglnexpirydate','givenname','ou');
$attrib=array('uid','sn','givenname','mail');

			echo"<br>\n on a récupéré ".sizeof($membres_gpe_annu)." membres .<br>\n ";
		
		for ( $i=0; $i<sizeof($membres_gpe_annu) ; $i++ )
		{
		$filtre = "(&(".$membres_gpe_annu[$i]."))";
		$sr =ldap_search($ds,$dn,$filtre);
				$nombre = ldap_count_entries($ds,$sr);
				
		$info = ldap_get_entries($ds,$sr);
		$sql='';
		//echo print_r($info);
		   for ( $k=0; $k<sizeof($attrib) ; $k++ )
		   {
				$temp=strtolower($attrib[$k]);
				if (array_key_exists($temp,$info[0]))
				{
								//echo "Pour l' etudiant ".$info[0]['uid'][0]." l'attribut $temp est OK <br>\n ";
			//pour les attrib multi evalues
						$valeur='';
						for ($z=0;$z<$info[0][$temp]["count"];$z++)
						{
						$valeur.= $info[0][$temp][$z].",";
						}
				}
				else		
				{
				echo "Pour le compte ".$info[0]['uid'][0]." il manque l'attribut $temp <br>\n ";
				#correction marc 20/09/2011
				$valeur=',';
				#fin correction marc 20/09/2011
				}
				
				// traitement des conversion nécessaire :
				//dates		
				// on enleve la virgule de la fin
				$valeur=substr($valeur,0,strlen($valeur)-1) ;
				if ($attrib[$k]=='aglndateofbirth' or $attrib[$k]=='aglnmodificationdate' or $attrib[$k]=='aglnadmissiondate' or $attrib[$k]=='aglnexpirydate' or $attrib[$k]=='modifytimestamp' )
				{
				$valeur=substr($valeur,6,2)."/".substr($valeur,4,2)."/".substr($valeur,0,4);
				}
				// pour le decodage utf8 des noms et prenoms
				if ($attrib[$k]=='givenname' or  $attrib[$k]=='sn' or $attrib[$k]=='aglnpatronymicname'  )
				{
				$valeur=utf8_decode($valeur);
				}
				//pb des ' à doubler
				$valeur= str_replace("'","''",stripslashes($valeur));
				$sql.="'".$valeur."',";
				//echo $valeur ."<br>\n ";	
			}
			
			 //il faut enlever la virgule de la fin pour le  query sql
 $sql=substr($sql,0,strlen($sql)-1) ;
							$query = "INSERT INTO people_tampon(`user_tampon_login`,`user_tampon_nom`,`user_tampon_prenom`,`user_tampon_email`) ";
   $query .= " VALUES($sql)";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat5=mysql_query($query,$connexion ); 
       if ($resultat5){$cree++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreur++;
    }
		// on récupère l'id du people que l'on vient de créer
$query6 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu[$i])[1]."'";		
//echo $query6;
  $resultat6=mysql_query($query6,$connexion );		
  $r=mysql_fetch_object($resultat6);
		
		
// on ajoute l'appartenance au groupe
$query = "INSERT INTO lignes_groupes_tampon (`groupe_tampon_id`,`people_tampon_id`) VALUES ('".$id_groupe_personnels."','".$r->user_tampon_login ."')";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat7=mysql_query($query,$connexion ); 
       if ($resultat7){$creelignes++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreurgpe++;
    }
		
		}		
		}// fin du if $nombre
		
	else{
	echo 'groupe personnels INEXISTANT DANS ANNUAIRE';
		}
		
//------------------------------------------------------------------------------------------------------------------------------------------------------------------	
		
		
		
//-----------------------------------------------------------------------------------------------------------------------------------------------------------		
echo " <br> on traite les ETUDIANTS <br>";
		// pour les etudiants  :
		
		// ici on se connecte à l'annuaire et on récupère le groupe
	//$server = "frontalannuaire2.inpg.fr";
	//$port = "389"  ;
	//$racine = "ou=inpg,dc=agalan,dc=org";
	# c'est un compte spécial qui ne sert qu'à ça et qui n'a pas de droits spéciaux
	#$rootdn="uid=radiusa,ou=people,ou=inpg,dc=agalan, dc=org";
	#$rootpw="q4Gv5Q9a";
	#$rootdn="uid=ensgia,ou=people,ou=inpg,dc=agalan, dc=org";
	#$rootpw="442Qj2gt";	
	//$rootdn="uid=standarl,ou=people,ou=inpg,dc=agalan, dc=org";
	//$rootpw="Cg3eB7Zw";	
	//$ds = ldap_connect($server);
	//$testconnect = ldap_bind($ds,$rootdn,$rootpw);		
		$dn =   "OU=groupes,ou=inpg,dc=agalan,dc=org";
		
		
		
		$filtre = "(&(".$groupe_annuaire_etudiants."))";		
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		echo"<br>\n on récupère les membres de  $groupe_annuaire_etudiants...<br>\n ";
		$info = ldap_get_entries($ds,$sr);
		// on initialise le tableau
		$membres_gpe_annu_etud=array();
// boucle en cas d'attrib multi evalues
for ( $j=0; $j<sizeof( $info[0]['member'])-1 ; $j++ )
			{
				//on remplit le tableau avec les UIDs
				$uidandco=explode(',',$info[0]['member'][$j]);
				// attention il faut exclure le fake member
				if($uidandco[0]!='cn=Agalan groups fake member')
					{
						$membres_gpe_annu_etud[]= $uidandco[0];
					}
			//echo $uidandco[0];
			//echo "<br>\n ";
			}
				
		// maintenant on parcourt le tableau et pour chaque uid on récupère les attributs qui nous intéressent
		$dn =   "OU=people,ou=inpg,dc=agalan,dc=org";
		//$attrib=array('sn','aglnpatronymicname','aglnorganizationuid','mail','mail','uid','aglnpersonstatus','employeetype','aglnine','aglndateofbirth','aglnmodificationdate','aglnadmissiondate','aglnexpirydate','givenname','ou');
$attrib=array('uid','sn','givenname','mail');

			echo"<br>\n on a récupéré ".sizeof($membres_gpe_annu_etud)." membres .<br>\n ";
		
		for ( $i=0; $i<sizeof($membres_gpe_annu_etud) ; $i++ )
		{
		$filtre = "(&(".$membres_gpe_annu_etud[$i]."))";
		$sr =ldap_search($ds,$dn,$filtre);
				$nombre = ldap_count_entries($ds,$sr);
				
		$info = ldap_get_entries($ds,$sr);
		$sql='';
		//echo print_r($info);
		   for ( $k=0; $k<sizeof($attrib) ; $k++ )
		   {
				$temp=strtolower($attrib[$k]);
				if (array_key_exists($temp,$info[0]))
				{
								//echo "Pour l' etudiant ".$info[0]['uid'][0]." l'attribut $temp est OK <br>\n ";
			//pour les attrib multi evalues
						$valeur='';
						for ($z=0;$z<$info[0][$temp]["count"];$z++)
						{
						$valeur.= $info[0][$temp][$z].",";
						}
				}
				else		
				{
				echo "Pour le compte ".$info[0]['uid'][0]." il manque l'attribut $temp <br>\n ";
				#correction marc 20/09/2011
				$valeur=',';
				#fin correction marc 20/09/2011
				}
				
				// traitement des conversion nécessaire :
				//dates		
				// on enleve la virgule de la fin
				$valeur=substr($valeur,0,strlen($valeur)-1) ;
				if ($attrib[$k]=='aglndateofbirth' or $attrib[$k]=='aglnmodificationdate' or $attrib[$k]=='aglnadmissiondate' or $attrib[$k]=='aglnexpirydate' or $attrib[$k]=='modifytimestamp' )
				{
				$valeur=substr($valeur,6,2)."/".substr($valeur,4,2)."/".substr($valeur,0,4);
				}
				// pour le decodage utf8 des noms et prenoms
				if ($attrib[$k]=='givenname' or  $attrib[$k]=='sn' or $attrib[$k]=='aglnpatronymicname'  )
				{
				$valeur=utf8_decode($valeur);
				}
				//pb des ' à doubler
				$valeur= str_replace("'","''",stripslashes($valeur));
				$sql.="'".$valeur."',";
				//echo $valeur ."<br>\n ";	
			}
			
			 //il faut enlever la virgule de la fin pour le  query sql
 $sql=substr($sql,0,strlen($sql)-1) ;
 
 // avant d'insérer l'user on vérifie si il  n'a pas déjà été ajouté comme personnel
 $query7 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu_etud[$i])[1]."'";		

  $resultat7=mysql_query($query7,$connexion );		
  $r7=mysql_fetch_object($resultat7);
  if (isset ($r7->user_tampon_id))
	  echo "ATTENTION ".explode('=',$membres_gpe_annu_etud[$i])[1] ." existe déjà<br>";
  else
  {
 
							$query = "INSERT INTO people_tampon(`user_tampon_login`,`user_tampon_nom`,`user_tampon_prenom`,`user_tampon_email`) ";
   $query .= " VALUES($sql)";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat5=mysql_query($query,$connexion ); 
       if ($resultat5){$cree++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreur++;
    }
  }
		// on récupère l'id du people que l'on vient de créer
$query6 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu_etud[$i])[1]."'";		
//echo $query6;
  $resultat6=mysql_query($query6,$connexion );		
  $r=mysql_fetch_object($resultat6);
		
		
// on ajoute l'appartenance au groupe
$query = "INSERT INTO lignes_groupes_tampon (`groupe_tampon_id`,`people_tampon_id`) VALUES ('".$id_groupe_etudiants."','".$r->user_tampon_login ."')";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat7=mysql_query($query,$connexion ); 
       if ($resultat7){$creelignes++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreurgpe++;
    }
		
		}		
		}// fin du if $nombre
		
	else{
	echo 'groupe étudiants INEXISTANT DANS ANNUAIRE';
		}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++





echo " <br> on traite les ETUPERSONNELS <br>";
		// pour les etupersonnels  :
			
		$dn =   "OU=groupes,ou=inpg,dc=agalan,dc=org";
		
		
		
		$filtre = "(&(".$groupe_annuaire_etupersonnels."))";		
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		echo"<br>\n on récupère les membres de  $groupe_annuaire_etupersonnels...<br>\n ";
		$info = ldap_get_entries($ds,$sr);
		// on initialise le tableau
		$membres_gpe_annu_etupersonnels=array();
// boucle en cas d'attrib multi evalues
for ( $j=0; $j<sizeof( $info[0]['member'])-1 ; $j++ )
			{
				//on remplit le tableau avec les UIDs
				$uidandco=explode(',',$info[0]['member'][$j]);
				// attention il faut exclure le fake member
				if($uidandco[0]!='cn=Agalan groups fake member')
					{
						$membres_gpe_annu_etupersonnels[]= $uidandco[0];
					}
			//echo $uidandco[0];
			//echo "<br>\n ";
			}
				
		// maintenant on parcourt le tableau et pour chaque uid on récupère les attributs qui nous intéressent
		$dn =   "OU=people,ou=inpg,dc=agalan,dc=org";
		//$attrib=array('sn','aglnpatronymicname','aglnorganizationuid','mail','mail','uid','aglnpersonstatus','employeetype','aglnine','aglndateofbirth','aglnmodificationdate','aglnadmissiondate','aglnexpirydate','givenname','ou');
$attrib=array('uid','sn','givenname','mail');

			echo"<br>\n on a récupéré ".sizeof($membres_gpe_annu_etupersonnels)." membres .<br>\n ";
		
		for ( $i=0; $i<sizeof($membres_gpe_annu_etupersonnels) ; $i++ )
		{
		$filtre = "(&(".$membres_gpe_annu_etupersonnels[$i]."))";
		$sr =ldap_search($ds,$dn,$filtre);
				$nombre = ldap_count_entries($ds,$sr);
				
		$info = ldap_get_entries($ds,$sr);
		$sql='';
		//echo print_r($info);
		   for ( $k=0; $k<sizeof($attrib) ; $k++ )
		   {
				$temp=strtolower($attrib[$k]);
				if (array_key_exists($temp,$info[0]))
				{
								//echo "Pour l' etudiant ".$info[0]['uid'][0]." l'attribut $temp est OK <br>\n ";
			//pour les attrib multi evalues
						$valeur='';
						for ($z=0;$z<$info[0][$temp]["count"];$z++)
						{
						$valeur.= $info[0][$temp][$z].",";
						}
				}
				else		
				{
				echo "Pour le compte ".$info[0]['uid'][0]." il manque l'attribut $temp <br>\n ";
				#correction marc 20/09/2011
				$valeur=',';
				#fin correction marc 20/09/2011
				}
				
				// traitement des conversion nécessaire :
				//dates		
				// on enleve la virgule de la fin
				$valeur=substr($valeur,0,strlen($valeur)-1) ;
				if ($attrib[$k]=='aglndateofbirth' or $attrib[$k]=='aglnmodificationdate' or $attrib[$k]=='aglnadmissiondate' or $attrib[$k]=='aglnexpirydate' or $attrib[$k]=='modifytimestamp' )
				{
				$valeur=substr($valeur,6,2)."/".substr($valeur,4,2)."/".substr($valeur,0,4);
				}
				// pour le decodage utf8 des noms et prenoms
				if ($attrib[$k]=='givenname' or  $attrib[$k]=='sn' or $attrib[$k]=='aglnpatronymicname'  )
				{
				$valeur=utf8_decode($valeur);
				}
				//pb des ' à doubler
				$valeur= str_replace("'","''",stripslashes($valeur));
				$sql.="'".$valeur."',";
				//echo $valeur ."<br>\n ";	
			}
			
			 //il faut enlever la virgule de la fin pour le  query sql
 $sql=substr($sql,0,strlen($sql)-1) ;
 
 // avant d'insérer l'user on vérifie si il  n'a pas déjà été ajouté comme personnel
 $query7 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu_etupersonnels[$i])[1]."'";		

  $resultat7=mysql_query($query7,$connexion );		
  $r7=mysql_fetch_object($resultat7);
  if (isset ($r7->user_tampon_id))
	  echo "ATTENTION ".explode('=',$membres_gpe_annu_etupersonnels[$i])[1] ." existe déjà<br>";
  else
  {
 
							$query = "INSERT INTO people_tampon(`user_tampon_login`,`user_tampon_nom`,`user_tampon_prenom`,`user_tampon_email`) ";
   $query .= " VALUES($sql)";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat5=mysql_query($query,$connexion ); 
       if ($resultat5){$cree++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreur++;
    }
  }
		// on récupère l'id du people que l'on vient de créer
$query6 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu_etupersonnels[$i])[1]."'";		
//echo $query6;
  $resultat6=mysql_query($query6,$connexion );		
  $r=mysql_fetch_object($resultat6);
		
		
// on ajoute l'appartenance au groupe
$query = "INSERT INTO lignes_groupes_tampon (`groupe_tampon_id`,`people_tampon_id`) VALUES ('".$id_groupe_etupersonnels."','".$r->user_tampon_login ."')";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat7=mysql_query($query,$connexion ); 
       if ($resultat7){$creelignes++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreurgpe++;
    }
		
		}		
		}// fin du if $nombre
		
	else{
	echo 'groupe etupersonnels INEXISTANT DANS ANNUAIRE';
		}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
// on traite les autres groupes
$autresgroupes=array(
'16'=>'cn=inpg-GI-service-scol-ADMIN',
'17'=>'cn=inpg-GI-service-bib-ADMIN',
'18'=>'cn=inpg-GI-service-comm-ADMIN',
'19'=>'cn=inpg-GI-service-compta-ADMIN',
'20'=>'cn=inpg-GI-service-dir-ADMIN',
'21'=>'cn=inpg-GI-service-re-ADMIN',
'22'=>'cn=inpg-GI-service-resppeda-ADMIN',
'23'=>'cn=inpg-GI-service-rh-ADMIN',
'24'=>'cn=inpg-GI-service-ri-ADMIN'
);
$liste_id_autresgroupes='';
foreach ($autresgroupes as $id_gpe_resp=>$ungpeannu)
{
$liste_id_autresgroupes.="'".$id_gpe_resp."',";
echo " <br> on traite le groupe $ungpeannu <br>";
		// pour les $ungpeannu  :
			
		$dn =   "OU=groupes,ou=inpg,dc=agalan,dc=org";
		
		
		
		$filtre = "(&(".$ungpeannu."))";		
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		echo"<br>\n on récupère les membres de  $ungpeannu...<br>\n ";
		$info = ldap_get_entries($ds,$sr);
		// on initialise le tableau
		$membres_gpe_annu=array();
// boucle en cas d'attrib multi evalues
for ( $j=0; $j<sizeof( $info[0]['member'])-1 ; $j++ )
			{
				//on remplit le tableau avec les UIDs
				$uidandco=explode(',',$info[0]['member'][$j]);
				// attention il faut exclure le fake member
				if($uidandco[0]!='cn=Agalan groups fake member')
					{
						$membres_gpe_annu[]= $uidandco[0];
					}
			//echo $uidandco[0];
			//echo "<br>\n ";
			}
				
		// maintenant on parcourt le tableau et pour chaque uid on récupère les attributs qui nous intéressent
		$dn =   "OU=people,ou=inpg,dc=agalan,dc=org";
		//$attrib=array('sn','aglnpatronymicname','aglnorganizationuid','mail','mail','uid','aglnpersonstatus','employeetype','aglnine','aglndateofbirth','aglnmodificationdate','aglnadmissiondate','aglnexpirydate','givenname','ou');
$attrib=array('uid','sn','givenname','mail');

			echo"<br>\n on a récupéré ".sizeof($membres_gpe_annu)." membres .<br>\n ";
		
		for ( $i=0; $i<sizeof($membres_gpe_annu) ; $i++ )
		{
		$filtre = "(&(".$membres_gpe_annu[$i]."))";
		$sr =ldap_search($ds,$dn,$filtre);
				$nombre = ldap_count_entries($ds,$sr);
				
		$info = ldap_get_entries($ds,$sr);
		$sql='';
		//echo print_r($info);
		   for ( $k=0; $k<sizeof($attrib) ; $k++ )
		   {
				$temp=strtolower($attrib[$k]);
				if (array_key_exists($temp,$info[0]))
				{
								//echo "Pour l' etudiant ".$info[0]['uid'][0]." l'attribut $temp est OK <br>\n ";
			//pour les attrib multi evalues
						$valeur='';
						for ($z=0;$z<$info[0][$temp]["count"];$z++)
						{
						$valeur.= $info[0][$temp][$z].",";
						}
				}
				else		
				{
				echo "Pour le compte ".$info[0]['uid'][0]." il manque l'attribut $temp <br>\n ";
				#correction marc 20/09/2011
				$valeur=',';
				#fin correction marc 20/09/2011
				}
				
				// traitement des conversion nécessaire :
				//dates		
				// on enleve la virgule de la fin
				$valeur=substr($valeur,0,strlen($valeur)-1) ;
				if ($attrib[$k]=='aglndateofbirth' or $attrib[$k]=='aglnmodificationdate' or $attrib[$k]=='aglnadmissiondate' or $attrib[$k]=='aglnexpirydate' or $attrib[$k]=='modifytimestamp' )
				{
				$valeur=substr($valeur,6,2)."/".substr($valeur,4,2)."/".substr($valeur,0,4);
				}
				// pour le decodage utf8 des noms et prenoms
				if ($attrib[$k]=='givenname' or  $attrib[$k]=='sn' or $attrib[$k]=='aglnpatronymicname'  )
				{
				$valeur=utf8_decode($valeur);
				}
				//pb des ' à doubler
				$valeur= str_replace("'","''",stripslashes($valeur));
				$sql.="'".$valeur."',";
				//echo $valeur ."<br>\n ";	
			}
			
			 //il faut enlever la virgule de la fin pour le  query sql
 $sql=substr($sql,0,strlen($sql)-1) ;
 
 // avant d'insérer l'user on vérifie si il  n'a pas déjà été ajouté 
 //normalement c'est déjà le cas
 /* $query7 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu[$i])[1]."'";		

  $resultat7=mysql_query($query7,$connexion );		
  $r7=mysql_fetch_object($resultat7);
  if (isset ($r7->user_tampon_id))
	  echo "ATTENTION ".explode('=',$membres_gpe_annu[$i])[1] ." existe déjà<br>";
  else
  {
 
							$query = "INSERT INTO people_tampon(`user_tampon_login`,`user_tampon_nom`,`user_tampon_prenom`,`user_tampon_email`) ";
   $query .= " VALUES($sql)";

  $resultat5=mysql_query($query,$connexion ); 
       if ($resultat5){$cree++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreur++;
    }
  } */
		// on récupère l'id du people 
$query6 = "SELECT * FROM people_tampon WHERE user_tampon_login='".explode('=',$membres_gpe_annu[$i])[1]."'";		
//echo $query6;
  $resultat6=mysql_query($query6,$connexion );		
  $r=mysql_fetch_object($resultat6);
		
// si on le trouve  
	  if (isset ($r->user_tampon_id))	
	  {
// on on ajoute l'appartenance au groupe
$query = "INSERT INTO lignes_groupes_tampon (`groupe_tampon_id`,`people_tampon_id`) VALUES ('".$id_gpe_resp."','".$r->user_tampon_login ."')";
//echo $query;
//echo "<br>\n ___________________<br>\n ";
  $resultat7=mysql_query($query,$connexion ); 
       if ($resultat7){$creelignes++;}
   else {
   echo "<br>\n  erreur avec ".$query."<br>\n ";
    $erreurgpe++;
    }		
		}
		else {
   echo "<br>\n  l'uid ".explode('=',$membres_gpe_annu[$i])[1] ." n'existe pas dans people_tampon "."<br>\n ";
    $erreuruid++;
    }
		
		}		
		}// fin du if $nombre
		
	else{
	echo 'groupe ungpeannu INEXISTANT DANS ANNUAIRE';
		}

} // fin du foreach
// pour $liste_id_autresgroupes on enleve la derniere virgule
$liste_id_autresgroupes=substr($liste_id_autresgroupes, 0, -1);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
		}		
			
		
	else{
		envoimail('gi-dev@grenoble-inp.fr', 'impossible de se connecter à '.$server, 'dans synchro_triode_mysql-auto impossible de se connecter à '.$server);
		echo 'erreur connection ldap';
		}

echo "<br>\n resultat ".$cree ." lignes   enregistrées dans people_tampon <br>\n ";
echo "<br>\n resultat ".$creelignes ." lignes enregistrées dans lignes_groupes_tampon <br>\n ";
echo "resultat ".$erreur ." erreurs <br>\n ";		
echo "resultat ".$erreuruid ." erreurs uid introuvable <br>\n ";	
echo "resultat ".$erreurgpe ." erreurs groupe<br>\n ";

// ici il faudrait comparer les tables tampons et def pour avoir la liste des modifications :
//ajout /suppression et les indiquer  dans le log et envoyer un mail
// pour les people
// les  arrivants :
$querycomp="select * from people_tampon  where people_tampon.user_tampon_login not in (select people.user_login from people)";
  $resultatcomp=mysql_query($querycomp,$connexion );		
	  $nouv=array(); 
 while ($z=mysql_fetch_object($resultatcomp))

  {
$nouv[]="(".$z->user_tampon_login.")  ".$z->user_tampon_nom;
  }	  

// les  départs :

$querycomp2="select * from people  where user_login not in (select user_tampon_login from people_tampon) and user_password=''";
  $resultatcomp2=mysql_query($querycomp2,$connexion );		
	  $old=array(); $ligne_groupe_delete=array();
 while ($z=mysql_fetch_object($resultatcomp2))
  {
$old[]="(".$z->user_login.")  ".$z->user_nom;
$ligne_groupe_delete[] = $z->user_login;
  }	 
// pour les groupes



// si tout s'est bien passé 

if ($cree > 500 and $creelignes >500)

//on peut recopier tampon-> prod
{
	$erreursprod=0;
	$creeprod=0;	
	$creelignesprod=0;

						
		echo"<br>\n on a$cree lignes dans people_tampon on  peut vider les tables de prod pour les groupes correspondants";		
		echo"<br>\n on vide  dans la table  lignes_groupes les lignes avec groupe_id=code_groupe etudiant et code_groupe personnel. et groupe etupersonnel.";
				$sqlquery="DELETE FROM lignes_groupes where groupe_id=".$id_groupe_personnels." OR groupe_id=".$id_groupe_etudiants.
		" OR groupe_id=".$id_groupe_etupersonnels . 
		" OR groupe_id in (".$liste_id_autresgroupes.")";
	//	echo $sqlquery;
		//$sqlquery="DELETE FROM lignes_groupes where groupe_id=".$id_groupe_personnels." OR groupe_id=".$id_groupe_etudiants.
		" OR groupe_id=".$id_groupe_etupersonnels ;
		

		$resultat=mysql_query($sqlquery,$connexion ); 
		echo afficheresultatsql($resultat,$connexion);
		echo"<br>\n on vide  la table  people... sauf localonly : password != ''";	
		$sqlquery="DELETE FROM people where user_password_hash = '' ";
		$resultat=mysql_query($sqlquery,$connexion ); 
		echo afficheresultatsql($resultat,$connexion);

		echo " <br> on recopie les people <br>";
		
		$query  = "SELECT * FROM people_tampon ";
  $resultat=mysql_query($query,$connexion );		
  	
		
		while($r=mysql_fetch_object($resultat))
		{
			$query2 = "INSERT INTO people(`user_login`,`user_nom`,`user_prenom`,`user_email`) ";
			$query2 .= " VALUES('".$r->user_tampon_login."','".str_replace("'","''",stripslashes($r->user_tampon_nom))."','".str_replace("'","''",stripslashes($r->user_tampon_prenom))."','".$r->user_tampon_email."') "	;	
		 $resultat2=mysql_query($query2,$connexion ); 
			   if ($resultat2){$creeprod++;}
		   else {
		   echo "<br>\n  erreur avec ".$query2."<br>\n ";
			$erreursprod++;
			}			
		}
		
		echo " <br> on recopie les lignes_groupes <br>";
		
		$query  = "SELECT * FROM lignes_groupes_tampon ";
  $resultat=mysql_query($query,$connexion );		
  	
		
		while($r=mysql_fetch_object($resultat))
		{
			$query2 = "INSERT INTO lignes_groupes(`groupe_id`,`people_id`) ";
			$query2 .= " VALUES('".$r->groupe_tampon_id."','".$r->people_tampon_id."') "	;	
		 $resultat2=mysql_query($query2,$connexion ); 
			   if ($resultat2){$creelignesprod++;}
		   else {
		   echo "<br>\n  erreur avec ".$query2."<br>\n ";
			$erreursprod++;
			}			
		}		
		

	echo "<br>\n resultat ".$creeprod ." lignes   enregistrées dans people <br>\n ";
echo "<br>\n resultat ".$creelignesprod ." lignes enregistrées dans lignes_groupes <br>\n ";
echo "resultat ".$erreursprod ." erreurs <br>\n ";
$mess='';		
if (sizeof($nouv)>0)
{
	$mess.="il y a ".sizeof($nouv) ." nouveau(x) (ils ont été ajoutés à people)  : " ."  \n ";
	foreach ($nouv as $unnouveau)
	{
		// on cherche si c'est un etu ou personnel
		$mess.=$unnouveau."\n ";
		
	}
	
}
if (sizeof($old)>0)
{
	$mess.="il y a ".sizeof($old) ." ancien(s) (ils ont été supprimés de people)  : " ."   \n ";
	foreach ($old as $unnouveau)
	{
		$mess.=$unnouveau."\n ";
		
	}
	
	foreach ($ligne_groupe_delete as $ligne_groupe_id)
	{

		$purge="DELETE FROM lignes_groupes where people_id = '$ligne_groupe_id' ";
		$purgeResult =mysql_query($purge,$connexion );
		$mess.= " purge lignes_groupes pour $ligne_groupe_id " ;

	}
	
	
}
if ($mess !='')
{
echo $mess." <br>\n ";
envoimail('gi-dev@grenoble-inp.fr', 'synchro des users GI',$mess);
}
//echo "resultat ".$erreurgpe ." erreurs groupe<br>\n ";
	
}else
	// il y a un problème on ne touche à rien : on garde la version n-1
{
	envoimail('gi-dev@grenoble-inp.fr', 'erreur import ldap',"il semble qu\'il y ait un problème  : dans synchro_triode_mysql-auto : seulement $cree utilisateurs dans people_tampon : on garde la version précédente");
	echo "il semble qu\'il y ait un problème  : $cree utilisateurs dans people_tampon : on garde la version précédente <br>\n  ";	
}



mysql_close($connexion);
}
?>
