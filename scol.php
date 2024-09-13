<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<title>gestion des etudiants scolarite</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);


if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod']='';
if (!isset($_POST['bouton_synchro'])) $_POST['bouton_synchro']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['synchro'])) $_GET['synchro']='';

if (!isset($_POST['fromfic'])) $_POST['fromfic']='';

$message='';
$sql1='';
$filtreok='';
$URL =$_SERVER['PHP_SELF'];;
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
$etudiants_code2[]=$v["Code etu"];
}

$liste_champs_dates=array('date_diplome','date_demande_badge','date_remise_badge','date_retour_badge' );


echo"<center>   ";
// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' ) {

          //inutile

}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
   //inutile
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod'] !=''){


  if((in_array ($login ,$re_user_liste )) or (in_array ($login ,$scol_user_liste )) or (in_array ($login ,$accueil_user_liste ))){

      //pour modifpar
$_POST['modifpar']=$login;

foreach($champs as $ci2){

 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
  if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }

         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));

 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle generee automatiquement par sqlserver
 if ($ci2=="code"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2."=now(), ";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;

   //$query = "UPDATE $table SET email='$_POST[email]',nom='$_POST[nom]'";
   $query = "UPDATE $table SET $sql1";
   $query .= " WHERE code='".$_POST['code']."' ";
   //echo $query;
   $result = mysql_query($query,$connexion ); 
   		$message.= afficheresultatsql($result,$connexion);
   
        }
        else{
   echo "<b>seule la scolarité peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $login ==
} //fin du elseif
//--------------------------------- synchro des fichiers etudiants et etudiants_scol 
elseif($_POST['bouton_synchro']=='OK' ){
echo"synchro en cours ...";

$supscol=0;
$suplignegpe=0;
//on parcourt la table  etudiants




$sqlquery="SELECT * FROM etudiants  order by nom";
$resultat=   mysql_query($sqlquery,$connexion ); 
$existe=0;
$cree=0;
$cree3=0;
$cree4=0;
while ($e=mysql_fetch_object($resultat)){

   //pour chaque code etudiant on verifie si la fiche scol associee existe
     $query = "SELECT * FROM $table where code= '".$e->$myetudiantscode_etu ."' order by code";
    $result = mysql_query($query,$connexion ); 
   //   si elle existe 
	if (mysql_num_rows( $result)!=0)
	{
	// on ne fait rien
	 $existe++;;
	   // on verifie le gpe principal	   
	 }

      else {
			 //sinon on la crée

			            $query2 = "INSERT INTO $table(code) VALUES('".$e->$myetudiantscode_etu."')";
             $result2 = mysql_query($query2,$connexion);
             $cree++;
			 
			 {
		    // ce sont donc des  nouveaux arrivés on les mets dans le groupe spécial import apogee,  si ils n'y sont pas déjà 			
			//  avant d'insérer la ligne , il faut vérifier si cet étudiant n'existe pas déjà  ds ce gpe
			$query4="select *  from  ligne_groupe where code_groupe='".$code_gpe_imp_apo."' and code_etudiant='".$e->$myetudiantscode_etu."'";
			$result4=mysql_query($query4,$connexion ); 
			if (mysql_num_rows($result4)==0)
				{
					$query3 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif) VALUES('".$code_gpe_imp_apo."','".$e->$myetudiantscode_etu."','imp','".$login."',now())";
				   //echo $query3;
				   $result3 = mysql_query($query3,$connexion);
				   	$cree3++;
				}
			else
				{
				echo "etudiant numero ". $e->$myetudiantscode_etu . " déjà inscrit dans le groupe import apogee <br>";
						echo "<br>";
				}

			   // et on indique l'etape ds le gpe principal
			   //il faut determiner l'annee à partir du code etape
	           $cod_etape = $e->$myetudiantscode_étape;
	           $annee_etp = $e->$myetudiantsnb_inscr_etp;
	           switch($cod_etape)
			   {		          
				   case "GSTG+":
		           $lib_etape='ex stagiaire international';
		           break;
				   case "G3AN3+":
		           $lib_etape='ex 3A';
		           break;
		           case "G3AN3":
		           if ($annee_etp > 1){
		           $lib_etape="4A";}
		           else {
		           $lib_etape="3A";}
		           break;
		           default :
		           //$lib_etape=substr($cod_etape,4,1)."A";
				   $lib_etape=$cod_etape;
				   $query5="update $table set annee='import-apogee ".$lib_etape."-".$e->$myetudiantsdate_iae."' where code ='".$e->$myetudiantscode_etu."'";
				   echo $query5 ."<br>";
				   //$result5 = mysql_query($query5,$connexion);
				   $cree4++;
				}
	     }
			 
      }
      }

      //suppression des fiches liées aux fiches absentes du  nouvel import ds scol
      $query = "SELECT * FROM $table ";
      $resultat=mysql_query($query,$connexion);
      while ($e=mysql_fetch_object($resultat)){
             //pour chaque code etudiant_scol on verifie si la fiche etudiant  associee existe
     $query = "SELECT * FROM etudiants where etudiants.`Code etu`= '".$e->code ."' ";
    //echo $query."<br>";
    $result = mysql_query($query,$connexion);
   //   si elle existe on ne fait rien
       if (mysql_num_rows($result)!=0){

	   
 //      echo odbc_result($result,"Code etu")." existe aussi ds etudiants donc on ne fait rien <br>";
     }
    //sinon
      else {
        //on le supprime dans lignes_groupe
		// on choisit si on teste ou si on supprime vraiment
          // $query4 = "DELETE from ligne_groupe WHERE code_etudiant='".$e->code ."'";
			 $query4 = "select * from ligne_groupe WHERE code_etudiant='".$e->code ."'";
			 $result4 = mysql_query($query4,$connexion);
            echo "  suppression de ".$e->code ." dans ".mysql_num_rows($result4) ."  groupes  <br>";



        //et on supprime sa fiche scol

            $query2 = "DELETE from $table WHERE code='".$e->code ."'";
            echo "  suppression  de la fiche scol de ".$e->code . "<br>";
          //   $result2 = mysql_query($query2,$connexion);
             $supscol++;
           }
      }






      echo "<br>resultat ".$cree ." fiches de scol on été créées<br>";
	        echo "<br>resultat ".$cree3 ." etudiants ont été ajoutés au groupe import_apogee<br>";
			echo "<br>resultat ".$cree4 ." information(s) : import apogee + code etape ont été ajoutés car gpe principal vide <br>";
       echo $existe." fiches existaient déjà<br>";
       echo $supscol." fiches orphelines de scolarité ont été supprimées<br>";
               //   on met à jour la date et l'heure dans la table param
        echo "<br>et on met à jour la date et l'heure dans la table param <br>";
        $query = "UPDATE param SET date_import_apo=now() WHERE config='1'";
       // $result = mysql_query($query, $connexion);
}

       echo $message;
// --------------------------------------sélection de toutes les fiches et affichage

  if((in_array ($login ,$re_user_liste )) or (in_array ($login ,$scol_user_liste )) or (in_array ($login ,$accueil_user_liste ))){

//si on n'a pas appuyé sur le bouton detail ou  kon a appuyé sur le bouton annuler de la fiche on affiche la page d'accueil et si on arrive pas de fiche.php
if((!$_POST['mod']!='' or $_POST['bouton_annul']!='')and !$_GET['code_etu']!='')  {

//si on est parti de fiche.php on saute l'affichage complet
if ( !$_POST['fromfic'] ){
 //$query="SELECT $table.*,etudiants.* FROM $table left outer join etudiants on upper($table.Code)=etudiants.`Code etu` order by etudiants.nom;";
  //  $result = mysql_query($query, $connexion);
  echo "<center><table  border=0>";
  echo "<tr><td>";
echo" sélectionnez un étudiant ";
echo    "<form method=post action=$URL> ";
//echo " <br>  <select name='code_etudiant'>  ";

  // for($i=0;$i<sizeof($etudiants_nom);$i++) {
    //les  2 lignes ci dessous sont une autre solution pour un recuperer les codes correspondant aux noms
     // echo "  <option  value=\"".current($etudiants_code)."\">";
    //echo current($etudiants_nom);
    // next($etudiants_nom);
     // next($etudiants_code);
   // echo"</option> " ;

   // }
  // echo"</select> " ;

   echo " <br>  <select name='code_etudiant'>  ";
   for($i=0;$i<sizeof($etudiants_code2);$i++) {
 $temp= $etudiants_code2[$i];
      echo "  <option  value=\"".$temp."\">";
    echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp]);
    echo"</option> " ;
 }
      echo"</select> " ;
	  
	  
   echo "<input type='Submit' name='mod' value='détails'> ";
     echo "</tr><tr>";
     $query2="SELECT * from param where config=1";
   $result2 = mysql_query($query2, $connexion);
   $e=mysql_fetch_object($result2);
     $date_import_apo= $e->date_import_apo;
       $date_import_annu= $e->date_import_annu;
    echo affichechamp('version apogee','date_import_apo',mysql_time($date_import_apo),'15',1);
    echo affichechamp('version annuaire','date_import_annu',mysql_time($date_import_annu),'15',1);
echo "<br><br><A href=".$URL."?synchro=1 > synchronisation scolarite avec apogee </a><br>";
}
//si on est parti de fiche.php
 else{

 //on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
$filtre ="&annee=".$_POST['promo']."&code_groupe_peda=".$_POST['code_groupe_peda']."&nom_recherche=".urlencode($_POST['nom_recherche'])."&options=".urlencode($_POST['options']);
$filtre.="&recherche_avance=".$_POST['recherche_avance']."&mon_champ=".urlencode($_POST['mon_champ'])."&code_etu_recherche=".urlencode($_POST['code_etu_recherche']);
$filtreok=$filtre."&bouton_ok=OK";
 $temp=$_POST['code'] ;
  echo "<br><A href=fiche.php?code=".$temp.$filtre." > Revenir à la fiche de ".$etudiants_nom[$temp]."</a><br><br>";
 }
 
echo "<br><A href=absences.php?stats=oui".$filtreok." > Récapitulatif des absences </a><br>";
echo "<br><br><A href=default.php?".$filtreok." > Revenir à l'accueil </a><br><br>";
}
if($_POST['mod']!=''  or $_GET['code_etu']!='' ){
  //------------------------------------c'est kon a cliqué sur le lien details ou qu'on est arrivé depuis fiche.php

   echo    "<form method=post action=$URL> ";
   echo "Modification des informations hors-apogée d'un étudiant ";

   			    	
     //si on est arrivé depuis fiche.php 
	 
   if ( $_GET['code_etu'] ){
   $code_etu=$_GET['code_etu'];
 		//on passe en hidden tous les arguments reçu en GET ( si on arrive par fiche.php)

	 foreach($_GET as $x=>$ci2)	
	  {
		  if(1)
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
   }
   //si on est pas arrivé depuis fiche.php
   else {$code_etu=$_POST['code_etudiant'];
   $_GET['code_etu']=$_POST['code_etudiant'];
   }
  $query = "SELECT $table.*,etudiants.*  FROM $table  ";
  $query=$query." left outer join etudiants on upper($table.Code)=etudiants.`Code etu`";
  $query=$query."where code='".$code_etu."'" ;
  //echo $query;
   $result = mysql_query($query,$connexion);
   $e=mysql_fetch_object($result);
   //on fait une boucle pour créer les variables issues de la table 
   foreach($champs as $ci2){
   $$ci2=$e->$ci2;
   		  //si c'est une date//petit bidouillage sur les dates
		   //on surcharge les dates pour les pbs de format
		if (in_array($ci2,$liste_champs_dates)){
		$$ci2=mysql_Datetime($e->$ci2);
		}
   }
         //$code= $e->code;
         //$annee= $e->annee;
         //$redoublant= $e->redoublant;
         //$admis_sur_titre= $e->admis_sur_titre;
         //$cursus_specifique= $e->cursus_specifique;
         //$double_cursus= $e->double_cursus;
         //$accueil_echange= $e->accueil_echange;		 
		 //$num_secu= $e->num_secu;
         $nom= $e->Nom;
         $prenom= $e->$myetudiantsprénom_1;
         $modifpar=$e->modifpar;
         $date_modif=$e->date_modif;
		 $annee_inscr=$e->$myetudiantsannée_univ;
		 //on surcharge les dates pour les pbs de format

		 
		 
        //$date_diplome=mysql_DateTime($e->date_diplome)  ;

          echo"<input type='hidden' name='code' value=\"$code\">   ";
                echo""; 
              echo"       <table><tr>  ";
			  echo afficheonly("","Informations de scolarité",'b' ,'h3');
			  echo "</tr><tr>"; 

              echo affichechamp('nom étudiant','nom',$nom,'',1);
              echo affichechamp('prénom','prenom',$prenom,'',1);
			  echo affichechamp('dernière inscription','annee_inscr', $annee_inscr,'5',1);
               echo "</tr><tr>";               
			   //$liste4a=array('1A','2A','3A','4A','Stagiaire international','Master Recherche','ex divers') ;
			  //echo affichemenu('annee','annee',$liste4a,$annee);
				//echo "<td>";
				//echo "groupe principal<br>";
				              echo affichechamp('groupe principal','annee',$annee,'',1);
				if( (in_array ($login ,$re_user_liste ))  or (in_array ($login ,$scol_user_liste ))){

              echo affichemenu('redoublant','redoublant',$liste1a,$redoublant);
              echo "</tr><tr>";

              echo affichemenu('double cursus','double_cursus',$listedc,$double_cursus);
              echo affichemenu('admis sur titre','admis_sur_titre',$liste1a,$admis_sur_titre);
				$listeechacc=array('Non','S1 accueil','S2 accueil','Année accueil') ;
			  //echo affichemenu('Echange Accueil','accueil_echange',$listeechacc,$accueil_echange);
              echo "</tr><tr>";
              echo affichechamp('cursus spécifique','cursus_specifique',$cursus_specifique);

			   //echo affichechamp('numéro SS','num_secu',$num_secu);
              echo affichechamp('date diplome (jj/mm/aa) ','date_diplome',$date_diplome,'8');
			  }
			  else
			  // pour accueil les memes en RO
			  {
			   echo affichechamp('redoublant','redoublant',$redoublant,'3',1);
			   echo affichechamp('double cursus','double_cursus',$double_cursus,15,1);
			   //echo affichechamp('Echange Accueil','accueil_echange',$accueil_echange,15,1);
			                 echo "</tr><tr>";
			   echo affichechamp('cursus spécifique','cursus_specifique',$cursus_specifique,'',1);
			  //echo affichechamp('numéro SS','num_secu',$num_secu,'',1);
              echo affichechamp('date diplome (jj/mm/aa) ','date_diplome',$date_diplome,'8',1);
			   
			  }
				echo "</tr><tr>"; 
		    	echo afficheonly("","Badges",'b' ,'h3');
					echo "</tr><tr>"; 
					//echo affichechamp('date demande (jj/mm/aa) ','date_demande_badge',$date_demande_badge,'8');
					echo affichechamp('numéro','num_badge',$num_badge,4);
					echo "</tr><tr>"; 
					echo affichechamp('date remise (jj/mm/aa) ','date_remise_badge',$date_remise_badge,'8');
					$listecaution=array('Chèque','Espèces','NC') ;
					if ($caution_badge==''){
					$caution_badge='NC';
					}
					echo affichemenu('caution','caution_badge',$listecaution,$caution_badge);
					echo "</tr><tr>"; 
					echo affichechamp('date retour (jj/mm/aa) ','date_retour_badge',$date_retour_badge,'8');
					$listeouinon=array('oui','non') ;
					if ($badge_perdu==''){
					$badge_perdu='non';
					}
					echo affichemenu('Perdu ou volé','badge_perdu',$listeouinon,$badge_perdu);
	               echo "</tr><tr>"; 		
					echo "<td colspan=2 >commentaires<br><textarea name='commentaire_badge' rows=3 cols=50>".$commentaire_badge."</textarea></td> ";	
	               echo "</tr><tr>"; 						
               echo affichechamp('modifié par','modifpar',$modifpar,'20',1);
               echo affichechamp('le','date_modif',mysql_Time($date_modif),'15',1);
 
   echo "</td></tr><th colspan=6><input type='Submit' name='bouton_mod' value='modifier'>
   <input type='Submit' name='bouton_annul' value='revenir'></th></tr></table></form> "  ;

  
   //affichage des absences on ne passe plus par la fiche de scol
 //$query2="select * from absences where code_etud='".$code_etu."'";
   // $result2 = mysql_query($query2,$connexion ); 
	//if (mysql_num_rows( $result2) !=0){
	//echo "<table border=0>";
	//echo afficheonly("","Absences",'b' ,'h3');	
		             //echo "</tr><tr>";               
	//echo "<table border=1>";
	//echo "<th>début</th><th>fin</th><th>motif</th><th>justifiée</th>";
	//while($u=mysql_fetch_object($result2)) {
		//echo"   <tr><td>" ;  
		//echo  mysql_DateTime($u->date_debut);
		//echo"   </td><td>" ;
		//echo  mysql_DateTime($u->date_fin)  ;
		//echo"   </td><td>" ;
		//echo $u->motif ;
		//echo"   </td><td>" ;
		//echo $u->valide ;
		//echo"   </td><td>" ;
		//echo " <A href=absences.php?del=".$u->id_absence."&code_etu=".$_GET['code_etu']." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cette absence ?')\">";
     //echo "sup</A> - ";
		 // echo "<A href=absences.php?modfiche=oui&mod=".$u->id_absence ."&code_etu=".$_GET['code_etu']."&fromfichescol=1>détails</A>";
	//	  echo"        </td> </tr>";
	// }
	 
	//echo"</table>"; 
	 //echo "</tr><tr>"; 

  //echo" </form> "  ;
		//echo "</table >";	
	//}
	//echo"<br><br>";

	//echo"<td><a href=absences.php?add=1&code_etu=".$_GET['code_etu'].">Ajouter une dispense d'activités pédagogiques pour  ".$etudiants_nom[$_GET['code_etu']]. "</a></td>";
	  echo"</center>";
      }
	  
	  }
	  else{
   echo "<b>seule la scolarité peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";}

  if($_GET['synchro']!='')  {
 //---------------------------------------c'est kon a cliqué sur le lien synchroniser
 if ($login == 'administrateur' ){
     echo"       <table><tr> ";
  //if ($_POST[bouton_add]){
  echo"<input type='hidden' name='synchro' value=1>";
  //}
  //si on revient  du choix du codepost

   echo"<center>";
   echo "êtes vous sur de vouloir synchroniser la table ?";
    echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_synchro' value='OK'><input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";

        }
        else
        { 
   echo "<b>seul l'administrateur peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br>";
         }  //fin du else
        } //fin du if $_GET[synchro])
echo "</center> " ;
echo"</body>";
echo "</html>";
mysql_close($connexion);
?>