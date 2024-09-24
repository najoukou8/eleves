<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
<style>
.table1 tr:nth-child(2n-1) {
  background-color:#f5f5f5
}
.table1 {
	width : 98% !important ;
}


.abs3:link, .abs3:visited {
  background-color: #55a8ff;
  color: black;
  border: 1px solid #55a8ff;
  padding: 5px 5px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
}

input[type="text"]{
	height : 20px ; 
	padding : 4px ; 
}

input[type="submit"]{
	padding : 4px ; 
	margin-left : 2px;
	text-transform: uppercase;
}


</style>
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
$texte_table='Absences Interface des gestionnaires';
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
//----------------------------------------------
//Attention bien laisser vide $table_sup si pas utilisé
$table_sup='etudiants_scol';
$cleetrangere_sup='code_etud';
$indexlien_sup='code';
//----------------------------------------------
//sql supplémentaire pour le select pour ajouter une table avec 
// pour la gestion des champs modifpar et date_modif
//laissez vide si pas géré
$champ_date_modif='date_modif';
$champ_modifpar='modifpar';
$liste_champs_lies_sup=array('annee');

$liste_champs_lies2=array('Nom', 'Prénom 1');
$liste_champs_lies3=array('absences_statuts_texte');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout2=array('Nom', 'Prénom 1');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout3=array('absences_statuts_texte','');
// au moins un (cléprimaire)
$liste_champs_obligatoires=array('date_debut', 'date_fin', 'duree','mot_cle','motif');
$liste_champs_lecture_seule_ajout=array('commentaire_absence','valide', 'absence_justif', 'statut_absence','absence_log');
$liste_champs_lecture_seule_modif=array('date_modif','modifpar','commentaire_absence','valide', 'absence_justif', 'statut_absence','absence_log');
//permet d'affecter lors de l'ajout une valeur aux champs en lecture seule ou invisibles (sinon c'est la valeur par defaut définie dans la bdd)
$liste_champs_lecture_seule_ou_invisibles_affectes_en_ajout=array('commentaire_absence','absence_log', 'statut_absence');
$liste_champs_invisibles_ajout=array('commentaire_absence');
$liste_champs_invisibles_modif=array('id_absence');
//----------------------------------------------
// pour les champs pour lesquels on ne fait rien en ajout et modif
$liste_champs_tableau_only=array('annee');
//----------------------------------------------
// champs qui sont ajouté dans le tableau et dans la fiche en modification , leur valeur est fixée non par la requête principale sql mais par getInfosLigneTable()
$liste_champs_tableau_sup=array('Mail effectif');
// les champs de $liste_champs_tableau_sup qui ne doivent pas  apparaitre dans le tableau  
//mais  seulement dans l'export et dans la fiche en modif ?
$liste_champs_tableau_sup_pasdanstableau=array('Mail effectif');
//paramètres pour le $getInfosLigneTable
$getinfotable['Mail effectif']='annuaire';
$getinfovariablevaleur['Mail effectif']='code_etud';
$getinfochampindex['Mail effectif']='code-etu';
$liste_champs_dates=array('date_debut', 'date_fin');
$liste_champs_heures=array();
// champs qui doivent être saisis à partir d'un select
$liste_champs_select=array('duree','mot_cle');
$liste_choix_duree=array('journée','matin','après midi','Autre (à préciser dans motif)');
$liste_choix_mot_cle=array("Cas confirmé COVID",
"Contact à risque COVID",
"Cas probable COVID",
"Forum / promotion école",
"Autre");
//pour afficher des radio buttons syntaxe array('nom_du_champ'=>$liste_de_valeurs,...)
//$liste_champs_bool=array('com_selection'=>$listeouinon);
$liste_champs_bool=array();
$liste_champs_tableau=array('Nom', 'Prénom 1','annee', 'code_etud', 'date_debut', 'date_fin','mot_cle', 'motif', 'date_modif','absences_statuts_texte');
$liste_champs_filtre=array('Nom', 'annee','code_etud','absences_statuts_texte','mot_cle');
// pour les filtres si il faut aller plus loin que select distinct
$liste_champs_filtre_partiel=array('annee');
$liste_champs_filtre_partiel_traitement=array('annee'=>'left(ltrim(annee),6)');

//----------------------------------------------
$liste_champs_filtre_val_defaut=array();
//----------------------------------------------
// nom des en tetes du tableau à substituer si commentaire de mysql vides
//dans l'ordre on regarde le tableau $liste_libelles_tableau, puis le commentaire sql sinon on prend le nom du champs
$liste_libelles_tableau=array('mot_cle'=>'mot clé','Prénom 1'=>'Prénom','annee'=>'Filière','Mail effectif'=>'Mail');
// nom des champs à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ sinon on prend le nom du champs
$liste_libelles_champ=array();
// taille des champs d'affichage à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ
$liste_tailles_champ=array('motif'=>89);
$liste_place_holder=array('duree'=>"matin, après midi, journée ...");
//pour les valeurs par defaut en ajout 
$liste_valeur_defaut=array();
//pour  l'ordre d'affichage
$liste_ordre_champ=array();
//le tri du premier affichage du tableau (avant de cliquer sur les entêtes) si vide c'est la cle primaire
$champ_tri_initial='date_modif';
// sens du tri initial asc ou desc
$senstriinitial='desc';
// where initial si pas de filtre initial  : $filtre_initial="where ";
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

/* if (!isset($_POST['toutrech'])) $_POST['toutrech']='';
if (!isset($_GET['tout'])) $_GET['tout']='';
if (!isset($_GET['toutrech'])) $_GET['toutrech']=''; */

// il faut récupérer la valeur de clone  qui pourrait être passée par un formulaire en hidden
//if (($_POST['toutrech'] !='' ))$_GET['tout']=$_POST['toutrech'];
//$filtrerech="toutrech=".$_GET['tout']."&";


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
$login_autorises=array_merge($scol_user_liste,array('lemairpi'));
//pour pouvoir usurper une identité vide si on ne veut pas de cette fonctionnalité
//attention danger normalement seulement administrateur
// incompatible avec $login_autorises vide
$login_autorises_clone=array('administrateur', 'jouffral','foukan');
// pour pouvoir  ajouter
$login_autorises_ajout=$scol_user_liste;
// pour pouvoir  supprimer
$login_autorises_suppression=$scol_user_liste;
// pour pouvoir  modifier
$login_autorises_modif=$scol_user_liste;
// pour pouvoir  accéder à détails : formulaire de modification sans validation et au lien sur les docs
$login_autorises_details=array_merge($scol_user_liste,array('lemairpi'));
// pour pouvoir  exporter
$login_autorises_export=$scol_user_liste;
// email correspondant au login  administrateur
$emailadmin='nadir.fouka@grenoble-inp.fr';
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
// on utilise enteteplus ?
$enteteplus=0;
// champs qui doivent être saisis à partir d'un select avec valeur retournée distincte de valeur affichée
$liste_champs_select_plus=array();
$liste_choix_lib_statut_absence=array('en attente', 'dépôt gestionnaire', 'justifiée' ,'soumis DE','complétée par étudiant','validée par DE', 'non validée par DE','terminée');
$liste_choix_code_statut_absence=array(0,1,2,3,4,5,6,7);
$liste_param_get=array('clone','from','tout');
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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

if ($_GET['tout'])
$filtre_initial="where statut_absence !=7  and ";
else
$filtre_initial="where date_debut > '".strval(intval($annee_courante)-1)."-08-31' and statut_absence !=2 and statut_absence !=5 and statut_absence !=3 and statut_absence !=6 and statut_absence !=7  and statut_absence !=8 and  statut_absence !=9 and statut_absence !=10 and ";

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

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
require('../header.php');
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

//require('../header.php');


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
// if (!isset($_POST['clone'])) $_POST['clone']='';
// if (!isset($_GET['clone'])) $_GET['clone']='';
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if (!isset($_POST['bouton_justifie_mod'])) $_POST['bouton_justifie_mod']='';
if (!isset($_POST['bouton_soumettrede_mod'])) $_POST['bouton_soumettrede_mod']='';
if (!isset($_POST['bouton_env'])) $_POST['bouton_env']='';
if (!isset($_POST['bouton_info_comp'])) $_POST['bouton_info_comp']='';

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$URL =$_SERVER['PHP_SELF'];
// pour tester comme un autre
// il faut récupérer la valeur de clone  qui pourrait être passée par un formulaire en hidden
// pour la déconnexion
 
//if (($_GET['clone'] !='' ))$_POST['clone']=$_GET['clone'];
// pour garder clone apres un form non lancé par un lien 
//if (($_POST['clone'] !='' ))$_GET['clone']=$_POST['clone'];

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
	// else
	// $filtrerech='';

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
//+++++++++++++++++++++++++++++++++++++++++++++++
// pour les champs ajoutés avec un 3eme left join juste pour le tableau
	foreach($liste_champs_tableau_only as $champs_tableau_only){
		$champs[]=$champs_tableau_only;
		$comment[$champs_tableau_only]='';
		$commentTaille[$champs_tableau_only]='';
		$commentPlaceHolder[$champs_tableau_only]='';	
		$commentValDefaut[$champs_tableau_only]='';		
		$taillechamp[$champs_tableau_only]='';
	}
//++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++
// pour les champs ajoutés avec la fonctions getInfosLigneTable()
	foreach($liste_champs_tableau_sup as $champs_tableau_sup){
		$champs[]=$champs_tableau_sup;
		$comment[$champs_tableau_sup]='';
		$commentTaille[$champs_tableau_sup]='';
		$commentPlaceHolder[$champs_tableau_sup]='';	
		$commentValDefaut[$champs_tableau_sup]='';		
		$taillechamp[$champs_tableau_sup]='';
	}
//++++++++++++++++++++++++++++++++++++++++++
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
  $sqlChampsTable_sup='';
 foreach($liste_champs_lies2 as $temp){
		   $sqlChampsTable2.=",".$table2.".`".$temp."`";
	   }
	   foreach($liste_champs_lies3 as $temp){
		   $sqlChampsTable3.=",".$table3.".`".$temp."`";
	   }	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	   
	   foreach($liste_champs_lies_sup as $temp){
		   $sqlChampsTable_sup.=",".$table_sup.".`".$temp."`";
	   }	   
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
/*  if ($_POST['bouton_env']=='envoyer'){
	//test
	//$_POST['liste_dest']='nadir.fouka@grenoble-inp.fr';
	// fin test
$_POST['texte']=htmlspecialchars_decode($_POST['texte']);
$_POST['objet_mail']=htmlspecialchars_decode($_POST['objet_mail']);
// on met aussi l'expediteur en liste destinataire
$_POST['liste_dest'].=",".$_POST['exp_mail'].",";
// on met aussi les CC en liste destinataire
//$_POST['liste_dest'].=$_POST['copie_conforme'].",";
//$_POST['liste_dest'].="nadir.fouka@grenoble-inp.fr,";
$_POST['texte']=" Ci dessous un message envoyé par ".$_POST['exp_mail']." à partir du module absences de la base élèves de GI\n ".$_POST['texte'];
	
	//test
	//$_POST['texte'] .=$headers;
	// fin test
envoimail($_POST['liste_dest'],$_POST['objet_mail'],$_POST['texte']);
envoimailtest($_POST['liste_dest'],$_POST['objet_mail'],$_POST['texte'],'',1);
echo "<br><center>l'envoi du mail ayant pour objet : <br><b> ".$_POST['objet_mail'] ."</b><br> pour  <br><b>".$_POST['liste_dest']."</b><br>  a bien été effectué<br>";


echo "<br><a href=".$URL."><b>CONTINUER</b> </a></center></h2>";
}  */
  
  	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 
	   
// ----------------------------------Ajout de la fiche
if($_POST['ajout']!='' and $_POST['bouton_add']!='' and (!isset($_POST['bouton_annul_conflit']))) {
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
	 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	 
	 // d'abord il faut vérifier si il n'y a pas déjà une absence à cette date pour cette étudiant 
	 	$pdoquery2 = $connexion->prepare("select *  FROM $table  WHERE code_etud= :code_etud and date_debut= :date_debut and date_fin= :date_fin ");
		   $res2=$pdoquery2->execute(array('code_etud' =>$_POST['code_etud'] ,
		   'date_debut'=> versmysql_Datetime($_POST['date_debut']),
		   'date_fin'=> versmysql_Datetime($_POST['date_fin']))
		   );
		   $compteabs=$pdoquery2->rowCount();
		   // si pas de conflit ou qu'on a déjà confirmé la création
		   if(!$compteabs or isset($_POST['bouton_confirm_conflit']))
		   {
	 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	 
	 
	 if ($champ_modifpar!='')
	 {
		$_POST[$champ_modifpar]=$loginConnecte;
	 }
	 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$_POST['absence_log']="statut  -}1 suite à la création de l'enregistrement  effectuée par : ".$nomloginConnecte." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
$_POST['statut_absence'] = 1;
	  $message.="<span class='notification-abs'> L'absence  a été enregistrée dans la base avec le statut 1-A justifier , envoi du mail   informant l'étudiant </span> <br/><br>";
 	  //$message.=" envoi du mail   informant l'étudiant </span> <br> ";
	 // il faudra aussi envoyer un mail
	  $messagem.="Une absence a été déclarée par ".$nomloginConnecte." vous concernant.\n Merci de bien vouloir rapidement l'expliquer sinon elle sera considérée comme injustifiée "."  \n";

	 $messagem .= " \nCordialement\n\n";	
	$messagem.= " accès gestion absences : ".$url_eleve."absences/index.php \n";
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
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 
		
	 	 
	 
	 
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
//2019  $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');
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

		//$message .= "Fiche <b>"." - ";
	    //$message .= "</B> ajoutée2 !<br>";
           }

	   else {
		echo affichealerte("erreur de saisie ");
	  echo "<center>La fiche n'est pas enregistrée</b> </center>";
		} 
}
else{   // fin du test erreur
    echo affichealerte("erreur :".$err." recommencez !");
	}
    }	
   else{   // fin du nombre=0
    echo affichealerte("il y a déjà une absence pour cet étudiant avec même date de début et même date de fin : Que souhaitez vous ?");
	 echo    "<form id='confirmation' method=post action=$URL> ";
	 	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
	   //on passe tous les arg reçus en post  en hidden 
	  foreach($_POST as $ci2)
	  {
		  	$x=key($_POST);
		  //if($x!='add' and $x!='mod')
		  //{
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  //}
			next($_POST);
	  }	   
	echo "<center>";
echo "<br>";	
echo"<input type='Submit' name='bouton_confirm_conflit' value=\"Je confirme la création de l'absence\">"  ;
echo"<input type='Submit' name='bouton_annul_conflit' value=\"J'annule la création de l'absence\" >"  ;
	echo "</center>";   
	 echo    "</form> ";
	}
	}
   else{   // fin du nom=''
    echo affichealerte("il manque des valeurs obligatoires Vérifiez!");
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
	
	// on vérifie le statut et les docs associés
	
	$pdoquery1 = $connexion->prepare("select *  FROM $table  WHERE ".$cleprimaire."= :del");
   $res1=$pdoquery1->execute(array('del' =>$_GET['del'] ));

   	while ($u =$pdoquery1->fetch(PDO::FETCH_OBJ))
	{
			//if ($u->statut_absence != 0 and $u->statut_absence != 1 )
				//on ne vérifie plus le statut
				if (0 )
			{
				echo affichealerte ('statut différent de 0 ou 1 on ne peut pas effacer ');
			}
		
		else{		
			// on vérifie d'abord les docs associés 
			$pdoquery2 = $connexion->prepare("select *  FROM absencesdocuments  WHERE doc_idAbsences= :del");
		   $res2=$pdoquery2->execute(array('del' =>$_GET['del'] ));
		   $comptedocs=$pdoquery2->rowCount();
		   if ($comptedocs)
		   {
			echo affichealerte(" il y a $comptedocs documents associé à cette absence  , on le(s) supprime aussi ")  ;
		   }
			while ($v =$pdoquery2->fetch(PDO::FETCH_OBJ))
			{
				// on s'occupe d'abord du fichier téléchargé
					$nomdoc=$chemin_local_absences.$v->doc_lienDoc;
			
					  if (file_exists($nomdoc))
					  {
						   unlink($nomdoc);
						   echo "<center>fichier  ".$nomdoc." supprimé</center>";
					  }
					  else
						echo "<br>fichier  ".$nomdoc." introuvable<br>"; 
			// ensuite on efface la fiche document
			$pdoquery3 = $connexion->prepare("DELETE FROM absencesdocuments  WHERE doc_idDoc= :del");
			   $res3=	    $pdoquery3->execute(array('del' =>$v->doc_idDoc ));
			   if($res3){
			   $message .= "Fiche absencesdocument <b>".$v->doc_idDoc;
			   $message .= "</b> supprimée <br>!";
			   }
			
			}
			// enfin on efface la fiche d'absence
			
			   $pdoquery = $connexion->prepare("DELETE FROM $table  WHERE ".$cleprimaire."= :del");
			   $res=	    $pdoquery->execute(array('del' =>$_GET['del'] ));
			   if($res){
			   $message .= "Fiche absence  <b>".$_GET['del'];
			   $message .= "</b> supprimée <br>!";
			   }
		}
   }

}
      else{
   echo "<center><b>seul un utilisateur autorisé peut effectuer cette opération</b><br>";
      echo "aucune modification effectuée<br></center>";
}//fin du else $loginConnecte == 
}
//--------------------------------- Modif de la fiche
elseif($_POST['bouton_mod']!='' or $_POST['bouton_justifie_mod'] !='' or $_POST['bouton_soumettrede_mod'] !='' or $_POST['bouton_info_comp'] !='')
{
 if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif)){
 $nom_etud =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Nom usuel'];
$prenom_etud =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Prénom'];
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
	if( $_POST['bouton_justifie_mod']!='')
	  { 
	   // si on a appuyé sur le bouton justifier on passe statut à 2
	$_POST['statut_absence']=2; 
		$_POST['absence_log'].="Etape ".$_POST['statutsauv']  ."-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
		// message affiché :
	$message.="absence justifiée envoi du mail informant l'étudiant <br> ";	
	 // il faudra aussi envoyer un mail
	  $messagem.="Votre absence a été justifiée par ".$nomloginConnecte ."  \n";
  		  if($_POST['commentaire_absence_aj']!='')
		  {
	  $messagem.="Voici son commentaire :\n  ".$_POST['commentaire_absence_aj'] ."  \n";
		  }			  
	$messagem.= " accès direct : ".$url_eleve."absences/index.php?mod=".$_POST['id_absence']." \n";
	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "justification de votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin'] ." par ".$nomloginConnecte ;
					// On envoi l’email à l'etudiant
					$emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			if ($emailetu !=''){			   
			envoimail($emailetu ,$objet,$messagem);
			envoimailtest($emailetu ,$objet,$messagem,'',1);			
			}				
	  }	
  
	if( $_POST['bouton_soumettrede_mod']!='')
	  { 
	   // si on a appuyé sur le bouton justifier on passe statut à 3
	$_POST['statut_absence']=3; 
		$_POST['absence_log'].="Etape ".$_POST['statutsauv']  ."-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	

		// message affiché :
	$message.="absence passée en statut : soumise au DE  <br> ";	
	 // il faudra aussi envoyer un mail
				  $messagem.="L' absence de ".$prenom_etud." ".$nom_etud ." a été soumise au directeur des études par ".$nomloginConnecte ."  \n";
				  
				  
				   $messagem.= " accès direct : ".$url_personnel."absences/absences_de.php?mod=".$_POST['id_absence']." \n";

	 $messagem .= " \nCordialement\n\n";	

				  // On prepare l'email : on initialise les variables
			$objet = "Une absence vient d'être soumise au DE  par ".$nomloginConnecte ;
					// On envoi l’email au DE

			if ($demail !=''){			   
			envoimail($demail ,$objet,$messagem);
			envoimailtest($demail ,$objet,$messagem,'',1);			
			}						
	  }	 
	if( $_POST['bouton_info_comp']!='')
	  { 
  
  		  if($_POST['commentaire_absence_aj']!='')
		  {
		  $emailetu =  getInfosLigneTable ('annuaire',$connexion,$_POST['code_etud'],'code-etu')['Mail effectif'];
			   // si on a appuyé sur le bouton  infos comp on passe statut à 1
			$_POST['statut_absence']=1; 
				$_POST['absence_log'].="Etape ".$_POST['statutsauv']  ."-}".$_POST['statut_absence'] ." par  ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";	
				// message affiché :
			$message.="absence passée en statut : injustifiée par demande d'info supplémentaire de la gestionnaire  <br> ";	
			 // il faut aussi envoyer le mail


		$objet=" message envoyé par ".$nomloginConnecte." suite à votre absence du ". $_POST['date_debut']." au ".$_POST['date_fin']."  \n ";
		$messagem = "Votre absence fait l'objet de ce commentaire  :\n".htmlspecialchars_decode($_POST['commentaire_absence_aj'],ENT_QUOTES);
			$messagem.= "\n\n accès direct : ".$url_eleve."absences/index.php?mod=".$_POST['id_absence']." \n";
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
		  
		  // si on a modifié la date de fin on l'indique dans le log
		  if($_POST['date_finsauv']!=$_POST['date_fin'])
		  {
			  $_POST['absence_log'].="Date de fin changée de ".$_POST['date_finsauv']." en ". $_POST['date_fin'] ."\r\n"." par ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
		  }
		  		  // si on a modifié la date de debut on l'indique dans le log
		  if($_POST['date_debutsauv']!=$_POST['date_debut'])
		  {
			  $_POST['absence_log'].="Date de début changée de ".$_POST['date_debutsauv']." en ". $_POST['date_debut'] ."\r\n"." par ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
		  }
		  // si on a modifié le motif  on l'indique dans le log
		  if($_POST['motifsauv']!=$_POST['motif'])
		  {
			  $_POST['absence_log'].="Motif changé de ".$_POST['motifsauv']."\r\n"." en ". $_POST['motif'] ."\r\n"." par ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
		  }	
		  // si on a modifié le mot clé  on l'indique dans le log
		  if($_POST['mot_clesauv']!=$_POST['mot_cle'])
		  {
			  $_POST['absence_log'].="Mot clef changé de ".$_POST['mot_clesauv']."\r\n"." en ". $_POST['mot_cle'] ."\r\n"." par ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";
		  	 // il faudra aussi envoyer un mail au resp admin
				  $messagem.= $nomloginConnecte ." vient de modifier le mot clé de l'absence de ".$prenom_etud." ".$nom_etud ."  \n";
				  $messagem.=  "Mot clef changé de ".$_POST['mot_clesauv']."\r\n"." en ". $_POST['mot_cle'] ."\r\n"." par ".$nomloginConnecte ." le ".date("d.m.y")  ." à ".date("H:i:s")  ."\r\n";

				  
				   $messagem.= " accès direct : ".$url_personnel."absences/absences_de.php?mod=".$_POST['id_absence']." \n";
	

				  // On prepare l'email : on initialise les variables
			$objet = "[ABSENCE COVID] modification mot clé de ".$nomloginConnecte ." au sujet de son absence";
					// On envoi l’email au ra

			if ($ramail !=''){			   
			envoimail($ramail ,$objet,$messagem);
			envoimailtest($ramail ,$objet,$messagem,'',1);			
			}		  
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
 //2019 $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');


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
	    if(	  $ci2!='annee')
 {
	   	   if(!in_array($ci2,$liste_champs_tableau_sup) )
	   {
   $$ci2=$u->$ci2;
	   }
	   else
	   {
	$$ci2=getInfosLigneTable($getinfotable[$ci2],$connexion,$u->{$getinfovariablevaleur[$ci2]},$getinfochampindex[$ci2])[$ci2];
	   }
 }
	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	
/*  if(	  $ci2!='annee')
 {
   $$ci2=$u->$ci2;
 }
    */	  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 	
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
	 // on stocke les infos avant modification
	 echo"<input type='hidden' name='statutsauv' value=\"".$statut_absence."\">"; 
	 echo"<input type='hidden' name='date_finsauv' value=\"".$date_fin."\">"; 
	echo"<input type='hidden' name='date_debutsauv' value=\"".$date_debut."\">"; 
	 echo"<input type='hidden' name='mot_clesauv' value=\"".$mot_cle."\">"; 
	echo"<input type='hidden' name='motifsauv' value=\"".$motif."\">"; 
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
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	      if (in_array($unchamps,$liste_champs_tableau_only))
		  {
			  // on ne fait rien
		  }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
	 // si on a une table liée
	 else if ($unchamps == $cleetrangere2 ){
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
     echo "<td><label for=\"".'commentaire_absence_aj'."\">"."Ajouter un commentaire"."<br></label><textarea  row = \"10\" cols=\"90\" name='commentaire_absence_aj' id='commentaire_absence_aj'></textarea></td>";			
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
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea readonly row = \"10\" cols=\"90\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
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
   //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
			if($unchamps=='valide' and $statut_absence != 7){
// on n'affiche pas 
			}
			else
			{
   //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++   
		  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
		 {
			echo affichechamp($commentaire,$unchamps,$$unchamps,$tailleAffichageChamp,'','','','','',$required. ' ' .$placeholder);
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea  row = \"10\" cols=\"90\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
		}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
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
 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	   
 // echo"<input type='Submit' name='bouton_mod' value='modifier'>";

if ($statut_absence == 0 or $statut_absence == 4 ){
  echo"<input type='Submit' name='bouton_justifie_mod' value='Justifier'>";
echo"<input type='Submit' name='bouton_soumettrede_mod' value='Soumettre DE'>";
echo"<input type='Submit' name='bouton_info_comp' value='Envoyer par mail le commentaire ci dessus'>";
 echo"<input type='Submit' name='bouton_mod' value='modifier'>";
}

if ($statut_absence == 3 or $statut_absence == 2 ){
 echo"<input type='Submit' name='bouton_mod' value='modifier'>";
}
if ($statut_absence == 1 ){
echo"<input type='Submit' name='bouton_soumettrede_mod' value='Soumettre DE'>";
  echo"<input type='Submit' name='bouton_justifie_mod' value='Justifier'>";
   echo"<input type='Submit' name='bouton_mod' value='modifier'>";
}
if ($code_etud!='')
{
					// On récupère l’email de l'etudiant
//$emailetu =  getInfosLigneTable ('annuaire',$connexion,$code_etud,'code-etu')['Mail effectif'];
			// if ($emailetu !=''){			   
 // echo "<a href=mailto:".$emailetu ."> Envoyer un mail à ".$emailetu ."</a>";
			// } 
		
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
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
/*  $emailetu =  getInfosLigneTable ('annuaire',$connexion,$code_etud,'code-etu')['Mail effectif'];
 if ($emailetu !=''){	
   echo    "<form method=POST name=envoi_mail action=".$URL."   onsubmit=\"return  confirm('Confirmez l\'envoi à ".$emailetu." ?')\"> ";

	 	  	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
  echo"       <table align=center><tr> ";

  //pour apres la sortie du formulaire retrouver la selection en cours
   echo afficheonly("","Pour envoyer un message à ".$emailetu."  ",'b' ,'h3');
 echo "</tr><tr>";
  // echo $filtre;
  $email_exp= ask_ldap($loginConnecte,'mail');
    $email_exp=  $email_exp[0];
//echo $reponse[0]."<br>";
//on met en hidden le mail de l'expediteur
echo affichechamp('Expéditeur','exp_mail', $email_exp,50,1);
 echo "</tr><tr>";
echo affichechamp('Objet','objet_mail', '',60,'','','','','','placeholder = \'objet du message\' ');
// echo "</tr><tr>";
//echo affichechamp('Cc','copie_conforme', '',60,'','','','','', 'placeholder = \'vous pouvez mettre plusieurs adresses en Cc , les séparer par des virgules \' ');
 echo "</tr><tr>";
	echo "<td colspan=2>Texte du message<br><textarea name='texte' rows=8 cols=80 placeholder= 'Saisissez votre message ici'></textarea></td> ";	

	// on met en hidden la liste des destinataires
  echo "<input type='hidden' name='liste_dest' value=\"".htmlspecialchars($emailetu, ENT_QUOTES, 'ISO8859-1')."\" >";

			echo "</tr><tr>";
  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_env' value='envoyer'></form>";
  //echo "<input type='Submit' name='bouton_annul' value='Revenir à la liste'>";
  echo"</th></tr></table> "  ;
 } */
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
			 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	      if (in_array($unchamps,$liste_champs_tableau_only))
		  {
			  // on ne fait rien
		  }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
	 // si on a une table liée
	 else if ($unchamps == $cleetrangere2 ){
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
				   
				  	  elseif (in_array($unchamps,$liste_champs_tableau_sup) ) {
				// on n'affiche pas 
					}
					  elseif (in_array($unchamps,$liste_champs_invisibles_ajout)  or in_array($unchamps,$liste_champs_lecture_seule_ajout) ){
						  // on n'affiche pas puisqu'il est invisible ou en lecture seule
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
						if($unchamps=='commentaire_absence'){
					 echo "<td><label for=\"".'commentaire_absence_aj'."\">"."Ajouter un commentaire"."<br></label><textarea  row = \"10\" cols=\"90\" name='commentaire_absence_aj' id='commentaire_absence_aj'></textarea></td>";			
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
						 echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea row = \"10\" cols=\"90\" name=$unchamps id=$unchamps $required>".$commentValDefaut[$unchamps]."</textarea></td>";			
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
			if (!(isset($_GET[$temp])))
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
		$reqsql.="1";

$where = $reqsql;
//echo $where;
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
	elseif($table_sup=='')
	{
		
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ". $where ." order by `".$orderby."` ".$sens );
$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ";
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	}
	else
	{
		
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// pour récupérer  les champs de la table_sup
//	$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ". $where ." order by `".$orderby."` ".$sens );
$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$sqlChampsTable_sup.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup` ". $where ." order by `".$orderby."` ".$sens );
$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup`";
//echo "SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$sqlChampsTable_sup.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup` ". $where ." order by `".$orderby."` ".$sens ;

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	}	

 //echo $req ; 
 $nombre=$req->rowCount();

if ($nombre>0){
echo"<center> <h1 class='titrePage2'>Liste des   ";
echo $nombre;
//++++++++++++++++++++++++++++++++++++++++++++++++++
echo " ".$texte_entite ."(s)";
if(!$_GET['tout']){
echo "pour ". ($annee_courante-1) ."-".$annee_courante;
}
//++++++++++++++++++++++++++++++++++++++++++++++++++
echo "</H2>";
}
else{
echo"<center> <h2> ";
echo " 0 ".$texte_entite." actuellement dans la base pour ". ($annee_courante-1) ."-".$annee_courante."</H2>";
}

if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1&".$filtrerech." > Ajouter une absence </a><br>";
}
if ($_GET['tout'])
echo"<br><a href=".$URL."?".$filtrerech."tout=0& >Ne voir que les absences à traiter</a>";
else
echo"<a href=".$URL."?".$filtrerech."tout=1&>Voir toutes les absences</a>";

echo"<BR><table border=1> ";


echo"<br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
if(sizeof($liste_champs_filtre)>0){
	echo"<br>Vous pouvez filtrer le tableau en sélectionnant une valeur dans le menu filtre </center>";
	}
        echo "<BR><table class='table1'>";
		
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
			
	
			if($enteteplus)
			echo afficheenteteplus($commentaire,$unchamps,$_GET['env_orderby'],$_GET['env_inverse'],$filtrerech,$URL);
			else
			echo afficheentete($commentaire,$unchamps,$_GET['env_orderby'],$_GET['env_inverse'],$filtrerech,$URL);

		}
				// pour les champs tableau sup on affiche pas les entetes cliquables (pas de possibilité
		//de changer l'ordre dans la requête sql
				foreach ($liste_champs_tableau_sup as $unchamps)
		{ 
					 if (!array_key_exists($unchamps,$liste_libelles_tableau) ) 			 				
				{	
				$commentaire=$unchamps;
				}
			 else
			 {
			 $commentaire=$liste_libelles_tableau[$unchamps];
			 }
			if (!in_array($unchamps,$liste_champs_tableau_sup_pasdanstableau))
			{
			echo "<th>$commentaire</th>";
			}
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
  elseif (in_array ($ci2 ,$liste_champs_heures))
	 { 
 	 $$ci2=$u->$ci2;
	 //on transforme les heures sql en hh:mm pour l'export		
	 $csv_output .=  nettoiecsvplus(mysql_Type_Time($u->$ci2));
	 }	 
	elseif(!in_array($ci2,$liste_champs_tableau_sup))
	 {
		  $$ci2=$u->$ci2;
	   $csv_output .=  nettoiecsvplus($$ci2);
	  }	 
	else
	{
	$$ci2=getInfosLigneTable($getinfotable[$ci2],$connexion,$u->{$getinfovariablevaleur[$ci2]},$getinfochampindex[$ci2])[$ci2];
	$csv_output .=  nettoiecsvplus($$ci2);
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
				echo "<a class='abs' href='../fiche.php?code=".$code_etud."'>".$$colonne."</a>" ;
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
	 foreach($liste_champs_tableau_sup as  $colonne)
		{
				 if (!in_array($colonne,$liste_champs_tableau_sup_pasdanstableau))
				 {
				 echo echosur($$colonne) ;
				  echo"   </td><td>" ;	
				 }			  
       }	     
if((in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression))  ){
     echo " <A style='width:50px;' class='abs2' href=".$URL."?del=".$$cleprimaire."&".$filtrerech." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A>";
	 }
	 if (in_array($loginConnecte,$login_autorises_modif) or empty($login_autorises_modif) ){
     echo "<A style='width:50px;margin-top:2px' class='abs3' href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Mod</A>";
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 	 	echo" </td><td>";	  
     echo "<A class='abs' href=documentabsences.php?offre=".$$cleprimaire."&".$filtrerech."from=gest >Docs(".$nombreDocs. ").</A>";	
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 }
	 elseif(in_array($loginConnecte,$login_autorises_details) or empty($login_autorises_details)){
     echo "<A class='abs' href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Détails</A>";
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 	 	echo" </td><td>";	  
     echo "<A class='abs' href=documentabsences.php?offre=".$$cleprimaire."&".$filtrerech."from=gest >Docs(".$nombreDocs. ").</A>";	
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 }
	        echo"</td> </tr>";
	   }
	   //pdo	   
	$req->closeCursor();
	if(in_array($loginConnecte,$login_autorises_export) or empty($login_autorises_export))
		{
	   echo  "<FORM  action=../export.php method=POST name='form_export'> ";
		echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  class='bouton_ok' value='Export vers EXCEL'> <br> "  ;
		echo "</form><hr/>";
		}

	   
echo"</table> ";
  
  }
 
  
  
  
 if(!$pdo)
mysql_close($connexion);
require('../footer.php');
?>

</body>
</html>
