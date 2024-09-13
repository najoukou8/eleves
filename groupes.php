<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
<script LANGUAGE="JavaScript">
<!--
function tout() {
	   limit = document.forms['ajoutenleve'].elements['code_etudiant[]'].options.length;
	   for ( i=0; i<limit ; i++ )
	   document.forms['ajoutenleve'].elements['code_etudiant[]'].options[i].selected = true;
	   }
// -->
</script>
<title>gestion des groupes</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<SCRIPT TYPE="text/javascript" SRC="filterlist.js"></SCRIPT>

<style>
body{
	background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='1800' height='500' preserveAspectRatio='none' viewBox='0 0 1800 500'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1022%26quot%3b)' fill='none'%3e%3crect width='1800' height='500' x='0' y='0' fill='rgba(39%2c 135%2c 195%2c 0.28)'%3e%3c/rect%3e%3cpath d='M 0%2c263 C 90%2c259.6 270%2c230.4 450%2c246 C 630%2c261.6 720%2c354.4 900%2c341 C 1080%2c327.6 1170%2c190 1350%2c179 C 1530%2c168 1710%2c264.6 1800%2c286L1800 500L0 500z' fill='rgba(255%2c 255%2c 255%2c 1)'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1022'%3e%3crect width='1800' height='500' fill='white'%3e%3c/rect%3e%3c/mask%3e%3c/defs%3e%3c/svg%3e");
	background-repeat: repeat-x;
}
</style>


<?

require ("style.php");
require ("param.php");
require ("function.php");
echo "</HEAD><BODY>" ;
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
require('header.php');
// pour les urls Ksup
$sqlquery2="SELECT META_CODE, META_LIBELLE_FICHE,ID_METATAG FROM METATAG WHERE META_CODE_RUBRIQUE LIKE 'GENIE_FOR%' AND META_LIBELLE_OBJET LIKE 'cours'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$fiche_code_ksup[$v["META_CODE"]]=$v["ID_METATAG"];
}
$fiche_code_ksup['']='';

if (!isset($_POST['ajout'])) $_POST['ajout']='';
if (!isset($_POST['bouton_effacer_stage_conf'])) $_POST['bouton_effacer_stage_conf']='';
if (!isset($_POST['bouton_ajout_membre'] )) $_POST['bouton_ajout_membre'] ='';
if (!isset($_POST['bouton_supp_membre'])) $_POST['bouton_supp_membre']='';
if (!isset($_POST['bouton_exempte_membre'])) $_POST['bouton_exempte_membre']='';
if (!isset($_POST['bouton_sup_exempte_membre'])) $_POST['bouton_sup_exempte_membre']='';
if (!isset($_POST['bouton_choix_semestre'])) $_POST['bouton_choix_semestre']='';
if (!isset($_POST['bouton_bloquer_membre'])) $_POST['bouton_bloquer_membre']='';

if (!isset($_POST['bouton_synchro'])) $_POST['bouton_synchro']='';
if (!isset($_POST['bouton_add'])) $_POST['bouton_add']='';
if (!isset($_POST['mod'])) $_POST['mod']='';
if (!isset($_POST['add'])) $_POST['add']='';
if (!isset($_POST['sup'])) $_POST['sup']='';
if (!isset($_GET['synchro'])) $_GET['synchro']='';
if (!isset($_GET['listegpe'])) $_GET['listegpe']='';
if (!isset($_GET['liste1gpe'])) $_GET['liste1gpe']='';
if (!isset($_POST['bouton_sup_stage'])) $_POST['bouton_sup_stage']='';
if (!isset($_POST['code_groupe'])) $_POST['code_groupe']='';
if (!isset($_POST['code_groupe_partie'])) $_POST['code_groupe_partie']='';
if (!isset($libelle)) $libelle='';
if (!isset($_POST['nom'])) $_POST['nom']='';
if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul']='';
if (!isset($_POST['bouton_dupl'])) $_POST['bouton_dupl']='';
if (!isset($_POST['bouton_dupliquer_ok'])) $_POST['bouton_dupliquer_ok']='';
if (!isset($_POST['bouton_edit'])) $_POST['bouton_edit']='';
if (!isset($_POST['bouton_edit_ok'])) $_POST['bouton_edit_ok']='';

//on initialise le tableau $etudiantspartie_code_simple[]
$etudiantspartie_code_simple=array();
//echo date("F j, Y, g:i:s a"); 
$affiche_exempt='';
$affiche_gestgroupe='1';
$visible='';
$sql1='';
$sql2='';
$message='';
$messagem='';
$groupe_code=array();
$URL =$_SERVER['PHP_SELF'];;
$table="groupes";
$tabletemp="groupes";
//on cree un tableau $champs[] avec les noms des colonnes de la table
$champs=champsfromtable($tabletemp);
//$sigimail="marc.patouillard@grenoble-inp.fr";


//on remplit 2 tableaux avec les nom-code  etudiants
//$sqlquery2="SELECT * ,etudiants_scol.* FROM etudiants  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code order by nom";
// a verifier avant de valider modif a cause de la lenteur : on ne prends que les champs nécessaires
$sqlquery2="SELECT etudiants.Nom,etudiants.`Prénom 1`,etudiants.`Code etu`,etudiants_scol.annee FROM etudiants  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code order by nom";
//echo $sqlquery2;
 $resultat2=mysql_query($sqlquery2,$connexion );
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
$etudiants_nom[$ind2]=$v["Nom"];
$etudiants_prenom[$ind2]=$v["Prénom 1"];
$etudiants_annee[$ind2]=$v["annee"];
//$etudiants_code[$ind]=$v["Code etu"];
$etudiants_code_simple[]=$v["Code etu"];
}

$groupe_libelle=array();
//$groupe_code=array();
//on cree un tableau $champs2[] avec les noms des colonnes de la table ligne_groupe
$table2="ligne_groupe";
$tabletemp="ligne_groupe";
$champs2=champsfromtable($tabletemp);
// pour la scol

if (in_array ($login ,$scol_user_liste ) or in_array ($login ,$nomail_user_liste ))
{
		if (in_array($login, $scol_plus_user_liste))
		// on prend tout
		{
		$where="   order by groupe_officiel desc  ,type_gpe_auto,visible desc,archive,upper(concat(arbre_gpe,libelle)),proprietaire";
		}
		else
		{
		//  la scol  voit les gpes constitutifs , les leurs (login) et les officiels et les archives et les partages
		$where=" where   (  login_proprietaire= '".$login."' or groupe_officiel = 'oui' or visible = 'oui' or code='".$code_gpe_tous."')  order by visible desc, groupe_officiel desc,archive,type_gpe_auto, upper(concat(arbre_gpe,libelle)),proprietaire";
		}
}
elseif ( in_array ($login ,$ri_modif_groupe ))
{

		//  les ri_modif_groupe ne voient que les leurs et les groupes edt qui n'ont pas de gpe constitutif
	//	$where=" where   (  login_proprietaire= '".$login."'  or (type_gpe_auto = 'edt' and( gpe_etud_constitutif is null or gpe_etud_constitutif ='' or gpe_etud_constitutif ='VIDE' ) or type_gpe_auto = 'scol' ) or code='".$code_gpe_tous."')  and archive !='oui'  order by visible desc, groupe_officiel desc,archive,type_gpe_auto, upper(concat(arbre_gpe,libelle)),proprietaire";
		$where=" where   (  login_proprietaire= '".$login."' or groupe_officiel = 'oui'  or code='".$code_gpe_tous."') and archive !='oui'  order by visible desc, groupe_officiel desc,archive,type_gpe_auto, upper(concat(arbre_gpe,libelle)),proprietaire";
		
}
else
{
	// pour les autres ils ne voient que leurs gpes les gpes offi mais pas les gpes edt ni les gpes scol
	$where=" where  (  login_proprietaire= '".$login."'  or groupe_officiel = 'oui' or code='".$code_gpe_tous."') and archive !='oui' and type_gpe_auto != 'scol' and type_gpe_auto != 'edt'  order by groupe_officiel desc,visible desc, type_gpe_auto, upper(concat(arbre_gpe,libelle)),proprietaire";
}
//on remplit 2 tableaux avec les nom-code  groupes
$sqlquery2="SELECT groupes.* FROM groupes ".$where;
//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2))
	{
	$ind=$v["libelle"] ;
	$ind2=$v["code"];
	//$groupe_code[$ind]=$v["code"];
	//attention en cas de doublon dans les libelles ya probleme :decallage dans les select
	//je remplace le tableau associatif par le tableau simple liste des code non indicés
	$groupe_code_simple[]=$v["code"];
	$groupe_visible[$ind2]=$v["visible"];
	$groupe_libelle[$ind2]=$v["libelle"];
	$groupe_proprio[$ind2]=$v["login_proprietaire"];
	$groupe_offi[$ind2]=$v["groupe_officiel"];
	$groupe_liste[$ind2]=$v["liste_offi"];
	$groupe_nomliste[$ind2]=$v["nom_liste"];
	$groupe_titre_affiche[$ind2]=  $v["titre_affiche"] ;
	$groupe_titre_special[$ind2]=$v["titre_special"];
	$groupe_code_ade[$ind2]=$v["code_ade"];
	$groupe_code_ade6[$ind2]=$v["code_ade6"];	
	//$groupe_gpe_evenement[$ind2]=$v["gpe_evenement"];
	$groupe_cours_complet[$ind2]=$v["groupe_cours_complet"];
	$groupe_type_auto[$ind2]=$v["type_gpe_auto"];
	$groupe_const[$ind2]=$v["libelle_gpe_constitutif"];
	$groupe_clone[$ind2]=$v["recopie_gpe_officiel"];	
	$groupe_etudconst[$ind2]=$v["gpe_etud_constitutif"];
	$groupe_arbre[$ind2]=$v["arbre_gpe"];
	$groupe_code[$ind]=$v["code"];
	$groupe_principal[$ind2]=$v["groupe_principal"];
	$groupe_archive[$ind2]=$v["archive"];
	$groupe_nomail[$ind2]=$v["nomail"];	
	$groupe_pere[$ind2]=$v["code_pere"];	
	// on calcule le nombre d'inscrits dans chaque groupe 
	$sqlquery3="SELECT* FROM ligne_groupe where code_groupe= '".$v["code"]."'";
	$resultat3=mysql_query($sqlquery3,$connexion ); 
	$groupe_inscrits[$ind2]=mysql_num_rows ( $resultat3 );
	}

    //sort($groupe_titre_affiche) ;
// ----------------------------------Ajout de la fiche groupe
if($_POST['bouton_add']=='ajouter' ) {

 if($_POST['libelle']!='' ) {
 $temp= str_replace("'","''",stripslashes($_POST['libelle']));
 //ici il faut verifier si  le libelle du gpe n'existe pas deja ds un autre gpe public ou du meme user
 $query="SELECT * from $table where libelle='".$temp."' and  ( visible='oui' or login_proprietaire='".$login."')  ";
   //echo $query;
	$result =mysql_query($query,$connexion ); 
	if (mysql_num_rows($result)==0){

	//si on trouve rien  on continue
 //à cause de mysql il faut doubler les \ dans proprio avant l'insert
 #$_POST['proprietaire']=$domaine."\\\\".$login;
  $_POST['proprietaire']=$login;
 // on initialise feuille_ade à vrai
 //inutile 23010-2011
 //$_POST['feuille_ade']='oui';
         foreach($champs as $ci2){
          if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
		 //a cause du ble antislash ds proprietaire on ne le traite pas sinon ça le vire
	 if ($ci2!="proprietaire"){	 
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
 }
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2=="code"){
 }
 elseif($ci2=="date_modif"){
 $sql1.= $ci2.",";
 $sql2.= " now() ,"; 
 }
 else
 {
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";  }
 }
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  // $query = "INSERT INTO $table(nom,email)";
    $query = "INSERT INTO $table($sql1)";
   $query .= " VALUES($sql2)";
  //echo $query;
	$result =mysql_query($query,$connexion ); 
	 echo afficheresultatsql($result,$connexion);

   $affiche_gestgroupe='0';
     
    }
	//si on a trouve un doublon ds les libelles
	else{ $message = "<font color='red'>Le nom que vous avez donné à votre groupe existe déjà! : Recommencez !</font>";}
	}
    else{
    $message = "<font color='red'>Vous devez donner un nom à votre groupe ! : Recommencez !</font>";}
}

//inutile maintenant 09-2010
if(0)
{
// ----------------------------------dupliquer un  groupe et ses membres
if($_POST['bouton_dupliquer_ok']!='' ) {


//on cree d'abord la fiche du groupe
 if($_POST['libelle']!='' ) {
 //ici il faut verifier si  le libelle du gpe n'existe pas deja ds un autre gpe public ou du meme user
 $query="SELECT * from $table where libelle='".$_POST['libelle']."' and  ( visible='oui' or login_proprietaire='".$login."')  ";
   // echo $query;
	$result =mysql_query($query,$connexion ); 
 //si on trouve rien  on continue
	if (mysql_num_rows($result)==0){
 //à cause de mysql il faut doubler les \ dans proprio avant l'insert
 $_POST['proprietaire']=$login;
         foreach($champs as $ci2){ 
          if (!isset($_POST[$ci2])) $_POST[$ci2]='';
				 		 //a cause du dble antislash ds proprietaire on ne le traite pas sinon ça le vire
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
		 	 if ($ci2!="proprietaire"){	
 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
   }
   //il ne faut pas remettre ces infos dans la  fiche dupliquée
   if ($ci2=="gpe_total" or $ci2=="membre_gpe_total" or $ci2=="titre_special" or $ci2=="titre_affiche" or $ci2=="groupe_officiel" or $ci2=="nom_liste" or $ci2=="liste_offi" or $ci2=="groupe_principal" or $ci2=="archive" or $ci2=="type_gpe_auto"){
$_POST[$ci2]='';   
   }
   
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
 if ($ci2!="code"){
 $sql1.= $ci2.",";
 $sql2.= "'".$_POST[$ci2]."',";  }
 }
 //il faut enlever la virgule de la fin
 $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $sql2=substr($sql2,0,strlen($sql2)-1) ;
  // $query = "INSERT INTO $table(nom,email)";
    $query = "INSERT INTO $table($sql1)";
   $query .= " VALUES($sql2)";
 // echo $query;
   	$result =mysql_query($query,$connexion ); 
	 echo afficheresultatsql($result,$connexion);
   $affiche_gestgroupe='0';
    
    //il faut recuperer le code qui vient d'etre genere
        $sqlquery3="SELECT     MAX(code) AS Expr1
FROM         groupes ";
    $resulmax=mysql_query($sqlquery3,$connexion );
	$e=mysql_fetch_object($resulmax);    
	$max = $e->Expr1;
    //on cree ensuite les lignes_groupe
$sqlquery=" INSERT INTO ligne_groupe
                      (code_groupe, code_etudiant)
SELECT     ".$max." AS Expr1, code_etudiant
FROM         ligne_groupe
WHERE     (code_groupe = ".$_POST['code'].")";
    //echo "<br>".$sqlquery;
        $result =mysql_query($sqlquery,$connexion ); 
			 echo afficheresultatsql($result,$connexion);
    }
		//si on a trouve un doublon ds les libelles
	else{ $message = "<font color='red'>Le nom que vous avez donné à votre groupe existe déjà! : Recommencez !</font>";}
	}
    else{
    $message = "<font color='red'>Vous devez donner un nom à votre groupe ! : Recommencez !</font>";}
}
}

// ----------------------------------modif d'un  groupe 

if($_POST['bouton_edit_ok']!='' ) {


 if($_POST['libelle']!='' ) {
 // si on coche liste offi sans nom de liste offi
 if ($_POST['liste_offi']!='oui' or $_POST['nom_liste']!='') {
	// on sauvegarde le libelle avant les transformations de doublage des quotes pour pouvoir  comparer avec la valeur avant modif et envoyez le mail au sigi le cas échéant
	$libellesimplequote=$_POST['libelle'];
	// on double les quotes du libelle pour
	$libelledoublecote= str_replace("'","''",stripslashes($_POST['libelle']));
 //ici il faut verifier si  le libelle du gpe n'existe pas deja ds un autre gpe public ou du meme user
 $query="SELECT * from $table where libelle='".$libelledoublecote."' and  ( visible='oui' or login_proprietaire='".$login."')  ";
   // echo $query;
   	$result =mysql_query($query,$connexion ); 
 //si on trouve rien ou si on a pas changé le libelle on continue
 //print_r($_POST);

 	if (	mysql_num_rows($result)==0 or strtoupper($_POST['libelle_sauv'])==strtoupper($_POST['libelle'])){

	 //à cause de mysql il faut doubler les \ dans proprio avant l'insert
 // 2020 on n'écrase plus le propriétaire 
 //$_POST['proprietaire']=$login;
 //2020 par sécurité mais proprietaire ne doit plus être utilisé
  $_POST['proprietaire']=$_POST['login_proprietaire'];
 foreach($champs as $ci2){
          if (!isset($_POST[$ci2])) $_POST[$ci2]='';
         //tout ce cirque à cause des apostrophes des magics quotes et de sqlserver
		 		 		 //a cause du ble antislash ds proprietaire on ne le traite pas sinon ça le vire
		if ($ci2!="proprietaire"){	
		 $_POST[$ci2]= str_replace("'","''",stripslashes($_POST[$ci2]));
		   }
 //pour fabriquer la chaine sql  attention il ne faut pas inclure la cle genere automatiquement par sqlserver
			if ($ci2=="code" or $ci2=="propriétaire"){
			 //on ne fait rien
			 }
			 elseif ($ci2=="date_modif"){
			$sql1.= $ci2."=now() ,";
			 $sql2.= "'".$_POST[$ci2]."',"; 			
			 }
			 else{
			$sql1.= $ci2."='".$_POST[$ci2]."',";
			 $sql2.= "'".$_POST[$ci2]."',";  }
 }
 //il faut enlever la virgule de la fin
  $sql1=substr($sql1,0,strlen($sql1)-1) ;
  $query = "UPDATE $table SET $sql1";
   $query .= " WHERE code='".$_POST['code']."' ";
 //echo $query;
        $result =mysql_query($query,$connexion ); 
			 echo afficheresultatsql($result,$connexion);
   
   $affiche_gestgroupe='0';
   // on envoie un mail au sigi si c'est un groupe cours et que le  libelle a été changé
    if ($_POST['type_gpe_auto']=='edt' and strtoupper($_POST['libelle_sauv'])!=strtoupper($libellesimplequote)) 
			{
			   $objet = "modification d'un groupe cours par la scolarité " ;
			$messagem .= "\n"."Le service SCOLARITE (".$login.") vient de modifier le libellé du groupe cours ".$_POST['libelle_sauv']." en  ".$_POST['libelle']." \n" ;
			$messagem .= "\n Attention aux conséquences pour Dokéos \n" ;
			 envoimail($sigimail,$objet,$messagem);  
			}
			   // on envoie un mail au sigi si on vient de mofifier le gpe auto en edt
    if ($_POST['type_gpe_auto_sauv']!='edt' and $_POST['type_gpe_auto']=='edt' ) 
			{
			   $objet = "ajout d'un groupe cours par la scolarité  " ;
			$messagem .= "\n"."Le service SCOLARITE (".$login.") vient d'ajouter un  groupe cours : ".$_POST['libelle']." \n" ;
			$messagem .= "\n Attention aux conséquences pour Dokéos \n" ;
			$messagem .= " \n";
			 envoimail($sigimail,$objet,$messagem);  
			}
    }
	//si on a trouve un doublon ds les libelles
	else{ $message = "<font color='red'>Le nom que vous avez donné à votre groupe existe déjà! : Recommencez !</font> ";
	}
	
	}
	else{
    $message = "<font color='red'>Vous ne pouvez pas choisir liste de diffusion officielle et ne pas donner son nom ! : Recommencez !</font>";}
	}
    else{
    $message = "<font color='red'>Vous devez donner un nom à votre groupe ! : Recommencez !</font>";}

}

//suppression d'un groupe

if($_POST['bouton_effacer_stage_conf']!='' ) {
//avant il faut supprimer toutes ses lignes
echo "<center>on efface les lignes des membres du groupe    ".$_POST['libelle_groupe']." </center><br>";
$query2 = "delete  from  $table2 where code_groupe = '".$_POST['code_groupe']."'";
        $result2 =mysql_query($query2,$connexion ); 
			 echo afficheresultatsql($result2,$connexion);
//$temp= $_POST['code_groupe'] ;
//avant il faut supprimer toutes les lignes de pré inscription eleves etrangers
echo "<center>on efface les lignes des pré-inscriptions élèves étrangers à ce groupe :    ".$_POST['libelle_groupe']." </center><br>";
//on récupère la liste des étudiants concernés pour l'envoyer ds le mail aux RI
		$query2 = "select * from    ligne_insc_acc  where liginsc_code_groupe = '".$_POST['code_groupe']."'";
        $result2 =mysql_query($query2,$connexion ); 
		$temp='';
		while ($e=mysql_fetch_object($result2))
		{
		$temp .= "\n etudiant : " . $e->liginsc_login ."  \n";
		}
// on efface l'info groupe pour les etudiants concernés
$query2 = "update    ligne_insc_acc set liginsc_code_groupe='' where liginsc_code_groupe = '".$_POST['code_groupe']."'";
        $result2 =mysql_query($query2,$connexion ); 
			 echo afficheresultatsql($result2,$connexion);
			if (mysql_affected_rows()>0)
			{
			// si il y en avait on envoi un mail au ri 
						$objet = "suppression  d'un groupe cours par la scolarité " ;
						$messagem .= "\n"."Le service SCOLARITE (".$login.") vient de supprimer le  groupe cours ".$_POST['libelle_groupe']." \n" ;
						$messagem .= "\n Attention il y avait ". mysql_affected_rows() ." pré inscriptions élèves étrangers pour ce groupe\n" ;
						$messagem .= "\n en voici la liste : ". $temp ;						
						 envoimail($rimail,$objet,$messagem);  
						 envoimail($sigiadminmail,$objet,$messagem);  
			}

//ensuite on efface le groupe
$query2 = "delete  from  $table where code = '".$_POST['code_groupe']."'";
echo "<center>on efface le groupe    ".$_POST['libelle_groupe']." </center><br>";
        $result2 =mysql_query($query2,$connexion ); 
			 echo afficheresultatsql($result2,$connexion);

   $affiche_gestgroupe='0';
         // on envoie un mail au sigi si c'est un groupe cours 
    if ($_POST['groupe_type_auto']=='edt' ) 
			{
			$objet = "suppression  d'un groupe cours par la scolarité " ;
			$messagem .= "\n"."Le service SCOLARITE (".$login.") vient de supprimer le  groupe cours ".$_POST['libelle_groupe']." \n" ;
			$messagem .= "\n Attention aux conséquences pour Dokéos \n" ;
			 envoimail($sigimail,$objet,$messagem);  
			}
 }



// ----------------------------------Ajout multiple  de  membres
if($_POST['bouton_ajout_membre']!='' ) {
if (isset($_POST['code_etudiant'])) {
 $var=$_POST['code_etudiant'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-etudiant
	{
    $query = "INSERT INTO $table2(code_groupe,code_etudiant,modifpar,date_modif)";
   $query .= " VALUES('".$_POST['code_groupe']."','".$var[$i]."','".$login."',now())";
   //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
  if ($result){
   $message .= $etudiants_nom[$var[$i]];
   $message .= "</b> ajouté au groupe <br>";
      //si c'est un gpe principal on met à jour gpe principal ds sa fiche scolarite si il n'est pas ds le gp principal internatioanux
	  // on est obligé de hard coder le nom approximatif du gpe principal  (= annee ) 
	  //c pas très joli mais ...
	  // il est inutile maintenant : 2010-2011  de vérifier lesinternationaux
	  
   if ($_POST['groupe_principal']=='oui'){
					//$query2 = "UPDATE etudiants_scol set  annee='".$groupe_libelle[$_POST['code_groupe']]."'  where etudiants_scol.code = '".$var[$i]. "' and annee not like '%etudiants internationaux%';";
					$query2 = "UPDATE etudiants_scol set  annee='".$groupe_libelle[$_POST['code_groupe']]."'  where etudiants_scol.code = '".$var[$i]. "' ";
				//echo $query2."<BR>";
					        $result2 =mysql_query($query2,$connexion ); 
   $message .="<br>et groupe principal dans fiche scolarité modifié  <br>";
   }
   // si c'est la scolarité et si c'est un groupe a liste sigi: on prepare l'email
    if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
    // On prepare l'email : on initialise les variables
$objet = "ajout d'un membre de liste " ;
$messagem .= "\n"."Le service SCOLARITE vient d'ajouter l'etudiant  ".$etudiants_nom[$var[$i]]." ".$etudiants_prenom[$var[$i]]." dans le  groupe ".$groupe_libelle[$_POST['code_groupe']]." \n" ;
$messagem .= " \n";
   }
   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>L ajout de ".$etudiants_nom[$var[$i]]." n'est pas enregistrée</b> </center>";
    }
}//fin du for
	//si c'est la scolarité et si c'est un groupe a liste sigi: On envoie l’email au SIGI
	 if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
	 # on envoie plus  le mail 
#envoimail($sigimail,$objet,$messagem);
}
//echo $messagem;
}

				else{ echo"<center><b>vous n'avez pas sélectionné d'étudiant non membres</b>, Recommencez !<br>";}
}

// ---------------------------------exemption multiple
if($_POST['bouton_exempte_membre']!='') {


if (isset($_POST['membres'])) {
 $var=$_POST['membres'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-etudiant
	{
 $query = "UPDATE  $table2 set ligne_groupe.exempte ='oui'"
      ." WHERE code_groupe='".$_POST['code_groupe']."' and code_etudiant='".$var[$i]."'";
      //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
   if ($result){
   $message .= $etudiants_nom[$var[$i]];
   $message .= "</b> exempté du groupe <br>";
      //si c'est un gpe principal on met à jour gpe principal ds sa fiche scolarite
  /*  if ($_POST['groupe_principal']=='oui'){
					$query2 = "UPDATE etudiants_scol set  annee='non affecté' where etudiants_scol.code = '".$var[$i]. "';";
					//echo $query2."<BR>";
					 $result2 =mysql_query($query2,$connexion ); 
   $message .="<br>et groupe principal ".$groupe_libelle[$_POST['code_groupe']]." effacé dans fiche scolarité : non affecté <br>";
   } */
   // si c'est la scolarité et si c'est un groupe a liste sigi: on prepare l'email
    if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
    // On prepare l'email : on initialise les variables
$objet = "exemption d'un membre de liste " ;
$messagem .= "\n"."Le service SCOLARITE vient d'exempter l'etudiant  ".$etudiants_nom[$var[$i]]." ".$etudiants_prenom[$var[$i]]." du groupe ".$groupe_libelle[$_POST['code_groupe']]." \n" ;
$messagem .= " \n";
   }
   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>L'exemption de ".$etudiants_nom[$var[$i]]." n'est pas enregistrée</b> </center>";
    }
	}//fin du for
	// si c'est la scolarité et si c'est un groupe a liste sigi: On envoie l’email au SIGI
	 if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
#envoimail($sigimail,$objet,$messagem);
}
   echo $messagem;
   }

else{ echo"<center><b>vous n'avez pas sélectionné d'étudiants  membres</b>, Recommencez !<br>";}
}
// ---------------------------------blocage multiple
if($_POST['bouton_bloquer_membre']!='') {


if (isset($_POST['membres'])) {
 $var=$_POST['membres'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-etudiant
	{
 $query = "UPDATE  $table2 set ligne_groupe.type_inscription ='fix'"
      ." WHERE code_groupe='".$_POST['code_groupe']."' and code_etudiant='".$var[$i]."'";
      //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
   if ($result){
   $message .= "inscription de ". $etudiants_nom[$var[$i]];
   $message .= "</b> bloquée dans ce groupe <br>";
    $message .= "</b> elle ne sera ni héritée , ni modifiée par un héritage <br>";
    if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
    // On prepare l'email : on initialise les variables
$objet = "exemption d'un membre de liste " ;
$messagem .= "\n"."Le service SCOLARITE vient de bloquer l'inscription de l'etudiant  ".$etudiants_nom[$var[$i]]." ".$etudiants_prenom[$var[$i]]." dans le  groupe ".$groupe_libelle[$_POST['code_groupe']]." \n" ;
$messagem .= " \n";
   }
   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>Le blocage de ".$etudiants_nom[$var[$i]]." n'est pas enregistrée</b> </center>";
    }
	}//fin du for
	// si c'est la scolarité et si c'est un groupe a liste sigi: On envoie l’email au SIGI
	 if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
#envoimail($sigimail,$objet,$messagem);
}
   echo $messagem;
   }

else{ echo"<center><b>vous n'avez pas sélectionné d'étudiants  membres</b>, Recommencez !<br>";}
}
// ---------------------------------suppression exemption  multiple
if($_POST['bouton_sup_exempte_membre']!='') {


if (isset($_POST['membres'])) {
 $var=$_POST['membres'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-etudiant
	{
 $query = "UPDATE  $table2 set ligne_groupe.exempte =''"
      ." WHERE code_groupe='".$_POST['code_groupe']."' and code_etudiant='".$var[$i]."'";
      //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
   if ($result){
   $message .= $etudiants_nom[$var[$i]];
   $message .= "</b> rétabli dans  groupe <br>";
      //si c'est un gpe principal on met à jour gpe principal ds sa fiche scolarite
  /*  if ($_POST['groupe_principal']=='oui'){
					$query2 = "UPDATE etudiants_scol set  annee='non affecté' where etudiants_scol.code = '".$var[$i]. "';";
					//echo $query2."<BR>";
					 $result2 =mysql_query($query2,$connexion ); 
   $message .="<br>et groupe principal ".$groupe_libelle[$_POST['code_groupe']]." effacé dans fiche scolarité : non affecté <br>";
   } */
   // si c'est la scolarité et si c'est un groupe a liste sigi: on prepare l'email
    if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
    // On prepare l'email : on initialise les variables
$objet = "exemption d'un membre de liste " ;
$messagem .= "\n"."Le service SCOLARITE vient de rétablir l'etudiant  ".$etudiants_nom[$var[$i]]." ".$etudiants_prenom[$var[$i]]." dans le groupe ".$groupe_libelle[$_POST['code_groupe']]." \n" ;
$messagem .= " \n";
   }
   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>L'annulation de l 'exemption de ".$etudiants_nom[$var[$i]]." n'est pas enregistrée</b> </center>";
    }
	}//fin du for
	// si c'est la scolarité et si c'est un groupe a liste sigi: On envoie l’email au SIGI
	 if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
#envoimail($sigimail,$objet,$messagem);
}
   echo $messagem;
   }

else{ echo"<center><b>vous n'avez pas sélectionné d'étudiants  membres</b>, Recommencez !<br>";}
}
// ---------------------------------modif semestre multiple
if($_POST['bouton_choix_semestre']!='') {
if($_POST['bouton_choix_semestre']=='RAZ') 
{$_POST['bouton_choix_semestre']='';}

if (isset($_POST['membres'])) {
 $var=$_POST['membres'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-etudiant
	{
 $query = "UPDATE  $table2 set ligne_groupe.semestre ='".$_POST['bouton_choix_semestre']."'"
      ." WHERE code_groupe='".$_POST['code_groupe']."' and code_etudiant='".$var[$i]."'";
      //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
   if ($result){
   $message .= $etudiants_nom[$var[$i]];
   $message .= "</b> semestre modifié dans groupe <br>";
      //si c'est un gpe principal on met à jour gpe principal ds sa fiche scolarite
  /*  if ($_POST['groupe_principal']=='oui'){
					$query2 = "UPDATE etudiants_scol set  annee='non affecté' where etudiants_scol.code = '".$var[$i]. "';";
					//echo $query2."<BR>";
					 $result2 =mysql_query($query2,$connexion ); 
   $message .="<br>et groupe principal ".$groupe_libelle[$_POST['code_groupe']]." effacé dans fiche scolarité : non affecté <br>";
   } */

   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>La modification de semestre de ".$etudiants_nom[$var[$i]]." n'est pas enregistrée</b> </center>";
    }
	}//fin du for

   echo $messagem;
   }

else{ echo"<center><b>vous n'avez pas sélectionné d'étudiants  membres</b>, Recommencez !<br>";}
}
// ---------------------------------Suppression multiple
if($_POST['bouton_supp_membre']!='') {


if (isset($_POST['membres'])) {
 $var=$_POST['membres'];
 //on recupere les lignes  rentrés ds le tableau
	for ($i=0;$i<count($var);$i++)
	//pour chaque ligne-etudiant
	{
 $query = "DELETE FROM $table2"
      ." WHERE code_groupe='".$_POST['code_groupe']."' and code_etudiant='".$var[$i]."'";
      //echo $query."<br>";
        $result =mysql_query($query,$connexion ); 
   if ($result){
   $message .= $etudiants_nom[$var[$i]];
   $message .= "</b> supprimé du groupe <br>";
      //si c'est un gpe principal on met à jour gpe principal ds sa fiche scolarite
   if ($_POST['groupe_principal']=='oui'){
					$query2 = "UPDATE etudiants_scol set  annee='non affecté' where etudiants_scol.code = '".$var[$i]. "';";
					//echo $query2."<BR>";
					 $result2 =mysql_query($query2,$connexion ); 
   $message .="<br>et groupe principal ".$groupe_libelle[$_POST['code_groupe']]." effacé dans fiche scolarité : non affecté <br>";
   }
   // si c'est la scolarité et si c'est un groupe a liste sigi: on prepare l'email
    if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
    // On prepare l'email : on initialise les variables
$objet = "suppression d'un membre de liste " ;
$messagem .= "\n"."Le service SCOLARITE vient de supprimer l'etudiant  ".$etudiants_nom[$var[$i]]." ".$etudiants_prenom[$var[$i]]." du groupe ".$groupe_libelle[$_POST['code_groupe']]." \n" ;
$messagem .= " \n";
   }
   }
   else {
    echo affichealerte("erreur de saisie ");
  echo "<center>La suppression de ".$etudiants_nom[$var[$i]]." n'est pas enregistrée</b> </center>";
    }
	}//fin du for
	// si c'est la scolarité et si c'est un groupe a liste sigi: On envoie l’email au SIGI
	 if ((in_array ($login ,$scol_user_liste ))and($groupe_liste[$_POST['code_groupe']]=='oui')){
	 # on envoie pas le mail en debut d'annee
	 #envoimail($sigimail,$objet,$messagem);
}
   echo $messagem;
   }

else{ echo"<center><b>vous n'avez pas sélectionné d'étudiants  membres</b>, Recommencez !<br>";}
}
   //--------------------------------- init des groupes par defaut gpe principal et gpe tous les inscrits
if($_POST['bouton_synchro']=='OK' ){
echo "init en cours ...";
$creetotal=0;
$efface_de_import_apo=0;
/* // on retrouve le code  du groupe TOUS GI
$query5="SELECT  code FROM groupes   where gpe_total='oui'";
$resultat5=mysql_query($query5,$connexion );
// il faut qu'il n y en ait qu'un
if (mysql_num_rows ($resultat5) == 1)
{
 while($f=mysql_fetch_array($resultat5)){
 $codeTOUS=$f['code'];
 } */
 
 // on vide les lignes de TOUSGI
 echo "<br>on efface les anciens membres du groupe total <br>";
 
 $query6="DELETE FROM ligne_groupe   where code_groupe='".$code_gpe_tous_inscrits."'";
$resultat6=mysql_query($query6,$connexion );
echo mysql_affected_rows($connexion) ." fiches effacées";
//on recupere les  membres de groupe total en regardant l'annee d'inscription dans la fiche etudiant
 // $sqlquery2="SELECT  * FROM groupes   where membre_gpe_total ='oui' and archive !='oui' order by  libelle";
    $sqlquery2="SELECT  * FROM etudiants   where `Année Univ` = '".($annee_courante-1)."'";
   $resultat2 = mysql_query($sqlquery2,$connexion );


				if ($login=='administrateur')
				echo "on renseigne le gpe TOTAL  <br>";
				$cree=0;
					while ($f=mysql_fetch_array($resultat2)){				
					// on le met dans le groupe TOUS GI si le groupe est membre groupe total et si il n'y est pas déjà
					// on vérifie si l'etudiant n'est pas déjà dans le groupe (cas des etrangers membres de plusieurs gpes principaux )
					$sqlquery5="SELECT  * FROM ligne_groupe    where code_etudiant='".$f['Code etu']."' and code_groupe='".$code_gpe_tous_inscrits."'";
					$resultat5 = mysql_query($sqlquery5,$connexion );
					// si il n'existe pas encore dans le groupe tousGI
						if (mysql_num_rows ($resultat5) == 0)
							{				
						$query4 = "INSERT INTO ligne_groupe (code_groupe,code_etudiant,type_inscription,modifpar,date_modif) VALUES('".$code_gpe_tous_inscrits."','". $f['Code etu'] ."','tous','".$login."',now())";
						//echo $query4."<br>";
						$result4 = mysql_query($query4,$connexion );
						$creetotal++;
						$cree++;
							}
							else
							{
							if ($login=='administrateur')
							echo "etudiant ".$f['code_etudiant'] ." déjà dans le groupe tous les inscrits num ".$code_gpe_tous_inscrits."<br>";
							}
						}

				
echo "<b>résultat ".$creetotal ." étudiants ont été ajouté dans le groupe tous les inscrits</b><br>";

//on recupere les groupes principaux
  $sqlquery5="SELECT  * FROM groupes   where groupe_principal='oui' order by  libelle";
   $resultat5 = mysql_query($sqlquery5,$connexion );

			   while($e=mysql_fetch_array($resultat5))
			   {
					$groupelib= $e['libelle'];
					$groupelib= str_replace("'","''",stripslashes($groupelib));
					$groupecode=$e['code'];


//pour chaque gpe on recupere ses membres
				$query3 = "select * from  ligne_groupe where code_groupe = '".$groupecode."'";
				//echo $query3;
				   $result3 = mysql_query($query3,$connexion );
				if ($login=='administrateur')
				echo "on renseigne le gpe principal pour  les membres du groupe    $groupelib <br>";
				$cree=0;
					while ($f=mysql_fetch_array($result3)){
   //pour chaque code etudiant on met à jour l'info gpe princiapal=annee dans etudiants_scol
					$query2 = "UPDATE etudiants_scol set  annee='".$groupelib."' where etudiants_scol.code = '".$f['code_etudiant']. "';";
					//echo $query2."<BR>";
					$result2 = mysql_query($query2,$connexion );
					if ($login=='administrateur')
					echo afficheresultatsql($result2,$connexion);
					// il faut aussi l'enlever du gpe import apogee si il y était 
										// on vérifie si l'etudiant n'est pas déjà dans le groupe import apogee 
					$sqlquery7="SELECT  * FROM ligne_groupe    where code_etudiant='".$f['code_etudiant']."' and code_groupe='".$code_gpe_imp_apo."'";
					$resultat7 = mysql_query($sqlquery7,$connexion );
					// si il  y etait on l'efface
						if (mysql_num_rows ($resultat7) != 0)
						{
					$query6 = "delete from ligne_groupe where code_groupe='".$code_gpe_imp_apo."' and code_etudiant='".$f['code_etudiant']."'";
					//echo $query6."<br>";
					if ($login=='administrateur')
					echo $f['code_etudiant'] ." était dans import apogee : on devrait l'enlever mais finalement  depuis quelques années on le laisse "."<br>";
					$efface_de_import_apo++;
						}
					
					$cree++;
					}
				if ($login=='administrateur')
				echo "résultat ".$cree ." fiches ont été modifiées pour le groupe principal $groupelib<br>";
				}
				if ($login=='administrateur')
				echo "<b>résultat ".$efface_de_import_apo ." fiches auraient dû être effacées du  du groupe IMPORT APOGEE</b><br>";
				
// pour ceux qui restent sans information de gpe principal ds leur fiche de scol 	 : on indique non affecté
				$sqlquery2="UPDATE etudiants_scol set  annee='non affecté' where annee='' or annee is null ";
				$resultat2 = mysql_query($sqlquery2,$connexion );
		echo "<br>résultat ".mysql_affected_rows() ." fiches de scol on été modifiées : info gpe principal vide remplacée par info -non affecté-<br>";

		// on veut la liste des sans groupe principal
		$query4 = "SELECT distinct code_etudiant FROM `ligne_groupe` left outer join `groupes` on code_groupe=code where groupe_principal= 'oui' and archive !='oui'";
							$result4=mysql_query($query4,$connexion );
							while ($g=mysql_fetch_array($result4)){
								
								$codeEtuAvecGpePrinc[]=$g['code_etudiant'];
							}
							//print_r($codeEtuAvecGpePrinc);
							echo "<h2>ATTENTION  ANOMALIES : éleves sans groupe principal ou avec groupe principal obsolète (en archive) inscrits en $anneeRefens </h2>";
			$query31 = "SELECT `Code etu` as codeetu ,`Année Univ`as anneeuniv, `Nom`, annee  FROM  `etudiants`  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code order by `Année Univ` ";
			$result31=mysql_query($query31,$connexion );
			echo "<table>";
 
							while ($k=mysql_fetch_array($result31)){
																
								if (!(in_array($k['codeetu'],$codeEtuAvecGpePrinc))  )
								{
											// on affiche seulemnt ceux de l'année en cours	
									 if($k['anneeuniv']==$anneeRefens)
									{
										echo "<tr>"."</td><td> ".$k['codeetu'] ."</td><td> ".$k['Nom']."</td><td> ".$k['anneeuniv']."</td><td> ".$k['annee'].'</tr>';
									 }
									
									   //pour chaque code etudiant   sans gpe principal on met l'ancien gpe principal avec des parenthèses (sauf si ça a déjà été fait )
					$query21 = "UPDATE etudiants_scol set  annee='(".$k['annee'].")' where etudiants_scol.code = '".$k['codeetu']. "' and LEFT(annee,1) !='(' and RIGHT(annee,1)!=')' ;";
					//echo $query21."<BR>";
					$result21 = mysql_query($query21,$connexion );
										//echo afficheresultatsql($result21,$connexion);
									
									
								}
							}						
										echo "</table>";
							
		
		 
}				
//fin du if

echo" <table width=100% height=100%><tr><td><center>  ";

 echo $message;
// --------------------------------------sélection de toutes les fiches et affichage
//si on n'a pas appuyé sur le bouton detail ou  kon a appuyé sur le bouton annuler de la fiche on affiche la page d'accueil et si on arrive pas de fiche.php

echo "<h1 class='titrePage2' style='margin-top:-13px'>Gestion des groupes  </h1>" ;


echo "<br><A href=$URL > Gestion des groupes </a>";
echo "<br><A href=listecours.php >Liste des cours importés de refens (avec les effectifs)  </a>";	
if ( (in_array ($login ,$scol_user_liste ))or $login=="administrateur"){

echo "<br><A href=".$URL."?synchro=1 > Synchronisation des  groupes principaux </a>";
echo "<br><A href=peuplement_gpes.php > Forcer le peuplement auto des groupes  </a>";
//echo "<br> inscriptions aux groupes par defaut (réservé à l'administrateur) <br><br><br>";
}
if ( (in_array ($login ,$scol_plus_user_liste ))or $login=="administrateur"){
echo "<br><A href=peuplement_gpes.php?synchro=18 >Simulation et synchro des cours REFENS  $anneeRefens  </a>";
}
echo "<table>";
if ($affiche_gestgroupe)  {	//rajout de ce test car qd on a ajouté ou supprimé un groupe ce n'est pas reflété dans le menu deroulant d: c'est mieux de revenir  alors au début 
	echo    "<form  name='ecranprincipal' method=post action=$URL> ";
   // si il n'existe pas de gpe pour cet utilisateur on affiche que le bouton créer un gpe
if (sizeof($groupe_code)!=0)
	{
	 echo "<tr >";
  echo "<td>";
  echo "</td><td>";
	echo" <br>Sélectionnez un groupe pour le gérer  ";
	echo" <br><i>-- type de Gpe--nom du Gpe---(effectif)---[gpe constitutifs]--*:Gpe principal--0:nomail </i> ";
	 echo "</tr >";
	//echo "   <select name='code_groupe'>  ";
	 //for($i=0;$i<sizeof($groupe_code_simple);$i++) {
	     // echo "  <option  value=\"".current($groupe_code_simple)."\" ";
		  //if (current($groupe_code_simple)==	$_POST['code_groupe']){
		  //echo " SELECTED ";}
		  //if (current($groupe_type_auto)=='edt') { 
	// $prop="- Gpe cours -";
	   // echo  ">".$prop.current($groupe_titre_affiche);
	//}
	//elseif(current($groupe_const)!= '') 
		//{
		// $prop=" - gpe scol -";
	   // echo  ">".$prop.current($groupe_libelle);
	    //}
	//else{
		// $prop=" - gpe public -";
	    ///echo  ">".$prop.current($groupe_libelle)." ( ".current($groupe_login_proprietaire)." ) ";
	    //}
		//echo "</option>";
		//next($groupe_code_simple) ;
	    //next($groupe_libelle);
		//next($groupe_login_proprietaire);
		//next ($groupe_officiel);
		//next ($groupe_type_auto);
		//next ($groupe_const);
		//next ($groupe_arbre);
		//next($groupe_titre_affiche);
	    //}
	   //echo"</select> " ;
	   //echo "<br>";	   
		reset($groupe_code) ;
	    reset($groupe_libelle);
	    reset($groupe_proprio);
		reset($groupe_offi);
		reset ($groupe_type_auto);
		reset ($groupe_const);
		reset ($groupe_arbre);	
		reset ($groupe_titre_affiche);	
		reset ($groupe_visible);
		reset ($groupe_archive);
		reset ($groupe_inscrits);
		reset($groupe_etudconst);
		reset($groupe_clone);		
		reset($groupe_principal);
		reset($groupe_nomail);
		reset($groupe_pere);		
	
 echo "</tr><tr >";
 
  echo "<td>";	
	echo "<INPUT class='selectStyle' NAME=regexp onKeyUp='myfilter.set(this.value)' size=35>";
	    echo "</td><td>";
	echo "   <select name='code_groupe' class='selectStyle'>  ";
	 for($i=0;$i<sizeof($groupe_code);$i++) {
	 //on ne garde que les groupes peda pas ceux du personnel  (proprio != admin)
	// if (current($groupe_proprio)!="admin"){ 
	if(in_array ($login ,$scol_user_liste )or in_array ($login ,$nomail_user_liste ))
	{
			// on n'affiche pas le groupe Tous
				if (current($groupe_libelle)!= 'TOUS') { 

				  echo "  <option  value=\"".current($groupe_code)."\" ";
						if ($_POST['code_groupe']==current($groupe_code)){
					echo " SELECTED";
					}
				}
			//si c'est un groupe officiel
			// ancienne version on regardait aussi le nom du domaine
			//list($domaine_prorio,$login_prorio)=explode("\\",current($groupe_proprio));

			//if (current($groupe_proprio)==$scol_user_complet){ 
		// il faut considérer 2 cas scol et autres
		$affnombre="----(".current($groupe_inscrits).")";
		if (current($groupe_principal)=='oui')
		$affgpeprinc="--*";
			else
		$affgpeprinc="";
		if (current($groupe_nomail)=='oui')
		$affgpenomail="--0";
			else
		$affgpenomail="";
		// pour afficher dans le select les effectifs des groupes constitutifs
$affeffectitfgpeconst='';	
// on explose sur la virgule
$totaleffectifgpeconst=0;
$gpeconstslice=explode(',',current($groupe_etudconst));
foreach($gpeconstslice as $uneslice)
{

//$affeffectitfgpeconst="(".$groupe_inscrits[array_search(current($groupe_etudconst),$groupe_const)].")";
	if(array_search($uneslice,$groupe_const))
	$totaleffectifgpeconst+=$groupe_inscrits[array_search($uneslice,$groupe_const)];
	
}
$affeffectitfgpeconst="(".$totaleffectifgpeconst.")";
		if (current($groupe_pere)!='')
		{
			$temp=current($groupe_pere);
			$affpere="{-->".$groupe_code_ade[$temp].'}';
		}
		else
		{
			$affpere="";	
		}

				if (current($groupe_type_auto)=='edt') { 
				 $prop="-- Gpe COURS --";
				 
				 if (current($groupe_etudconst)=='VIDE' or current($groupe_etudconst)=='' )$affgroupe_etudconst="---[]";
				 else $affgroupe_etudconst="---[<- ".current($groupe_etudconst).$affeffectitfgpeconst.']';
				 if ($login != 'administrateur')
					echo  " style=\"background-color:#F78181;\"> ".$prop.current($groupe_titre_affiche).$affnombre.$affgroupe_etudconst.$affgpeprinc.$affgpenomail;
				else
					echo  " style=\"background-color:#F78181;\"> ".$prop.current($groupe_titre_affiche).$affnombre.$affgroupe_etudconst.$affgpeprinc.$affgpenomail.$affpere;
				}

				elseif(current($groupe_const)!= '') 
					{
					 $prop=" -- Gpe SCOL --";
					echo  " style=\"background-color:#F7FE2E;\"> ".$prop.current($groupe_libelle).$affnombre.$affgpeprinc.$affgpenomail;
					}
				elseif(current($groupe_offi)== 'oui'  ) 
					{
					if (current($groupe_archive)== 'oui' ) 
						{
						 $prop=" -- Gpe OFFICIEL ARCHIVE --";
						echo  " style=\"background-color:#99FFCC;\"> ".$prop.current($groupe_libelle).$affnombre.$affgpeprinc.$affgpenomail;
						}
						else
						{
						 $prop=" -- Gpe OFFICIEL --";
						 if(current($groupe_clone) !='')
						 {
						$affgroupe_clone="---[<- ".$groupe_libelle[current($groupe_clone)]."]";	 						 
						 }
						 else
						 {
						$affgroupe_clone="---[]";								 
						 }
						echo  " style=\"background-color:#CCFF00;\"> ".$prop.current($groupe_libelle).$affnombre.$affgroupe_clone.$affgpeprinc.$affgpenomail;						 
						}
					}
				elseif(current($groupe_visible)== 'oui'  ) 
					{
					 $prop=" -- Gpe Partagé --";
					echo  " style=\"background-color:#00FFFF;\"> ".$prop.current($groupe_libelle).$affnombre.$affgpeprinc.$affgpenomail;
					}	
				else{
					 $prop=" -- Gpe Privé --";
					echo  " style=\"background-color:#0099FF;\"> ".$prop.current($groupe_libelle)."  ( ".current($groupe_proprio)." ) ".$affnombre.$affgpeprinc.$affgpenomail;
					}
					echo "</option>";
	} //fin du if  membre scol
	elseif(in_array ($login ,$ri_modif_groupe ))
		{
		// on n'affiche pas le groupe Tous ni les groupes scol ni les officiels
				if (current($groupe_libelle)!= 'TOUS') { 

			  echo "  <option  value=\"".current($groupe_code)."\" ";
					if ($_POST['code_groupe']==current($groupe_code)){
				echo " SELECTED";
				}
			
				//si c'est un groupe officiel
				// ancienne version on regardait aussi le nom du domaine
				//list($domaine_prorio,$login_prorio)=explode("\\",current($groupe_proprio));

				//if (current($groupe_proprio)==$scol_user_complet){ 
			// il faut considérer 2 cas scol et autres
			$affnombre="----(".current($groupe_inscrits).")";
			if (current($groupe_type_auto)=='edt') { 
			 $prop="-- Gpe COURS --";
				 if (current($groupe_etudconst)=='VIDE' or current($groupe_etudconst)=='' )$affgroupe_etudconst="---[]";
				 else $affgroupe_etudconst="---[<- ".current($groupe_etudconst).']';
					echo  " style=\"background-color:#F78181;\"> ".$prop.current($groupe_titre_affiche).$affnombre.$affgroupe_etudconst;
				}

			elseif(current($groupe_const)!= '') 
				{
				 $prop=" -- Gpe SCOL --";
				echo  " style=\"background-color:#F7FE2E;\"> ".$prop.current($groupe_libelle).$affnombre;
				}
			elseif(current($groupe_offi)== 'oui'  ) 
				{
				if (current($groupe_archive)== 'oui' ) 
					{
					 $prop=" -- Gpe OFFICIEL ARCHIVE --";
					echo  " style=\"background-color:#99FFCC;\"> ".$prop.current($groupe_libelle).$affnombre;
					}
					else
					{
						 $prop=" -- Gpe OFFICIEL --";
						 if(current($groupe_clone) !='')
						 {
						$affgroupe_clone="---[<- ".$groupe_libelle[current($groupe_clone)]."]";	 						 
						 }
						 else
						 {
						$affgroupe_clone="---[]";								 
						 }
						echo  " style=\"background-color:#CCFF00;\"> ".$prop.current($groupe_libelle).$affnombre.$affgroupe_clone;						 

					}
				}
			elseif(current($groupe_visible)== 'oui'  ) 
				{
				 $prop=" -- Gpe Partagé --";
				echo  " style=\"background-color:#00FFFF;\"> ".$prop.current($groupe_libelle).$affnombre;
				}	
			else{
				 $prop=" -- Gpe Privé --";
				echo  " style=\"background-color:#0099FF;\"> ".$prop.current($groupe_libelle)."  ( ".current($groupe_proprio)." ) ".$affnombre;
				}
				echo "</option>";
				}
	 } //fin du if  groupe membre ri modif
	 else
	 {

	 // les autres ne voient que leurs groupes privés et partagés
	 		if(current($groupe_proprio)==$login and current($groupe_visible)== 'oui'  ) 
			{
			echo "  <option  value=\"".current($groupe_code)."\" ";
		  	if ($_POST['code_groupe']==current($groupe_code)){
		echo " SELECTED";
		}
			 $prop=" -- Gpe Partagé --";
		    echo  ">".$prop.current($groupe_libelle);
		    }	
			elseif (current($groupe_proprio)==$login ) {
			echo "  <option  value=\"".current($groupe_code)."\" ";
		  	if ($_POST['code_groupe']==current($groupe_code)){
		echo " SELECTED";
		}
			 $prop=" -- Gpe Privé --";
		    echo  ">".$prop.current($groupe_libelle)." ( ".current($groupe_proprio)." ) ";
			}	    
			echo "</option>";
	 }
	    next($groupe_code) ;
	    next($groupe_libelle);
	    next($groupe_proprio);
		next($groupe_offi);
		next ($groupe_type_auto);
		next ($groupe_const);
		next ($groupe_clone);		
		next ($groupe_arbre);	
		next ($groupe_titre_affiche);	
		next ($groupe_visible);	
		next ($groupe_archive);
		next ($groupe_inscrits);
		next($groupe_etudconst);
		next($groupe_principal);
		next($groupe_nomail);	
		next($groupe_pere);			
	    }

	echo"</select> " ; 
echo "<SCRIPT TYPE='text/javascript'>";
echo "var myfilter = new filterlist(document.ecranprincipal.code_groupe)";
echo "</SCRIPT>";   
 echo "</tr><tr >";
   echo "<td>";
  echo "( vous pouvez saisir une partie du nom <br>du groupe pour filtrer la liste )";
  echo "</tr>";
  echo"</table>";
	   echo "<br><input class='bouton_ok' type='Submit' name='mod' value='Ajouter/enlever/éditer des membres' class='bouton_ok'> ";
	            echo "<br><input class='bouton_ok' style='background-color:green' type='Submit' name='bouton_edit' value='Modifier' class='bouton_ok'> ";  
	echo "<input class='bouton_ok' type='Submit' style='background-color:red' name='bouton_sup_stage' value='Supprimer' class='bouton_ok'> ";
	
	    //  echo "<input type='Submit' name='bouton_dupl' value='Dupliquer'> ";
		echo "<br><br> Ou créez en un nouveau";
		  }
		  // si pas de groupe on affiche juste le bouton créer un gpe
echo "<br><input type='Submit' name='add' value='Créer un nouveau groupe' class='bouton_ok'> ";

echo "</form>";
   
}
echo "<br><br/>" ;
if($_POST['add']!='')  {
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
echo    "<form method=post action=$URL> ";
  echo"       <table><tr> ";

  //echo"<input type='hidden' name='ajout' value=1>";

   echo"<center>";
  echo"       <table><tr>  ";
  echo affichechamp('Libellé','libelle','','50');
 // echo "          <td>Libellé</td><td><input type='text' name='libelle' value=\"$libelle\" ></td>   ";

   //echo affichechamp('propriétaire','proprietaire',$domaine."-".$login,'50',1);
      echo affichechamp('propriétaire','login_proprietaire',$login,'15',1);
  //echo"<input type='hidden' name='login_proprietaire' value=\"".$login."\">";
  echo"       </tr><tr>  ";
      //pour la scol par defaut on cree un gpe public
if (in_array ($login ,$scol_user_liste )){
                echo afficheradio ('partagé','visible',$listeouinon,'',"oui") ;
				echo afficheradio ('groupe officiel','groupe_officiel',$listeouinon,'',"non") ;
				//  echo"<input type='hidden' name='groupe_officiel' value=\""."oui"."\">";
				}
        else{
              echo afficheradio ('partagé','visible',$listeouinon,'',"non") ;}
     echo "</td></tr><tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_add' value='ajouter'><input class='bouton_ok' type='Submit' name='bouton_annul' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
        }
if($_POST['sup']!='')  
		{
		//---------------------------------------c'est kon a cliqué sur le bouton supprimer
        }

if($_POST['mod']!='' or $_POST['bouton_supp_membre']!=''  or $_POST['bouton_ajout_membre'] !=''
 or $_POST['code_groupe_partie']!='' ){
	
  //------------------------------------c'est kon a cliqué sur le bouton Ajouter/enlever des membres------------------------------------------------------------
  
   echo    "<form    method=post action=$URL name='ajoutenleve'> ";
    
$tempcode_groupe=$_POST['code_groupe'];

  	    //on verifie si c'est le proprio du gpe  ou si c'est un Gpe officiel de la scol c'est le login d'un membre de la scol sinon on on ne fait rien

   // if (
   // strtolower($login)==strtolower($groupe_proprio[$tempcode_groupe]) or  in_array ($login ,$scol_user_liste ) or
   // (in_array ($login ,$ri_modif_groupe )  and ($groupe_type_auto[$_POST['code_groupe']]=='edt' and $groupe_etudconst[$_POST['code_groupe']]=='VIDE' ))
   // )
   // 11/11/2017 on autorise aux membres du gpe ri_modif le peuplement manuel même si il existe un gpe constitutif
     if (
   strtolower($login)==strtolower($groupe_proprio[$tempcode_groupe]) or  in_array ($login ,$scol_user_liste ) or
   (in_array ($login ,$ri_modif_groupe )  and ($groupe_type_auto[$_POST['code_groupe']]=='edt' ))
   )
   {
   echo "<br><br>";
 

  echo"<input type='hidden' name='code_groupe' value=\"".$_POST['code_groupe']."\">";
  echo"<input type='hidden' name='groupe_principal' value=\"".$groupe_principal[$tempcode_groupe]."\">";
  echo"<hr><table style='width:100%'><tr><td>";
  echo "<div class='titrePage' style='margin-top:-60px'> gestion des membres  du groupe : <br>".RemoveAccents2($groupe_libelle[$tempcode_groupe])." </div>";
  echo "</td><td>";
  
   echo "<div class='titrePage'>".RemoveAccents2('choisissez le groupe <br/>où récupérer les membres à ajouter')."</div><br/>";
reset($groupe_code) ;
	    reset($groupe_libelle);
	    reset($groupe_proprio);
		reset($groupe_offi);
		reset ($groupe_type_auto);
		reset ($groupe_const);
		reset ($groupe_arbre);	
		reset ($groupe_titre_affiche);	
		reset ($groupe_visible);	
		reset ($groupe_archive);

  echo "   <br/><select class='selectStyle' name='code_groupe_partie' style='width:100%' onchange='ajoutenleve.submit()'>";
 	echo  "  <option  value='AUCUN'";
echo " SELECTED  ";
echo "> aucun groupe sélectionné</option>";
  for($i=0;$i<sizeof($groupe_code);$i++) {
	 //on ne garde que les groupes peda pas ceux du personnel  (proprio != admin)

	 
	      $lignemenu="  <option  value=\"".current($groupe_code)."\" ";
		  	if ($_POST['code_groupe_partie']==current($groupe_code)){
		$lignemenu.= " SELECTED";
		}
	//si c'est un groupe officiel
	// ancienne version on regardait aussi le nom du domaine
	//list($domaine_prorio,$login_prorio)=explode("\\",current($groupe_proprio));
	//if (current($groupe_proprio)==$scol_user_complet){ 
	//if (in_array (strtolower($login_prorio) ,$scol_user_liste )) { 
	if (current($groupe_type_auto)=='edt') { 
	 $prop="- Gpe cours -";
	 //on  affiche  les groupes cours à nouveau
	 echo  $lignemenu." style=\"background-color:#F78181;\"> ".$prop.current($groupe_titre_affiche);
	 echo "</option>";
	}

	elseif(current($groupe_const)!= '') 
		{
		 $prop=" - gpe scol -";
	    echo   $lignemenu." style=\"background-color:#F7FE2E;\"> ".$prop.current($groupe_libelle);
		echo "</option>";
	    }
	elseif(current($groupe_offi)== 'oui' ) 
		{
		if (current($groupe_archive)== 'oui' ) 
			{
			 $prop=" -- Gpe OFFICIEL ARCHIVE --";
		    echo   $lignemenu." style=\"background-color:#99FFCC;\"> ".$prop.current($groupe_libelle);
			}
			else
			{
			 $prop=" -- Gpe OFFICIEL --";
		    echo   $lignemenu." style=\"background-color:#CCFF00;\"> ".$prop.current($groupe_libelle);
		    }
		}
		
	elseif(current($groupe_visible)== 'oui'and current($groupe_archive)!= 'oui' ) 
		{
		 $prop=" - gpe partagé -";
	    echo   $lignemenu." style=\"background-color:#00FFFF;\"> ".$prop.current($groupe_libelle);
		echo "</option>";		
	    }	
	elseif(current($groupe_archive)!= 'oui')
		{
		 $prop=" - gpe privé -";
	    echo   $lignemenu. " style=\"background-color:#0099FF;\"> ".$prop.current($groupe_libelle)." ( ".current($groupe_proprio)." ) ";
		echo "</option>";		
	    }
	elseif(current($groupe_code)== $code_gpe_tous)
		{
		 $prop=" - gpe Tous -";
	    echo   $lignemenu.">".$prop.current($groupe_libelle)." ( ".current($groupe_proprio)." ) ";
		echo "</option>";		
	    }
	  
	    next($groupe_code) ;
	    next($groupe_libelle);
	    next($groupe_proprio);
		next($groupe_offi);
		next ($groupe_type_auto);
		next ($groupe_const);
		next ($groupe_arbre);	
		next ($groupe_titre_affiche);	
		next ($groupe_visible);	
		next ($groupe_archive);			
	    }
   echo"</select> " ;
   echo"</td><tr>";

$query="SELECT etudiants.*,groupes.*,ligne_groupe.*
               FROM ligne_groupe INNER JOIN
                      etudiants ON ligne_groupe.code_etudiant = etudiants.`Code etu` LEFT OUTER JOIN
                      groupes ON ligne_groupe.code_groupe = groupes.code " ;
$query.= "where ligne_groupe.code_groupe= '".$_POST['code_groupe']."' order by etudiants.nom";

//$query= "SELECT etudiants.* from etudiants";
	     $result = mysql_query($query,$connexion ); 

// on initialise les 6 tableaux
$membres_groupe=array();
$non_membres=array();
$membres_groupe_exempte=array();
$membres_groupe_semestre=array();
$membres_groupe_type_insc=array();
$membres_groupe_date_modif=array();
$membres_groupe_modifpar=array();
// si on ne choisit qu'une certaine population : on utilise le tableau $etudiantspartie
   $sqlquery2="SELECT etudiants.*,groupes.*,ligne_groupe.*
               FROM ligne_groupe INNER JOIN
                      etudiants ON ligne_groupe.code_etudiant = etudiants.`Code etu` LEFT OUTER JOIN
                      groupes ON ligne_groupe.code_groupe = groupes.code " ;
 $sqlquery2.= "where ligne_groupe.code_groupe= '".$_POST['code_groupe_partie']."' order by etudiants.nom";
//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion ); 
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["Nom"] ;
$ind2=$v["Code etu"];
$etudiantspartie_nom[$ind2]=$v["Nom"];
$etudiantspartie_prenom[$ind2]=$v["Prénom 1"];
$etudiantspartie_code[$ind]=$v["Code etu"];
$etudiantspartie_code_simple[]=$v["Code etu"];
}

while ($v=mysql_fetch_array($result)){
//$temp=  "etudiants.[Code etu]";
$membres_groupe[]=$v['code_etudiant'];
$temp1=$v['code_etudiant'];
$membres_groupe_exempte[$temp1]=$v['exempte'];
$membres_groupe_semestre[$temp1]=$v['semestre'];
$membres_groupe_type_insc[$temp1]=$v['type_inscription'];
$membres_groupe_date_modif[$temp1]=$v['date_modif'];
$membres_groupe_modifpar[$temp1]=$v['modifpar'];
}
echo"<td style='color:red'>";
echo "<br/><select name='membres[]' multiple size=30 style='width:100% ;' >  ";
 for($i=0;$i<sizeof($membres_groupe);$i++) {
 $temp= $membres_groupe[$i];
      echo "  <option  value=\"".$temp."\">";
    //echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp] ." ". $exempte[$temp]);
	if ($membres_groupe_exempte[$temp]=='oui')
	{
	$affiche_exempt=' (--EXEMPTE--) ';
	}else
	 {
	$affiche_exempt='';
	 }
	 if ($membres_groupe_semestre[$temp]!='')
	{
	$affiche_semestre=' (--'.$membres_groupe_semestre[$temp].'--) ';
	}else
	 {
	$affiche_semestre='';
	 }
	 if (in_array($login,$scol_plus_user_liste))
	 {
		 echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp] ) ."    [".strtoupper($membres_groupe_type_insc[$temp])."]".$affiche_exempt." ".$affiche_semestre." -".mysql_DateTime($membres_groupe_date_modif[$temp])."  -".$membres_groupe_modifpar[$temp];   
	}
	 else
	 {
		 echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp] ) ."    [".strtoupper($membres_groupe_type_insc[$temp])."]".$affiche_exempt." ".$affiche_semestre;   
	 }		 
	 echo"</option> " ;
 }
   echo"</select> " ;
   echo "<div class='titrePage'>".sizeof($membres_groupe)." membre(s)</div>";
  echo "</td><td>";

$non_membres=array_diff($etudiantspartie_code_simple,$membres_groupe);

//print_r($etudiants_code);

echo " <br>  <select name='code_etudiant[]' multiple size=30 style='width:100%'>  ";
  foreach ($non_membres as $temp){
 if ($temp !=""){
      echo "  <option  value=\"".$temp."\">";

    echo $etudiants_nom[$temp]." ". strtolower($etudiants_prenom[$temp])." / ".$etudiants_annee[$temp];
    echo"</option> " ;
    }
 }
   echo"</select> " ;
   echo  "<div class='titrePage'>".sizeof($non_membres)." non membres</div>";
  echo "</td><td>";

   echo "</td></tr><tr>";
       echo afficheonly('','Vous pouvez sélectionner plusieurs lignes avec Control Click et Majuscule Click Sinon cliquer sur &#8594;');
         echo afficheonly('',"<input class='bouton_ok' type='button' onClick='tout()' value='Sélectionner tout'>",'','','',0);
	   echo "</tr><tr>";
	         if($groupe_type_auto[$tempcode_groupe]=='scol' and (sizeof($membres_groupe) !=0)){

		   echo  affichemenuncsubmit('si pas présent année entière sélectionner le semestre de présence à GI','bouton_choix_semestre',$liste_sem_presence,'',' sélectionnez le semestre');
			echo"</tr><tr>";
		  }
   echo"<th colspan=6>";
   if (sizeof($membres_groupe) !=0){
   if($groupe_type_auto[$tempcode_groupe]=='edt'){
	   	echo"<input class='bouton_ok' type='Submit' name='bouton_bloquer_membre' value='bloquer'>";
		   echo"<input class='bouton_ok' type='Submit' name='bouton_exempte_membre' value='exempter'>";
		   echo"<input class='bouton_ok' type='Submit' name='bouton_sup_exempte_membre' value='annuler exemption'>";
		   }
   echo"<input class='bouton_ok' type='Submit' name='bouton_supp_membre' value='enlever'>";
   }
   echo"<input class='bouton_ok' type='Submit' name='bouton_ajout_membre' value='ajouter'>";
   echo"</th >";
     echo"</th></tr></table></form> ";
   
   echo "<table width=\"700\">";
echo "<form action=" . $URL ." method='post' enctype='multipart/form-data'>";

echo "<tr>";
echo "<td width='20%'>Vous pouvez importer un fichier csv </td>";
echo "<td width='80%'><input class='input-file' type='file' name='file' id='file' ></td>";
echo "<tr>";
echo "<td width='20%'> </td>";
  echo"<input type='hidden' name='code_groupe_pour_csv' value=\"".$_POST['code_groupe']."\">";
echo "<td><input class='bouton_ok' type='submit' name='submit' /></td>";
echo "<tr>";
echo "</form>";
echo "</table>";
echo "</center>";

  }
 else {
     echo "<br>Vous n'avez pas les droits nécessaires pour gérer le groupe <b>". $groupe_libelle[$_POST['code_groupe']]."</b>   ";
	echo "</td></tr><tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
 }

      }
//----------------------------------------traitement du csv-------------------	  
if ( isset($_POST["submit"]) ) {
   if ( isset($_FILES["file"])) {
             echo "<br>______________________ <br />";
            //if there was an error uploading the file
        if ($_FILES["file"]["error"] > 0) {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

        }
        else {
                 //Print file details
             echo "Upload: " . $_FILES["file"]["name"] . "<br />";
             echo "Type: " . $_FILES["file"]["type"] . "<br />";
             echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
       //      echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                 //if file already exists
             if (file_exists("upload/" . $_FILES["file"]["name"])) {
            echo $_FILES["file"]["name"] . " already exists. ";
             }
             else {
                    //Store file in directory "upload" with the name of "uploaded_file.txt"
            $storagename = "uploaded_file.txt";
            move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
            }
			// traitement du fichier
						if ( $file = fopen( "upload/" . $storagename , 'r' ) ) {
				echo "File opened.<br />";
				//$firstline = fgets ($file, 4096 );
					//Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
				//$num = strlen($firstline) - strlen(str_replace(";", "", $firstline));
				$num=1;
					//save the different fields of the firstline in an array called fields
				//$fields = array();
				//$fields = explode( ";", $firstline, ($num+1) );
				$line = array();
				$i = 0;
					//CSV: one line is one record and the cells/fields are seperated by ";"
					//so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
				while ( $line[$i] = fgets ($file, 4096) ) {
					$dsatz[$i] = array();
					$dsatz[$i] = explode( ";", $line[$i], ($num+1) );
					$i++;
				}
			//echo print_r($dsatz);
					echo "<table>";
					echo "<tr>";
					// pas de ligne des noms de champs
			//	for ( $k = 0; $k != ($num+1); $k++ ) {
			//		echo "<td>".$fields[$k]."</td>";
			//	}
					echo "</tr>";
				foreach ($dsatz as $key => $number) {
							//new table row for every record
					echo "<tr>";
					foreach ($number as $k1 => $content) {
									//new table cell for every field of the record
						//echo "<td>" . $content . "</td>";
					}
				}
				echo "</table>";
// maintenant on peut effacer le fichier 
				
// ici il faut ecrire les lignes dans la table lignes inscription
$messagem='';
$aj=0;
$email_exp= ask_ldap($login,'mail');
$email_exp=  $email_exp[0];	
				//echo "code du groupe : ".$_POST['code_groupe_pour_csv'];
				foreach ($dsatz as $key => $number) {
							//new table row for every record
					
					foreach ($number as $k1 => $content) {
				$temp=intval($content);
									//new table cell for every field of the record
						//echo $etudiants_prenom[$temp];
						if (array_key_exists($temp,$etudiants_nom))
						{
						//on vérifie si cet etudiant n'est pas déjà dans ce groupe
							$querys = "select * from $table2 where code_etudiant='".$temp."' and code_groupe='".$_POST['code_groupe_pour_csv']."'";
							//echo $querys;
							$results = mysql_query($querys,$connexion ); 
							if (mysql_num_rows($results)==0)
								{
								$query = "INSERT INTO $table2(code_groupe,code_etudiant,modifpar,date_modif)";
								$query .= " VALUES('".$_POST['code_groupe_pour_csv']."','".$temp."','".$login."',now())";
								//echo $query ."<br>";
									  $result = mysql_query($query,$connexion ); 
								if ($result)
									{
									$aj++;
									$messagem .= $email_exp." vient d'ajouter l'etudiant  ".$etudiants_nom[$temp]." ".$etudiants_prenom[$temp]." (".$temp.") dans le  groupe ".$groupe_libelle[$_POST['code_groupe_pour_csv']]." \n<br>" ;
									}
								}
								else
								{
								echo " l'etudiant  ".$etudiants_nom[$temp]." ".$etudiants_prenom[$temp]." existe déjà dans le  groupe ".$groupe_libelle[$_POST['code_groupe_pour_csv']]." \n<br>" ;								
								}
						}
						else
						{
						$messagem .= "ATTENTION le code étudiant  ".$temp." n'est pas un code valide  \n<br>" ;
						
						}

					}
					
				}
	$messagem .="\n<br><b> Au total ".$aj." élèves ont été ajoutés au  groupe ".$groupe_libelle[$_POST['code_groupe_pour_csv']]."</b> \n<br>" ;
   echo $messagem;
   echo 
// ici on envoie le mail				
			$objet = "peuplement  d'un groupe cours par import de fichier csv" ;
// on envoie à l'auteur
envoimail( $email_exp,$objet,$messagem); 	
// on envoie a sigiadmin
envoimail( $sigiadminmail,$objet,$messagem);
// on envoie à la scol si c'est un resp d'année et que c'est un groupe cours

	if ($groupe_type_auto[$_POST['code_groupe_pour_csv']]=='edt' and in_array ($login ,$ri_modif_groupe ))
		{
			envoimail($scoltousmail,$objet,$messagem);  
		}				
			}
			
			
			
        }
     } else {
             echo "No file selected <br />";
     }
}
	  
	  
	  
	  

if($_GET['synchro']!='')  {
 //---------------------------------------c'est kon a cliqué sur le lien init
  echo"       <table><tr> ";
  echo    "<form method=post action=$URL> ";
  //echo"<input type='hidden' name='synchro' value=1>";
   echo"<center>";

   if ($login =='administrateur' or (in_array ($login ,$scol_user_liste ))){


   echo "êtes vous sur de vouloir mettre à jour le groupe principal de tous les etudiants et de reconstituer le groupe tous les inscrits(a lancer en cas de probleme de concordance )   ?";
    echo "</td></tr><tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_synchro' value='OK'><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
  }else   {
   echo "seul l'administrateur ou la scolarité  peut effectuer cette operation";
    echo "</td></tr><tr><th colspan=6><input type='Submit' class='bouton_ok' name='bouton_cancel' value='OK'></th></tr></table></center></form> "  ;
  }

        }
		
		
if($_GET['listegpe']!='')  {
 //---------------------------------------c'est kon a cliqué sur le lien liste des groupes 

$tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query = " SELECT * FROM `cours` order by code ";
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//on initialise  $csv_output
 $csv_output="";
$csv_output .= "code apogee;libelle court;ects;h_eqTD;h_detail;semestre;email resp;inscrits;gen;icl;idp;ap;sie;mastgi;mast2gi;stg";
$csv_output .= "\n";
echo"<center> <h2>Liste des ".$nombre."   fiches de cours ";
		echo" </h2></center>  <BR>";
		echo"<table border=1> ";
        echo "<th>code apogee</th><th>lien ksup</th> <th>libelle court</th><th>ects</th><th>h eq TD</th><th>h détail</th><th>semestre</th><th>email resp</th><th>inscrits</th><th>GEN</th><th>ICL</th><th>IDP</th><th>AP</th><th>MastSIE</th><th>Mast1GI</th><th>Mast2GI</th><th>STG</th>";     
        while($r=mysql_fetch_object($result)) {
			$icl=0;
			$idp=0;
			$ap=0;
			$stg=0;
			$gen=0;
			$sie=0;
			$gi=0;
			$go=0;

	$sqlquery3="SELECT distinct code_etudiant ,`Code étape` as codeEtape FROM ligne_groupe
left join groupes on code_groupe= code
left join etudiants on code_etudiant= `Code etu`
	 where libelle like  '%#".$r->CODE."%' " ;
	$resultat3=mysql_query($sqlquery3,$connexion ); 
	$inscrits=mysql_num_rows ( $resultat3 );
        while($s=mysql_fetch_object($resultat3)) {
			//Pour chaque étudiant on va vérifier sa filière pour faire un sous total
			$slice=explode("-",$s->codeEtape);
			if ($slice[1]=='ICL')
				$icl++;
			if ($slice[1]=='GEN')
				$gen++;			
			elseif ($slice[1]=='IDP')
				$idp++;
			elseif ($slice[1]=='AP')
				$ap++;		
			elseif ($slice[1]=='STG')
				$stg++;		
			elseif ($slice[1]=='SIE')
				$sie++;		
			elseif ($slice[1]=='GI')
				$gi++;		
			elseif ($slice[1]=='GO' or $slice[1]=='II' or $slice[1]=='DP')
				$go++;					
		}
 $tot=	$icl+$gen+$idp+$ap+$stg+$sie+$gi+$go	;
$iclpcent=0;
 $genpcent=0;
 $idppcent=0;  
  $appcent=0; 
 $stgpcent=0;   
 $siepcent=0;  
 $gipcent=0;   
 $gopcent=0;   
 if ($tot!=0)
 {
 $iclpcent=round(($icl/$tot)*100,0);
 $genpcent=round(($gen/$tot)*100);
  $idppcent=round(($idp/$tot)*100);
 $appcent=round(($ap/$tot)*100); 
 $stgpcent=round(($stg/$tot)*100);
 $siepcent=round(($sie/$tot)*100);
 $gipcent=round(($gi/$tot)*100);
 $gopcent=round(($go/$tot)*100); 
 }
   $csv_output .= "\n";
   if ($tot==$inscrits)
        	echo"   <tr><td>" ;
			else
        	echo"   <tr bgcolor='orange'><td>" ;				
			echo "<a href=".$URL."?liste1gpe=".$r->CODE.">".$r->CODE."</a>";
	   $csv_output .= nettoiecsvplus( $r->CODE);
		      echo"   </td><td>" ;
			  					if (array_key_exists($r->CODE,$fiche_code_ksup))
				{
				if($url_ksup_monobloc==''){echo  "<a href=".$url_ksup_prefixe.$fiche_code_ksup[$r->CODE].$url_ksup_suffixe." >"."$r->CODE"."</a>";}else{echo  "<a href=".$url_ksup_monobloc." >"."$r->CODE"."</a>";}
				}	   
		      echo"   </td><td>" ;
			echo $r->LIBELLE_COURT;
	   $csv_output .= nettoiecsvplus($r->LIBELLE_COURT);		
		      echo"   </td><td>" ;
			echo $r->CREDIT_ECTS;	
	   $csv_output .= nettoiecsvplus($r->CREDIT_ECTS); 	
      echo"   </td><td>" ;
			echo $r->heuresEqTD;	
	   $csv_output .= nettoiecsvplus(str_replace('.',',',$r->heuresEqTD)); 
      echo"   </td><td>" ;
			echo $r->heuresDetail;	
	   $csv_output .= nettoiecsvplus(str_replace('.',',',$r->heuresDetail)); 	   
		      echo"   </td><td>" ;
			echo $r->semestre;	
	   $csv_output .= nettoiecsvplus($r->semestre); 		
		      echo"   </td><td>" ;
			echo $r->emailResponsable;	
	   $csv_output .= nettoiecsvplus($r->emailResponsable); 
	   
		      echo"   </td><td>" ;			  
			echo $inscrits;	
   $csv_output .= nettoiecsvplus($inscrits); 
    		 echo"   </td><td>" ; 
			echo $gen;	
			echo " (". $genpcent ."%) ";		
   $csv_output .= nettoiecsvplus($gen);   
  		      echo"   </td><td>" ; 
			echo $icl;	
			echo " (". $iclpcent ."%) ";
   $csv_output .= nettoiecsvplus($icl);    
     		      echo"   </td><td>" ; 
			echo $idp;	
			echo " (". $idppcent ."%) ";			
   $csv_output .= nettoiecsvplus($idp);  
  		      echo"   </td><td>" ; 
			echo $ap;
			echo " (". $appcent ."%) ";			
   $csv_output .= nettoiecsvplus($ap);    
     		  echo"   </td><td>" ; 
			echo $sie;	
			echo " (". $siepcent ."%) ";
   $csv_output .= nettoiecsvplus($sie); 
    		  echo"   </td><td>" ; 
			echo $gi;
			echo " (". $gipcent ."%) ";			
   $csv_output .= nettoiecsvplus($gi);    
 		      echo"   </td><td>" ; 
			echo $go;
			echo " (". $gopcent ."%) ";			
   $csv_output .= nettoiecsvplus($go);    
 		      echo"   </td><td>" ; 			  
			echo $stg;
			echo " (". $stgpcent ."%) ";			
   $csv_output .= nettoiecsvplus($stg);     
   
			echo"   </td></tr>" ;			
        }
		echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
        echo"</table>"; 
        }		

if($_GET['liste1gpe']!='')  {
 //---------------------------------------c'est kon a cliqué sur le lien code apogee pour un gpe 

$tabletemp="cours";
$champs=champsfromtable($tabletemp);
	$query ="SELECT distinct code_etudiant ,`Code étape` as codeEtape FROM ligne_groupe
left join groupes on code_groupe= code
left join etudiants on code_etudiant= `Code etu`
	 where libelle like  '%#".$_GET['liste1gpe']."%' " ;
	//$query.=$where."  ";
   //$query.=$orderby."  ";   
   $result = mysql_query($query,$connexion ); 
$nombre= mysql_num_rows($result);
//on initialise  $csv_output
 $csv_output="";
$csv_output .= "code_etudiant;code Etape";
$csv_output .= "\n";
echo"<center> <h2>Liste des ".$nombre."   inscriptions au  cours ".$_GET['liste1gpe'] ;
		echo" </h2></center>  <BR>";
		echo"<table border=1> ";
        echo "<th>code_etudiant</th><th>code Etape</th> ";     
        while($r=mysql_fetch_object($result)) {

	

 
   $csv_output .= "\n";
        	echo"   <tr><td>" ;
			echo $r->code_etudiant;
	   $csv_output .= nettoiecsvplus( $r->code_etudiant);
		      echo"   </td><td>" ;
			echo $r->codeEtape;
	   $csv_output .= nettoiecsvplus( $r->codeEtape);
		      echo"   </td><td>" ;	 
			echo"   </td></tr>" ;			
        }
		echo  "<FORM  action=export.php method=POST name='form_export'> ";
 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
echo "</form>";
        echo"</table>"; 
        }			
		
 if($_POST['bouton_sup_stage']!='')  {
 if($_POST['code_groupe']!=''){
 //---------------------------------------c'est kon a cliqué sur le bouton supprimer un groupe
// $query="SELECT * FROM   $table      
//WHERE     (code= ".$_POST['code_groupe'].")";
$temp=$_POST['code_groupe'];
// $result = odbc_exec($sqlconnect, $query); 
  	    //si ce n'est pas le proprio du gpe on ne fait rien
	   
  echo    "<form method=post action=$URL> ";
   echo"<center>"; 
	    //si ce n'est pas le proprio du gpe ni un  gpe de la scol et un utilisateur de la scol on ne fait rien

      if (strtolower($login)==strtolower($groupe_proprio[$temp]) or  in_array ($login ,$scol_user_liste ) )
   {
   //$temp=$_POST['code_groupe'] ;
   echo"<input type='hidden' name='code_groupe' value='".$temp."'>";
    echo"<input type='hidden' name='libelle_groupe' value='".$groupe_libelle[$temp]."'>";
    echo"<input type='hidden' name='groupe_type_auto' value='".$groupe_type_auto[$temp]."'>";	
	
   echo "êtes vous sur de vouloir supprimer le groupe $groupe_libelle[$temp] ?";
    echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_effacer_stage_conf' value='OK'><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
	}
	//si le login n'est pas le login_proprietaire
  else{
  echo "<br>Vous n'avez pas les droits nécessaires  pour supprimer le groupe <b>". $groupe_libelle[$_POST['code_groupe']]."</b>   ";
	echo "</td></tr><tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
	}
  echo"</center>";
  echo "</form>";
  }
}

 //---------------------------------------c'est kon a cliqué sur le bouton dupliquer un groupe
 // inutile maintenant 09-2010
 if(0)
 {
 if($_POST['bouton_dupl']!='' and $_POST['code_groupe']!='')  
 {
 $query="SELECT * FROM   $table      
WHERE     (code= ".$_POST['code_groupe'].")";
   	$result =mysql_query($query,$connexion );
	$e=mysql_fetch_object($result); 
	$i=1;
   //on fait une boucle pour créer les variables issues de la table stage
   foreach($champs as $ci2){
    $$ci2=$e->$ci2;  }
   //on surcharge les infos gpe principal en cas de duplication d'un gpe officiel
   $groupe_officiel='non';
   $groupe_principal='non';
   $liste_offi='non';
   $visible='non';
     echo    "<form method=post action=$URL> ";
   //on fait une boucle pour remettre en hiden tous les champs  de la table groupe
        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
            foreach($champs as $ci2){
        echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";
        }
  echo "Attention vous allez créer un nouveau groupe avec les  membres du groupe ". $libelle ."<br>";
  echo"       <table><tr> ";
  //echo"<input type='hidden' name='ajout' value=1>";
   echo"<center>";
  echo"       <table><tr>  ";
  echo affichechamp('nouveau libellé','libelle','','');
 // echo "          <td>Libellé</td><td><input type='text' name='libelle' value=\"$libelle\" ></td>   ";
   //echo affichechamp('propriétaire','proprietaire',$domaine."-".$login,'50',1);
  echo"<input type='hidden' name='login_proprietaire' value=\"".$login."\">";
    echo"<input type='hidden' name='liste_offi' value='non'>";
  //il faut mettre en hidden le code  du groupe qui sert à la duplication
      $listeouinon=array('oui','non') ;
      //pour la scol par defaut on cree un gpe public
              echo afficheradio ('partagé','visible',$listeouinon,$visible,"non") ;
                               echo "</tr><tr>";
           echo affichechamp('propriétaire','proprietaire',$login,'40',1);
           echo "</td></tr><tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_dupliquer_ok' value='OK'><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
  echo"</center>";
  }
}

if($_POST['bouton_edit']!='' and $_POST['code_groupe']!='') 
{
 //---------------------------------------c'est kon a cliqué sur le bouton editer  un groupe

   $query="SELECT * FROM   $table      
WHERE     (code= ".$_POST['code_groupe'].")";

	     $result = mysql_query($query,$connexion ); 
		 	$e=mysql_fetch_object($result); 

   //on fait une boucle pour créer les variables issues de la table
   foreach($champs as $ci2){
    $$ci2=$e->$ci2;
   }
		$date_modif=mysql_Time($date_modif);

   
     echo    "<form style='background-color:#f1fff1' method=post action=$URL> ";
	    //si ce n'est pas le proprio du gpe ni   un utilisateur de la scol on ne fait rien
	      if (strtolower($login)==strtolower($e->login_proprietaire) or  in_array ($login ,$scol_user_liste )or in_array ($login ,$nomail_user_liste )) 
			{
		if (($e->type_gpe_auto!='edt' and $e->type_gpe_auto!='scol' )or in_array($login, $scol_plus_user_liste) )
			{
			 
		   //on fait une boucle pour remettre en hiden tous les champs  de la table groupes
		        //ceci fait que meme sils ne sont pas dans le formulaire on garde leur valeur
		            foreach($champs as $ci2){
		       echo"<input type='hidden' name='".$ci2."' value=\"".htmlspecialchars($$ci2, ENT_QUOTES, 'ISO8859-1')."\">\n";			
		        }
				
				//on stocke ds un champ cache le libelle pour pouvoir savoir si il  a été modifiée
				echo"<input type='hidden' name='libelle_sauv' value=\"".htmlspecialchars($libelle, ENT_QUOTES, 'ISO8859-1')."\">";			
								//on stocke ds un champ cache le type auto pour pouvoir savoir si il  a été modifiée
				echo"<input type='hidden' name='type_gpe_auto_sauv' value=\"".$type_gpe_auto."\">";
				
		  echo"       <table><tr> <hr/>";

		  //echo"<input type='hidden' name='ajout' value=1>";

		   echo"<center>";
		  echo"       <table><tr>  ";
		   if (in_array ($login ,$scol_user_liste ) ){
		  echo affichechamp('Libellé','libelle',$libelle,'50');
		// echo "          <td>Libellé</td><td><input type='text' name='libelle' value=\"$libelle\" ></td>   ";

		   //echo affichechamp('propriétaire','proprietaire',$domaine."-".$login,'50',1);
		 
		  //2020 
		  //echo"<input type='hidden' name='login_proprietaire' value=\"".$login."\">";
		      $listeouinon=array('oui','non') ;
		      //pour la scol par defaut on cree un gpe public

		              echo afficheradio ('groupe partagé','visible',$listeouinon,$visible,"non") ;
		                   //  if (in_array ($login ,$re_user_liste ) or $login == 'administrateur')
							// { 
							//	if ($id_ens_referent=='')$id_ens_referent='9999';
							//	echo affichemenusqlplus('Tuteur référent','id_ens_referent','id','select * from enseignants order by nom','nom',$id_ens_referent,$connexion);
							//}							 
   
							                    echo "</tr><tr>"; 
						echo afficheradio ('groupe officiel','groupe_officiel',$listeouinon,$groupe_officiel,"non") ;
						echo afficheradio ('groupe principal','groupe_principal',$listeouinon,$groupe_principal,"non") ;

						if (in_array($login, $scol_plus_user_liste)){
						echo afficheradio ('Ajouter au groupe TOUS LES INSCRITS','membre_gpe_total',$listeouinon,$membre_gpe_total,"non") ;
						echo afficheradio ('groupe TOUS LES INSCRITS','gpe_total',$listeouinon,$gpe_total,"non") ;

						echo "</tr><tr>";
						echo affichechamp('Code gpe parent','code_pere',$code_pere,'5');
						echo affichemenusqlplusnc('choisissez le groupe parent','code_pere','code','select * from groupes where libelle !=\'VIDE\' order by libelle ','libelle',$code_pere,$connexion);
						echo affichechamp('niveau parent','niveau parente',$niveau_parente,'2');
						}
		                               echo "</tr><tr>";
						echo afficheradio ('liste de difffusion officielle','liste_offi',$listeouinon,$liste_offi,"non") ;
						echo affichechamp('adresse de la liste de diffusion','nom_liste',$nom_liste,'40');
						echo affichechamp ('URL EdT directe','url_edt_direct',$url_edt_direct,'40') ;
		                               echo "</tr><tr>";
						echo afficheradio ("titre spécial (sinon c'est le libellé du gpe)",'titre_special',$listeouinon,$titre_special,"non") ;
						                   echo affichechamp('titre spécial à afficher','titre_affiche',$titre_affiche,'80');
						echo "</tr><tr>";								   
						echo afficheradio ('archivé','archive',$listeouinon,$archive,"non") ;
						}
						if(in_array($login, $scol_plus_user_liste) ){
						// gestion du cas vide
						
		                               echo "</tr><tr>";
						//echo affichechamp('Code ADE','code_ade',$code_ade,'30');
						echo affichechamp('Code ADE6','code_ade6',$code_ade6,'50');						
						echo afficheradio ('groupe_cours_complet ? ( pour affichage base élèves uniquement , n\'existe pas dans ADE )','groupe_cours_complet',$listeouinon,$groupe_cours_complet,'non');						
						echo afficheradio ('groupe évènement','gpe_evenement',$listeouinon,$gpe_evenement,"non") ;
						                echo "</tr><tr>";
							            echo "</tr><tr>";
						echo affichechamp('arbre groupe','arbre_gpe',$arbre_gpe,'25');
						echo affichechamp('type groupe','type_gpe_auto',$type_gpe_auto,'5');
						echo afficheradio ('masquer le mail des étudiants','nomail',$listeouinon,$nomail,"non") ;						
										echo "</tr><tr>";
						echo affichechamp('si c\'est un gpe constitutif : son nom','libelle_gpe_constitutif',$libelle_gpe_constitutif,'10');
						echo affichechamp('groupe cours peuplé à partir de :','gpe_etud_constitutif',$gpe_etud_constitutif,'10');
						//echo affichemenusqlplusnc('groupe cours peuplé à partir de:','gpe_etud_constitutif','libelle',"select * from groupes where type_gpe_auto ='scol' order by libelle ",'libelle',$gpe_etud_constitutif,$connexion);						
						
						//echo affichechamp('gpe offi cloné à partir de gpe scol ','recopie_gpe_officiel',$recopie_gpe_officiel,'10');
						echo affichemenusqlplusnc('gpe offi cloné, choisissez le groupe scol origine :','recopie_gpe_officiel','code',"select * from groupes where type_gpe_auto ='scol' order by libelle ",'libelle',$recopie_gpe_officiel,$connexion);						
										//echo affichechamp('archivé','archive',$archive,'5');
						                echo "</tr><tr>";	
						   echo affichechamp('code interne','code',$code,'6',1);								
							}
							// ajout 2019
							elseif	(in_array ($login ,$nomail_user_liste ) ){
								echo afficheradio ('masquer le mail des étudiants','nomail',$listeouinon,$nomail,"non") ;	
										echo "</tr><tr>";								
							}	
							if ($login=='administrateur'){							
								echo affichechamp('code propriétaire','login_proprietaire',$login_proprietaire,'15');
								}
							else
							{
							 echo affichechamp('code propriétaire','login_proprietaire',$login_proprietaire,'15',1);
							}
		                   echo affichechamp('date modif','date_modif',$date_modif,'18',1);
		                  // echo affichechamp('code','code',$code,'10',1);
						 
					     echo "</td></tr><tr><td colspan=6><input class='bouton_ok' type='Submit' name='bouton_edit_ok' value='OK'>  <input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></td></tr></table></form> "  ;
					  echo"</center>";
			}
			//si c'est un grpe systeme
			 else
			 {
			  echo "<br>Vous ne pouvez pas modifier le groupe <b>". $groupe_libelle[$_POST['code_groupe']]."</b> parce que c'est un groupe système  de type  scol ou cours    ";
			  echo "<tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
			  }
			}
			//si le login n'est pas le login_proprietaire
			  else
			  {
			  echo "<br>Vous n'avez pas les droits nécessaires pour modifier le groupe <b>". $groupe_libelle[$_POST['code_groupe']]."</b>   ";
			  echo "<tr><th colspan=6><input class='bouton_ok' type='Submit' name='bouton_cancel' value='Annuler'></th></tr></table></form> "  ;
			  }
}


mysql_close($connexion);
echo "<br><br>";
require ("footer.php");
echo"</body>";
echo "</html>";
?>