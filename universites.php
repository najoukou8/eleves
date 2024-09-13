<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des Universités</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
echo "</HEAD><BODY>" ;
// On se connecte
//echo "Connexion ($user_sql, $password, $dsn, $host)";
$connexion =Connexion ($user_sql, $password, $dsn, $host);
require('header.php');


if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_POST['bouton_cp_add'])) $_POST['bouton_cp_add']='';
if (!isset($_POST['bouton_cp_mod'])) $_POST['bouton_cp_mod']='';
if (!isset($_POST['bouton_cp'])) $_POST['bouton_cp']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['fromstage'])) $_POST['fromstage']='';
if (!isset($_GET['fromstage'])) $_GET['fromstage']='';
if (!isset($_POST['code_etu'])) $_POST['code_etu']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['club_indus'])) $_POST['club_indus']='';
if (!isset($_POST['villecp'])) $_POST['villecp']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
$message='';
$sql1='';
$sql2='';
$where='';
$dep_2a='non';
$dep_3a='non';
$tabgere_par=array('ENSGI','INPG','mixte');
$listeouinon=array('oui','non');
$listeaccdep=array('départ','accueil','départ et accueil');
if ($_GET['env_orderby']=='') {$orderby= ' order by nom_uni';}
	else{
	$orderby=" order by ".urldecode($_GET['env_orderby']);
	if  ($_GET['env_inverse']!="1"){
                  $orderby=$orderby." desc";}
	}


  //seules les personnes autorisées ont acces à la liste
// if(in_array($login,$ri_user_liste)){
//tout le monde a accès à la liste
 if($login != ''){
	$affichetout=1;
}else
	{$affichetout=0;
	}
	

$URL =$_SERVER['PHP_SELF'];;
$table="universite";
//on cree un tableau $champs[] avec les noms des colonnes de la table universite et leur taille
$result = mysql_query("SHOW COLUMNS FROM $table");
if (!$result) {
   echo 'Impossible d\'exécuter la requête : ' . mysql_error();
   exit;
}
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {

      $champs[]= $row["Field"];
	  $type[]= $row["Type"];
   }
}



//on cree un   tableaux  id l/ibelles des pays et 
 $query = "SELECT * FROM pays";
   $result = mysql_query($query,$connexion ); 
while($pays=mysql_fetch_object($result)) {
     $tab_nom_pays[]=$pays->libelle_pays;
     $tab_id_pays[]=$pays->id_pays;
	  $tab_pays = array($tab_id_pays,$tab_nom_pays);
	  // un associatif id /libelles des continents
	 $tab_continent[$pays->id_pays] = $pays->continent;
}

//print_r( $tab_continent);


// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$ri_user_liste)){
   if($_POST['nom_uni']!='' ) {
 $_POST['modifpar']=$login;
 //pour les dates 
$_POST['deb_era']=versmysql_Date($_POST['deb_era']);
$_POST['fin_era']=versmysql_Date($_POST['fin_era']);
$_POST['date_limite_insc']=versmysql_Date($_POST['date_limite_insc']);

foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

 if ($ci2=="id_uni"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(),";}
  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  // $query = "INSERT INTO $table(nom,email)";
    $query = "INSERT INTO $table($sql1)";
   $query .= " VALUES($sql2)";
  //echo $query;
      $result = mysql_query($query,$connexion);
       if ($result){
    $message = "Fiche <b>".$_POST['nom_uni']." - ";
   $message .= "</B> ajoutée !<br>";}
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>La fiche n'est pas enregistrée</b> </center>";
    } 

    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez donnez un nom à votre Université ! : Recommencez !");
	if  ($_POST['fromstage'] =='2'){
    echo "<center><a href=etustages.php>    revenir à la création du stage</a>  </center>";
		}
	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$ri_user_liste)){
 






// il faut verifier qu'il n existe pas de contacts rataché
   $query = "SELECT * FROM contact where id_univ_contact= ".$_GET['del'] ;
    $result = mysql_query($query,$connexion ); 
	$nombre= mysql_num_rows($result);
     if ($nombre <> 0){
      echo "<br><center>impossible de supprimer cette université car ".$nombre." contact(s)
      lui sont associés</center><br>";
     }
	 // et pas de periodes
	 else{
	 $query = "SELECT * FROM periode_envoi where id_univ_periode= ".$_GET['del'] ;
    $result = mysql_query($query,$connexion ); 
	$nombre= mysql_num_rows($result);
     if ($nombre <> 0){
      echo "<br><center>impossible de supprimer cette université  car ".$nombre." periode(s)
      lui sont associées</center><br>";	 
	 }
	 else{	
	 // et pas de bourses
	 $query = "SELECT * FROM bourse where id_univ_bourse= ".$_GET['del'] ;
    $result = mysql_query($query,$connexion ); 
	$nombre= mysql_num_rows($result);
     if ($nombre <> 0){
      echo "<br><center>impossible de supprimer cette université  car ".$nombre." bourse(s)
      lui sont associées</center><br>";	 
	 }
     else {

	 	 //ok la on peut supprimer
   $query = "DELETE FROM $table"
      ." WHERE id_uni=".$_GET['del']."";
     // echo $query;
   $result = mysql_query($query,$connexion);
   if($result){
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";}
   }
   }
   }

   }
   
      else{
		echo "<center><b>seul le service des relations internationales peut effectuer cette operation</b><br>";
		echo "aucune modification effectuée<br></center>";
		}//fin du else $login == 
}

//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$ri_user_liste)){
 //pour modifpar
$_POST['modifpar']=$login;
//pour les dates
$_POST['deb_era']=versmysql_Date($_POST['deb_era']);
$_POST['fin_era']=versmysql_Date($_POST['fin_era']);
$_POST['date_limite_insc']=versmysql_Date($_POST['date_limite_insc']);
//gestion des listes modifiables
if ($_POST['reseau_new']!=''){$_POST['reseau']=$_POST['reseau_new'];}


foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="id_uni"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2."=now(),";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }



 //attention il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE id_uni=".$_POST['id_uni']." ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['id_uni']." modifiée <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>seul le  le  service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==


} //fin du if

if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details

 $query = "SELECT * FROM $table 
					  where id_uni=".$_GET['mod']." order by nom_uni ";
					  //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
	   $deb_era = mysql_DateTime($deb_era);
		   	$fin_era = mysql_DateTime($fin_era);
		$date_limite_insc = mysql_DateTime($date_limite_insc);	
		$date_modif=mysql_Time($date_modif);
		//on récupère les champs liés

         
//  echo"<input type='hidden' name='modif' value=1>";
     echo    "<form method=post action=$URL> ";

    echo"<input type='hidden' name='id_uni' value=\"$id_uni\">   ";
  echo"<center>";
  echo"       <table>  ";
  echo "<tr>";
  echo "<td><H1>ENVOI D'ETUDIANT</H1>";
echo "</tr><tr>";
	echo afficheonly("","Informations générales",'b' ,'h3');
echo "</tr><tr>";
	echo affichechamp('Nom Université','nom_uni',$nom_uni,50,'');
    echo affichechamp('Nom Abrégé','abrev_uni',$abrev_uni,'','');
		echo affichemenu('Départ ou accueil','uni_dep_acc',$listeaccdep,$uni_dep_acc,'');	
echo "</tr><tr>";
echo affichechamp('Ville','ville',$ville,35,'');
	
	echo affichemenuplus('Pays','id_pays',$tab_pays,$id_pays);
	echo affichechamp('Continent','continent',$tab_continent[$id_pays],'25',1);
	echo "</tr><tr>";
	echo "<td colspan=2>Commentaires<br><textarea name='commentaire' rows=2 cols=60>".$commentaire."</textarea></td> ";
		echo "</tr><tr>";
	echo afficheradio('Ouvert à candidature 2A','ouv_cand',$listeouinon,$ouv_cand,'non');
		echo afficheradio('Ouvert à candidature 1A','ouv_cand2',$listeouinon,$ouv_cand2,'non');
	echo affichechamp('Nombre de places','nbre_places',$nbre_places,3);
	echo "</tr><tr>";
	echo affichechamp('Site Web','site_web',$site_web,60,'');
	echo "</tr><tr>";
	echo afficheonly("","Accords inter universités",'b' ,'h3');
 echo "</tr><tr>";
	echo affichemenu('Géré par ','gere_par',$tabgere_par,$gere_par);	  
	echo afficheradio('Possibilité double diplôme','dd',$listeouinon,$dd,'non');
	echo afficheradio('Possibilité Master','master',$listeouinon,$master,'non');		
 echo "</tr><tr>";
 	//echo affichemenusql('Choisissez le réseau ci dessous ou utilisez le champ ci contre','reseau','reseau',"SELECT distinct reseau FROM universite ",'reseau',$reseau);
	echo affichemenusqlplus('Choisissez le réseau ci dessous ou utilisez le champ ci contre','reseau','reseau',"SELECT distinct reseau FROM universite ",'reseau',$reseau,$connexion);
    echo affichechamp('Nouveau reseau','reseau_new','','','');
	echo "</tr><tr>";
	echo afficheonly("","ERASMUS",'b' ,'h3');	
		echo "</tr><tr>";
	echo afficheradio('Erasmus','erasmus',$listeouinon,$erasmus,'non');		   
	echo affichechamp('Num Contrat Erasmus','contrat_era',$contrat_era,'','');
echo "</tr><tr>";
		echo affichechamp('Début du contrat (jj/mm/aaaa)','deb_era',$deb_era,'','');
		echo affichechamp('Fin du contrat (jj/mm/aaaa)','fin_era',$fin_era,'','');
		echo "</tr><tr>";
		echo affichechamp('Nombre d\'étudiants ','nb_etudian_era',$nb_etudian_era,'','');
		echo affichechamp('Nombre de mois ','mois_era',$mois_era,'','');
	echo "</tr><tr>";
	echo afficheonly("","Contacts Départs",'b' ,'h3');
	echo "</tr><tr>";
		echo"<td colspan=2>";	
	

	echo "<table border=1>";
	echo "<th>nom</th><th>prenom</th><th>fonction</th><th>email</th><th>tel</th><th>fax</th>";
	 $query2 = "SELECT * FROM contact where id_univ_contact = ".$id_uni ." and cont_dep_acc  like  'départ%' order by nom" ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
echo"   <tr><td>" ;
      echo  $u->nom ;
      echo"   </td><td>" ;
      echo $u->prenom ;
	  echo"   </td><td>" ;
      echo $u->fonction ;
	  echo"   </td><td>" ;
	  if ($u->mail!=''){
	 echo "<a href=mailto:".$u->mail.">".$u->mail."</a>" ;}
	  echo"   </td><td>" ;
	 echo $u->tel ;
	  echo"   </td><td>" ;
	 echo $u->fax ;
     echo"        </td> </tr>";
	 }
	echo"</table >";
	echo "</td>";
	echo"</tr><tr>";
	 if(in_array($login,$ri_user_liste)){	
	echo"<td><a href=contacts.php?filtre_id=".$id_uni.">Détails-Ajouter-Modifier les contacts de  ".$nom_uni. "</a></td>";
	 }
	echo "</tr><tr>";
	echo "</tr>";
	
	echo"   <tr><td>" ;
		echo "</tr><tr>";
		echo afficheonly("","Périodes d'études en envoi",'b' ,'h3');
	echo "</tr><tr>";
	echo "<td></td>";
	
	echo "</tr><tr>";
	echo"<td>" ;	
	echo "<table border=1>";
	echo "<th>semestre départ</th><th>date debut</th><th>date fin</th><th>Langue</th>";
	 $query2 = "SELECT * FROM periode_envoi where id_univ_periode = ".$id_uni ." order by sem_depart" ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {

echo"   <tr><td>" ;  
      echo  $u->sem_depart ;
      echo"   </td><td>" ;
      echo mysql_DateTime_jm($u->date_deb) ;
	  echo"   </td><td>" ;
      echo mysql_DateTime_jm($u->date_fin) ;
	   echo"   </td><td>" ;
      echo $u->lang ;
     echo"        </td> </tr>";
	 }
	echo"</table>";
	echo"   </td>" ; 
	echo "</tr><tr>";
	if(in_array($login,$ri_user_liste)){
	echo"<td> <a href=periodes.php?filtre_id=".$id_uni.">Détails-Ajouter-Modifier les périodes d'étude en envoi de  ".$nom_uni. "</a></td>";
	}
	echo "</tr><tr>";
	echo afficheonly("","Bourses spécifiques à cette destination",'b' ,'h3');
	echo "</tr><tr>";
	echo "<td></td>";
	
	echo "</tr><tr>";
	echo"<td>" ;	
	echo "<table border=1>";
	echo "<th>nom de  la bourse</th><th>site web</th>";
	 $query2 = "SELECT * FROM bourse where id_univ_bourse = ".$id_uni ." order by libel_bourse" ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
echo"   <tr><td>" ;  
      echo  $u->libel_bourse ;
      echo"   </td><td>" ;
	  	  if ($u->site_bourse!=''){
	 echo "<a href=".$u->site_bourse.">".$u->site_bourse."</a>" ;}
   

      
	 }
	echo"</table>";
	echo"   </td>" ; 
	echo "</tr><tr>";
	 if(in_array($login,$ri_user_liste)){	
	echo"<td><a href=bourses.php?filtre_id=".$id_uni.">Détails-Ajouter-Modifier les bourses de  ".$nom_uni. "</a></td>";
	 }
	echo "</tr><tr>";
	
	echo afficheonly("","TOEFL",'b' ,'h3');
	echo "</tr><tr>";
	$listetoefl=array('oui','non','recommandé');
	echo afficheradio('TOEFL requis','toefl',$listetoefl,$toefl,'non');
	echo affichechamp('Score requis (IBT) ','score_toefl',$score_toefl,'','');
	echo affichechamp('Score requis à l\'essai(IBT) ','score_toefl_essai',$score_toefl_essai,'','');
	echo "</tr><tr>";

	echo afficheonly("","Inscriptions",'b' ,'h3');
		echo "</tr><tr>";
		echo affichechamp('Site pour candidater ','site_insc',$site_insc,'','');
		echo affichechamp('Date limite d\'inscription ','date_limite_insc',$date_limite_insc,'','');
			echo "</tr><tr>";
	 echo "<td colspan=2>Commentaires inscriptions <br><textarea name='com_insc' rows=3 cols=70>".$com_insc."</textarea></td> ";		  
  echo "</tr><tr><td>";
  echo "<H1>ACCUEIL D'ETUDIANT</H1>";
  echo afficheonly("","Contacts Accueil",'b' ,'h3');
	echo "</tr><tr>";
		echo"<td colspan=2>";	
	

	echo "<table border=1>";
	echo "<th>nom</th><th>prenom</th><th>fonction</th><th>email</th><th>tel</th><th>fax</th>";
	 $query2 = "SELECT * FROM contact where id_univ_contact = ".$id_uni ." and cont_dep_acc  like  '%acc%' order by nom" ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
echo"   <tr><td>" ;
      echo  $u->nom ;
      echo"   </td><td>" ;
      echo $u->prenom ;
	  echo"   </td><td>" ;
      echo $u->fonction ;
	  echo"   </td><td>" ;
	  if ($u->mail!=''){
	 echo "<a href=mailto:".$u->mail.">".$u->mail."</a>" ;}
	  echo"   </td><td>" ;
	 echo $u->tel ;
	  echo"   </td><td>" ;
	 echo $u->fax ;
     echo"        </td> </tr>";
	 }
	echo"</table >";
	echo "</td>";
	echo"</tr><tr>";
		 if(in_array($login,$ri_user_liste)){
	echo"<td><a href=contacts.php?filtre_id=".$id_uni.">Détails-Ajouter-Modifier les contacts de  ".$nom_uni. "</a></td>";
		 }
	echo "</tr><tr>";
	echo "</tr><tr>";
	echo afficheonly("","Périodes d'études en accueil",'b' ,'h3');
echo "</tr><tr>";	
		        echo "<td colspan=2>Commentaires Accueil<br><textarea name='com_acc' rows=3 cols=70>".$com_acc."</textarea></td> ";		  
echo "</tr><tr>";
	echo afficheonly("","Divers",'b' ,'h3');
echo "</tr><tr>";	
    echo affichechamp('Modifié par','modifpar',$modifpar,'15',1);
    echo affichechamp('le','date_modif',$date_modif,'17',1);
    echo "</tr><tr>";
	 if(in_array($login,$ri_user_liste)){
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'>";
	 }
	 echo"<input type='Submit' name='bouton_annul' value='Revenir'></th></tr></table></form> "  ;
  echo"<br>";
  
	    echo"<br>";
 
  echo"</center>";

      }
	  }
	  
 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		   
     

		
		
  echo    "<form method=post action=$URL> ";
  echo"   <center>    <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
  //pour les dates  car il faut les transformer ensuite dans ajout de la fiche
    echo"<input type='hidden' name='deb_era' value=''>";
	    echo"<input type='hidden' name='fin_era' value=''>";
		    echo"<input type='hidden' name='date_limite_insc' value=''>";

    echo"<center>";
  echo"       <table><tr>  ";
   echo affichechamp('Nom Université','nom_uni',$nom_uni,50,'');
         echo affichechamp('Nom Abrégé','abrev_uni',$abrev_uni,'','');
		 	     echo "</tr><tr>";
		 echo affichemenu('Départ ou accueil','uni_dep_acc',$listeaccdep,'départ','');		 
	  echo affichechamp('Site Web','site_web',$site_web,50,'');
	  
	     echo "</tr><tr>";

    	echo affichechamp('Ville','ville',$ville,35,'','');
	   echo "</tr><tr>";
		echo affichemenuplus('Pays','id_pays',$tab_pays,'246');
	   echo "</tr><tr>";

   // echo affichechamp('modifié par','modifpar',$modifpar,'15',1);
   // echo affichechamp('le','date_modif',$date_modif,'15',1);
    echo "</tr><tr>";   echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Revenir'></th></tr></table></form> "  ;
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage


   $query = "SELECT *,pays.* FROM $table left outer join pays on  universite.id_pays=pays.id_pays";
   $query.=$where."  ".$orderby;
   //echo $query;
   $result = mysql_query($query,$connexion );
echo "<A class='abs' href=accueil_international.php > Retour à l'accueil des départs à l'étranger</a>";   
	 if(in_array($login,$ri_user_liste)){
echo "<br><br><A  class='abs1' href=".$URL."?add=1 > Ajouter une Université </a><br>";
	 }
//echo "<br><br><A href=departs.php > Gestion des départs </a><br>";
//echo "<br><A href=default.php > Revenir à l'accueil </a><br><br>";
echo"<center><br/><h1 class='titrePage2'>Liste des   ";
$nombre= mysql_num_rows($result);
echo $nombre;
echo" universités partenaires </h1> <BR><table border=1> ";
//echo "<table><th>Nom</th><th>ville</th><th>Pays</th><th>Action</th>";
echo"Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes";
echo"<br>En cliquant sur le nom de l'université ,vous accédez à son site web ";
        echo "<BR><BR><table class='table1'><tr bgcolor=\"#98B5FF\" > ";

		    if   ($_GET['env_orderby']=='universite.nom_uni' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=universite.nom_uni&env_inverse=1>université</a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=universite.nom_uni>université</a></th> ";}

if   ($_GET['env_orderby']=='pays.libelle_pays' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=pays.libelle_pays&env_inverse=1>Pays</a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=pays.libelle_pays>Pays</a></th> ";}

echo"<th>Départs</th> ";
//echo"<th>Départ 3A</th> ";
echo"<th>DD/Master</th> ";
		    

	//		if   ($_GET['env_orderby']=='dd' && $_GET['env_inverse']<> 1)
//{echo"<th><a href=".$URL."?env_orderby=dd&env_inverse=1>Dble diplôme</a></th> ";}
//else
//{echo "<th><a href=".$URL."?env_orderby=dd>Dble diplôme</a></th> ";}

			if   ($_GET['env_orderby']=='toefl' && $_GET['env_inverse']<> 1)
{echo"<th><a href=".$URL."?env_orderby=toefl&env_inverse=1>toefl</a></th> ";}
else
{echo "<th><a href=".$URL."?env_orderby=toefl>toefl</a></th> ";}
echo afficheentete('places','nbre_places',$_GET['env_orderby'],$_GET['env_inverse'],'',$URL);

//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
$csv_output .= $champs[$i].";";}
$csv_output .= "\n";
while($universite=mysql_fetch_object($result)) {
$dep_all='';
$dep_2a='-';
$dep_3a='-';
$ddmaster='-';
 //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   $csv_output .= "\"".$universite->$ci2."\"".";";
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format
		   
		//on récupère les champs liés
		
		//on calcule les champs calculés
		if ($dd=='oui' or $master=='oui' ){
	 $ddmaster='oui';}else{$ddmaster='-';}
     
	 $pays=$universite->libelle_pays;
	 //pour chaque universite  on verifie ds la table periode
	    $query2 = "SELECT * FROM periode_envoi where id_univ_periode= ".$id_uni ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
     if ($u->sem_depart=='S3' or $u->sem_depart=='S4' or $u->sem_depart=='AC-2A'){
	 $dep_2a='oui';}else{$dep_2a='-';}
	 if ($u->sem_depart=='S5' or $u->sem_depart=='S5bis' or $u->sem_depart=='AC-3A'){
	 $dep_3a='oui';}else{$dep_3a='-'; }
	 }
	 
	 //variante on fait la liste de toutes les semestres de période  qui apparaissent au moins une fois 
	 	    $query2 = "SELECT distinct sem_depart FROM periode_envoi where id_univ_periode = ".$id_uni ." order by sem_depart" ;
    $result2 = mysql_query($query2,$connexion ); 
	while($u=mysql_fetch_object($result2)) {
	$dep_all=$dep_all."-".$u->sem_depart;
	 }
	 //on enleve le 1ercaractere
	 $dep_all=substr($dep_all,1);
	 //$modifpar=odbc_result($result,"modifpar") ;
      echo"   <tr><td>" ;
	  if ($site_web!=''){
	        echo "<a class='abs' href=".$site_web. ">".$nom_uni."</a>" ;
	  }else{
      echo $nom_uni ;}
      echo"   </td><td>" ;
	  	  
      echo $pays ;
	  echo"   </td><td>" ;
      echo $dep_all ;
	  echo"   </td><td>" ;
      //echo $dep_3a ;
	  //echo"   </td><td>" ;
      echo $ddmaster ;
	  echo"   </td><td>" ;
      echo $toefl ;
      	  echo"   </td><td>" ;
      echo $nbre_places ;
      	  echo"   </td><td>" ;
		  	 if(in_array($login,$ri_user_liste)){
     echo "<A class='abs' href=contacts.php?filtre_id=".$id_uni.">Contacts</A>";
	  echo"      </td><td nowrap> ";
     
     echo "<a class='abs' href=bourses.php?filtre_id=".$id_uni.">Bourses</A>";
	  echo"      </td><td nowrap> ";
    
     echo "<a class='abs' href=periodes.php?filtre_id=".$id_uni.">Périodes</A>";
	 echo"      </td><td nowrap> ";

     echo " <A class='abs2' href=".$URL."?del=".$id_uni." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette Université ?')\">";
     echo "Supp</A> - ";
		 }
     echo "<A class='abs1' href=". $URL."?mod=".$id_uni.">Détails</A>";

     echo"        </td> </tr>";
       }
	   
	   echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
	   
echo"</table> ";
echo"</table> ";

  }

mysql_close($connexion);
require('footer.php');
?>
</body>
</html>