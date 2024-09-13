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

require ("../paramcommun.php");
//---paramètres à configurer
// texte affiché en haut du tableau
$texteintro= "<h2>gestion des comptes GI </h2>";
//accès à la BDD on peut aussi les mettre dans un fichier de param séparé (param .php)
$dsn="gi_users";
$user_sql="apache";
$password='Bmanpj1';
$host="localhost";
//connexion pdo (pdo=1) ou oldfashion (pdo=0)
$pdo=1;
// CAS activé nécessite la présence de cas.php  et du rep CAS dans le rep
$casOn=0;
$texte_table='comptes GI';
// pour afficher dans l'interface le nom des entités de chaque table
$texte_entite='compte';
$texte_entite2='';
$texte_entite3='';
$table="people";
$cleprimaire='user_id';
$autoincrement='user_id';
$cleetrangere2='';
// pour l'ordre d'affichage dans le  select en saisie / modification - peut être vide
$ordrecleeetrangere2='';
// restriction dans le  select en saisie / modification - peut être vide
$wherecleeetrangere2="";
$table2="";
$indexlien2='';
$cleetrangere3='';
$ordrecleeetrangere3='';
// restriction dans le  select en saisie / modification - peut être vide
$wherecleeetrangere3="";
$table3="";
$indexlien3='';
//----------------------------------------------
//Attention bien laisser vide $table_sup si pas utilisé
$table_sup='';
$cleetrangere_sup='code_etud';
$indexlien_sup='code';
//---------------------------------------------
// pour la gestion des champs modifpar et date_modif
//laissez vide si pas géré
$champ_date_modif='';
$champ_modifpar='';
$liste_champs_lies_sup=array();
$liste_champs_lies2=array();
$liste_champs_lies3=array();
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout2=array();
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout3=array();
// au moins un (cléprimaire)
$liste_champs_obligatoires=array('user_nom','user_prenom','user_date_limite');
$liste_champs_lecture_seule_ajout=array();
$liste_champs_lecture_seule_modif=array('user_login','user_password_hash');
//permet d'affecter lors de l'ajout une valeur aux champs en lecture seule ou invisibles (sinon c'est la valeur par defaut définie dans la bdd)
$liste_champs_lecture_seule_ou_invisibles_affectes_en_ajout=array('user_password_hash','user_login','user_password');
$liste_champs_invisibles_ajout=array('user_login','user_password_hash','user_password');
$liste_champs_invisibles_modif=array('user_id');
//----------------------------------------------
// pour les champs pour lesquels on ne fait rien en ajout et modif
$liste_champs_tableau_only=array();

// champs qui sont ajouté dans le tableau et dans la fiche en modification , leur valeur est fixée non par la requête principale sql mais par getInfosLigneTable()
$liste_champs_tableau_sup=array();
//paramètres pour le $getInfosLigneTable
$getinfotable['annee']='etudiants_scol';
$getinfovariablevaleur['annee']='interculture_code_etud';
$getinfochampindex['annee']='code';

$getinfotable['redoublant']='etudiants_scol';
$getinfovariablevaleur['redoublant']='interculture_code_etud';
$getinfochampindex['redoublant']='code';

//----------------------------------------------
$liste_champs_dates=array('user_date_limite');
$liste_champs_heures=array();
// champs qui doivent être saisis à partir d'un select
$liste_champs_select=array('eleveacteur_axe');
$liste_choix_eleveacteur_axe=array('Pour faire vivre l’école',
'Pour bien vivre à l’école',
'Pour porter un projet en faisant du Génie industriel',
'Pour diffuser l’image de l’école'
);
//pour afficher des radio buttons syntaxe array('nom_du_champ'=>$liste_de_valeurs,...)
//$liste_champs_bool=array('com_selection'=>$listeouinon);
$liste_champs_bool=array();
$liste_champs_tableau=array('user_login','user_nom','user_prenom','user_email','user_date_limite');
$liste_champs_filtre=array('user_nom','user_login');
//pour récupérer le bon $_GET['champfiltre_rech'] correctement ( à cause des espaces dans les noms des champs de table)
// si pas utilisé laisser vide ex avec Prenom 1
//$liste_champs_filtre_trim=array('Nom','Prénom_1','annee','eleveacteur_statut');
$liste_champs_filtre_trim=array();
// pour les filtres si il faut aller plus loin que select distinct
$liste_champs_filtre_partiel=array();
$liste_champs_filtre_partiel_traitement=array();
//----------------------------------------------
$liste_champs_filtre_val_defaut=array();
//----------------------------------------------
// nom des en tetes du tableau à substituer si commentaire de mysql vides
//dans l'ordre on regarde le tableau $liste_libelles_tableau, puis le commentaire sql sinon on prend le nom du champs
$liste_libelles_tableau=array('user_login'=>'login');
// nom des champs à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ sinon on prend le nom du champs
$liste_libelles_champ=array();
// taille des champs d'affichage à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ
$liste_tailles_champ=array('user_login'=>15,'user_nom'=>50,'user_prenom'=>50,'user_email'=>50,'user_password'=>50);
$liste_place_holder=array( );
//pour les valeurs par defaut en ajout 
$liste_valeur_defaut=array();
//pour  l'ordre d'affichage
$liste_ordre_champ=array();
//le tri du premier affichage du tableau (avant de cliquer sur les entêtes) si vide c'est la cle primaire
$champ_tri_initial='';
// sens du tri initial asc ou desc
$senstriinitial='desc';
// where initial si pas de filtre initial  : $filtre_initial="where ";
//$filtre_initial="where date_debut > '".strval(intval($annee_courante)-1)."-08-31' and ";
//++++++++++++++++++++++++++++++++++++++++++++++
/* 
if (isset($_POST['nom']))
	//$filtre_initial="where user_nom like '%".$_POST['nom']."%' and  user_login like '%".$_POST['login']."%' and";
	{
		$GET['user_nom_rech']=$_POST['nom'];	
		$filtre_initial="where  ";
	}
	else
	{
$filtre_initial="where 0 and ";
	} */
if (isset($_POST['user_nom_rech']) and $_POST['user_nom_rech']=='')
	$_POST['user_nom_rech']='tous';
if (isset($_POST['user_login_rech']) and $_POST['user_login_rech']=='')
	$_POST['user_login_rech']='tous';

//++++++++++++++++++++++++++++++++++++++++++++++
$filtre_initial="where  ";

// pour ajouter un champ calculé aux requêtes select 
//$ajout_sql=",year(date_debut) as year ";
//$ajout_sql=",year(date_debut) as year ";
$ajout_sql="";
// champs supplémentaires ajouté par $ajout_sql
$liste_champs_tableau_calcule=array();
// pour accéder à la page
$login_autorises=array('patouilm','administrateur');
//pour pouvoir usurper une identité vide si on ne veut pas de cette fonctionnalité
//attention danger normalement seulement administrateur
// incompatible avec $login_autorises vide
$login_autorises_clone=array('patouilm','administrateur');
// pour pouvoir  ajouter
$login_autorises_ajout=array('patouilm','administrateur');
// pour pouvoir  supprimer
$login_autorises_suppression=array('patouilm','administrateur');
// pour pouvoir  modifier
$login_autorises_modif=array('administrateur','patouilm');
// pour pouvoir  accéder à détails : formulaire de modification sans validation
$login_autorises_details=array('patouilm','administrateur');
// pour pouvoir  exporter
$login_autorises_export=array('patouilm','administrateur');
// email correspondant au login  administrateur
$emailadmin='marc.patouillard@grenoble-inp.fr';
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
$champrepetition='Nom';
// couleur html des lignes à répetition
$couleur_changement=' orange ';

// on utilise enteteplus ?
$enteteplus=1;

// champs qui doivent être saisis à partir d'un select avec valeur retournée distincte de valeur affichée
$liste_champs_select_plus=array('statut_absence');
$liste_choix_lib_statut_absence=array('en attente', 'dépôt gestionnaire', 'justifiée' ,'soumis DE','complétée par étudiant','validée par DE', 'non validée par DE');
$liste_choix_code_statut_absence=array(0,1,2,3,4,5,6);
//Les params qui seront récupérés dans l'url et transmis via  $filtrerech aux formulaires etaux links afin d'être préservés tout au long de la navigation
$liste_param_get=array('user_nom_rech','user_login_rech','clone','from');
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

// pour le php cas
if($casOn)
{	
// nom de la variable de session
$nomSession='sess123';
require ("casgenerique.php");
$loginConnecte = $login;
}
else
{
	// inutile si on utilise  paramcommun
//// on récupère le login du connecté dans $_SERVER (authentification http ldap )
 if(isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] !=''){
	 $loginConnecte=$_SERVER['PHP_AUTH_USER'];
	 $loginConnecte=strtolower($loginConnecte);}
	 else
	 { $loginConnecte=''; }
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

$URL =$_SERVER['PHP_SELF'];
// pour tester comme un autre
// il faut récupérer la valeur de clone  qui pourrait être passée par un formulaire en hidden
// pour la déconnexion
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

if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'givenname')[0]." ".ask_ldap($loginConnecte,'sn')[0];else  $nomloginConnecte='';
if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';
if($loginConnecte=='administrateur' ) 
{$emailConnecte=$emailadmin;
$nomloginConnecte='Administrateur';
}
echo " <p align=right>Vous &ecirc;tes  <b>  : ".$loginConnecte."( ".$emailConnecte.")</b>  ";
echo $nomloginConnecte."<br>";
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
	//on passe tous les arg reçus en get  en hidden sauf clone
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='clone' )
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
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
			// il faut passer  le param GET clone à vide comme il existe déjà dans $filtrerech on l'ajoute une 2eme fois à la fin 
			echo "<A href=".$URL."?".$filtrerech."clone= >Déconnexion $loginConnecte </a><br>";
			}
}

$message='';
$messagem='';
$sql1='';
$sql2='';
$where='';
$orderby= '';
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
// on ajoute les champs supplementaires sql :
foreach ($liste_champs_tableau_calcule as $unchamps)
		{ 
		$champs[]=$unchamps;
		$comment[$unchamps]='';	
		$commentTaille[$unchamps]='';
		$commentPlaceHolder[$unchamps]='';
		$commentValDefaut[$unchamps]='';		
		$taillechamp[$unchamps]='';		
		}
//+++++++++++++++++++++++++++++++++++++++++++++++
// pour les champs ajoutés avec un 3eme left join juste pour le tableau
	foreach($liste_champs_lies_sup as $champs_lie_sup){
		$champs[]=$champs_lie_sup;
		$comment[$champs_lie_sup]='';
		$commentTaille[$champs_lie_sup]='';
		$commentPlaceHolder[$champs_lie_sup]='';	
		$commentValDefaut[$champs_lie_sup]='';		
		$taillechamp[$champs_lie_sup]='';
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
foreach($liste_champs_lies_sup as $temp){
		   $sqlChampsTable_sup.=",".$table_sup.".`".$temp."`";
	   }	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

print "<center>";
print "<h1>interrogation base users  GI </h1>";

print "<form  method=POST    action=".$_SERVER['PHP_SELF']." accept-charset=utf-8>";
	 	  //on passe tous les arg reçus en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }
print "<P>";
print " nom <br>" ;
print "<input type=text name=user_nom_rech value='".$_POST['user_nom_rech']."' size=30>";
print "<P>";
print " login <br>" ;
print "<input type=text name=user_login_rech value='".$_POST['user_login_rech']."' size=30>";
print "<P>";
print "<P>";

//echo affichemenuplus ("groupe","groupe",$tab2d,$groupeaff);

print "<P>";
print "<input type=submit name=suite value=\"RECHERCHE\">"  ;
print "</FORM>";
print "<i>(Vous pouvez faire des recherches sur des noms ou pr&eacute;noms incomplets)</i>";

print "</center>";














//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	   
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
elseif($_POST['bouton_mod']!='' ){

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
	   if(!in_array($ci2,$liste_champs_tableau_sup))
	   {
   $$ci2=$u->$ci2;
	   }
	   else
	   {
	$$ci2=getInfosLigneTable($getinfotable[$ci2],$connexion,$u->{$getinfovariablevaleur[$ci2]},$getinfochampindex[$ci2])[$ci2];
	   }
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
				
	      if (in_array($unchamps,$liste_champs_tableau_only))
		  {
			  // on ne fait rien
		  }			
	 // si on a une table liée
	 else if ($unchamps == $cleetrangere2 ){
	       if (in_array($unchamps,$liste_champs_lecture_seule_modif))
		   {
		   	echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">\n";
			echo afficheonlysqlplus($commentaire,'onlyaffnom',$indexlien2,'select * from '.$table2 ." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);
		   }
		   else
		   {
			echo affichemenusqlplus($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);
		   }
	  }
	  elseif ($unchamps == $cleetrangere3 ){
	       if (in_array($unchamps,$liste_champs_lecture_seule_modif))
		   {		  
		  	echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">\n";
			echo afficheonlysqlplus($commentaire,'onlyaffnom',$indexlien3,'select * from '.$table3 ." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);
		   }
		   else
		   {	  
	       echo affichemenusqlplus($commentaire,$unchamps,$indexlien3,'select * from '.$table3 ." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);
		   }
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
				elseif ($unchamps == $cleprimaire  or in_array($unchamps,$liste_champs_lecture_seule_modif) or in_array($unchamps,$liste_champs_lies2) or in_array($unchamps,$liste_champs_lies3) or in_array($unchamps,$liste_champs_lies_sup) or in_array($unchamps,$liste_champs_tableau_sup)or in_array($unchamps,$liste_champs_tableau_calcule)){

		 // en lecture seule
		  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
		 {
				echo affichechamp($commentaire,$unchamps,$$unchamps,$tailleAffichageChamp,'1');	
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea readonly rows = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
		}
		 
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
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea  rows = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
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
	      if (in_array($unchamps,$liste_champs_tableau_only))
		  {
			  // on ne fait rien
		  }			 
	 // si on a une table liée
	  elseif ($unchamps == $cleetrangere2 ){
		 $commentaire=$texte_entite2;
	       echo affichemenusqlplusnc($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$wherecleeetrangere2." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);

	  }
		  elseif ($unchamps == $cleetrangere3 ){
		 $commentaire=$texte_entite3;
			   echo affichemenusqlplusnc($commentaire,$unchamps,$indexlien3,'select * from '.$table3." ".$wherecleeetrangere3." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);

		  }
			   elseif (in_array($unchamps,$liste_champs_lies2)){
				  // on n'affiche pas 
			  }		
				  elseif (in_array($unchamps,$liste_champs_lies3) ){
					  // on n'affiche pas 
				  }	
				  	elseif (in_array($unchamps,$liste_champs_lies_sup) ){
					  // on n'affiche pas 
				  }					  
			  
				  	  elseif (in_array($unchamps,$liste_champs_tableau_sup) ) {
				// on n'affiche pas 
					}
						elseif (in_array($unchamps,$liste_champs_tableau_calcule) ) {
				// on n'affiche pas 
						}	
					  elseif (in_array($unchamps,$liste_champs_invisibles_ajout)  or in_array($unchamps,$liste_champs_lecture_seule_ajout) ){
						  // on n'affiche pas puisqu'il est invisible ou en lecture seule
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
							  echo affichemenuplus2tabnc ($commentaire,$unchamps,$$temp,$$temp2,'','','','choisissez ci dessous');
						 }
						 else
						 {
							 echo affichemenuplus2tab ($commentaire,$unchamps,$$temp,$$temp2,'','');					 
						 }
					  }	 			 			 
					 
						 else
						 {
							  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
							 {
						 echo affichechamp($commentaire,$unchamps,$commentValDefaut[$unchamps],$tailleAffichageChamp,'','','','','',$required . ' ' .$placeholder);
							 }
							else{
						 echo "<td><label for=\"".$unchamps."\">".$commentaire."<br></label><textarea rows = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$commentValDefaut[$unchamps]."</textarea></td>";			
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

 echo" <input type='Submit' name='bouton_annul' value='Annuler'></th></tr></table> "  ;
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

//pour récupérer le bon $_GET['champfiltre_rech'] correctement ( à cause des espaces dans les noms des champs de table)
	for($i=0;$i<count($liste_champs_filtre_trim);$i++)
		{
			if (isset($_GET[$liste_champs_filtre_trim[$i].'_rech']))
			$_GET[$liste_champs_filtre[$i].'_rech']=$_GET[$liste_champs_filtre_trim[$i].'_rech'];
		}
//		
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
				$reqsql.= "(`".$unchamps ."` like '%' or `".$unchamps."` is null ) and ";
			}
			elseif($_GET[$temp]=='')
				// pas de % dans ce cas
			{
				$reqsql.= "(`".$unchamps ."` = '' or `".$unchamps."` is null ) and ";
			}
			else
			{
					if (in_array ($unchamps ,$liste_champs_dates))
					{ 
			
					$reqsql.="`".$unchamps ."` like '".versmysql_Datetime($_GET[$temp])."%' and ";
					}
				else
				{
					// si on a &#039; dans un champ de recherche ( quote transformé en tête de script ) dans un des champs de rech					
					// ( et comme on peut avoir dans le champ les 2 variantes  quote ou &#039; ) 
					// pour la requête sql on cherche à la fois sur  quote (\') et 	&#039;
					if (stripos($_GET[$temp],"&#039;")!== false)
					{
					$temprech=str_replace("&#039;","\'",$_GET[$temp]);
					$reqsql.= "(`".$unchamps ."` like '".$temprech."%' or `".$unchamps ."` like '".$_GET[$temp]."%') and ";
					}
					else
					{
					$reqsql.= "`".$unchamps ."` like '".$_GET[$temp]."%' and ";
	
					}
	
				}				
			}
 
		}
		$reqsql.="1";

$where = $reqsql;
  if($table2=='')
  {
	  $req = $connexion->query("SELECT $table.*".$ajout_sql." FROM  $table ". $where ." order by `".$orderby."` " .$sens );
//echo "SELECT $table.*".$ajout_sql." FROM  $table ". $where ." order by `".$orderby."` " .$sens ;
	  $reqfiltre= $table;
	}
	elseif($table3=='')
	{

	$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ". $where ."  order by `".$orderby."` ".$sens );
	$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ";
	}
	elseif($table_sup=='')
	{
$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ". $where ." order by `".$orderby."` ".$sens );
$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ";
	}
	else
	{
// pour récupérer  les champs de la table_sup
$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$sqlChampsTable_sup.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup` ". $where ." order by `".$orderby."` ".$sens );
$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup`";
//echo "SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$sqlChampsTable_sup.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup` ". $where ." order by `".$orderby."` ".$sens ;

	}

 $nombre=$req->rowCount();

if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo " ".$texte_entite ."(s)</H2>";}
else{
echo"<center> <h2> ";
echo " 0 ".$texte_entite." actuellement dans la base</H2>";
}

if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1&".$filtrerech." > Ajouter un enregistrement </a><br>";
}
echo"<br><br><a href=".$pageaccueil.">revenir à l'accueil</a>";
//+++++++++++++++++++++++++++++++++++++++
echo"<br><br><a href=groups.php?group_libelle_rech=personnel>gestion des groupes</a>";
//+++++++++++++++++++++++++++++++++++++++
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
		{ 		if (in_array( $unchamps,$liste_champs_filtre) )
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
					echo affichemenusqlplustous('',$temp,$unchamps,"select distinct ".$unchamps." from ".$reqfiltre  ." ".$where ,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'",'','1');						
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
		echo "<th>$commentaire</th>";
		}		
		// pour la colonne actions
				echo "<td><center>Action</center></td>";	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// pour la colonne groupes 
				echo "<td><center>Groupes</center></td>";
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++				
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


 //on fait une boucle pour créer les variables issues de la table 
   foreach($champs as $ci2){
   if (in_array ($ci2 ,$liste_champs_dates))
	 { 
	 //on transforme les dates sql en dd/mm/yy
		 $$ci2=mysql_DateTime($u->$ci2);
	 $csv_output .=  nettoiecsvplus(mysql_DateTime($u->$ci2));
	 }
	elseif(in_array ($ci2 ,$liste_champs_heures))
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
			 echo echosur($$colonne) ;
			  echo"   </td><td>" ;		
       }
	   		foreach($liste_champs_tableau_sup as  $colonne)
		{
			 echo echosur($$colonne) ;
			  echo"   </td><td>" ;		
       }



	   
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
     echo " <A href=".$URL."?del=".$$cleprimaire."&".$filtrerech." onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";
	 }
	 if (in_array($loginConnecte,$login_autorises_modif) or empty($login_autorises_modif) ){
     echo "<A href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Mod</A>";
	 }
	 elseif(in_array($loginConnecte,$login_autorises_details) or empty($login_autorises_details)){
     echo "<A href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Détails</A>";
	 }

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	        echo"</td> <td>";
	  
// on récupère les groupes de l'user
$req2 = $connexion->query("select group_libelle from lignes_groupes left join groups on group_id=groupe_id where people_id='".$user_login."'");
while ($v = $req2->fetch(PDO::FETCH_OBJ)) {
		     
	echo $v->group_libelle."<br>";
}
 echo"   </td></tr>" ;		

 }

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
?>
</body>
</html>
