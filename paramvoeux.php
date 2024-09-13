
<?php


// pour les campagnes de voeux il faut récupérer les valeurs dans la table param_voeux

// On se connecte
error_reporting(E_ALL ^ E_NOTICE);  
$cnx =Connexion ($user_sql, $password, $dsn, $host);
$tableparam="param_voeux";
//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille
$resultparam = mysql_query("SHOW COLUMNS FROM $tableparam",$cnx );
if (!$resultparam) {
   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
   exit;
}
if (mysql_num_rows($resultparam) > 0) {
   while ($row = mysql_fetch_assoc($resultparam)) {

      $champsparam[]= $row["Field"];
	  $typeparam[]= $row["Type"];
   }
}
//on remplit 2 tableaux avec les nom-code  groupes
$sqlquery2param="SELECT groupes.* FROM groupes ";
//echo $sqlquery2;
$resultat2param=mysql_query($sqlquery2param,$cnx ); 
while ($vparam=mysql_fetch_array($resultat2param))
	{
	$ind2param=$vparam["code"];
	$groupe_libelleparam[$ind2param]=$vparam["libelle"];	
	}
	
// on récupère les données
$queryparam = "SELECT * FROM $tableparam ";
$resultparam = mysql_query($queryparam,$cnx ); 
while($uparam=mysql_fetch_object($resultparam)) {
 foreach($champsparam as $ci2){
   $$ci2=$uparam->$ci2;
   if (in_array ($ci2 ,$liste_champs_dates_paramvoeux))
		 {
		 //on transforme les dates sql en dd/mm/yy
		  $$ci2=mysql_DateTime($uparam->$ci2);
		 }
 }
 // on affecte les données des champs de la table aux variable de paramcommun
switch ($numero_campagne)
{
 case '1':
	 $idsondage1=$idsondage;
	 $datedebutvoeux1=$datedebutvoeux;
	 $datelimitevoeux1=$datelimitevoeux;
	 $datelimitevoeux1RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin1=$datefinvoeuxadmin;
	 $titrevoeux1=$titrevoeux;
	 $gpecible1=$groupe_libelleparam[$gpecible];
	 $lienvoeux1="<center><a href=voeux.php>". $titrevoeux1."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste1=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste1[]=$u->ligne_user_voeux_uid;
	 }
	  break;
 case '2':
	 $idsondage2=$idsondage;
	 $datedebutvoeux2=$datedebutvoeux;
	 $datelimitevoeux2=$datelimitevoeux;
	 $datelimitevoeux2RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin2=$datefinvoeuxadmin;
	 $titrevoeux2=$titrevoeux;
	 $gpecible2=$groupe_libelleparam[$gpecible];
	 $lienvoeux2="<center><a href=voeux2.php>". $titrevoeux2."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste2=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste2[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
 case '3':
	 $idsondage3=$idsondage;
	 $datedebutvoeux3=$datedebutvoeux;
	 $datelimitevoeux3=$datelimitevoeux;
	 $datelimitevoeux3RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin3=$datefinvoeuxadmin;
	 $titrevoeux3=$titrevoeux;
	 $gpecible3=$groupe_libelleparam[$gpecible];
	 $lienvoeux3="<center><a href=voeux3.php>". $titrevoeux3."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste3=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste3[]=$u->ligne_user_voeux_uid;
	 }	
	 $query = "SELECT * FROM param_camp3_reponses order by param_camp3_reponses_ordre";
	 $result = mysql_query($query,$cnx ); 
	 $tabrep_voeux_parcours[]='NC';
	 while($u=mysql_fetch_object($result)) {
	 $tabrep_voeux_parcours[]=$u->param_camp3_reponses_libelle;
	 }	
	$query = "SELECT * FROM param_camp3_parcours order by param_camp3_parcours_ordre";
	 $result = mysql_query($query,$cnx ); 
	 $tabparcours3[]='NC';
	 while($u=mysql_fetch_object($result)) {
	 $tabparcours3[]=$u->param_camp3_parcours_libelle;
	 }	

	 
	  break;
 case '4':
	 $idsondage4=$idsondage;
	 $datedebutvoeux4=$datedebutvoeux;
	 $datelimitevoeux4=$datelimitevoeux;
	 $datelimitevoeux4RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin4=$datefinvoeuxadmin;
	 $titrevoeux4=$titrevoeux;
	 $gpecible4=$groupe_libelleparam[$gpecible];
	 $lienvoeux4="<center><a href=voeux4.php>". $titrevoeux4."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste4=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste4[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
 case '5':
	 $idsondage5=$idsondage;
	 $datedebutvoeux5=$datedebutvoeux;
	 $datelimitevoeux5=$datelimitevoeux;
	 $datelimitevoeux5RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin5=$datefinvoeuxadmin;
	 $titrevoeux5=$titrevoeux;
	 $gpecible5=$groupe_libelleparam[$gpecible];
	 $lienvoeux5="<center><a href=voeux5.php>". $titrevoeux5."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste5=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste5[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	  
 case '6':
	 $idsondage6=$idsondage;
	 $datedebutvoeux6=$datedebutvoeux;
	 $datelimitevoeux6=$datelimitevoeux;
	 $datelimitevoeux6RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin6=$datefinvoeuxadmin;
	 $titrevoeux6=$titrevoeux;
	 $gpecible6=$groupe_libelleparam[$gpecible];
	 $lienvoeux6="<center><a href=voeux6.php>". $titrevoeux6."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste6=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste6[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
 case '7':
	 $idsondage7=$idsondage;
	 $datedebutvoeux7=$datedebutvoeux;	 
	 $datelimitevoeux7=$datelimitevoeux;
	 $datelimitevoeux7RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin7=$datefinvoeuxadmin;
	 $titrevoeux7=$titrevoeux;
	 $gpecible7=$groupe_libelleparam[$gpecible];
	 $lienvoeux7="<center><a href=voeux7.php>". $titrevoeux7."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste7=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste7[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	 
 case '8':
	 $idsondage8=$idsondage;
	 $datedebutvoeux8=$datedebutvoeux;
	 $datelimitevoeux8=$datelimitevoeux;
	 $datelimitevoeux8RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin8=$datefinvoeuxadmin;
	 $titrevoeux8=$titrevoeux;
	 $gpecible8=$groupe_libelleparam[$gpecible];
	 $lienvoeux8="<center><a href=voeux8.php>". $titrevoeux8."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste8=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste8[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
 case '9':
	 $idsondage9=$idsondage;
	 $datedebutvoeux9=$datedebutvoeux;
	 $datelimitevoeux9=$datelimitevoeux;
	 $datelimitevoeux9RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin9=$datefinvoeuxadmin;
	 $titrevoeux9=$titrevoeux;
	 $gpecible9=$groupe_libelleparam[$gpecible];
	 $lienvoeux9="<center><a href=voeux9.php>". $titrevoeux9."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste9=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste9[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
 case '10':
	 $idsondage10=$idsondage;
	 $datedebutvoeux10=$datedebutvoeux;
	 $datelimitevoeux10=$datelimitevoeux;
	 $datelimitevoeux10RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin10=$datefinvoeuxadmin;
	 $titrevoeux10=$titrevoeux;
	 $gpecible10=$groupe_libelleparam[$gpecible];
	 $lienvoeux10="<center><a href=voeux10.php>". $titrevoeux10."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste10=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste10[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	  
case '11':
	 $idsondage11=$idsondage;
	 $datedebutvoeux11=$datedebutvoeux;
	 $datelimitevoeux11=$datelimitevoeux;
	 $datelimitevoeux11RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin11=$datefinvoeuxadmin;
	 $titrevoeux11=$titrevoeux;
	 $gpecible11=$groupe_libelleparam[$gpecible];
	 $lienvoeux11="<center><a href=voeux11.php>". $titrevoeux11."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste11=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste11[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;		  
case '12':
	 $idsondage12=$idsondage;
	 $datedebutvoeux12=$datedebutvoeux;
	 $datelimitevoeux12=$datelimitevoeux;
	 $datelimitevoeux12RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin12=$datefinvoeuxadmin;
	 $titrevoeux12=$titrevoeux;
	 $gpecible12=$groupe_libelleparam[$gpecible];
	 $lienvoeux12="<center><a href=voeux12.php>". $titrevoeux12."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste12=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste12[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;
case '13':
	 $idsondage13=$idsondage;
	 $datedebutvoeux13=$datedebutvoeux;
	 $datelimitevoeux13=$datelimitevoeux;
	 $datelimitevoeux13RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin13=$datefinvoeuxadmin;
	 // spécial campagne 13
	 $dateRestitution13=$dateRestitution;
	 $titrevoeux13=$titrevoeux;
	 $gpecible13=$groupe_libelleparam[$gpecible];
	 $lienvoeux13="<center><a href=voeux13.php>". $titrevoeux13."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste13=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste13[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
case '14':
	 $idsondage14=$idsondage;
	 $datedebutvoeux14=$datedebutvoeux;
	 $datelimitevoeux14=$datelimitevoeux;
	 $datelimitevoeux14RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin14=$datefinvoeuxadmin;
	 $titrevoeux14=$titrevoeux;
	 $gpecible14=$groupe_libelleparam[$gpecible];
	 $lienvoeux14="<center><a href=voeux14.php>". $titrevoeux14."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste14=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste14[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;
case '15':
	 $idsondage15=$idsondage;
	 $datedebutvoeux15=$datedebutvoeux;
	 $datelimitevoeux15=$datelimitevoeux;
	 $datelimitevoeux15RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin15=$datefinvoeuxadmin;
	 // spécial campagne 15
	 $dateRestitution15=$dateRestitution;
	 $titrevoeux15=$titrevoeux;
	 $gpecible15=$groupe_libelleparam[$gpecible];
	 $lienvoeux15="<center><a href=voeux15.php>". $titrevoeux15."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste15=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste15[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;
case '16':
	 $idsondage16=$idsondage;
	 $datedebutvoeux16=$datedebutvoeux;
	 $datelimitevoeux16=$datelimitevoeux;
	 $datelimitevoeux16RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin16=$datefinvoeuxadmin;
	 $titrevoeux16=$titrevoeux;
	 $gpecible16=$groupe_libelleparam[$gpecible];
	 $lienvoeux16="<center><a href=voeux16.php>". $titrevoeux16."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste16=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste16[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
case '17':
	 $idsondage17=$idsondage;
	 $datedebutvoeux17=$datedebutvoeux;
	 $datelimitevoeux17=$datelimitevoeux;
	 $datelimitevoeux17RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin17=$datefinvoeuxadmin;
	 $titrevoeux17=$titrevoeux;
	 $gpecible17=$groupe_libelleparam[$gpecible];
	 $lienvoeux17="<center><a href=voeux17.php>". $titrevoeux17."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste17=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste17[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;
 case '18':
	 $idsondage18=$idsondage;
	 $datedebutvoeux18=$datedebutvoeux;
	 $datelimitevoeux18=$datelimitevoeux;
	 $datelimitevoeux18RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin18=$datefinvoeuxadmin;
	 $titrevoeux18=$titrevoeux;
	 $gpecible18=$groupe_libelleparam[$gpecible];
	 $lienvoeux18="<center><a href=voeux18.php>". $titrevoeux18."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste18=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste18[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;
 case '19':
	 $idsondage19=$idsondage;
	 $datedebutvoeux19=$datedebutvoeux;
	 $datelimitevoeux19=$datelimitevoeux;
	 $datelimitevoeux19RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin19=$datefinvoeuxadmin;
	 $titrevoeux19=$titrevoeux;
	 $gpecible19=$groupe_libelleparam[$gpecible];
	 $lienvoeux19="<center><a href=voeux19.php>". $titrevoeux19."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste19=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste19[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;  	
case '20':
	 $idsondage20=$idsondage;
	 $datedebutvoeux20=$datedebutvoeux;
	 $datelimitevoeux20=$datelimitevoeux;
	 $datelimitevoeux20RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin20=$datefinvoeuxadmin;
	 $titrevoeux20=$titrevoeux;
	 $gpecible20=$groupe_libelleparam[$gpecible];
	 $lienvoeux20="<center><a href=voeux20.php>". $titrevoeux20."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste20=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste20[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;	
case '21':
	 $idsondage21=$idsondage;
	 $datedebutvoeux21=$datedebutvoeux;
	 $datelimitevoeux21=$datelimitevoeux;
	 $datelimitevoeux21RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin21=$datefinvoeuxadmin;
	 $titrevoeux21=$titrevoeux;
	 $gpecible21=$groupe_libelleparam[$gpecible];
	 $lienvoeux21="<center><a href=voeux21.php>". $titrevoeux21."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste21=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste21[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;  
case '22':
	 $idsondage22=$idsondage;
	 $datedebutvoeux22=$datedebutvoeux;
	 $datelimitevoeux22=$datelimitevoeux;
	 $datelimitevoeux22RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin22=$datefinvoeuxadmin;
	 $titrevoeux22=$titrevoeux;
	 $gpecible22=$groupe_libelleparam[$gpecible];
	 $lienvoeux22="<center><a href=voeux22.php>". $titrevoeux22."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste22=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste22[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;  
case '23':
	 $idsondage23=$idsondage;
	 $datedebutvoeux23=$datedebutvoeux;
	 $datelimitevoeux23=$datelimitevoeux;
	 $datelimitevoeux23RO=$datelimitevoeuxRO;
	 $datefinvoeuxadmin23=$datefinvoeuxadmin;
	 $titrevoeux23=$titrevoeux;
	 $gpecible23=$groupe_libelleparam[$gpecible];
	 $lienvoeux23="<center><a href=voeux23.php>". $titrevoeux23."</a></center>";
	 $query = "SELECT * FROM ligne_user_voeux where ligne_user_voeux_vid = '".$idsondage."' ";
	 $result = mysql_query($query,$cnx ); 
	 	 $voeux_liste23=array('administrateur');
	 while($u=mysql_fetch_object($result)) {
	 $voeux_liste23[]=$u->ligne_user_voeux_uid;
	 }	 
	  break;  	  
 }
}

// on ferme la connexion
  mysql_close($cnx);
?>

