<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html>
<?




require __DIR__."/vendor/autoload.php" ;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;


function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE) {
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose    = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support    = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}



if (!isset($_SERVER['PHP_AUTH_USER'])) {

$number_3_abs = [] ;

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



    require("param.php");
//---paramètres à configurer
// texte affiché en haut du tableau
    $texteintro = "<h2></h2>";
//accès à la BDD on peut aussi les mettre dans un fichier de param séparé (param .php)
//$dsn="qualite_gi_test";
//$user_sql="qualiteuser";
//$password='test2014';
//$host="localhost";
//connexion pdo (pdo=1) ou oldfashion (pdo=0)
    $pdo = 1;
// CAS activé nécessite la présence de cas.php  et du rep CAS dans le rep
    $casOn = 0;
    $texte_table = 'absences ' . strval(intval($annee_courante) - 1) . '-' . $annee_courante;
// pour afficher dans l'interface le nom des entités de chaque table
    $texte_entite = 'absence';
    $texte_entite2 = '';
    $texte_entite3 = '';
    $table = "absences";
    $cleprimaire = 'id_absence';
    $autoincrement = 'id_absence';
    $cleetrangere2 = 'code_etud';
// pour l'ordre d'affichage dans le  select en saisie / modification - peut être vide
    $ordrecleeetrangere2 = '';
// restriction dans le  select en saisie / modification - peut être vide
    $wherecleeetrangere2 = "";
    $table2 = "etudiants";
    $indexlien2 = 'Code etu';
    $cleetrangere3 = 'code_etud';
    $ordrecleeetrangere3 = '';
// restriction dans le  select en saisie / modification - peut être vide
    $wherecleeetrangere3 = "";
    $table3 = "etudiants_scol";
    $indexlien3 = 'code';
//----------------------------------------------
//Attention bien laisser vide $table_sup si pas utilisé
    $table_sup = 'absences_statuts';
    $cleetrangere_sup = 'statut_absence';
    $indexlien_sup = 'absences_statuts_code';
//---------------------------------------------
// pour la gestion des champs modifpar et date_modif
//laissez vide si pas géré
    $champ_date_modif = 'vac_dateModif';
    $champ_modifpar = 'modifpar';
    $liste_champs_lies_sup = array('absences_statuts_texte');
    $liste_champs_lies2 = array('Nom');
    $liste_champs_lies3 = array('annee');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
    $liste_champs_lies_pour_formulaire_ajout2 = array('Nom', 'Prénom 1');
//$liste_champs_lies_pour_formulaire_ajout 2 maxi , si un seul mettre une chaine vide dans le 2eme element du tableau
    $liste_champs_lies_pour_formulaire_ajout3 = array();
// au moins un (cléprimaire)
    $liste_champs_obligatoires = array('id_absence');
    $liste_champs_lecture_seule = array('year');
    $liste_champs_lecture_seule_modif = array('vac_respUid');
//permet d'affecter lors de l'ajout une valeur aux champs en lecture seule ou invisibles (sinon c'est la valeur par defaut définie dans la bdd)
    $liste_champs_lecture_seule_ou_invisibles_affectes_en_ajout = array();
    $liste_champs_invisibles = array('id_absence', 'date_modif', 'modifpar');
    $liste_champs_invisibles_modif = array('id_absence', 'date_modif', 'modifpar');
//----------------------------------------------
// pour les champs pour lesquels on ne fait rien en ajout et modif
    $liste_champs_tableau_only = array('absences_statuts_texte');
//----------------------------------------------// champs qui sont ajouté dans le tableau et dans la fiche en modification , leur valeur est fixée non par la requête principale sql mais par getInfosLigneTable()
    $liste_champs_tableau_sup = array();
//paramètres pour le $getInfosLigneTable
    $getinfotable['annee'] = 'etudiants_scol';
    $getinfovariablevaleur['annee'] = 'interculture_code_etud';
    $getinfochampindex['annee'] = 'code';

    $getinfotable['redoublant'] = 'etudiants_scol';
    $getinfovariablevaleur['redoublant'] = 'interculture_code_etud';
    $getinfochampindex['redoublant'] = 'code';

//----------------------------------------------
    $liste_champs_dates = array('date_debut', 'date_fin');
    $liste_champs_heures = array();
// champs qui doivent être saisis à partir d'un select
    $liste_champs_select = array();
    $liste_choix_eleveacteur_axe = array('Pour faire vivre l’école',
        'Pour bien vivre à l’école',
        'Pour porter un projet en faisant du Génie industriel',
        'Pour diffuser l’image de l’école'
    );
//pour afficher des radio buttons syntaxe array('nom_du_champ'=>$liste_de_valeurs,...)
//$liste_champs_bool=array('com_selection'=>$listeouinon);
    $liste_champs_bool = array();
    $liste_champs_tableau = array('Nom', 'annee', 'date_debut', 'date_fin', 'absences_statuts_texte', 'year');
    $liste_champs_filtre = array('Nom', 'annee', 'date_debut', 'date_fin', 'absences_statuts_texte', 'motif');
//pour récupérer le bon $_GET['champfiltre_rech'] correctement ( à cause des espaces dans les noms des champs de table)
// si pas utilisé laisser vide ex avec Prenom 1
//$liste_champs_filtre_trim=array('Nom','Prénom_1','annee','eleveacteur_statut');
    $liste_champs_filtre_trim = array();
// pour les filtres si il faut aller plus loin que select distinct
    $liste_champs_filtre_partiel = array('annee');
    $liste_champs_filtre_partiel_motcles = array('motif');
    $sqlmotcle = '';
// foreach($liste_champs_filtre_partiel_motcles as $motcle)
// {$sqlmotcle.= "substring(motif, LOCATE(". $motcle.",motif),strlen(". $motcle.")";}
    $liste_champs_filtre_partiel_traitement = array('annee' => 'left(ltrim(annee),6)');
//----------------------------------------------
    $liste_champs_filtre_val_defaut = array();
//----------------------------------------------
// nom des en tetes du tableau à substituer si commentaire de mysql vides
//dans l'ordre on regarde le tableau $liste_libelles_tableau, puis le commentaire sql sinon on prend le nom du champs
    $liste_libelles_tableau = array('mot_cle' => 'mot clé', 'code_etud' => 'num étud', 'annee' => 'gpe principal', 'year' => 'année scolaire', 'absences_statuts_texte' => 'statut');
// nom des champs à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ sinon on prend le nom du champs
    $liste_libelles_champ = array('id_absence' => 'Identifiant', 'year' => 'année scolaire');
// taille des champs d'affichage à substituer si commentaire de mysql vides
//dans l'ordre on regarde  le commentaire mysql puis le tableau $liste_libelles_champ
    $liste_tailles_champ = array();
    $liste_place_holder = array();
//pour les valeurs par defaut en ajout
    $liste_valeur_defaut = array();
//pour  l'ordre d'affichage
    $liste_ordre_champ = array();
//le tri du premier affichage du tableau (avant de cliquer sur les entêtes) si vide c'est la cle primaire
    $champ_tri_initial = 'date_debut';
// sens du tri initial asc ou desc
    $senstriinitial = 'desc';
// where initial si pas de filtre initial  : $filtre_initial="where ";
//$filtre_initial="where date_debut > '".strval(intval($annee_courante)-1)."-08-31' and ";
    $filtre_initial = "where date_debut > '" . strval(intval($annee_courante) - 1) . "-08-31' and ";
// pour ajouter un champ calculé aux requêtes select
//$ajout_sql=",year(date_debut) as year ";
//$ajout_sql=",year(date_debut) as year ";
    $ajout_sql = ",
CASE 
 WHEN month(date_debut) < 9 THEN concat(year(date_debut)-1,'-',year(date_debut))
ELSE 
concat(year(date_debut),'-',year(date_debut)+1)
END as year ";
// champs supplémentaires ajouté par $ajout_sql
    $liste_champs_tableau_calcule = array('year');

// pour accéder à la page
    $login_autorises = array();
//pour pouvoir usurper une identité vide si on ne veut pas de cette fonctionnalité
//attention danger normalement seulement administrateur
// incompatible avec $login_autorises vide
    $login_autorises_clone = array('patouilm');
// pour pouvoir  ajouter
    $login_autorises_ajout = array('administrateur');
// pour pouvoir  supprimer
    $login_autorises_suppression = array('administrateur');
// pour pouvoir  modifier
    $login_autorises_modif = array('administrateur');
// pour pouvoir  accéder à détails : formulaire de modification sans validation
    $login_autorises_details = array('administrateur');
// pour pouvoir  exporter
    $login_autorises_export = array('administrateur');
// email correspondant au login  administrateur
    $emailadmin = 'marc.patouillard@grenoble-inp.fr';
// est ce qu'on fait appel à ldap pour récupérer les noms prenom mail ...à partir des logins
    $ldapOK = 1;
// attention pour vérifier les groupes autorisés après l'authentification CAS ldap est aussi utilisé
//si on laisse vide les 2 dn des groupes , tout le monde est accepté et le nomgroupe authentification vaut :' membre de grenoble-inp'
// dn du groupe1
    $dngroupe1authentification1 = 'CN=inpg-GI-personnels-GI-GSCOP,OU=Groups,DC=gi-admin,DC=inpg,DC=fr';
// nom affiché du groupe 1
    $nomgroupe1authentification1 = "Personnel GI-GSCOP";
// dn du groupe1
    $dngroupe1authentification2 = '';
// nom affiché du groupe 1
    $nomgroupe1authentification2 = "";
    $pageaccueil = 'default.php';
// au dessus de cette valeur  on tracera une zone de texte
    $tailleLimiteChampCourt = 200;
//en dessous on prendra soit cette valeur soit la valeur présente dans 2eme item des commentaires de champs de la bdd ou dans la liste $liste_tailles_champ
    $tailleDefautChampCourt = 60;
// changement couleur dans tableau
// à partir de combien de répétitions on change (au moins 1) si 0 désactive la fonctionnalité
    $seuil_changement_couleur = 0;
// nom du champ qui déclenchera le changement de couleur ne peut pas être vide
    $champrepetition = 'Nom';
// couleur html des lignes à répetition
    $couleur_changement = ' orange ';

// on utilise enteteplus ?
    $enteteplus = 1;

// champs qui doivent être saisis à partir d'un select avec valeur retournée distincte de valeur affichée
    $liste_champs_select_plus = array();
    $liste_choix_lib_statut_absence = array('en attente', 'dépôt gestionnaire', 'justifiée', 'soumis DE', 'complétée par étudiant', 'validée par DE', 'non validée par DE');
    $liste_choix_code_statut_absence = array(0, 1, 2, 3, 4, 5, 6);
//Les params qui seront récupérés dans l'url et transmis via  $filtrerech aux formulaires etaux links afin d'être préservés tout au long de la navigation
    $liste_param_get = array('clone');
//-------------------------fin de configuration

// ces 2 fichiers doivent être présent dans le même rep
    require("function.php");
    require("style.php");
    echo "<head>";
    echo "<title>" . $texte_table . "</title>";
    echo "<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />";
// ces 4 fichiers doivent être présent dans le même rep
    /* echo "		<link rel='stylesheet' href='../js/calendrier.css' type='text/css' />";
    echo "		<script src='../js/jsSimpleDatePickrInit.js'></script>";
    echo "		<script src='../js/jsSimpleDatePickr.js'></script>";
    echo "		<script src='../js/verifheure.js'></script>"; */
    echo "</HEAD><BODY>";
// On se connecte à mysql classique ou  PDO
    if ($pdo)
        $connexion = ConnexionPDO($user_sql, $password, $dsn, $host);
    else
        $connexion = Connexion($user_sql, $password, $dsn, $host);

    $pdo = ConnexionPDO($user_sql, $password, $dsn, $host);

    function getEtudiantByNumer($connexion, $code)
    {

        $query = "select `Code etu` , Nom , `Prénom 1` from etudiants where `Code etu` = ?";
        $stmt = $connexion->prepare($query);
        $stmt->execute(array($code));

        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return "         <span style='color:red'> &nbsp;&nbsp;&nbsp;&nbsp; &#10006; " . $arr[0]['Nom'] . ' ' . $arr [0]['Prénom 1'] . "</span>";
    }

    $login = "foukan";
    $loginConnecte = $login;

// pour le php cas
    if ($casOn) {
// nom de la variable de session
        $nomSession = 'sess123';
        require("casgenerique.php");
        $loginConnecte = $login;
    } else {
        // inutile si on utilise  paramcommun
//// on récupère le login du connecté dans $_SERVER (authentification http ldap )
        if (isset($_SERVER['PHP_AUTH_USER']) and $_SERVER['PHP_AUTH_USER'] != '') {
            $loginConnecte = $_SERVER['PHP_AUTH_USER'];
            $loginConnecte = strtolower($loginConnecte);
        } else {
            $loginConnecte = '';
        }
    }

    if (!isset($_POST['ajout'])) $_POST['ajout'] = '';
    if (!isset($_GET['del'])) $_GET['del'] = '';
    if (!isset($_POST['bouton_mod'])) $_POST['bouton_mod'] = '';
    if (!isset($_POST['bouton_add'])) $_POST['bouton_add'] = '';
    if (!isset($_POST['add'])) $_POST['add'] = '';
    if (!isset($_GET['add'])) $_GET['add'] = '';
    if (!isset($_GET['mod'])) $_GET['mod'] = '';
    if (!isset($_POST['mod'])) $_POST['mod'] = '';
    if (!isset($_POST['bouton_annul'])) $_POST['bouton_annul'] = '';
    if (!isset($_GET['env_orderby'])) $_GET['env_orderby'] = '';
    if (!isset($_GET['env_inverse'])) $_GET['env_inverse'] = '';
    if (!isset($_POST['clone'])) $_POST['clone'] = '';
    if (!isset($_GET['clone'])) $_GET['clone'] = '';

    $URL = $_SERVER['PHP_SELF'];
// pour tester comme un autre
// il faut récupérer la valeur de clone  qui pourrait être passée par un formulaire en hidden
// pour la déconnexion
    $filtrerech = '';
    foreach ($liste_param_get as $unparam) {
        // on les initialise à vide
        if (!isset($_GET[$unparam])) $_GET[$unparam] = '';
        if (!isset($_POST[$unparam])) $_POST[$unparam] = '';
        if ($_GET[$unparam] != '') $_POST[$unparam] = $_GET[$unparam];
        if ($_POST[$unparam] != '') $_GET[$unparam] = $_POST[$unparam];
        if ($_POST[$unparam] != '') {
            $filtrerech .= $unparam . "=" . urlencode($_POST[$unparam]) . "&";
        }
    }

    if ($ldapOK) $nomloginConnecte = ask_ldap($loginConnecte, 'givenname')[0] . " " . ask_ldap($loginConnecte, 'sn')[0]; else  $nomloginConnecte = '';
    if ($ldapOK) $emailConnecte = ask_ldap($loginConnecte, 'mail')[0]; else  $emailConnecte = '';
    if ($loginConnecte == 'administrateur') {
        $emailConnecte = $emailadmin;
        $nomloginConnecte = 'Administrateur';
    }
//echo " <p align=right>Vous &ecirc;tes  <b>  : ".$loginConnecte."( ".$emailConnecte.")</b>  ";
//echo $nomloginConnecte."<br>";
    require('header.php');
// on sauvegarde le login de primo connexion
    $loginorigine = $loginConnecte;
// on sauvegarde le email de primo connexion
    $emailorigine = $emailConnecte;
// si on a le droit
    if (in_array($loginConnecte, $login_autorises_clone)) {
        //et qu'on est pas sur la page  de modif ou d'ajout on affiche le formulaire clone
        if ($_GET['add'] == '' and $_GET['mod'] == '') {
            echo "<FORM  action=$URL method=POST name='form_clone'> ";
            //on passe tous les arg reçus en get  en hidden sauf clone
            foreach ($_GET as $x => $ci2) {
                if ($x != 'clone') {
                    echo "<input type='hidden' name='" . $x . "' value=\"" . $ci2 . "\">\n";
                }
            }
            echo "<p align=right>Clone";
            echo affichechamp('', 'clone', '', 10);
            echo "     <input type ='submit' name='bouton_clone'  value='OK'> <br> ";
            echo "</form>";
        }
        // et on remplace  $login par $_POST['clone']
        if ($_POST['clone'] != '') {
            $loginConnecte = $_POST['clone'];
            echo "<p align=right><i> login clone :" . $loginConnecte . "</i> ";
            if ($ldapOK) $nomloginConnecte = ask_ldap($loginConnecte, 'givenname')[0] . " " . ask_ldap($loginConnecte, 'sn')[0]; else  $nomloginConnecte = '';
            if ($ldapOK) $emailConnecte = ask_ldap($loginConnecte, 'mail')[0]; else  $emailConnecte = '';
            echo $nomloginConnecte . " (" . $emailConnecte . ")<br>";
            // il faut passer  le param GET clone à vide comme il existe déjà dans $filtrerech on l'ajoute une 2eme fois à la fin
            echo "<A href=" . $URL . "?" . $filtrerech . "clone= >Déconnexion $loginConnecte </a><br>";
        }
    }

    $message = '';
    $messagem = '';
    $sql1 = '';
    $sql2 = '';
    $where = '';
    $orderby = '';
    $filtretri = '';
    $sens = '';
//pdo
    $sql1pdo = '';
    $sql2pdo = '';
    $tableaupdo = array();

    //seules les personnes autorisées ont acces à la liste
    if (in_array($loginConnecte, $login_autorises) or empty($login_autorises)) {
        $affichetout = 1;
    } else {
        $affichetout = 0;
        echo affichealerte(" Vous n'êtes pas autorisé à consulter cette page");
    }

//on cree un tableau $champs[] avec les noms des colonnes de la table  et leur taille et leur commentaires
    $champs = champsfromtable($table, $connexion);
    $type = champstypefromtable($table, $connexion);
    $comment = champscommentfromtableplus($table, $connexion, 0, '$', 0);
    $commentTaille = champscommentfromtableplus($table, $connexion, 0, '$', 1);
    $commentPlaceHolder = champscommentfromtableplus($table, $connexion, 0, '$', 2);
    $commentValDefaut = champscommentfromtableplus($table, $connexion, 0, '$', 3);
// taille des champs
    $taillechamp = champsindextaillefromtable($table, $connexion);
    // on cree un tableau indexé des longueurs par le nom des champs
// on sauvegarde le tableau des champs sans les champs lies
    $champsSingle = $champs;
    if ($table2 != '') {
        //on cree un tableau $champstable2[] avec les noms des colonnes de la table  et leur taille et leur commentaires
        $champstable2 = champsfromtable($table2, $connexion);
        $typetable2 = champstypefromtable($table2, $connexion);
        $commenttable2 = champscommentfromtable($table2, $connexion);
        $commentTaille2 = champscommentfromtableplus($table2, $connexion, 0, '$', 1);
        $commentPlaceHolder2 = champscommentfromtableplus($table2, $connexion, 0, '$', 2);
        $commentValDefaut2 = champscommentfromtableplus($table2, $connexion, 0, '$', 3);
        //$commenttable2=tabindextab($champstable2, $temp);
        // taille des champs
        $taillechamps2 = champsindextaillefromtable($table2, $connexion);
        foreach ($liste_champs_lies2 as $champs_lie) {
            $champs[] = $champs_lie;
            $comment[$champs_lie] = $commenttable2[$champs_lie];
            $commentTaille[$champs_lie] = $commentTaille2[$champs_lie];
            $commentPlaceHolder[$champs_lie] = $commentPlaceHolder2[$champs_lie];
            $commentValDefaut[$champs_lie] = $commentValDefaut2[$champs_lie];
            $taillechamp[$champs_lie] = $taillechamps2[$champs_lie];
        }
    }
    if ($table3 != '') {
        //on cree un tableau $champstable3[] avec les noms des colonnes de la table  et leur taille et leur commentaires
        $champstable3 = champsfromtable($table3, $connexion);
        $typetable3 = champstypefromtable($table3, $connexion);
        $commenttable3 = champscommentfromtable($table3, $connexion);
        $commentTaille3 = champscommentfromtableplus($table3, $connexion, 0, '$', 1);
        $commentPlaceHolder3 = champscommentfromtableplus($table3, $connexion, 0, '$', 2);
        $commentValDefaut3 = champscommentfromtableplus($table3, $connexion, 0, '$', 3);
        //$commenttable2=tabindextab($champstable2, $temp);
        // taille des champs
        $taillechamps3 = champsindextaillefromtable($table3, $connexion);
        // on ajoute ces tableaux aux tableaux $champs
        foreach ($liste_champs_lies3 as $champs_lie) {
            $champs[] = $champs_lie;
            $comment[$champs_lie] = $commenttable3[$champs_lie];
            $commentTaille[$champs_lie] = $commentTaille3[$champs_lie];
            $commentPlaceHolder[$champs_lie] = $commentPlaceHolder3[$champs_lie];
            $commentValDefaut[$champs_lie] = $commentValDefaut3[$champs_lie];
            $taillechamp[$champs_lie] = $taillechamps3[$champs_lie];
        }
    }
// on ajoute les champs supplementaires sql :
    foreach ($liste_champs_tableau_calcule as $unchamps) {
        $champs[] = $unchamps;
        $comment[$unchamps] = '';
        $commentTaille[$unchamps] = '';
        $commentPlaceHolder[$unchamps] = '';
        $commentValDefaut[$unchamps] = '';
        $taillechamp[$unchamps] = '';
    }
//+++++++++++++++++++++++++++++++++++++++++++++++
// pour les champs ajoutés avec un 3eme left join juste pour le tableau
    foreach ($liste_champs_lies_sup as $champs_lie_sup) {
        $champs[] = $champs_lie_sup;
        $comment[$champs_lie_sup] = '';
        $commentTaille[$champs_lie_sup] = '';
        $commentPlaceHolder[$champs_lie_sup] = '';
        $commentValDefaut[$champs_lie_sup] = '';
        $taillechamp[$champs_lie_sup] = '';
    }
//++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++
// pour les champs ajoutés avec la fonctions getInfosLigneTable()
    foreach ($liste_champs_tableau_sup as $champs_tableau_sup) {
        $champs[] = $champs_tableau_sup;
        $comment[$champs_tableau_sup] = '';
        $commentTaille[$champs_tableau_sup] = '';
        $commentPlaceHolder[$champs_tableau_sup] = '';
        $commentValDefaut[$champs_tableau_sup] = '';
        $taillechamp[$champs_tableau_sup] = '';
    }
//++++++++++++++++++++++++++++++++++++++++++
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $query = "select code_etud,count(*) as compte from absences 
where date_debut > '" . strval(intval($annee_courante) - 1) . "-08-31' group by 
code_etud ";
    $preparequery = $connexion->prepare($query);
    $res = $preparequery->execute(array());
    $compteabsences = array();
    while ($u = $preparequery->fetch(PDO::FETCH_OBJ)) {
        $compteabsences[$u->code_etud] = $u->compte;
    }
//print_r ($compteabsences);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// on affecte la liste d'ordre des champs au tab leau avant de commencer la boucle
    $ordreaffichage = $liste_ordre_champ;
    $i = 0;
    foreach ($champs as $unchamps) {
        // pour la taille
        // elle n'est pas spécifiée dans les commentaires des champs dans la  bdd ? on  prend celle spécifié dans $liste_tailles_champ sinon on prend celle de la bdd

        if (array_key_exists($unchamps, $liste_tailles_champ)) {
            $commentTaille[$unchamps] = $liste_tailles_champ[$unchamps];
        } elseif ($commentTaille[$unchamps] != '') {
            // on garde cette valeur récupérée dans les commentaires de la bdd
        } // si on n'a pas de valeur fixée , on vérifie si on est en dessous de la taille limite des champs courst
        elseif ($taillechamp[$unchamps] < $tailleLimiteChampCourt)
            $commentTaille[$unchamps] = $tailleDefautChampCourt;
        else    // on prend la valeur de la bdd
            $commentTaille[$unchamps] = $taillechamp[$unchamps];
        // pour le place holder
        // il n'est pas spécifié dans les commentaires des champs dans la  bdd ? on  prend celui spécifié dans $liste_place_holder sinon on prend celle de la bdd

        if (array_key_exists($unchamps, $liste_place_holder)) {
            $commentPlaceHolder[$unchamps] = $liste_place_holder[$unchamps];
        } elseif ($commentPlaceHolder[$unchamps] != '') {
            // on garde cette valeur récupérée dans les commentaires de la bdd
        } else {
            //valeur par défaut du placeholder
            $commentPlaceHolder[$unchamps] = '';
        }
        // pour la valeur par defaut
        // elle n'est pas spécifiée dans les commentaires des champs dans la  bdd ? on  prend celle spécifiée dans $liste_valeur_defaut sinon on prend celle de la bdd

        if (array_key_exists($unchamps, $liste_valeur_defaut)) {
            $commentValDefaut[$unchamps] = $liste_valeur_defaut[$unchamps];
        } elseif ($commentValDefaut[$unchamps] != '') {
            // on garde cette valeur récupérée dans les commentaires de la bdd
        } else {
            //valeur par défaut de la valeur par defaut
            $commentValDefaut[$unchamps] = '';
        }

        // pour le libellé
        // il  n'est pas spécifié dans les commentaires des champs dans la  bdd ? on  prend celui spécifié dans $liste_libelles_champ sinon on prend celui de la bdd
        if (array_key_exists($unchamps, $liste_libelles_champ)) {
            $comment[$unchamps] = $liste_libelles_champ[$unchamps];
        } elseif ($comment[$unchamps] != '') {
            // on garde cette valeur récupérée dans les commentaires de la bdd
        } else {
            $comment[$unchamps] = $unchamps;
        }
        // pour l'ordre d'affichage
        // on regarde d'abord dans $liste_libelles_champ ensuite on prend l'ordre de la bdd
        if (!(array_key_exists($unchamps, $liste_ordre_champ))) {
            $r = $i;
            while (in_array($r, $liste_ordre_champ)) {
                $r++;
            }
            $ordreaffichage[$unchamps] = $r;
        }
        $i++;
    }
// on ordonne $ordreaffichage avec le nouvel ordre et on l'affecte à  $champs
    asort($ordreaffichage);
    $champs = array_keys($ordreaffichage);

//debug($champs );
//debug($comment,'comment');
//debug($commentTaille,'taille');


// pour le tri initial
    if (in_array($champ_tri_initial, $champs)) {
        $tri_initial = $champ_tri_initial;
    } else
        $tri_initial = $cleprimaire;
// on vérifie que le $_GET['env_orderby'] est bien un champ de la table
// pour traiter le cas où on utilise afficheenteteplus() , on récupère champ1,champ2 , il faut vérifier chaque champ
    $temp = explode(',', urldecode($_GET['env_orderby']));
    foreach ($temp as $untemp) {
        if (!in_array($untemp, $champs)) {
            $_GET['env_orderby'] = '';
            break;
        }
    }
    if ($_GET['env_orderby'] == '') {
        $orderby = $tri_initial;
        $sens = $senstriinitial;
    } else {
// pour traiter le cas où on utilise afficheenteteplus() , on récupère champ1,champ2 , il faut ajouter le car ` de séparation des champs
        $orderby = str_replace(',', '`,`', urldecode($_GET['env_orderby']));
#ça c'est pour les espaces ds les noms de colonnes
//$orderby="\"".$orderby.  "\"";
//$orderby="ORDER BY ".$orderby;
        if ($_GET['env_inverse'] == "1") {
            $sens = "desc";
        }
    }
//on prepare la liste sql des champs table2 et table3 à récupérer	utilisé dans les select toutes les fiches et le formulaire de modif
    $sqlChampsTable2 = '';
    $sqlChampsTable3 = '';
    $sqlChampsTable_sup = '';
    foreach ($liste_champs_lies2 as $temp) {
        $sqlChampsTable2 .= "," . $table2 . ".`" . $temp . "`";
    }
    foreach ($liste_champs_lies3 as $temp) {
        $sqlChampsTable3 .= "," . $table3 . ".`" . $temp . "`";
    }
    foreach ($liste_champs_lies_sup as $temp) {
        $sqlChampsTable_sup .= "," . $table_sup . ".`" . $temp . "`";
    }
// ----------------------------------Ajout de la fiche

// ---------------------------------Suppression de la fiche


//--------------------------------- Modif de la fiche


    //---------------------------------------c'est kon a cliqué sur le lien ajouter


    if ($affichetout) {
        echo " <table  width=100% height=100%><tr><td><center>  ";
        echo $texteintro;
        echo $message;
// --------------------------------------sélection de toutes les fiches et affichage
//++++++++++++++++++++++++++++++++
        echo "<table >";
        echo "<th colspan =2>Synthèse des absences actuellement en cours </th>";
        echo "<tr>";
        echo "<td>";
        $reqsynth = $connexion->query("select mot_cle as type ,count(*) as nombre from absences where date_debut <= curdate() and date_fin >= curdate() group by mot_cle");
        $totsynt = 0;
        echo "<table >";
        echo "<th>type absence</th><th>nombre</th>";
        while ($re = $reqsynth->fetch(PDO::FETCH_OBJ)) {
            echo "<tr><td>";
            echo $re->type;
            echo "</td><td style='padding : 5px ; color : black ; text-align:center;' >";
            echo $re->nombre;
            $totsynt += $re->nombre;
            echo "</td>";

        }
        echo "<tr><td>";
        echo '<b>T O T A L </b>';
        echo "</td><td style='background-color: red ; padding : 5px ; color : white ; text-align:center;'>";
        echo $totsynt;
        echo "</td>";
        echo "</table>";
        echo "</td><td>";
        $reqsynth = $connexion->query("select annee, left(ltrim(annee),6) as 'filiere' ,count(*) as nombre
	 from absences left join etudiants_scol on code=code_etud  where date_debut <= curdate() and date_fin >= curdate() group by filiere
	");
        echo "<table border=1>";
        echo "<th>filière</th><th>nombre</th>";
        while ($re = $reqsynth->fetch(PDO::FETCH_OBJ)) {

            echo "<tr><td>";
            if ($re->filiere == '1A-ETU' or $re->filiere == '2A-ICL' or $re->filiere == '2A-IDP' or $re->filiere == '1A-IPI' or $re->filiere == '2A-IPI')
                echo $re->filiere;
            else
                echo $re->annee;
            echo "</td><td>";
            echo $re->nombre;
            echo "</td></tr>";

        }
        echo "</table>";
        echo "</td>";
        echo "</table>";

//++++++++++++++++++++++++++++++
//on forge le where qui va bien en fonction des filtres choisis
        $reqsql = $filtre_initial;

//pour récupérer le bon $_GET['champfiltre_rech'] correctement ( à cause des espaces dans les noms des champs de table)
        for ($i = 0; $i < count($liste_champs_filtre_trim); $i++) {
            if (isset($_GET[$liste_champs_filtre_trim[$i] . '_rech']))
                $_GET[$liste_champs_filtre[$i] . '_rech'] = $_GET[$liste_champs_filtre_trim[$i] . '_rech'];
        }
//
        foreach ($liste_champs_filtre as $unchamps) {
            $temp = $unchamps . '_rech';
            if (!(isset($_GET[$temp]))) {
//lors du  premier accès (pas de $_GET[] dans l'url )
//----------------------------------------------
                if (array_key_exists($unchamps, $liste_champs_filtre_val_defaut)) {
                    $_GET[$temp] = $liste_champs_filtre_val_defaut[$unchamps];
                } else {
                    $_GET[$temp] = "tous";
                }
//----------------------------------------------
            }
            if (isset($_POST[$temp])) {
                $_GET[$temp] = $_POST[$temp];
            }
//++++++++++++++++++++++++++++++++++++++++
// pour que les filtres mots cles quand vide remplacés par tous
            if (in_array($unchamps, $liste_champs_filtre_partiel_motcles) and $_GET[$temp] == '') {
                $_GET[$temp] = 'tous';
            }
//+++++++++++++++++++++++++++++++++++++++++

            $$temp = $_GET[$temp];
            // on créé aussi le filtre de recherche que l'on ajoute en get lors des clics sur les entetes pour les tris

            $filtrerech .= $temp . "=" . urlencode($_GET[$temp]) . "&";
            if ($_GET[$temp] == 'tous') // à cause des null qui ne sont pas renvoyés par like %
            {
                $reqsql .= "(`" . $unchamps . "` like '%' or `" . $unchamps . "` is null ) and ";
            } elseif ($_GET[$temp] == '') // pas de % dans ce cas
            {
                $reqsql .= "(`" . $unchamps . "` = '' or `" . $unchamps . "` is null ) and ";
            } else {
                if (in_array($unchamps, $liste_champs_filtre_partiel)) {

                    $reqsql .= $liste_champs_filtre_partiel_traitement[$unchamps] . " like '" . $_GET[$temp] . "%' and ";
                } elseif (in_array($unchamps, $liste_champs_dates)) {

                    $reqsql .= $unchamps . " like '" . versmysql_Datetime($_GET[$temp]) . "%' and ";
                } elseif (in_array($unchamps, $liste_champs_filtre_partiel_motcles)) {

                    $reqsql .= $unchamps . " like '%" . $_GET[$temp] . "%' and ";
                } else {
                    // si on a &#039; dans un champ de recherche ( quote transformé en tête de script ) dans un des champs de rech
                    // ( et comme on peut avoir dans le champ les 2 variantes  quote ou &#039; )
                    // pour la requête sql on cherche à la fois sur  quote (\') et 	&#039;
                    if (stripos($_GET[$temp], "&#039;") !== false) {
                        $temprech = str_replace("&#039;", "\'", $_GET[$temp]);
                        $reqsql .= "(`" . $unchamps . "` like '" . $temprech . "%' or `" . $unchamps . "` like '" . $_GET[$temp] . "%') and ";
                    } else {
                        $reqsql .= "`" . $unchamps . "` like '" . $_GET[$temp] . "%' and ";

                    }

                }
            }

        }
        $reqsql .= "1";

        $where = $reqsql;
        if ($table2 == '') {
            $req = $connexion->query("SELECT $table.*" . $ajout_sql . " FROM  $table " . $where . " order by `" . $orderby . "` " . $sens);

            $reqfiltre = $table;
            //echo "SELECT $table.*".$ajout_sql." FROM  $table ". $where ." order by `".$orderby."` " .$sens ;
        } elseif ($table3 == '') {

            $req = $connexion->query("SELECT $table.*" . $sqlChampsTable2 . $ajout_sql . " FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` " . $where . "  order by `" . $orderby . "` " . $sens);
            $reqfiltre = $table . " LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ";
            //echo "SELECT $table.*".$sqlChampsTable2.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` ". $where ."  order by `".$orderby."` ".$sens;
        } elseif ($table_sup == '') {
            $req = $connexion->query("SELECT $table.*" . $sqlChampsTable2 . $sqlChampsTable3 . $ajout_sql . " FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  " . $where . " order by `" . $orderby . "` " . $sens);
            $reqfiltre = $table . " LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ";
            //echo "SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3`  ". $where ." order by `".$orderby."` ".$sens ;
        } else {
            // pour récupérer  les champs de la table_sup
            $req = $connexion->query("SELECT $table.*" . $sqlChampsTable2 . $sqlChampsTable3 . $sqlChampsTable_sup . $ajout_sql . " FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup` " . $where . " order by `" . $orderby . "` " . $sens);
            $reqfiltre = $table . " LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup`";
            //echo "SELECT $table.*".$sqlChampsTable2.$sqlChampsTable3.$sqlChampsTable_sup.$ajout_sql." FROM $table LEFT JOIN $table2 ON $table.`$cleetrangere2` = $table2.`$indexlien2` LEFT JOIN $table3 ON $table.`$cleetrangere3` = $table3.`$indexlien3` LEFT JOIN $table_sup ON $table.`$cleetrangere_sup` = $table_sup.`$indexlien_sup` ". $where ." order by `".$orderby."` ".$sens ;
        }

        $nombre = $req->rowCount();

        if ($nombre > 0) {
            echo "<center> <h2 style='margin-top: 0px ; background-color : #2b79b5 ; color : white ; padding : 8px ;text-transform: uppercase; font-size : 24px; font-weight:bold'>Liste des   ";
            echo $nombre;
//+++++
            echo " " . $texte_entite . "(s) pour l'année " . ($annee_courante - 1) . "-" . $annee_courante . "</H2>";
        } //
        else {
            echo "<center> <h2> ";
            echo " 0 " . $texte_entite . " actuellement dans la base</H2>";
        }

        if (in_array($loginConnecte, $login_autorises_ajout) or empty($login_autorises_ajout)) {
            echo "<A href=" . $URL . "?add=1&" . $filtrerech . " > Ajouter un enregistrement </a><br>";
        }
        echo "<a class='abs' href=" . $pageaccueil . ">Revenir à l'Accueil</a>";
        echo "<BR><table class='table1'> ";
//+++++++++++++++++++++++++++++++++++++++++++++++++
        echo "<br>le nom des élèves avec 3 absences ou plus dans l'année scolaire apparait en <b style='background-color : orange ; padding:4px ; color : white'>orange</b> </center>";
        echo "<br>les abences actuellement en cours apparaissent en <b style='background-color :  lightblue  ; padding:4px ; color : white'>bleu</b>  </center>";
//+++++++++++++++++++++++++++++++++++++++++++++++++

        echo "<br><br>Vous pouvez changer l'ordre de tri initial en cliquant sur les entêtes des colonnes </center>";
        if (sizeof($liste_champs_filtre) > 0) {
            echo "<br>Vous pouvez filtrer le tableau sur certaines colonnes en sélectionnant une valeur dans le menu filtre </center>";
        }
        if (sizeof($liste_champs_filtre_partiel_motcles) > 0) {
            echo "<br>Vous pouvez filtrer le tableau sur certaines colonnes en saisissant le texte recherché dans la zone prévue (pour tout reprendre laissez vide et validez) </center>";
        }
        echo "<BR><BR><table class='table1' >";

        echo "<FORM  action=" . $_SERVER['PHP_SELF'] . " method=GET name='monform'> ";

        //on passe tous les arg reçus en get  en hidden sauf mod et add
        foreach ($_GET as $x => $ci2) {
            if ($x != 'add' and $x != 'mod') {
                echo "<input type='hidden' name='" . $x . "' value=\"" . $ci2 . "\">\n";
            }
        }
        foreach ($liste_champs_tableau as $unchamps) {
            if (in_array($unchamps, $liste_champs_filtre)) {
                $temp = $unchamps . '_rech';
                if (in_array($unchamps, $liste_champs_filtre_partiel)) {
                    echo affichemenusqlplustous('', $temp, $unchamps, "select distinct " . $liste_champs_filtre_partiel_traitement[$unchamps] . " as $unchamps from " . $reqfiltre . " " . $where . " order by `" . $unchamps . "`", $unchamps, $$temp, $connexion, '', 'tous', "onchange='submit()'");

                } elseif (in_array($unchamps, $liste_champs_filtre_partiel_motcles)) {
                    //+++++++++++++++++++++++++++++++++++++++
                    echo affichechamp('Saisissez le texte recherché et validez ', $temp, $$temp, 30, '', '', '', '', 'tous', "onchange='submit()'");;
                    //affichechamp ($titre,$champ,$valeur,$taille=30,$ro='',$maj='',$coteacote='',$colospan='',$nc='',$js='',$id='')
                    //echo"     <input type ='submit' name='bouton_recherche'  value='OK'> <br> "  ;
                    //+++++++++++++++++++++++++++++++++++++++
                } elseif (in_array($unchamps, $liste_champs_dates)) {
                    echo affichemenusqlplustous('', $temp, $unchamps, "select distinct DATE_FORMAT(" . $unchamps . ",'%d/%m/%Y') as  '" . $unchamps . "' from " . $reqfiltre . " " . $where . " order by `" . $unchamps . "`", $unchamps, $$temp, $connexion, '', 'tous', "onchange='submit()'");
                    //on transforme les dates sql en dd/mm/yy
                } else {
                    echo affichemenusqlplustous('', $temp, $unchamps, "select distinct " . $unchamps . " from " . $reqfiltre . " " . $where . " order by `" . $unchamps . "`", $unchamps, $$temp, $connexion, '', 'tous', "onchange='submit()'");
                }
            } else {
                echo "<td></td>";
            }

        }
        echo "<td></td>";
        echo "</tr><tr>";
        echo "</FORM>";
        //dans l'ordre on regarde le tableau des libelles, puis le commentaire sql sinon on prend le nom du champs
        foreach ($liste_champs_tableau as $unchamps) {
            if (!array_key_exists($unchamps, $liste_libelles_tableau)) {
                if ($comment[$unchamps] != '') {
                    $commentaire = $comment[$unchamps];
                } else {
                    $commentaire = $unchamps;
                }
            } else {
                $commentaire = $liste_libelles_tableau[$unchamps];
            }


            if ($enteteplus)
                echo afficheenteteplus($commentaire, $unchamps, $_GET['env_orderby'], $_GET['env_inverse'], $filtrerech, $URL);
            else
                echo afficheentete($commentaire, $unchamps, $_GET['env_orderby'], $_GET['env_inverse'], $filtrerech, $URL);
        }

        // pour les champs tableau sup on affiche pas les entetes cliquables (pas de possibilité
        //de changer l'ordre dans la requête sql
        foreach ($liste_champs_tableau_sup as $unchamps) {
            if (!array_key_exists($unchamps, $liste_libelles_tableau)) {
                $commentaire = $unchamps;
            } else {
                $commentaire = $liste_libelles_tableau[$unchamps];
            }
            echo "<th>$commentaire</th>";
        }
        // pour la colonne actions
        echo "<td><center>Action</center></td>";
//on initialise  $csv_output
        $csv_output = "";
        //pour l'export en totalité au cas ou
        for ($i = 0; $i < sizeof($champs); $i++) {
            $csv_output .= nettoiecsvplus($champs[$i]);
        }
        $csv_output .= "\n";
//pour le changement de couleur
        $sauvChamp = '';
        $compte = 0;
        $bgcolor = '';

        while ($u = $req->fetch(PDO::FETCH_OBJ)) {
            //on fait une boucle pour créer les variables issues de la table
            foreach ($champs as $ci2) {
                if (in_array($ci2, $liste_champs_dates)) {
                    //on transforme les dates sql en dd/mm/yy
                    $$ci2 = mysql_DateTime($u->$ci2);
                    $csv_output .= nettoiecsvplus(mysql_DateTime($u->$ci2));
                } elseif (in_array($ci2, $liste_champs_heures)) {
                    $$ci2 = $u->$ci2;
                    //on transforme les heures sql en hh:mm pour l'export
                    $csv_output .= nettoiecsvplus(mysql_Type_Time($u->$ci2));
                } elseif (!in_array($ci2, $liste_champs_tableau_sup)) {
                    $$ci2 = $u->$ci2;
                    $csv_output .= nettoiecsvplus($$ci2);
                } else {
                    $$ci2 = getInfosLigneTable($getinfotable[$ci2], $connexion, $u->{$getinfovariablevaleur[$ci2]}, $getinfochampindex[$ci2])[$ci2];
                    $csv_output .= nettoiecsvplus($$ci2);
                }
            }
            $csv_output .= "\n";
            //on surcharge les dates pour les pbs de format
            //on récupère les champs liés
            // on ecrit chaque ligne

            // pour faire changer la couleur de la ligne si répetition
            if ($seuil_changement_couleur > 0) {
                if ($sauvChamp == $$champrepetition) {
                    $compte++;
                    if ($compte >= $seuil_changement_couleur) {
                        $bgcolor = $couleur_changement;
                    }

                } else {
                    $compte = 0;
                    $bgcolor = '';
                    $sauvChamp = $$champrepetition;
                }
            }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            if ($compteabsences[$code_etud] >= 3 and ($statut_absence == 6 or $statut_absence == 1)) {
                $tdcolor = ' orange ';
                $tdtitle = 'Cet élève a 3 absences ou plus pour cette année scolaire';
                $number_3_abs[] = getEtudiantByNumer($pdo, $code_etud);

            } //elseif ($compteabsences[$code_etud]>=3)$bgcolor=' orange ';
            else {
                $tdcolor = '';
                $tdtitle = '';
            }

// absence active
            if ($u->date_debut <= date('Y-m-d 00:00:00') and $u->date_fin >= date('Y-m-d 00:00:00')) {
                $tdcolor = ' lightblue ';
                $tdtitle = 'Cet élève est absent aujourd\'hui';
            }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            echo "   <tr bgcolor='" . $bgcolor . "' >";
            foreach ($liste_champs_tableau as $colonne) {
                if ($colonne == 'Nom') {
                    echo "<td bgcolor='" . $tdcolor . "' title=\"" . $tdtitle . "\" >";
                    echo "<a class='abs' href=fiche.php?code=" . $code_etud . ">" . echosur($$colonne) . "</a>";
                } else {
                    echo "<td>";
                    echo echosur($$colonne);
                }
                echo "   </td>";
            }
            foreach ($liste_champs_tableau_sup as $colonne) {
                echo echosur($$colonne);
                echo "   </td><td>";
            }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            if (in_array($loginConnecte, $login_autorises_suppression) or empty($login_autorises_suppression)) {
                echo " <A href=" . $URL . "?del=" . $$cleprimaire . "&" . $filtrerech . " onclick=\"return confirm('Etes vous sûr de vouloir supprimer cet enregistrement ?')\">";
                echo "sup</A> - ";
            }
            if (in_array($loginConnecte, $login_autorises_modif) or empty($login_autorises_modif)) {
                echo "<A href=" . $URL . "?mod=" . $$cleprimaire . "&" . $filtrerech . " >Mod</A>";
            } elseif (in_array($loginConnecte, $login_autorises_details) or empty($login_autorises_details)) {
                echo "<A href=" . $URL . "?mod=" . $$cleprimaire . "&" . $filtrerech . " >Détails</A>";
            }
            echo "</td> </tr>";
        }
        //pdo
        $req->closeCursor();
        if (in_array($loginConnecte, $login_autorises_export) or empty($login_autorises_export)) {
            echo "<FORM  action=export.php method=POST name='form_export'> ";
            echo "<input type=hidden name=csv_output value='" . urlencode($csv_output) . "'> ";
            echo "     <input type ='submit' name='bouton_export'  value='Export vers EXCEL'> <br> ";
            echo "</form>";
        }


        echo "</table> ";

    }


    $number_3_abs2 = array_unique($number_3_abs);
    $cachePool = new FilesystemAdapter();
    $cachePool->deleteItem('count_abs_3_cache_');

    $count_abs_3 = $cachePool->getItem('count_abs_3_cache_');
    if (!$count_abs_3->isHit()) {

        $count_abs_3->set(serialize($number_3_abs2));
        $cachePool->save($count_abs_3);
    }


    if (!$pdo)
        mysql_close($connexion);
    require('footer.php');

}else {

    echo('THIS PAGE EXECUTE ONLY CLI COMMAND - ');
    echo('<br/>Le service GI-DEV vient d etre informer de votre localisaion ...<hr>');
    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".getRealIpAddr());
    echo $xml->geoplugin_countryName ;

    echo "<pre>";
    foreach ($xml as $key => $value)
    {
        echo $key , "= " , $value ,  " \n" ;
    }
    echo "</pre>";

}


?>
</body>
</html>
