<?
set_time_limit(240);
require ("param.php");
require ("function.php");
// acces uniquement en ligne de commande :
if (!isset($_SERVER['PHP_AUTH_USER']))
{
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
    $gauche='';
    $droite='' ;
	$partie3=''; 

 //--------------------------------- import dans  annu 
   
echo"<br>\n import ldap  vers table annu_imp en cours ...";
$cree=0;
$erreur=0;
$supp=0;
$new=0;
$sqlquery="select * from imp_annu  ";
$resultat=mysql_query($sqlquery,$connexion ); 
echo "<br>\n  il y a ".mysql_num_rows($resultat)." etudiants  dans la table import";
echo"<br>\n on vide  la table d'import ...";
$sqlquery="DELETE FROM imp_annu ";
$resultat=mysql_query($sqlquery,$connexion ); 
echo afficheresultatsql($resultat,$connexion);

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
			echo "<br>\n on est bien connecté à ".$server .'<br>\n';
		$dn =   "OU=groupes,ou=inpg,dc=agalan,dc=org";
		$filtre = "(&(".$groupe_annuaire_etudiants."))";		
		$sr =ldap_search($ds,$dn,$filtre);
		$nombre = ldap_count_entries($ds,$sr);
		if ($nombre==1){
		echo"<br>\n on récupère les membres de  $groupe_annuaire_etudiants...<br>\n ";
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
		$attrib=array('sn','aglnpatronymicname','aglnorganizationuid','mail','mail','uid','aglnpersonstatus','employeetype','aglnine','aglndateofbirth','aglnmodificationdate','aglnadmissiondate','aglnexpirydate','givenname','ou');
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
				echo "Pour l' etudiant ".$info[0]['uid'][0]." il manque l'attribut $temp <br>\n ";
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
							$query = "INSERT INTO imp_annu(`Nom usuel`,`Nom patronymique`,`Id. Établ.`,`Mail cano.`,`Mail effectif`,`UId`, `Statut`,`Types`,`INE`,`Date nais.`,`Date modification`,`Date création`,`Date expir.`,`Prénom`,`Composantes`) ";
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
		}// fin du if $nombre
		
	else{
	echo 'groupe INEXISTANT DANS ANNUAIRE';
		}
		}
	else{
		envoimail('sigi.admin@grenoble-inp.fr', 'impossible de se connecter à '.$server, 'dans initannu-auto.php impossible de se connecter à '.$server);
		echo 'erreur connection ldap';
		}

echo "<br>\n resultat ".$cree ." fiches enregistrées dans import annuaire <br>\n ";
echo "resultat ".$erreur ." erreurs <br>\n ";		
		
$sqlquery="select * from imp_annu  ";
$resultat=mysql_query($sqlquery,$connexion ); 
echo "<br>\n  il y a ".mysql_num_rows($resultat)." etudiants  à importer";

// maintenant on importe de imp annu vers annuaire
echo"<br>\n import table annu_imp vers table annuaire en cours ...";
$cree=0;
$erreur=0;
$supp=0;
$new=0;
$pasoffi=0;
//on parcourt le fichier import-annuaire
$sqlquery="SELECT * FROM imp_annu  ";
$resultat=mysql_query($sqlquery,$connexion ); 
//pour chaque enregistrement

while ($e=mysql_fetch_object($resultat)){
$estnouveau=0;
if ($e->Statut =='OFFI')
		{
		$uid_etu_import=$e->$myannuaireuid;
		//on teste si le login existe deja dans la table annuaire
		$sqlquery2="SELECT * FROM $table where uid='". $uid_etu_import ."'";
		$resultat2=mysql_query($sqlquery2,$connexion ); 
		$r2=mysql_fetch_object($resultat2);
		//si oui  on efface l'enregistrement
		        if (mysql_num_rows( $resultat2)!=0){

		$sqlquery3="DELETE FROM $table where uid='". $uid_etu_import ."'";
		//echo $sqlquery3;
		//echo"<br>\n ";
		$resultat3=mysql_query($sqlquery3,$connexion ); 
		$supp++;

		}
		//sinon c'est un nouveau
		else{$new++;
		$estnouveau=1;
		echo "<br>\n  nouveau : ".$e->$myannuaireuid;

		}
		// ds les 2 cas on ajoute l'enregistrement
		$cibon='';
		foreach($champs as $ci2)
		{
		 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
			if ($ci2!="date_maj")
			 { 
			 //ds imp-annu il n'y a pas ces deux champs
			 if ($ci2=="code-ccp" or $ci2=="code-etu" )

				 {
				 			 // on ne fait rien
				 }
				//2019
				//inutile avec l'info nomail dans les groupes et le script initannu-nomail
				//elseif($ci2=="Mail effectif" and  $estnouveau )				
				//elseif($ci2=="Mail effectif" and ($estnouveau or $r2->$myannuairemail_effectif=='') and diffdatejours($date_debut_email1A)<0 )
				//{
				// si c'est le champ mail ET que c'est un nouveau ET que la date de publication des emails n'est pas dépassée on insert un email vide
				//			  $sql1.= "`".$ci2."`,";
				//				$sql2.= "'',";
				//}
				 else
				{ 
				$cibon= str_replace("'","''",stripslashes($e->$ci2));
				 $sql1.= "`".$ci2."`,";
				 $sql2.= "'".$cibon."',";
				 }
			 }
			else	
			 {
			  $sql1.= $ci2.",";
			 $sql2.= "now(),";		 
			 }
		 }		 
		 //il faut enlever les virgules de la fin
		 //il faut enlever la virgule de la fin
		 $sql1=substr($sql1,0,strlen($sql1)-1) ;
		  $sql2=substr($sql2,0,strlen($sql2)-1) ;

		    $query = "INSERT INTO $table($sql1)";
		   $query .= " VALUES($sql2)";
		//echo $query;
		//echo "<br>\n ___________________<br>\n ";
		  $resultat5=mysql_query($query,$connexion ); 
		       if ($resultat5){$cree++;}
		   else {
		   echo "<br>\n  erreur ".mysql_error($connexion)." avec ".$query."<br>\n ";
		 
			//   $objet = "erreur dans ".$URL ;
			//$messagem .= "\n une erreur SQL s'est produite dans le script $URL : requete ayant produit l'erreur\n" ;
			//$messagem .= "\n ".$query." \n" ;
			//$messagem .= "\n erreur mysql : \n" ;
			//$messagem .= "\n ".mysql_error($connexion)." \n" ;						
			 //envoimail($sigiadminmail,$objet,$messagem);  
			
		    $erreur++;
		    } 
		$sql1='';
		$sql2='';
	             
		}
		else //pour les pas offi
		{
		$pasoffi++;
		}
}
echo "<br>\n resultat ".$cree ." fiches enregistrées<br>\n ";
echo "resultat ".$supp ." fiches modifiees<br>\n ";
echo "resultat ".$new ." fiches nouvelles<br>\n ";
echo "resultat ".$pasoffi ." avec statut different de OFFI donc pas importés  <br>\n ";
echo "resultat ".$erreur ." erreurs <br>\n ";	

        //   on met à jour la date et l'heure dans la table param
       // echo "<br>\n et on met à jour la date et l'heure dans la table param <br>\n ";
       // $query = "UPDATE param SET date_import_annu=getdate() WHERE config='1'";
        //$result = odbc_exec($sqlconnect, $query);
//--------------------------------- synchro des fichiers 
echo"synchro en cours ...";
//on parcourt la table  annuaire
$cree=0;
$erreurcode_ccp=0;
    $erreurcode_etu=0;
   $query="SELECT * FROM $table ";
$resultat=mysql_query($query,$connexion ); 
while ($e=mysql_fetch_object($resultat)){
//modif marc 27/01/2017 suite bascule
//$id=$e->$myannuaireid__établ_;
$id=$e->$idetablissement;
  // $id=$e->$myannuaireid__Établ_;
   $nomusuel=$e->$myannuairenom_usuel;
//attention on a aussi des codes en 4 parties avec inpg-opi
           $code_etu = '';
            $code_ccp = '';
            $morceaux = explode(',', $id);
            foreach ($morceaux as $index => $chaine) {
                if (substr($chaine, 0, strlen('apo-')) == 'apo-') {
                    // La chaine commence par apo
                    $code_etu = substr($chaine, strlen('apo-'));
                } elseif (substr($chaine, 0, strlen('inpg_apo-')) == 'inpg_apo-') {
                    $code_etu = substr($chaine, strlen('inpg_apo-'));
                } elseif (substr($chaine, 0, strlen('ccp-')) == 'ccp-') {
                    $code_ccp = substr($chaine, strlen('ccp-'));
                } else {
                    // On ne fait rien
                }
            }
			
            if ($code_etu == '') {
                // si on arrive ici c'est qu'on a pas trouvé apo ou inpg_apo
                echo "Erreur avec " . $id . "-" . $nomusuel . " pas apo dans id etabl on met 99999999 comme code etu dans la table annuaire<br>\n";
                // pour les quelques ujf mis dans les groupes annuaire par wilfrid mais qui n'existent  pas dans apogee , donc absent de la base élèves
                $code_etu = '99999999';
                $erreurcode_etu++;
            }
            if ($code_ccp == '') {
                $code_ccp = '';
                $erreurcode_ccp++;
            }

		
				//attention il y a des code ccp 2004-xxxx ds ce cas on vire le 2004-
		 if (substr($code_ccp,0,5)== '2004-')
		 {

		 $code_ccp=substr($code_ccp,5);
		 } 
		 // CAS PARTICULIER  de LIBERT 2005119 qui a des infos ccp ds l'annuair emais pas pour notre concours et des  ensimag
		 if ($code_etu=='20051119' or $code_etu=='20051011'or $code_etu=='20051452'or $code_etu=='20050381')
		 {
		 $code_ccp='';
		       $erreurcode_ccp++;
		 }
		
 //pour chaque code etudiant on cree le code etu et le code ccp
            $query2 = "UPDATE  $table set `code-etu`='$code_etu',`code-ccp`='$code_ccp'  WHERE `Id. Établ.`='$id'";
           //echo $query2."| $gauche |$droite |$partie3| $partie4<br>\n ";
		$result2=mysql_query($query2,$connexion ); 
             $cree++;
}
 echo "<br>\n resultat ".$cree ." fiches on été modifiées<br>\n ";
       echo "<br>\n resultat ".$erreurcode_etu ." erreurs de code etu<br>\n ";
        echo "<br>\n resultat ".$erreurcode_ccp ."  code ccp vides <br>\n ";
        //   on met à jour la date et l'heure dans la table param
        echo "<br>\n et on met à jour la date et l'heure dans la table param <br>\n ";
        $query = "UPDATE param SET date_import_annu=now() WHERE config='1'";
       $result=mysql_query($query,$connexion ); 
 

mysql_close($connexion);
}
?>
