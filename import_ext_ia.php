<?
set_time_limit(60);
require ("param.php");
require ("function.php");
// acces uniquement en ligne de commande :
if (!isset($_SERVER['PHP_AUTH_USER']))
//	if(1)
{
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$sql1='';
$sql2='';
$table="etudiants";
$message_mail='';
$message_mail2='';
//on cree un tableau $champs[] avec les noms des colonnes de la table
$tabletemp="etudiants";
$champs=champsfromtable($tabletemp);
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
$tabletemp="ext_ia_";
$champs2=champsfromtable($tabletemp);
foreach($champs2 as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}
// $tabletemp="ext_ia_oldformat";
// $champs3=champsfromtable($tabletemp);
// foreach($champs3 as $ci){
// $ci2=nettoiechamps($ci,$tabletemp);
// $$ci2=$ci;
//}
//-----------------------v�rification des inscriptions annul�es --------------------
// on explore �tudiants pour l'ann�e en cours et on v�rifie pour chacun qu'il existe dans ext_ia_
echo " 1-v�rification des annulations <br> ";
$message_mail .= " 1-v�rification des annulations \n ";
$sqlquery="SELECT * FROM etudiants where `Ann�e Univ` = '".($annee_courante-1)."'  ";
$resultat=mysql_query($sqlquery,$connexion ); 
$totannee=0;
$annulations=0;
$messannulmail='';
$messannul='';
while ($e=mysql_fetch_object($resultat)){
	$totannee++;
	$sqlquery2="SELECT * FROM ext_ia_  where `code etu`='".$e->$myext_ia_code_etu."' and `Code �tape` ='".$e->$myext_ia_code_�tape."'";
	$resultat2=mysql_query($sqlquery2,$connexion ); 

	if (mysql_num_rows($resultat2) ==0  )
	{
		// il faut v�rifier si l'etud est inscrit dans une VETs GI , sinon  on ne consid�re pas que c'est une annulation ( il a �t� inscrit via un import extia local )
		if (in_array($e->$myext_ia_code_�tape,$vetsGi))
		{
		$annulations ++ ;
		$messannul .=  $e->$myext_ia_code_etu .' '.$e->$myext_ia_nom.' <br> ';
		$messannulmail.=  $e->$myext_ia_code_etu .' '.$e->$myext_ia_nom."\n ";
		}
	}
	
}
echo "il y a " .$totannee ." inscriptions pour ".($annee_courante-1)." dans la table 1ere inscription etudiants<br>";
$message_mail .="il y a " .$totannee ." etudiants pour ".($annee_courante-1)." dans la table 1ere inscription etudiants\n";
if ($annulations)
{
echo "d'apr�s l'export ext_ia du jour  : il y a " .$annulations ." annulation(s) pour cette annee universitaire dans la table etudiants : <br>";
echo $messannul;
$message_mail .= "d'apr�s l'export ext_ia du jour  : il y a " .$annulations ." annulation(s) pour cette annee universitaire dans la table etudiants :\n";
$message_mail .=$messannulmail;
}
else
{
echo "il n'y a pas d'annulation d'inscription d�tect�e <br>";
$message_mail .="il n'y a pas d'annulation d'inscription d�tect�e \n";
}

// on explore insciption_sup pour l'ann�e en cours et on v�rifie pour chacun qu'il existe dans ext_ia_
echo " 2-v�rification des annulations 2eme inscription<br> ";
$message_mail .= " 1-v�rification des annulations 2eme inscription \n ";
$sqlquery="SELECT * FROM inscription_sup where `Ann�e Univ` = '".($annee_courante-1)."'  ";
$resultat=mysql_query($sqlquery,$connexion ); 
$totannee2=0;
$annulations2=0;
$messannulmail2='';
$messannul2='';
while ($e=mysql_fetch_object($resultat)){
	$totannee2++;
	$sqlquery2="SELECT * FROM ext_ia_  where `code etu`='".$e->$myext_ia_code_etu."' and `Code �tape` ='".$e->$myext_ia_code_�tape."'";
	//echo $sqlquery2."<br>";
	$resultat2=mysql_query($sqlquery2,$connexion ); 

	if (mysql_num_rows($resultat2) ==0  )
	{
		// il faut v�rifier si l'etud est inscrit dans une VETs GI , sinon  on ne consid�re pas que c'est une annulation ( il a �t� inscrit via un import extia local )
		if (in_array($e->$myext_ia_code_�tape,$vetsGi))
		{
		$annulations2 ++ ;
		$messannul2 .=  $e->$myext_ia_code_etu .' '.$e->$myext_ia_nom.' <br> ';
		$messannulmail2.=  $e->$myext_ia_code_etu .' '.$e->$myext_ia_nom."\n ";
		}
		//else echo 'test';
	}
	
}


echo "il y a " .$totannee2 ." inscriptions  pour ".($annee_courante-1)." dans la table 2eme inscription etudiants<br>";
$message_mail .="il y a " .$totannee2 ." etudiants pour ".($annee_courante-1)." dans la table  2eme inscription etudiants\n";
if ($annulations2)
{
echo "d'apr�s l'export ext_ia du jour  : il y a " .$annulations2 ." annulation(s) pour cette annee universitaire dans la table  2eme inscription etudiants : <br>";
echo $messannul2;
$message_mail .= "d'apr�s l'export ext_ia du jour  : il y a " .$annulations2 ." annulation(s) pour cette annee universitaire dans la table 2eme inscription etudiants  :\n";
$message_mail .=$messannulmail2;
}
else
{
echo "il n'y a pas d'annulation de 2eme inscription d�tect�e <br>";
$message_mail .="il n'y a pas d'annulation de 2eme inscription d�tect�e \n";
}	



//--------------------------------- import dans  etudiants 
echo"<br>3-import ext_ia en cours ...";
echo"<br>maintenant on importe depuis la table d'import ...";
$reinsc=0;
$reinsc_sup=0;
$cree=0;
$erreur=0;
$supp=0;
$new=0;
$cree_insc_sup=0;
$erreur_insc_sup=0;
$supp_insc_sup=0;
$new_insc_sup=0;

//on parcourt le fichier import-apogee
$sqlquery="SELECT * FROM ext_ia_  ";
$resultat=mysql_query($sqlquery,$connexion ); 
//pour chaque enregistrement
//$hash=0;
$tot=0;
while ($e=mysql_fetch_object($resultat)){
	$tot++;
	$code_etu_import=$e->$myext_ia_code_etu;
	$code_vet_import=$e->$myext_ia_code_vet;
	$code_etape_import=$e->$myext_ia_code_�tape;	
	$annee_univ_import=$e->$myext_ia_ann�e_univ;
	//on teste si le code etudiant+�tape +annee existe deja dans la table etudiant dans ce cas c'est une mise � jour 

	$sqlquery2="SELECT * FROM $table where (`code etu`='". $code_etu_import ."' and `Code �tape` ='".$code_etape_import."' and `Ann�e Univ` ='".$annee_univ_import.
	"')  ";
	
	$resultat2=mysql_query($sqlquery2,$connexion ); 
	// si oui 
	 if (mysql_num_rows( $resultat2)!=0){
		//  on efface l'enregistrement dans etudiants
		$sqlquery3="DELETE FROM $table where (`code etu`='". $code_etu_import ."' and `Code �tape` ='".$code_etape_import."' and `Ann�e Univ` ='".$annee_univ_import.
	"')  ";
		//echo $sqlquery3;
		$resultat3=mysql_query($sqlquery3,$connexion ); 
		$supp++;
		// et on insere l'import  dans etudiants
		foreach($champs as $ci2){
		$cibon= str_replace("'","''",$e->$ci2);
		 $sql1.= "`".$ci2."`,";
		 $sql2.= "'".$cibon."',";
		 }
		 //il faut enlever la virgule de la fin
		 $sql1=substr($sql1,0,strlen($sql1)-1) ;
		  $sql2=substr($sql2,0,strlen($sql2)-1) ;
			$query = "INSERT INTO $table($sql1)";
		   $query .= " VALUES($sql2)";
		  //echo $query;
		 //echo "<br>___________________<br>";
		  $resultat5=mysql_query($query,$connexion ); 
			   if ($resultat5){$cree++;}
		   else {
			$erreur++;
			} 
		$sql1='';
		$sql2='';
	}
		//sinon on on teste si le code etu existe mais pas pour l'ann�e courante , c'est une r�inscription
	else
	{	
	$sqlquery2="SELECT * FROM $table  where 
	 `code etu`='". $code_etu_import."' and `Ann�e Univ` !='".$annee_univ_import."'  ";
	
	$resultat2=mysql_query($sqlquery2,$connexion ); 
	// si oui 
	 if (mysql_num_rows( $resultat2)!=0){
		 
		 
		 		echo "<br> r�inscription de : ".$e->Nom. " inscrit en ".$e->$myext_ia_lib_�tape. " le ".$e->$myext_ia_date_iae;
				$message_mail.="R�inscription de : ".$e->Nom. " inscrit en ".$e->$myext_ia_lib_�tape. " le ".$e->$myext_ia_date_iae."\n";			

		 
		// on efface l'enregistrement dans etudiants
		$sqlquery3="DELETE FROM $table where  `code etu`='". $code_etu_import."' and `Ann�e Univ` !='".$annee_univ_import."'  ";
	
		//echo $sqlquery3;
		$resultat3=mysql_query($sqlquery3,$connexion ); 
		$reinsc_sup++;
		// et on insere l'import  dans etudiants
		foreach($champs as $ci2){
		$cibon= str_replace("'","''",$e->$ci2);
		 $sql1.= "`".$ci2."`,";
		 $sql2.= "'".$cibon."',";
		 }
		 //il faut enlever la virgule de la fin
		 $sql1=substr($sql1,0,strlen($sql1)-1) ;
		  $sql2=substr($sql2,0,strlen($sql2)-1) ;
			$query = "INSERT INTO $table($sql1)";
		   $query .= " VALUES($sql2)";
		  //echo $query;
		 //echo "<br>___________________<br>";
		  $resultat5=mysql_query($query,$connexion ); 
			   if ($resultat5){$reinsc++;}
		   else {
			$erreur++;
			} 
		$sql1='';
		$sql2='';	
		
	 }
	//sinon on on teste si le code etudiant+�tape+annee existe deja dans la table inscription_sup 
	//dans ce cas c'est une mise � jour de la 2eme inscription
	else
	{	
	$sqlquery7="SELECT * FROM inscription_sup where `code etu`='". $code_etu_import ."' and `Code �tape` ='".$code_etape_import."' and `Ann�e Univ` ='".$annee_univ_import."' ";
	$resultat7=mysql_query($sqlquery7,$connexion ); 
	// si oui 
	 if (mysql_num_rows( $resultat7)!=0){
		// on efface l'enregistrement dans inscription_sup
		$sqlquery8="DELETE FROM inscription_sup where `code etu`='". $code_etu_import ."' and `Code �tape` ='".$code_etape_import."' and `Ann�e Univ` ='".$annee_univ_import."' ";
		//echo $sqlquery3;
		$resultat8=mysql_query($sqlquery8,$connexion ); 
		$supp_insc_sup++;
		// et on  insere l'import  dans inscription_sup
		foreach($champs as $ci2){
		$cibon= str_replace("'","''",$e->$ci2);
		 $sql1.= "`".$ci2."`,";
		 $sql2.= "'".$cibon."',";
		 }
		 //il faut enlever la virgule de la fin
		 $sql1=substr($sql1,0,strlen($sql1)-1) ;
		  $sql2=substr($sql2,0,strlen($sql2)-1) ;
			$query = "INSERT INTO inscription_sup($sql1)";
		   $query .= " VALUES($sql2)";
		  //echo $query;
		 //echo "<br>___________________<br>";
		  $resultat9=mysql_query($query,$connexion ); 
			   if ($resultat9){$cree_insc_sup++;}
		   else {
			$erreur_insc_sup++;
			} 
		$sql1='';
		$sql2='';	
		
	 }
	 else
		 // on teste si le code etu existe pour l'annee courante dans etudiants ( �tape diff�rente)
		//	 c'est une double inscription
	 {
	$sqlquery20="SELECT * FROM $table where `code etu`='". $code_etu_import ."' and `Code �tape` !='".$code_etape_import."' and `Ann�e Univ` ='".$annee_univ_import."' ";
	$resultat20=mysql_query($sqlquery20,$connexion ); 
	// si oui 
		if (mysql_num_rows( $resultat20)!=0){
		//on insere dans inscription_sup
			 echo "<br> nouveau double inscription pour : ".$e->Nom. " inscrit en ".$e->$myext_ia_lib_�tape. " le ".$e->$myext_ia_date_iae;
			$message_mail.="nouveau double inscription  pour : ".$e->Nom. " inscrit en ".$e->$myext_ia_lib_�tape. " le ".$e->$myext_ia_date_iae."\n";		
	 		// et on  insere l'import  dans inscription_sup
		foreach($champs as $ci2){
		$cibon= str_replace("'","''",$e->$ci2);
		 $sql1.= "`".$ci2."`,";
		 $sql2.= "'".$cibon."',";
		 }
		 //il faut enlever la virgule de la fin
		 $sql1=substr($sql1,0,strlen($sql1)-1) ;
		  $sql2=substr($sql2,0,strlen($sql2)-1) ;
			$query = "INSERT INTO inscription_sup($sql1)";
		   $query .= " VALUES($sql2)";
		  //echo $query;
		 //echo "<br>___________________<br>";
		  $resultat9=mysql_query($query,$connexion ); 
			   if ($resultat9){$new_insc_sup++;}
		   else {
			$erreur_insc_sup++;
			} 
		$sql1='';
		$sql2='';	
		 
		 
		}
		else
		{
			// on teste si le code etu n'existe pas  dans etudiants c'est une premiere  inscription
			$sqlquery20="SELECT * FROM $table where `code etu`='". $code_etu_import."' ";
	$resultat20=mysql_query($sqlquery20,$connexion ); 
	// si oui 
		if (mysql_num_rows( $resultat20)==0){
		// c'est un nouveau on l'insere dans etudiants
		
				 echo "<br> nouveau inscription de : ".$e->Nom. " inscrit en ".$e->$myext_ia_lib_�tape. " le ".$e->$myext_ia_date_iae;
				$message_mail.="nouveau inscription de : ".$e->Nom. " inscrit en ".$e->$myext_ia_lib_�tape. " le ".$e->$myext_ia_date_iae."\n";			
				// et on insere l'import  dans etudiants
				foreach($champs as $ci2){
				$cibon= str_replace("'","''",$e->$ci2);
				 $sql1.= "`".$ci2."`,";
				 $sql2.= "'".$cibon."',";
				 }
				 //il faut enlever la virgule de la fin
				 $sql1=substr($sql1,0,strlen($sql1)-1) ;
				  $sql2=substr($sql2,0,strlen($sql2)-1) ;
					$query = "INSERT INTO $table($sql1)";
				   $query .= " VALUES($sql2)";
				  //echo $query;
				 echo "<br>___________________<br>";
				  $resultat5=mysql_query($query,$connexion ); 
					   if ($resultat5){ $new++;}
				   else {
					$erreur++;
					} 
				$sql1='';
				$sql2='';
				}
		
			}
	   }
		
	}
			

}

            
} // fin du while 

echo "<br>resultat ".$reinsc_sup ." fiches effac�es pour reinsc<br>\n";
echo "resultat ".$reinsc ."  r�inscription <br>\n";

echo "<br>resultat ".$supp ." fiches effac�es pour maj<br>\n";
echo "resultat ".$cree ." maj dans etudiants  <br>\n";
echo "resultat ".$new ." fiches nouvelles dans etudiants<br>\n";
echo "resultat ".$erreur ." erreurs lors de l'insertion dans etudiants<br>\n";

echo "<br>resultat ".$supp_insc_sup ." fiches effac�es pour maj dans insc sup <br>\n";
echo "resultat ".$cree_insc_sup ." maj dans insc sup <br>\n";
echo "resultat ".$new_insc_sup ." fiches nouvelles dans insc sup<br>\n";
echo "resultat ".$erreur_insc_sup ." erreurs lors de l'insertion  dans insc sup <br>\n";
// si on avait rien dans la table c'est que l'alim DSI n'avait pas �t� faite
if (!$tot)
{
	echo "probl�me lors de la synchro du  ".date('d-m-y h:i').": table ext_ia vide \n ";
		$message_mail.=" probl�me lors de la synchro du  ".date('d-m-y h:i')." : la table ext_ia est vide \n 
elle aurait d� �tre aliment�e par le job Talend ApogeeToBaseEleveGI lanc� quotidiennement par la DSI � 07h57 sur la machine estages.grenoble-inp.fr \n ";
		 $objet='ERREUR synchro auto apogee-base �l�ves GI : table ext_ia vide ';
				$message_dest='';
				// envoimail($message_dest,$objet,$message_mail);
				
				$message_dest.='gi-dev@grenoble-inp.fr,bruno.ferrari@grenoble-inp.fr';	
					 envoimail($message_dest,$objet,$message_mail);					
}
else
{


		//echo " r�sultat de la synchro du  ".date('d-m-y h:i')."\n".$cree ." fiches enregistr�es\n".$supp ." fiches existaient d�j� et ont pu �tre modifi�es\n".$new ." fiche(s) nouvelle(s)\n".$erreur ." erreurs<br>\n";		
		//echo "\n".$cree_insc_sup ." fiches enregistr�es comme double insciption\n".$supp_insc_sup ." fiches double insciption existaient d�j� et ont pu �tre modifi�es\n".$new_insc_sup ." fiche(s) nouvelle(s) double insciption \n".$erreur_insc_sup ." erreurs double insciption<br>\n";		
		
		$message_mail.="\n 2-r�sultat de la synchro du  ".date('d-m-y h:i')."\n".$cree ." fiches enregistr�es\n".$supp ." fiches existaient d�j� et ont pu �tre modifi�es\n".$new ." fiche(s) nouvelle(s) \n".$erreur ." erreurs";
		$message_mail.="\n".$reinsc ." fiches enregistr�es comme r�insciption\n";			
		$message_mail.="\n".$cree_insc_sup ." fiches enregistr�es comme double insciption\n".$supp_insc_sup ." fiches double insciption existaient d�j� et ont pu �tre modifi�es\n".$new_insc_sup ." fiche(s) nouvelle(s) double insciption \n".$erreur_insc_sup ." erreurs double insciption<br>\n";		
	


		 $objet='synchro auto apogee-base �l�ves : nouvelle(s) inscription(s)';
				$message_dest='';
				// envoimail($message_dest,$objet,$message_mail);
				foreach($scol_user_liste as $ci){
					$temp=ask_ldap($ci,'mail');
					if ($ci!='administrateur' and $ci!='viardch' ){
					$message_dest.=',';
					$message_dest.=$temp[0];
					}
				}
				$message_dest.=',';
				$message_dest.='gi-dev@grenoble-inp.fr,sigi.etu@grenoble-inp.fr';
				// pour les tests
				//$message_dest='marc.patouillard@grenoble-inp.fr';
				// on envoie � la scol que s'il y a des nouvelles inscriptions ou des nouvelles double inscriptinos  ou des reinscriptions
		if ($new != 0 or $new_insc_sup != 0  or $reinsc != 0 or $annulations != 0 or $annulations2 != 0)
		{
		 envoimail($message_dest,$objet,$message_mail);
		 }
}
// on vide ext_ia pour d�tecter le d�faut d'alimentation  �ventuel lors de la  prochaine ex�cution
$sqlquery="delete  FROM ext_ia_  ";
$resultat=mysql_query($sqlquery,$connexion );
//echo "on vide la table ext_ia";
mysql_close($connexion);
}
else echo "acc�s interdit";
?>
