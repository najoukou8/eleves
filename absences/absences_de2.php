<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
<?


//on filtre tous les arg reçus en get

    foreach($_GET AS $key => $value) {
		        // On regarde si le type de arg  est une string
        if(is_string($value))
		{
		$_GET[$key] = 	htmlspecialchars($value, ENT_QUOTES, 'ISO-8859-1',false);
		
		}
		// on regarde si c'est un tableau
		if (is_array($value))
		{
			//dans ce cas on nettoie chaque ligne du tableau si c'est une string
	        if(is_string($value))
				{		
					foreach($value AS $cle => $valeur) {
					$_GET[$cle] = 	htmlspecialchars($value, ENT_QUOTES, 'ISO-8859-1',false);		
					}
				}		
		}
    }
//on filtre tous les arg reçus en Post

    foreach($_POST AS $key => $value) {
		        // On regarde si le type de arg  est une string
        if(is_string($value))
		{		
		$_POST[$key] =htmlspecialchars($value, ENT_QUOTES, 'ISO-8859-1',false);
		}
		// on regarde si c'est un tableau
		if (is_array($value))
		{
			//dans ce cas on nettoie chaque ligne du tableau si c'est une string
	        if(is_string($value))
				{		
					foreach($value AS $cle => $valeur) {
					$_POST[$cle] = 	htmlspecialchars($value, ENT_QUOTES, 'ISO-8859-1',false);			
					}
				}		
		}		
    }




//attention il ne doit pas y avoir de nom de colonnes identiques
// il doit y avoir un index unique (auto incrémental ou pas ) dans chaque fichier
// si on a un seul fichier laisser les infos $cleetrangere2 $table2  $indexlien2 à vide
// si on veut autoriser tout le monde laisser des array vides 

require ("../param.php");
//---paramètres à configurer
// texte affiché en haut du tableau
$texteintro= "<h2></h2>";
//accès à la BDD on peut aussi les mettre dans un fichier de param séparé (param .php)
//$dsn="qualite_gi_test";
//$user_sql="qualiteuser";
//$password='test2014';
//$host="localhost";
//connexion pdo (pdo=1) ou oldfashion (pdo=0)
$pdo=1;
// CAS activé nécessite la présence de cas.php  et du rep CAS dans le rep
$casOn=0;
$texte_table='Absences Interface du DE';
// pour afficher dans l'interface le nom des entités de chaque table
$texte_entite='absence';
$texte_entite2='étudiant';
$texte_entite3='';
$table="absences";
$cleprimaire='id_absence';
$autoincrement='id_absence';
$cleetrangere2='code_etud';
// pour l'ordre d'affichage dans le  select en saisie / modification - peut être vide
$ordrecleeetrangere2='order by Nom';
// restriction dans le  select en saisie / modification - peut être vide
$wherecleeetrangere2="";
$table2="etudiants";
$indexlien2='Code etu';
$cleetrangere3='statut_absence';
$ordrecleeetrangere3='';
// restriction dans le  select en saisie / modification - peut être vide
$wherecleeetrangere3="";
$table3="absences_statuts";
$indexlien3='absences_statuts_code';
// pour la gestion des champs modifpar et date_modif
//laissez vide si pas géré
$champ_date_modif='date_modif';
$champ_modifpar='modifpar';

$liste_champs_lies2=array('Nom', 'Prénom 1');
$liste_champs_lies3=array('absences_statuts_texte');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout2=array('Nom', 'Prénom 1');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout3=array('absences_statuts_texte','');
// au moins un (cléprimaire)
$liste_champs_obligatoires=array();
$liste_champs_lecture_seule_ajout=array('commentaire_absence','valide', 'absence_justif', 'statut_absence','absence_log');
$liste_champs_lecture_seule_modif=array('date_debut', 'date_fin','mot_cle', 'motif','duree','commentaire_absence','valide', 'absence_justif', 'statut_absence','absence_log');
//permet d'affecter lors de l'ajout une valeur aux champs en lecture seule ou invisibles (sinon c'est la valeur par defaut définie dans la bdd)
$liste_champs_lecture_seule_ou_invisibles_affectes_en_ajout=array('absence_log', 'statut_absence');
$liste_champs_invisibles_ajout=array('commentaire_absence','modifpar','date_modif');
$liste_champs_invisibles_modif=array('modifpar','date_modif');
$liste_champs_dates=array('date_debut', 'date_fin');
$liste_champs_heures=array();
// champs qui doivent être saisis à partir d'un select
$liste_champs_select=array('');
$liste_choix_eleveacteur_axe=array();
//pour afficher des radio buttons syntaxe array('nom_du_champ'=>$liste_de_valeurs,...)
//$liste_champs_bool=array('com_selection'=>$listeouinon);
$liste_champs_bool=array();
$liste_champs_tableau=array( 'Nom', 'Prénom 1', 'date_debut', 'date_fin','mot_cle', 'motif', 'valide', 'date_modif','absences_statuts_texte');
$liste_champs_filtre=array('Nom','absences_statuts_texte','mot_cle');
// pour les filtres si il faut aller plus loin que select distinct
$liste_champs_filtre_partiel=array();
$liste_champs_filtre_partiel_traitement=array();
//----------------------------------------------

//----------------------------------------------
// nom des en tetes du tableau à substituer si commentaire de mysql vides
//dans l'ordre on regarde le tableau $liste_libelles_tableau, puis le commentaire sql sinon on prend le nom du champs
$liste_libelles_tableau=array('Prénom 1'=>'Prénom','mot_cle'=>'mot clé');
// nom des champs à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ sinon on prend le nom du champs
$liste_libelles_champ=array();
// taille des champs d'affichage à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ
$liste_tailles_champ=array();
$liste_place_holder=array();
//pour les valeurs par defaut en ajout 
$liste_valeur_defaut=array();
//pour  l'ordre d'affichage
$liste_ordre_champ=array();
//le tri du premier affichage du tableau (avant de cliquer sur les entêtes) si vide c'est la cle primaire
$champ_tri_initial='statut_absence';
// sens du tri initial asc ou desc
$senstriinitial='desc';
// where initial si pas de filtre initial  : $filtre_initial="where ";

//$filtre_initial="where (date_debut > '".($annee_courante-1)."-09-01') and  ";
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// acces depuis fiche.php
//if(isset($_GET['code_etud_rech']) and $_GET['code_etud_rech']!='')
//$filtre_initial="where ";
//else
//$filtre_initial="where date_debut > '".strval(intval($annee_courante)-1)."-08-31' and ";
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// pour ajouter un champ calculé aux requêtes select 
//$ajout_sql=",year(date_debut) as year ";
$ajout_sql="";
// pour accéder à la page
$login_autorises=array_merge($de_user_liste,array('lemairpi','foukan'));
//pour pouvoir usurper une identité vide si on ne veut pas de cette fonctionnalité
//attention danger normalement seulement administrateur
// incompatible avec $login_autorises vide
$login_autorises_clone=array('administrateur');
// pour pouvoir  ajouter
$login_autorises_ajout=array('administrateur');
// pour pouvoir  supprimer
$login_autorises_suppression=array('administrateur');
// pour pouvoir  modifier
$login_autorises_modif=array_merge($de_user_liste,array('administrateur','foukan'));
// pour pouvoir  accéder à détails : formulaire de modification sans validation
$login_autorises_details=array_merge($de_user_liste,array('administrateur'));
// pour pouvoir  exporter
$login_autorises_export=array_merge($de_user_liste,array('administrateur'));
// email correspondant au login  administrateur
$emailadmin='nadir.fouka@grenoble-inp.fr';
$emailgestionnaire='genie-industriel.scolarite@grenoble-inp.fr';
// est ce qu'on fait appel à ldap pour récupérer les noms prenom mail ...à partir des logins
$ldapOK=1;
// attention pour vérifier les groupes autorisés après l'authentification CAS ldap est aussi utilisé
//si on laisse vide les 2 dn des groupes , tout le monde est accepté et le nomgroupe authentification vaut :' membre de grenoble-inp'
// dn du groupe1
$dngroupe1authentification1='CN=inpg-GI-personnels-GI-GSCOP,OU=Groups,DC=gi-admin,DC=inpg,DC=fr';
// nom affiché du groupe 1 
$nomgroupe1authentification1="Personnel GI-GSCOP";
// dn du groupe1
$dngroupe1authentification2='';
// nom affiché du groupe 1 
$nomgroupe1authentification2="";
$pageaccueil='../default.php';
// au dessus de cette valeur  on tracera une zone de texte
$tailleLimiteChampCourt = 200;
//en dessous on prendra soit cette valeur soit la valeur présente dans 2eme item des commentaires de champs de la bdd ou dans la liste $liste_tailles_champ
$tailleDefautChampCourt = 60;
// changement couleur dans tableau
// à partir de combien de répétitions on change (au moins 1) si 0 désactive la fonctionnalité
$seuil_changement_couleur=0;
// nom du champ qui déclenchera le changement de couleur ne peut pas être vide
$champrepetition='';
// couleur html des lignes à répetition
$couleur_changement=' orange ';
// champs qui doivent être saisis à partir d'un select avec valeur retournée distincte de valeur affichée
$liste_champs_select_plus=array();
$liste_choix_lib_statut_absence=array();
$liste_choix_code_statut_absence=array();
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
if (isset($_GET['toutvoir']) and $_GET['toutvoir']) $_GET['tout']=1;
if (isset($_GET['toutvoir']) and !$_GET['toutvoir']) $_GET['tout']=0;

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
$liste_param_get=array('clone','from','tout');
$filtrerech='';
 foreach($liste_param_get as $unparam )
{
	// on les initialise à vide 
	if (!isset($_GET[$unparam])) $_GET[$unparam]='';
	if (!isset($_POST[$unparam])) $_POST[$unparam]='';	
	if ($_GET[$unparam] !='' )$_POST[$unparam]=$_GET[$unparam];
	if ($_POST[$unparam] !='' )$_GET[$unparam]=$_POST[$unparam];
	if ( $_POST[$unparam]!='')
	{
		$filtrerech.=$unparam."=".urlencode($_POST[$unparam])."&";
	}
}
// pour la premiere fois ou on change 


if ($_GET['tout'])
{
//$filtre_initial="where statut_absence !=7  and ";
$filtre_initial="where (date_debut > '".($annee_courante-1)."-09-01') and  ";
$liste_champs_filtre_val_defaut=array('absences_statuts_texte'=>'tous');
//$filtre_initial="where (statut_absence =3 or  statut_absence =9) and ";
}
else
{
$filtre_initial="where (statut_absence =3 or  statut_absence =9) and ";
$liste_champs_filtre_val_defaut=array('absences_statuts_texte'=>'tous');
}

//-------------------------fin de configuration

// ces 2 fichiers doivent être présent dans le même rep
require ("../function.php");
require ("../style.php");
echo "<head>";
echo "<title>".$texte_table."</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";
// ces 4 fichiers doivent être présent dans le même rep
echo "		<link rel='stylesheet' href='../js/calendrier.css' type='text/css' />";
echo "		<script src='../js/jsSimpleDatePickrInit.js'></script>";
echo "		<script src='../js/jsSimpleDatePickr.js'></script>";
echo "		<script src='../js/verifheure.js'></script>";
echo "</HEAD><BODY>" ;
// On se connecte à mysql classique ou  PDO
if($pdo)
	$connexion =ConnexionPDO ($user_sql, $password, $dsn, $host);
else
$connexion =Connexion ($user_sql, $password, $dsn, $host);
$loginConnecte = 'lemairpi' ; 
$login ='lemairpi' ;
$_SERVER['PHP_AUTH_USER']= 'lemairpi' ;  
require('../header.php');
// pour le cas

$_SERVER['PHP_AUTH_USER']= 'lemairpi' ; 

$loginConnecte = 'lemairpi' ; 
$login ='lemairpi' ;
// pour le cas
if($casOn)
{	
// nom de la variable de session
$nomSession='sess123';
require ("casgenerique.php");
$loginConnecte = $login;
}
else
{
//// on récupère le login du connecté dans $_SERVER (authentification http ldap )
 // if(isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] !=''){
	 // $loginConnecte=$_SERVER['PHP_AUTH_USER'];
	 // $loginConnecte=strtolower($loginConnecte);}
	 // else
	 // { $loginConnecte=''; }
}


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
if (!isset($_POST['clone'])) $_POST['clone']='';
if (!isset($_GET['clone'])) $_GET['clone']='';
if (!isset($_POST['bouton_valider_mod'])) $_POST['bouton_valider_mod']='';
if (!isset($_POST['bouton_valider2_mod'])) $_POST['bouton_valider2_mod']='';
if (!isset($_POST['bouton_nepasvalider_mod'])) $_POST['bouton_nepasvalider_mod']='';
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if (!isset($_POST['bouton_info_comp'])) $_POST['bouton_info_comp']='';
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$URL =$_SERVER['PHP_SELF'];
// pour tester comme un autre
// il faut récupérer la valeur de clone  qui pourrait être passée par un formulaire en hidden
// pour la déconnexion

if (($_GET['clone'] !='' ))$_POST['clone']=$_GET['clone'];
// pour garder clone apres un form non lancé par un lien 
if (($_POST['clone'] !='' ))$_GET['clone']=$_POST['clone'];
if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'givenname')[0]." ".ask_ldap($loginConnecte,'sn')[0];else  $nomloginConnecte='';
if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';
if($loginConnecte=='administrateur' ) 
{$emailConnecte=$emailadmin;
$nomloginConnecte='Administrateur';
}
//echo " <p align=right>Vous &ecirc;tes  <b>  : ".$loginConnecte."( ".$emailConnecte.")</b>  ";
//echo $nomloginConnecte."<br>";
// on sauvegarde le login de primo connexion 
$loginorigine=$loginConnecte;
// on sauvegarde le email de primo connexion 
$emailorigine=$emailConnecte;
// si on a le droit 

require ('./../header.php'); 
$loginConnecte = 'lemairpi' ; 

if (in_array($loginConnecte,$login_autorises_clone) ) {
			//et qu'on est pas sur la page  de modif ou d'ajout on affiche le formulaire clone 
	if ( $_GET['add']=='' and $_GET['mod']==''  )
	 {
		   echo  "<FORM  action=$URL method=POST name='form_clone'> ";
			echo "<p align=right>Clone";echo affichechamp('','clone','',10);	
			echo"     <input type ='submit' name='bouton_clone'  value='OK'> <br> "  ;
			echo "</form>";
	 }
			// et on remplace  $login par $_POST['clone']
	if ($_POST['clone'] !=''  ) {			
			$loginConnecte=$_POST['clone'];
			echo "<p align=right><i> login clone :".$loginConnecte."</i> ";
			if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'givenname')[0]." ".ask_ldap($loginConnecte,'sn')[0];else  $nomloginConnecte='';	
			if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';			
			echo $nomloginConnecte." (".$emailConnecte.")<br>";
			echo "<A href=".$URL."?clone= >Déconnexion $loginConnecte </a><br>";
			}
}

$message='';
$messagem='';
$sql1='';
$sql2='';
$where='';
$orderby= '';
if ($_POST['clone']!='')
	$filtrerech.="clone=".$_POST['clone']."&";
//+++++++++++++++++++++++++
	//else
	//$filtrerech='';
//++++++++++++++++++++
$filtretri='';
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

//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille et leur commentaires
      $champs= champsfromtable ($table,$connexion);
	  $type= champstypefromtable ($table,$connexion);
	  $comment=champscommentfromtableplus ($table,$connexion,0,'$',0);
	  $commentTaille=champscommentfromtableplus ($table,$connexion,0,'$',1);	  
	  $commentPlaceHolder=champscommentfromtableplus ($table,$connexion,0,'$',2);	
	  $commentValDefaut=champscommentfromtableplus ($table,$connexion,0,'$',3);	  
// taille des champs 
		$taillechamp=champsindextaillefromtable($table,$connexion);
		// on cree un tableau indexé des longueurs par le nom des champs
// on sauvegarde le tableau des champs sans les champs lies
$champsSingle=$champs;
if ($table2!='')
{
	//on cree un tableau $champstable2[] avec les noms des colonnes de la table  et leur taille et leur commentaires	
		  $champstable2= champsfromtable ($table2,$connexion);
		  $typetable2= champstypefromtable ($table2,$connexion);
		  $commenttable2=champscommentfromtable ($table2,$connexion);
		  $commentTaille2=champscommentfromtableplus ($table2,$connexion,0,'$',1);	
		$commentPlaceHolder2=champscommentfromtableplus ($table2,$connexion,0,'$',2);	
	  $commentValDefaut2=champscommentfromtableplus ($table2,$connexion,0,'$',3);	 		
		  //$commenttable2=tabindextab($champstable2, $temp);	  
	// taille des champs 
		$taillechamps2=champsindextaillefromtable($table2,$connexion);		
	foreach($liste_champs_lies2 as $champs_lie){
		$champs[]=$champs_lie;
		$comment[$champs_lie]=$commenttable2[$champs_lie];
		$commentTaille[$champs_lie]=$commentTaille2[$champs_lie];
		$commentPlaceHolder[$champs_lie]=$commentPlaceHolder2[$champs_lie];	
		$commentValDefaut[$champs_lie]=$commentValDefaut2[$champs_lie];			
		$taillechamp[$champs_lie]=$taillechamps2[$champs_lie];
		}
}
if ($table3!='')
{
	//on cree un tableau $champstable3[] avec les noms des colonnes de la table  et leur taille et leur commentaires	
		  $champstable3= champsfromtable ($table3,$connexion);
		  $typetable3= champstypefromtable ($table3,$connexion);
		  $commenttable3=champscommentfromtable ($table3,$connexion);
		  $commentTaille3=champscommentfromtableplus ($table3,$connexion,0,'$',1);	
	  $commentPlaceHolder3=champscommentfromtableplus ($table3,$connexion,0,'$',2);
	  $commentValDefaut3=champscommentfromtableplus ($table3,$connexion,0,'$',3);	 	  
		  //$commenttable2=tabindextab($champstable2, $temp);	  
	// taille des champs 
		$taillechamps3=champsindextaillefromtable($table3,$connexion);
	// on ajoute ces tableaux aux tableaux $champs	
	foreach($liste_champs_lies3 as $champs_lie){
		$champs[]=$champs_lie;
		$comment[$champs_lie]=$commenttable3[$champs_lie];
		$commentTaille[$champs_lie]=$commentTaille3[$champs_lie];
		$commentPlaceHolder[$champs_lie]=$commentPlaceHolder3[$champs_lie];	
		$commentValDefaut[$champs_lie]=$commentValDefaut3[$champs_lie];		
		$taillechamp[$champs_lie]=$taillechamps3[$champs_lie];
		}
}
// on affecte la liste d'ordre des champs au tab leau avant de commencer la boucle
$ordreaffichage=$liste_ordre_champ;	
$i=0;	
foreach($champs as $unchamps){	
				 // pour la taille
			 // elle n'est pas spécifiée dans les commentaires des champs dans la  bdd ? on  prend celle spécifié dans $liste_tailles_champ sinon on prend celle de la bdd

					if (array_key_exists($unchamps,$liste_tailles_champ) )
					{	
					$commentTaille[$unchamps]=$liste_tailles_champ[$unchamps];
					}						
						elseif($commentTaille[$unchamps]!='')
						{
							// on garde cette valeur récupérée dans les commentaires de la bdd 
						}		
							// si on n'a pas de valeur fixée , on vérifie si on est en dessous de la taille limite des champs courst						
							elseif($taillechamp[$unchamps]<$tailleLimiteChampCourt)						
							$commentTaille[$unchamps]=$tailleDefautChampCourt;	
								else	// on prend la valeur de la bdd
								$commentTaille[$unchamps]=$taillechamp[$unchamps];		
				 // pour le place holder
			 // il n'est pas spécifié dans les commentaires des champs dans la  bdd ? on  prend celui spécifié dans $liste_place_holder sinon on prend celle de la bdd

					if (array_key_exists($unchamps,$liste_place_holder) )
						{	
						$commentPlaceHolder[$unchamps]=$liste_place_holder[$unchamps];
						}						
					elseif($commentPlaceHolder[$unchamps]!='')
						{
							// on garde cette valeur récupérée dans les commentaires de la bdd 
						}		
					else
						{
							//valeur par défaut du placeholder
						$commentPlaceHolder[$unchamps]='';
						}	
				 // pour la valeur par defaut 
			 // elle n'est pas spécifiée dans les commentaires des champs dans la  bdd ? on  prend celle spécifiée dans $liste_valeur_defaut sinon on prend celle de la bdd

					if (array_key_exists($unchamps,$liste_valeur_defaut) )
						{	
						$commentValDefaut[$unchamps]=$liste_valeur_defaut[$unchamps];
						}						
					elseif($commentValDefaut[$unchamps]!='')
						{
							// on garde cette valeur récupérée dans les commentaires de la bdd 
						}		
					else
						{
							//valeur par défaut de la valeur par defaut
						$commentValDefaut[$unchamps]='';
						}						
							
				 // pour le libellé
			 // il  n'est pas spécifié dans les commentaires des champs dans la  bdd ? on  prend celui spécifié dans $liste_libelles_champ sinon on prend celui de la bdd
				if (array_key_exists($unchamps,$liste_libelles_champ) )
						{	
						$comment[$unchamps]=$liste_libelles_champ[$unchamps];
						}
					elseif($comment[$unchamps]!='')
						{
							// on garde cette valeur récupérée dans les commentaires de la bdd 
						}
					else
						{
						$comment[$unchamps]=$unchamps;
						}				
				 // pour l'ordre d'affichage
			 // on regarde d'abord dans $liste_libelles_champ ensuite on prend l'ordre de la bdd
				if (!(array_key_exists($unchamps,$liste_ordre_champ) ))
					 {	
					$r=$i;				 
					while(in_array($r,$liste_ordre_champ))
					{					
						$r++;
					}
					$ordreaffichage[$unchamps]=$r;
					 }
	$i++;				
}
// on ordonne $ordreaffichage avec le nouvel ordre et on l'affecte à  $champs
asort ($ordreaffichage );
$champs=array_keys($ordreaffichage);

//debug($champs );
//debug($comment,'comment');
//debug($commentTaille,'taille');


// pour le tri initial
if (in_array($champ_tri_initial,$champs))
{
$tri_initial=$champ_tri_initial;}
else
$tri_initial=$cleprimaire;
// on vérifie que le $_GET['env_orderby'] est bien un champ de la table
// pour traiter le cas où on utilise afficheenteteplus() , on récupère champ1,champ2 , il faut vérifier chaque champ
$temp=explode(',',urldecode($_GET['env_orderby']));
	foreach($temp as $untemp)
		{
		If (!in_array($untemp,$champs)) 
			{$_GET['env_orderby']='';
			break ;
			}
		}
if ($_GET['env_orderby']=='') {$orderby=$tri_initial ;
$sens=$senstriinitial;
}
	else{
// pour traiter le cas où on utilise afficheenteteplus() , on récupère champ1,champ2 , il faut ajouter le car ` de séparation des champs
	$orderby=str_replace(',','`,`',urldecode($_GET['env_orderby']));
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
//$orderby="ORDER BY ".$orderby;
                  if  ($_GET['env_inverse']=="1"){
                  $sens="desc";
                  }
	}
//on prepare la liste sql des champs table2 et table3 à récupérer	utilisé dans les select toutes les fiches et le formulaire de modif
  $sqlChampsTable2='';
  $sqlChampsTable3='';	
 foreach($liste_champs_lies2 as $temp){
		   $sqlChampsTable2.=",".$table2.".`".$temp."`";
	   }
	   foreach($liste_champs_lies3 as $temp){
		   $sqlChampsTable3.=",".$table3.".`".$temp."`";
	   }	   
// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='') {
//test si autorisé
if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
// test valeurs obligatoires
	 $yaunvide=0;
	foreach($liste_champs_obligatoires as $champsobligatoire){
	 if (($_POST[$champsobligatoire]==''  or $_POST[$champsobligatoire]=='NC' )){
	 $yaunvide=1;
	}
	}
 if (!$yaunvide ){
	 if ($champ_modifpar!='')
	 {
		$_POST[$champ_modifpar]=$loginConnecte;
	 }
	 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$_POST['absence_log']="statut  -}1 suite à la création de l'enregistrement  effectuée par : ".$nomloginConnecte." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
$_POST['statut_absence'] = 1;
	  $message.=" L'absence  a été enregistrée dans la base avec le statut 1-Dépôt par le gestionnaire <br>";
 	$message.=" envoi du mail   informant l'étudiant <br> ";	
	 // il faudra aussi envoyer un mail
	  $messagem.="Votre abence a été saisie par ".$nomloginConnecte ."  \n";

	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "déclaration absence par ".$nomloginConnecte ;
					// On envoi l’email à l'etudiant
					$emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			if ($emailetu !=''){			   
			envoimail($emailetu ,$objet,$messagem);
			envoimailtest($emailetu ,$objet,$messagem,'',1);
			} 
 		  // si on en a ajouté un  on met en forme le commentaire
		  if($_POST['commentaire_absence_aj']!='')
		  {
	  $_POST['commentaire_absence']=" le ".date("d.m.y")  ." à ".date("H:i:s")." ".	$nomloginConnecte .' a écrit : '.  $_POST['commentaire_absence_aj'] ."\r\n";	
		  }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	 	 
	 
	 
//valeur par defaut et pb des dates mysql
$err='';
foreach($champsSingle as $ci2){
 if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 //si c'est une date//petit bidouillage sur les dates
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
  if ($_POST[$ci2]=='erreur de format de date')$err=$err.'<br> '.'erreur de format de date'; 
 }
  if (in_array($ci2,$liste_champs_heures)){
 $_POST[$ci2]=versmysql_Type_Time($_POST[$ci2]);
 if ($_POST[$ci2]=='erreur de format heure')$err=$err.'<br> '.'erreur de format heure';
 }

// pour ne pas stocker du html dans la bdd
//2019 $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');
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
   elseif(in_array($ci2,$liste_champs_invisibles_ajout)and (!in_array($ci2,$liste_champs_lecture_seule_ou_invisibles_affectes_en_ajout)))
 {
 // on ne fait rien pour récupérer si elle existe la valeur par défaut définie dans la bdd
 }
   elseif(in_array($ci2,$liste_champs_lecture_seule_ajout) and (!in_array($ci2,$liste_champs_lecture_seule_ou_invisibles_affectes_en_ajout)))
 {
 // on ne fait rien pour récupérer si elle existe la valeur par défaut définie dans la bdd
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
 $sql1pdo=substr($sql1pdo,0,strlen($sql1pdo)-1) ;
  $sql2pdo=substr($sql2pdo,0,strlen($sql2pdo)-1) ;  
   $querypdo = "INSERT INTO $table($sql1pdo)";
   $querypdo .= " VALUES($sql2pdo)";
if ($err=='')
{
		  $req = $connexion->prepare($querypdo );
		  $res=$req->execute($tableaupdo);
		   if ($res){
		$message .= "Fiche <b>"." - ";
	   $message .= "</B> ajoutée !<br>";}
	   else {
		echo affichealerte("erreur de saisie ");
	  echo "<center>La fiche n'est pas enregistrée</b> </center>";
		} 
}
else{   // fin du test erreur
    echo affichealerte("erreur :".$err." recommencez !");
	}
    }
   else{   // fin du nom=''
    echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
    }
    else{//debut du else $loginConnecte==
   echo "<center><b>seul un utilisateur autorisé peut effectuer cette opération</b><br>";
      echo "aucune modification effectuée<br></center>";

} //fin du else $loginConnecte ==
}
// ---------------------------------Suppression de la fiche
elseif($_GET['del']!='') {
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){

   $pdoquery = $connexion->prepare("DELETE FROM $table  WHERE ".$cleprimaire."= :del");
   $res=	    $pdoquery->execute(array('del' =>$_GET['del'] ));
   if($res){
   $message .= "Fiche <b>".$_GET['del'];
   $message .= "</b> supprimée <br>!";
   }
   }
      else{
   echo "<center><b>seul un utilisateur autorisé peut effectuer cette opération</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $loginConnecte == 
}
//--------------------------------- Modif de la fiche
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
elseif( $_POST['bouton_accepter'] != '' or $_POST['bouton_accepter'] != '' or  $_POST['bouton_mod']!='' or $_POST['bouton_valider_mod'] !='' or $_POST['bouton_valider2_mod'] !='' or $_POST['bouton_nepasvalider_mod'] !='' or $_POST['bouton_info_comp'] !='')
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
{
 if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif)){
 
// test valeurs obligatoires
	 $yaunvide=0;
	foreach($liste_champs_obligatoires as $champsobligatoire){
	 if (($_POST[$champsobligatoire]=='' or $_POST[$champsobligatoire]=='NC'  )){
	 $yaunvide=1;
	}
	}
 if (!$yaunvide ){
	 	 if ($champ_modifpar!='')
	 {
		$_POST[$champ_modifpar]=$loginConnecte;
	 }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	 
	if( $_POST['bouton_valider_mod']!='')
	  { 
	   // si on a appuyé sur le bouton valider on passe statut à 5
	$_POST['statut_absence']=5; 
		$_POST['absence_log'].="Etape  ".$_POST['statutsauv']  . "-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
		// message affiché :
	$message.="absence validée par DE envoi du mail à  informant l'étudiant <br> ";	
	 // il faudra aussi envoyer un mail
	  $messagem.="Votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin'] ."  a été validée par la Direction des études sous réserve d’aucune évaluation ce jour et de validation des modalités de remplacement des activités pédagogiques par les enseignants concernés.  \n".$nomloginConnecte ."  \n";

	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "validation  de l'absence par le directeur des études ".$nomloginConnecte ;
					// On envoi l’email à l'etudiant
					$emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			if ($emailetu !=''){			   
			envoimail($emailetu ,$objet,$messagem);
			envoimailtest($emailetu ,$objet,$messagem,'',1);
			}				
	  }	
	  
	if( $_POST['bouton_valider2_mod']!='')
	  { 
	   // si on a appuyé sur le bouton valider on passe statut à 5
	$_POST['statut_absence']=10; 
		$_POST['absence_log'].="Etape  ".$_POST['statutsauv']  . "-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
		// message affiché :
	$message.="absence validée sans justificatif par DE envoi du mail à  informant l'étudiant <br> ";	
	 // il faudra aussi envoyer un mail
	  $messagem.="Votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin'] ."  a été validée sans justificatif par la Direction des études sous réserve d’aucune évaluation ce jour et de validation des modalités de remplacement des activités pédagogiques par les enseignants concernés.  \n".$nomloginConnecte ."  \n";

	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "validation  de l'absence sans justificatif  par le directeur des études ".$nomloginConnecte ;
					// On envoi l’email à l'etudiant
					$emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			if ($emailetu !=''){			   
			envoimail($emailetu ,$objet,$messagem);
			envoimailtest($emailetu ,$objet,$messagem,'',1);
			}				
	  }		  
	  
	  /**
	  NADIR MISE A JOUR 
	  */ 
	  
	  	if( $_POST['bouton_accepter']=='Accepter')
	  { 
  
   
	   // si on a appuyé sur le bouton nepasvalider on passe statut à 6
	$_POST['statut_absence']=11; 
		$_POST['absence_log'].="Etape ".$_POST['statutsauv']  . "-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
		// message affiché :
	$message.="absence passée en statut :  non validée par DE envoi du mail à  informant l'étudiant <br> ";	
	 // il faudra aussi envoyer un mail
 $messagem.="Votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin'] ."  a été validée par la Direction des études. \n ".$nomloginConnecte ."  \n";

	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "non validation  de l'absence par le directeur des études ".$nomloginConnecte ;
					// On envoi l’email à l'etudiant
					$emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			if ($emailetu !=''){			   
			envoimail($emailetu ,$objet,$messagem);
			envoimailtest($emailetu ,$objet,$messagem,'',1);
			//envoimail('nadir.fouka@grenoble-inp.fr' ,$objet,$messagem);
			}					
	  }
	  
  
	if( $_POST['bouton_nepasvalider_mod']!='')
	  { 
	   // si on a appuyé sur le bouton nepasvalider on passe statut à 6
	$_POST['statut_absence']=6; 
		$_POST['absence_log'].="Etape ".$_POST['statutsauv']  . "-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
		// message affiché :
	$message.="absence passée en statut :  non validée par DE envoi du mail à  informant l'étudiant <br> ";	
	 // il faudra aussi envoyer un mail
 $messagem.="Votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin'] ."  n'a pas été validée par la Direction des études. \n ".$nomloginConnecte ."  \n";

	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "non validation  de l'absence par le directeur des études ".$nomloginConnecte ;
					// On envoi l’email à l'etudiant
					$emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			if ($emailetu !=''){			   
			envoimail($emailetu ,$objet,$messagem);
			envoimailtest($emailetu ,$objet,$messagem,'',1);
			}					
	  }	 
	  
	  	if( $_POST['bouton_info_comp']!='')
	  { 
  
  		  if($_POST['commentaire_absence_aj']!='')
		  {
		  $emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			   // si on a appuyé sur le bouton  infos comp on passe statut à 8
			$_POST['statut_absence']=8; 
				$_POST['absence_log'].="Etape ".$_POST['statutsauv']  ."-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
				// message affiché :
			$message.="absence passée en statut : 	demande infos du DE par demande d'info supplémentaire du DE <br> ";	
			 // il faut aussi envoyer le mail


		$objet=" message envoyé par le directeur des études ".$nomloginConnecte." suite à votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin']."  \n ";
			
			//test
			//$_POST['texte'] .=$headers;
			// fin test

		if ($emailetu !=''){			   
					envoimail($emailetu ,$objet,htmlspecialchars_decode($_POST['commentaire_absence_aj'],ENT_QUOTES));
					envoimailtest($emailetu ,$objet,htmlspecialchars_decode($_POST['commentaire_absence_aj'],ENT_QUOTES),'',1);				
					
		echo "<br><center>l'envoi du mail ayant pour objet : <br><b> ".$objet ."</b><br> pour <br><b>". $emailetu."</b><br>  a bien été effectué<br>";
		}
	  }else
		  echo affichealerte(" impossible d'envoyer le mail à l'étudiant , vous n'avez pas saisi de commentaire !");
					
	  }	
	  
	  
 		  // si on en a ajouté un  on met en forme le commentaire
		  if($_POST['commentaire_absence_aj']!='')
		  {
	  $_POST['commentaire_absence'].=" le ".date("d.m.y")  ." à ".date("H:i:s")." ".	$nomloginConnecte .' a écrit : '.  $_POST['commentaire_absence_aj'] ."\r\n";	
		  }	  
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 
	 
//pour les dates
$err='';
foreach($champsSingle as $ci2){
if (!isset($_POST[$ci2])) $_POST[$ci2]='';
 if (in_array($ci2,$liste_champs_dates)){
 $_POST[$ci2]=versmysql_Datetime($_POST[$ci2]);
  if ($_POST[$ci2]=='erreur de format de date')$err=$err.'<br> '.'erreur de format de date'; 
 }
  if (in_array($ci2,$liste_champs_heures)){
 $_POST[$ci2]=versmysql_Type_Time($_POST[$ci2]);
  if ($_POST[$ci2]=='erreur de format heure')$err=$err.'<br> '.'erreur de format heure';
 }
		 			// pour ne pas stocker du html dans la bdd
//2019  $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');


if ($ci2==$champ_date_modif){

  $sql1pdo.= $ci2."=now(),";
 }

  else{

   $sql1pdo.= $ci2."= :".$ci2.",";
 $tableaupdo[$ci2]=$_POST[$ci2];
 }
 }
 //attention il faut enlever la virgule de la fin

 $sql1pdo=substr($sql1pdo,0,strlen($sql1pdo)-1) ;

$querypdo= "UPDATE $table SET $sql1pdo";
$querypdo .= " WHERE ".$cleprimaire."= :".$cleprimaire." ";
if ($err=='')
{
	$req = $connexion->prepare($querypdo );
	  $res= $req->execute($tableaupdo); 
   if($res){

   $message .= "Fiche numero ".$_POST[$cleprimaire]." modifiée <br>";}
   else {$message .= "Probleme d'enregistrement de la fiche ";
    }
}
else{   // fin du test erreur
    echo affichealerte("erreur :".$err." recommencez !");
	}	
	}
	else{
	echo affichealerte("il manque des valeurs obligatoires Recommencez!");
	}
	}
	
   else{
   echo "<center><b>seul un utilisateur autorisé peut effectuer cette opération</b><br>";
      echo "aucune modification effectuée<br>";

} //fin du else $loginConnecte ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
$affichetout=0;
if($_GET['mod']!=''){
  //------------------------------------c'est kon a cliqué sur le lien details
  if($table2=='')
  {
		$query = "SELECT $table.*".$ajout_sql." FROM $table 
					  WHERE ".$cleprimaire."= :mod";		  
	}
	elseif($table3=='')
  {

	$query = "SELECT $table.*".$sqlChampsTable2.$ajout_sql."  FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` where ".$cleprimaire."= :mod";	
	}	
	else
	{

	$query = "SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  where ".$cleprimaire."= :mod";
	}
	$preparequery=$connexion->prepare($query);
   $res=$preparequery->execute(array('mod' =>$_GET['mod'] ));					 
	$u =$preparequery->fetch(PDO::FETCH_OBJ);
   //on fait une boucle pour créer les variables issues de la table principale
   foreach($champs as $ci2){
   $$ci2=$u->$ci2;
   		   //on surcharge les dates pour les pbs de format
    if (in_array($ci2,$liste_champs_dates)){
 $$ci2=mysql_DateTime($u->$ci2);
 }
    		   //on surcharge  les heures pour les pbs de format
    if (in_array($ci2,$liste_champs_heures)){
 $$ci2=mysql_Type_Time($u->$ci2);
 }
   }
   	 	 if ($champ_date_modif !='')
			 {
				$$champ_date_modif=mysql_Time($$champ_date_modif);
			 }
     echo    "<form method=post action=$URL> ";

	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
  echo"<center>";
  echo"       <table><tr>  ";
	 echo "</tr><tr>";
	 
	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	 
	 // on stocke le statut avant modification
	 echo"<input type='hidden' name='statutsauv' value=\"".$statut_absence."\">"; 
	 // on stocke l'email de l'étudiant
	 $query2="SELECT annuaire.`Mail cano.` as mailetu FROM etudiants
                  left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
				 WHERE `Code etu` = '". $code_etud ."';";
	$req2 = $connexion->query($query2 );
	$g = $req2->fetch(PDO::FETCH_OBJ) ;	
	//$temp='Mail cano.';
	//echo affichechamp('email','email_aff',$g->mailetu,'25','1');	
	echo"<input type='hidden' name='email_aff' value=\"".$g->mailetu."\">";
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
	 
	 foreach ($champs as $unchamps)
	 {
			$required='';
			$placeholder='';
			 $commentaire=$comment[$unchamps];			 
			 if(in_array($unchamps,$liste_champs_obligatoires))
			 {
				 $commentaire=$commentaire." (*) ";
				 $required=' required ';
			 } 	
			if (array_key_exists($unchamps ,$commentPlaceHolder))
			 {
				// echo $unchamps;
			$placeholder=" placeholder=\"".$commentPlaceHolder[$unchamps]."\"";		
			 }				 
			if (in_array ($unchamps ,$liste_champs_dates))
			 {
			$placeholder=" placeholder=jj/mm/aaaa ";		
			 } 	
			if (in_array ($unchamps ,$liste_champs_heures))
			 {
			$placeholder=" placeholder=hh:mm ";		
			 } 			 
		 
			$tailleAffichageChamp=$commentTaille[$unchamps];
				
	 // si on a une table liée
	  if ($unchamps == $cleetrangere2 ){
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	       //echo affichemenusqlplus($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);
			echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">\n";
			echo afficheonlysqlplus($commentaire,'onlyaffnom',$indexlien2,'select * from '.$table2 ." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	  }
	  elseif ($unchamps == $cleetrangere3 ){
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	       //echo affichemenusqlplus($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);
			echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">\n";
			echo afficheonlysqlplus($commentaire,'onlyaffnom',$indexlien3,'select * from '.$table3 ." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	  }	
	  elseif (in_array($unchamps,$liste_champs_lies2) and  in_array($unchamps,$liste_champs_lies_pour_formulaire_ajout2)){
	      // on n'affiche pas puisqu'il est dans le popup
	  }		
	  elseif (in_array($unchamps,$liste_champs_lies3) and  in_array($unchamps,$liste_champs_lies_pour_formulaire_ajout3)){
	      // on n'affiche pas puisqu'il est dans le popup
	  }		  
	  elseif (in_array($unchamps,$liste_champs_invisibles_modif)){
	      // on n'affiche pas puisqu'il est invisible mais on le met en hidden
		    echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">";
	  }
		elseif ($unchamps == $cleprimaire  or in_array($unchamps,$liste_champs_lecture_seule_modif) or in_array($unchamps,$liste_champs_lies2) or in_array($unchamps,$liste_champs_lies3)){
		 // en lecture seule
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		if($unchamps=='commentaire_absence'){
     echo "<td><label for=\"".'commentaire_absence_aj'."\">"."Ajouter un commentaire"."<br></label><textarea  row = \"4\" cols=\"70\" name='commentaire_absence_aj' id='commentaire_absence_aj'></textarea></td>";			
    echo "</tr><tr>";		
			 }
   //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if(($unchamps=='valide' or $unchamps=='absence_justif') and $statut_absence != 7 ){
// on n'affiche pas 
			}
			else
			{
   //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   			 		 
		 
		 
		  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
		 {
				echo affichechamp($commentaire,$unchamps,$$unchamps,$tailleAffichageChamp,'1');	
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea readonly row = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
		}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		

		 
			 }
		elseif (in_array ($unchamps ,$liste_champs_dates)){
							$indexchampdate=array_search($unchamps,$liste_champs_dates);
						  echo "<td>$commentaire : <input type=\"text\" value=\"".$$unchamps."\" name=\"".$unchamps."\" id=\"".$unchamps."\" size=\"12\" maxlength=\"10\" placeholder=\"jj/mm/aaaa\" ".$required." ></td>";
						  echo "<div id=\"calendarMain".$indexchampdate."1\"></div>
					<script type=\"text/javascript\">
					//<![CDATA[
					calInit(\"calendarMain".$indexchampdate."1\", \"\", \"".$unchamps."\", \"jsCalendar\",\"day\", \"selectedDay\");
					//]]>
					</script>";
					  }	
		elseif (in_array ($unchamps ,$liste_champs_heures)){
							 echo affichechamp($commentaire,$unchamps,$$unchamp,$tailleAffichageChamp,'','','','','',$required . ' ' .$placeholder . "onblur=\"return checkTime(this) \"" );
					  }
				elseif(array_key_exists ($unchamps ,$liste_champs_bool))
				 {
			 echo afficheradio($commentaire,$unchamps,$liste_champs_bool[$unchamps],$$unchamps,'','');	
					}
				elseif (in_array($unchamps,$liste_champs_select)   ){
						 // on affiche le select  correspondant
							  $temp='liste_choix_'.$unchamps;
						 if(in_array($unchamps,$liste_champs_obligatoires))
						 {
							  echo affichemenunc ($commentaire,$unchamps,$$temp,$$unchamps,'','','choisissez ci dessous');
						 }
						 else
						 {
							 echo affichemenu ($commentaire,$unchamps,$$temp,$$unchamps);						 
						 }
					  }	 
					  elseif (in_array($unchamps,$liste_champs_select_plus)   ){
						 // on affiche le select  correspondant
							  $temp='liste_choix_lib_'.$unchamps;
								$temp2='liste_choix_code_'.$unchamps;							  
						 if(in_array($unchamps,$liste_champs_obligatoires))
						 {
							  echo affichemenuplus2tabnc ($commentaire,$unchamps,$$temp,$$temp2,$$unchamps,'','','choisissez ci dessous');
						 }
						 else
						 {
							 echo affichemenuplus2tab ($commentaire,$unchamps,$$temp,$$temp2,$$unchamps);					 
						 }
					  }	
			 else{
		  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
		 {
						 echo affichechamp($commentaire,$unchamps,$$unchamps,$tailleAffichageChamp,'','','','','',$required. ' ' .$placeholder);
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea  row = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
		}
			 }
    echo "</tr><tr>";	 
	 }
   //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// il faut récupérer les docs associés à la demande et les afficher
	
	$querydoc=("SELECT * FROM absencesdocuments  where  	doc_idAbsences = :mod ");
	$preparequerydoc=$connexion->prepare($querydoc);
	$resdoc=$preparequerydoc->execute(array('mod' =>$_GET['mod'] ));
	$nombreDocs=$preparequerydoc->rowCount();
	if (!$nombreDocs)
	{
		echo "<td><h3>Il n'y a pas de document(s) joint(s)</h3></td>";	
	}
	else
	{
		echo "<td><h3>Il y a  $nombreDocs document(s) joint(s)</h3></td>";
		while (	$u =$preparequerydoc->fetch(PDO::FETCH_OBJ))
		{
	echo "<tr><td><a target='_blank' href='".$chemin_absences.$u->doc_lienDoc."'</a>".$u->doc_libelle."</a></td></tr>";
		}
	}	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	 	 
  echo "</td></tr><tr><th colspan=6>";
    //on met en hidden la cle primaire - inutile si elle est déjà affichée
  //  echo"<input type='hidden' name='$cleprimaire' value=\"".$$cleprimaire."\">   ";
   if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif))
   {
 // echo"<input type='Submit' name='bouton_mod' value='modifier'>";
 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if ($statut_absence == 3 || $statut_absence == 9 || $statut_absence == 5 || $statut_absence == 6 || $statut_absence == 10) {
  echo"<input type='Submit' name='bouton_valider_mod' value='Valider'>";
  echo"<input type='Submit' name='bouton_accepter' value='Accepter'>";
    echo"<input type='Submit' name='bouton_valider2_mod' value='Valider sans justificatif'>";
echo"<input type='Submit' name='bouton_nepasvalider_mod' value='Ne Pas Valider'>";
echo"<input type='Submit' name='bouton_info_comp' value='Envoyer par mail le commentaire ci dessus'>";

}
 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
   }
  echo "</form>";
  echo    "<form id='annulation' method=post action=$URL> ";

	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
  echo"<input type='Submit' name='bouton_annul' value='Revenir à la liste'></th></tr></table></form> "  ;
  echo "(*) champs obligatoires";
  echo"</center>";
      }
	 }

 if($_GET['add']!=''or $_POST['add']!='')  {
   $affichetout=0;
 //---------------------------------------c'est kon a cliqué sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour créer les variables issues de la table 
 

 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
				
  echo    "<form method=post action=$URL> ";

	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }

  echo"<input type='hidden' name='ajout' value=1>";
    echo"<center>";
  echo"       <table><tr>  ";
     foreach ($champs as $unchamps)
	 {
			$required='';
			$placeholder='';
			 $commentaire=$comment[$unchamps];			 
			 if(in_array($unchamps,$liste_champs_obligatoires))
			 {
				 $commentaire=$commentaire." (*) ";
				 $required=' required ';
			 } 	
			if (array_key_exists($unchamps ,$commentPlaceHolder))
			 {
				// echo $unchamps;
			$placeholder=" placeholder=\"".$commentPlaceHolder[$unchamps]."\"";		
			 } 			 
			if (in_array ($unchamps ,$liste_champs_dates))
			 {
			$placeholder=" placeholder=jj/mm/aaaa ";		
			 } 	
			if (in_array ($unchamps ,$liste_champs_heures))
			 {
			$placeholder=" placeholder=hh:mm ";		
			 } 				 
			 
			$tailleAffichageChamp=$commentTaille[$unchamps];
			 			 			 
	 // on n'affiche pas le auto inc ni date_modif ni modifpar
if ($unchamps != $autoincrement and $unchamps != $champ_date_modif and $unchamps != $champ_modifpar ){
	
			 
	 // si on a une table liée
	  if ($unchamps == $cleetrangere2 ){
		  		  $commentaire=$texte_entite2;
	       echo affichemenusqlplusnc($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$wherecleeetrangere2." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);

	  }
		  elseif ($unchamps == $cleetrangere3 ){
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// on n'affiche pas le menu statut 
	       // echo affichemenusqlplus($commentaire,$unchamps,$indexlien3,'select * from '.$table3." ".$wherecleeetrangere3." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);
	echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">\n";
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 
		  }
			   elseif (in_array($unchamps,$liste_champs_lies2)){
				  // on n'affiche pas 
			  }		
				  elseif (in_array($unchamps,$liste_champs_lies3) ){
					  // on n'affiche pas 
				  }	
					  elseif (in_array($unchamps,$liste_champs_invisibles_ajout)  or in_array($unchamps,$liste_champs_lecture_seule_ajout) ){
						  // on n'affiche pas puisqu'il est invisible ou en lecture seule
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						if($unchamps=='commentaire_absence'){
					 echo "<td><label for=\"".'commentaire_absence_aj'."\">"."Ajouter un commentaire"."<br></label><textarea  row = \"4\" cols=\"70\" name='commentaire_absence_aj' id='commentaire_absence_aj'></textarea></td>";			
					echo "</tr><tr>";		
							 }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				 
				  
					  }
						elseif (in_array ($unchamps ,$liste_champs_dates)){
							$indexchampdate=array_search($unchamps,$liste_champs_dates);
						  echo "<td>$commentaire : <input type=\"text\" value=\"\" name=\"".$unchamps."\" id=\"".$unchamps."\" size=\"12\" maxlength=\"10\" placeholder=\"jj/mm/aaaa\" ".$required." ></td>";
						  echo "<div id=\"calendarMain".$indexchampdate."1\"></div>
					<script type=\"text/javascript\">
					//<![CDATA[
					calInit(\"calendarMain".$indexchampdate."1\", \"\", \"".$unchamps."\", \"jsCalendar\",\"day\", \"selectedDay\");
					//]]>
					</script>";
					  }
 						elseif (in_array ($unchamps ,$liste_champs_heures)){
							 echo affichechamp($commentaire,$unchamps,'',$tailleAffichageChamp,'','','','','',$required . ' ' .$placeholder . "onblur=\"return checkTime(this) \"" );
					  }	
						elseif(array_key_exists ($unchamps ,$liste_champs_bool))
						{
							echo afficheradio($commentaire,$unchamps,$liste_champs_bool[$unchamps],$commentValDefaut[$unchamps],'','');	
						}
							elseif (in_array($unchamps,$liste_champs_select)   ){
							 // on affiche le select  correspondant
								  $temp='liste_choix_'.$unchamps;
							 if(in_array($unchamps,$liste_champs_obligatoires))
							 {
								  echo affichemenunc ($commentaire,$unchamps,$$temp,'','','','choisissez ci dessous');
							 }
							 else
							 {
								 echo affichemenu ($commentaire,$unchamps,$$temp,'');						 
							 }
							}	 
			 			 
					  elseif (in_array($unchamps,$liste_champs_select_plus)   ){
						 // on affiche le select  correspondant
							  $temp='liste_choix_lib_'.$unchamps;
								$temp2='liste_choix_code_'.$unchamps;							  
						 if(in_array($unchamps,$liste_champs_obligatoires))
						 {
							  echo affichemenuplus2tabnc ($commentaire,$unchamps,$$temp,$$temp2,$$unchamps,'','','choisissez ci dessous');
						 }
						 else
						 {
							 echo affichemenuplus2tab ($commentaire,$unchamps,$$temp,$$temp2,$$unchamps);					 
						 }
					  }	
					  
						 else
						 {
							  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
							 {
						 echo affichechamp($commentaire,$unchamps,$commentValDefaut[$unchamps],$tailleAffichageChamp,'','','','','',$required . ' ' .$placeholder);
							 }
							else{
						 echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea row = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$commentValDefaut[$unchamps]."</textarea></td>";			
							}	
						 }
}
    echo "</tr><tr>";	 
	 }

  
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_add' value='ajouter'></form>";
    echo    "<form id='annulation' method=post action=$URL> ";
	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }

 echo" <input type='Submit' name='bouton_annul' value='Revenir à la liste'></th></tr></table> "  ;
     echo    "</form > ";
  echo "(*) champs obligatoires";
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
echo $texteintro;
echo $message;
// --------------------------------------sélection de toutes les fiches et affichage

//on forge le where qui va bien en fonction des filtres choisis
$reqsql=$filtre_initial;


		foreach ($liste_champs_filtre as $unchamps)
		{
			$temp=$unchamps.'_rech';
			
			
			
			if (!(isset($_GET[$temp]))   )
			//+++++++++++++++++++++++++++++++++++++++++++++++				
			{
//lors du  premier accès (pas de $_GET[] dans l'url )
//----------------------------------------------				
			 if (array_key_exists($unchamps,$liste_champs_filtre_val_defaut) ) 
			 {
				$_GET[$temp]=$liste_champs_filtre_val_defaut[$unchamps];
			 }
			else
			{
				$_GET[$temp]="tous";
			}
//----------------------------------------------			
			}
			if (isset($_POST[$temp] ))
			{
				$_GET[$temp] = $_POST[$temp];
			}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
// si on a cliqué sur toutvoir ou plus tout voir on force le filtre à tous
if (isset($_GET['toutvoir'] ) ){
					$_GET[$temp]="tous";
}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++

			$$temp=$_GET[$temp];
			// on créé aussi le filtre de recherche que l'on ajoute en get lors des clics sur les entetes pour les tris

			$filtrerech .=$temp ."=".urlencode($_GET[$temp])."&";
			if($_GET[$temp]=='tous')
				// à cause des null qui ne sont pas renvoyés par like %
			{
				$reqsql.= "(".$unchamps ." like '%' or ".$unchamps." is null ) and ";
			}
			elseif($_GET[$temp]=='')
				// pas de % dans ce cas
			{
				$reqsql.= "(".$unchamps ." = '' or ".$unchamps." is null ) and ";
			}
			else
			{
					if (in_array ($unchamps ,$liste_champs_dates))
					{ 
			
					$reqsql.=$unchamps ." like '".versmysql_Datetime($_GET[$temp])."%' and ";
					}
					else
					{
					$reqsql.= $unchamps ." like '".$_GET[$temp]."%' and ";						
					}				
			}
 
		}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		// on unset $_GET['toutvoir'] car il ne doit servir qu'une fois 
		
unset($_GET['toutvoir']);
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++
		$reqsql.="1";

$where = $reqsql;
  if($table2=='')
  {
	  $req = $connexion->query("SELECT $table.*".$ajout_sql." FROM  $table ". $where ." order by `".$orderby."` " .$sens );

	  $reqfiltre= $table;
	}
	elseif($table3=='')
	{

	$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ". $where ."  order by `".$orderby."` ".$sens );
	$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ";
	}
	else
	{
	$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ". $where ." order by `".$orderby."` ".$sens );
	$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` ";
	}	

 $nombre=$req->rowCount();

if ($nombre>0){
	if (!$_GET['tout']) $textesup="à traiter"; else  $textesup="";
echo"<center> <h2 class='titrePage2'>Liste des   ";
echo $nombre;
echo " ".$texte_entite ."(s) ".$textesup." pour ". ($annee_courante-1) ."-".$annee_courante."</H2>";}
else{
echo"<center> <h2> ";
echo " 0 ".$texte_entite." actuellement dans la base pour ". ($annee_courante-1) ."-".$annee_courante."</H2>";
}

if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1&".$filtrerech." > Ajouter une absence </a><br>";
}
if ($_GET['tout'])
echo"<br><a href=".$URL."?".$filtrerech."toutvoir=0& ><h2>Ne voir que les absences à traiter :  statut 'soumis DE' ou 'réponse étudiant au DE'</h2></a>";
else
echo"<br><a href=".$URL."?".$filtrerech."toutvoir=1&><h2>Voir toutes les absences pour l'année scolaire courante</h2></a>";	
echo"<br><br><a href=".$pageaccueil.">revenir à l'accueil</a>";
echo"<BR><table border=1> ";


echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
if(sizeof($liste_champs_filtre)>0){
	echo"<br>Vous pouvez filtrer le tableau en sélectionnant une valeur dans le menu filtre </center>";
	}
        echo "<BR><BR><table border=1>";
		
		echo  "<FORM  action=".$_SERVER['PHP_SELF']." method=GET name='monform'> ";

	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
		foreach ($liste_champs_tableau as $unchamps)
		{ 		if (in_array( $unchamps,$liste_champs_filtre))
				{
				$temp=$unchamps.'_rech';
					if (in_array ($unchamps ,$liste_champs_dates))
					{ 
					echo affichemenusqlplustous('',$temp,$unchamps,"select distinct DATE_FORMAT(".$unchamps.",'%d/%m/%Y') as  '".$unchamps."' from ".$reqfiltre ." ".$where,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'");	
					//on transforme les dates sql en dd/mm/yy
					}
					 elseif(in_array ($unchamps ,$liste_champs_filtre_partiel))
					{	 
					echo affichemenusqlplustous('',$temp,$unchamps,"select distinct ". $liste_champs_filtre_partiel_traitement[$unchamps]." as $unchamps from ".$reqfiltre  ." ".$where ,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'");						
					}				
					 else
					{	 
					echo affichemenusqlplustous('',$temp,$unchamps,"select distinct ".$unchamps." from ".$reqfiltre  ." ".$where ,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'");						
					}
				}
				else
				{
					echo "<td></td>";
				}
				 
		}
		echo "<td></td>";			
		echo "</tr><tr>";
		echo "</FORM>";
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
			
	
			echo afficheentete($commentaire,$unchamps,$_GET['env_orderby'],$_GET['env_inverse'],$filtrerech,$URL);
		}
		// pour la colonne actions
				echo "<td><center>Action</center></td>";		
//on initialise  $csv_output
 $csv_output="";
 //pour l'export en totalité au cas ou
for($i=0;$i<sizeof($champs);$i++) {
			$csv_output .= nettoiecsvplus($champs[$i]);
}
$csv_output .= "\n";
//pour le changement de couleur
$sauvChamp='';
$compte=0;
$bgcolor='';

while ($u = $req->fetch(PDO::FETCH_OBJ)) {	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// il faut récupérer le nombre de docs associés à la demande
	
	$req2 = $connexion->query("SELECT * FROM absencesdocuments  where  	doc_idAbsences =".$u->id_absence." ");
	$nombreDocs=$req2->rowCount();
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

 //on fait une boucle pour créer les variables issues de la table 
   foreach($champs as $ci2){
   if (in_array ($ci2 ,$liste_champs_dates))
	 { 
	 //on transforme les dates sql en dd/mm/yy
		 $$ci2=mysql_DateTime($u->$ci2);
	 $csv_output .=  nettoiecsvplus(mysql_DateTime($u->$ci2));
	 }
  else if (in_array ($ci2 ,$liste_champs_heures))
	 { 
 	 $$ci2=$u->$ci2;
	 //on transforme les heures sql en hh:mm pour l'export		
	 $csv_output .=  nettoiecsvplus(mysql_Type_Time($u->$ci2));
	 }	 
	 
	 else{
		  $$ci2=$u->$ci2;
	   $csv_output .=  nettoiecsvplus($u->$ci2);
	  }   
   }
   $csv_output .= "\n";
		   //on surcharge les dates pour les pbs de format
		//on récupère les champs liés
		// on ecrit chaque ligne
		
		// pour faire changer la couleur de la ligne si répetition
		if ($seuil_changement_couleur>0)
			{
			if($sauvChamp==$$champrepetition  )
			{
			$compte++;	
				if($compte>=$seuil_changement_couleur)
				{
						$bgcolor=$couleur_changement;		
				}	

			}else{
				$compte=0;
				$bgcolor='';
				$sauvChamp=$$champrepetition;
				}	
			}		
						
		 echo"   <tr bgcolor='".$bgcolor."' ><td>" ;	
		foreach($liste_champs_tableau as  $colonne)
		{
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($colonne=='Nom')
			{
				echo "<a href='../fiche.php?code=".$code_etud."'>".$$colonne."</a>" ;
			}
			else
			{
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
			 echo echosur($$colonne) ;		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			  
			}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			  echo"   </td><td>" ;
	   
		}
	   
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
     echo " <A href=".$URL."?del=".$$cleprimaire."&".$filtrerech." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";
	 }
	 if (in_array($loginConnecte,$login_autorises_modif) or empty($login_autorises_modif) ){
     echo "<A href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Mod</A>";
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 	 	echo" </td><td>";	  
     echo "<A href=documentabsences.php?offre=".$$cleprimaire."&".$filtrerech."from=de >Docs(".$nombreDocs. ").</A>";	
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 }
	 elseif(in_array($loginConnecte,$login_autorises_details) or empty($login_autorises_details)){
     echo "<A href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Détails</A>";
	 }
	        echo"</td> </tr>";
	   }
	   //pdo	   
	$req->closeCursor();
	if(in_array($loginConnecte,$login_autorises_export) or empty($login_autorises_export))
		{
	   echo  "<FORM  action=../export.php method=POST name='form_export'> ";
		echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> "  ;
		echo "</form>";
		}

	   
echo"</table> ";
  
  }
 if(!$pdo)
mysql_close($connexion);
require './../footer.php';
?>
</body>
</html>
