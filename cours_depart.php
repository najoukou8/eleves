<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>gestion des departs à l'étranger</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<?
require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
//si on vient de la fiche.php on remet  les parametres  ds l'url  pour retrouver l'environnement de départ
if (isset($_GET['fromfic'])){
 $filtre ="&code_groupe_peda=".$_GET['code_groupe_peda']."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($_GET['options']);
$filtre.="&recherche_avance=".$_GET['recherche_avance']."&annee=".$_GET['annee']."&mon_champ=".urlencode($_GET['mon_champ'])."&code_etu_recherche=".urlencode($_GET['code_etu_recherche']);
$filtreok=$filtre."&bouton_ok=OK";
}
else{
$filtre='';
$filtreok='';
}
$liste_champs_dates=array();
$liste_champs_dates_courts=array();
$liste_champs_dates_longs=array('date_modif');
$villecode='';
$message='';
$message_entete='';
$sql1='';
$sql2='';
$afficheliste=1;
$self=$_SERVER['PHP_SELF'];
if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_POST['modif'])) $_POST['modif']='';
if (!isset($_POST['code_etu_filtre'])) $_POST['code_etu_filtre']='';
if (!isset($_POST['code_ent_filtre'])) $_POST['code_ent_filtre']='';
if (!isset($_POST['bouton_cp_mod'])) $_POST['bouton_cp_mod']='';
if (!isset($_POST['bouton_cp_adm_mod'])) $_POST['bouton_cp_adm_mod']='';
if (!isset($_POST['bouton_cp'])) $_POST['bouton_cp']='';
if (!isset($_POST['bouton_cp_adm'])) $_POST['bouton_cp_adm']='';
if (!isset($_POST['bouton_cp_add'])) $_POST['bouton_cp_add']='';
if (!isset($_GET['del'])) $_GET['del']='';
if (!isset($_GET['code_etu'])) $_GET['code_etu']='';
if (!isset($_GET['code_ent'])) $_GET['code_ent']='';
if (!isset($_GET['nom_ent'])) $_GET['nom_ent']='';
if (!isset($_GET['mod'])) $_GET['mod']='';
if (!isset($_GET['add'])) $_GET['add']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_POST['code_etudiant'])) $_POST['code_etudiant']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['villecp'])) $_POST['villecp']='';
if (!isset($_POST['imp_convention'])) $_POST['imp_convention']='';
if (!isset($_GET['st_mon_champ'])) $_GET['st_mon_champ']='';
if (!isset($_GET['st_recherche'])) $_GET['st_recherche']='' ;
if (!isset($_GET['st_recherche_avance'])) $_GET['st_recherche_avance']='' ;
if (!isset($_GET['st_orderby'])) $_GET['st_orderby']='' ;
if (!isset($_GET['st_inverse'])) $_GET['st_inverse']='' ;
if (!isset($_GET['st_bouton_ok'])) $_GET['st_bouton_ok']='';
if (!isset($_GET['code_depart'])) $_GET['code_depart']='';
if (!isset($_POST['id_depart'])) $_POST['id_depart']='';
if ($_GET['st_orderby']=='') {$orderby='ORDER BY code_cours';}

	else{
	$orderby=urldecode($_GET['st_orderby']);
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
	$orderby="ORDER BY ".$orderby;
                  if  ($_GET['st_inverse']=="1"){
                  $orderby=$orderby." desc";
                  }
	}
// pour tester comme un autre
// il faut récupérer la valeur de clone et num etudiant qui pourrait être passée par un formulaire en hidden
if (isset($_POST['clone']))$_GET['clone']=$_POST['clone'];
//if (isset($_POST['code_etu']))$_GET['code_etu']=$_POST['code_etu'];

if (!isset($_GET['clone'])) $_GET['clone']='';
if (($_GET['clone']) !=''  and in_array($login,$ri_user_liste)) $login=$_GET['clone'];
$URL =$_SERVER['PHP_SELF'];
$table="cours_departs";


//si on vient de valider un ajout ou une modif il faut remmettre l'id  ds le get_var
if ($_POST['id_depart']!=''){
$_GET['code_depart']=$_POST['id_depart'];}


$tabletemp="cours_departs";
$champs=champsfromtable($tabletemp);
$taillechamps=champstaillefromtable($tabletemp);
//print_r($taillechamps);

//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces et slashs dans les noms de champs
foreach($champs as $ci){
$ci2=nettoiechamps($ci,$tabletemp);
$$ci2=$ci;
}

//on remplit 2 tableaux avec les nom-code  etudiants
$sqlquery2="SELECT * FROM etudiants  order by nom";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
//on remplit un tableau indice avec les noms etudiants pour le select du formulaire
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Prénom 1"];
}
//on remplit 2 tableaux avec les noms-codes universites
$sqlquery2="SELECT * FROM universite order by nom_uni ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["nom_uni"] ;
$ind2=$v["id_uni"];
//on remplit un tableau associatif avec les noms universites  pour le select du formulaire
$universites_nom[$ind2]=$v["nom_uni"];
$universites_ville[$ind2]=$v["ville"];
//on remplit un tableau associatif avec les codes universites pour le insert
$universites_code[$ind]=$v["id_uni"];
$universites_code2[]=$v["id_uni"];
}
     $sqlquery2 = "SELECT etudiants.Nom AS nom_etud ,etudiants.`prénom 1` AS prenom_etud ,etudiants_scol.annee,universite.*   ,departs.* FROM departs  
	 left outer join etudiants on upper(etudiants.`Code etu`)=departs.code_etudiant       
	 left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code 
	left outer join universite on  code_periode=universite.id_uni 
	 ";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
//$ind=$v["semestre"] ;
$ind2=$v["code_depart"];
//on remplit un tableau associatif avec les noms universites  pour le select du formulaire
//$depart_nom[$ind2]=$v["semestre"] ;
$depart_nom_etud[$ind2]=$v["nom_etud"] ;
$depart_universite[$ind2]=$v["nom_uni"] ;
$depart_ville[$ind2]=$v["ville"] ;
//on remplit un tableau associatif avec les codes universites pour le insert
//$depart_code[$ind]=$v["code_depart"];
$depart_code2[]=$v["code_depart"];
}


$tabletemp="cours_departs";
$st_champs=champsfromtable($tabletemp);




if($_POST['ajout']!='') { // ------------Ajout de la fiche--------------------
if($login == 'administrateur' or in_array($login,$ri_user_liste)){

$_POST['modifpar']=$login;
//pour les credits ects mal saisis
$_POST['ects']=nettoiefloat($_POST['ects']);
foreach($champs as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 // attention aux valeurs par defaut :
$_POST['verrouille']='non';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle generee automatiquement par sqlserver

   if ($ci2=="code_cours"){
 

 }
elseif ($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= "now(), ";}

  else{
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";}
 }
 //il faut enlever les virgules de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  $query = "INSERT INTO $table($sql1)";
  $query .= " VALUES($sql2)";
//echo $query."<br>";
   $result = mysql_query($query,$connexion ); 
   		 echo afficheresultatsql($result,$connexion);
}
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucun ajout effectuée<br></center>";

} //fin du else $login ==
}
elseif($_GET['del']!='') { //--------------- Suppression de la fiche--------------------

if($login == 'administrateur' or in_array($login,$ri_user_liste)){
   $query = "DELETE FROM $table"
      ." WHERE code_cours='".$_GET['del']."'";
	     $result = mysql_query($query,$connexion ); 
		 echo afficheresultatsql($result,$connexion);
		 } 
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune suppression effectuée<br></center>";

} //fin du else $login ==
}

elseif($_POST['modif']!='') { //---------------- Modif de la fiche---------------------
if($login == 'administrateur' or in_array($login,$ri_user_liste)){
//pour modifpar
$_POST['modifpar']=$login;
//pour les credits ects mal saisis
$_POST['ects']=nettoiefloat($_POST['ects']);


//pour code etudiant et entreprise on a les noms mais pas les codes :
//il faut les retrouver ds le tableau associatif



 for($i=0;$i<sizeof($champs);$i++) {
 $ci2=$champs[$i];
  $ci3=$taillechamps[$i];
   // debug echo $ci2."_".$ci3."<br>";
   //si c'est une date//petit bidouillage sur les dates

 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
  if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
 }
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
  // on tronque tout ce qui depasse la longueur du champ ds la table
  $_POST[$ci2]=tronquerPhrase($_POST[$ci2],$ci3) ;
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="code_cours"){
 //on ne fait rien
 }
 elseif ($ci2=="date_modif"){
 $sql1.= $ci2."=now(), ";}
  else{
 $sql1.= $ci2."='".$_POST[$ci2]."',";}
 }
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $query = "UPDATE $table SET $sql1";
   $query .= " WHERE code_cours='".$_POST['code_cours']."' ";
  // echo $query;
   $result = mysql_query($query,$connexion ); 
      if ($result){
   $message = "Fiche numero ".$_POST['code_cours']." modifiée <br>";
   }   else {
		echo affichealerte("erreur de saisie "). mysql_error($connexion);
		echo "<center>La fiche n'est pas modifiée</b> </center>";
		}
   }
   else{
   echo  affichealerte("Seul le service relations internationales peut effectuer cette operation");
      echo "aucune modification effectuée<br></center>";
} //fin du else $login ==

}
elseif($_POST['imp_convention']!='') { 
}

echo"<table width=100% height=100%><tr><td><center>";
echo $message;
   
    //debut
   // ___________sélection de tous les cours ou du cours de l'etudiant si arrivee depuis fiche.php________

   //$query = "SELECT etudiants.[Nom],$table.* FROM $table left outer join etudiants on $table.[code_etudiant]=etudiants.[Numéro INE] order by code_stage";
   // $query = "SELECT etudiants.[Nom],entreprises.[nom],$table.* FROM $table,etudiants,entreprises where [code_etudiant]=etudiants.[Code etu] and  [code_entreprise]=entreprises.code order by date_debut";

     //ça c'est kan on arrive depuis fiche.php ou kan on a clique apres sur details ou sup
     //ds les 2 cas on filtre la liste sur le code du depart
     if ( $_GET['mod']!='') {
    //lien pour revenir à l'accueil des stages un stage
  //echo "<br><A href=".$URL." > Revenir à la liste des cours </a><br>";

     }else
     {
     if ( $_GET['code_depart']!='') {
     //il faut aussi chercher si l etudiant n'est pas le num 2 ou le num 3 d'un stage etude de terrain
     $where="and (code_depart='".$_GET['code_depart']. "')"   ;

     //$message_entete="de ".$depart_nom_etud[$_GET['code_depart']];
	 $temp=$_GET['code_depart'];
		$affichtemp= $depart_nom_etud[$temp]."-".$depart_universite[$temp];
		$message_entete="de ".$affichtemp;
      }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter apres fiche.php
      elseif ( $_POST['code_etu_filtre']!='') {
     $where="and [code_etudiant]='".$_POST['code_etudiant']."' "   ;
     //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_etu']=$_POST['code_etudiant'];
     //pour afficher le message correct
     $message_entete="de ".$etudiants_nom[$_GET['code_etu']];
      }
      //ça c'est kan on arrive depuis entreprise.php ou kan on a clique apres sur details ou sup
     //ds les 2 cas on filtre sur le code entreprise
     elseif ( $_GET['code_ent']!='') {
     $where="and code_entreprise='".$_GET['code_ent']."' "   ;
     $message_entete="de ".$entreprises_nom[$_GET['code_ent']];
      }
      //ça c'est kan on arrive depuis le bouton modifier ou ajouter
     elseif ( $_POST['code_ent_filtre']!='') {
     $where="and code_entreprise='".$_POST['code_entreprise']."' "   ;
      //il faut remettre ds le get l'info pour que le liens ajouter soit correct
     $_GET['code_ent']=$_POST['code_entreprise'];
     $message_entete="de ".$entreprises_nom[$_GET['code_ent']];
     }
      else{
	  //si on est en recherche avancee
	    if($_GET["st_recherche_avance"]=="oui" and $_GET["st_mon_champ"]!=''){
		//il faut traiter le cas recherche avnce est egal à vide
if ($_GET['st_recherche']=='vide') {  $_GET['st_recherche']='';}
// et date est égal à NC 
if ($_GET['st_recherche']=='NC') {  $_GET['st_recherche']='01/01/1900';}
		  $where="and ".$table.".`".$_GET["st_mon_champ"]."` = '".$_GET["st_recherche"]."'";

		}
		//sinon on prend tout
		else{
      $where="";}
	  }
	  
	  

	   
	   
//____________________________________________________________________________________________________________________________
  //AFFICHAGE DES liens  pour ajouter un stage et revenir a l'accueil si pas mod et si pas retour de code postal
  	if(in_array($login,$ri_user_liste)){
		  if ( $_GET['add']!='1' and $_GET['mod']=='' and  $_POST['mod']=='' and $afficheliste) {
		  echo "<br><br><A href=".$URL."?add=1&code_depart=".$_GET['code_depart']."&code_ent=".$_GET['code_ent']."&clone=".$_GET['clone']." > Ajouter un cours</a><br><br>";
		 }
	}
  //lien pour revenir
  if ( $_GET['code_etu']!='') {
  //si on arrive depuis fiche.php
     $temp= $_GET['code_depart'] ;
      echo "<br><A href=departs.php?code_etu=".$_GET['code_etu'].$filtre."&clone=".$_GET['clone']." > Revenir à la fiche du départ de  ". $depart_nom_etud[$temp]."</a><br><br>";
    }
    else{
     echo "<br><A href=departs.php?code_etu=".$_GET['code_etu'].$filtre."&clone=".$_GET['clone']." > Revenir à la liste des départs </a><br><br>";
	 
    }
    //else{
  //dans l tous les  cas
      
	   
	
}//fin du bouton_ok=ok

  if($_GET['mod']!='' or $_POST['mod']!='' ){//--------------------------------------c'est kon a cliqué sur detail ou kon revient du code postal
  $afficheliste=0;
   echo    "<form method=post action=$URL> "; 
  if ($_GET['clone']!='')
  {
echo"<input type='hidden' name='clone' value=".$_GET['clone'].">"; 	  
  }
  if($_GET['mod'] !=''){
  //si on a cliqué sur détails
  //1ere version de la requete
//   $query = "SELECT etudiants.[Nom],entreprises.[nom],enseignants.[email],$table.* FROM $table,etudiants,entreprises,enseignants where [code_etudiant]=etudiants.[Code etu]
//    and  [code_entreprise]=entreprises.code and  [code_tuteur_gi]=enseignants.id and code_stage=$_GET[mod] order by date_debut";
   $query = "SELECT $table.* FROM $table  
WHERE     code_cours = ".$_GET['mod'];

   $result = mysql_query($query,$connexion );
$e=mysql_fetch_object($result); 
$i=1;
   //on fait une boucle pour créer les variables issues de la table 
   foreach($champs as $ci2){
   $$ci2=$e->$ci2;
   }
           //on surcharge les dates pour les pbs de format



        //on récupère les champs liés
        
        $date_modif=mysql_Time($e->date_modif) ;

    }

       
   //-------------------------------------------------------------------------------------------------debut affichage  modification de fiche
        //on fait une boucle pour remettre en hiden tous les champs  de la table stage
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        }
        echo"       <table><tr>  ";
		 echo"<input type='hidden' name='id_depart' value=\"".stripslashes(($_GET['code_depart']))."\">"."\n";
		echo afficheonly("","Le départ",'b' ,'h3');
        echo "</tr><tr>";  
		
		$temp=$code_depart;
		$affichtemp= $depart_nom_etud[$temp]."-".$depart_universite[$temp];
		echo affichechamp('Départ','departaffi',$affichtemp,'60',1);
		        echo "</tr><tr>"; 
                echo afficheonly("","Le cours",'b' ,'h3');
        echo "</tr><tr>";   

   echo affichechamp('Code du cours','code_cours_long',$code_cours_long,'10');
           echo "</tr><tr>"; 
    echo affichechamp('Intitulé du cours','intitule_cours',$intitule_cours,'50');
        echo "</tr><tr>"; 
	echo affichemenunc('Niveau','niveau',$ListeNiveauCoursDepart,$niveau);
        echo "</tr><tr>"; 		
		echo "<td colspan=2> Descriptif du cours <br>";
 echo "<textarea cols=47 rows=5  name='descriptif'>$descriptif </textarea>";			
     //echo affichechamp('Descriptif du cours','descriptif',$descriptif);
	         echo "</tr><tr>";   
	 echo affichechamp('Lien Web','url',$url,'50');        
	 echo "</tr><tr>";   
	 echo affichechamp('Crédits ECTS','ects',$ects,'5');
	 	// echo "<td  >Crédits ECTS<input type='number' step='0.1' size='5' name='ects'  value=\"".$ects."\"></td>";
	 echo affichechamp('Note','note',$note,'5');
	 	 echo "</tr><tr>";  
		 	if(in_array($login,$ri_user_liste)){	 
	 echo affichemenu('verrouillé','verrouille',$listeouinon,$verrouille);
			}
		echo "</tr><tr>";
        echo affichechamp('modifié par','modifpar',$modifpar,'20',1);

        echo affichechamp('le','date_modif',$date_modif,'15',1);
        
        echo "</tr><tr>";
        echo"        <th colspan=5>";
			if(in_array($login,$ri_user_liste)){
               echo " <input type='Submit' name='modif' value='modifier'>";
			}
				echo" <input type='Submit' name='bouton_annul' value='Annuler'>
                </th>
            </tr></table>
        </form> "  ;
}
 elseif($_GET['add']!='' or $_POST['add']!=''){ 
 //--------------------------------------------------------------------------------------------------------------------------c'est kon a cliqué sur ajouter
 $afficheliste=0;

 if($login == 'administrateur' or in_array($login,$ri_user_liste) ){
//on initialise les variables de tous les champs
 foreach($champs as $ci2){
 $$ci2='';
}

 //echo"<input type='hidden' name='ajout' value=1>";
  echo    "<form method=post action=$URL> "; 
      if ($_GET['clone']!='')
  {
echo"<input type='hidden' name='clone' value=".$_GET['clone'].">"; 	  
  }
  echo"<input type='hidden' name='id_depart' value=\"".stripslashes(($_GET['code_depart']))."\">"."\n";
        echo"       <table>";
        echo "</tr><tr>";   
		//si on arrive du detail d'une fiche de depart on met en hidden  le code depart
		if ($_GET['code_depart']!=''){
		$temp=$_GET['code_depart'];
		$affichtemp= $depart_nom_etud[$temp]."-".$depart_universite[$temp];
		echo affichechamp('Depart','departaffi',$affichtemp,'60',1);
		echo"<input type='hidden' name='code_depart' value=\"".$_GET['code_depart']."\">";
		  echo "</tr><tr>"; 
		//echo afficheonly ('code_depart' value=\"".stripslashes(($_GET['filtre_id']))."\">"."\n";
		}
		//sinon on affiche la liste 
		else{
		
          echo "<br>  periode <select name='code_depart'>  ";
   for($i=0;$i<sizeof($depart_code2);$i++) {
        $temp=$depart_code2[$i];
	 echo "  <option  value=\"".$temp."\"";
	  // if  ($depart_nom[$temp]== 'NC' ){
       //echo " SELECTED "; }
        echo ">";
    // echo "  <option value=\"$temp\">";
     echo $depart_nom_etud[$temp]."-".$depart_universite[$temp];


      echo"</option> " ;
    }
   echo"</select> " ;
   }
          echo "</tr><tr>";   

   echo affichechamp('Code du cours','code_cours_long',$code_cours_long,'10');
           echo "</tr><tr>"; 
    echo affichechamp('Intitulé du cours','intitule_cours',$intitule_cours,'50');
        echo "</tr><tr>"; 
	echo affichemenunc('Niveau','niveau',$ListeNiveauCoursDepart,'');
		echo "</tr><tr>"; 
		echo "<td colspan=2> Descriptif du cours <br>";
 echo "<textarea cols=47 rows=5  name='descriptif'>$descriptif </textarea>";			
     //echo affichechamp('Descriptif du cours','descriptif',$descriptif);
	         echo "</tr><tr>";   
	 echo affichechamp('Lien Web','url',$url,'50');        
	 echo "</tr><tr>";   
	// echo affichechamp('Crédits ECTS','ects',$ects,'5','','','','',''," type='number' step='0.01'");
	 echo "<td  >Crédits ECTS<input type='number' step='0.1' size='5' name='ects'  value=\"".$ects."\"></td>";
	 echo affichechamp('Note','note',$note,'5');
		echo "</tr><tr>";
				 	if(in_array($login,$ri_user_liste)){	 
	 echo affichemenu('verrouillé','verrouille',$listeouinon,'non');
			}
			echo "</tr><tr>";		
   echo"          </td> </tr><tr><th colspan=4>
               <input type='Submit' name='ajout' value='Ajouter'><input type='Submit' name='bouton_annul' value='Annuler'>
            </th>
         </tr></table> ";
      echo"   </form> "  ;

         }
   else{
   echo "<center><b>seul le service relations internationales peut effectuer cette operation</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $login ==

      }//fin du ajouter

	   
	  
	  
 //___________________________________AFFICHAGE TABLEAU_______________________________	
if  ($_GET['st_bouton_ok']=="OK" or ($_GET['st_recherche_avance']!="oui"  and  $_GET['add']!='1' ) ){	
	  	     if ($afficheliste){
     $query = "SELECT $table.* FROM $table where '1'='1' 
	 ";
	 	if(in_array($login,$ri_user_liste)){
				 $query.=$where.$orderby;
		}
		else // c'est un prof 
	{
	 $query.=$where."and verrouille!='oui'".$orderby;
		}	
	//echo $query;
  $result=mysql_query($query,$connexion );
  $i=1;
        $nombre=  mysql_num_rows($result);
         echo" <h2>Liste des  cours ".$message_entete." </h2>";
        echo "<BR><BR><table border=1><tr bgcolor=\"#98B5FF\" > ";

         echo" <tr>";
		 if   ($_GET['st_orderby']=='code_cours_long' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=code_cours_long&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Code</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=code_cours_long&st_bouton_ok=OK".$filtre.">Code</a></th> ";}

		 if   ($_GET['st_orderby']=='intitule_cours' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=intitule_cours&st_inverse=1"."&st_bouton_ok=OK". $filtre.">intitulé</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=intitule_cours&st_bouton_ok=OK".$filtre.">Intitulé</a></th> ";}
		 if   ($_GET['st_orderby']=='niveau' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=niveau&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Niveau</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=niveau&st_bouton_ok=OK".$filtre.">Niveau</a></th> ";}

 if   ($_GET['st_orderby']=='ects' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=ects&st_inverse=1"."&st_bouton_ok=OK". $filtre.">Nbre de crédits (ECTS ou autre)</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=ects&st_bouton_ok=OK".$filtre.">Nbre de crédits (ECTS ou autre)</a></th> ";}


		
 if   ($_GET['st_orderby']=='note' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=note&st_inverse=1"."&st_bouton_ok=OK". $filtre.">note</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=note&st_bouton_ok=OK".$filtre.">note</a></th> ";}
	 	if(in_array($login,$ri_user_liste)){
 if   ($_GET['st_orderby']=='verrouille' && $_GET['st_inverse']<> 1)
{echo"<th><a href=".$self."?st_orderby=verrouille&st_inverse=1"."&st_bouton_ok=OK". $filtre.">verrouille</a></th> ";}
else
{echo "<th><a href=".$self."?st_orderby=verrouille&st_bouton_ok=OK".$filtre.">verrouille</a></th> ";}
		}


		echo"</th><th>action</th></tr>";
		


		
		$totects=0;
      while($e=mysql_fetch_object($result)) {
	        $code_cours=$e->code_cours;
      $code_cours_long=$e->code_cours_long;
        $intitule_cours=$e->intitule_cours;
		$ects=$e->ects;
        $url= $e->url;
        $note= $e->note;
        $code_depart= $e->code_depart;
		$niveau= $e->niveau;
        if($url!='' ){
			$link="<a href=$url>$intitule_cours</a>";
			}else{
			$link=$intitule_cours;}
       
		 
              echo"<tr><td>". $code_cours_long." </td><td> ".$link." </td><td> ".$niveau." </td><td> ".$ects." </td><td> ".$note;
        echo "   </td><td>";
	if(in_array($login,$ri_user_liste)){
		echo $e->verrouille." </td><td> ";
         echo "<A href=".$URL."?del=".$code_cours."&code_depart=".$code_depart;		 
         echo" onclick=\"return confirm('Etes vous sûr de vouloir supprimer ce cours ?')\">sup</A> - ";
	}
         echo "<A href=".$URL."?mod=".$code_cours."&code_depart=".$code_depart;
          echo ">détails</A> </td></tr> ";
       $i++; 
	   // pour que le total soit juste on corrige $ects
	   // on remplace la virgule par le point 
	   $ectstot=nettoiefloat($ects);
	   $totects=$totects+$ectstot;
	   }
	echo "<tr><td></td><td></td><td></td><td><b> total ECTS ".$totects."</b></td></tr>";
       echo "</table> ";
      }
	  } //fin du affiche liste

 
 echo "</td></tr></table>";
 mysql_close($connexion);
 ?>
</body>
</html>