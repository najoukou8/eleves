<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
<?
// pour g�rer l'erreur quand l'upload d�passe post_max_size
if ( $_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST) &&
     empty($_FILES) && $_SERVER['CONTENT_LENGTH'] > 0 )
{      
  $displayMaxSize = ini_get('post_max_size'); 
  $error = 'votre fichier est trop gros :  '.(round($_SERVER['CONTENT_LENGTH']/1024/1024)).'Moctets'.
           ' , il d�passe la taille  maximum fix�e �   '.
           $displayMaxSize.' octets';
		   echo "<center><H2>". $error ."</H2>";
			echo"<br><a href=index.php>revenir � l'accueil</a><br></center>";
		   //exit();
}
//on filtre tous les arg re�us en get

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
//on filtre tous les arg re�us en Post

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
// il doit y avoir un index unique (auto incr�mental ou pas ) dans chaque fichier
// si on a un seul fichier laisser les infos $cleetrangere2 $table2  $indexlien2 � vide
// si on veut autoriser tout le monde laisser des array vides 

require ("param.php");
//---param�tres � configurer
// texte affich� en haut du tableau
$texteintro= "<h2>documents joints</h2>";
//acc�s � la BDD on peut aussi les mettre dans un fichier de param s�par� (param .php)
//$dsn="qualite_gi_test";
//$user_sql="qualiteuser";
//$password='test2014';
//$host="localhost";
//connexion pdo (pdo=1) ou oldfashion (pdo=0)
$pdo=1;
// CAS php activ� n�cessite la pr�sence de cas.php  et du rep CAS dans le rep
$casOn=0;
$texte_table='documents joints';
$table="departsdocuments";
$cleprimaire='doc_idDoc';
$autoincrement='doc_idDoc';
$cleetrangere2='';
// pour l'ordre d'affichage dans le  select en saisie / modification - peut �tre vide
$ordrecleeetrangere2='';
// restriction dans le  select en saisie / modification - peut �tre vide
$wherecleeetrangere2="";
$table2="";
$indexlien2='';
$cleetrangere3='';
$ordrecleeetrangere3='';
// restriction dans le  select en saisie / modification - peut �tre vide
$wherecleeetrangere3="";
$table3="";
$indexlien3='';
// pour la gestion des champs modifpar et date_modif
//laissez vide si pas g�r�
$champ_date_modif='date_modif';
$champ_modifpar='modifpar';

$liste_champs_lies2=array();
$liste_champs_lies3=array();
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout2=array();
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
$liste_champs_lies_pour_formulaire_ajout3=array();
// au moins un (cl�primaire)
$liste_champs_obligatoires=array('doc_libelle');
$liste_champs_lecture_seule=array();
$liste_champs_invisibles=array();
$liste_champs_dates=array();
$liste_champs_heures=array();
// champs qui doivent �tre saisis � partir d'un select
$liste_champs_select=array();
$liste_choix_eleveacteur_axe=array('Pour faire vivre l��cole',
'Pour bien vivre � l��cole',
'Pour porter un projet en faisant du G�nie industriel',
'Pour diffuser l�image de l��cole'
);
//pour afficher des radio buttons syntaxe array('nom_du_champ'=>$liste_de_valeurs,...)
//$liste_champs_bool=array('com_selection'=>$listeouinon);
$liste_champs_bool=array();
$liste_champs_tableau=array('doc_libelle');
$liste_champs_filtre=array();
// pour les filtres si il faut aller plus loin que select distinct
$liste_champs_filtre_partiel=array();
$liste_champs_filtre_partiel_traitement=array();
// nom des en tetes du tableau � substituer si commentaire de mysql vides
//dans l'ordre on regarde le tableau $liste_libelles_tableau, puis le commentaire sql sinon on prend le nom du champs
$liste_libelles_tableau=array();
// nom des champs � substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ sinon on prend le nom du champs
$liste_libelles_champ=array();
// taille des champs d'affichage � substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ
$liste_tailles_champ=array();
$liste_place_holder=array('doc_libelle'=>'De quel document s\'agit il ?');
//pour les valeurs par defaut en ajout 
$liste_valeur_defaut=array();
//pour  l'ordre d'affichage
$liste_ordre_champ=array();
//le tri du premier affichage du tableau (avant de cliquer sur les ent�tes) si vide c'est la cle primaire
$champ_tri_initial='';
// sens du tri initial asc ou desc
$senstriinitial='desc';
// where initial si pas de filtre initial  : $filtre_initial="where ";
//$filtre_initial="where date_debut > '".strval(intval($annee_courante)-1)."-08-31' and ";
$filtre_initial="where ";
// pour acc�der � la page
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
  // les personnels autoris�s
  $elevedepart_users=array('patouilm','administrateur','dehemchn');
   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
$login_autorises=array();
//pour pouvoir usurper une identit� vide si on ne veut pas de cette fonctionnalit�
//attention danger normalement seulement administrateur
// incompatible avec $login_autorises vide
$login_autorises_clone=$elevedepart_users;
// pour pouvoir  ajouter
$login_autorises_ajout=$elevedepart_users;
// pour pouvoir  supprimer
$login_autorises_suppression=$elevedepart_users;
// pour pouvoir  modifier
$login_autorises_modif=$elevedepart_users;
// pour pouvoir  acc�der � d�tails : formulaire de modification sans validation
$login_autorises_details=$elevedepart_users;
// pour pouvoir  exporter
$login_autorises_export=$elevedepart_users;
// email correspondant au login  administrateur
$emailadmin='marc.patouillard@grenoble-inp.fr';
// est ce qu'on fait appel � ldap pour r�cup�rer les noms prenom mail ...� partir des logins
$ldapOK=1;
// attention pour v�rifier les groupes autoris�s apr�s l'authentification CAS ldap est aussi utilis�
//si on laisse vide les 2 dn des groupes , tout le monde est accept� et le nomgroupe authentification vaut :' membre de grenoble-inp'
// dn du groupe1
$dngroupe1authentification1='CN=inpg-GI-personnels-GI-GSCOP,OU=Groups,DC=gi-admin,DC=inpg,DC=fr';
// nom affich� du groupe 1 
$nomgroupe1authentification1="Personnel GI-GSCOP";
// dn du groupe1
$dngroupe1authentification2='';
// nom affich� du groupe 1 
$nomgroupe1authentification2="";
$pageaccueil='departs.php';
// au dessus de cette valeur  on tracera une zone de texte
$tailleLimiteChampCourt = 200;
//en dessous on prendra soit cette valeur soit la valeur pr�sente dans 2eme item des commentaires de champs de la bdd ou dans la liste $liste_tailles_champ
$tailleDefautChampCourt = 60;
//-------------------------fin de configuration

// ces 2 fichiers doivent �tre pr�sent dans le m�me rep
require ("function.php");
require ("style.php");
echo "<head>";
echo "<title>".$texte_table."</title>";
echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";
// ces 4 fichiers doivent �tre pr�sent dans le m�me rep
// echo "		<link rel='stylesheet' href='../js/calendrier.css' type='text/css' />";
// echo "		<script src='../js/jsSimpleDatePickrInit.js'></script>";
// echo "		<script src='../js/jsSimpleDatePickr.js'></script>";
// echo "		<script src='../js/verifheure.js'></script>";
echo "</HEAD><BODY>" ;
// On se connecte � mysql classique ou  PDO
if($pdo)
	$connexion =ConnexionPDO ($user_sql, $password, $dsn, $host);
else
$connexion =Connexion ($user_sql, $password, $dsn, $host);

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
//// on r�cup�re le login du connect� dans $_SERVER (authentification http ldap )
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
   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
if (!isset($_GET['offre'])) $_GET['offre']='';
if (!isset($_POST['offre'])) $_POST['offre']='';
if (!isset($_GET['from'])) $_GET['from']='';
if (!isset($_POST['from'])) $_POST['from']='';
   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
$URL =$_SERVER['PHP_SELF'];
// pour tester comme un autre
// il faut r�cup�rer la valeur de clone  qui pourrait �tre pass�e par un formulaire en hidden
// pour la d�connexion

if (($_GET['clone'] !='' ))$_POST['clone']=$_GET['clone'];
//idem pour offre
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
if (($_GET['offre'] !='' ))$_POST['offre']=$_GET['offre'];
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
// pour garder clone apres un form non lanc� par un lien 
if (($_POST['clone'] !='' ))$_GET['clone']=$_POST['clone'];
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
if (($_POST['offre'] !='' ))$_GET['offre']=$_POST['offre'];
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'displayname')[0];else  $nomloginConnecte='';
if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';
if($loginConnecte=='administrateur' ) $emailConnecte=$emailadmin;
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
			echo "<p align=right>Clone";echo affichechamp('','clone','',10);	
			echo"     <input type ='submit' name='bouton_clone'  value='OK'> <br> "  ;
			echo "</form>";
	 }
			// et on remplace  $login par $_POST['clone']
	if ($_POST['clone'] !=''  ) {			
			$loginConnecte=$_POST['clone'];
			echo "<p align=right><i> login clone :".$loginConnecte."</i> ";
			if($ldapOK) $nomloginConnecte=ask_ldap($loginConnecte,'displayname')[0];else  $nomloginConnecte='';		
			if($ldapOK) $emailConnecte=ask_ldap($loginConnecte,'mail')[0];else  $emailConnecte='';			
			echo $nomloginConnecte." (".$emailConnecte.")<br>";
			echo "<A href=".$URL."?clone= >D�connexion $loginConnecte </a><br>";
			}
}



   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

if ( $_GET['offre']!='') 
{
	   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 
	$filtre_initial=" where doc_idDepart = '".$_GET['offre']."' and " ;
	
	// pour ajouter l'etudiant connect� aux listes d'autorisation
	$etudOK=0;
	//il faut recuperer le num etudiant � partir de son login
	$query= "SELECT annuaire.`code-etu` as codeEtu  FROM annuaire where Uid='".$loginConnecte."'";
		$req = $connexion->query($query );
		 $nombre=$req->rowCount();
	 //si le login est bien celui d'un etudiant
	 if ($nombre!=0){
	$e = $req->fetch(PDO::FETCH_OBJ) ;
	$query="SELECT annuaire.*,etudiants.*,etudiants_scol.*,etudiants_accueil.acc_code_ade FROM etudiants
					  left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
					  left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.`acc_code_etu`
					  left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.`code` WHERE `Code etu` = '". $e->codeEtu ."';";
	$req = $connexion->query($query );
	$nombre=$req->rowCount();
	// si il existe bien dans la base eleves 
	 if ($nombre!=0){
		 		 // il faut encore v�rifier que son code etu  est bien celui pr�sent dans la fiche du depart
		$query= "SELECT  code_etudiant FROM departs  where code_depart= :offre";
			$preparequery=$connexion->prepare($query);
			$res=$preparequery->execute(array('offre' =>$_GET['offre'] ));			
			$u =$preparequery->fetch(PDO::FETCH_OBJ); 
			if($u->code_etudiant == $e->codeEtu)
			{

			 $etudOK=1;
			 // on l'ajoute dans les autorisations
			 $login_autorises[]=$loginConnecte; 
			 $login_autorises_ajout[]=$loginConnecte; 
			$login_autorises_modif[]=$loginConnecte; 	
			$login_autorises_details[]=$loginConnecte; 		
			$login_autorises_suppression[]=$loginConnecte;	 
			 $codeEtudOK=$e->codeEtu;
			 }
			else
			{echo "probl�me de concordance d`'identifiants $u->code_etudiant diff�rent de $e->codeEtu ";
			}
		 }
	 }	
 
	 
	 
	 
	 
	 
}
else
{
	// si un �tudiant  arrive ici  , c'est qu'il  a bidouill� les param , donc on ne l'autorise pas � aller plus loin
	// il n' y a rien � faire car il n'a pas �t� ajout� � $login_autorises
 //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 


}

   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

$message='';
$messagem='';
$sql1='';
$sql2='';
$where='';
$orderby= '';
if ($_POST['clone']!='')
	$filtrerech="clone=".$_POST['clone']."&";
	else
	$filtrerech='';
if ($_POST['offre']!='')
	$filtrerech.="offre=".$_POST['offre']."&";
 if ($_GET['from']!='')
 $filtrerech.="from=".$_GET['from']."&";

$filtretri='';
$sens='';
//pdo
$sql1pdo='';
$sql2pdo='';
$tableaupdo=array();

   //seules les personnes autoris�es ont acces � la liste
if(in_array($loginConnecte,$login_autorises) or empty($login_autorises) ){
	$affichetout=1;
}else
	{$affichetout=0;
	  echo affichealerte(" Vous n'�tes pas autoris� � consulter cette page");
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
		// on cree un tableau index� des longueurs par le nom des champs
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
			 // elle n'est pas sp�cifi�e dans les commentaires des champs dans la  bdd ? on  prend celle sp�cifi� dans $liste_tailles_champ sinon on prend celle de la bdd

					if (array_key_exists($unchamps,$liste_tailles_champ) )
					{	
					$commentTaille[$unchamps]=$liste_tailles_champ[$unchamps];
					}						
						elseif($commentTaille[$unchamps]!='')
						{
							// on garde cette valeur r�cup�r�e dans les commentaires de la bdd 
						}		
							// si on n'a pas de valeur fix�e , on v�rifie si on est en dessous de la taille limite des champs courst						
							elseif($taillechamp[$unchamps]<$tailleLimiteChampCourt)						
							$commentTaille[$unchamps]=$tailleDefautChampCourt;	
								else	// on prend la valeur de la bdd
								$commentTaille[$unchamps]=$taillechamp[$unchamps];		
				 // pour le place holder
			 // il n'est pas sp�cifi� dans les commentaires des champs dans la  bdd ? on  prend celui sp�cifi� dans $liste_place_holder sinon on prend celle de la bdd

					if (array_key_exists($unchamps,$liste_place_holder) )
						{	
						$commentPlaceHolder[$unchamps]=$liste_place_holder[$unchamps];
						}						
					elseif($commentPlaceHolder[$unchamps]!='')
						{
							// on garde cette valeur r�cup�r�e dans les commentaires de la bdd 
						}		
					else
						{
							//valeur par d�faut du placeholder
						$commentPlaceHolder[$unchamps]='';
						}	
				 // pour la valeur par defaut 
			 // elle n'est pas sp�cifi�e dans les commentaires des champs dans la  bdd ? on  prend celle sp�cifi�e dans $liste_valeur_defaut sinon on prend celle de la bdd

					if (array_key_exists($unchamps,$liste_valeur_defaut) )
						{	
						$commentValDefaut[$unchamps]=$liste_valeur_defaut[$unchamps];
						}						
					elseif($commentValDefaut[$unchamps]!='')
						{
							// on garde cette valeur r�cup�r�e dans les commentaires de la bdd 
						}		
					else
						{
							//valeur par d�faut de la valeur par defaut
						$commentValDefaut[$unchamps]='';
						}						
							
				 // pour le libell�
			 // il  n'est pas sp�cifi� dans les commentaires des champs dans la  bdd ? on  prend celui sp�cifi� dans $liste_libelles_champ sinon on prend celui de la bdd
				if (array_key_exists($unchamps,$liste_libelles_champ) )
						{	
						$comment[$unchamps]=$liste_libelles_champ[$unchamps];
						}
					elseif($comment[$unchamps]!='')
						{
							// on garde cette valeur r�cup�r�e dans les commentaires de la bdd 
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
// on ordonne $ordreaffichage avec le nouvel ordre et on l'affecte �  $champs
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
// on v�rifie que le $_GET['env_orderby'] est bien un champ de la table
If (!in_array(urldecode($_GET['env_orderby']),$champs)) $_GET['env_orderby']='';
if ($_GET['env_orderby']=='') {$orderby=$tri_initial ;
$sens=$senstriinitial;
}
	else{
	$orderby=urldecode($_GET['env_orderby']);
#�a c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
//$orderby="ORDER BY ".$orderby;
                  if  ($_GET['env_inverse']=="1"){
                  $sens="desc";
                  }
	}
//on prepare la liste sql des champs table2 et table3 � r�cup�rer	utilis� dans les select toutes les fiches et le formulaire de modif
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
//test si autoris�
if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
// d'abord on upload le fichier temporaire

$fichier = basename($_FILES['docfil']['name']);
$extfichier=pathinfo($fichier, PATHINFO_EXTENSION);
$fichier =nettoie(date('dmyhis') ."-".$fichier).".".$extfichier;

$extensions = array('.jpg','.docx','.doc','.pdf');

//D�but des v�rifications de s�curit�...
// si on a pas de fichier temporaire c'est qu'il n' a pas �t� accept� par le formulaire (taile  MAX )
if($_FILES['docfil']['tmp_name']!='')
		{
	$extension = strrchr($_FILES['docfil']['name'], '.'); 
		if(!in_array(strtolower($extension), $extensions)) //Si l'extension n'est pas dans le tableau
		{
			 $erreur = 'Vous devez uploader un fichier du type autoris� : .jpg,.docx,.doc,.pdf';
		}

		}
		else{
			$erreur = 'Fichier trop volumineux';
		}
if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
{
     //On formate le nom du fichier ici...
	// $fichier =$_GET['code'].".jpg";
	 //echo "<br>". $_FILES['docfil']['tmp_name'];
    if(move_uploaded_file($_FILES['docfil']['tmp_name'], $chemin_local_depart . $fichier)) //Si la fonction renvoie TRUE, c'est que �a a fonctionn�...
     {
          echo 'Upload effectu� avec succ�s !';	  
			}//fin du if moveupload
		     else //Sinon (la fonction renvoie FALSE).
		     {
		          echo "Echec de l'upload ! ";
		     }
	
 
	
// on positionne le nom  du fichier	
	
$_POST['doc_lienDoc']=$fichier;	
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	
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
// $_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');
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
  elseif(in_array($ci2,$liste_champs_invisibles))
 {
 // on ne fait rien pour r�cup�rer si elle existe la valeur par d�faut d�finie dans la bdd
 }
   elseif(in_array($ci2,$liste_champs_lecture_seule))
 {
 // on ne fait rien pour r�cup�rer si elle existe la valeur par d�faut d�finie dans la bdd
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
	   $message .= "</B> ajout�e !<br>";}
	   else {
		echo affichealerte("erreur de saisie ");
	  echo "<center>La fiche n'est pas enregistr�e</b> </center>";
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
   echo "<center><b>impossible d'enregistrer ce fichier : $erreur </b><br>";
      echo "aucune modification effectu�e<br></center>";

} //fin du else $loginConnecte ==
}
}
// ---------------------------------Suppression de la fiche
if($_GET['del']!='') {
	
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	// il faut d'abord supprimer le document pour cela il faut r�cup�rer le nom du fichier
	 $req = $connexion->query("SELECT $table.* FROM  $table where ". $where .$cleprimaire."='".$_GET['del']."'"  );
	//$query = "SELECT *  FROM $table"
    //  ." WHERE ".$cleprimaire."='".$_GET['del']."'";
	// $result = mysql_query($query,$connexion);
	//$r=mysql_fetch_object($result);
	$r= $req->fetch(PDO::FETCH_OBJ);
	$nomdoc=$chemin_local_depart.$r->doc_lienDoc;
	
	  if (file_exists($nomdoc))
	  {
   unlink($nomdoc);
   echo "<br>fichier  ".$nomdoc." supprim�<br>";
	  }
	  else
		echo "<br>fichier  ".$nomdoc." introuvable<br>"; 

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


   $pdoquery = $connexion->prepare("DELETE FROM $table  WHERE ".$cleprimaire."= :del");
   $res=	    $pdoquery->execute(array('del' =>$_GET['del'] ));
   if($res){
   $message .= "Fiche <b>".$_GET['del'];
   $message .= "</b> supprim�e <br>!";
   }
   }
      else{
   echo "<center><b>seul un utilisateur autoris� peut effectuer cette op�ration</b><br>";
      echo "aucune modification effectu�e<br></center>";
}//fin du else $loginConnecte == 
}
//--------------------------------- Modif de la fiche
if($_POST['bouton_mod']!='' ){

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
 //$_POST[$ci2]= html_entity_decode($_POST[$ci2], ENT_QUOTES, 'ISO8859-1');


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

   $message .= "Fiche numero ".$_POST[$cleprimaire]." modifi�e <br>";}
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
   echo "<center><b>seul un utilisateur autoris� peut effectuer cette op�ration</b><br>";
      echo "aucune modification effectu�e<br>";

} //fin du else $loginConnecte ==
} //fin du if
if($_GET['mod']!='' or $_POST['mod']!='' ){
	
$affichetout=0;
if($_GET['mod']!=''){

  //------------------------------------c'est kon a cliqu� sur le lien details
  if($table2=='')
  {
		$query = "SELECT $table.* FROM $table 
					  WHERE ".$cleprimaire."= :mod";		  
	}
	elseif($table3=='')
  {

	$query = "SELECT $table.*".$sqlChampsTable2."  FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` where ".$cleprimaire."= :mod";	
	}	
	else
	{

	$query = "SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  where ".$cleprimaire."= :mod";
	}
	$preparequery=$connexion->prepare($query);
   $res=$preparequery->execute(array('mod' =>$_GET['mod'] ));					 
	$u =$preparequery->fetch(PDO::FETCH_OBJ);
   //on fait une boucle pour cr�er les variables issues de la table principale
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

	 	  //on passe tous les arg re�us en get  en hidden sauf mod et add
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
				
	 // si on a une table li�e
	  if ($unchamps == $cleetrangere2 ){
	       echo affichemenusqlplus($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);

	  }
	  elseif ($unchamps == $cleetrangere3 ){
	       echo affichemenusqlplus($commentaire,$unchamps,$indexlien3,'select * from '.$table3 ." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],$$unchamps,$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);

	  }	
	  elseif (in_array($unchamps,$liste_champs_lies2) and  in_array($unchamps,$liste_champs_lies_pour_formulaire_ajout2)){
	      // on n'affiche pas puisqu'il est dans le popup
	  }		
	  elseif (in_array($unchamps,$liste_champs_lies3) and  in_array($unchamps,$liste_champs_lies_pour_formulaire_ajout3)){
	      // on n'affiche pas puisqu'il est dans le popup
	  }		  
	  elseif (in_array($unchamps,$liste_champs_invisibles)){
	      // on n'affiche pas puisqu'il est invisible mais on le met en hidden
		    echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">";
	  }
		elseif ($unchamps == $cleprimaire  or in_array($unchamps,$liste_champs_lecture_seule) or in_array($unchamps,$liste_champs_lies2) or in_array($unchamps,$liste_champs_lies3)){
		 // en lecture seule
		  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
		 {
				echo affichechamp($commentaire,$unchamps,$$unchamps,$tailleAffichageChamp,'1');	
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br>.</label><textarea readonly row = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
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
    //+++++++++++++++++++++++++++on n'affiche pas doc_lienDoc+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 elseif ($unchamps== 'doc_lienDoc' )
			 {
				  echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">";
			 }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
    //+++++++++++++++++++++++++++on n'affiche pas doc_idVoeu_eleves	+++++++++++++++++++++++++++++++++++++++++++++++++++++++
		 elseif ($unchamps== 'doc_idDepart' )
			 {
				  echo"<input type='hidden' name='".$unchamps."' value=\"".$$unchamps."\">";
			 }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
			 else{
		  if ($tailleAffichageChamp<$tailleLimiteChampCourt)
		 {
						 echo affichechamp($commentaire,$unchamps,$$unchamps,$tailleAffichageChamp,'','','','','',$required. ' ' .$placeholder);
		 }
		else{
     echo "<td><label for=\"".$unchamps."\">".$commentaire."<br>.</label><textarea  row = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$$unchamps."</textarea></td>";			
		}
			 }
    echo "</tr><tr>";	 
	 }
  echo "</td></tr><tr><th colspan=6>";
    //on met en hidden la cle primaire - inutile si elle est d�j� affich�e
  //  echo"<input type='hidden' name='$cleprimaire' value=\"".$$cleprimaire."\">   ";
   if(in_array($loginConnecte,$login_autorises_modif)or empty($login_autorises_modif))
   {
  echo"<input type='Submit' name='bouton_mod' value='modifier'>";
  }

  
  echo "</form>";
  echo    "<form id='annulation' method=post action=$URL> ";

	 	  //on passe tous les arg re�us en get  en hidden sauf mod et add
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
 //---------------------------------------c'est kon a cliqu� sur le lien ajouter
 //on initialise les variables
 //on fait une boucle pour cr�er les variables issues de la table 
 

 
   foreach($champs as $ci2){
  if (!isset($$ci2)) $$ci2='';
   }
				
  //echo    "<form method=post action=$URL> ";
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
 	echo "	<form method='POST' action=$URL enctype='multipart/form-data'>";
  echo"     <center>  <table><tr> ";
  // pour garder la ref de l'offre apres avoir valid� le form
    echo"<input type='hidden' name='offre' value=".$_GET['offre'].">"; 
   //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ 

	 	  //on passe tous les arg re�us en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }

  echo"<input type='hidden' name='ajout' value=1>";

  

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
			 
	 // si on a une table li�e
	  if ($unchamps == $cleetrangere2 ){
	       echo affichemenusqlplus($commentaire,$unchamps,$indexlien2,'select * from '.$table2 ." ".$wherecleeetrangere2." ".$ordrecleeetrangere2,$liste_champs_lies_pour_formulaire_ajout2[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout2[1]);

	  }
		  elseif ($unchamps == $cleetrangere3 ){
			   echo affichemenusqlplus($commentaire,$unchamps,$indexlien3,'select * from '.$table3." ".$wherecleeetrangere3." ".$ordrecleeetrangere3,$liste_champs_lies_pour_formulaire_ajout3[0],'',$connexion,$liste_champs_lies_pour_formulaire_ajout3[1]);

		  }
			   elseif (in_array($unchamps,$liste_champs_lies2)){
				  // on n'affiche pas 
			  }		
				  elseif (in_array($unchamps,$liste_champs_lies3) ){
					  // on n'affiche pas 
				  }	
					  elseif (in_array($unchamps,$liste_champs_invisibles)  or in_array($unchamps,$liste_champs_lecture_seule) ){
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
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 // on met la ref offre comme valeur par defaut pour le champ code offre
	 elseif ($unchamps== 'doc_idDepart' ){
    // echo affichechamp($commentaire,$unchamps,$_GET['offre'],'40','1');	
		echo"<input type='hidden' name='".$unchamps."' value='".$_GET['offre']."'>";	 
	 }	  
	 //Pour t�l�charger le doc
	 elseif ($unchamps== 'doc_lienDoc' )
	 {	


			echo afficheonly("","Joindre un document  <br> ATTENTION format .jpg,.docx,.doc,.pdf  et <br>taille maxi 5 Mo ",'b' ,'h3','',0);
			//pour apres la sortie du formulaire retrouver la selection en cours
		 //On limite le fichier � 100Ko -->
		echo " <input type='hidden' name='MAX_FILE_SIZE' value='1500000'>";
			//echo " <input type='hidden' name='code' value=".$_GET['code'].">";
		echo"       <table><tr>  ";
		echo "  Fichier : <input type='file' name='docfil'>";
				 echo "</tr><tr>";	
		//echo "<td> <input type='submit' name='bouton_adddoc' value='Envoyer le fichier' onClick=\"return confirmSubmit()\">";
		 //echo " <input type='submit' name='bouton_annuldoc' value='Annuler'></td>";
		//echo "</form>";
		//echo "</table>";
	 }
//	 elseif ($unchamps== 'doc_libelle' )	
// echo affichechamp($commentaire,$unchamps,'descriptif',40,'','','','','',$required );
// on n'affiche pas le auto inc ni date_modif ni modifpar
	 elseif ($unchamps != $autoincrement and $unchamps != 'date_modif' and $unchamps != 'modifpar' ){

						 echo affichechamp($commentaire,$unchamps,$commentValDefaut[$unchamps],$tailleAffichageChamp,'','','','','',$required . ' ' .$placeholder);
		 }


  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++  
						 // else
						 // {
							  // if ($tailleAffichageChamp<$tailleLimiteChampCourt)
							 // {
						 // echo affichechamp($commentaire,$unchamps,$commentValDefaut[$unchamps],$tailleAffichageChamp,'','','','','',$required . ' ' .$placeholder);
							 // }
							// else{
						 // echo "<td><label for=\"".$unchamps."\">".$commentaire."<br>.</label><textarea row = \"4\" cols=\"70\" name=$unchamps id=$unchamps $required>".$commentValDefaut[$unchamps]."</textarea></td>";			
							// }	
						 // }
}
    echo "</tr><tr>";	 
	 }

  
 echo "</td></tr><tr><td><input type='Submit' name='bouton_add' value='ajouter'></form>";    echo    "<form id='annulation' method=post action=$URL> ";
	 	  //on passe tous les arg re�us en get  en hidden sauf mod et add
	 foreach($_GET as $x=>$ci2)	
	  {
		  if($x!='add' and $x!='mod')
		  {
          echo"<input type='hidden' name='".$x."' value=\"".$ci2."\">\n";
		  }
	  }

 echo" </td><td><input type='Submit' name='bouton_annul' value='Annuler'></td></tr></table> "  ;
      echo    "</form > ";
  echo "(*) champs obligatoires";
  echo"</center>";
        }

 if ($affichetout)  {
echo" <table width=100% height=100%><tr><td><center>  ";
echo $texteintro;
echo $message;
// --------------------------------------s�lection de toutes les fiches et affichage

//on forge le where qui va bien en fonction des filtres choisis
$reqsql=$filtre_initial;
		foreach ($liste_champs_filtre as $unchamps)
		{
			$temp=$unchamps.'_rech';
			if (!(isset($_GET[$temp])))
			{
				$_GET[$temp]="";
			}
			if (isset($_POST[$temp] ))
			{
				$_GET[$temp] = $_POST[$temp];
			}	
			$$temp=$_GET[$temp];
			// on cr�� aussi le filtre de recherche que l'on ajoute en get lors des clics sur les entetes pour les tris

			$filtrerech .=$temp ."=".urlencode($_GET[$temp])."&";
			if($_GET[$temp]=='')
				// � cause des null qui ne sont pas renvoy�s par like %
			{
				$reqsql.= "(".$unchamps ." like '%' or ".$unchamps." is null ) and ";
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
  if($table2=='')
  {
	  $req = $connexion->query("SELECT $table.* FROM  $table ". $where ." order by `".$orderby."` " .$sens );

	  $reqfiltre= $table;
	}
	elseif($table3=='')
	{

	$req = $connexion->query("SELECT $table.*".$sqlChampsTable2." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ". $where ."  order by `".$orderby."` ".$sens );
	$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ";
	}
	else
	{
	$req = $connexion->query("SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ". $where ." order by `".$orderby."` ".$sens );
	$reqfiltre= $table." LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` ";
	}	

 $nombre=$req->rowCount();

if ($nombre>0){
echo"<center> <h2>Liste des   ";
echo $nombre;
echo " enregistrements ".$texte_table ."</H2>";}
else{
echo"<center> <h2> ";
echo " pas d'enregistrement trouv� dans ".$texte_table ."</H2>";
}

if(in_array($loginConnecte,$login_autorises_ajout) or empty($login_autorises_ajout)){
echo "<A href=".$URL."?add=1&".$filtrerech." > Ajouter un enregistrement </a><br>";
}
echo"<br><br><a href=".$pageaccueil.'?'.$filtrerech.">revenir � l'accueil</a>";
echo"<BR><table border=1> ";


echo"<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les ent�tes des colonnes </center>";
if(sizeof($liste_champs_filtre)>0){
	echo"<br>Vous pouvez filtrer le tableau en s�lectionnant une valeur dans le menu filtre </center>";
	}
        echo "<BR><BR><table border=1> ";
		
		echo  "<FORM  action=".$_SERVER['PHP_SELF']." method=GET name='monform'> ";

	 	  //on passe tous les arg re�us en get  en hidden sauf mod et add
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
					echo affichemenusqlplusnc('',$temp,$unchamps,"select distinct DATE_FORMAT(".$unchamps.",'%d/%m/%Y') as  '".$unchamps."' from ".$reqfiltre ." ".$where,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'");	
					//on transforme les dates sql en dd/mm/yy
					}
					 elseif(in_array ($unchamps ,$liste_champs_filtre_partiel))
					{	 
					echo affichemenusqlplusnc('',$temp,$unchamps,"select distinct ". $liste_champs_filtre_partiel_traitement[$unchamps]." as $unchamps from ".$reqfiltre  ." ".$where ,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'");						
					}				
					 else
					{	 
					echo affichemenusqlplusnc('',$temp,$unchamps,"select distinct ".$unchamps." from ".$reqfiltre  ." ".$where ,$unchamps,$$temp,$connexion,'','tous',"onchange='submit()'");						
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
 //pour l'export en totalit� au cas ou
for($i=0;$i<sizeof($champs);$i++) {
			$csv_output .= nettoiecsvplus($champs[$i]);
}
$csv_output .= "\n";

while ($u = $req->fetch(PDO::FETCH_OBJ)) {	
 //on fait une boucle pour cr�er les variables issues de la table 
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
		//on r�cup�re les champs li�s
		// on ecrit chaque ligne
		      echo"   </tr><td>" ;	
		foreach($liste_champs_tableau as  $colonne)
		{
			 echo echosur($$colonne) ;
			  echo"   </td><td>" ;		
       }
	   
if(in_array($loginConnecte,$login_autorises_suppression) or empty($login_autorises_suppression)){
     echo " <A href=".$URL."?del=".$$cleprimaire."&".$filtrerech." onclick=\"return confirm('Etes vous s�r de vouloir supprimer cet enregistrement ?')\">";
     echo "sup</A> - ";
	 }
	 if (in_array($loginConnecte,$login_autorises_modif) or empty($login_autorises_modif) ){
     echo "<A href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >Mod</A>";
	 }
	 elseif(in_array($loginConnecte,$login_autorises_details) or empty($login_autorises_details)){
     echo "<A href=". $URL."?mod=".$$cleprimaire."&".$filtrerech." >D�tails</A>";
	 }
	 
	 // pour tous lien de telechargement
 echo "<a href='".$chemin_depart.$doc_lienDoc ."' target=\"_blank\"> T�l�charger</A>";
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
 if(!$pdo)
mysql_close($connexion);
?>
</body>
</html>
