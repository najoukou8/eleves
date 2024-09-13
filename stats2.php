<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>tableau de bord statistiques</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />

<?


require ("param.php");
require ("function.php");
require ("style.php");
// On se connecte
$connexion =Connexion ($user_sql, $password, $dsn, $host);
if(!isset($_GET['inverse']))$_GET['inverse']='';
if(!isset($_GET['tri']))$_GET['tri']='';
echo "</HEAD><BODY>" ;
echo "<center>";
echo " <a href=default.php> retour vers accueil de la Base élèves</a>";
//on vérifie si on a les droits
//if (in_array('pilotage',ask_ldap($loginConnection,'memberof')))
//	accès pour tous 
if (1)
{
		
echo "<h2> Effectifs ".($annee_courante-1)."-".$annee_courante."</h2>";




$listechamps=array();
$listechamps2=array();
$libchamps=array();
//$listechamps1=champsfromtable ('etudiants',$connexion);
$listecommentaires=champscommentfromtable ('etudiants',$connexion);
$commentLib1=champscommentfromtableplus ('etudiants',$connexion,0,'$',1);
$commentLib0=champscommentfromtableplus ('etudiants',$connexion,0,'$',0);	
$commentLib2=champscommentfromtableplus ('etudiants',$connexion,0,'$',4);
//print_r($commentLib1);

// pour générer la liste des champs 
// si rien dans commentaire on ne le garde pas 

foreach ($commentLib0  as $key => $value)
{	
	if ($value!='')
		{		
			$listechamps[]=$key;
		}
}

foreach ($listechamps  as $unchamp)
{
	$listechamps2[]=$unchamp."1";
// si rien dans commentaire on prend le nom du champ comme libellé 
	if ($commentLib0[$unchamp]=='')
	{
	$libchamps[]=$unchamp;	
	$libchampsindex[$unchamp]=$unchamp;	
	}
	else
		// sinon  on prend le commentaire  comme libellé 
	{
	$libchamps[]=$commentLib0[$unchamp];
	$libchampsindex[$unchamp]=$commentLib0[$unchamp];	
	}

}
$listechamps[]='Code dpt bac';
$listechamps2[]='Code dpt bac1';
$libchamps[]='Département du bac';
$libchampsindex['Code dpt bac']='departement du bac';
$commentLib2['Code dpt bac']='pays';

$listechamps[]='dept_naiss';
$listechamps2[]='dept_naiss1';
$libchamps[]='Département de naissance';
$libchampsindex['dept_naiss']='departement de naissance';
$commentLib2['dept_naiss']='pays';

$listechamps[]='étrangers';
$listechamps2[]='etr1';
$libchamps[]='FRANCE/ETRANGER';
$libchampsindex['étrangers']='étrangers';	
$commentLib2['étrangers']='pays';
	if(!isset($_GET['detailonly']) )
	{
echo "<br><br><br>";
$filtre='';
// valeur par defaut si pas de paramètre passé 
if(!isset($_GET['champ']))
	$_GET['champ']='Etat civ1';
	$filtre="champ=".urlencode($_GET['champ']);

if (!isset($_GET['onlygi']))
	{		
		$_GET['onlygi']='non';
		$checked ="";
	}
$filtre.="&onlygi=".urlencode($_GET['onlygi']);		
echo "<form >";
echo "<table>";
echo"<td>";
   //echo  afficheradio ('restreindre aux VETs GI','onlygi',$listeouinon,'',$_POST['onlygi'],'',' ','');
   if ($_GET['onlygi']=='oui') $checked =" checked ";
   echo 'Restreindre aux VETs GI';
   echo  "<input type='checkbox' name='onlygi' value='oui'".$checked ." onchange=submit() /><br>";
   echo"</td>";
   echo"<td>";
	//echo "<input type='Submit' name='mod' value='OK'> "; 
   echo"</td>";
 echo "</table>";  

//function affichemenuplus2tab ($titre,$champ,$listelib,$listeret,$selection='',$js='',$id='')
echo affichemenuplus2tab  ('Choisissez le critère de regroupement : <br>','champ',$libchamps,$listechamps2,$_GET['champ'],'onchange=\'submit()\'','','');
echo "</form>";
echo "<table id=t1>";
echo "<tr>";
echo "<td >";
if ($_GET['onlygi']=="non")
{
	$restriction= '';
}
else
{
$restriction= " and `Code étape` in ('".implode('\',\'',$vetsGi)."') ";
}

// tel que dans la bdd , il faut enlever le 1 final ajouté plus haut pour distinguer 2 traitements différents sur le même champ  par ex nationalité
$getchampmodif=substr($_GET['champ'],0,strlen($_GET['champ'])-1);
$regroupe1=$getchampmodif ;
$col1=$getchampmodif ;
$col_lien="`".$getchampmodif ."`";
$libcol1=$getchampmodif ;
if ($col1 != 'etr' and $commentLib2[$col1] =='pays'){
	$regroupe1='dep_libelle';
	$col1='dep_libelle';
}
$query="select `".$col1."` as '".$libcol1."',departements.dep_libelle ,count(*) as nombre  from ligne_groupe  
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code=".$col_lien." 
where `code_groupe`=".$code_gpe_tous_inscrits .$restriction.
" group by `".$regroupe1."` ";
if ($getchampmodif =='Lib étab ech'){
$query="select `".$col1."` as '".$libcol1."',departements.dep_libelle ,count(*) as nombre  from ligne_groupe  
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code=".$col_lien." 
where `code_groupe`=".$code_gpe_tous_inscrits .$restriction.
" and `".$libcol1."` !='' group by `".$regroupe1."` ";
}
if ($getchampmodif =='dept_naiss'){
	$col1='dep_libelle';
	$regroupe1='dep_libelle';
$query="select `".$col1."` as '".$libcol1."',departements.dep_libelle ,count(*) as nombre  from ligne_groupe  
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code= if( left(`Pays/dept naiss`,1)=0 , right(`Pays/dept naiss`,2)
        , `Pays/dept naiss` )
where `code_groupe`=".$code_gpe_tous_inscrits .$restriction.
" and ( left(`Pays/dept naiss`,1)=0 or left(`Pays/dept naiss`,1)=9)
group by `".$regroupe1."` ";	
}
if ($getchampmodif =='Code dpt bac'){
	$col1='dep_libelle';
	$regroupe1='dep_libelle';
$query="select `".$col1."` as '".$libcol1."',departements.dep_libelle ,count(*) as nombre  from ligne_groupe  
left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code= if( left(`Code dpt bac`,1)=0 , right(`Code dpt bac`,2)
        , `Code dpt bac` )
where `code_groupe`=".$code_gpe_tous_inscrits.$restriction.
" and ( left(`Code dpt bac`,1)=0 or left(`Code dpt bac`,1)=9)
group by `".$regroupe1."` ";	
}
if ($getchampmodif =='etr'){
	//$getchampmodif='Nationalité';
		$libcol1='Nationalité FR/ETR';
	$col1=$libcol1;
	$regroupe1=$libcol1;
$query="select 
CASE
when `dep_libelle` != 'FRANCE' THEN 'ETRANGER'
ELSE 'FRANCE' 
END as '".$libcol1."',departements.dep_libelle , count(*) as nombre 
from ligne_groupe left join etudiants on code_etudiant=`Code etu` 
left join departements on dep_code=Nationalité where `code_groupe`=".$code_gpe_tous_inscrits .$restriction.
" group by `".$regroupe1."` ";	
//echo $query;
}
if ($getchampmodif =='Date naiss'){
	$expsql="   YEAR(CURDATE()) - YEAR(MAKEDATE (cast(concat(if ( right(`Date naiss`,2) >= '00' AND  right(`Date naiss`,2) <'40','20','19'), right(`Date naiss`,2) ) as UNSIGNED ),1))  ";
	$regroupe1=' right(`Date naiss`,2) ';
	$libcol1='age';
	$col1=$libcol1;
$query="select ".$expsql." as '".$libcol1."' ,count(*) as nombre  from ligne_groupe  
left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`=".$code_gpe_tous_inscrits .$restriction.
" 
group by ".$regroupe1." ";	
}



//echo $query;
$total=0;
$x=0;
$xdouble=0;
$dataPoints=array();
$resultats=array();
$resultatsdouble=array();
$translit=array(''=>'non renseigné','4G-STG'=>'Erasmus accueil');
$result = executesql($query,$connexion);
	// on calcule le total pour les pourcentages
	while ($x=mysql_fetch_object($result))
	{
				$total+=$x->nombre;				
	}
$result = executesql($query,$connexion);
echo "<table id=t2 border=1 >";	
	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_object($result))
	{		
		$x=$x+1;				
		$resultats[]=array('ind'=>$x,'champ'=>$r->$col1,'libelle'=>$r->$libcol1,'nombre'=>$r->nombre,'pourcent'=>round($r->nombre/$total*100,2));
		//$dataPoints[]=array("x"=> $x, "y"=> $r->nombre ,"indexLabel"=>$r->code_etape);
	}		
	// on génère les entetes	
	//echo afficheentete2020('code VET','code','tri','inverse','','');
	echo afficheentete2020($libcol1,'libelle','tri','inverse',$filtre,'');
	echo afficheentete2020('effectif','nombre','tri','inverse',$filtre,'');	
	echo afficheentete2020('%','pourcent','tri','inverse',$filtre,'');		
if (isset($_GET['tri']) && $_GET['tri'] !='' )	
	{
				if (isset($_GET['inverse']) and $_GET['inverse']==1 )
				{
					$resultats=array_sort($resultats,$_GET['tri'],SORT_DESC);

				}
				else
					{
					$resultats=array_sort($resultats,$_GET['tri'],SORT_ASC);

				}
	}
	$totfrance=0;
foreach($resultats as $ligne)
	{
		$dataPoints[]=array("x"=> $ligne['ind'], "y"=> $ligne['nombre'],"label"=>utf8_encode($ligne['libelle']) ,"indexLabel"=>utf8_encode($ligne['libelle']));
		echo "<tr>";
		echo "<td>";
		// on vérifie avant de l'afficher si on a une translitération pour le nom de la VET
		if (array_key_exists($ligne['libelle'],$translit))
		echo $ligne['libelle'].'->'.'<i>'.$translit[$ligne['libelle']].'</i>';
		else
		echo $ligne['libelle'];	
		echo "</td><td align=right>";
		if ($getchampmodif!='etr' and $getchampmodif!='Lib CSP parent' and $getchampmodif!='Lib_handi' and $getchampmodif!='Lib sit fam' and $getchampmodif!='Lib aide finan')
		echo "<a href=?champ_choisi=".urlencode($getchampmodif)."&detail=".urlencode($ligne['libelle'])."&champ=".urlencode($_GET['champ']).">".$ligne['nombre']."</a>";	
		else
		echo $ligne['nombre'];				
		echo "</td><td align=right>";		
		echo  $ligne['pourcent'];			
		echo "</td></tr>";		
	}
		echo "<tr bgcolor='lightgreen'>";
		echo "<td>";
		echo "Total";
		echo "</td><td align=right>";		
		echo "<b>$total</b>";	
		echo "</td></tr>";
		echo "</table id=t2>";
//print_r($dataPoints);
?>
<script>

window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light3", // "light1", "light2", "dark1", "dark2"
	title:{
		text: ""
	},
		legend: {
		fontSize: 12
	},
	data: [{
		type: "pie", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		//showInLegend: false,
			//	legendText: "{label}",
			//	toolTipContent: "<b>{label}</b>: {y}",
		indexLabelFontSize: 13,
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "inside",   
		dataPoints: <?php echo json_encode($dataPoints); ?>
	}]
});
chart.render();
 
}
</script>
</td>
<td  >

<div id="chartContainer" style="height: 450px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</td>
</tr>
<?
echo "</td>";
echo "</table id=1>";

	} // fin du if !isset( $_GET['detailonly'])
if (isset($_GET['detail']))
{	
$prefixe='';
$libellecriterepourtableau=$libchampsindex[$_GET['champ_choisi']];
	echo "<br>";
// on double quote dans le $_GET['detail']
$detail=str_replace("'","''",stripslashes($_GET['detail']));
if ($_GET['champ_choisi']=='dept_naiss') {
if( $_GET['detail']!='Réunion' and $_GET['detail']!='Nouvelle Calédonie'){
	$prefixe='0';
}
	$_GET['champ_choisi']='Pays/dept naiss';
}
if ($_GET['champ_choisi']=='Code dpt bac') {
if( $_GET['detail']!='Réunion' and $_GET['detail']!='Nouvelle Calédonie'){
	$prefixe='0';
}
	$_GET['champ_choisi']='Code dpt bac';
}


$champ_choisi=str_replace("'","''",stripslashes($_GET['champ_choisi']));
// si on récupère dep_libelle
//if($champ_choisi !='dep_libelle')
if($commentLib2[$champ_choisi] =='pays')
{
	// il faut retrouver le code du pays 
		//
 $sqlquery2="SELECT dep_code FROM `departements` where dep_libelle ='".$detail."'";
$resultat2=mysql_query($sqlquery2,$connexion ); 
		while ($v=mysql_fetch_array($resultat2)){
		$codepays=$prefixe.$v['dep_code'];
		}	
$query="select etudiants.`Code etu` as code_etu ,  etudiants.`Nom` as nom_etu ,  etudiants.`Lib étape` as lib_vet  from ligne_groupe  left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`='".$code_gpe_tous_inscrits . "' and etudiants.`".$champ_choisi."`='".$codepays."'";
}
	elseif ($commentLib2[$champ_choisi] =='age')
{
	$query="select etudiants.`Code etu` as code_etu ,  etudiants.`Nom` as nom_etu ,  etudiants.`Lib étape` as lib_vet  from ligne_groupe  left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`='".$code_gpe_tous_inscrits . "' and cast(concat (if ( right(`Date naiss`,2) ='00','20','19'),right(`".$champ_choisi."`,2)) as UNSIGNED)= YEAR(CURDATE())-".$detail."";
//YEAR(CURDATE()) - YEAR(MAKEDATE (cast(concat(if ( right(`Date naiss`,2) ='00','20','19'), right(`Date naiss`,2) ) as UNSIGNED ),1)) 
}


	else
{
	$query="select etudiants.`Code etu` as code_etu ,  etudiants.`Nom` as nom_etu ,  etudiants.`Lib étape` as lib_vet  from ligne_groupe  left join etudiants on code_etudiant=`Code etu` 
where `code_groupe`='".$code_gpe_tous_inscrits . "' and etudiants.`".$champ_choisi."`='".$detail."'";
}

	$result = executesql($query,$connexion);
	//echo $query;
$nbresult=mysql_num_rows($result);
	echo "<h2>Détail des $nbresult élèves pour critère  ".$libellecriterepourtableau." = ".$detail. ":</h2>";
	echo "<table border=1 >";
	echo "<th>code etu</th><th>nom</th><th>VET</th>";		
	// on remplit un tableau avec les résultats
	while ($r=mysql_fetch_object($result))
	{
echo "<tr>";
echo "<td>";
echo "<a href=fiche.php?code=".$r->code_etu.">".$r->code_etu."</a>";
echo"</td>";
echo "<td>";
echo $r->nom_etu;
echo"</td>";
echo "<td>";
echo $r->lib_vet;
echo "</tr>";
	}	
	}

}else // fin de verif on a le droit
{
	echo affichealerte( 'Vous ne disposez pas des droits nécessaires pour accéder à cette page',0);
}
?>

</body>
</html>