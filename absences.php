<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des dispenses d'activit�s p�dagogiques</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("param.php");
require ("function.php");
require ("style.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);



if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_GET['fromstage'])) $_GET['fromstage']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['env_orderby'])) $_GET['env_orderby']='';
if (!isset($_GET['env_inverse'])) $_GET['env_inverse']='';
if (!isset($_POST['mod_ligne_absence'])) $_POST['mod_ligne_absence']='';
if (!isset($_POST['code_etu'])) $_POST['code_etu']='';
if (!isset($_GET['addligne'])) $_GET['addligne']='';
if (!isset($_GET['delligne'])) $_GET['delligne']='';
if (!isset($_GET['modfiche'])) $_GET['modfiche']='';
if (!isset($_POST['ajoutligne'])) $_POST['ajoutligne']='';
if (!isset($_POST['bouton_annul_ligne'])) $_POST['bouton_annul_ligne']='';
if (!isset($_GET['fromfiche'])) $_GET['fromfiche']='';
if (!isset($_GET['fromfic'])) $_GET['fromfic']='';
if (!isset($_GET['fromfichescol'])) $_GET['fromfichescol']='';
if (!isset($_GET['stats'])) $_GET['stats']='';

//si on vient de valider un ajout ou une modif de ligne  il faut remmettre l'id  ds le get_var
if ($_POST['mod']!=''){
$_GET['mod']=$_POST['mod'];}
if ($_POST['code_etu']!=''){
$_GET['code_etu']=$_POST['code_etu'];}
$listejustificatif=array('oui','non','voir d�tail');
$afficheliste=1;
$message='';
$sql1='';
$sql2='';
$orderby=' order by date_debut';
$liste_champs_dates=array('date_debut' ,'date_fin');
   $listeouinon=array('non','oui');
//on remplit 3 tableaux avec les nom-code  etudiants
$sqlquery2="SELECT *,annuaire.`Mail effectif` as mailetu FROM etudiants 
left outer JOIN  annuaire  ON etudiants.`Code etu` = annuaire.`Code-etu`  order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
//on remplit un tableau indice avec les noms etudiants
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Pr�nom 1"];
$etudiants_email[$ind2]=$v["mailetu"];
}

//si on vient de valider un ajout ou une modif il faut remmettre l'id univ ds le get_var
if ($_POST['code_etu']!=''){
$_GET['code_etu']=$_POST['code_etu'];
}

if ($_GET['code_etu']!=''){
$where=" where code_etud=".$_GET['code_etu']." ";
$nom_etud=$etudiants_nom[$_GET['code_etu']];
}else{
$where='';
$nom_etud='';
}

//si on est parti du lien d�tails absences de fiche.php on saute l'affichage complet
if ( $_GET['fromfiche'] ){
//on remet  les parametres  ds l'url  pour retrouver l'environnement de d�part
$filtre ="&annee=".$_GET['promo']."&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);
$filtreok=$filtre."&bouton_ok=OK";
}




   //seules les personnes autoris�es ont acces � la liste
if(in_array($login,$scol_user_liste)){
	$affichetout=1;
}else
	{$affichetout=0;
	}
	
$URL =$_SERVER['PHP_SELF'];;
$table="absences";
//on cree un tableau $champs[] avec les noms des colonnes de la table universite et leur taille
$result = mysql_query("SHOW COLUMNS FROM $table");
if (!$result) {
   echo 'Impossible d\'ex�cuter la requ�te : ' . mysql_error();
   exit;
}
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {

      $champs[]= $row["Field"];
	  $type[]= $row["Type"];
   }
}
$table2="lignes_absence";
//on cree un tableau $champs[] avec les noms des colonnes de la table universite et leur taille
$result = mysql_query("SHOW COLUMNS FROM $table2");
if (!$result) {
   echo 'Impossible d\'ex�cuter la requ�te : ' . mysql_error();
   exit;
}
if (mysql_num_rows($result) > 0) {
   while ($row = mysql_fetch_assoc($result)) {

      $champs2[]= $row["Field"];
	  $type2[]= $row["Type"];
   }
}




// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {

//test si admin ent ou si on vient de creation de stage
 if(in_array($login,$scol_user_liste)){
 // pb du nom du champ code _etud aulieu de la variable  code_etu
$_POST['code_etud']=($_GET['code_etu']);
 
   if($_POST['date_debut']!='' ) {
 $_POST['modifpar']=$login;
foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque � cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver

  //pb des dates mysql
//si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }


 if ($ci2=="id_absence"){
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
    $message = "Fiche <b>";
   $message .= "</B> ajout�e !<br>";
   
   // il faut aussi envoyer un mail � l'�tudiant
			// On prepare l'email : on initialise les variables

			$objet = "Absence saisie pour ".$etudiants_prenom[$_POST['code_etud']] ." "  .$etudiants_nom[$_POST['code_etud']]  ;
			$messagem = "Votre demande d'absence du ".mysql_DateTime($_POST['date_debut'])." a �t� vis�e par la Direction des �tudes"." \n" ;
			$messagem .= "Vous pouvez la consulter sur la base �l�ves \n" ;
			$messagem .= "Cordialement , \n";
			$messagem .= "Le service Scolarit� \n";			
			//$messagem .= "Email de l'�tudiant ".$_POST['etudiant_email']." \n";				
			if (($_POST['etudiant_email']!='')){
			envoimail($_POST['etudiant_email'],$objet,$messagem);
			//envoimail($rimail,$objet,$messagem);
			envoimail($sigiadminmail,$objet,$messagem);	
			}			
   }
   
   
   else {
    echo affichealerte("erreur de saisie ")." : ". mysql_error();
  echo "<center>La fiche n'est pas enregistr�e</b> </center>";
    } 

    }
   else{   // fin du nom=''
    echo affichealerte("Vous devez donnez une date de d�but ! : Recommencez !");

	}
    }
    else{//debut du else $login==
   echo "<center><b>seul le service scolarit� peut effectuer cette operation</b><br>";
      echo "aucune modification effectu�e<br></center>";

} //fin du else $login ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
 if(in_array($login,$scol_user_liste)){
 

	 //et qu'une offre de stage n'y est pas rattach�e non plus 
   $query = "DELETE FROM $table"
      ." WHERE id_absence=".$_GET['del']."";
     // echo $query;
   $result = mysql_query($query,$connexion);

   if($result){
      // il faut aussi supprimer les lignes rattach�es
	  // inutile 2016
   //$query2 = "DELETE FROM lignes_absence "
     // ." WHERE lignes_absence_id_absences=".$_GET['del']."";
	   //  $result2 = mysql_query($query2,$connexion);
	  
   $message = "Fiche <b>".$_GET['del'];
   $message .= "</b> supprim�e <br>!";
   }
   }
   
      else{
   echo "<center><b>seul le service relations industrielles peut effectuer cette operation</b><br>";
      echo "aucune modification effectu�e<br></center>";
}//fin du else $login == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' ){

 if(in_array($login,$scol_user_liste)){
 //pour modifpar
$_POST['modifpar']=$login;
// pb du nom du champ code _etud aulieu de la variable  code_etu
$_POST['code_etud']=($_GET['code_etu']);
foreach($champs as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque � cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
 
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="id_absence"){
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
   $query .= " WHERE id_absence=".$_POST['id_absence']." ";
  //echo $query;

   $result = mysql_query($query,$connexion);
   if($result){

   $message = "Fiche numero ".$_POST['id_absence']." modifi�e <br>";}
   else {$message = "Probleme d'enregistrement de la fiche ".mysql_error();;
    }
	}
   else{
   echo "<b>seul le   service scolarit� peut effectuer cette operation</b><br>";
      echo "aucune modification effectu�e <br>";

} //fin du else $login ==
} //fin du if

if($_POST['ajoutligne']!='') {
 // ------------Ajout de la fiche ligne absence--------------------
if($login == 'administrateur' or in_array($login,$scol_user_liste)){
//il faut qu'on retombe sur le detail de la fiche
$_GET['modfiche']='oui';
$_POST['modifpar']=$login;
$_POST['lignes_absence_id_absences']=$_POST['mod'];
foreach($champs2 as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 //if (in_array($ci2,$liste_champs_dates)){
 //$_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 //}
         //tout ce cirque � cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle generee automatiquement par sqlserver

   if ($ci2=="lignes_absence_id"){
 

 }
//elseif ($ci2=="date_modif"){
// $sql1.= $ci2.",";
// $sql2.= "now(), ";}

  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  $query = "INSERT INTO $table2($sql1)";
  $query .= " VALUES($sql2)";
//echo $query."<br>";
   $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
}
   else{
   echo "<center><b>seul le service scolarit� peut effectuer cette operation</b><br>";
      echo "aucun ajout effectu�e<br></center>";

} //fin du else $login ==
}	 
if($_GET['addligne']!='' ){ 
 //--------------------------------------------------------------------------------------------------------------------------c'est kon a cliqu� sur ajouter ligne
 $afficheliste=0;

 if($login == 'administrateur' or in_array($login,$scol_user_liste) ){
//on initialise les variables de tous les champs
 foreach($champs as $ci2){
 $$ci2='';
}
 //echo"<input type='hidden' name='ajout' value=1>";
 echo "<center>";
  echo    "<form method=post action=$URL> "; 
  
		if ($_GET['mod']!=''){
  echo"<input type='hidden' name='mod' value=\"".stripslashes(($_GET['mod']))."\">"."\n";}
  		if ($_GET['code_etu']!=''){
  echo"<input type='hidden' name='code_etu' value=\"".stripslashes(($_GET['code_etu']))."\">"."\n";}
        echo"       <table>";
        echo "</tr><tr>";   

		  echo "</tr><tr>"; 
		//echo afficheonly ('code_depart' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
		//sinon on affiche la liste 
          echo "</tr><tr>";   
		echo affichemenu('heure d�but','lignes_absence_heure_deb',$heures_liste,'08h00');


		echo affichemenu('heure fin','lignes_absence_heure_fin',$heures_liste,'08h00');
        echo "</tr><tr>"; 
				      echo affichechamp('Dispense autoris�e (oui / non ) par','lignes_absence_validby','','40');
   echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='ajoutligne' value='Ajouter'><input type='Submit' name='bouton_annul_ligne' value='Annuler'>
            </th>
         </tr></table> ";
      echo"   </form> "  ;
	   echo "</center>";

         }
   else{
   echo "<center><b>seul le service scolarit� peut effectuer cette operation</b><br>";
      echo "aucune modification effectu�e<br></center>";

} //fin du else $login ==

      }
if($_GET['delligne']!='') { //--------------- Suppression de la ligne d'absence-------------------

if($login == 'administrateur' or in_array($login,$scol_user_liste)){
   $query = "DELETE FROM $table2"
      ." WHERE lignes_absence_id='".$_GET['delligne']."'";
	     $result = mysql_query($query,$connexion ); 
		 echo afficheresultatsql($result,$connexion);
		 } 
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune suppression effectu�e<br></center>";

} //fin du else $login ==
}

if($_GET['modfiche']!=''  or $_GET['delligne']!='' or $_POST['bouton_annul_ligne']!=''){
$affichetout=0;
//if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqu� sur le lien details ou quon revient de suppression ligne ou ajout ligne 

 $query = "SELECT * FROM $table 
					  where id_absence=".$_GET['mod']." order by date_debut ";
					  //echo $query;

  $result = mysql_query($query,$connexion );
$universite=mysql_fetch_object($result) ;
   //on fait une boucle pour cr�er les variables issues de la table
   foreach($champs as $ci2){
   $$ci2=$universite->$ci2;
   }
		   //on surcharge les dates pour les pbs de format
		   //on surcharge les dates pour les pbs de format
        $date_debut=mysql_DateTime($universite->date_debut)  ;
        $date_fin=mysql_DateTime($universite->date_fin) ;
		$date_modif=mysql_Time($date_modif);
//$date_fin= preg_replace('/^(.{4})-(.{2})-(.{2})$/','$3.$2.$1', $date_fin);
		//on r�cup�re les champs li�s
     
         
//  echo"<input type='hidden' name='modif' value=1>";
 echo" <h2><center>dispense d'activit�s p�dagogiques de ".$nom_etud."</h2></center>  <BR>";
     echo    "<form method=post action=$URL> ";

    echo"<input type='hidden' name='id_absence' value=\"$id_absence\">   ";
  echo"<center>";
  echo"       <table><tr>  ";
  //on met en hidden le  code_etud

echo"<input type='hidden' name='code_etu' value=\"".stripslashes(($_GET['code_etu']))."\">"."\n";
  echo affichechamp('Nom','affiche nom',$etudiants_nom[$_GET['code_etu']],'','1');
  	   echo "</tr><tr>";
      echo affichechamp('Date d�but (jj/mm/aaaa)','date_debut',$date_debut,10,'');
	  echo affichechamp('Date fin (jj/mm/aaaa)','date_fin',$date_fin,10,'');
	   echo "</tr><tr>";
   echo affichechamp('Motif','motif',$motif,'50','');	 
	   echo "</tr><tr>";
	echo affichemenunc('Valid� par la direction','absence_justif',$listeouinon,$absence_justif);
	echo affichemenunc('justificatif fourni','valide',$listeouinon,$valide);

 echo "</tr><tr>";

    echo affichechamp('modifi� par','modifpar',$modifpar,'15',1);
    echo affichechamp('le','date_modif',$date_modif,'15',1);
    echo "</tr><tr>";
	
	
	  // on peut venir de scol.php ou de fiche.php
	  // la fin du formulaire est diff�rente
	  if ($_GET['fromfichescol'])
		{
		echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'>";
		echo "</tr></table>";
		echo "<br><A href=scol.php?code_etu=".$_GET['code_etu']." > REVENIR � la fiche de scolarit� de ".$etudiants_nom[$_GET['code_etu']]." </a>";
		echo "<br><A href=fiche.php?code=".$_GET['code_etu']." > REVENIR � la fiche de ".$etudiants_nom[$_GET['code_etu']]." </a>";
		}
		if ($_GET['fromfiche']  or $_GET['modfiche']!='' or $_POST['bouton_annul_ligne']!='' or $_GET['delligne']!='')
		{
		 if($login == 'administrateur' or in_array($login,$scol_user_liste) ){
		 echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'>";
		 
		 }
		echo "</td></tr><tr>";
		echo "</tr></table>";
		//echo "<br><A href=fiche.php?code=".$_GET['code_etu'].$filtre." > REVENIR � la fiche de ".$etudiants_nom[$_GET['code_etu']]." </a>";
		}
  // echo afficheonly("","D�tail de cette dispense d'activit�s p�dagogiques",'b' ,'h3');
	// echo "</tr><tr>";
	// echo "<td></td>";
	
	// echo "</tr><tr>";
	// echo"<td>" ;	
	// echo "<table border=1>";
	// echo "<th>heure d�but</th><th>heure fin</th><th>Dispense autoris�e (oui / non ) par</th>";
	 // $query2 = "SELECT * FROM lignes_absence where lignes_absence_id_absences = '".$_GET['mod'] ."' order by lignes_absence_heure_deb " ;
	// echo $query2;
    // $result2 = mysql_query($query2,$connexion ); 
	// while($u=mysql_fetch_object($result2)) {

// echo"   <tr><td>" ;  
      // echo  $u->lignes_absence_heure_deb;
      // echo"   </td><td>" ;
     // echo  $u->lignes_absence_heure_fin  ;
      // echo"   </td><td>" ;
      // echo $u->lignes_absence_validby;
	   // echo "   </td><td nowrap>";
	   	// if($login == 'administrateur' or in_array($login,$scol_user_liste) ){
         // echo "<A href=".$URL."?delligne=".$u->lignes_absence_id."&mod=".$u->lignes_absence_id_absences."&code_etu=".$_GET['code_etu'];
         // echo" onclick=\"return confirm('Etes vous s�r de vouloir supprimer cette ligne ?')\">sup</A> ";}
         // echo "</td></tr> ";
	  
	  
	  
     // echo"        </td> </tr>";
	 // }
	// echo"</table>";
	// echo"   </td>" ; 
	// echo "</tr><tr>";
	// if($login == 'administrateur' or in_array($login,$scol_user_liste) ){
	// echo "<br><br><A href=".$URL."?addligne=oui&mod=".$_GET['mod']."&code_etu=".$_GET['code_etu']." > Ajouter une heure</a><br><br>";
	// }
	echo "<br><A href=fiche.php?code=".$_GET['code_etu']." > REVENIR � la fiche de  ".$etudiants_nom[$_GET['code_etu']]." </a>";	
  echo"</center>";
   //   }
	  }
	  
 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqu� sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour cr�er les variables issues de la table stage
 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
		
	 echo" <h2><center>Ajout d'une dispense d'activit�s p�dagogiques de ".$nom_etud."</h2></center>  <BR>";	
  echo    "<form method=post action=$URL> ";
  echo"     <center>  <table><tr> ";
  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
  //on met en hidden le code etud

echo"<input type='hidden' name='code_etu' value=\"".stripslashes(($_GET['code_etu']))."\">"."\n";
  echo affichechamp('Nom','affiche nom',$etudiants_nom[$_GET['code_etu']],'','1');
    echo affichechamp('Email','etudiant_email',$etudiants_email[$_GET['code_etu']],'','1');
  	   echo "</tr><tr>";

      echo affichechamp('date de d�but de l\'absence(jj/mm/aaaa)','date_debut',$date_debut,10,'');
	  	   echo "</tr><tr>";
	        echo affichechamp('date de fin de l\'absence(jj/mm/aaaa)','date_fin',$date_fin,10,'');
	   echo "</tr><tr>";
	   
		        echo affichechamp('motif','motif',$motif,50,'');
				
    echo "</tr><tr>";
	echo affichemenunc('Valid� par la direction','absence_justif',$listeouinon,$absence_justif);
	echo affichemenunc('justificatif fourni','valide',$listeouinon,$valide);
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'>
  <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table>  </center> </form> "  ;
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
       echo $message;
	   
	   

  
// --------------------------------------s�lection de toutes les fiches et affichage
	  	     if ($afficheliste){
	if ($_GET['stats']=='oui')
	{
	$query = "SELECT absences.*,etudiants.Nom,etudiants.`Pr�nom 1`,etudiants_scol.annee FROM `absences` left outer join etudiants on absences.code_etud=etudiants.`Code etu` left outer join etudiants_scol on etudiants_scol.code=etudiants.`Code etu`  ";
	$query.=$where."  ";
   $query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//echo "<br><A href=default.php > Revenir � l'accueil </a><br><br>";

		echo"<center> <h2>Liste des ".$nombre."  dispenses d'activit�s p�dagogiques ";
		echo" </h2></center>  <BR>";
		    echo "<center><a href=default.php>    revenir � l'accueil</a>  </center>";
		
		echo"<BR><table border=1> ";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
		echo "<th>d�but</th> <th>fin</th><th>Nom</th><th>Ann�e</th><th>groupe</th><th>motif</th><th>valid�e</th>";
		//on initialise  $csv_output
 $csv_output="";
 $csv_output .="d�but".";"."fin".";"."nom".";"."annee".";"."groupe".";"."motif".";"."valide".";";
 $csv_output .= "\n";
		while($universite=mysql_fetch_object($result)) {
		 //on fait une boucle pour cr�er les variables issues de la table absence
		   foreach($champs as $ci2){
		   $$ci2=$universite->$ci2;
		   }
			//on surcharge les dates pour les pbs de format
	        $date_debut=mysql_DateTime($universite->date_debut)  ;
	        $date_fin=mysql_DateTime($universite->date_fin) ;
			//on r�cup�re les champs li�s    
			echo"   <tr><td>" ;
			echo $date_debut;
		      echo"   </td><td>" ;
			echo $date_fin;
			echo"   </td><td>" ;			
			echo $universite->Nom;	
			echo"   </td><td>" ;
			echo substr($universite->annee,0,2);	
			echo"   </td><td>" ;
			echo $universite->annee;		
			echo"   </td><td>" ;
			echo $motif;
	      echo"   </td><td>" ;
		  echo $valide;
		$csv_output .=$date_debut.";".$date_fin.";".$universite->Nom.";".substr($universite->annee,0,2).";".$universite->annee.";".$motif.";".$valide.";";
		   $csv_output .= "\n";
	     //echo " <A href=".$URL."?del=".$id_absence."&code_etu=".$_GET['code_etu']." onclick=\"return confirm('Etes vous s�r de vouloir supprimer cette dispense d'activit�s p�dagogiques ?')\">";
	     //echo "sup</A> - ";
	     //echo "<A href=". $URL."?modfiche=oui&mod=".$id_absence."&code_etu=".$_GET['code_etu'].">d�tails</A>";
	     echo"        </td> </tr>";
       }

		 echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
				echo"</table> ";
	}
	else
	{
   $query = "SELECT * FROM $table ";
   $query.=$where."  ";
   $query.=$orderby."  ";   
   //echo $query;
   $result = mysql_query($query,$connexion ); 
	$nombre= mysql_num_rows($result);
	//echo "<br><A href=default.php > Revenir � l'accueil </a><br><br>";
	if ($nombre>0)
	{

		echo"<center> <h2>Liste des   ";
		echo $nombre;
		echo" dispense(s) d'activit�s p�dagogiques de ".$nom_etud."</h2></center>  <BR>";
		echo "<A href=".$URL."?add=1&code_etu=".$_GET['code_etu']." > Ajouter une dispense d'activit�s p�dagogiques </a><br>";
		echo "<br><A href=fiche.php?code=".$_GET['code_etu']." > REVENIR � la fiche de  ".$etudiants_nom[$_GET['code_etu']]." </a>";	
	}
	else{
	echo"<center> <h2>Il n'existe pas de dispenses d'activit�s p�dagogiques enregistr�es    ";
	echo" pour $nom_etud</h2></center>  <BR>";
	echo "<A href=".$URL."?add=1&code_etu=".$_GET['code_etu']." > Ajouter une dispense d'activit�s p�dagogiques </a><br>";
	echo "<br><A href=fiche.php?code=".$_GET['code_etu']." > REVENIR � la fiche de  ".$etudiants_nom[$_GET['code_etu']]." </a>";
		}

		if ($nombre>0){
		echo"<BR><table border=1> ";
		echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";
		echo "<th>d�but</th><th>fin</th><th>motif</th><th>valid�e</th><th>justifi�e</th>";
		while($universite=mysql_fetch_object($result)) {
		 //on fait une boucle pour cr�er les variables issues de la table stage
		   foreach($champs as $ci2){
		   $$ci2=$universite->$ci2;
		   }
				   //on surcharge les dates pour les pbs de format
		        $date_debut=mysql_DateTime($universite->date_debut)  ;
		        $date_fin=mysql_DateTime($universite->date_fin) ;
				//on r�cup�re les champs li�s    	 
			 //$modifpar=odbc_result($result,"modifpar") ;
		      echo"   <tr><td>" ;
				echo $date_debut;
		      echo"   </td><td>" ;
				echo $date_fin;
		      echo"   </td><td>" ;
			echo $motif ;
			echo"   </td><td>" ;
			echo $absence_justif ;   
			echo"   </td><td>" ;
			echo $valide ;
			echo"   </td><td>" ;
		     echo " <A href=".$URL."?del=".$id_absence."&code_etu=".$_GET['code_etu']." onclick=\"return confirm('Etes vous s�r de vouloir supprimer cette dispense d\'activit� ?')\"" ;
		     echo ">sup</A> - ";
		     echo "<A href=". $URL."?modfiche=oui&mod=".$id_absence."&code_etu=".$_GET['code_etu'].">d�tails</A>";
		     echo"        </td> </tr>";
		       }
			   //echo "</form>";
				echo"</table> ";
					}
	  }


  }
  }
mysql_close($connexion);  
?>
</body>
</html>