<?php
	 if (session_status() === PHP_SESSION_NONE) {
		    session_set_cookie_params(3600 * 24 * 15);
			session_start();
	}
	 // $_SESSION['doubleAuth'] = true ; 
	 // $_SESSION['doubleAuth'] = null ; 


if ( !isset($_SESSION['doubleAuth'] )   ) {
    require('./totpSecureBundle/totp.php') ;
    die() ;
}

?>


<!DOCTYPE html>
<html>
<head>
<title>Accueil Base Elèves 2024/2025</title>
<link rel="icon" type="image/x-icon" href="/eleves/favicon.ico">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="generator" content="HAPedit 3.1">
<SCRIPT TYPE="text/javascript" SRC="filterlist.js"></SCRIPT>
<link href="https://fonts.cdnfonts.com/css/roboto-condensed" rel="stylesheet">
<script src="https://cdn.tiny.cloud/1/0jfms96dp9ogy09v3b1oqocpr5sduvs7wgnmscghwojaca93/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<style>

.table1 tr:nth-child(3n) {
  background-color:#f5f5f5
}

#link-content{
	background-repeat: repeat-x;
	background-image: url("data:image/svg+xml,%3csvg stroke='rgb(43, 121, 181,0.40)' xmlns='http://www.w3.org/2000/svg' version='1.1' xmlns:xlink='http://www.w3.org/1999/xlink' xmlns:svgjs='http://svgjs.dev/svgjs' width='2000' height='350' preserveAspectRatio='none' viewBox='0 0 2000 350'%3e%3cg mask='url(%26quot%3b%23SvgjsMask1032%26quot%3b)' fill='none'%3e%3crect width='2000' height='350' x='0' y='0' fill='rgba(39%2c 135%2c 195%2c 0.2)'%3e%3c/rect%3e%3cpath d='M 0%2c308 C 100%2c264.6 300%2c116.4 500%2c91 C 700%2c65.6 800%2c169.6 1000%2c181 C 1200%2c192.4 1300%2c119.2 1500%2c148 C 1700%2c176.8 1900%2c289.6 2000%2c325L2000 350L0 350z' fill='rgba(255%2c 255%2c 255%2c 1)'%3e%3c/path%3e%3c/g%3e%3cdefs%3e%3cmask id='SvgjsMask1032'%3e%3crect width='2000' height='350'  fill='white'%3e%3c/rect%3e%3c/mask%3e%3c/defs%3e%3c/svg%3e");
}	

		
</style>
                
<?php

require_once './vendor/autoload.php';
require ("style.php");
require ("param.php");
require ("function.php");

$container = require __DIR__."/src/container.php" ;
 

/*
if( $_GET['env'] != 'dev' ) {
echo "<h1 style='font-size:35px;color:red;text-align:center'>SITE EN MAINTENANCE POUR LA BASCULE 2023/2024... </h1>" ;
echo "<center>Pour accèder à l'ancienne base, cliquer sur <a href='https://web.gi.grenoble-inp.fr/eleves2022/'> Ancienne base 2022/2023 </a></center>" ; 
exit() ;
}
*/ 

echo "</HEAD><BODY>" ; ?>


    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "290px";
            document.getElementById('link-content').remove();
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById('link-content').style.visibility = "visible";
        }
    </script>

    <?php
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

    use Bundles\AppBundle\Entity\Etudiants;
    use Bundles\AppBundle\Entity\LigneGroupe;
    use Doctrine\ORM\Query\Expr\Join;
    use Symfony\Component\Cache\Adapter\FilesystemAdapter;
    $cachePool = new FilesystemAdapter(
    $namespace = '',
    $defaultLifetime = 0,
    $directory = "/var/www/html/giqualite/symfony-cache/"
);

require('header.php');
$liste_champs_dates=array();
$liste_champs_dates_courts=array('date_diplome');
$liste_champs_dates_longs=array();
if (!isset($_GET['annee'])) $_GET['annee']='';
if (!isset($_GET['orderby'])) $_GET['orderby']='';
if (!isset($_GET['nom_recherche'])) $_GET['nom_recherche']='';
if (!isset($_GET['recherche_avance'])) $_GET['recherche_avance']='';
if (!isset($_GET['options'])) $_GET['options']='';
if (!isset($_GET['bouton_ok'])) $_GET['bouton_ok']='';
if (!isset($_GET['bouton_annul'])) $_GET['bouton_annul']='';
if (!isset($_GET['code_groupe'])) $_GET['code_groupe']='';
if (!isset($_GET['code_groupe_peda'])) $_GET['code_groupe_peda']='';
if (!isset($_GET['code_etu_recherche'])) $_GET['code_etu_recherche']='' ;
if (!isset($_GET['forceFormulaireMail'])) $_GET['forceFormulaireMail']='' ;

if (!isset($_GET['mon_champ'])) $_GET['mon_champ']='';
if (!isset($_GET['inverse'])) $_GET['inverse']='';
if (!isset($_GET['impression'])) $_GET['impression']='';
if (!isset($_POST['bouton_env'])) $_POST['bouton_env']='';

//on remet en GET le filtre passé en POST depuis le formaulaire mail

set_time_limit(120);

    /**
     * stat
     */

    $entityManager = $container->get('_em') ;
    $queryBuilder = $entityManager->createQueryBuilder();

    $queryBuilder->select("et.codeEtape,et.libEtape,cc.codeGroupe , count(et.libEtape) as nombre")
        ->from( LigneGroupe::class , 'cc')
        ->leftJoin(Etudiants::class , 'et' ,  Join::WITH, 'cc.codeEtudiant = et.codeEtu')
        ->where("cc.codeGroupe = '4483' ")
        //->setParameter('code',  4483 )
        ->groupBy('et.libEtape')
        ->orderBy('et.libEtape' , 'ASC' )
    ;

    $query = $queryBuilder->getQuery();
    $results  =  $query->execute();

    $dataPoints = [] ;

    foreach ( $results as $result ) {

        $dataPoints[]  = array(
            'indexLabel' => $result['codeEtape'] ,
            'y'          => $result['nombre'] ,
        ) ;
    }

    $label = array() ;
    $data  = array() ;
    $total__ = 0 ;

    foreach ( $dataPoints as $key=>$value ) {
        $label[]  = $value['indexLabel'] ;
        $data[]   = (int) $value['y'] ;
        $total__ = $total__ + (int) $value['y'] ;
    }

    $label = json_encode($label);
    $data = json_encode($data);


//a cause des apostrophes ds les champs transmis par url
$_GET['code_etu_recherche']=stripslashes($_GET['code_etu_recherche']);
$_GET['nom_recherche']=trim(stripslashes($_GET['nom_recherche'])) ;
$table='etudiants';
$j=0;
$mode="liste";
$listeoffi='';
$gpetitre='';
$gpetitresansade='';

//on remplit 1 tableau avec les libelle-code  departements
$sqlquery2="SELECT * FROM departements ";
//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion );
while ($v=mysql_fetch_array($resultat2))
	{

	$libelleDep[$v["dep_code"]]=$v["dep_libelle"] ;
	}

//on cree un tableau $champs[] avec les noms des colonnes de la table universite et leur taille

$champs=champsfromtable($table);

//on parcourt ce tableau pour creer les variables compatibles avec le pb des espaces dans les noms de champs
foreach($champs as $ci){
$ci2="my".str_replace(" ","_",strtolower($ci));
 $$ci2=$ci;
}
//pb des espaces ds les noms de champs ds mysql
$mycode_etu='Code etu';
$myprenom_1='Prénom 1';
$mymail_effectif='mail effectif';
$mycode_etape='Lib étape';
$mypays_dept_naiss='Pays/dept naiss';
$mynationalite='Nationalité';

$champstype=(champstypefromtable($table));

$champs[]="annee";
$champs[]="redoublant";
$champs[]="admis_sur_titre";
$champs[]="date_diplome";
sort ($champs);
//si on arrive ici apres avoir choisi un groupe on efface le champ de recherche
//if ($_GET['code_groupe_peda'] !='TOUS'){
//$_GET['code_etu_recherche']='' ;
//}
$self=$_SERVER['PHP_SELF'];
$photolocal =$chemin_local_images."logo.gif";
list($largeur,$hauteur,$type,$attribut) = getimagesize($photolocal);
$haut=($hauteur/$largeur)*110 ;
//$auth2=explode("\\",$_SERVER['AUTH_USER']);
#$where=" where proprietaire = '".$_SERVER['AUTH_USER'] ."' or visible = 'oui' order by groupe_officiel desc,upper(libelle),proprietaire";
// pour la scol

if (in_array ($login ,$scol_user_liste ))
{
// il n'y a que la scol qui voit les gpes constitutifs
$where=" where   (  login_proprietaire= '".$login."' or groupe_officiel = 'oui'  or visible = 'oui' )   order by groupe_officiel desc  ,type_gpe_auto,visible desc,archive,upper(concat(arbre_gpe,libelle)),proprietaire";
}
elseif (in_array ($login ,$archive_user_liste ))
{
// eux peuvent voir  les groupes archives mais pas les groupes scol
$where=" where   (  login_proprietaire= '".$login."' or groupe_officiel = 'oui'  or visible = 'oui' ) and type_gpe_auto!='scol' order by groupe_officiel desc  ,type_gpe_auto ,visible desc,archive,upper(concat(arbre_gpe,libelle)),proprietaire";
}
else
{
// pour les autres
$where=" where  (  login_proprietaire= '".$login."' or visible = 'oui' ) and archive !='oui' and type_gpe_auto!='scol'  order by groupe_officiel desc  ,type_gpe_auto,visible desc,archive,upper(concat(arbre_gpe,libelle)),proprietaire";
}
 //                                      on remplit 2 tableaux avec les nom-code  groupes visibles
$sqlquery2="SELECT groupes.* FROM groupes ".$where;
//echo $sqlquery2;
//$sqlquery2="SELECT * FROM groupes  order by libelle";
$resultat2=mysql_query($sqlquery2,$connexion );
while ($v=mysql_fetch_array($resultat2)){
$ind=$v["libelle"] ;
$ind2=$v["code"];
$groupe_visible[$ind2]=$v["visible"];
$groupe_libelle[$ind2]=$v["libelle"];
$groupe_proprio[$ind2]=$v["login_proprietaire"];
$groupe_offi[$ind2]=$v["groupe_officiel"];
$groupe_liste[$ind2]=$v["liste_offi"];
$groupe_nomliste[$ind2]=$v["nom_liste"];
$groupe_titre_affiche[$ind2]= $v["titre_affiche"]  ;
$groupe_titre_special[$ind2]=$v["titre_special"];
$groupe_code_ade[$ind2]=$v["code_ade"];
$groupe_code_ade6[$ind2]=$v["code_ade6"];
$groupe_gpe_evenement[$ind2]=$v["gpe_evenement"];
//$groupe_feuille_ade[$ind2]=$v["feuille_ade"];
$groupe_type_auto[$ind2]=$v["type_gpe_auto"];
$groupe_const[$ind2]=$v["libelle_gpe_constitutif"];
$groupe_arbre[$ind2]=$v["arbre_gpe"];
$groupe_archive[$ind2]=$v["archive"];
$groupe_url_direct[$ind2]=$v["url_edt_direct"];
$groupe_code[$ind]=$v["code"];
}
//sort($groupe_titre_affiche);
//traitement du cas  pour impression NE SERT PLUS
if ($_GET['impression'] !='oui'){
echo "<table  border=0 width=100%>";
//echo "<img src=".$chemin_images."logo.gif  width=110  height=$haut>";

echo "<td valign=top align=left>";
if ($login!='administrateur')
{
$temp= ask_ldap($login,'displayname');
$prenom_connecte=$temp[0];
// suite aux pbs ldap aD
//$prenom_connecte=$login;
}
else
{
$prenom_connecte='Chef';
}


//echo  "Bonjour  <b> ". $prenom_connecte . ",</b><br>" ;

if( $_SERVER['SERVER_NAME'] == "localhost" ) {
    echo "<h1 style='margin-top:-11px;font-family :Roboto Condensed; text-align:center ; background-color : #d72f2f ; color : white ; padding : 10px ;text-transform: uppercase; font-size : 50px; font-weight:bold'><img id='loader' src='./icons/ajax3.gif' style='width:32px;'/> *Base des élèves $annee_accueil </h1> ";
}else{
	    //echo "<h1 style='margin-top:-11px;font-family :Roboto Condensed; text-align:center ; background-color : #f57d11 ; color : white ; padding : 10px ;text-transform: uppercase; font-size : 50px; font-weight:bold'><img id='loader' src='./icons/ajax3.gif' style='width:32px;'/> *Base des élèves $ecole $annee_accueil </h1> ";
        echo "<h1 style='font-size: 49px;  margin-bottom: 34px;margin-top: -98px;font-family :Roboto Condensed; text-align:center ; background-image: linear-gradient(#1e5f80, #1e5f80) ; color : white ; padding : 5px ;text-transform: uppercase; font-weight:bold'><img id='loader' src='./icons/ajax3.gif' style='width:32px;'/> <i class='fas fa-graduation-cap' style='color:white'></i>  Base élèves $annee_accueil </h1>";
}


    $prov = "SELECT `Nom usuel` as nom , `Prénom` 
    FROM `imp_annu`
    WHERE ( `Statut` LIKE '%PROV%' ) AND Types LIKE '%E%' " ;
        $count_prov = 0 ;

        $resultprov=mysql_query($prov,$connexion );
        $prov_message = "" ;

        while ($ab=mysql_fetch_object($resultprov))
        {

            $prov_message = $prov_message ." <spane style='color: #f7ce00'> $ab->nom </spane> $ab->Prénom <br/>" ;
            $count_prov++ ;
        }


	

    $count1=mysql_query("SELECT COUNT(*) AS count1 FROM `etudiants` WHERE `Année Univ` = '$anneeRefens'",$connexion );
    $count1_ = 0 ;

    $count2=mysql_query("SELECT COUNT(*) AS count2 FROM `enseignants` where nom != 'NC' ",$connexion );
    $count2_ = 0 ;

    $count3=mysql_query("SELECT COUNT(*) AS count3 FROM `cours`",$connexion );
    $count3_ = 0 ;

    $query = "SELECT count(*) as count4 FROM absences LEFT JOIN etudiants ON absences.`code_etud` = etudiants.`Code etu` LEFT JOIN absences_statuts ON absences.`statut_absence` = absences_statuts.`absences_statuts_code` LEFT JOIN etudiants_scol ON absences.`code_etud` = etudiants_scol.`code` where date_debut > '$anneeRefens-08-31' and statut_absence !=2 and statut_absence !=5 and statut_absence !=3 and statut_absence !=6 and statut_absence !=7 and statut_absence !=8 and statut_absence !=9 and statut_absence !=10 and (Nom like '%' or Nom is null ) and (annee like '%' or annee is null ) and (code_etud like '%' or code_etud is null ) and (absences_statuts_texte like '%' or absences_statuts_texte is null ) and (mot_cle like '%' or mot_cle is null )";
    $count4=mysql_query($query ,$connexion );
    $count4_ = 0 ;

    $count5_ = 0 ;
    $entAttente = "SELECT count(*) as count5 FROM absences LEFT JOIN etudiants ON absences.`code_etud` = etudiants.`Code etu` LEFT JOIN absences_statuts ON absences.`statut_absence` = absences_statuts.`absences_statuts_code` LEFT JOIN etudiants_scol ON absences.`code_etud` = etudiants_scol.`code` where date_debut > '$anneeRefens-08-31' and statut_absence !=2 and statut_absence !=5 and statut_absence !=3 and statut_absence !=6 and statut_absence !=7 and statut_absence !=8 and statut_absence !=9 and statut_absence !=10 and (Nom like '%' or Nom is null ) and (annee like '%' or annee is null ) and (code_etud like '%' or code_etud is null ) and (absences_statuts_texte like '%' or absences_statuts_texte is null ) and (mot_cle like '%' or mot_cle is null ) and ( absences_statuts_texte ='en attente' )  ;";
    $count5=mysql_query($entAttente ,$connexion );

    $v1=mysql_fetch_array($count1) ;
    {
        $count1_ =  $v1["count1"] ;
    }

    $v2=mysql_fetch_array($count2) ;
    {
        $count2_ =  $v2["count2"] ;
    }


    $v3=mysql_fetch_array($count3) ;
    {
        $count3_ =  $v3["count3"] ;
    }


    $v4=mysql_fetch_array($count4) ;
    {
        $count4_ =  $v4["count4"] ;
    }


    $v5=mysql_fetch_array($count5) ;


    {
        $count5_ =  $v5["count5"] ;
    }


    ?>

<div class="wrapper">




    <?php
    if ($count_prov > 0  ) { ?>
        <div class="box b" id='websiteavis1' style='background-color:#165964 ; color : white; animation: blink 0.8s;animation-iteration-count:infinite;border:4px #0b899d solid;' > &#9203; Chargement ... </div>
        <?php
    }
    ?>

    <?php
    if ($count_prov < 0  ) { ?>
        <div class="box b" id='websiteavis1' style='background-color:#17a2b8 ; color : white;' > &#9203; Chargement ... </div>
        <?php
    }
    ?>


    <?php
    if ( $count5_ <= 0  ) { ?>
        <div class="box a" id='websiteavis1' style='background-color:#17a2b8 ; color : white ;' > &#9203; Chargement ...</div>
    <?php }

    ?>


  <div class="box a" id='websiteavis5' style='background-color:#17A2B8 ; color : white' > &#9203; Chargement ...</div>
  <div class="box b" id='websiteavis2' style='background-color:#ffc107 ; color : black' > &#9203; Chargement ... </div>
  <div class="box b" id='websiteavis3' style='background-color:#dc3545 ; color : white' > &#9203; Chargement ... </div>


    <?php
            if ($count5_ > 0 && $count5_ > 9  ) { ?>
                <div class="box b" id='websiteavis4' style='background-color:#28a745 ; color : white; animation: blink 0.8s;animation-iteration-count:infinite;border:4px #2b6840 solid;' > &#9203; Chargement ... </div>
     <?php
            }
     ?>


    <?php
    if ( $count5_ <= 9  ) { ?>
        <div class="box b" id='websiteavis4' style='background-color:#28a745 ; color : white;' > &#9203; Chargement ... </div>
        <?php }

    ?>



</div>


    <div class="container">
        <div class="marquee" style='background-color: #82fa9d !important;color:black'>
            <div>
                <b style="background-color: GREEN  ; padding: 4px ; opacity: 0.8 ; border-radius: 4px ;"> <span style="color: red ; font-size: 15px;">&#9888; </span> * INFORMATION : </b> 16/07/24 12h32 >  BASCULE BASE ELEVE/SI/ADE/REFENS/TRIODE EST TERMINEE.   
            </div>
        </div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.bundle.js"></script>
    <script src="https://kit.fontawesome.com/743629b881.js" crossorigin="anonymous"></script>

    <span style='font-size:30px; font-weight:bold ; cursor:pointer ; color: #2b79b5 ;' onclick='openNav()'>&#9776; MENU></span>
    <div id="mySidenav" class="sidenav">

        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="font-size: 60px">&times;</a><
        <a href='#' style="text-align: center ;"> <img src="https://web.gi.grenoble-inp.fr/eleves/icons/favicon.ico"/></a>" ;
        <a href='#' style="text-align: center ;"> </a>" ;

        <?php
		
		    
        
            echo "<a href=# style='background: #ffb327 ; color:#e12727 ; border-radius: 5px ; width:267px ; text-align: center'> <i class='fa fa-database' aria-hidden='true'></i> $dsn</a>";
            echo  "<a  href='https://web.gi.grenoble-inp.fr/eleves2022'> <i class='fa fa-home'></i> Archive BE 2022/2023</a>";
			
        ?>

        <?php
		
		
        if(in_array ($login ,$ipid_user_liste )){
            echo "<a href=offresapprentissage.php> <i class='fa fa-circle' aria-hidden='true'></i>Terrains apprentissage</a>";
        }

        echo  "<a href=groupes.php> <i class='fa fa-user' aria-hidden='true'></i> Gestion des groupes</a>";
        echo  "<a href=https://e-stages.grenoble-inp.fr/><i class='fa fa-graduation-cap' aria-hidden='true'></i>
e-Stages</a>";

        if(in_array ($login ,$re_user_liste )){
            echo  "<a href=stages.php><i class='fa fa-circle' aria-hidden='true'></i>Archives stages (&#8594; 2011)</a>";
            echo "<a href=entreprises.php>    <i class='fa fa-sliders' aria-hidden='true'></i> Gestion des entreprises (&#8594; 2011) </a>";}
            echo "<a href=etud_accueil.php >    <i class='fa fa-graduation-cap' aria-hidden='true'></i>
 Cours des étudiants en accueil</a>";
        if(in_array ($login ,$re_user_liste ) or in_array ($login ,$scol_user_liste )) {
            echo "<a href=enseignants.php><i class='fa fa-sliders' aria-hidden='true'></i>Gestion des personnels</a>";}
        if((in_array ($login ,$re_user_liste )) or (in_array ($login ,$scol_user_liste )) or (in_array ($login ,$accueil_user_liste ))){
            echo "<a href=scol.php> <i class='fa fa-sliders' aria-hidden='true'></i>Gestion de scolarité-Badges</a>";}
        if( in_array ($login ,$scol_user_liste )) {
            echo "<a href=absences/absences_gest.php>    <i class='fa fa-folder-open' aria-hidden='true'></i>
 Gestion des absences -scol-</a>";
            echo "<a href=portedocument/index.php>   <i class='fa fa-folder-open' aria-hidden='true'></i> Gestion des porte-documents </a>";
        }
        elseif( in_array ($login ,$de_user_liste )) {
            echo "<a href=absences/absences_de.php>    <i class='fa fa-sliders' aria-hidden='true'></i>
 Gestion des absences -DE-</a>";}
            echo "<a href=listeabsences.php><i class='fa fa-list-alt' aria-hidden='true'></i>Liste absences </a>";
            //echo "<a href='/eleves/absences/absences_comm.php'><i class='fa fa-list-alt' aria-hidden='true'></i>Liste absences commun</a>";
 
  
		//if(in_array ($login ,$de_user_liste )){
			 // echo "<a href='#'>[new] Validation des absences</a>";
		//}

        echo "<a href=accueil_international.php> <i class='fa fa-plane' aria-hidden='true'></i> Départs à l'étranger</a>";
        echo "<a href=eleve_acteur/index.php><i class='fa fa-circle' aria-hidden='true'></i>Expériences Elève acteur</a>";
        echo "<a href=configvoeux.php><i class='fa fa-circle' aria-hidden='true'></i>Campagnes de voeux</a>";
        echo "<a href=accueil_stats.php><i class='fa fa-calculator' aria-hidden='true'></i>
Tableaux de bord-Indicateurs</a>";

        ?>

    </div>

<?php

#echo "<font color='red' size='4' >Attention coupure électrique : pas d'accès possible samedi 22 janvier </font>";
echo "<div  id='link-content' style=' ; padding-left : 151px; margin-top:-40px ; min-height: 210px ;padding-bottom: 5px'>";

?>

    <div class="doughnut2" style=" min-width: 400px !important; float: right ; margin-top: 10px">
        <div class="doughnutChartContainer2"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
            <canvas id="myChart2" style="width: 400px; height:  100%;"></canvas>
        </div>
    </div>

    <div class="doughnut" style=" min-width: 450px !important; float: right ; margin-top: 10px">
        <div class="doughnutChartContainer"><iframe class="chartjs-hidden-iframe" style="width: 80%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
            <canvas id="myChart" style="height:  100%;"></canvas>
        </div>
    </div>

    <?php


echo "<br><i class='fa-solid fa-file-zipper'></i> Archive Base élèves <a target='_blank' href='https://web.gi.grenoble-inp.fr/eleves2023' style='background-color: #ffc107;
color: red;
padding: 2px;
border-radius: 4px;'> 2023/2024 </a><a target='_blank' href='https://web.gi.grenoble-inp.fr/eleves2022' style='background-color: #ffc107;
color: red; margin-left:2px;
padding: 2px;
border-radius: 4px;'> 2022/2023 </a>";

if(in_array ($login ,$ipid_user_liste )){
echo "<br>&#x1F4DA; <a href=offresapprentissage.php> terrains apprentissage</a>";
}
echo "<br>&#128295; <a href=groupes.php>    Gestion des groupes</a>";
//echo "<br><a href=stages.php>    Stages </a>";
echo  "<br>&#128309;  <a href=https://e-stages.grenoble-inp.fr/>e-Stages</a>";
//echo  "<br><a href=offres.php>Offres de stages</a>";
if(in_array ($login ,$re_user_liste )){
echo  "<br>&#128309; <a href=stages.php>Archives stages (&#8594; 2011)</a>";
echo "<br>&#x1F3E6; <a href=entreprises.php>    Gestion des entreprises (&#8594; 2011) </a>";}
echo "<br>&#x1F4DD; <a href=etud_accueil.php >    Cours des étudiants en accueil</a>";
if(in_array ($login ,$re_user_liste ) or in_array ($login ,$scol_user_liste )) {
echo "<br>&#128378; <a href=enseignants.php>    Gestion des personnels</a>";}

  if((in_array ($login ,$re_user_liste )) or (in_array ($login ,$scol_user_liste )) or (in_array ($login ,$accueil_user_liste ))){
echo "<br>&#9658; <a href=scol.php> Gestion de scolarité-Badges</a>";}
if( in_array ($login ,$scol_user_liste )) {
echo "<br>&#x1F505; <a href=absences/absences_gest.php>    Gestion des absences -scol-</a>";
echo "<br>&#128194; <a href=portedocument/index.php>    Gestion des porte-documents </a>";
}

if( in_array ($login ,$de_user_liste )) {
echo "<br> 	<i class='fa-solid fa-person-circle-question'></i>   <a href=absences/absences_de.php?tout=1><spane style='border-radius: 30px;font-size:10px;background-color:red;color:white;padding:3px'>Nouveau</spane>Gestion des absences -DE-</a>";}
echo "<br><i class='fa-solid fa-list'></i> <a href=listeabsences.php>Liste absences</a>";


//    echo "<br><i class='fa-solid fa-list'></i> <a href='/eleves/absences/absences_comm.php'>Liste absences commun</a>";

// var_dump($de_user_liste) ;



 if($login == 'administrateur'){
//echo "<br><a href=initannu.php> init annuaire</a>";
// inutile maintenant : car automatisé 07/02/2010
//echo "<br><a href=import.php> import apogee</a>";

}
  //seules les personnes autorisées ont acces à la liste
 //if(in_array($login,$ri_user_liste)){
echo "<br>&#x2708; <a href=accueil_international.php>Départs à l'étranger</a>";
echo  "<br>&#128309; <a href=eleve_acteur/index.php>Expériences Elève acteur</a>";
//}
// pour les liens administration des voeux
// $i=1;
// $temp="voeux_liste".$i;
// $tempbis="datefinvoeuxadmin".$i;
// while(isset($$temp)){
// if (in_array($login,$$temp) and diffdatejours($$tempbis)<0  ){
// $temp2="titrevoeux".$i;
// echo "<br><a href=voeuxadmin".$i.".php> ".$$temp2." (administrables jusqu'au ".$$tempbis.")</a>";
// }
// $i++;
// $temp="voeux_liste".$i;
// $tempbis="datefinvoeuxadmin".$i;
// }
echo "<br>&#128309; <a href=configvoeux.php>Campagnes de voeux</a>";
echo "<br>&#128202; <a href=accueil_stats.php>Tableaux de bord-Indicateurs</a>";


echo "</div>" ;
echo "</table>";
//si on a donne un nom on force le gpe TOUS
if ($_GET['nom_recherche'] !=''  ){
$_GET['code_groupe_peda']='TOUS';
}

echo  "<FORM  action=".$self." method=GET name='monform'> ";
echo "<div id='progress' style='height:4px;width:99.3%; margin-left: 6px;text-align: center ; margin-top: -5px ;'></div>";

echo "<table id='front' style='width:100% ; background-color: white ; border : 1px black solid ; border-radius: 4px ;'><tr><td> ";
echo "<b class='red'>Choisissez une condition :</b> </td>";
echo "</tr><tr >";

echo "</td><td>";
//si on est en recherche avancee on n'affiche pas la  boite de saisie du nom
if ($_GET['recherche_avance'] !='oui'){
echo "</td><td>";
// echo " Nom de l'élève commence par    <br>";

//si on a donné un nom et un gpe le nom est effacé
//if ($_GET['code_groupe_peda']!='TOUS'){$_GET['nom_recherche']='';}
echo" <input type='text' name='nom_recherche' style='width:90% ; height:30px;' placeholder='Nom de l`étudiant' value="."\"".$_GET['nom_recherche']."\""."> ";
echo "<input type ='submit' name='bouton_ok'  class='bouton_ok' value='OK'>  "  ;
}
echo "</td><td>";
echo "</tr><tr ><td colspan=3>";
echo "</tr><tr>";
echo "</td><td>";

 if($_GET["recherche_avance"]=="oui"){
 echo "<a class='titrePage' href=".$self."?recherche_avance=non>recherche simple</a>";
 //on remet la valeur ds le formulaire en cache pour la conserver
 echo "<input type=hidden name=recherche_avance value='oui'> ";

echo "</td><td>";
//echo "NOM  <input type='text' name='nom_recherche' size='20'>";
  if($_GET["mon_champ"]==""){
  $_GET["mon_champ"]="Nom";}
echo " <select name='mon_champ'  onchange='monform.submit()'>  ";
for($i=0;$i<sizeof($champs);$i++) {
    echo "  <option ";
    //pour la premiere fois
    if($_GET["mon_champ"]==$champs[$i]){
         echo "SELECTED";}
    echo">";
    echo  $champs[$i];
    echo"</option> " ;
    }
echo "</select> ";
//echo "</td><td>";
$temp= urldecode($_GET['mon_champ']);
 if (($temp=='annee') or ($temp=='redoublant') or($temp=='admis_sur_titre')or($temp=='date_diplome')){
 $sqlquery2="SELECT distinct `".$temp ."` FROM etudiants_scol  order by  `".$temp ."` desc";
 }
 else{
$sqlquery2="SELECT distinct `".$temp ."` FROM etudiants  where `".$temp ."` is not NULL order by  `".$temp ."` desc";
}
//echo $sqlquery2;
$resultat2=mysql_query($sqlquery2,$connexion );
//echo "commence par   <br> ";
//echo"     <input type ='submit' name='bouton_egal' value='est égal à'>  "  ;
echo "est égal à  ";
echo " <select name='code_etu_recherche'>  ";
while($r=mysql_fetch_object($resultat2)){
$valeur= $r->$temp;
if ($valeur==''){

 $valeuraffichee='vide';}
  else{
  $valeuraffichee=$valeur;
  }

 if (in_array($_GET["mon_champ"],$liste_champs_dates_courts)) {
$valeuraffichee=mysql_datetime($valeur);
}
 echo "  <option  value="."\"".$valeur."\"";
 //a cause des apotsrophes  dsles donnees apogee
 if(($_GET['code_etu_recherche'])==$valeur){
         echo "SELECTED";}
    echo  ">".$valeuraffichee."</option> ";
}
echo "<input type ='submit' name='bouton_ok'  value='OK'>  "  ;
  } //fin du if recherche avancee
  else {
   echo "<a class='titrePage' href=".$self."?recherche_avance=oui>Recherche Avancée&nbsp;&nbsp;&nbsp;</a>";
    echo "<input type=hidden name=recherche_avance value='non'> ";
  } //fin du else  recherche avancee
echo "</td><td>";
echo "</td><td>";
echo "</tr><tr>";
echo "<td >";
echo "</td><td>";
//echo" <input type='text' name='code_etu_recherche' size='20' value="."\"".$_GET['code_etu_recherche']."\""."> ";
echo "</td><td>";

echo "</tr><tr ><td colspan=3>";
 echo "</tr><tr >";
 echo "<td><b class='red'>Ou bien séléctionnez un groupe :</b>";
// $sqlquery2="SELECT distinct annee FROM etudiants_scol    order by  annee";
// $resultat2=mysql_query($sqlquery2,$connexion );
 // if($login == 'administrateur'  ){
// echo " <select name='annee'>  ";
// while($r=mysql_fetch_object($resultat2)){
// $valeur= $r->annee;
// if ($valeur==''){
  // $valeur='vide';}
 // echo "  <option  value=\"".$valeur."\" ";
    // echo  ">".$valeur."</option> ";
    // }
// echo "<option value='TOUS' selected> Sélectionnez un gpe principal</option>";
// echo "</select>";
// }
// else{
//echo "<input type=hidden name=annee value='TOUS'> ";
// }
 // echo "</td><td>";
echo "<input type=hidden name=annee value='TOUS'> ";
echo "</td><td>";


echo "<INPUT class='regexp' NAME=regexp onKeyUp='myfilter.set(this.value)' style='width:90%;height:30px;' placeholder='Nom du groupe/mot clé' >";
//echo "<input type=hidden name='bouton_ok'  value='OK'>  "  ;
echo" <select name='code_groupe_peda'  onchange='nom_recherche.value=null;monform.submit()' onkeypress='monform.submit()' style='width:90.30%;height:30px;margin-top:2px;' >  ";
 	echo  "  <option  value='TOUS'";
if ($_GET['code_groupe_peda']=='' or $_GET['code_groupe_peda']=='TOUS' or $_GET['nom_recherche']!=''){
echo " SELECTED  ";}
echo "> Aucun Groupe Sélectionné</option>";
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
 for($i=0;$i<sizeof($groupe_code);$i++) {
 //on ne garde que les groupes peda pas ceux du personnel  (proprio != admin)

 if (current($groupe_proprio)!="admin"){
      echo "  <option  value=\"".current($groupe_code)."\" ";
	  	if ($_GET['code_groupe_peda']==current($groupe_code)){
	echo " SELECTED";
	}
//si c'est un groupe officiel
// ancienne version on regardait aussi le nom du domaine
//list($domaine_prorio,$login_prorio)=explode("\\",current($groupe_proprio));

//if (current($groupe_proprio)==$scol_user_complet){

//if (in_array (strtolower($login_prorio) ,$scol_user_liste )) {
if (current($groupe_type_auto)=='edt') {
 $prop="- gpe COURS -";
    echo  " style=\"background-color:#F78181;\"> ".$prop.current($groupe_titre_affiche);
}

elseif(current($groupe_const)!= '')
	{
	 $prop=" - gpe Scol -";
    echo  " style=\"background-color:#F7FE2E;\"> ".$prop.current($groupe_libelle);
    }
	elseif(current($groupe_offi)== 'oui' )
		{
		if (current($groupe_archive)== 'oui' )
			{
			 $prop=" -- Gpe OFFICIEL ARCHIVE --";
		    echo  " style=\"background-color:#99FFCC;\"> ".$prop.current($groupe_libelle);
			}
			else
			{
			 $prop=" -- Gpe OFFICIEL --";
		    echo   " style=\"background-color:#CCFF00;\"> ".$prop.current($groupe_libelle);
		    }
		}
elseif(current($groupe_visible)== 'oui' )
	{
	 $prop=" - gpe Partagé -";
    echo  " style=\"background-color:#00FFFF;\"> ".$prop.current($groupe_libelle);
    }
elseif(current($groupe_archive)== 'oui' )
	{
	 $prop=" - gpe ARCHIVE -";
    echo  " style=\"background-color:#00FF99;\"> ".$prop.current($groupe_libelle);
    }
else{
	 $prop=" - gpe Privé -";
    echo   " style=\"background-color:#0099FF;\"> ".$prop.current($groupe_libelle)." ( ".current($groupe_proprio)." ) ";
    }

	echo "</option>";
    } //fin du if proprio != admin
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

echo "<SCRIPT TYPE='text/javascript'>";
echo "var myfilter = new filterlist(document.monform.code_groupe_peda)";
echo "</SCRIPT>";



  if((in_array ($login ,$re_user_liste )) or (in_array ($login ,$scol_user_liste ))  or (in_array ($login ,$power_user_liste )) ){
  $listeopt=array('tableau court','tableau complet','liste émargement','trombinoscope','liste mail','export totalité','export insc cours') ;
  }elseif(in_array ($login ,$accueil_user_liste )) {
  $listeopt=array('tableau court','tableau complet','liste émargement','trombinoscope','liste mail','liste badges') ;
  }
  else{
$listeopt=array('tableau court','tableau complet','liste émargement','trombinoscope','liste mail') ;
}


//if ($_GET['options']==''){ $_GET['options']='tableau';}

 echo "</tr><tr >";

  echo "<td>";
    echo "</td><td style='color:;text-transform: uppercase;'>";
  echo "( vous pouvez saisir une partie du nom du groupe pour filtrer la liste )";
echo "</td>";
echo "</tr><tr ><td colspan=3>";
 echo "</tr><tr >";
  echo "</td><td>";
  echo "<b class='red'>et un mode d'affichage</b>";
echo afficheradiosubmit('','options',$listeopt,$_GET['options'],'tableau complet');

echo "</td><td align=right>";

//plus besoin les popups et radiobutton sont autosubmit
//echo"     <input type ='submit' name='bouton_ok'  value='OK'> <br> "  ;
// on le laisse en hidden pour le test ci dessous
echo "<input type=hidden name='bouton_ok'  value='OK'> ";
echo "</form>";
echo "</table>";
} //fin du cas pour impression
//                                                             fin du form


if  ($_GET['bouton_ok']=="OK"  ){
echo "</td><td>";
echo "</table>";
//gestion du cas vide
if ($_GET['code_etu_recherche']=='vide') {  $_GET['code_etu_recherche']='';}
//fabrication du select qui va bien en fonction des parametres passés au script
if   ($_GET['orderby']==""){
  $orderby="ORDER BY nom,`prénom 1`";
}
else{
   $orderby=urldecode($_GET['orderby']);
#ça c'est pour les espaces ds les noms de colonnes
$orderby="`".$orderby.  "`";
  $orderby="ORDER BY ".$orderby;
                  if  ($_GET['inverse']=="1"){
                  $orderby=$orderby."desc";
                  }
  }
$annee=urldecode($_GET['annee']);
$code_groupe=urldecode($_GET['code_groupe']);
$code_groupe_peda=urldecode($_GET['code_groupe_peda']);
// a cause des apostrophes ds certains champs apogee pour la chaine sql
$code_filtre=urldecode(str_replace("'","''",$_GET['code_etu_recherche']));
$champ_filtre=urldecode($_GET['mon_champ']);
$recherche_avance= urldecode($_GET['recherche_avance']);
$nom_recherche= urldecode(str_replace("'","''",$_GET['nom_recherche']));
$options= urldecode($_GET['options']);
$filtre ="&mon_champ=".urlencode($champ_filtre)."&code_etu_recherche=".urlencode($_GET['code_etu_recherche'])."&annee=".urlencode($annee)."&code_groupe_peda=".urlencode($code_groupe_peda)."&recherche_avance=".urlencode($recherche_avance)."&nom_recherche=".urlencode($_GET['nom_recherche'])."&options=".urlencode($options);
// si  on a indiqué un nom et qu'on est pas en recherche avancée
if ($_GET['nom_recherche'] !='' and $_GET['recherche_avance'] !='oui' ){
$champ_filtre='nom';
$code_filtre=urldecode(str_replace("'","''",$_GET['nom_recherche']));
if ($code_filtre==''){
$where=" WHERE `".$champ_filtre."` = '' or `".$champ_filtre."` is  NULL";
}
else{
$where=" WHERE `".$champ_filtre."` like '".$code_filtre."%'";
}

$sqlquery="SELECT `Code étape` as filiere, annuaire.`mail effectif`,annuaire.`uid`,etudiants.* ,etudiants_scol.* , departs.*,etudiants_accueil.acc_annee,etudiants_accueil.acc_semestre FROM etudiants
left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code
left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.acc_code_etu
left outer join departs on upper(etudiants.`Code etu`)=departs.code_etudiant".$where." group by `Code etu` " .$orderby.";";
}
//si on a pas touché aux selections de gpe ou d'annee on prend les conditions de recheche avancée ou simple
if (($_GET['annee'] =='TOUS' and $_GET['code_groupe_peda'] =='TOUS' ) ){
//si on est pas en recherche avancée
if   ( $champ_filtre =='' ) {
// on filtre sur le nom
$champ_filtre='nom';
// si il y a un nom
	if ($code_filtre!='')
		{
		$where=" WHERE `nom` like '".$code_filtre."%'";
		}
	else
	// on ne renvoie rien car liste complète  trop longue
	{
		$where=" WHERE 0 ";
	}
}else //on est en recherche avancee
{
//on traite le cas code filtre vide
if ($code_filtre==''){
$where=" WHERE `".$champ_filtre."` = '' or `".$champ_filtre."` is  NULL";
}else{
$where=" WHERE `".$champ_filtre."` like '".$code_filtre."%'";
}
}
//$where .= " and 	( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui')";
$sqlquery="SELECT `Code étape` as filiere, annuaire.`mail effectif`,annuaire.uid,etudiants.* ,etudiants_scol.*,departs.*,departs.semestre AS semestre_dep,etudiants_accueil.acc_annee,etudiants_accueil.acc_semestre FROM etudiants
left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code
left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.acc_code_etu
left outer join departs on upper(etudiants.`Code etu`)=departs.code_etudiant".$where." group by `Code etu` " .$orderby.";";
 }
 //on a fait une selection de groupe ou d'annee
 else{
		//si on est en plus  en recherche avancee
		if ($_GET['recherche_avance'] =='oui'){
		//il faut combiner les 2 criteres
		// on traite le cas code filtre  vide
if ($code_filtre==''){
$where=" ( `".$champ_filtre."` = '' or `".$champ_filtre."` is  NULL)";
}else{
$where=" ( `".$champ_filtre."` like '".$code_filtre."%')";
}
		$sqlquery="SELECT `Code étape` as filiere, annuaire.`mail effectif`,annuaire.`uid`,etudiants.*,groupes.*,ligne_groupe.* ,etudiants_scol.*, departs.*,departs.semestre AS semestre_dep,etudiants_accueil.acc_annee,etudiants_accueil.acc_semestre
               FROM ligne_groupe left outer join
                      etudiants ON ligne_groupe.code_etudiant = etudiants.`Code etu` left outer join
                      groupes ON ligne_groupe.code_groupe = groupes.code
                      left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
                      left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.`code`
					  left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.acc_code_etu					  
					  left outer join departs on upper(etudiants.`Code etu`)=departs.code_etudiant" ;
                      $sqlquery.= " where ligne_groupe.code_groupe= '".$code_groupe_peda."' and 	( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui') and  ".$where." group by `Code etu` ". $orderby.";" ;
		}
		else {
		//on a fait une selection de groupe
		if ($_GET['code_groupe_peda'] !='TOUS' and $_GET['nom_recherche']=='' ){
		//et 'on a pas indiqué de nom et on est pas en recherche avancee
		$sqlquery="SELECT `Code étape` as filiere, annuaire.`mail effectif`,annuaire.uid,etudiants.*,groupes.*,ligne_groupe.* ,etudiants_scol.*,departs.*,departs.semestre AS semestre_dep,etudiants_accueil.acc_annee,etudiants_accueil.acc_semestre
               FROM ligne_groupe left outer join
                      etudiants ON ligne_groupe.code_etudiant = etudiants.`Code etu` left outer join
                      groupes ON ligne_groupe.code_groupe = groupes.code
                      left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
                      left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code
					  left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.acc_code_etu
					  left outer join departs on upper(etudiants.`Code etu`)=departs.code_etudiant" ;

                      $sqlquery.= " where ligne_groupe.code_groupe= '".$code_groupe_peda."' and 	( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui')"." group by `Code etu` ".$orderby.";" ;}
		//on a fait une selection d'annee
		if ($_GET['annee'] !='TOUS' ){
                    $sqlquery="SELECT `Code étape` as filiere,annuaire.`mail effectif`,annuaire.uid,etudiants.* ,etudiants_scol.* ,departs.*,departs.semestre AS semestre_dep,etudiants_accueil.acc_annee,etudiants_accueil.acc_semestre FROM etudiants
                    left outer join annuaire on upper(etudiants.`Code etu`)=annuaire.`code-etu`
                    left outer join etudiants_scol on upper(etudiants.`Code etu`)=etudiants_scol.code
					left outer join etudiants_accueil on upper(etudiants.`Code etu`)=etudiants_accueil.acc_code_etu
					left outer join departs on upper(etudiants.`Code etu`)=departs.code_etudiant";
                      $sqlquery.= " where etudiants_scol.annee= '".$annee."'  group by `Code etu` ".$orderby.";" ;}
			}
	}
//$sqlquery="SELECT *  FROM etudiants  ".$where.$orderby.";";
//echo $sqlquery."<br>";

$resultat=mysql_query($sqlquery,$connexion );
$nb_champs = mysql_num_rows($resultat);
//traçage de l'entete du  tableau
//si on est ds impression on affiche le logo :NE SERT PLUS
if ($_GET['impression'] =='oui'){
//echo "<img src=".$chemin_images."logo.gif  width=110  height=$haut>";
echo "<img src=".$chemin_images."logo.gif width=300 >";
 }
if ( $_GET['code_groupe_peda']!='TOUS'  and $_GET['nom_recherche']=='' and $_GET['code_groupe_peda']!=''){
//echo "<center><h2>Année ".$_GET['annee'].": <b>$nb_champs</b> élèves<br></h2></center> <hr>";

if ($groupe_titre_special[$_GET['code_groupe_peda']] =='oui')
{
$gpetitre=$groupe_titre_affiche[$_GET['code_groupe_peda']]." : ".$nb_champs." élèves";
}
else
{
$gpetitre="".$groupe_libelle[$_GET['code_groupe_peda']].": $nb_champs élèves";
}

	if ( $_GET['code_groupe_peda'] !='' ) {
		
			$code_groupe_peda = $_GET['code_groupe_peda'] ; 
	$sqlquery_code_groupe_peda="select * from groupes where code = $code_groupe_peda";

    $sqlquery_code_groupe_peda_resultat=mysql_query($sqlquery_code_groupe_peda,$connexion );
    while ($v=mysql_fetch_array($sqlquery_code_groupe_peda_resultat))
    {
			$fetch_list_diffusion  = $v['nom_liste'] ; 
    }
		if ( $fetch_list_diffusion != '') 
		echo "<br><center style='margin-top:-13px;font-weight:bold'> liste de diffusion :  $fetch_list_diffusion</center>" ; 
	}
	
	//on sauve le titre sans ade
	$gpetitresansade=$gpetitre;
// pour afficher le lien vers ADE
	 //nombres de semaine depuis le debut du projet  ADE
	$numsemaine=diffdate($date_debut_projetADE);
	// depuis 2018 attention on peut changer d'année ADE en année n-1
	if($numsemaine<=0)$numsemaine=0;
if ($groupe_code_ade[$_GET['code_groupe_peda']]!='' or $groupe_code_ade6[$_GET['code_groupe_peda']]!=''){


	 if ($groupe_code_ade6[$_GET['code_groupe_peda']]!='' ){
	 //nombres de semaine depuis le debut du projet  ADE
//$numsemaine=diffdate($date_debut_projetADE);
	$code_groupe_peda = $_GET['code_groupe_peda'] ; 
	$sqlquery_code_groupe_peda="select * from groupes where code = $code_groupe_peda";

    $sqlquery_code_groupe_peda_resultat=mysql_query($sqlquery_code_groupe_peda,$connexion );
    while ($v=mysql_fetch_array($sqlquery_code_groupe_peda_resultat))
    {
			$fetch_list_diffusion  = $v['nom_liste'] ; 
    }

 	$gpetitre.="<br><a style='color:yellow;font-size:14px;' href='".$lien_ade_pers."&weeks=".$numsemaine."&days=0,1,2,3,4,&name=".$groupe_code_ade6[$_GET['code_groupe_peda']]."' target=_blank  target=_blank > Emploi du temps sur ADE </a>.";
	 }
}
	 // est ce que c'est un groupe avec un lien direct ADE
	 elseif ($groupe_url_direct[$_GET['code_groupe_peda']]!='')
	 {
	 	$gpetitre.="<br><a href='".$groupe_url_direct[$_GET['code_groupe_peda']]."' target=_blank > Emploi du temps</a> ";
	 }
}
else{
//cas de recherche par nom
if ($_GET['nom_recherche'] !=''){
$gpetitre = $nb_champs." élève(s) correspond(ent) à votre requête :  $champ_filtre commence par $code_filtre ";
	$gpetitresansade=$gpetitre;
}
//cas de tous
elseif($_GET['code_groupe_peda']=='TOUS'){
$gpetitre = "Faites un choix ci dessus";
//$gpetitre = " liste complète : ".$nb_champs." élève(s)";
	$gpetitresansade=$gpetitre;
}
}
//cas de recherche avancee
if($_GET['recherche_avance']=='oui'){

if ($_GET['code_groupe_peda']!='TOUS'){$libgperech_avance="ET groupe égal à ".$groupe_libelle[$_GET['code_groupe_peda']];}
else{$libgperech_avance='';}
if (in_array($champ_filtre,$liste_champs_dates_courts)) {
$code_filtre_affiche=mysql_datetime($code_filtre);
}else {$code_filtre_affiche=$code_filtre;}
if ($code_filtre==''){$code_filtre_affiche='vide';}
$gpetitre = "<center><b>".$nb_champs."</b> élève(s) correspond(ent) à votre requête : <br><b> $champ_filtre est égal à $code_filtre_affiche ".$libgperech_avance."</b><br></center>";
}

echo "<center><h2 class='titrePage'>".RemoveAccents2($gpetitre)."</h2></center>";

//while(mysql_fetch_row($resultat)){
//$csv_output .= mysql_result($resultat,"nom").";".mysql_result($resultat,1)."\n";
//}

//_____________________________________________________________________________________________________________________________
//}//fin du if impression
if   ($nb_champs >0){
//presentation trombi
if ($_GET['options']=='trombinoscope'){
	$url=$self."?".$filtre."&bouton_ok=OK&impression=oui";
	if ($_GET['impression'] !='oui')  {
	//echo "<a href='#' onclick=\"window.open('$url','nom','location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=1,width=800,height=600')\">version imprimable</a> ";
	//echo "<br>";
	//$filtrepdf=$filtre."&format=A4";
	// on ne produit les pdf que pour les groupes
	echo "<center>";
	if ( $_GET['code_groupe_peda']!='TOUS' ){
	echo "<a class='abs' href='#' onclick=\"window.open('pdf.php?".$filtre."&format=A4"."','nom','location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=1,width=800,height=600')\">Imprimer le Trombinoscope en PDF A4 </a> ou ";
	echo "<a class='abs' href='#' onclick=\"window.open('pdf.php?".$filtre."&format=A3"."','nom','location=0, directories=0, status=0, scrollbars=1, resizable=1, copyhistory=0, menuBar=1,width=800,height=600')\">A3</a> ";
	}
	}


	echo"<table ><tr>";
    $total =mysql_num_rows($resultat) ; $i=1 ;
	while($e=mysql_fetch_object($resultat)){

        $percent =ceil($i/$total*100)."%"  ;
        // Javascript for updating the progress bar and information
        echo '<script> 
          document.getElementById("progress").innerHTML="<div class=\"progress-bar blue stripes\" style=\"width:'.$percent.';background-color:#dc3545;\">&nbsp;</div>";
          // document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
          </script>';

        // This is for the buffer achieve the minimum size in order to flush data
        echo str_repeat(' ',1024*64);

        // Send output to browser immediately
        flush();

        // Sleep one second so we can see the delay
        usleep(10000);

        $i++ ;



	if ($j%4 == 0 )
	{echo "</tr><tr>";}
	$j++;
	echo "<td align=center>";

	$photo=$chemin_images.$e->$mycode_etu.".jpg";
	$photo_perso=$chemin_images_perso.$e->$mycode_etu.".jpg";
	$photolocal =$chemin_local_images.$e->$mycode_etu.".jpg";
	$photolocal_perso =$chemin_local_images_perso.$e->$mycode_etu.".jpg";
	echo "<a class='abs' href=fiche.php?code=".$e->$mycode_etu.$filtre. " > ";
	//on regarde d'abord ds le rep upload pour la photo téléchargée
	  if (file_exists($photolocal_perso))
	{
		list($largeur,$hauteur,$type,$attribut) = getimagesize($photolocal_perso);
		$haut=($hauteur/$largeur)*106 ;
		  echo "<img src=".$photo_perso." border=0 max-width=100  height=$haut><br>";

	}
	 elseif (file_exists($photolocal))
	{
	list($largeur,$hauteur,$type,$attribut) = getimagesize($photolocal);
	$haut=($hauteur/$largeur)*106 ;

		  echo "<img src=".$photo." border=0 max-width=100  height=$haut><br>";
	}
	// sinon dans unicampus
	elseif (image_unicampus($e->$mycode_etu)['status']=='200')
	{
	   //print "<i>photo non disponible </i><br><img src=".$chemin_images."default.jpg ><br>";
	   echo "<img src=\"".image_unicampus($e->$mycode_etu)['dataimg']."\" alt=\"photo_unicampus\" max-width=100 ><br>";
	}
	else{
	   print "<img src=".$chemin_images."default.png  style='height: 300px ; width: 240px;'><br>";
	}
	print $e->Nom." ".$e->$myprenom_1." <br>";
	echo"</a></td>";
	}

	echo "</table></center>";
}//fin du if presentation trombi

elseif ($_GET['options']=='liste mail'){

	$listeoffi='vide';
	$listemail='';
	$listemai3='';
	$listemail2='';
	$i=0;
	echo"<table class='table1'>";
	
	echo "<thead align='left' style='display: table-header-group'>";
		echo "<tr>";
		echo "<th>Mail </th>" ; 
		echo "</tr>" ; 
	echo "</thead>" ; 
	
	while($e=mysql_fetch_object($resultat)){
	 if ( $e->$mymail_effectif !=''){
	 $i++;
	$listemail.=  $e->$mymail_effectif.",<br>";
	$listemail2.=  $e->$mymail_effectif.",";
	$listemail3.=  $e->$mymail_effectif."\n";
	
	    echo "<tr>";
			echo "<td>".$e->$mymail_effectif."</td>" ;
		echo "</tr>";
	
				  }
	}
	

	//echo "<td>liste à copier<br><textarea name='listeacopier' rows=10 cols=60>".$listemail."</textarea></td> ";
	if ($_GET['annee']!='TOUS' ){
	switch ($annee){
	case '1A':
	$listeoffi="pro09.officiel@ensgi.inpg.fr";
	break;
	case '2A':
	$listeoffi="pro08.officiel@ensgi.inpg.fr";
	break;
	case '3A':
	$listeoffi="pro07.officiel@ensgi.inpg.fr";
	break;
	case '4A':
	$listeoffi="4Apro07.officiel@ensgi.inpg.fr";
	break;
	case 'stagiaire international':
	$listeoffi="echanges2006.officiel@ensgi.inpg.fr";
	break;
	case 'Master Recherche':
	$listeoffi="master2007.officiel@ensgi.inpg.fr";
	break;
	default:
	$listeoffi='vide';
	break;
	}
	if($listeoffi!='vide'and $_GET['nom_recherche'] ==''){
	echo "<center><a href=mailto:$listeoffi>envoyer un mail aux $i élèves de la promotion ".$_GET['annee']."</a>" ;
	}else{
	echo "<center>il n'y a pas de liste de diffusion pour cette catégorie" ;
	}
	}
	if ($_GET['code_groupe_peda'] !='TOUS'){
	#switch (($groupe_libelle[$_GET['code_groupe_peda']])){
	#case '1A promo complète':
	#$listeoffi="pro10.officiel@ensgi.inpg.fr";
	#break;
	#case '2A promo complète':
	#$listeoffi="pro09.officiel@ensgi.inpg.fr";
	#break;
	#case '3A promo complète sauf 4A/césure':
	#$listeoffi="pro08.officiel@ensgi.inpg.fr";
	#break;
	#case '4A':
	#$listeoffi="4Apro08.officiel@ensgi.inpg.fr";
	#break;
	#case 'Stagiaires internationaux':
	#$listeoffi="echanges2007.officiel@ensgi.inpg.fr";
	#break;
	#case 'Master Recherche':
	#$listeoffi="master2008.officiel@ensgi.inpg.fr";
	#break;
	#case 'TOUS LES ELEVES GI':
	#$listeoffi="elevesgi.officiel@ensgi.inpg.fr";
	#break;
	#case '3A présents au S5 GI':
	#$listeoffi="pro08gis5.admin@ensgi.inpg.fr";
	#break;
	#case '3A promo complète (compris 4A/césure)':
	#$listeoffi="pro084acesure.admin@ensgi.inpg.fr";
	#break;
	#default:
	#$listeoffi='vide';
	#break;
	#}//fin du switch

	if ($groupe_liste[$_GET['code_groupe_peda']] =='oui'){
	$listeoffi=$groupe_nomliste[$_GET['code_groupe_peda']];
	} else
	{
	$listeoffi='vide';
	}



	}//fin du if
	//$_GET['forceFormulaireMail'] permet de forcer le formulaire Mail

	if (($listeoffi=='vide') and ($nb_champs<40) and $_GET['forceFormulaireMail']!='1'){
	//si on achoisi un nom
	if( $_GET['nom_recherche']!='' ){
	echo "<center><a href=mailto:$listemail2>envoyer un mail aux $i élèves de cette sélection</a><br><br>" ;
	}
	//si on a choisi un groupe
	if( $_GET['code_groupe_peda']!='TOUS' and $_GET['nom_recherche']=='' ){
	echo "<center><a href=mailto:$listemail2>envoyer un mail aux $i élèves du groupe ".$groupe_libelle[$_GET['code_groupe_peda']]."</a><br><br>" ;
	}
	//si on est en recherche avancee
	if( $_GET['nom_recherche']=='' and $_GET['mon_champ']!=''){
	echo "<center><a href=mailto:$listemail2>envoyer un mail aux $i élèves de cette sélection avancée</a><br><br>" ;
	}
	echo " <br><b><i>ATTENTION</i></b> Pour ne pas saturer les serveurs de messagerie , n'ajoutez pas de pièce jointe de taille supérieure à 500 Ko à votre message !<br>";
	echo " <br>si le lien ci dessus ne fonctionne pas<br>copier et coller cette liste dans le champ destinataire de votre message</center><br>";
	echo $listemail;
	}

	//c'est  une liste offi ou bien il  y a plus de 20 eleves
	else{
	if ($listeoffi=='vide' or $_GET['forceFormulaireMail']=='1' ) {
	//________________________________________________________________________________________________________________________________
	// il  y a plus de 150 eleves
	if ($nb_champs >200){
	echo "<center>impossible d'envoyer un mail à ce groupe : trop grand nombre de destinataires</center>";
	}
	// si on a pas appuyé sur le bouton annulation envoi du mail juste avant
	elseif ($_GET['bouton_annul']=='')
	{
	// on recupere le bon titre pour les mails
	if ($gpetitresansade==''){
	$gpetitresansade=$gpetitre;
	  }
	 echo    "<form method=POST name=envoi_mail action=".$self."?".$filtre."   onsubmit=\"return  confirm('Confirmez l\'envoi aux élèves du groupe ".$gpetitresansade." ?')\"> ";

	  echo"       <table align=center style='width:95% ; font-family:Roboto Condensed '><tr> ";

	  //pour apres la sortie du formulaire retrouver la selection en cours
	 echo "<td>Pour ce groupe vous  pouvez seulement envoyer un mail à l'aide du formulaire ci-dessous ( trop de destinataires )</td></tr><tr> ";
	  echo afficheonly("","Texte du message qui sera envoyé aux ".$nb_champs." élève(s) du groupe ",'b' ,'h3');
	 echo "</tr><tr>";
	  // echo $filtre;
	  $email_exp= ask_ldap($login,'mail');
		$email_exp=  $email_exp[0];
	//echo $reponse[0]."<br>";
	//on met en hidden le mail de l'expediteur
	 //echo affichechamp('Expéditeur','exp_mail', $email_exp,50,1);
	 
	 echo "<td>Expéditeur<br><input type='text' size='50' name='exp_mail' id='exp_mail' value=$emailConnecte></td>" ; 
	 
	 
	 echo "</tr><tr>";
	echo affichechamp('Objet','objet_mail', '',60,'','','','','','placeholder = \'objet du message\' ');
	 echo "</tr><tr>";
	echo affichechamp('Cc','copie_conforme', '',60,'','','','','', 'placeholder = \'vous pouvez mettre plusieurs adresses en Cc , les séparer par des virgules \' ');
	 echo "</tr><tr>";
		echo "<td colspan=2>Texte du message<br><textarea name='texte' id='textareaId' rows=8 cols=80 placeholder= 'Saisissez votre message en HTML5 ici / copie/colle depuis word'></textarea></td> ";

		// on met en hidden la liste des destinataires
	  echo "<input type='hidden' name='liste_dest' value=\"".htmlspecialchars($listemail2, ENT_QUOTES, 'ISO8859-1')."\" >";
	  //echo "lalsite :".$listemail2 ;
	  // on met en hidden le nom du groupe sans ade

	  echo "<input type='hidden' name='titre_gpe' value=\"".htmlspecialchars($gpetitresansade, ENT_QUOTES, 'ISO8859-1')."\" >";


	//echo $reponse[0]."<br>";
				echo "</tr><tr>";
	  echo "</td></tr><tr><th colspan=6><input type='Submit' name='bouton_env' value='envoyer'></form>";
	  echo "<input type='Submit' name='bouton_annul' value='Annuler'>";
	  echo"</th></tr></table> "  ;


	echo "<br>";
	//echo $listemail;
	}

	}else{
	//c'est donc une liste offi sympa
	echo "<center><a href=mailto:$listeoffi>envoyer un mail aux $i élèves du groupe ".$groupe_libelle[$_GET['code_groupe_peda']]."</a><br><br>" ;
	}
	}

	echo "</table></center>";
	}

//============================================================================
else
	{
	//présentation liste
	echo "<center><table class='table1'><tr bgcolor=\"#98B5FF\" >";


	//============================================================================
	if ($_GET['options']=='liste émargement'){
		if   ($_GET['orderby']=='Code etu' && $_GET['inverse']<> 1)
		{echo"<th><a href=".$self."?orderby=".urlencode("Code etu") ."&inverse=1"."&bouton_ok=OK". $filtre.">Code etu</a></th> ";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("Code etu")."&bouton_ok=OK".$filtre.">Code etu</a></th> ";}
		if   ($_GET['orderby']=='nom' && $_GET['inverse']<> 1)
		{echo"<th><a href=".$self."?orderby=".urlencode("nom") ."&inverse=1"."&bouton_ok=OK". $filtre.">Nom</a></th> ";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("nom")."&bouton_ok=OK".$filtre.">Nom</a></th> ";}
		if  ($_GET['orderby']=='prénom 1' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("prénom 1")."&inverse=1"."&bouton_ok=OK". $filtre." >Prénom</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("prénom 1")."&bouton_ok=OK".$filtre.">Prénom</a></th> ";}
		if  ($_GET['orderby']=='cursus_specifique' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("cursus_specifique")."&inverse=1"."&bouton_ok=OK". $filtre." >cursus spécifique</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("cursus_specifique")."&bouton_ok=OK".$filtre.">cursus spécifique</a></th> ";}
		echo "<th>Signature</th> ";
	}
	else
	{
		echo "<th></th> ";
		if   ($_GET['orderby']=='nom' && $_GET['inverse']<> 1)
		{echo"<th><a href=".$self."?orderby=".urlencode("nom") ."&inverse=1"."&bouton_ok=OK". $filtre.">Nom</a></th> ";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("nom")."&bouton_ok=OK".$filtre.">Nom</a></th> ";}
		if  ($_GET['orderby']=='prénom 1' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("prénom 1")."&inverse=1"."&bouton_ok=OK". $filtre." >Prénom</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("prénom 1")."&bouton_ok=OK".$filtre.">Prénom</a></th> ";}
		if  ($_GET['orderby']=='annee' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("annee")."&inverse=1"."&bouton_ok=OK". $filtre .">Groupe principal</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("annee")."&bouton_ok=OK".$filtre.">Groupe <br>principal</a></th> ";}
		if  ($_GET['orderby']=='filiere' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("filiere")."&inverse=1"."&bouton_ok=OK". $filtre .">Filière</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("filiere")."&bouton_ok=OK".$filtre.">Filière</a></th> ";}

		if ($_GET['options']!='tableau complet'){
			echo "<th>Echanges</th> ";
		 }
		if ($_GET['options']=='tableau court' or $_GET['options']=='export totalité'){
			echo "<th>Adresse mail</th> ";
		}
	}
	// si on a choisi tableau complet il faut mettre d'autres champs ici
	if ($_GET['options']=='tableau complet'){
		//echo "<th>Adm sur<br> titre</th> ";

		if  ($_GET['orderby']=='admis_sur_titre' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("admis_sur_titre")."&inverse=1"."&bouton_ok=OK". $filtre .">Adm sur<br> titre</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("admis_sur_titre")."&bouton_ok=OK".$filtre.">Adm sur<br> titre</a></th> ";}
		if  ($_GET['orderby']=='redoublant' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("redoublant")."&inverse=1"."&bouton_ok=OK". $filtre .">Redou<br>-blant</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("redoublant")."&bouton_ok=OK".$filtre.">Redou<br>-blant</a></th> ";}

		echo "<th>Echanges</th> ";
		if  ($_GET['orderby']=='cursus_specifique' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("cursus_specifique")."&inverse=1"."&bouton_ok=OK". $filtre .">Cursus spécifique</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("cursus_specifique")."&bouton_ok=OK".$filtre.">Cursus spécifique</a></th> ";}

		echo "<th>Adresse mail</th> ";
	}
	// si on a choisi tableau badges il faut mettre d'autres champs ici
	if ($_GET['options']=='liste badges'){

		if  ($_GET['orderby']=='num_badge' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("num_badge")."&inverse=1"."&bouton_ok=OK". $filtre .">numero</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("num_badge")."&bouton_ok=OK".$filtre.">numero</a></th> ";}
		if  ($_GET['orderby']=='date_remise_badge' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("date_remise_badge")."&inverse=1"."&bouton_ok=OK". $filtre .">date remise</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("date_remise_badge")."&bouton_ok=OK".$filtre.">date remise</a></th> ";}
		if  ($_GET['orderby']=='caution_badge' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("caution_badge")."&inverse=1"."&bouton_ok=OK". $filtre .">caution</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("caution_badge")."&bouton_ok=OK".$filtre.">caution</a></th> ";}
		if  ($_GET['orderby']=='date_retour_badge' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("date_retour_badge")."&inverse=1"."&bouton_ok=OK". $filtre .">date retour</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("date_retour_badge")."&bouton_ok=OK".$filtre.">date retour</a></th> ";}
		if  ($_GET['orderby']=='badge_perdu' && $_GET['inverse']<> 1)
		{echo "<th><a href=".$self."?orderby=".urlencode("badge_perdu")."&inverse=1"."&bouton_ok=OK". $filtre .">badge perdu</a></th>";}
		else
		{echo "<th><a href=".$self."?orderby=".urlencode("badge_perdu")."&bouton_ok=OK".$filtre.">badge perdu</a></th> ";}
		echo "<th>Adresse mail</th> ";
	}
	if ($_GET['options']=='export insc cours'){
		echo "<th>ECTS</th> ";
		}


	echo "</tr>";
	$index=0;
	//pour l'export CSV
	//on ecrit d'abord les  noms des colonnes
	//Premiere ligne = nom des champs (si on en a besoin)
	//on initialise  $csv_output
	 $csv_output="";
	 $csv_output2="";

	$csv_output = $gpetitresansade."\n\n";
	if ($_GET['options']=='export totalité'){
		 //pour l'export en totalité au cas ou
		for($i=0;$i<sizeof($champs);$i++) {
		$csv_output .= $champs[$i].";";
		}
		$csv_output .= "Groupe principal;Filière;Admis sur titre;Redoublant;Echanges;Cursus spécifique;libellé nationalité";
	}
	if ($_GET['options']=='tableau complet'){
		$csv_output .= "N°étudiant;Nom;Prénom;Groupe principal;Filière;Admis sur titre;Redoublant;Echanges;Cursus spécifique;Adresse e-mail;";
		// if($login == 'administrateur'){
		 $csv_output .="login";
	 //}
	}
	if ($_GET['options']=='tableau court'){
		$csv_output .= "N°étudiant;Nom;Prénom;Groupe principal;Filière;Echanges;Adresse e-mail";
	}
	if ($_GET['options']=='liste badges'){
		$csv_output .= "N°étudiant;Nom;Prénom;Groupe principal;Filière;Echanges;Date demande;Numéro;Date remise;Caution;Date retour;Badge perdu;Adresse e-mail";
	}
	if ($_GET['options']=='liste émargement'){
		$csv_output .= "Date : ;\n";
		$csv_output .= "Horaire : ;\n";
		$csv_output .= "N°étudiant;Nom;Prénom;signature";
	}
	if ($_GET['options']=='export insc cours'){
		$csv_output .= "N°étudiant;Nom;Prénom;Groupe principal;Filière;Total_ects;code_ue et libelle;semestre;credit_ects";
		$csv_output2 .= "N°étudiant;Nom;Prénom;Groupe principal;Filière;code_ue et libelle;semestre;credit_ects";
	}
	$csv_output .= "\n";
	$csv_output2 .= "\n";

    $total =mysql_num_rows($resultat) ; $i=1 ;
	while($f=mysql_fetch_object($resultat)){


        $percent =ceil($i/$total*100)."%"  ;
        // Javascript for updating the progress bar and information
        echo '<script> 
  document.getElementById("progress").innerHTML="<div class=\"progress-bar blue stripes\" style=\"width:'.$percent.';background-color:#dc3545;\">&nbsp;</div>";
  // document.getElementById("information").innerHTML="'.$i.' row(s) processed.";
  </script>';

        // This is for the buffer achieve the minimum size in order to flush data
        echo str_repeat(' ',1024*64);

        // Send output to browser immediately
        flush();

        // Sleep one second so we can see the delay
        usleep(10000);

        $i++ ;

	if (strtolower($f->admis_sur_titre)!='non'){
	$admisurtitrecsv=$f->admis_sur_titre;}
	else{$admisurtitrecsv="-";}
	if (strtolower($f->redoublant)!='non'){
	$redoublantcsv=$f->redoublant;}
	else{$redoublantcsv="-";}
	$echangescsv=$f->semestre_dep;
	if ($f->dd=='oui') {
	$echangescsv.="(DD)";}
	if ($f->master=='oui')
	{
	$echangescsv.="(Master)";}
	if (strtolower($f->accueil_echange)!='non'){
	$echangescsv.=$f->accueil_echange;
	}
	// pour enlever les parenthèses qui marquent les gpes principaux obsolètes
	// si annee commence par '(' et finit par ') ' on enleve le 1er et le dernier caractere
	if(substr($f->annee,0,1)=='(' and substr($f->annee,-1)==')')
	{
	$anneecsv=substr($f->annee,1);
	$anneecsv=substr($anneecsv,0,-1);
	}
	else
	{
	$anneecsv	=$f->annee;
	}

	if ($_GET['options']=='export totalité'){
	//pour l'export en totalite
	for($i=0;$i<sizeof($champs);$i++) {
			//echo $champs[$i] ."<br>";
		$csv_output .= nettoiecsv($f->{$champs[$i]});
		}
		$csv_output .= $anneecsv.";".$f->filiere.";". $admisurtitrecsv.";".$redoublantcsv.";".$echangescsv.";".$f->cursus_specifique.";".$libelleDep[$f->$mynationalite].";";
	}

	if ($_GET['options']=='tableau complet'){
		$csv_output .= $f->$mycode_etu.";".$f->Nom.";".ucfirst(strtolower($f->$myprenom_1)).";".$anneecsv.";".$f->filiere.";".$admisurtitrecsv.";".$redoublantcsv.";".$echangescsv.";".$f->cursus_specifique.";".$f->$mymail_effectif.";";
		 //if($login == 'administrateur'){
		 $csv_output .=$f->uid;
	 //}
	}
	if ($_GET['options']=='tableau court'){
	$csv_output .= $f->$mycode_etu.";".$f->Nom.";".ucfirst(strtolower($f->$myprenom_1)).";".$anneecsv.";".$f->filiere.";".$echangescsv.";".$f->$mymail_effectif.";";
	}
	if ($_GET['options']=='liste badges'){
	$csv_output .= $f->$mycode_etu.";".$f->Nom.";".ucfirst(strtolower($f->$myprenom_1)).";".$anneecsv.";".$f->filiere.";".$echangescsv.";".mysql_datetime($f->date_demande_badge).";".$f->num_badge.";".mysql_datetime($f->date_remise_badge).";".$f->caution_badge.";".mysql_datetime($f->date_retour_badge).";".$f->badge_perdu.";".$f->$mymail_effectif.";";
	}
	if ($_GET['options']=='liste émargement'){
	$csv_output .= $f->$mycode_etu.";".$f->Nom.";".ucfirst(strtolower($f->$myprenom_1)).";";
	}

if ($_GET['options']=='export insc cours'){
	$csv_output .= $f->$mycode_etu.";".$f->Nom.";".ucfirst(strtolower($f->$myprenom_1)).";".$anneecsv.";".$f->filiere.";";

		//il faut récupérer les cours où il est inscrit
				$queryplus="select distinct 
		etudiants.`Nom`,etudiants.`Prénom 1`,annee as gpe_principal, cours.CODE,cours.LIBELLE_LONG,CREDIT_ECTS,cours.semestre 
		from ligne_groupe
		left outer join etudiants on ligne_groupe.code_etudiant=etudiants.`Code etu`
		left outer join etudiants_scol on etudiants_scol.code=etudiants.`Code etu`
		left outer join groupes on groupes.code=ligne_groupe.code_groupe
		left join cours on cours.CODE=left(code_ade6,8)

		 where archive !='oui' and 	( ligne_groupe.exempte is NULL or  ligne_groupe.exempte !='oui') and type_gpe_auto='edt'
		and etudiants.`Code etu`='".$f->$mycode_etu."' order by semestre";



		$resultatplus=mysql_query($queryplus,$connexion );
		//$csv_output.=nettoiecsv($f->$mycode_etu);
		//$csv_output.=nettoiecsv($f->Nom);
		$totects=0;
		$csv_outputtemp='';

		while($b=mysql_fetch_object($resultatplus))
			{
			$totects+=	$b->CREDIT_ECTS;
			$csv_outputtemp.=nettoiecsv($b->CODE.'-'.$b->LIBELLE_LONG);
			//à cause du separateur decimal dans excel
			$csv_outputtemp.=nettoiecsv(str_replace(".",",",$b->semestre));
			$csv_outputtemp.=nettoiecsv(str_replace(".",",",$b->CREDIT_ECTS));
			//var_dump($csv_output);die();
			$csv_output2 .= $f->$mycode_etu.";".$f->Nom.";".ucfirst(strtolower($f->$myprenom_1)).";".$anneecsv.";".$f->filiere.";";
			$csv_output2.=nettoiecsv($b->CODE.'-'.$b->LIBELLE_LONG);
			$csv_output2.=nettoiecsv(str_replace(".",",",$b->semestre));
			$csv_output2.=nettoiecsv(str_replace(".",",",$b->CREDIT_ECTS));
			$csv_output2 .= "\n";
			}

		$csv_output.=nettoiecsv(str_replace(".",",",$totects));
		$csv_output.=$csv_outputtemp;
	}

	//exporte le login en plus
	//$csv_output .= mysql_result($resultat,"admis_sur_titre").";".mysql_result($resultat,"Code etu").";".mysql_result($resultat,2).";";
	//if ($_GET['code_groupe_peda']!="TOUS"){
	//$groupe_libelle_export=$groupe_libelle[$_GET['code_groupe_peda']];}
	//else{
	//$groupe_libelle_export='';}
	//$csv_output .= mysql_result($resultat,"admis_sur_titre").";".mysql_result($resultat,"Code etu").";".$groupe_libelle_export.";".mysql_result($resultat,"cursus_specifique").";".mysql_result($resultat,1).";";
	$csv_output .= "\n";

	// on récupère les absences pour chaque etudiants
	$bgcolor='';
	$queryabs="select * from absences where code_etud ='".$f->$mycode_etu."'";
	$resultatabs=mysql_query($queryabs,$connexion );
	// on vérifie si il y a une absence en cours
	$bgcolor='';
	$messsurvol='';
	while ($ab=mysql_fetch_object($resultatabs))
	{
	// absence active
	if($ab->date_debut<= date('Y-m-d 00:00:00') and $ab->date_fin>= date('Y-m-d 00:00:00') )
	{$bgcolor=' orange ';
	$messsurvol= " absent du ".mysql_DateTime($ab->date_debut)." au ".mysql_DateTime($ab->date_fin);
	}

	}
	echo "<tr bgcolor='".$bgcolor."' title='".$messsurvol."'>" ;


	/* On parcourt les résultats de la requête */
	//et on trace le corps du tableau
	$nom = $f->Nom;
	$prenom_1 = ucfirst(strtolower($f->$myprenom_1));
	$code_etu = $f->$mycode_etu;
	//$lib_etape = mysql_result($resultat,"Lib étape");
	$cod_etape = $f->$mycode_etape;
	//$annee_dip = mysql_result($resultat,"Nb inscr dip");
	//$annee_etp = mysql_result($resultat,"Nb inscr etp");
	$lib_etape=$f->annee;
	$mail =   $f->$mymail_effectif;
	//$code_etu=substr($code_etu,0,8) ;
	$index=$index+1 ;

	if ($_GET['options']=='liste émargement'){
		echo"<td> $code_etu</td>" ;
		echo"<td> $nom</td>" ;
		echo "<td> $prenom_1</td> ";
		echo "<td> ".$f->cursus_specifique."</td>";
		echo "<td> </td>";
	}
	else
	{
		echo "<td>";
		// on verifie si c'est un etudiant qui a été anonymise
		if(substr($f->$mycommentaire,0,9)!='nettoyage'){
		echo"<a class='abs' target='_blank' href=fiche.php?code=".$code_etu.$filtre."><i class='fas fa-arrow-alt-circle-right' style='font-size:24px;color:'></i></a>";
		}
		echo"</td> ";
        echo"<td><a target='_blank' href=fiche.php?code=".$code_etu.$filtre.">$nom</a></td>";
		echo "<td> $prenom_1</td> ";
		//echo"<td> $cod_etape</td>";
		//echo"<td> $annee_dip</td><td> $annee_etp</td> ";
		echo "<td> $lib_etape</td>";
		echo "<td> ".$f->filiere."</td>";
		if ($_GET['options']!='tableau complet'){
		$echanges=$f->semestre_dep;
		if ($f->dd=='oui') {
		$echanges.="(DD)";}
		if ($f->master=='oui')
		{
		$echanges.="(Master)";}
		if (strtolower($f->accueil_echange)!='non'){
		$echanges.=$f->accueil_echange;
		}
		if ($f->acc_semestre!=''){
		$echanges=$f->acc_annee." ".$f->acc_semestre;
		}
		echo "<td> ".$echanges."</td>";
		}
	}
	if ($_GET['options']=='tableau complet' ){
			if (strtolower($f->admis_sur_titre)!='non'){
			echo "<td> ".$f->admis_sur_titre."</td>";}
			else{echo "<td>-</td>";}
			if (strtolower($f->redoublant)!='non'){
			echo "<td> ".$f->redoublant."</td>";}
			else{echo "<td>-</td>";}
			$echanges=$f->semestre_dep;
			if ($f->dd=='oui') {
			$echanges.="(DD)";}
			if ($f->master=='oui')
			{
			$echanges.="(Master)";}
			if (strtolower($f->accueil_echange)!='non'){
			$echanges.=$f->accueil_echange;
			}
			if ($f->acc_semestre!=''){
			$echanges=$f->acc_annee." ".$f->acc_semestre;
			}
			echo "<td> ".$echanges."</td>";
			echo "<td> ".$f->cursus_specifique."</td>";
			echo "<td><a href=mailto:$mail> $mail </a></td>";
	}
	if ($_GET['options']=='liste badges'){
		//echo "<td> ".mysql_datetime($f->date_demande_badge)."</td>";
		echo "<td> ".$f->num_badge."</td>";
		echo "<td> ".mysql_datetime($f->date_remise_badge)."</td>";
		echo "<td> ".$f->caution_badge."</td>";
		echo "<td> ".mysql_datetime($f->date_retour_badge)."</td>";
		echo "<td> ".$f->badge_perdu."</td>";
		echo "<td><a href=mailto:$mail> $mail </a></td>";
	}
	if ($_GET['options']=='export insc cours'){
		//echo "<td> ".mysql_datetime($f->date_demande_badge)."</td>";
		echo "<td> ".$totects."</td>";
	}
	if ($_GET['options']=='tableau court' or $_GET['options']=='export totalité'){
			echo "<td><a href=mailto:$mail> $mail </a></td>";
		}

	echo "</tr>";
	}


	 if ($_GET['options']=='export insc cours'){

		 	echo  "<FORM  action=export.php method=POST name='form_export'> ";
	 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  value='EXPORT des inscriptions aux cours avec ects'> <br> "  ;
		echo "</form>";
		echo  "<FORM  action=export.php method=POST name='form_export2'> ";
		 echo "<input type=hidden name=csv_output value='".urlencode($csv_output2)."'> ";
		echo"     <input type ='submit' name='bouton_export2'  value='EXPORT des inscriptions aux cours avec ects pour tableau croisé'> <br> "  ;
	 }
		elseif ($_GET['options']=='export totalité'){
				echo  "<FORM  action=export.php method=POST name='form_export'> ";
	 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  value='EXPORT de toutes les informations administratives vers EXCEL'> <br> "  ;
	 }else{
	 	echo  "<FORM  action=export.php method=POST name='form_export'> ";
	 echo "<input type=hidden name=csv_output value='".urlencode($csv_output)."'> ";
		echo"     <input type ='submit' name='bouton_export'  value='EXPORT vers EXCEL' class='bouton_ok'> <br> "  ;
			}
	echo "</form>";
	echo"</table>";

}



} //fin du if nb>0
}  //fin du if bouton ok
if ($_POST['bouton_env']=='envoyer'){
	//test
	//$_POST['liste_dest']='marc.patouillard@grenoble-inp.fr';
	// fin test
$_POST['texte']=stripslashes($_POST['texte']);
$_POST['titre_gpe']=stripslashes($_POST['titre_gpe']);
$_POST['objet_mail']=stripslashes($_POST['objet_mail']);
// on met aussi l'expediteur en liste destinataire
$_POST['liste_dest'].=$_POST['exp_mail'].",";
// on met aussi les CC en liste destinataire
$_POST['liste_dest'].=$_POST['copie_conforme'].",";
$_POST['liste_dest'].=$sigiadminmail.",";
$_POST['texte']=" Ci dessous un message envoyé par ".$_POST['exp_mail']." à partir de la base élèves de GI\n destinataires :".$_POST['titre_gpe']." \n".$_POST['texte'];
$headers = 'From: base_eleves_gi<noreply@grenoble-inp.fr>' . "\n";
$headers .='Reply-To: '.$_POST['exp_mail']."\n";
$headers .='Bcc: '.$_POST['liste_dest']."\n";
$headers .='Cc: '.$_POST['copie_conforme']."\n";
$headers .= 'Content-Type: text/html; charset="iso-8859-1"' . "\n";
$headers .= 'Content-Transfer-Encoding: 8bit';
$headers .=  "Message-ID: ".time().rand()."@grenoble-inp.fr". "\n";
	//test
	//$_POST['texte'] .=$headers;
	// fin test
if (mail('',$_POST['objet_mail'],$_POST['texte'],$headers))
{

echo "<br><center>l'envoi du mail ayant pour objet : <br><b> ".$_POST['objet_mail'] ."</b><br> pour le groupe <br><b>".$_POST['titre_gpe']."</b><br>  a bien été effectué<br>";
}
else
{
echo "<br><center>Le message n'a pu être envoyé</center></h2>";
echo "<br>headers :".$headers;
}
echo "<br><a href=".$self."><b>CONTINUER</b> </a></center></h2>";
}


mysql_close($connexion);

echo "<br><div><a class='titrePage' style='margin-left:5px;' href=infos_legales.html>Informations Légales </a></div>";



$counter = count(file('./../etud-auth/counter.txt')) ;
$header  = "IP                           TimeSTAMP             Agalan" ;
$content = "" ;

$handle = fopen('./../etud-auth/counter.txt' , "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $content = $content . $line . "<br/>" ;
    }

    fclose($handle);
}

if ($cachePool->hasItem('cmp_cours'))
{
    $cmp_cours = $cachePool->getItem('cmp_cours')->get() ;
}else{
    $cmp_cours = 0 ;
}

if ($cachePool->hasItem('cmp_enseignants'))
{
    $cmp_enseignants = $cachePool->getItem('cmp_enseignants')->get() ;
}else{
    $cmp_enseignants = 0 ;
}

if ($cachePool->hasItem('count_abs_3_cache_'))
{
    $count_abs_3_cache = $cachePool->getItem('count_abs_3_cache_')->get() ;
}else{
    $count_abs_3_cache = 0 ;
}



$array = unserialize($count_abs_3_cache) ;
$msg = "";
foreach ( $array as $item) {
    $msg .= $item . "<br/>" ;
}



?>



<script>

	        function clickNotification () {
				    console.log('redirect to attente');
					location.href = "https://web.gi.grenoble-inp.fr/eleves/absences/absences_gest.php?clone=&from=&tout=&del=&env_orderby=&env_inverse=&Nom_rech=tous&annee_rech=tous&code_etud_rech=tous&absences_statuts_texte_rech=tous&mot_cle_rech=tous&Nom_rech=tous&annee_rech=tous&code_etud_rech=tous&mot_cle_rech=tous&absences_statuts_texte_rech=en+attente";
			};


	        var counter1 = 0;
			var factor1 = 1;
			var damping1 = 80;
			var minVal1 = 0.1;
			var moreInfore1 = "<a href='/eleves/default.php?nom_recherche=&recherche_avance=non&annee=TOUS&regexp=&code_groupe_peda=4483&options=tableau+complet&bouton_ok=OK' /><i class='far fa-arrow-alt-circle-right' style='font-size:24px;'></i></a>" ;


			if (document.getElementById('websiteavis1') !=null) {

						var timer1 = setInterval(function () {
							document.getElementById("websiteavis1").innerHTML = '&#128113; '+ Math.ceil(counter1) + ' Etudiant(s)'     ;
							counter1 = counter1 + factor1;
							var Max1 = 0;
												Max1 = <?php echo json_encode($count1_);?> ;
												console.log("totale " + Max1 );

											if (counter1 > 40 && counter1 < Max1 ) {
								factor1 = Math.max((Max1 - counter1)/damping1, minVal1) * 5 ;
							} else if (counter1 > Max1 ) {
								clearInterval(timer1);
							}


							 if ( counter1 > Max1 ) {
								counter1-- ;
								document.getElementById("websiteavis1").innerHTML = '&#128113; '+ Math.ceil(counter1) + ' Etudiant(s)'  + "<br/><a class='notification' href='/eleves/default.php?nom_recherche=&recherche_avance=non&annee=TOUS&regexp=&code_groupe_peda=4483&options=tableau+complet&bouton_ok=OK' /> <i class='far fa-arrow-alt-circle-right' style='font-size:24px;'></i> <span class='badge'><?php echo $count_prov;?></span>   <span class='tooltiptext3'> &#10060; <spane style='background-color: red ; padding : 3px ; color : white ; border-radius: 3px; '> ETUDIANT(S) STATUS PROV  </spane><br/><br/><hr> " + "<?php echo $prov_message; ?>"  + " <br/>  </span> </a>" ;
								 document.getElementById("websiteavis1").classList.add('tooltip3') ;
							 }

						}, 0.01);				
				
			}


			 var counter2 = 0;
			var factor2 = 1;
			var damping2 = 80;
			var minVal2 = 0.1;
			var moreInfore1 = '' ;
			
			if (document.getElementById('websiteavis2') !=null) {
			
					var timer2 = setInterval(function () {
						document.getElementById("websiteavis2").innerHTML = '&#x1F474; ' + Math.ceil(counter2) + ' Enseignant(s)'  ;
						counter2 = counter2 + factor2;
						var Max2 = 0;
						var cmp_enseignants = 0  ;
						Max2 = <?php echo json_encode($count2_);?> ;
						var cmp_enseignants =<?php echo json_encode($cmp_enseignants);?> ;
										if (counter2 > 40 && counter2 < Max2 ) {
							factor2 = Math.max((Max2 - counter2)/damping2, minVal2) * 5 ;
						} else if (counter2 > Max2 ) {
							clearInterval(timer2);
						}

						if ( counter2 > Max2 ) {
							counter2-- ;
							document.getElementById("websiteavis2").innerHTML = '&#x1F474; ' + Math.ceil(counter2) + ' Enseignant(s)'  + "<br/><a class='notification' href='/eleves/enseignants.php' /> <i class='far fa-arrow-alt-circle-right' style='font-size:24px;'></i><span class='badge4' title=  'Attention : " +cmp_enseignants+" Enseignant(s) en activité mais quils sont pas dans l`annuaire triode.' > " + (cmp_enseignants>0 ? cmp_enseignants:'') + "</span> </a>" ;

						}

					}, 0.01);			
			}
			


			 var counter3 = 0;
			var factor3 = 1;
			var damping3 = 80;
			var minVal3 = 0.1;
			var cmp = <?php echo json_encode($cmp_cours);?> ;
			var timer3 = setInterval(function () {
				document.getElementById("websiteavis3").innerHTML = '&#x1F4D2; ' + Math.ceil(counter3) + ' Cours(s)'  ;
				counter3 = counter3 + factor3;
				var Max3 = 0;
									Max3 = <?php echo json_encode($count3_);?> ;

								if (counter3 > 20 && counter3 < Max3) {
					factor3 = Math.max((Max3 - counter3)/damping3, minVal3) * 5 ;
				} else if (counter3 > Max3 ) {
					clearInterval(timer3);
				}


				if ( counter3 > Max3 ) {
					counter3-- ;
					document.getElementById("websiteavis3").innerHTML = '&#x1F4D2; ' + Math.ceil(counter3) + ' Cours(s)'  + "<br/><a class='notification' href='/eleves/listecours.php' /> <span class='badge3' title= '" + cmp + " Nouveau(x) cours pour 2023'> " + cmp + " </span>  <i class='far fa-arrow-alt-circle-right' style='font-size:24px;'></i></a>" ;
				}

			}, 0.01);



			 var counter4 = 0;
			var factor4 = 1;
			var damping4 = 80;
			var minVal4 = 0.1;
			var enAttente = <?php echo json_encode($count5_);?> ;
			var timer4 = setInterval(function () {
				document.getElementById("websiteavis4").innerHTML = '&#x1F4C8; ' + Math.ceil(counter4) + ' Absent(s)'  ;
				counter4 = counter4 + factor4;
				var Max4 = 0;
				Max4 =  <?php echo json_encode( $count4_  );?> ;

				if (counter4 > 20 && counter4 < Max4) {
					factor4 = Math.max((Max4 - counter4)/damping4, minVal4) * 5 ;
				} else if (counter4 > Max4 ) {
					clearInterval(timer4);
				}

				if ( counter4 > Max4 ) {
					counter4-- ;
					document.getElementById("websiteavis4").innerHTML = '&#x1F4C8; ' + Math.ceil(counter4) + ' Absent(s)'   + "<br/><a class='notification' href='/eleves/absences/absences_gest.php' />  <span class='badge2' title= '" + enAttente + " Absence(s) En Attente de Validation par DE'> " + enAttente + " </span> <i class='far fa-arrow-alt-circle-right' style='font-size:24px;'></i> <span class='tooltiptext'> &#10060; ATTENTION <br/><br/><hr> - " +" Absence(s) à valider :  " + enAttente + " <br/>  </span></a>" ;
                    document.getElementById("websiteavis4").classList.add('tooltip') ;

                }

			}, 0.01);



			var counter5 = 0;
			var factor5 = 1;
			var damping5 = 80;
			var minVal5 = 0.1;
			document.getElementById("loader").remove();
			var timer5 = setInterval(function () {
				document.getElementById("websiteavis5").innerHTML = '&#x1F4FA; ' + Math.ceil(counter5) + ' En ligne(s)'  ;
				counter5 = counter5 + factor5;
				var Max5 = 0;
									Max5 = <?php echo json_encode($counter);   ?> ;
									content = <?php echo json_encode($content); ?> ;

								if (counter5 > 20 && counter5 < Max5) {
					factor5 = Math.max((Max5 - counter5)/damping5, minVal5) * 5 ;
				} else if (counter5 > Max5 ) {
					clearInterval(timer5);
				}


				if ( counter5 > Max5 ) {
					counter5-- ;

					document.getElementById("websiteavis5").innerHTML = '&#x1F4FA; ' + Math.ceil(counter5) + ' En ligne(s)'  + "<br/><a href='#' /> <i class='fas fa-info-circle' style='font-size:24px;color:#e3e3e3'></i>  <span class='tooltiptext2'> &nbsp;&nbsp; &#10071; <spane style='background-color: #056522 ; padding : 3px ; color : white ; border-radius: 3px; '> ETUDIANT(S) EN LIGNE(S) </spane><br/><br/><hr>" + content  + " </span> </a>" ;
                    document.getElementById("websiteavis5").classList.add('tooltip2') ;
                }

			}, 0.01);




</script>


    <script>

        var percent2 =<?php echo $total__ ;?>

            window.onload=function(){
                var data = {
                    labels:   <?php echo $label;?> ,
                    datasets: [
                        {
                            data:   <?php echo $data;?> ,
                            backgroundColor: [
                                "#FF6283",
                                "#36A2EB",
                                "#FFCC54" ,
                                'rgb(247, 70, 74)',
                                'rgb(51, 143, 82)',
                                'rgb(141,106,17)',
                                'rgb(103,163,213)',
                                'rgb(220,5,30)',
                                'rgb(181,252,203)',
                                'rgb(248,185,97)',
                                'rgb(143,136,136)',
                                'rgb(87,197,89)',
                                'rgb(5,81,129)',
                                "#FF6283",
                                "#36A2EB",
                                "#FFCC54" ,
                                'rgb(247, 70, 74)',
                                'rgb(51, 143, 82)',
                                'rgb(141,106,17)',
                                'rgb(103,163,213)',
                                'rgb(220,5,30)',
                                'rgb(5,81,129)',
                                'rgb(248,185,97)',
                                'rgb(143,136,136)',
                                'rgb(54,168,56)'
                            ],
                            hoverBackgroundColor: [
                                "#FF6283",
                                "#36A2EB",
                                "#FFCC54"
                            ]
                        }]
                };
				Chart.defaults.global.animation.duration = 0;
                var promisedDeliveryChart = new Chart(document.getElementById('myChart'), {
                    type: 'horizontalBar',
                    data: data,
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Répartition de nos '+percent2 + ' étudiant(s)'
                        },
						scales: {
							xAxes: [{
								ticks: {
									display: false , 
									beginAtZero: true,
									
								},gridLines: {
                display:false,drawBorder: false
            },
										}],
										  yAxes: [
							  {
								  ticks: {
									  beginAtZero: true
									  
								  },
								  gridLines: {
                display:false,
				drawBorder: false
            },
							  }
						  ]
						
						}
						
                    }
                });
				
                var promisedDeliveryChart = new Chart(document.getElementById('myChart2'), {
                    type: 'doughnut',
                    data: data,
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },

                    }
                });

                Chart.pluginService.register({
                    beforeDraw: function(chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;
                        ctx.restore();
                        var fontSize = (height / 180).toFixed(2) ;
                        ctx.font = fontSize + "em helvetica";
						ctx.fillStyle = 'black';
						
                        ctx.textBaseline = "middle";
                        var text =  percent2+ ' étudiant(s)' ,
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2 + 3 ;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                });
            }


		

    </script>





<script>


$(document).ready(function () {
    $("#delCookie").click(function(){
        // del_cookie("cookie");   
    });
	
	var messageDispatcher = "<p style='color:gray ; font-size:13px;text-align: justify;text-justify: inter-word;margin-top:-2px'>Pour renforcer la sécurité de nos applications, l'option de la double authentification 2FA est appliquée, pour la désactiver il suffit de cliquer sur la case à cocher 'OTP' , elle sera renouveler de nouveau tout les 15 jours. <br> Merci de votre compréhension</p>" ; 
    
    console.log(document.cookie);
    var visit = getCookie("cookie");
	visit = "NO POPUP" ; 
    if (visit == null) {

           Swal.fire({
                    icon: "info",
                    title: "SERVICE GI-DEV<hr>" ,
                    html: messageDispatcher,
                    footer: '<a href="#">MESSAGE AUTOMATIQUE</a>'
                });
				
        var expire = new Date();
        expire = new Date(expire.getTime() + 360000000 );
		console.log("expiration"+expire) ; 
        document.cookie = "cookie=here; expires=" + expire;
    }
});

function del_cookie(name)
{
    document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

function getCookie(c_name) {
    var c_value = document.cookie;
    var c_start = c_value.indexOf(" " + c_name + "=");
    if (c_start == -1) {
        c_start = c_value.indexOf(c_name + "=");
    }
    if (c_start == -1) {
        c_value = null;
    } else {
        c_start = c_value.indexOf("=", c_start) + 1;
        var c_end = c_value.indexOf(";", c_start);
        if (c_end == -1) {
            c_end = c_value.length;
        }
        c_value = unescape(c_value.substring(c_start, c_end));
    }
    return c_value;
}


    var _smartsupp = _smartsupp || {};
    _smartsupp.key = 'cfecada6c12875f8181288f8365311c621651f7a';
    window.smartsupp||(function(d) {
        var s,c,o=smartsupp=function(){ o._.push(arguments)};o._=[];
        s=d.getElementsByTagName('script')[0];c=d.createElement('script');
        c.type='text/javascript';c.charset='utf-8';c.async=true;
        c.src='https://www.smartsuppchat.com/loader.js?';s.parentNode.insertBefore(c,s);
    })(document);


 tinymce.init({
        selector: 'textarea#textareaId',
        height: 300,
        language_url: '/cpge-demat/public/js/fr_FR.js',
        language : "fr_FR",
        menubar: true,
        content_style: "body { font-size: 12pt; font-family: Helvetica; }",
        toolbar: "undo redo | styleselect | fontselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent",
        branding: false,
        help_accessibility: false,
        statusbar: false
    });


    $("#textareaId").keypress(function (e) {
        if(e.which === 13 && !e.shiftKey) {
            e.preventDefault();

            $(this).closest("form").submit();
        }
    });

</script>




    <?php
//require ("otp.php");

require ("footer.php");
echo "</body>";
echo "</html>";
?> 


