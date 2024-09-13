<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>
<?

//on filtre tous les arg reçus en get

    foreach($_GET AS $key => $value) {
		        // On regarde si le type de arg  est une string
        if(is_string($value))
		{
		$_GET[$key] = 	htmlentities($value, ENT_QUOTES, 'ISO8859-1',false);
		
		}
		// on regarde si c'est un tableau
		if (is_array($value))
		{
			//dans ce cas on nettoie chaque ligne du tableau si c'est une string
	        if(is_string($value))
				{		
					foreach($value AS $cle => $valeur) {
					$_GET[$cle] = 	htmlentities($valeur, ENT_QUOTES, 'ISO8859-1',false);			
					}
				}		
		}
    }
//print_r($_GET);
//on filtre tous les arg reçus en Post

    foreach($_POST AS $key => $value) {
		        // On regarde si le type de arg  est une string
        if(is_string($value))
		{		
		$_POST[$key] =htmlentities($value, ENT_QUOTES, 'ISO8859-1',false);
		}
		// on regarde si c'est un tableau
		if (is_array($value))
		{
			//dans ce cas on nettoie chaque ligne du tableau si c'est une string
	        if(is_string($value))
				{		
					foreach($value AS $cle => $valeur) {
					$_GET[$cle] = 	htmlentities($valeur, ENT_QUOTES, 'ISO8859-1',false);			
					}
				}		
		}		
    }
//print_r($_POST);



//attention il ne doit pas y avoir de nom de colonnes identiques
// il doit y avoir un index unique (auto incrémental ou pas ) dans chaque fichier
// si on a un seul fichier laisser les infos $cleetrangere2 $table2  $cleprimaire2 à vide
// si on veut auroriser tout le monde laisser des array vides 
//---paramètres à configurer
//$dsn="eleves_dbo_bis";
//$user_sql="qualiteuser";
//$password='test2014';
//$host="localhost";
$texte_table='table des périodes d\'envoi ';
$table="periodes_departs";
$cleprimaire='pdp_idPdp';
$autoincrement='pdp_idPdp';
$cleetrangere2='';
$table2="";
$cleprimaire2='';
$cleetrangere3='';
$table3="";
$cleprimaire3='';
// pour la gestion des champs modifpar et date_modif
//laissez vide si pas géré
$champ_date_modif='date_modif';
$champ_modifpar='modifpar';

$liste_champs_lies2=array('');
$liste_champs_lies3=array();
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout2=array();
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout3=array();
$champsobligatoires=array('pdp_libelle');
$liste_champs_dates=array();
$liste_champs_tableau=array('pdp_idPdp','pdp_libelle','pdp_nouveautype');
// nom des en tetes du tableau à substituer si commentaire de mysql vides
//dans l'ordre on regarde le tableau $liste_libelles_tableau, puis le commentaire sql sinon on prend le nom du champs
$liste_libelles_tableau=array('pdp_idPdp'=>'code','pdp_libelle'=>'nom période','pdp_nouveautype'=>'pour voeux');
// nom des champs à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ sinon on prend le nom du champs
//$liste_libelles_champ=array('ref'=>'reference','date_delai'=>'delai');
$liste_libelles_champ=array();
$tri_initial=$cleprimaire;
$login_autorises=array('administrateur','dehemchn');
$login_autorises_ajout=array('administrateur','dehemchn');
$login_autorises_suppression=array('administrateur');
$login_autorises_modif=array('administrateur','dehemchn');
$login_autorises_export=array('administrateur','dehemchn');
$pageaccueil='default.php';
//---fin de configuration

echo "<head>";
echo "<title>".$texte_table."</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";
require ("function.php");
require ("style.php");
require ("param.php");
echo "</HEAD><BODY>" ;
// On se connecte à mysql classique ou  PDO
//$connexion =Connexion ($user_sql, $password, $dsn, $host);
$connexion =ConnexionPDO ($user_sql, $password, $dsn, $host);


if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
$message='';
$sql1='';
$sql2='';
$where='';
$orderby= '';
$filtre='';
$sens='';
//pdo
$sql1pdo='';
$sql2pdo='';
$tableaupdo=array();


   //seules les personnes autorisées ont acces à la liste
if(in_array($loginConnecte,$login_autorises) or empty($login_autorises) ){
	$affichetout=1;
}else
	{$affichetout=0;
	  echo affichealerte(" Vous n'êtes pas autorisé à consulter cette page");
	}
$URL =$_SERVER['PHP_SELF'];
//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille et leur commentaires
      $champs= champsfromtable ($table,$connexion);
	  $type= champstypefromtable ($table,$connexion);
	  $comment=champscommentfromtable ($table,$connexion);
// taille des champs 
		$taillechamp=champsindextaillefromtable($table,$connexion);
		// on cree un tableau indexé des longueurs par le nom des champs
		//$taillechamp=tabindextab($champs, $temp);

echo"<br>";
//array_map(function($a,$b){ global $taillechamp; $taillechamp[$a] = $b; }, $champs, $temp);
//$taillechamp=tabindextab($champs, $temp);


// on sauvegarde le tableau des champs sans les champs lies
$champsSingle=$champs;
if ($table2!='')
{
//on cree un tableau $champstable2[] avec les noms des colonnes de la table  et leur taille et leur commentaires
	
      $champstable2= champsfromtable ($table2,$connexion);
	  $typetable2= champstypefromtable ($table2,$connexion);
	  $commenttable2=champscommentfromtable ($table2,$connexion);
	  //$commenttable2=tabindextab($champstable2, $temp);	  
// taille des champs 
	$taillechamps2=champsindextaillefromtable($table2,$connexion);
	
foreach($liste_champs_lies2 as $champs_lie){
$champs[]=$champs_lie;
$comment[$champs_lie]=$commenttable2[$champs_lie];
$taillechamp[$champs_lie]=$taillechamps2[$champs_lie];
}
}
if ($table3!='')
{
//on cree un tableau $champstable3[] avec les noms des colonnes de la table  et leur taille et leur commentaires
	
      $champstable3= champsfromtable ($table3,$connexion);
	  $typetable3= champstypefromtable ($table3,$connexion);
	  $commenttable3=champscommentfromtable ($table3,$connexion);
	  //$commenttable2=tabindextab($champstable2, $temp);	  
// taille des champs 
	$taillechamps3=champsindextaillefromtable($table3,$connexion);
	
foreach($liste_champs_lies3 as $champs_lie){
$champs[]=$champs_lie;
$comment[$champs_lie]=$commenttable3[$champs_lie];
$taillechamp[$champs_lie]=$taillechamps3[$champs_lie];
}
}
// on vérifie que le $_GET['env_orderby'] est bien un champ de la table
If (!in_array(urldecode($_GET['env_orderby']),$champs)) $_GET['env_orderby']='';
if ($_GET['env_orderby']=='') {$orderby=$tri_initial ;}
	else{
	$orderby=urldecode($_GET['env_orderby']);
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
	//$orderby="ORDER BY ".$orderby;
                  if  ($_GET['env_inverse']=="1"){
                  $sens="desc";
                  }
	}
// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si autorisé
if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
// test valeurs obligatoires
	 $yaunvide=0;
	foreach($champsobligatoires as $champsobligatoire){
	 if (($_POST[$champsobligatoire]==''  )){
	 $yaunvide=1;
	}
	}
 if (!$yaunvide ){
	 if ($champ_modifpar!='')
	 {
		$_POST[$champ_modifpar]=$loginConnecte;
	 }
//valeur par defaut et pb des dates mysql

foreach($champsSingle as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }

// pour ne pas stocker du html dans la bdd
 $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2==$champ_date_modif){
 //$sql1.= $ci2.",";
 $sql1pdo.= $ci2.",";
 //$sql2.= "now(),";
 $sql2pdo.= "now(),"; 
 }
 elseif($ci2==$autoincrement)
 {
 // on ne fait rien
 }
  else{
 //$sql1.= $ci2.",";
 $sql1pdo.= $ci2.",";
 //$sql2.= "'".$_POST[$ci2]."',";
 $sql2pdo.= " :".$ci2.",";
 $tableaupdo[$ci2]=$_POST[$ci2];
 }
 }
 //il faut enlever les virgules de la fin
 //$sql1=substr($sql1,0,strlen($sql1)-1) ;
 $sql1pdo=substr($sql1pdo,0,strlen($sql1pdo)-1) ;
  //$sql2=substr($sql2,0,strlen($sql2)-1) ;
  $sql2pdo=substr($sql2pdo,0,strlen($sql2pdo)-1) ;  
  //  $query = "INSERT INTO $table($sql1)";
   //$query .= " VALUES($sql2)";
   $querypdo = "INSERT INTO $table($sql1pdo)";
   $querypdo .= " VALUES($sql2pdo)";
  //echo $query;
    //  $result = mysql_query($query,$connexion);
	  $req = $connexion->prepare($querypdo );
	  $res=$req->execute($tableaupdo);
       if ($res){
    $message = "Fiche <b>"." - ";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 
    }
   else{   // fin du nom=''
    echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
    }
    else{//debut du else $loginConnecte==
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $loginConnecte ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
  // $query = "DELETE FROM $table"
      //." WHERE ".$cleprimaire."='".$_GET['del']."'";
   //  echo $query;
   $pdoquery = $connexion->prepare("DELETE FROM $table  WHERE ".$cleprimaire."= :del");
   $res=	    $pdoquery->execute(array('del' =>$_GET['del'] ));
   //$result = mysql_query($query,$connexion);
   if($res){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
      else{
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $loginConnecte == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif)){
 
// test valeurs obligatoires
	 $yaunvide=0;
	foreach($champsobligatoires as $champsobligatoire){
	 if (($_POST[$champsobligatoire]==''  )){
	 $yaunvide=1;
	}
	}
 if (!$yaunvide ){
	 	 if ($champ_modifpar!='')
	 {
		$_POST[$champ_modifpar]=$loginConnecte;
	 }
//pour les dates

foreach($champsSingle as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }

		 			// pour ne pas stocker du html dans la bdd
 $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');
 //$_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));

if ($ci2==$champ_date_modif){
 //$sql1.= $ci2."=now(),";
  $sql1pdo.= $ci2."=now(),";
 }
  else{
 //$sql1.= $ci2."='".$_POST[$ci2]."',";
   $sql1pdo.= $ci2."= :".$ci2.",";
 $tableaupdo[$ci2]=$_POST[$ci2];
 }
 }

 //attention il faut enlever la virgule de la fin
 //$sql1=substr($sql1,0,strlen($sql1)-1) ;
 $sql1pdo=substr($sql1pdo,0,strlen($sql1pdo)-1) ;
  // $query = "UPDATE $table SET $sql1";
   //$query .= " WHERE ".$cleprimaire."='".$_POST[$cleprimaire]."' ";
  //echo $query;
$querypdo= "UPDATE $table SET $sql1pdo";
$querypdo .= " WHERE ".$cleprimaire."= :".$cleprimaire." ";
  // $result = mysql_query($query,$connexion);
 	//pdo	  
	$req = $connexion->prepare($querypdo );
	  $res= $req->execute($tableaupdo); 
   if($res){

   $message = "Fiche numero ".$_POST[$cleprimaire]." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ";
    }
	}
	else{
	echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
	}
	
   else{
   echo "<center><b>seul les utilisateurs autorisés peuvent effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $loginConnecte ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details
  if($table2=='')
  {
      // $query = "SELECT * FROM $table 
		//			  where ".$cleprimaire ." ='".$_GET['mod']."' ";
		$query = "SELECT * FROM $table 
					  WHERE ".$cleprimaire."= :mod";		  
	}
	elseif($table3=='')
  {
	$query = "SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere2 = $table2.$cleprimaire2 where ".$cleprimaire."= :mod";	
	}	
	else
	{
	$query = "SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere2 = $table2.$cleprimaire2 LEFT JOIN $table3 ON $table.$cleetrangere3 = $table3.$cleprimaire3  where ".$cleprimaire."= :mod";
	}
	$preparequery=$connexion->prepare($query);
					 // echo $query;
   $res=	    $preparequery->execute(array('mod' =>$_GET['mod'] ));					 
  //$result = mysql_query($query,$connexion );
$u =$preparequery->fetch(PDO::FETCH_OBJ);
   //on fait une boucle pour créer les variables issues de la table principale
   foreach($champs as $ci2){
   $$ci2=$u->$ci2;
   		   //on surcharge les dates pour les pbs de format
    if (in_array($ci2,$liste_champs_dates)){
 $$ci2=mysql_DateTime($u->$ci2);
 }
   }
   	 	 if ($champ_date_modif !='')
			 {
				$$champ_date_modif=mysql_Time($$champ_date_modif);
			 }
     echo    "<form method=post action=$URL> ";
  echo"<center>";
  echo"       <table><tr>  ";
	 echo "</tr><tr>";
	 foreach ($champs as $unchamps)
	 {
	 		 if ($comment[$unchamps]=='')
			 {
				if (array_key_exists($unchamps,$liste_libelles_champ) )
				{	
				$commentaire=$liste_libelles_champ[$unchamps];
				}else
				{	
				$commentaire=$unchamps;
				}
			 }else
			 {
			 $commentaire=$comment[$unchamps];
			 }
			 if(in_array($unchamps,$champsobligatoires))
			 {
				 $commentaire=$commentaire." (*) ";
			 } 	
		 // si on a une table liée
	  // if ($unchamps == $cleetrangere2 ){
	       // echo affichemenusqlplus($commentaire,$unchamps,$cleprimaire2,'select * from '.$table2 ,$liste_champs_lies_pour_formulaire_ajout2[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);

	  // }	 
	  
	  // elseif ($unchamps == $cleetrangere3 ){
	       // echo affichemenusqlplus($commentaire,$unchamps,$cleprimaire3,'select * from '.$table3 ,$liste_champs_lies_pour_formulaire_ajout3[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);

	  // }	
	 	 if ($unchamps == $cleprimaire or $unchamps == $cleetrangere2 or $unchamps == $cleetrangere3 or in_array($unchamps,$liste_champs_lies2) or in_array($unchamps,$liste_champs_lies3)){
		 // en lecture seule
		  if ($taillechamp[$unchamps]<120)
		 {
     echo affichechamp($commentaire,$unchamps,$$unchamps,'40','1');	
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br>.</label><textarea readonly row = \"4\" cols=\"80\" name=$unchamps id=$unchamps></textarea></td>";			
		}
		 
			 }
			 
			 else{
				 		if($unchamps == 'pdp_nouveautype')
		 {
			  echo afficheradio($commentaire,$unchamps,$listeouinon,$$unchamps,'','');	
		 }
		  elseif ($taillechamp[$unchamps]<120)
		 {
     echo affichechamp($commentaire,$unchamps,$$unchamps,'40','');	
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br>.</label><textarea  row = \"4\" cols=\"80\" name=$unchamps id=".$unchamps.">".$$unchamps."</textarea></td>";			
		}
			 }
    echo "</tr><tr>";	 
	 }
  echo "</td></tr><tr><th colspan=6>";
    //on met en hidden la cle primaire - inutile si elle est déjà affichée
  //  echo"<input type='hidden' name='$cleprimaire' value=\"".$$cleprimaire."\">   ";
   if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif))
   {
  echo"<input type='Submit' name='bouton_mod' value='modifier'>";
  }
  echo"<input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo "(*) champs obligatoires";
  echo"</center>";
      }
	 }

 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 
   foreach($champsSingle as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		
		
  echo    "<form method=post action=$URL> ";
  echo"       <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
     foreach ($champsSingle as $unchamps)
	 {
	 		 if ($comment[$unchamps]=='')
			 {
				if (array_key_exists($unchamps,$liste_libelles_champ) )
				{	
				$commentaire=$liste_libelles_champ[$unchamps];
				}else
				{	
				$commentaire=$unchamps;
				}
			 }else
			 {
			 $commentaire=$comment[$unchamps];
			 }
			 if(in_array($unchamps,$champsobligatoires))
			 {
				 $commentaire=$commentaire." (*) ";
			 } 

	 // on n'affiche pas le auto inc ni date_modif ni modifpar
if ($unchamps != $autoincrement and $unchamps != $champ_date_modif and $unchamps != $champ_modifpar ){
			 
	 // si on a une table liée
	  if ($unchamps == $cleetrangere2 ){
	       echo affichemenusqlplus($commentaire,$unchamps,$cleprimaire2,'select * from '.$table2 ,$liste_champs_lies_pour_formulaire_ajout2[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);

	  }
	  elseif ($unchamps == $cleetrangere3 ){
	       echo affichemenusqlplus($commentaire,$unchamps,$cleprimaire3,'select * from '.$table3 ,$liste_champs_lies_pour_formulaire_ajout3[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);

	  }
	 else
	 { 
		if($unchamps == 'pdp_nouveautype')
		 {
			  echo afficheradio($commentaire,$unchamps,$listeouinon,$$unchamps,'oui','');	
		 }
		elseif ($taillechamp[$unchamps]<120)
		 {
     echo affichechamp($commentaire,$unchamps,'',$taillechamp[$unchamps],'');
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br>.</label><textarea row = \"4\" cols=\"80\" name=$unchamps id=$unchamps></textarea></td>";			
		}	
	 }
}
    echo "</tr><tr>";	 
	 }

   
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo "(*) champs obligatoires";
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


  if($table2=='')
  {
     // $query = "SELECT * FROM $table where 1 ";
	  $req = $connexion->query('SELECT * FROM '. $table.'  order by `'.$orderby.'` ' .$sens );
	}
	elseif($table3=='')
	{
	//$query = "SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere2 = $table2.$cleprimaire2 where 1 ";
	$req = $connexion->query("SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere2 = $table2.$cleprimaire2 where 1  order by `".$orderby."` ".$sens );
	}
	else
	{
	$req = $connexion->query("SELECT * FROM $table LEFT JOIN $table2 ON $table.$cleetrangere2 = $table2.$cleprimaire2 LEFT JOIN $table3 ON $table.$cleetrangere3 = $table3.$cleprimaire3 where 1 order by `".$orderby."` ".$sens );
	}	
//echo $query;
   //$query.=$where."  ".$orderby;
  // $result = mysql_query($query,$connexion ); 
//$nombre= mysql_num_rows($result);
 $nombre=$req->rowCount();
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo " enregistrements ".$texte_table ."</H2>";}

if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1> Ajouter un enregistrement </a><br>";
}
echo"<br><br><a href=".$pageaccueil.">revenir à l'accueil</a>";
if ($nombre>0){
echo"<BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";


echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
		//dans l'ordre on regarde le tableau des libelles, puis le commentaire sql sinon on prend le nom du champs
		foreach ($liste_champs_tableau as $unchamps)
		{ 
			 if (!array_key_exists($unchamps,$liste_libelles_tableau) ) 
			 {
				if ($comment[$unchamps]!='')
				{	
				$commentaire=$comment[$unchamps];		
				}else
				{	
				$commentaire=$unchamps;
				}
			 }else
			 {
			 $commentaire=$liste_libelles_tableau[$unchamps];
			 }
		
			echo afficheentete($commentaire,$unchamps,$_GET['env_orderby'],$_GET['env_inverse'],$filtre,$URL);
		}
//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
			$csv_output .= nettoiecsvplus($champs[$i]);
}
$csv_output .= "\n";
//while($u=mysql_fetch_object($result)) {
while ($u = $req->fetch(PDO::FETCH_OBJ)) {	
 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   if (in_array ($ci2 ,$liste_champs_dates))
	 { 
	 //on transforme les dates sql en dd/mm/yy
		 $$ci2=mysql_DateTime($u->$ci2);
	 $csv_output .=  nettoiecsvplus(mysql_DateTime($u->$ci2));
	 }else{
		  $$ci2=$u->$ci2;
	   $csv_output .=  nettoiecsvplus($u->$ci2);
	  }   
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format
		//on récupère les champs liés
		// on ecrit chaque ligne
		      echo"   </tr><td>" ;	
		foreach($liste_champs_tableau as  $colonne)
		{
   		//if (!in_array($colonne,$liste_champs_lies))
		//if (1)
		//	{
			 echo echosur($$colonne) ;
			  echo"   </td><td>" ;
		//	}	 
		//else
		//	{
		//	echo $tableau_champs_lies[$colonne][$$cleetrangere2];
		//	echo"   </td><td>" ;
		//	}
		
       }
	if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
     echo " <A href=".$URL."?del=".$$cleprimaire." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";
	 }
	 
     echo "<A href=". $URL."?mod=".$$cleprimaire." >Mod</A>";
	        echo"</td> </tr>";
	   }
	   //pdo	   
	$req->closeCursor();
	if(in_array($loginConnecte,$login_autorises_export) or empty($login_autorises_export))
		{
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
		echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
		echo "</form>";
		}

	   
echo"</table> ";
  }
  }
//mysql_close($connexion);
?>
</body>
</html>
