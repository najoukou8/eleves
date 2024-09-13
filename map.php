<!DOCTYPE html>
<html>
<head>
<?php

require ("param.php");
require ("function.php");
if (!isset($_GET['champ'])) $_GET['champ']='nationalité';
if (!isset($_GET['annee'])) $_GET['annee']=$annee_courante;
$types=array();
$types['nationalité']=array(
'title'=>"Répartition par nationalité ".($_GET['annee']-1)."-".$_GET['annee'],
'id_fichier'=>'nationalite',
'champ1'=>"code_abrege",
'champ2'=>"libelle_pays",
'indexjsonoutput'=>"",
'query'=>"select `code_abrege`  ,libelle_pays,count(*) as nombre from ligne_groupe 
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code= `Nationalité` 
left join pays on dep_libelle= libelle_pays
where `code_groupe`=".$code_gpe_tous_inscrits." 
group by `libelle_pays` ",
'query2'=>"select * from  pays     ",
'scriptdetail'=>"stats2",
'champdetail'=>'Nationalit%E9'
);
$types['département de naissance']=array(
'title'=>"Répartition par département de naissance ".($_GET['annee']-1)."-".$_GET['annee'],
'id_fichier'=>'naissance',
'champ1'=>"dep_code",
'champ2'=>"dep_libelle",
'indexjsonoutput'=>"department-",
'query'=>"select `dep_libelle`  ,dep_code,count(*) as nombre from ligne_groupe 
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code= if( left(`Pays/dept naiss`,1)=0 , right(`Pays/dept naiss`,2) , `Pays/dept naiss` ) 
where `code_groupe`=".$code_gpe_tous_inscrits."  and ( left(`Pays/dept naiss`,1)=0 or left(`Pays/dept naiss`,1)=9) 
group by `dep_libelle`      ",
'query2'=>"select * from  departements  where length(`dep_code`)=2    ",
'scriptdetail'=>"stats2",
'champdetail'=>'dept_naiss'
);
$types['pays des parents']=array(
'title'=>"Répartition par pays des parents (adresse fixe)",
'id_fichier'=>'nationalite',
'champ1'=>"code_abrege",
'champ2'=>"libelle_pays",
'indexjsonoutput'=>"",
'query'=>"select `code_abrege`  ,libelle_pays,count(*) as nombre from ligne_groupe 
left join etudiants on code_etudiant=`Code etu` 
left join pays on `Adf lib pays`= libelle_pays
where `code_groupe`=".$code_gpe_tous_inscrits." 
group by `libelle_pays`",
'query2'=>"select * from  pays     ",
'scriptdetail'=>"stats2",
'champdetail'=>'Adf+lib+pays'
);
$types['département du BAC']=array(
'title'=>"Répartition par département d'obtention du baccalaureat ".($_GET['annee']-1)."-".$_GET['annee'],
'id_fichier'=>'naissance',
'champ1'=>"dep_code",
'champ2'=>"dep_libelle",
'indexjsonoutput'=>"department-",
'query'=>"select `dep_libelle`  ,dep_code,count(*) as nombre from ligne_groupe 
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code= if( left(`Code dpt bac`,1)=0 , right(`Code dpt bac`,2) ,`Code dpt bac` ) 
where `code_groupe`=".$code_gpe_tous_inscrits." 
group by `dep_libelle`      ",
'query2'=>"select * from  departements  where length(`dep_code`)=2    ",
'scriptdetail'=>"stats2",
'champdetail'=>'Code+dpt+bac'
);

$types['pays départs']=array(
'title'=>"Répartition des départs par pays de destination 2007-".($_GET['annee']-1),
'id_fichier'=>'nationalite2',
'champ1'=>"code_abrege",
'champ2'=>"libelle_pays",
'indexjsonoutput'=>"",
'query'=>"SELECT `code_abrege`  ,libelle_pays,count(*) as nombre FROM departs 
	left outer join universite on  code_periode=universite.id_uni
	left outer join pays on  universite.id_pays=pays.id_pays
group by `libelle_pays` ",
'query2'=>"select * from  pays     ",
'scriptdetail'=>'departs',
'champdetail'=>'tous'
);
$types['pays départs en cours']=array(
'title'=>"Localisation des départs en cours",
'id_fichier'=>'nationalite2',
'champ1'=>"code_abrege",
'champ2'=>"libelle_pays",
'indexjsonoutput'=>"",
'query'=>"SELECT `code_abrege`  ,libelle_pays,count(*) as nombre FROM departs 
	left outer join universite on  code_periode=universite.id_uni
	left outer join pays on  universite.id_pays=pays.id_pays
	where annee_scolaire='2020-2021' and etape >= 6 
group by `libelle_pays` ",
'query2'=>"select * from  pays     ",
'scriptdetail'=>'departs',
'champdetail'=>'en_cours'
);
$types['pays accueil']=array(
'title'=>"Répartition des étudiants en accueil par pays d'origine 2008-".($_GET['annee']-1),
'id_fichier'=>'nationalite2',
'champ1'=>"code_abrege",
'champ2'=>"libelle_pays",
'indexjsonoutput'=>"",
'query'=>"SELECT `code_abrege`  ,libelle_pays,count(*) as nombre FROM etudiants_accueil 
left join universite on acc_id_uni=id_uni
left join pays on universite.id_pays=pays.id_pays
group by `libelle_pays` ",
'query2'=>"select * from  pays     ",
'scriptdetail'=>'etud_accueil',
'champdetail'=>''
);

$types['pays interculture']=array(
'title'=>"Répartition des expériences interculturelles 2016-".($_GET['annee']-1),
'id_fichier'=>'nationalite',
'champ1'=>"code_abrege",
'champ2'=>"libelle_pays",
'indexjsonoutput'=>"",
'query'=>"SELECT `code_abrege`  ,libelle_pays,count(*) as nombre FROM interculture 
	left outer join pays on  interculture.interculture_pays_id=pays.id_pays
group by `libelle_pays` ",
'query2'=>"select * from  pays     ",
'scriptdetail'=>'interculture',
'champdetail'=>''
);
$title=$types[$_GET['champ']]['title'];
$id_fichier=$types[$_GET['champ']]['id_fichier'];
$champ1=$types[$_GET['champ']]['champ1'];
$champ2=$types[$_GET['champ']]['champ2'];
$champscriptdetail=$types[$_GET['champ']]['scriptdetail'];
$champdetail=$types[$_GET['champ']]['champdetail'];
$indexjsonoutput=$types[$_GET['champ']]['indexjsonoutput'];
$query=$types[$_GET['champ']]['query'];
	// il nous faut la liste complete des codes dep
$query2=$types[$_GET['champ']]['query2'];
include ("js/jQuery-Mapael/".$id_fichier.".css");
?>
<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />
    <title><?php echo $title ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"
            charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
    <script src="js/jQuery-Mapael/jquery.mapael.js" charset="utf-8"></script>
    <script src="js/jQuery-Mapael/maps/france_departments.js" charset="utf-8"></script>
    <script src="js/jQuery-Mapael/maps/world_countries.js" charset="utf-8"></script>
<?
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
        }
    });
    return $array;
}

// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);

$result = executesql($query,$connexion);	
 $jsonoutput=[];	
$deptraite=array();
	while ($r=mysql_fetch_assoc($result))
	{
		$deptraite[]=$r[$champ1];
		//$cles=array_keys($r);
		//$s=array_combine(utf8_converter($cles),utf8_converter($r));
		$temp=$r[$champ1];
		if ($champscriptdetail=='stats2')
			$href="stats2.php?detailonly=1&champ_choisi=".$champdetail."&detail=".stripAccents($r[$champ2]);
		elseif($champscriptdetail=='departs')
			$href="departs.php?".$champdetail."=1&pays_rech=".stripAccents($r[$champ2]);
		elseif($champscriptdetail=='interculture')
			$href="interculture/index.php?&pays_rech=".stripAccents($r[$champ2]);
		elseif($champscriptdetail=='etud_accueil')
			$href="etud_accueil.php?an=tous&pays_rech=".stripAccents($r[$champ2]);
		else
			$href='#';
		$jsonoutput[$indexjsonoutput.$temp]=
		array(
		'value'=>$r['nombre'],
				'href'=>$href,
				'tooltip'=>array ('content'=> "<span style=\"font-weight:bold;\">".$r[$champ2]." (".$r[$champ1].")</span><br />nombre : ".$r['nombre'])
		);
	}
	//print_r($jsonoutput);

//echo $query;
$result = executesql($query2,$connexion);	
	
	while ($r=mysql_fetch_assoc($result))
	{
		if (!in_array($r[$champ1],$deptraite))
		{
				$temp=$r[$champ1];
				$jsonoutput[$indexjsonoutput.$temp]=
				array(
				'value'=>0,
						'href'=>'#',
						'tooltip'=>array ('content'=> "<span style=\"font-weight:bold;\">".$r[$champ2]." (".$r[$champ1].")</span><br />nombre : 0")
				);
		}	
	}

include ("js/jQuery-Mapael/".$id_fichier.".js");
?>
</head>
<body>
<div class="formulaire">
<center>
<?php
$listechamps=array_keys($types);
echo "<a href=../eleves/accueil_stats.php> retour accueil stats</a>";
// valeur par defaut si pas de paramètre passé 
echo "<form >";
//function affichemenuplus2tab ($titre,$champ,$listelib,$listeret,$selection='',$js='',$id='')
echo affichemenu('Choisissez le critère  : <br>','champ',$listechamps,$_GET['champ'],'onchange=\'submit()\'');
echo "</form>";
?>
</center>
</div>   
<div class="container">
    <h1><?php echo $title ?></h1>

    <div class="mapcontainer">
        <div class="map">
            <span>Alternative content for the map</span>
        </div>
        <div class="areaLegend">
            <span>Alternative content for the legend</span>
        </div>
    </div>   
</div>
</body>
</html>